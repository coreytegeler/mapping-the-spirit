var argv = require('yargs').argv;
var gulpif = require('gulp-if');
var rename = require('gulp-rename');
var gulp = require('gulp');
var gutil = require('gulp-util');
var plumber = require('gulp-plumber');
var jade = require('gulp-jade');
var sass = require('gulp-sass');
var coffee = require('gulp-coffee');
var rupture = require('rupture');
var autoprefixer = require('gulp-autoprefixer');
var htmlmin = require('gulp-htmlmin');
var replace = require('gulp-replace');
var htmlreplace = require('gulp-html-replace');

var paths = {
  jade: 'source/jade/*.jade',
  sass: 'source/sass/*.sass',
  coffee: 'source/coffee/*.coffee',
}

var dest = {
  html: './',
  css: './assets/css',
  js: './assets/js',
  imgs: './assets/imgs'
}

gulp.task('compile-jade', function() {
  return gulp.src(paths.jade)
    .pipe(plumber())
    .pipe(jade())
    .pipe(gulpif(argv.prod, htmlmin({ collapseWhitespace: true })))
    .pipe(gulpif(argv.prod, htmlreplace({ css: 'style.min.css' })))
    .pipe(gulpif(argv.prod, htmlreplace({ css: 'script.min.js' })))
    .pipe(replace('imgs/', dest.imgs))
    .pipe(gulp.dest(dest.html))
  .on('end', function() {
    log('HTML done');
    if (argv.prod) log('HTML minified');
  });
});

gulp.task('compile-sass', function() {
  var options = {
    use: [rupture(), autoprefixer()],
    compress: argv.prod ? true : false
  };

  return gulp.src('./source/sass/style.scss')
    .pipe(plumber())
    .pipe(sass(options))
    .pipe(gulpif(argv.prod, rename('style.min.css')))
    .pipe(replace('imgs/', dest.imgs))
    .pipe(gulp.dest(dest.css))
  .on('end', function() {
    log('Sass done');
    if (argv.prod) log('CSS minified');
  });
});

gulp.task('compile-coffee', function() {
  return gulp.src('./source/coffee/script.coffee')
    .pipe(coffee({bare: true}))
    .pipe(gulpif(argv.prod, rename('script.min.js')))
    .pipe(gulp.dest(dest.js))
  .on('end', function() {
    log('Coffee done');
    if (argv.prod) log('JS minified');
  });
});

gulp.task('watch', function() {
  gulp.watch(paths.jade, ['compile-jade']);
  gulp.watch(paths.sass, ['compile-sass']);
  gulp.watch(paths.coffee, ['compile-coffee']);
});


gulp.task('dev', [
  'compile-jade',
  'compile-sass',
  'compile-coffee',
  'watch'
]);

gulp.task('prod', [
  'compile-jade',
  'compile-sass',
  'compile-coffee'
]);


function log(message) {
  gutil.log(gutil.colors.bold.green(message));
}