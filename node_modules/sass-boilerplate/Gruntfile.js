module.exports = function(grunt) {
    'use-strict';

    require("load-grunt-tasks")(grunt);
    grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
        clean: {
            clean_sass: {
                src: ['dist/css/*'],
                filter: 'isFile',
            },
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded', /* compressed, compact, nested */
                    precision: 7
                },
                files: {
                    'dist/css/style.css' : 'src/scss/style.scss'
                }
            },
            dist_compressed: {
                options: {
                    style: 'compressed', /* compressed, compact, nested */
                    sourcemap: 'none',
                    precision: 7
                },
                files: {
                    'dist/css/style.css' : 'src/scss/style.scss'
                }
            }
        },
        babel: {
           options: {
               sourceMap: true,
               presets: ['es2015']
           },
           dist: {
                files: {
                   'dist/js/app.js': 'js/app.js'
                }
            }
        },
        watch: {
            options: {
                dateFormat: function(time) {
                    grunt.log.writeln('The watch finished in ' + time + 'ms at' + (new Date()).toString());
                    grunt.log.writeln('Waiting for more changes...');
                },
            },
            watch_sass: {
                files: ['src/**/*.scss'],
                tasks: ['sass:dist'],
                options: {
                    spawn: false,
                },
            },
        },
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('remove',['clean:clean_sass']);
    grunt.registerTask('babel_build',['babel']);
    grunt.registerTask('build', ['sass:dist']);
    grunt.registerTask('production',['sass:dist_compressed']);
	grunt.registerTask('default',['watch']);
}
