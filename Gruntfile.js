module.exports = function(grunt) {

// Load multiple grunt tasks using globbing patterns
require('load-grunt-tasks')(grunt);

// Project configuration.
grunt.initConfig({
	pkg: grunt.file.readJSON('package.json'),

		makepot: {
			target: {
				options: {
					domainPath: '/languages',    // Where to save the POT file.
					exclude: ['build/.*'],
					potFilename: 'toivo.pot',    // Name of the POT file.
					potHeaders: {
						poedit: true,                 // Includes common Poedit headers.
						'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
								},
					type: 'wp-theme',    // Type of project (wp-plugin or wp-theme).
					updateTimestamp: true,    // Whether the POT-Creation-Date should be updated without other changes.
					updatePoFiles: true, // Whether to update PO files in the same directory as the POT file.
					processPot: function( pot, options ) {
						pot.headers['report-msgid-bugs-to'] = 'https://foxland.fi/contact/';
						pot.headers['last-translator'] = 'Foxland (https://foxland.fi)\n';
						pot.headers['language-team'] = 'Foxland <sami.keijonen@foxnet.fi>\n';
						pot.headers['language'] = 'en_US';
						var translation, // Exclude meta data from pot.
							excluded_meta = [
								'Plugin Name of the plugin/theme',
								'Plugin URI of the plugin/theme',
								'Author of the plugin/theme',
								'Author URI of the plugin/theme'
							];
							for ( translation in pot.translations[''] ) {
								if ( 'undefined' !== typeof pot.translations[''][ translation ].comments.extracted ) {
									if ( excluded_meta.indexOf( pot.translations[''][ translation ].comments.extracted ) >= 0 ) {
										console.log( 'Excluded meta: ' + pot.translations[''][ translation ].comments.extracted );
										delete pot.translations[''][ translation ];
									}
								}
							}
							return pot;
						}
					}
				}
			},

		checktextdomain: {
			options:{
				text_domain: 'toivo',
				create_report_file: true,
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d',
					' __ngettext:1,2,3d',
					'__ngettext_noop:1,2,3d',
					'_c:1,2d',
					'_nc:1,2,4c,5d'
					]
				},
				files: {
					src: [
						'**/*.php', // Include all files
						'!node_modules/**', // Exclude node_modules/
						'!build/.*'// Exclude build/
						],
					expand: true
				}
			},

		// Right to left styles
		rtlcss: {
			options: {
				// rtlcss options
				config:{
					swapLeftRightInUrl: false,
					swapLtrRtlInUrl: false,
					autoRename: false,
					preserveDirectives: true,
					stringMap: [
						{
							name: 'import-rtl-stylesheet',
							search: [ '.css' ],
							replace: [ '-rtltest.css' ],
							options: {
								scope: 'url',
								ignoreCase: false
							}
						}
					]
				},
				// extend rtlcss rules
				//rules:[],
				// extend rtlcss declarations
				//declarations:[],
				// extend rtlcss properties
				//properties:[],
				// generate source maps
				//map: false,
				// save unmodified files
				saveUnmodified: true,
			},
			theme: {
				expand : true,
				//cwd    : '/',
				//dest   : '/',
				ext    : '-rtl.css',
				src    : [
					'style.css'
				]
			}
	},

		// Minify files
		uglify: {
			responsivenav: {
				files: {
					'js/responsive-nav.min.js': ['js/responsive-nav.js'],
					'js/settings.min.js': ['js/settings.js']
				}
			},
			settigns: {
				files: {
					'js/functions.min.js': ['js/functions.js'],
					'js/customizer.min.js': ['js/customizer.js']
				}
			}
		},

		// Minify css
		cssmin : {
			css: {
				src: 'style.css',
				dest: 'style.min.css'
			},
			genericons: {
				src: 'fonts/genericons/genericons/genericons.css',
				dest: 'fonts/genericons/genericons/genericons.min.css'
			}
		},

		// Clean up build directory
		clean: {
			main: ['build/<%= pkg.name %>']
		},

		// Copy the theme into the build directory
		copy: {
			main: {
				src:  [
					'**',
					'!node_modules/**',
					'!build/**',
					'!.git/**',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!.gitmodules',
					'!.tx/**',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/*~',
			'!style-rtl.css'
				],
				dest: 'build/<%= pkg.name %>/'
			}
		},

		// Replace text
		replace: {
			styleVersion: {
				src: [
					'style.css',
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				} ]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'TOIVO_VERSION'.*$/m,
					to: 'define( \'TOIVO_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			}
		},

		// Compress build directory into <name>.zip and <name>-<version>.zip
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './build/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'build/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		},

});

// Default task.
grunt.registerTask( 'default', [ 'checktextdomain', 'makepot', 'rtlcss', 'uglify', 'cssmin' ] );

// Build task(s).
grunt.registerTask( 'build', [ 'clean', 'replace:styleVersion', 'replace:functionsVersion', 'copy', 'compress' ] );

};