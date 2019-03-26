module.exports = function (grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    uglify: {
      dist: {
        options: {
          mangle: false,
          sourceMap: true,
          beautify: true
        },
        files: {
          '../js/custom.js': [
            'js/lib/jquery-3.3.1.min.js',
            'js/main.js'
          ]
        }
      }
    },

    sass: {
      options: {
        sourceMap: true,
        outputStyle: 'expanded'
      },
      dist: {
        files: {
          '../css/custom.css': 'sass/main.scss',
          '../css/candidate.css': 'sass/main_candidate.scss'
        }
      }
    },

    watch: {
      js: {
        files: ['js/*'],
        tasks: ['uglify']
      },
      sass: {
        files: ['sass/**/*'],
        tasks: ['sass']
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('build', ['sass', 'uglify']);
  grunt.registerTask('default', 'build');

};