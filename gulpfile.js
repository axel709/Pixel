const { src, dest, watch, series, task } = require('gulp')
const sass = require('gulp-sass')(require('sass'))

function build() {
    return src('src/style/scss/index.scss')
      .pipe(sass())
      .pipe(dest('src/style/css'))
}

function taskWatcher() {
    watch(['index.scss'], build)
}

exports.default = series(build, taskWatcher)