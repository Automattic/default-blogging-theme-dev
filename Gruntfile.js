module.exports = function( grunt ) {
	'use strict';
	
	grunt.initConfig({
		sass: {
			build: {
				options: {
					require: 'susy',
					sourcemap: 'none',
					includePaths: require( 'node-bourbon' ).includePaths
				},
				files: [ {"style.css":"style.scss","rtl.css":"rtl.scss"} ]
			}
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