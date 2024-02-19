const { src, dest, watch, series } = require('gulp')
const sass = require('gulp-sass')(require('sass'))

function buildApp() {
    return src('src/style/scss/**/*.scss')
      .pipe(sass())
      .pipe(dest('src/style/css'))
}

function watchTask() {
    watch(['src/style/scss/**/*.scss'], buildApp)
}

exports.default = series(buildApp, watchTask)