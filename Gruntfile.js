module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    clean: {
      mincss: {
        src: ['httpdocs/css/style.min.css']
      },
      revcss: {
        src: ['httpdocs/css/*style.min.css']
      },
      revjs: {
        src: ['httpdocs/js/*main.min.js']
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true
        }
      },
      all: ['Gruntfile.js','httpdocs/js/main.js']
    }, 
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: 'httpdocs/js/main.js',
        dest: 'httpdocs/js/main.min.js'
      }
    },
    cssmin: {
      css: {
        files: {
          'httpdocs/css/style.min.css' : 
          [ 'httpdocs/css/style.css' ]
        }
      }
    },
    rev: {
      css: {
        files: {
          src: ['httpdocs/css/style.min.css']
        }
      },
      js: {
        files: {
          src: ['httpdocs/js/main.min.js']
        }
      }
    },
    injector: {
      options: { "ignorePath": ['httpdocs'] },
      css: {
        files: {
          'httpdocs/index.cfm': ['httpdocs/css/*style.min.css'],
        }
      },
      js: {
        files: {
          'httpdocs/index.cfm': ['httpdocs/js/*main.min.js'],
        }
      }
    },
    watch: {
      js: {
        files: ['httpdocs/js/main.js'],
        tasks: ['js']
      },
      css: {
        files: ['httpdocs/css/style.css'],
        tasks: ['css']
      }
    },
    browserSync: {
      dev: {
        bsFiles: {
          src : '*.*'
        },
        options: {
          watchTask: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-rev');
  grunt.loadNpmTasks('grunt-injector');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-browser-sync');

  // Default task(s).
  grunt.registerTask('default', ['browserSync','watch']);
  grunt.registerTask('js', ['clean:revjs','jshint','uglify','rev:js','injector:js','browserSync']);
  grunt.registerTask('css', ['clean:mincss','clean:revcss','cssmin','rev:css','injector:css','browserSync']);

};
