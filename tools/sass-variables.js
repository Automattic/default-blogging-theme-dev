/* sass-variables.js */

const { basename, dirname } = require( 'path' );
const { existsSync, readFileSync } = require( 'fs' );

const IGNORE_IMPORTS=[ "bourbon" ];

const VAR_PREFIX="x-";

const VAR_PREFIX_REGEX = new RegExp( `^\\$${VAR_PREFIX}` );

const VAR_INTERPOLATION_REGEX = new RegExp( `#\\s*{\s*\\$${VAR_PREFIX}([a-z0-9-_]+)\s*}`, 'g' );

class SassVariablesCLI {

	constructor() {
		const args = process.argv.slice(2);
		if ( 1 == args.length ) {
			const file = args[0];
			this.check( file );
			this.run( file );
		} else {
			this.usage();
		}
	}

	check( file ) {
		if ( ! existsSync( file ) ) {
			console.log( 'File does not exist: %s', file );
			process.exit( 1 );
		}
	}

	run( file ) {
		const buf = readFileSync( file, 'utf8' ).trim();
		const sass = new SassImportsResolver( buf ).toString();
		const processed = new SassVariableResolver( sass ).toString();
	}
	
	usage() {
		console.log( 'Usage: %s <sass-file>', basename( __filename ) );
		process.exit( 1 );
	}
	
}

class SassImportsResolver {
	
	constructor( buf, path='' ) {
		const self = this;
		this.buffer = buf.trim().split( "\n" ).map( line => {
			return self.processLine( line, path );
		} ).join( "\n" ) + "\n";
	}
	
	toString() {
		return this.buffer;
	}
	
	isIgnoredImport( target ) {
		return IGNORE_IMPORTS.indexOf( target ) >= 0;
	}
	
	processLine( line, path ) {
		const matches = line.match( /^\s*@import\s*['"]([^'"]+)['"]\s*;/ );
		if ( matches ) {
			let file, target = matches[1];
			if ( '' !== path ) {
				target = `${path}/${target}`;
			}
			if ( ! this.isIgnoredImport( target ) ) {
				if ( target.indexOf( '/' ) >= 0 ) {
					const parts = target.split( '/' );
					const last = parts.pop();
					file = `${ parts.join( '/' ) }/_${ last }.scss`;
				} else {
					file = `_${ target }.scss`
				}
				if ( existsSync( file ) ) {
					const path = dirname( file ).replace( /^\.$/, '' );
					const buf = readFileSync( file, 'utf8' );
					const sass = new SassImportsResolver( buf, path );
					return sass.toString();
				} else {
					throw new Error( `Bad Import: ${ line }` );
				}
			}
		}
		return line;
	}
	
}

class SassVariableResolver {
	
	constructor( buf ) {
		let sass = buf;
		const spec = this.getVariables( buf );
		const root = this.renderRoot( spec );
		sass = this.addMediaQueryVariables( sass, spec );
		sass = this.addFallbacks( sass, spec );
		console.log( `${root}\n${sass}` );
	}
	
	addMediaQueryVariables( buf, spec ) {
		const self = this;
		return buf.replace( /\(\s*([a-z0-9-]+)\s*:\s*([^\)]+)\s*\)/g, (match, prop, val ) => {
			val = self.replaceInterpolatedVariables( val );
			val = self.replaceRawVariables( val, spec );
			return `(${prop}: ${val})`;
		} );
	}
	
	addFallbacks( buf, spec ) {
		let self = this;
		return this.addPropertyFallbacks( buf, spec, x => {
			x = self.replaceInterpolatedVariables(x);
			x = self.replaceRawVariables(x, spec);
			return x;
		} );
	}
	
	replaceRawVariables( val, spec ) {
		const self = this, keys = Object.keys( spec ).sort( (a, b) => a.length - b.length ).reverse(); // Sort by string length.
		return keys.reduce( ( str, k ) => {
			const v = self.sassToCSSVar( k );
			while ( str.indexOf( k ) >= 0 ) {
				str = str.replace( k, `var(${v})` );
			}
			return str;
		}, val );
	}
	
	addPropertyFallbacks( buf, spec, filter ) {
		const self = this;
		return buf.replace( /(;|{|\s*)(:|::)?(\$)?([a-z0-9-]+)\s*:\s*(.+)(\s*)(;?|})/g, (match, before='', colon='', varPrefix='', property, value, whiteSpace='', end ) => {
			if ( '$' === varPrefix ) {
				return match;
			} else {
				const filteredValue = filter( value, spec );
				if ( filteredValue !== value ) {
					const filteredMatch = match.replace( /^(;|{)\s*/, '' ).replace( /(;?|})/, '' ).replace( /;\s*$/, '' ).trimRight() + ';';
					const matchEndWs = /;\s*$/.test(match) ? (match.split( ';' ).pop() || '' ) : '';
					const repl = `${before}${filteredMatch}${matchEndWs}${before.replace(/[^\s]+/,'')}${colon}${varPrefix}${property}: ${filteredValue}${whiteSpace}${end}`;
					return repl;
				} else {
					return match;
				}
			}
		} );
	}

	renderRoot( spec ) {
		const self = this;
		const root = Object.keys( spec ).reduce( ( acc, key ) => {
		const prop = self.sassToCSSVar( key );
		const val = self.replaceInterpolatedVariables( spec[ key ] );
			acc.push( `  ${prop}: ${val};` );
			return acc;
		}, []).join( "\n" );
		return `::root {\n${root}\n}`;
	}
	
	sassToCSSVar( x ) {
		return x.replace( VAR_PREFIX_REGEX, '--' );
	}

	replaceInterpolatedVariables( buf ) {
		return buf.replace( VAR_INTERPOLATION_REGEX, 'var(--$1)' );
	}

	getVariables( buf ) {
		const prefix = `$${VAR_PREFIX}`;
		return buf.match( /(\$[a-z0-9_-]+)\s*:\s*([^;]+);/g ).filter( line => {
			return 0 === line.indexOf( prefix );
		} ).reduce( ( ob, line ) => {
			const [ prop, value ] = line.replace( /\s*;$/, '' ).split( /\s*:\s*/ );
			ob[ prop ] = value;
			return ob;
		}, {});
	}
	
}

new SassVariablesCLI;