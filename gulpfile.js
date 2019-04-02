const { watch, parallel, src, dest } = require('gulp');

const rollup	= require('rollup');
const sass		= require('gulp-sass');
const concat	= require('gulp-concat');

function transpileCss() {
	return src('resources/sass/**/*.scss')
		.pipe(sass({
			includePaths: ['node_modules/bulma'],
			//outputStyle: 'compressed'
		}).on('error', sass.logError))
		.pipe(dest('public/css'));
}

function transpileJs() {
	return rollup.rollup({
		input: 'resources/js/app.js'
	}).then(bundle => {
		return bundle.write({
			file: 'public/js/app.js',
			format: 'iife',
			name: 'WeFrame',
			sourcemap: 'inline'
		});
	});
}

function vendorJs() {
    return src(['node_modules/jquery/dist/jquery.min.js',
		'node_modules/slick-carousel/slick/slick.min.js'])
        .pipe(concat('vendor.min.js'))
        .pipe(dest('js'));
}

function vendorStyles() {
	return src(['node_modules/slick-carousel/slick/slick.css',
				'node_modules/slick-carousel/slick/slick-theme.css'])
        .pipe(concat('vendor.css'))
        .pipe(dest('css'));
}

function watchSass() {
	return watch('resources/sass/**/*.scss', transpileCss);
}

function watchJs() {
	return watch('resources/js/**/*.js', transpileJs);
}

exports.watch = parallel(
	watchSass,
	watchJs
);

exports.update = parallel(
	transpileCss,
	transpileJs
);

exports.vendor = parallel(
	vendorJs,
	vendorStyles
);