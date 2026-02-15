const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const browserSync = require('browser-sync').create();

// Rutas
const paths = {
    scss: {
        src: './src/scss/**/*.scss',
        main: './src/scss/style.scss',
        dest: './assets/css'
    },
    js: {
        src: './assets/js/**/*.js'
    }
};

// Compilar SCSS
function compileSass() {
    return gulp.src(paths.scss.main)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.scss.dest))
        .pipe(browserSync.stream());
}

// Minificar CSS
function minifyCSS() {
    return gulp.src('./assets/css/style.css')
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(paths.scss.dest));
}

// Watch
function watch() {
    browserSync.init({
        proxy: "localhost", // Ajusta según tu configuración local
        notify: false
    });
    
    gulp.watch(paths.scss.src, compileSass);
    gulp.watch('./**/*.php').on('change', browserSync.reload);
    gulp.watch(paths.js.src).on('change', browserSync.reload);
}

// Build
const build = gulp.series(compileSass, minifyCSS);

// Exports
exports.compileSass = compileSass;
exports.minifyCSS = minifyCSS;
exports.watch = watch;
exports.build = build;
exports.default = watch;