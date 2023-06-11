const preprocessor = 'sass',
		  fileswatch   = 'php,html,htm,txt,json,md,woff2,css',
      baseDir      = 'app',
      hostName     = 'http://ams.rg/'

const { src, dest, parallel, series, watch } = require('gulp');
const browserSync  = require('browser-sync').create();
const bssi         = require('browsersync-ssi');
const ssi          = require('ssi');
const strip 			 = require('gulp-strip-comments');
const webpack      = require('webpack-stream');
const sass         = require('gulp-sass');
const sassglob		 = require('gulp-sass-glob');
const sourcemaps   = require('gulp-sourcemaps');
const cleancss     = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const rename       = require('gulp-rename');
const imagemin     = require('gulp-imagemin');
const newer        = require('gulp-newer');
const rsync        = require('gulp-rsync');
const concat       = require('gulp-concat');
const uglify       = require('gulp-uglify-es').default;
const terser 			 = require('gulp-terser')
const del          = require('del');


function browsersync() {
  if(hostName != 'http://localhost/'){
    browserSync.init({
      proxy: {
        target: hostName,
      },
      notify: false,
      online: true,
    })
  }else{
    browserSync.init({
      server: {
        baseDir: baseDir,
        middleware: bssi({ baseDir, ext: '.html' })
      },
      ghostMode: { clicks: false },
      notify: false,
      online: true,
    })
  }
}
function assets() {
	return src([ // Берём файлы из источников
  `${baseDir}/libs/modernizr/modernizr.js`,
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/suggestions-jquery/dist/js/jquery.suggestions.min.js',
  'node_modules/jquery-pjax/jquery.pjax.js',
  `${baseDir}/libs/specversion/jquery.cookie.min.js`,
  `${baseDir}/libs/specversion/jquery.matchHeight-min.js`,
  'node_modules/jquery-validation/dist/jquery.validate.min.js',
  'node_modules/jquery-validation/dist/localization/messages_ru.js',
  'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
  'node_modules/nprogress/nprogress.js',
  'node_modules/toastr/toastr.js',
  `${baseDir}/libs/waypoints/waypoints.min.js`,
  'node_modules/gsap/dist/gsap.min.js',
  'node_modules/izimodal/js/iziModal.min.js',
  'node_modules/select2/dist/js/select2.min.js',
  'node_modules/select2/dist/js/i18n/ru.js',
  'node_modules/mmenu-js/dist/mmenu.js',
  'node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
  'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
  'node_modules/air-datepicker/dist/js/datepicker.min.js',
  'node_modules/animejs/lib/anime.min.js',
  'node_modules/chart.js/dist/Chart.bundle.min.js',
  `${baseDir}/libs/specversion/special_version.js`,
])
		.pipe(newer(`${baseDir}/assets/js/libs.min.js`))
		.pipe(strip())
		.pipe(uglify()) // Сжимаем JavaScript
		.pipe(concat('libs.min.js')) // Конкатенируем в один файл
		.pipe(terser())
		.pipe(dest(`${baseDir}/assets/js/`)) // Выгружаем готовый файл в папку назначения
		.pipe(browserSync.stream()) // Триггерим Browsersync для обновления страницы
}
function scripts() {
	return src([`${baseDir}/js/common.js`, `!${baseDir}/js/*.min.js`])
		.pipe(webpack({
			mode: 'production',
			performance: { hints: false },
			module: {
				rules: [
					{
						test: /\.(js)$/,
						exclude: /(node_modules)/,
						loader: 'babel-loader',
						query: {
							presets: ['@babel/env'],
							plugins: ['babel-plugin-root-import']
						}
					}
				]
			}
		})).on('error', function handleError() {
			this.emit('end')
		})
		.pipe(rename('common.min.js'))
		.pipe(dest(`${baseDir}/js`))
		.pipe(browserSync.stream())
}

function styles() {
	return src([`${baseDir}/${preprocessor}/*.*`, `!${baseDir}/${preprocessor}/_*.*`])
    .pipe(eval(`${preprocessor}glob`)())
    .pipe(sourcemaps.init())       // активируем gulp-sourcemaps 
    .pipe(sass({
        outputStyle: 'nested'      // вложенный (по умолчанию) 
    }).on('error', sass.logError)) // уведомление об ошибках 
		.pipe(autoprefixer({ overrideBrowserslist: ['last 10 versions'], grid: true }))
		.pipe(cleancss({ level: { 1: { specialComments: 0 } },/* format: 'beautify' */ }))
		.pipe(rename({ suffix: ".min" }))
    .pipe(sourcemaps.write('.'))   // создание карты css.map в текущей папке
		
		.pipe(dest(`${baseDir}/css`))
		.pipe(browserSync.stream())
}

function images() {
	return src([`${baseDir}/images/src/**/*`])
		.pipe(newer(`${baseDir}/images/dist`))
		.pipe(imagemin())
		.pipe(dest(`${baseDir}/images/dist`))
		.pipe(browserSync.stream())
}

function buildcopy() {
	return src([
		`{${baseDir}/js,${baseDir}/css}/*.min.*`,
		`${baseDir}/images/**/*.*`,
		`!${baseDir}/images/src/**/*`,
		`${baseDir}/fonts/**/*`,
		`${baseDir}/video/**/*`
	], { base: `${baseDir}/` })
	.pipe(dest('dist'))
}

async function buildhtml() {
	let includes = new ssi(`${baseDir}/`, 'dist/', '/**/*.html')
	includes.compile()
	del('dist/parts', { force: true })
}

function cleandist() {
	return del('dist/**/*', { force: true })
}

function deploy() {
	return src('dist/')
		.pipe(rsync({
			root: 'dist/',
			hostname: 'username@yousite.com',
			destination: 'yousite/public_html/',
			// clean: true, // Mirror copy with file deletion
			include: [/* '*.htaccess' */], // Included files to deploy,
			exclude: [ '**/Thumbs.db', '**/*.DS_Store' ],
			recursive: true,
			archive: true,
			silent: false,
			compress: true
		}))
}

function startwatch() {
	watch(`${baseDir}/sass/**/*`, { usePolling: true }, styles)
	watch([`${baseDir}/js/**/*.js`, `!${baseDir}/js/**/*.min.js`], { usePolling: true }, scripts)
	watch(`${baseDir}/images/src/**/*.{jpg,jpeg,png,webp,svg,gif}`, { usePolling: true }, images)
	watch(`${baseDir}/**/*.{${fileswatch}}`, { usePolling: true }).on('change', browserSync.reload)
}

exports.scripts = scripts
exports.styles  = styles
exports.assets  = assets
exports.images  = images
exports.deploy  = deploy
exports.assets  = series(scripts, styles,assets, images)
exports.build   = series(cleandist,assets, scripts, styles, images, buildcopy, buildhtml)
exports.default = series(assets, scripts, styles, images, parallel(browsersync, startwatch))