// Определяем константы Gulp
const { src, dest, parallel, series, watch } = require('gulp');
const browserSync   = require('browser-sync').create();
const uglify        = require('gulp-uglify-es').default;
const terser 				= require('gulp-terser')
const sass          = require('gulp-sass');
const autoprefixer  = require('gulp-autoprefixer');
const cleancss      = require('gulp-clean-css');
const concat        = require('gulp-concat');
const imagemin      = require('gulp-imagemin');
const newer         = require('gulp-newer');
const babel 				= require('gulp-babel')
const del           = require('del');


let preprocessor    = 'sass';
let lang            = 'php';
let defpath         = 'app/';
 
function browsersync() {
	browserSync.init({ // Инициализация Browsersync
		proxy: 'http://ams.rg/',
    // server: { baseDir: `${defpath}` }, // Указываем папку сервера
    notify: false, // Отключаем уведомления
    online: true // Режим работы: true или false
  })
}
function assets() {
		return src([ // Берём файлы из источников
			`${defpath}libs/modernizr/modernizr.js`,
			'node_modules/jquery/dist/jquery.min.js',
			'node_modules/suggestions-jquery/dist/js/jquery.suggestions.min.js',
			'node_modules/jquery-pjax/jquery.pjax.js',
			`${defpath}libs/specversion/jquery.cookie.min.js`,
			`${defpath}libs/specversion/jquery.matchHeight-min.js`,
			'node_modules/jquery-validation/dist/jquery.validate.min.js',
			'node_modules/jquery-validation/dist/localization/messages_ru.js',
			'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
			'node_modules/nprogress/nprogress.js',
			'node_modules/toastr/toastr.js',
			`${defpath}libs/waypoints/waypoints.min.js`,
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
			`${defpath}libs/specversion/special_version.js`,
			])
			.pipe(newer(`${defpath}assets/js/libs.min.js`))
			.pipe(concat('libs.min.js')) // Конкатенируем в один файл
			.pipe(uglify()) // Сжимаем JavaScript
			// .pipe(babel({presets: ["@babel/preset-env"]}))
			.pipe(terser())
			.pipe(dest(`${defpath}assets/js/`)) // Выгружаем готовый файл в папку назначения
			.pipe(browserSync.stream()) // Триггерим Browsersync для обновления страницы
}
function scripts() {
	return src([`${defpath}/js/common.js`,])
		// .pipe(newer(`${defpath}js/common.min.js`))
		// .pipe(babel({presets: ["@babel/preset-env"]}))
		.pipe(concat('common.min.js')) // Конкатенируем в один файл
		// .pipe(uglify()) // Сжимаем JavaScript
		.pipe(terser())
		.pipe(dest(`${defpath}js/`)) // Выгружаем готовый файл в папку назначения
		.pipe(browserSync.stream()) // Триггерим Browsersync для обновления страницы
}

function styles() {
	return src(`${defpath}${preprocessor}/main.${preprocessor}`) // Выбираем источник: "app/sass/main.sass" или "app/less/main.less"
	.pipe(eval(preprocessor)()) // Преобразуем значение переменной "preprocessor" в функцию
	.pipe(concat('app.min.css')) // Конкатенируем в файл app.min.js
	.pipe(autoprefixer({ overrideBrowserslist: ['last 10 versions'], grid: true })) // Создадим префиксы с помощью Autoprefixer
	.pipe(cleancss( { level: { 1: { specialComments: 0 } }/* , format: 'beautify' */ } )) // Минифицируем стили
	.pipe(dest(`${defpath}css/`)) // Выгрузим результат в папку "app/css/"
	.pipe(browserSync.stream()) // Сделаем инъекцию в браузер
}

function images() {
	return src(`${defpath}images/src/**/*`) // Берём все изображения из папки источника
	.pipe(newer(`${defpath}images/dest/`)) // Проверяем, было ли изменено (сжато) изображение ранее
	.pipe(imagemin()) // Сжимаем и оптимизируем изображеня
	.pipe(dest(`${defpath}images/dest/`)) // Выгружаем оптимизированные изображения в папку назначения
}

function cleanimg() {
	return del(`${defpath}images/dest/**/*`, { force: true }) // Удаляем всё содержимое папки "app/images/dest/"
}

function startwatch() {
  watch([`${defpath}**/*.js`, `!${defpath}**/*.min.js`], scripts);
  watch(`${defpath}${preprocessor}/**/*`, styles);
  watch(`${defpath}**/*.${lang}`).on('change', browserSync.reload);
  watch(`${defpath}images/src/**/*`, images);
}

function buildcopy() {
	return src([
		`${defpath}css/**/*.min.css`,
		`${defpath}js/**/*.min.js`,
		`${defpath}images/dest/**/*`,
		`${defpath}/*.css`,
		`${defpath}**/*.${lang}`,
		], { base: defpath }) // Параметр "base" сохраняет структуру проекта при копировании
	.pipe(dest(`dist`)) // Выгружаем в папку с финальной сборкой
}

function cleandist() {
	return del('dist/**/*', { force: true }) // Удаляем всё содержимое папки "dist/"
}
exports.assets				= assets
exports.images        = images;
exports.styles        = styles;
exports.scripts       = scripts;
exports.cleanimg      = cleanimg;
exports.browsersync   = browsersync;

exports.build         = series(cleandist, styles, assets, scripts, images, buildcopy);
exports.default       = parallel(styles, assets, scripts, browsersync, startwatch);