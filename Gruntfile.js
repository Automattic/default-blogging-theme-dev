
const { existsSync } = require( 'fs' );

const sassBuildFiles = {
	'style.css': 'style.scss',
	'rtl.css': "rtl.scss",
}

if ( existsSync( 'vars-build.scss' ) ) {
	sassBuildFiles[ 'vars-build.css' ] = 'vars-build.scss';
}

module.exports = function( grunt ) {
	'use strict';
	
	grunt.initConfig({
		sass: {
			build: {
				options: {
					outputStyle: 'expanded',
					require: 'susy',
					sourcemap: 'none',
					includePaths: require( 'node-bourbon' ).includePaths
				},
				files: [ sassBuildFiles ]
			},
		},
		watch: {
			sass: {
				files: ["stylesheets/inc/*.scss","stylesheets/*.scss","*.scss"],
				tasks: [
					'sass'
				]
			},
		}
	});
	
	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.registerTask( 'default', [
		'build',
		'watch',
	]);

	grunt.registerTask( 'css', [
		'sass',
	] );

	grunt.registerTask( 'build', [
		'css',
	]);
	
};