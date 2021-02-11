<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}
?>
<!DOCTYPE html>
<html class="no-js" lang="ru">
<head>
	<meta charset="utf-8">
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta property="og:image" content="path/to/image.jpg">
	<!-- <meta http-equiv="x-pjax-version" content="v1"> -->
	<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/img/favicon/apple-touch-icon-114x114.png">
	<?
	$APPLICATION->ShowHead();
	Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/app.min.css");
	Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/app.min.js");
	Bitrix\Main\Page\Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?apikey=256e028a-94b5-496f-b948-394772dc151a&lang=ru_RU");
	Bitrix\Main\Page\Asset::getInstance()->addJs("https://www.google.com/recaptcha/api.js?render=6Lf3hssZAAAAAK2SOCPR9V8zAbClunlgAlNjYLKT");
	Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/common.js");
	$GLOBALS["IS_HOME"] = $APPLICATION->GetCurPage(true) === SITE_DIR . "index.php";
	CModule::IncludeModule('iblock');
	?>
</head>
<body>
<div class="wrapper" <?if (!$GLOBALS["IS_HOME"]) {?>id="pjax-container"<?}?>>
	<div><?$APPLICATION->ShowPanel();?></div>
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
	<!-- begin top_content  <?//=SITE_TEMPLATE_PATH?>/api/search.php-->
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
							<?$APPLICATION->IncludeComponent("bitrix:menu", "cheif_menu", Array(
								"ALLOW_MULTI_SELECT" => "N", // Разрешить несколько активных пунктов одновременно
								"CHILD_MENU_TYPE" => "left", // Тип меню для остальных уровней
								"DELAY" => "N", // Откладывать выполнение шаблона меню
								"MAX_LEVEL" => "2", // Уровень вложенности меню
								"MENU_CACHE_GET_VARS" => "", // Значимые переменные запроса
								"MENU_CACHE_TIME" => "3600", // Время кеширования (сек.)
								"MENU_CACHE_TYPE" => "N", // Тип кеширования
								"MENU_CACHE_USE_GROUPS" => "Y", // Учитывать права доступа
								"ROOT_MENU_TYPE" => "chief", // Тип меню для первого уровня
								"USE_EXT" => "Y", // Подключать файлы с именами вида .тип_меню.menu_ext.php
								"COMPONENT_TEMPLATE" => "horizontal_multilevel",
							),
								false
							);?>
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
							<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" alt="">
							<p>Администрация местного самоуправления и Собрания представителей г. Владикавказ.</p>
						</a>
					</div>
				</div>
				<div class="col-2 col-xl-8">
					<?$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"top_menu", 
						array(
							"ALLOW_MULTI_SELECT" => "N",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N",
							"MAX_LEVEL" => "2",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"ROOT_MENU_TYPE" => "top",
							"USE_EXT" => "Y",
							"COMPONENT_TEMPLATE" => "top_menu"
						),
						false
					);?>
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
		<div class="container">
			<div class="banner">
				<h2 class="banner_title">Далеко-далеко за словесными горами в стране гласных, и согласных живут.</h2>
				<div class="banner_text">Далеко-далеко, за словесными горами в стране гласных и согласных живут рыбные тексты. Знаках сбить раз всеми, страну злых страна ipsum единственное своего продолжил текст маленький он снова, ведущими подпоясал даже курсивных свой!</div>
				<div class="btn_close"><i class="fa fa-times-circle"></i></div>
			</div>
		</div>
	</section>
	<!-- end section.promo -->
	<!-- begin section.news -->
	<section class="section news">
		<div class="container" style="margin-top: -125px; background-color: #fff; padding: 20px;position: relative;">
			<div class="row">
				<div class="col-12 col-xl-4">
					<?$APPLICATION->IncludeComponent(
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
					);?>
				</div>
				<div class="col-12 col-xl-8">
				<?$APPLICATION->IncludeComponent(
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
							"COMPONENT_TEMPLATE" => "news_home",
						),
						false
					);?>
				</div>
			</div>
		</div>
	</section>
	<!-- end section.news -->
	<!-- begin section.consideration -->
	<section class="section consideration">
		<div class="container">
			<?$APPLICATION->IncludeComponent(
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
						0 => "SHOW_COUNTER",
						1 => "",
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
				),
				false
			);?>
		</div>
	</section>
	<!-- end section.consideration -->
	<!-- begin section.count_info -->
	<section class="section count_info" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/img/count_section.jpg');">
		<h2 class="section_title">Владикавказ в цифрах</h2>
		<div class="container">
			<?$APPLICATION->IncludeComponent(
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
					"COMPOSITE_FRAME_TYPE" => "AUTO"
				),
				false
			);?>
		</div>
	</section>
	<!-- end section.count_info -->
	<!-- begin section.service -->
	<section class="section services">
		<h2 class="section_title">Муниципальные услуги</h2>
		<div class="container">
			<div class="services_list">
				<?$arFilter = Array('IBLOCK_ID' => 51, 'GLOBAL_ACTIVE' => 'Y', 'DEPTH_LEVEL' => 1);
					$db_list = CIBlockSection::GetList(Array($by => $order), $arFilter, true, $arSelect = array('UF_SVG'));
					while ($ar_result = $db_list->GetNext()) {?>
					<a class="item" href="/ams/m_uslugi/index.php?SECTION_ID=<?=$ar_result['ID']?>">
						<img class="item_media" src="<?=CFile::GetPath($ar_result['UF_SVG'])?>" alt="">
						<h3 class="item_title"><?=$ar_result['NAME']?></h3>
						<!-- <p class="item_description"><?=$ar_result['DESCRIPTION']?></p> -->
				</a>
				<?}?>
			</div>
		</div>
	</section>
	<!-- end section.service -->
	<!-- begin section.useful_link -->
	<section class="section useful_link">
		<h2 class="section_title">Полезные ресурсы</h2>
		<div class="container">
			<?$APPLICATION->IncludeComponent(
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
			);?>
		</div>
	</section>
	<!-- end section.useful_link -->
	<?}
		// is home
	?>
	<!-- begin content -->
	<main <?if (!$GLOBALS["IS_HOME"]) {?>class="content"<?}?>>
		<!-- begin container or container-fluid -->
		<div class="container">
			<!-- begin row -->
			<div class="row">
				<?
				if (isSectionMenu('left', true, true) and !$GLOBALS["IS_HOME"] and !$APPLICATION->GetProperty("FULL_WIDTH") == "Y"): ?>
					<div class="col-12 col-xl-3">
						<aside id="sidebar">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"left_menu", 
								array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "left",
									"DELAY" => "N",
									"MAX_LEVEL" => "3",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "N",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "left",
									"USE_EXT" => "Y",
									"COMPONENT_TEMPLATE" => "left_menu"
								),
								false
							);?>
						</aside>
					</div>
					<!-- begin #WORK_AREA -->
					<div class="col-12 col-xl-8">
							<?
							// is home
							if (!$GLOBALS["IS_HOME"]) {
							?>
							<h2 class="content_title"><?$APPLICATION->ShowTitle()?></h2>
							<!-- begin breadcrumbs -->
							<div class="breadcrumb">
									<?$APPLICATION->IncludeComponent(
											"bitrix:breadcrumb",
											"",
											Array(
												"PATH" => "",
												"SITE_ID" => "s1",
												"START_FROM" => "0"
											)
										);?>
									</div>
								<!-- end breadcrumbs -->
								<?}?>
								<div id="WORK_AREA" <?if($APPLICATION->GetProperty("WHITE_CONTENT") == "Y"){?>class="white_content"<?}?>>
				<?else: ?>
					<!-- begin #WORK_AREA -->
					<div class="col-12 <?if($APPLICATION->GetProperty("FULL_WIDTH") == "Y"){?>col-xl-10 offset-xl-1 <?}else{?>col-xl-12<?}?><?if($APPLICATION->GetProperty("WHITE_CONTENT") == "Y"){?>white_content<?}?>">
					<?
					// is home
					if (!$GLOBALS["IS_HOME"]) {
					?>
					<!-- begin breadcrumbs -->
					<h2 class="content_title"><?$APPLICATION->ShowTitle()?></h2>
					<div class="breadcrumb">
						<?$APPLICATION->IncludeComponent(
								"bitrix:breadcrumb",
								"",
								Array(
									"PATH" => "",
									"SITE_ID" => "s1",
									"START_FROM" => "0"
								)
							);?>
						</div>
					<!-- end breadcrumbs -->
						<?}?>
					<div id="WORK_AREA">
				<?endif;?>
