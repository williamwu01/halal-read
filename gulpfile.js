const gulp = require('gulp');
const autoprefixer = require('autoprefixer');
const browserSync = require('browser-sync').create();
const postcss = require('gulp-postcss');
const sass = require('gulp-dart-sass');
const sourcemaps = require('gulp-sourcemaps');

// Compile Sass to CSS and add prefixes when needed
gulp.task('css', function () {
	let plugins = [
		autoprefixer()
	]
	return gulp.src('./sass/*.scss')
	    .pipe(sourcemaps.init())
	    .pipe(sass({
			outputStyle: 'expanded',
			precision: 10,
			indentType: 'tab',
			indentWidth: '1'
	    }).on('error', sass.logError))
	    .pipe(postcss(plugins))
	    .pipe(sourcemaps.write('./sass'))
	    .pipe(gulp.dest('./'));
});

// Watch everything
gulp.task('watch', function () {
	gulp.watch( ['./**/*.scss' ], gulp.series('css') );
	// BrowserSync ***UPDATE PROXY & PORT***
	browserSync.init({
		open: 'external',
		proxy: 'http://localhost/halal',
		port: 8080
	});
	gulp.watch('./**/*').on('change', browserSync.reload);
});

// Default task that runs when running 'npx gulp'
gulp.task( 'default', gulp.series('css', 'watch') );
