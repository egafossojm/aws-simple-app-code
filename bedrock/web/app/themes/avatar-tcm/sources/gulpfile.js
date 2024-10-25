/*
Gulpfile.js file for Avatar IE WordPres Theme
Using Gulp, SASS for your front end web development
Options:
gulp - delete all css, js files and generate new files
gulp-watch - rug gulp in background and generate css, javascript when the files was changed
gulp-clean - delete all generated files
gulp-styles - generate main css file style.css and style.css.map
gulp-stylesva - generate vendors and admin css files
gulp-scripts - generate frontend and backend JavaScripts
*/

// Include gulp and gulp plug-ins
var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    //cmq = require('gulp-combine-media-queries'),
    concat = require('gulp-concat'),
    del = require('del'),
    jshint = require('gulp-jshint'),
    minifycss = require('gulp-minify-css'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    rigger = require('gulp-rigger'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    livereload = require('gulp-livereload');

var autoprefixerOptions = {
  browsers: ['last 2 version', 'safari 5', 'ie 11', 'opera 12.1', 'ios 6', 'android 4']
};


var paths = {
     home: '../',
     assets_css: '../assets/css/',
     assets_js: '../assets/javascripts/',
     assets_fonts: '../assets/fonts/',
     src_css_fe: 'scss/front-end/',
     src_css_be: 'scss/back-end/',
     src_js: 'javascripts/',
     bower_libs: ['./bower_components/bootstrap-sass/assets/stylesheets/'],
    };

var onError = function(err) {
         console.log(err);
    }

// Generate Vendors, Admin CSS
gulp.task('stylesva', function() {
  return gulp.src([ paths.src_css_fe + '*.scss', paths.src_css_be + '*.scss'])
    .pipe(plumber({errorHandler: onError}))
    .pipe(sourcemaps.init())
    .pipe(sass({ includePaths : paths.bower_libs, style: 'expanded', errLogToConsole: true }))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(gulp.dest(paths.assets_css))
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifycss())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.assets_css))
    //.pipe(notify({ message: 'Styles task complete: <%= file.relative %>!' }))
    .pipe(livereload());
});

//Generate Main CSS
gulp.task('styles', function() {
  return gulp.src('scss/style.scss')
    .pipe(plumber({errorHandler: onError}))
    .pipe(sourcemaps.init())
    .pipe(sass({ includePaths : paths.bowerlibs, style: 'expanded', errLogToConsole: true }))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(minifycss())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.home))
    //.pipe(notify({ message: 'Styles task complete: <%= file.relative %>!' }))
    .pipe(livereload());
});

// Generate Scripts
gulp.task('scripts', function() {
  return gulp.src( paths.src_js + '*.js')
    .pipe(rigger())
    .pipe(gulp.dest(paths.assets_js))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify().on('error', function(e){
            console.log(e);
         }))
    .pipe(gulp.dest(paths.assets_js))
    //.pipe(notify({ message: 'Scripts task complete: <%= file.relative %>!' }))
    .pipe(livereload());
});

// Fonts
gulp.task('fonts', function() {
  return gulp.src([ './bower_components/font-awesome/fonts/fontawesome-webfont.*'])
    .pipe(gulp.dest( paths.assets_fonts ))
    //.pipe(notify({ message: 'Copy Fonts : <%= file.relative %>!' }))
    .pipe(livereload());
});


// Clean
gulp.task('clean', function(cb) {
    del([ paths.assets_fonts + '*', paths.assets_css + '*', paths.assets_js + '*', paths.home + 'style.+(css|css.map)'], {force: true}, cb)
});

// Default task
gulp.task('default', [ 'clean', 'fonts', 'stylesva', 'styles', 'scripts'], function() {
    gulp.start('styles', 'scripts');
});

// Watch
gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch([ paths.src_css_fe + '**/*.scss', paths.src_css_be + '**/*.scss'], ['stylesva', 'styles']);
  gulp.watch([ 'scss/style.scss', paths.src_css_fe + 'main.scss'] , ['styles']);

  // Watch gulpfile files
  gulp.watch('gulpfile.js', ['styles', 'stylesva', 'scripts']);

  // Watch .js files
  gulp.watch( paths.src_js + '*.js', ['scripts']);
  gulp.watch( paths.src_js + '**/*.js', ['scripts']);
  gulp.watch( paths.src_js + '**/**/*.js', ['scripts']);

  // Enable LiveReload
  livereload.listen();

});