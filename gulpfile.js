// Load Gulp...of course
const { src, dest, task, watch, series, parallel } = require('gulp');

// CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();
var reload       = browserSync.reload;

// Project related variables
var projectURL   = 'http://plugin.localhost';

var styleSRC     = './src/scss/style.scss';
var styleForm     = './src/scss/form.scss';
var styleSlider     = './src/scss/slider.scss';
var styleAuth       = './src/scss/auth.scss';
var styleURL     = './dist/css/';
var mapURL       = './';

var jsSRC        = './src/js/';
var jsAdmin		 = 'script.js';
var jsForm       = 'form.js';
var jsSlider     = 'slider.js';
var jsAuth       = 'auth.js';
var jsFiles      = [ jsAdmin , jsForm, jsSlider , jsAuth];
var jsURL        = './dist/js/';


var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';

// Tasks
// Tasks
function browser_sync() {
	browserSync.init({
		server: {
			baseDir: './dist/'
		}
	});
	browserSync.init({
		proxy: projectURL,
		injectChanges: true,
		open: false
	});
}

function reload(done) {
	browserSync.reload();
	done();
}

function css(done) {
	src( [ styleSRC, styleForm, styleSlider, styleAuth ] )
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer({ browsersList: [ 'last 2 versions' ] }) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( dest( styleURL ) )
		/*.pipe( browserSync.stream() );*/
	done();
};

function js(done) {
	jsFiles.map( function( entry ) {
		return browserify({
			entries: [jsSRC + entry]
		})
		.transform( babelify, { presets: [ '@babel/preset-env' ] } )
		.bundle()
		.pipe( source( entry ) )
		.pipe( rename( {
			extname: '.min.js'
        } ) )
		.pipe( buffer() )
		.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
		.pipe( sourcemaps.init({ loadMaps: true }) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( dest( jsURL ) )
		//.pipe( browserSync.stream() );
	});
	done();
};



function triggerPlumber( src_file, dest_file ) {
	return src( src_file )
		.pipe( plumber() )
		.pipe( dest( dest_file ) );
}

function watch_files() {
	/*watch(styleWatch, series(css , reload));
	watch(jsWatch, series(js , reload));*/
	watch(styleWatch, series(css));
	watch(jsWatch, series(js));
	src(jsURL + 'script.min.js')
		.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
}

task("css", css);
task("js", js);
task("default", parallel(css, js));
//task("watch", parallel(browser_sync, watch_files));
task("watch", parallel(watch_files));
