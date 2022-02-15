<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}
?>
<!DOCTYPE html>
<html class="no-js" lang="ru">

<head>
	<meta charset="utf-8">
	<title><? $APPLICATION->ShowTitle() ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta property="og:image" content="path/to/image.jpg">
	<!-- <meta http-equiv="x-pjax-version" content="v1"> -->
	<link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon/apple-touch-icon-114x114.png">
	<?
	$APPLICATION->ShowHead();
	Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/app.min.css");
	Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/libs.min.js");
	Bitrix\Main\Page\Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?apikey=256e028a-94b5-496f-b948-394772dc151a&lang=ru_RU");
	Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/common.js");
	// Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/app_form.js");
	$GLOBALS["IS_HOME"] = $APPLICATION->GetCurPage(true) === SITE_DIR . "index.php";
	CModule::IncludeModule('iblock');
	?>
</head>

<body>
	<div class="wrapper" <? if (!$GLOBALS["IS_HOME"]) { ?>id="pjax-container" <? } ?>>
		<div><? $APPLICATION->ShowPanel(); ?></div>
		<div class="special-settings">
			<div class="aa-block aaFontsize">
				<div class="fl-l">Размер:</div>
				<a class="aaFontsize-small" data-aa-fontsize="small" href="#" title="Уменьшенный размер шрифта">A</a>
				<a class="aaFontsize-normal a-current" href="#" data-aa-fontsize="normal" title="Нормальный размер шрифта">A</a>
				<a class="aaFontsize-big" data-aa-fontsize="big" href="#" title="Увеличенный размер шрифта">A</a>
			</div>

			<div class="aa-block aaColor">
				Цвет:
				<a class="aaColor-black a-current" data-aa-color="black" href="#" title="Черным по белому"><span>C</span></a>
				<a class="aaColor-yellow" data-aa-color="yellow" href="#" title="Желтым по черному"><span>C</span></a>
				<a class="aaColor-blue" data-aa-color="blue" href="#" title="Синим по голубому"><span>C</span></a>
			</div>

			<div class="aa-block aaImage">
				Изображения
				<span class="aaImage-wrapper">
					<a class="aaImage-on a-current" data-aa-image="on" href="#">Вкл.</a>
					<a class="aaImage-off" data-aa-image="off" href="#">Выкл.</a>
				</span>
			</div>
			<span class="aa-block"><a href="/?set-aa=normal" data-aa-off><i class="icon icon-special-version"></i> Обычная версия сайта</a></span>
		</div>
		<!-- .special-settings -->
		<!-- begin top_content  <? //=SITE_TEMPLATE_PATH
														?>/api/search.php-->
		<div class="top_content">
			<div class="search_close"><i class="fa fa-times"></i></div>
			<form class="search_form wow slideInDown" method="GET" action="/search/">
				<div class="container">
					<div class="row">
						<div class="col-12 col-xl-12">
							<label for="search">
								<input type="text" name="q" class="search_input" placeholder="Поиск" autocomplete="off">
								<button type="submit" class="search_btn"><i class="fa fa-search"></i> Искать</button>
							</label>
						</div>
						<div class="col-12 col-xl-12">
							<div class="row">
								<div class="col-12 col-xl-3">
									<label class="checkbox" for="search_form_all">
										<input type="checkbox" name="iblocktype" value="" id="search_form_all" checked>
										<span>Везде</span>
									</label>
								</div>
								<div class="col-12 col-xl-3">
									<label class="checkbox" for="search_form_news">
										<input type="checkbox" name="where" value="iblock_news" id="search_form_news">
										<span>Новости</span>
									</label>
								</div>
								<div class="col-12 col-xl-3">
									<label class="checkbox" for="search_form_document">
										<input type="checkbox" name="iblocktype" value="iblock_document" id="search_form_document">
										<span>Документы</span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- end top_content -->
		<!-- begin header -->
		<header class="header">
			<div class="top_info">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-xl-10 offset-xl-1">
							<? $APPLICATION->IncludeComponent(
								"bitrix:menu",
								"cheif_menu",
								array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "left",
									"DELAY" => "N",
									"MAX_LEVEL" => "2",
									"MENU_CACHE_GET_VARS" => array(),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "N",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "chief",
									"USE_EXT" => "Y",
									"COMPONENT_TEMPLATE" => "cheif_menu",
									"COMPOSITE_FRAME_MODE" => "A",
									"COMPOSITE_FRAME_TYPE" => "AUTO"
								),
								false
							); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="search">
						<i class="fa fa-search"></i>
					</div>
					<div class="col-10 col-xl-2 offset-sm-1">
						<div class="logo">
							<a href="/">
								<img src="<?= SITE_TEMPLATE_PATH ?>/img/logo.png" alt="">
								<p>Администрация местного самоуправления и Собрание представителей г. Владикавказ.</p>
							</a>
						</div>
					</div>
					<div class="col-2 col-xl-8">
						<? $APPLICATION->IncludeComponent(
							"bitrix:menu",
							"top_menu",
							array(
								"ALLOW_MULTI_SELECT" => "N",
								"CHILD_MENU_TYPE" => "left",
								"DELAY" => "N",
								"MAX_LEVEL" => "2",
								"MENU_CACHE_GET_VARS" => array(),
								"MENU_CACHE_TIME" => "3600",
								"MENU_CACHE_TYPE" => "N",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"ROOT_MENU_TYPE" => "top",
								"USE_EXT" => "Y",
								"COMPONENT_TEMPLATE" => "top_menu",
							),
							false
						); ?>
					</div>
				</div>
			</div>
		</header>
		<!-- end header -->
		<?
		// is home
		if ($GLOBALS["IS_HOME"]) {
		?>
			<!-- begin section.promo -->
			<!-- <h1 class="city">Владикавказ</h1> -->
			<section class="section promo">
				<!-- <div class="container">
			<div class="banner">
				<h2 class="banner_title">Далеко-далеко за словесными горами в стране гласных, и согласных живут.</h2>
				<div class="banner_text">Далеко-далеко, за словесными горами в стране гласных и согласных живут рыбные тексты. Знаках сбить раз всеми, страну злых страна ipsum единственное своего продолжил текст маленький он снова, ведущими подпоясал даже курсивных свой!</div>
				<div class="btn_close"><i class="fa fa-times-circle"></i></div>
			</div>
		</div> -->
			</section>
			<!-- end section.promo -->
			<!-- begin section.news -->
			<section class="section news">
				<div class="container" style="margin-top: -125px; background-color: #fff; padding: 20px;position: relative;">
					<div class="row">
						<div class="col-12 col-xl-4">
							<? $APPLICATION->IncludeComponent(
								"bitrix:news.list",
								"ad_home",
								array(
									"ACTIVE_DATE_FORMAT" => "d.m.Y",
									"ADD_SECTIONS_CHAIN" => "Y",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_ADDITIONAL" => "",
									"AJAX_OPTION_HISTORY" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"CACHE_FILTER" => "N",
									"CACHE_GROUPS" => "Y",
									"CACHE_TIME" => "36000000",
									"CACHE_TYPE" => "A",
									"CHECK_DATES" => "Y",
									"DETAIL_URL" => "",
									"DISPLAY_BOTTOM_PAGER" => "Y",
									"DISPLAY_DATE" => "Y",
									"DISPLAY_NAME" => "Y",
									"DISPLAY_PICTURE" => "Y",
									"DISPLAY_PREVIEW_TEXT" => "Y",
									"DISPLAY_TOP_PAGER" => "N",
									"FIELD_CODE" => array(
										0 => "SHOW_COUNTER",
										1 => "",
									),
									"FILTER_NAME" => "",
									"HIDE_LINK_WHEN_NO_DETAIL" => "N",
									"IBLOCK_ID" => "34",
									"IBLOCK_TYPE" => "news",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
									"INCLUDE_SUBSECTIONS" => "Y",
									"MESSAGE_404" => "",
									"NEWS_COUNT" => "8",
									"PAGER_BASE_LINK_ENABLE" => "N",
									"PAGER_DESC_NUMBERING" => "N",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "N",
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_TEMPLATE" => ".default",
									"PAGER_TITLE" => "Новости",
									"PARENT_SECTION" => "",
									"PARENT_SECTION_CODE" => "",
									"PREVIEW_TRUNCATE_LEN" => "",
									"PROPERTY_CODE" => array(
										0 => "",
										1 => "",
									),
									"SET_BROWSER_TITLE" => "Y",
									"SET_LAST_MODIFIED" => "N",
									"SET_META_DESCRIPTION" => "Y",
									"SET_META_KEYWORDS" => "Y",
									"SET_STATUS_404" => "N",
									"SET_TITLE" => "Y",
									"SHOW_404" => "N",
									"SORT_BY1" => "ID",
									"SORT_BY2" => "SORT",
									"SORT_ORDER1" => "DESC",
									"SORT_ORDER2" => "ASC",
									"COMPONENT_TEMPLATE" => "ad_home",
								),
								false
							); ?>
						</div>
						<div class="col-12 col-xl-8">
							<? $APPLICATION->IncludeComponent(
								"bitrix:news.list",
								"news_home",
								array(
									"ACTIVE_DATE_FORMAT" => "d.m.Y",
									"ADD_SECTIONS_CHAIN" => "Y",
									"AJAX_MODE" => "N",
									"AJAX_OPTION_ADDITIONAL" => "",
									"AJAX_OPTION_HISTORY" => "N",
									"AJAX_OPTION_JUMP" => "N",
									"AJAX_OPTION_STYLE" => "Y",
									"CACHE_FILTER" => "N",
									"CACHE_GROUPS" => "Y",
									"CACHE_TIME" => "36000000",
									"CACHE_TYPE" => "A",
									"CHECK_DATES" => "Y",
									"DETAIL_URL" => "",
									"DISPLAY_BOTTOM_PAGER" => "Y",
									"DISPLAY_DATE" => "Y",
									"DISPLAY_NAME" => "Y",
									"DISPLAY_PICTURE" => "Y",
									"DISPLAY_PREVIEW_TEXT" => "Y",
									"DISPLAY_TOP_PAGER" => "N",
									"FIELD_CODE" => array(
										0 => "SHOW_COUNTER",
										1 => "",
									),
									"FILTER_NAME" => "",
									"HIDE_LINK_WHEN_NO_DETAIL" => "N",
									"IBLOCK_ID" => "19",
									"IBLOCK_TYPE" => "news",
									"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
									"INCLUDE_SUBSECTIONS" => "Y",
									"MESSAGE_404" => "",
									"NEWS_COUNT" => "4",
									"PAGER_BASE_LINK_ENABLE" => "N",
									"PAGER_DESC_NUMBERING" => "N",
									"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
									"PAGER_SHOW_ALL" => "N",
									"PAGER_SHOW_ALWAYS" => "N",
									"PAGER_TEMPLATE" => ".default",
									"PAGER_TITLE" => "Новости",
									"PARENT_SECTION" => "",
									"PARENT_SECTION_CODE" => "",
									"PREVIEW_TRUNCATE_LEN" => "",
									"PROPERTY_CODE" => array(
										0 => "VIDEO",
										1 => "",
									),
									"SET_BROWSER_TITLE" => "Y",
									"SET_LAST_MODIFIED" => "N",
									"SET_META_DESCRIPTION" => "Y",
									"SET_META_KEYWORDS" => "Y",
									"SET_STATUS_404" => "N",
									"SET_TITLE" => "Y",
									"SHOW_404" => "N",
									"SORT_BY1" => "ID",
									"SORT_BY2" => "SORT",
									"SORT_ORDER1" => "DESC",
									"SORT_ORDER2" => "ASC",
									"COMPONENT_TEMPLATE" => "news_home",
									"STRICT_SECTION_CHECK" => "N",
									"COMPOSITE_FRAME_MODE" => "A",
									"COMPOSITE_FRAME_TYPE" => "AUTO"
								),
								false
							); ?>
						</div>
					</div>
				</div>
				<? //if(CUser::IsAuthorized()){
				?>
				<div class="container">
					<script src='https://pos.gosuslugi.ru/bin/script.min.js'></script>
					<style>
						#js-show-iframe-wrapper {
							position: relative;
							display: flex;
							align-items: center;
							justify-content: center;
							width: 100%;
							min-width: 293px;
							max-width: 100%;
							background: linear-gradient(138.4deg, #38bafe 26.49%, #2d73bc 79.45%);
							color: #fff;
							cursor: pointer
						}

						#js-show-iframe-wrapper .pos-banner-fluid * {
							box-sizing: border-box
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2 {
							display: block;
							width: 240px;
							min-height: 56px;
							font-size: 18px;
							line-height: 24px;
							cursor: pointer;
							background: #0d4cd3;
							color: #fff;
							border: none;
							border-radius: 8px;
							outline: 0
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:hover {
							background: #1d5deb
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:focus {
							background: #2a63ad
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:active {
							background: #2a63ad
						}

						@-webkit-keyframes fadeInFromNone {
							0% {
								display: none;
								opacity: 0
							}

							1% {
								display: block;
								opacity: 0
							}

							100% {
								display: block;
								opacity: 1
							}
						}

						@keyframes fadeInFromNone {
							0% {
								display: none;
								opacity: 0
							}

							1% {
								display: block;
								opacity: 0
							}

							100% {
								display: block;
								opacity: 1
							}
						}

						@font-face {
							font-family: LatoWebLight;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Light.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Light.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Light.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: LatoWeb;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Regular.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Regular.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Regular.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: LatoWebBold;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Bold.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Bold.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Lato/fonts/Lato-Bold.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: RobotoWebLight;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Light.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Light.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Light.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: RobotoWebRegular;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Regular.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Regular.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Regular.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: RobotoWebBold;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Bold.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Bold.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Roboto/Roboto-Bold.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: ScadaWebRegular;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Regular.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Regular.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Regular.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: ScadaWebBold;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Bold.woff2) format("woff2"), url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Bold.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Scada/Scada-Bold.ttf) format("truetype");
							font-style: normal;
							font-weight: 400
						}

						@font-face {
							font-family: Geometria;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria.eot);
							src: url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria.eot?#iefix) format("embedded-opentype"), url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria.ttf) format("truetype");
							font-weight: 400;
							font-style: normal
						}

						@font-face {
							font-family: Geometria-ExtraBold;
							src: url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria-ExtraBold.eot);
							src: url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria-ExtraBold.eot?#iefix) format("embedded-opentype"), url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria-ExtraBold.woff) format("woff"), url(https://pos.gosuslugi.ru/bin/fonts/Geometria/Geometria-ExtraBold.ttf) format("truetype");
							font-weight: 800;
							font-style: normal
						}
					</style>

					<style>
						#js-show-iframe-wrapper {
							background: var(--pos-banner-fluid-40__background)
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2 {
							width: 100%;
							min-height: 52px;
							background: #fff;
							color: #0d4cd3;
							font-size: 16px;
							font-family: LatoWeb, sans-serif;
							font-weight: 400;
							padding: 0;
							line-height: 1.2;
							border: 2px solid #0d4cd3
						}

						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:active,
						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:focus,
						#js-show-iframe-wrapper .pos-banner-fluid .pos-banner-btn_2:hover {
							background: #e4ecfd
						}

						#js-show-iframe-wrapper .bf-40 {
							position: relative;
							display: grid;
							grid-template-columns: var(--pos-banner-fluid-40__grid-template-columns);
							grid-template-rows: var(--pos-banner-fluid-40__grid-template-rows);
							width: 100%;
							max-width: var(--pos-banner-fluid-40__max-width);
							box-sizing: border-box;
							grid-auto-flow: row dense
						}

						#js-show-iframe-wrapper .bf-40__decor {
							background: var(--pos-banner-fluid-40__bg-url) var(--pos-banner-fluid-40__bg-url-position) no-repeat;
							background-size: cover;
							background-color: #f8efec;
							position: relative
						}

						#js-show-iframe-wrapper .bf-40__content {
							display: flex;
							flex-direction: column;
							padding: var(--pos-banner-fluid-40__content-padding);
							grid-row: var(--pos-banner-fluid-40__content-grid-row);
							justify-content: center
						}

						#js-show-iframe-wrapper .bf-40__description {
							display: flex;
							flex-direction: column;
							margin: var(--pos-banner-fluid-40__description-margin)
						}

						#js-show-iframe-wrapper .bf-40__text {
							margin: var(--pos-banner-fluid-40__text-margin);
							font-size: var(--pos-banner-fluid-40__text-font-size);
							line-height: 1.4;
							font-family: LatoWeb, sans-serif;
							font-weight: 700;
							color: #0b1f33
						}

						#js-show-iframe-wrapper .bf-40__text_small {
							font-size: var(--pos-banner-fluid-40__text-small-font-size);
							font-weight: 400;
							margin: 0
						}

						#js-show-iframe-wrapper .bf-40__bottom-wrap {
							display: flex;
							flex-direction: row;
							align-items: center
						}

						#js-show-iframe-wrapper .bf-40__logo-wrap {
							position: absolute;
							top: var(--pos-banner-fluid-40__logo-wrap-top);
							left: 0;
							padding: var(--pos-banner-fluid-40__logo-wrap-padding);
							background: #fff;
							border-radius: 0 0 8px 0
						}

						#js-show-iframe-wrapper .bf-40__logo {
							width: var(--pos-banner-fluid-40__logo-width);
							margin-left: 1px
						}

						#js-show-iframe-wrapper .bf-40__slogan {
							font-family: LatoWeb, sans-serif;
							font-weight: 700;
							font-size: var(--pos-banner-fluid-40__slogan-font-size);
							line-height: 1.2;
							color: #005ca9
						}

						#js-show-iframe-wrapper .bf-40__btn-wrap {
							width: 100%;
							max-width: var(--pos-banner-fluid-40__button-wrap-max-width)
						}
					</style>
					<div id='js-show-iframe-wrapper'>
						<div class='pos-banner-fluid bf-40'>

							<div class='bf-40__decor'>
								<div class='bf-40__logo-wrap'>
									<img class='bf-40__logo' src='https://pos.gosuslugi.ru/bin/banner-fluid/gosuslugi-logo-blue.svg' alt='Госуслуги' />
									<div class='bf-40__slogan'>Решаем вместе</div>
								</div>
							</div>
							<div class='bf-40__content'>
								<div class='bf-40__description'>
									<span class='bf-40__text'>
										Не убран мусор, яма на дороге, не горит фонарь?
									</span>
									<span class='bf-40__text bf-40__text_small'>
										Столкнулись с проблемой&nbsp;— сообщите о ней!
									</span>
								</div>

								<div class='bf-40__bottom-wrap'>
									<div class='bf-40__btn-wrap'>
										<!-- pos-banner-btn_2 не удалять; другие классы не добавлять -->
										<button class='pos-banner-btn_2' type='button'>Написать о проблеме
										</button>
									</div>
								</div>
							</div>

						</div>
					</div>
					<script>
						(function() {
							"use strict";

							function ownKeys(e, t) {
								var n = Object.keys(e);
								if (Object.getOwnPropertySymbols) {
									var o = Object.getOwnPropertySymbols(e);
									if (t) o = o.filter(function(t) {
										return Object.getOwnPropertyDescriptor(e, t).enumerable
									});
									n.push.apply(n, o)
								}
								return n
							}

							function _objectSpread(e) {
								for (var t = 1; t < arguments.length; t++) {
									var n = null != arguments[t] ? arguments[t] : {};
									if (t % 2) ownKeys(Object(n), true).forEach(function(t) {
										_defineProperty(e, t, n[t])
									});
									else if (Object.getOwnPropertyDescriptors) Object.defineProperties(e, Object.getOwnPropertyDescriptors(n));
									else ownKeys(Object(n)).forEach(function(t) {
										Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
									})
								}
								return e
							}

							function _defineProperty(e, t, n) {
								if (t in e) Object.defineProperty(e, t, {
									value: n,
									enumerable: true,
									configurable: true,
									writable: true
								});
								else e[t] = n;
								return e
							}
							var POS_PREFIX_40 = "--pos-banner-fluid-40__",
								posOptionsInitialBanner40 = {
									background: "#ffffff",
									"grid-template-columns": "100%",
									"grid-template-rows": "264px auto",
									"max-width": "100%",
									"text-font-size": "20px",
									"text-small-font-size": "14px",
									"text-margin": "0 0 12px 0",
									"description-margin": "0 0 24px 0",
									"button-wrap-max-width": "100%",
									"bg-url": "url('https://pos.gosuslugi.ru/bin/banner-fluid/35/banner-fluid-bg-35.svg')",
									"bg-url-position": "right bottom",
									"content-padding": "26px 24px 20px",
									"content-grid-row": "0",
									"logo-wrap-padding": "16px 12px 12px",
									"logo-width": "65px",
									"logo-wrap-top": "0",
									"slogan-font-size": "12px"
								},
								setStyles = function(e, t) {
									var n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : POS_PREFIX_40;
									Object.keys(e).forEach(function(o) {
										t.style.setProperty(n + o, e[o])
									})
								},
								removeStyles = function(e, t) {
									var n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : POS_PREFIX_40;
									Object.keys(e).forEach(function(e) {
										t.style.removeProperty(n + e)
									})
								};

							function changePosBannerOnResize() {
								var e = document.documentElement,
									t = _objectSpread({}, posOptionsInitialBanner40),
									n = document.getElementById("js-show-iframe-wrapper"),
									o = n ? n.offsetWidth : document.body.offsetWidth;
								if (o > 340) t["button-wrap-max-width"] = "209px";
								if (o > 360) t["bg-url"] = "url('https://pos.gosuslugi.ru/bin/banner-fluid/35/banner-fluid-bg-35-2.svg')", t["bg-url-position"] = "calc(100% + 135px) bottom";
								if (o > 482) t["text-font-size"] = "23px", t["text-small-font-size"] = "18px", t["bg-url-position"] = "center bottom";
								if (o > 568) t["bg-url"] = "url('https://pos.gosuslugi.ru/bin/banner-fluid/35/banner-fluid-bg-35.svg')", t["bg-url-position"] = "calc(100% + 35px) bottom", t["text-font-size"] = "24px", t["text-small-font-size"] = "14px", t["grid-template-columns"] = "1fr 292px", t["grid-template-rows"] = "100%", t["content-grid-row"] = "1", t["content-padding"] = "48px 24px";
								if (o > 783) t["grid-template-columns"] = "1fr 390px", t["bg-url"] = "url('https://pos.gosuslugi.ru/bin/banner-fluid/35/banner-fluid-bg-35-2.svg')", t["bg-url-position"] = "calc(100% + 144px) bottom", t["text-small-font-size"] = "18px", t["content-padding"] = "30px 24px";
								if (o > 820) t["grid-template-columns"] = "1fr 420px";
								if (o > 918) t["bg-url-position"] = "calc(100% + 100px) bottom";
								if (o > 1098) t["bg-url-position"] = "center bottom", t["grid-template-columns"] = "1fr 557px", t["text-font-size"] = "32px", t["content-padding"] = "34px 50px", t["logo-width"] = "78px", t["slogan-font-size"] = "15px", t["logo-wrap-padding"] = "20px 16px 16px";
								if (o > 1422) t["max-width"] = "1422px", t["grid-template-columns"] = "1fr 720px", t.background = "linear-gradient(90deg, #ffffff 50%, #E0ECFE 50%)";
								setStyles(t, e)
							}
							changePosBannerOnResize(), window.addEventListener("resize", changePosBannerOnResize), window.onunload = function() {
								var e = document.documentElement,
									t = _objectSpread({}, posOptionsInitialBanner40);
								window.removeEventListener("resize", changePosBannerOnResize), removeStyles(t, e)
							};
						})()
					</script>
					<script>
						Widget("https://pos.gosuslugi.ru/form", 220820)
					</script>
					<a href="http://dom.gosuslugi.ru" target="_blank" rel="noopener noreferrer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/images/jkh_banner.jpg" alt="">
					</a>
					<iframe id="widgetPosId" src="https://pos.gosuslugi.ru/og/widgets/view?type=[10,30,40]&fontFamily=Arial&maxPage=5&maxElement=2&updateFrequency=5000&level=30&municipality_id=90701000&startTitleColor=000000&startTextColor=666666&startTextBtnColor=FFFFFF&startBtnBgColor=0063B0&widgetBorderColor=e3e8ee&logoColor=ffffff&phoneHeaderColor=0B40B3&fillSvgHeadColor=ffffff&backgroundColor=ffffff&typeBgColor=F2F8FC&selectColor=2c8ecc&hoverSelectColor=116ca6&itemColor=354052&hoverItemColor=2c8ecc&backgroundItemColor=f9f9fa&paginationColor=000000&backgroundPaginationColor=2862AC&hoverPaginationColor=2862AC&deviderColor=e3e8ee&logoFs=16&selectFs=25&itemFs=14&paginationFs=15&widgetBorderFs=1&startTitleFs=38&startTextFs=18&startTextBtnFs=16" width="100%" height="333" style="border:0"></iframe>
				</div>
	</div>
	<? //}
	?>
	</section>
	<!-- end section.news -->
	<!-- begin section.consideration -->
	<section class="section consideration">
		<div class="container">
			<? $APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"consideration_home",
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "ACTIVE_FROM",
						1 => "SHOW_COUNTER",
						2 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "78",
					"IBLOCK_TYPE" => "sidebar_element",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "20",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "DOC_FILE",
						2 => "",
					),
					"SET_BROWSER_TITLE" => "Y",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "Y",
					"SET_META_KEYWORDS" => "Y",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "Y",
					"SHOW_404" => "N",
					"SORT_BY1" => "ID",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"COMPONENT_TEMPLATE" => "consideration_home",
					"STRICT_SECTION_CHECK" => "N",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO"
				),
				false
			); ?>
		</div>
	</section>
	<!-- end section.consideration -->
	<!-- begin section.count_info -->
	<section class="section count_info" style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/img/count_section.jpg');">
		<div class="section_title">
			<h2>Владикавказ в цифрах</h2>
			<p>за 2020 год</p>
		</div>
		<div class="container">
			<? $APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"counter",
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "SHOW_COUNTER",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "104",
					"IBLOCK_TYPE" => "ams",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "3",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "DOC_FILE",
						2 => "",
					),
					"SET_BROWSER_TITLE" => "Y",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "Y",
					"SET_META_KEYWORDS" => "Y",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "Y",
					"SHOW_404" => "N",
					"SORT_BY1" => "ID",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"COMPONENT_TEMPLATE" => "counter",
					"STRICT_SECTION_CHECK" => "N",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
				),
				false
			); ?>
		</div>
	</section>
	<!-- end section.count_info -->
	<!-- begin section.service -->
	<section class="section services">
		<h2 class="section_title">Муниципальные услуги</h2>
		<div class="container">
			<div class="services_list">
				<? $arFilter = array('IBLOCK_ID' => 51, 'GLOBAL_ACTIVE' => 'Y', 'DEPTH_LEVEL' => 1);
				$db_list = CIBlockSection::GetList(array($by => $order), $arFilter, true, $arSelect = array('UF_SVG'));
				while ($ar_result = $db_list->GetNext()) { ?>
					<a class="item" href="/ams/m_uslugi/index.php?SECTION_ID=<?= $ar_result['ID'] ?>">
						<img class="item_media" src="<?= CFile::GetPath($ar_result['UF_SVG']) ?>" alt="">
						<h3 class="item_title"><?= $ar_result['NAME'] ?></h3>
						<!-- <p class="item_description"><?= $ar_result['DESCRIPTION'] ?></p> -->
					</a>
				<? } ?>
			</div>
		</div>
	</section>
	<!-- end section.service -->
	<!-- begin section.useful_link -->
	<section class="section useful_link">
		<h2 class="section_title">Полезные ресурсы</h2>
		<div class="container">
			<? $APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"useful_link",
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "73",
					"IBLOCK_TYPE" => "news",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "20",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "LINK",
						1 => "",
					),
					"SET_BROWSER_TITLE" => "Y",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "Y",
					"SET_META_KEYWORDS" => "Y",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "Y",
					"SHOW_404" => "N",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"COMPONENT_TEMPLATE" => "useful_link",
				),
				false
			); ?>
		</div>
	</section>
	<!-- end section.useful_link -->
<? }
		// is home
?>
<!-- begin content -->
<main <? if (!$GLOBALS["IS_HOME"]) { ?>class="content" <? } ?>>
	<!-- begin container or container-fluid -->
	<div <? if (!$APPLICATION->GetProperty("MAPS") == "Y") { ?> class="container" <? } else { ?>class="container-fluid" <? } ?>>
		<!-- begin row -->
		<div class="row">
			<?
			if (isSectionMenu('left', true, true) and !$GLOBALS["IS_HOME"] and !$APPLICATION->GetProperty("FULL_WIDTH") == "Y") : ?>
				<div class="col-12 col-xl-3">
					<aside id="sidebar">
						<? $APPLICATION->IncludeComponent(
							"bitrix:menu",
							"left_menu",
							array(
								"ALLOW_MULTI_SELECT" => "N",
								"CHILD_MENU_TYPE" => "left",
								"DELAY" => "N",
								"MAX_LEVEL" => "3",
								"MENU_CACHE_GET_VARS" => array(),
								"MENU_CACHE_TIME" => "3600",
								"MENU_CACHE_TYPE" => "N",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"ROOT_MENU_TYPE" => "left",
								"USE_EXT" => "Y",
								"COMPONENT_TEMPLATE" => "left_menu",
							),
							false
						); ?>
					</aside>
				</div>
				<!-- begin #WORK_AREA -->
				<div class="col-12 col-xl-8">
					<?
					// is home
					if (!$GLOBALS["IS_HOME"]) {
					?>
						<h2 class="content_title"><? $APPLICATION->ShowTitle() ?></h2>
						<!-- begin breadcrumbs -->
						<div class="breadcrumb">
							<? $APPLICATION->IncludeComponent(
								"bitrix:breadcrumb",
								"",
								array(
									"PATH" => "",
									"SITE_ID" => "s1",
									"START_FROM" => "0",
								)
							); ?>
						</div>
						<!-- end breadcrumbs -->
					<? } ?>
					<div id="WORK_AREA" <? if ($APPLICATION->GetProperty("WHITE_CONTENT") == "Y") { ?>class="white_content" <? } ?>>
					<? else : ?>
						<!-- begin #WORK_AREA -->
						<div class="col-12 <? if ($APPLICATION->GetProperty("FULL_WIDTH") == "Y") { ?>col-xl-10 offset-xl-1 <? } else { ?>col-xl-12<? } ?><? if ($APPLICATION->GetProperty("WHITE_CONTENT") == "Y") { ?>white_content<? } ?>">
							<?
							// is home
							if (!$GLOBALS["IS_HOME"]) {
							?>
								<!-- begin breadcrumbs -->
								<h2 class="content_title"><? $APPLICATION->ShowTitle() ?></h2>
								<div class="breadcrumb">
									<? $APPLICATION->IncludeComponent(
										"bitrix:breadcrumb",
										"",
										array(
											"PATH" => "",
											"SITE_ID" => "s1",
											"START_FROM" => "0",
										)
									); ?>
								</div>
								<!-- end breadcrumbs -->
							<? } ?>
							<div id="WORK_AREA">
							<? endif; ?>