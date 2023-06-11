<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=256e028a-94b5-496f-b948-394772dc151a&lang=ru_RU');
$ajaxPage = "/bitrix/templates/app/components/bitrix/news.list/maps/ajax.php";
?>

<div class="shop-list">
<div class="action"></div>
	<?
	$index = 1; // Порядковый номер объекта на карте
	foreach ($arResult["ITEMS"] as $arItem) { 
		// PR($arItem['DETAIL_PAGE_URr']);
		?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<?
		$arCoords = $arItem['PROPERTIES']['OBJECT_COORDS']['VALUE'];
		//Разбиваем координаты яндекс карты на X и Y координату
		$Yandex = explode(",", $arCoords);
		$Yandex_X = $Yandex[0];
		$Yandex_Y = $Yandex[1];
		$file = $arItem["PROPERTIES"]["IMAGES_MORE"]["VALUE"][0] ? getFileArr($arItem["PROPERTIES"]["IMAGES_MORE"]["VALUE"][0])['path'] : '/bitrix/templates/app/images/map-stroi.png';
		?>
		<!--Засовываем данные для формирования точки на карте в атрибуты контейнера div-->
		<div class="institution-data" 
			data-id="<?= $arItem['ID'] ?>"
			data-index="<?= $index ?>"
			data-name="<?= $arItem["NAME"] ?>"
			data-yandex-x="<?= $Yandex_X; ?>"
			data-yandex-y="<?= $Yandex_Y; ?>"
			data-text="<?= $arItem["PREVIEW_TEXT"]; ?>"
			data-coords="<?= $arItem["PROPERTIES"]["OBJECT_COORDS"]["VALUE"]; ?>"
			data-floors="<?= $arItem["PROPERTIES"]["OBJECT_FLOORS"]["VALUE"]; ?>"
			data-function="<?= $arItem["PROPERTIES"]["OBJECT_FUNCTION"]["VALUE"]; ?>"
			data-violations="<?= $arItem["PROPERTIES"]["OBJECT_VIOLATIONS"]["VALUE"]; ?>"
			data-square="<?= $arItem["PROPERTIES"]["OBJECT_SQUARE"]["VALUE"]; ?>"
			data-date-verification="<?= $arItem["PROPERTIES"]["OBJECT_DATE_OF_VERIFICATION"]["VALUE"]; ?>"
			data-address="<?= $arItem["PROPERTIES"]["OBJECT_ADDRESS"]["VALUE"]; ?>"
			data-img="<?=$file?>"
			data-url="<?=$arItem['DETAIL_PAGE_URL']?>"
			>
		</div>
	<? 
	$ips[] = explode(',', $arItem["PROPERTIES"]['IP_ADDRESS']['VALUE']);
	++$index;
	}
	unset($index); ?>
	<!--Контейнер в который прилетит сформированная яндекс карта-->
	<div id="map_container"></div>
</div>
<script>
	$(document).ready(function() {
		//Если на странице есть контейнер для яндекс карты с id map_container, начинаем её формировать
		if ($("#map_container").length > 0) {
			//yandex map
			ymaps.ready(function() {
				var myPlacemark,
					map = new ymaps.Map("map_container", {
						center: [43.024270378846325, 44.67674405029294], //Создаём карту с центром в городе "Ростов-на-Дону"
						zoom: 13, //Увеличение 11
						controls: ['zoomControl', 'fullscreenControl'] //'searchControl',
					}, {
						searchControlProvider: 'yandex#search'
					});
				//Кластера - группируем близко расположенные друг к другу объекты, чтобы при отдалении карты появлялась другая иконка
				// с количеством объектов в данной точке 
				var ClusterContent = ymaps.templateLayoutFactory.createClass('<div class="claster" ><span>$[properties.geoObjects.length]</span></div>');
				//Параметры иконки кластера, обычно её делают отличной от точки, чтобы пользователь не путал номер объекта
				// и количество объектов
				var clusterIcons = [{
					href: '/bitrix/templates/app/images/map-claster-stroi.png',
					size: [58, 80],
					offset: [-24, -80],
				}];
				//Создание самого кластера
				myClusterer = new ymaps.Clusterer({
					clusterIcons: clusterIcons,
					clusterNumbers: [1],
					zoomMargin: [30],
					clusterIconContentLayout: ClusterContent,
				});
				//HTML шаблон балуна, того самого всплывающего блока, который появляется при щелчке на карту
				var myBalloonLayout = ymaps.templateLayoutFactory.createClass(
					`<div class="ballon">
						<div class="ballon_media" style="background-image: url($[properties.img])"></div>
						<div class="ballon_content">
							<p class="ballon_content_title"><strong>$[properties.name]</strong></p>
							<ul class="ballon_content_info" >
								<li><strong>Адрес:</strong> $[properties.address]</li>
								<li><strong>Дата Акта проверки з/у:</strong> $[properties.dateVerification]</li>
								<li><strong>Выявленое нарушения:</strong> $[properties.violations]</li>
								<li><strong>Функциональное назначение:</strong> $[properties.function] </li>
								<li><strong>Этажность (кол-во этажей):</strong> $[properties.floors]</li>
								<li><strong>Площадь застройки (кв.м):</strong> $[properties.square]</li>
								<li><strong><a href="$[properties.url]">Подробнее</a></strong></li>
							</ul>
						</div>
					</div>`,
					{
						build: function () {
							myBalloonLayout.superclass.build.call(this);
							$('button[data-val]').on('click', function(){
								
								let data = {
									elid: $(this).data('id'),
									action: "vote",
									ip_address: "<?=$_SERVER['REMOTE_ADDR']?>",
									vote: $(this).data('val')
								};
								let spanT = $(`span.total`)
								let span = $(`span.${$(this).data('val')}`)
								$(spanT).text(Number($(spanT).text()) + 1)
								$(span).text(Number($(span).text()) + 1)
								let res = actionAjax(data)
								$(this).parent().html(`<div style="width: 100%;text-align: center;">
								<h4>Ваш голос принят!</h4>
								<p>Спасибо за участие в голосовании!</p>
								</div>`)
							});
						},
					}
				);
				var Placemark = {}; //Пустой объекта, куда будут помещены точки на для карты
				//Перебираем все блоки с картой и считываем данные для формирования точки и балуна по ранее заданному шаблону
				$(".institution-data").each(function() {
					//Координаты точки
					var X = $(this).attr("data-yandex-x");
					var Y = $(this).attr("data-yandex-y");
					Obj = $(this).attr("pointindex");
					//Создаём объект с заданными координатами и доп.свойствами
					Placemark[Obj] = new ymaps.Placemark([X, Y], {
						id: $(this).attr("data-id"),
						img: $(this).attr("data-img"),
						name: $(this).attr("data-name"),
						text: $(this).attr("data-text"),
						coords: $(this).attr("data-coords"),
						floors: $(this).attr("data-floors"),
						function: $(this).attr("data-function"),
						violations: $(this).attr("data-violations"),
						square: $(this).attr("data-square"),
						dateVerification: $(this).attr("date-verification"),
						address: $(this).attr("data-address"),
						url: $(this).attr("data-url"),
						iconContent: "<div class='marker-circ'></div>",
					}, { //Ниже некоторые параметры точки и балуна
						balloonContentLayout: myBalloonLayout,
						balloonOffset: [5, 0],
						balloonCloseButton: true,
						balloonMinWidth: 450,
						balloonMaxWidth: 450,
						balloonMinHeught: 150,
						balloonMaxHeught: 200,
						iconImageHref: '/bitrix/templates/app/images/map-stroi.png', //Путь к картинке точки
						iconImageSize: [50, 70],
						iconImageOffset: [-24, -80],
						iconLayout: 'default#imageWithContent',
						iconactive: '/bitrix/templates/app/images/map-stroi.png' //Путь к картинке точки при наведении курсора мыши
					});
					//Добавляем маркер (точку) через кластер
					myClusterer.add(Placemark[Obj]);
				});
				//Добавление кластеры на карту
				map.geoObjects.add(myClusterer);
				//Запрещаем изменение размеров карты по скролу мыши
				map.behaviors.disable("scrollZoom");
				// Определяем адрес по координатам (обратное геокодирование).
				function getAddress(coords) {
					myPlacemark.properties.set('iconCaption', 'поиск...');
					ymaps.geocode(coords).then(function(res) {
						let firstGeoObject = res.geoObjects.get(0);
						myPlacemark.properties
							.set({
								// Формируем строку с данными об объекте.
								iconCaption: [
									// Название населенного пункта или вышестоящее административно-территориальное образование.
									firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
									// Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
									firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
								].filter(Boolean).join(', '),
								// В качестве контента балуна задаем строку с адресом объекта.
								balloonContent: firstGeoObject.getAddressLine()
							});
							$('.action').addClass('active').html(`${firstGeoObject.getAddressLine()} <div class="action_btn"><button class="add">Добавить адрес</button> <button class="cancel">Отмена</button></div>`)
							$('.action button.add').on('click', function(){
								let data = {
									action: "add",
									ip_address: "<?=$_SERVER['REMOTE_ADDR']?>",
									address: firstGeoObject.getAddressLine(),
									coords: coords.toString()
								};
								actionAjax(data)
								setTimeout(()=>{
									document.location.reload();
								}, 300)
							})
							$('.action button.cancel').on('click', function(){
								$('.action').removeClass('active')
								
								map.geoObjects.remove(myPlacemark);
								myPlacemark = null
							})
					});
				}
			});
		}
		function actionAjax(data){
			let ajaxresult = {}
			return $.ajax({
				method: "POST",
				url: "<?= $ajaxPage; ?>",
				data: data,
				success: function(res) {
					if(res.success){
						ajaxresult.title = res.title
						ajaxresult.desc = res.desc
						return ajaxresult
					}
				},
				error: function(res) {
					$(".results").attr("data-status", "error").text('Ошибка отправки, попробуйте презагрузить страницу');
				}
				
			})
			return ajaxresult
		}
	});
</script>