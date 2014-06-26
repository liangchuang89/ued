/*
 * created by 栖邀(qiyao.kxp@taobao.com)
 */

module.exports = function (grunt) {

    var path = require('path');
    var shell = require('shelljs');

    grunt.loadNpmTasks('grunt-kmc');
    grunt.loadNpmTasks('grunt-native2ascii');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    var _basePkg = 'ecc';
    var dailyPath = 'http://g.assets.daily.taobao.net', cdnPath = 'http://g.tbcdn.cn';

    grunt.registerTask('build', 'build the component', function () {
        var buildDir = String(grunt.option('buildTo') || '.package').trim();
        var base = String(grunt.option('path') || '').trim();
        var env = '';

        var branch = shell.exec('cat .git/HEAD', {silent: true}).output;
        if (branch.search(/daily\/\d\.\d\.\d/g) == -1) {
            grunt.log.error('你所在分支不合法，无法build(请在daily/x.x.x下进行build)');
            return false;
        }

        var buildVer = (buildVer || branch.slice(branch.lastIndexOf('/') + 1)).trim();
        var buildComponent = (buildComponent || path.basename(shell.pwd())).trim();

        if (base.indexOf(dailyPath) != -1) {
            env = 'daily';
        }
        if (base.indexOf(cdnPath) != -1) {
            env = 'publish';
        }

        if (!env) {
            grunt.log.error('非法的base打包路径');
            return false;
        }

        console.log(env+'=>'+base+';'+buildDir+';'+buildVer+';'+buildComponent);

        grunt.initConfig({

            clean: {
                build: {
                    src: [buildDir + '/**']
                },
                temp: {
                    src: [buildDir + '/' + buildComponent + '/**']
                }
            },

            copy: { //注入组件名和组件版本(build/comp/1.0.0/)，复制一份到build下，以便生成依赖
                main: {
                    files: [
                        {
                            expand: true,
                            cwd: 'src/',
                            src: ['*.js', '*.css'],
                            dest: buildDir + '/' + buildComponent + '/' + buildVer,
                            flatten: true,
                            filter: 'isFile'
                        }
                    ]
                }
            },

            concat: { //打包组件的css到index.css
                options: {
                    process: function (src, filepath) {
                        return '/*source from:' + path.basename(filepath) + '*/\n' + src;
                    }
                },
                main: {
                    files: [
                        {
                            src: [buildDir + '/**/*.css'],
                            dest: buildDir + '/index.css'
                        }
                    ]
                }
            },

            kmc: { //根据入口文件生成combo后的组件到index.js
                options: {
                    packages: [
                        {
                            name: buildComponent,
                            path: '../',
                            charset:'utf-8'
                        }
                    ],
                    map: [
                        [buildComponent + '/' + buildDir + '/', _basePkg + '/']
                    ]
                },
                main: {
                    files: [
                        {
                            src: buildDir + '/' + buildComponent + '/' + buildVer + '/index.js',
                            dest: buildDir + '/index.js'
                        }
                    ]
                }
            },

            native2ascii: { //中文ascii化
                main: {
                    files: [
                        {
                            src: buildDir + '/index.js',
                            dest: buildDir + '/index.js'
                        }
                    ]
                }
            },

            uglify: { //压缩js
                options: {
                    beautify: {
                        ascii_only: true
                    }
                },
                main: {
                    files: [
                        {
                            src: buildDir + '/index.js',
                            dest: buildDir + '/index.js'
                        }
                    ]
                }
            },

            cssmin: { //压缩css
                main: {
                    files: [
                        {
                            src: buildDir + '/index.css',
                            dest: buildDir + '/index.css'
                        }
                    ]
                }
            }

        });

        var tasks = ['clean', 'copy', 'concat', 'kmc', 'native2ascii', 'clean:temp'];
        if (env == 'publish') {
            tasks.push('uglify', 'cssmin');
        }

        grunt.task.run(tasks);

    });

    grunt.registerTask('default', [
        'build'
    ]);

};
