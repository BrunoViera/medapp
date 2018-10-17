const gulp = require('gulp');
const rev = require('gulp-rev');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');

gulp.task('build', ['build:css'], () => {
  gulp.start('build:addVersion');
});

gulp.task('build:addVersion', () => gulp
  .src(['assets/build/**/*', '!assets/build/**/fonts/**', '!assets/build/**/images/**'])
  .pipe(rev())
  .pipe(gulp.dest('./public/'))
  .pipe(rev.manifest('manifest.json'))
  .pipe(gulp.dest('./public/')));

gulp.task('build:css', () => gulp
  .src('./assets/sass/*.scss')
  .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
  .pipe(autoprefixer({
    browsers: ['last 2 versions'],
    cascade: false,
  }))
  .pipe(gulp.dest('./assets/build/css')));
