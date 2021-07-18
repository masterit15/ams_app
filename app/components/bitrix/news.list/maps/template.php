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
$ips = array();
?>

<div class="shop-list">
<div class="action"></div>
	<?
	$index = 1; // Порядковый номер объекта на карте
	foreach ($arResult["ITEMS"] as $arItem) { ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<?
		$arCoords = $arItem['PROPERTIES']['OBJECT_COORDINAT']['VALUE'];
		//Разбиваем координаты яндекс карты на X и Y координату
		$Yandex = explode(",", $arCoords);
		$Yandex_X = $Yandex[0];
		$Yandex_Y = $Yandex[1];

		?>
		<?
		switch ($arItem["PROPERTIES"]["DOCS"]["VALUE"]) {
			case 'ДА':
				$GLOBALS['OBJECT_COLOR'] = "map-green";
				break;
			case 'НЕТ':
				$GLOBALS['OBJECT_COLOR'] = "map-red";
				break;
		}
		?>
		<!--Засовываем данные для формирования точки на карте в атрибуты контейнера div-->
		<div class="institution-data" 
			data-id="<?= $arItem['ID'] ?>"
			data-index="<?= $index ?>"
			data-name="<?= $arItem["NAME"] ?>"
			data-yandex-x="<?= $Yandex_X; ?>"
			data-yandex-y="<?= $Yandex_Y; ?>"
			data-count="<?= $arItem["PROPERTIES"]["COUNT"]["VALUE"]; ?>"
			data-address="<?= $arItem["PROPERTIES"]["ADDRESS"]["VALUE"]; ?>"
			data-yes="<?= $arItem["PROPERTIES"]["YES"]["VALUE"]; ?>"
			data-no="<?= $arItem["PROPERTIES"]["NO"]["VALUE"]; ?>">
		</div>
	<? 
	$ips[] = explode(',', $arItem["PROPERTIES"]['IP_ADDRESS']['VALUE']);
	++$index;
	}
	unset($index); ?>
	<!--Контейнер в который прилетит сформированная яндекс карта-->
	<div id="map_container"></div>
</div>
<?
$ipArr = walkArr($ips);
if(in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
	$isVote = false;
}else{
	$isVote = true;
}
?>
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
					href: '/bitrix/templates/app/images/map_claster.png',
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
					`<div class="ballon_content"><p class="ballon_content_title"><strong>$[properties.name]</strong></p>
						<ul class="ballon_content_info" >
							<li><strong>Адрес:&nbsp;</strong>$[properties.address]</li>
							<li><strong>Обшее количество голосоваших:&nbsp;</strong><span class="total">$[properties.count]</span></li>
							<li><strong>За:&nbsp;</strong><span class="y">$[properties.yes]</span></li>
							<li><strong>Против:&nbsp;</strong><span class="n">$[properties.no]</span></li>
						</ul>
						<?if($isVote){?>
						<div class="ballon_content_action">
							<button id="yes" data-id="$[properties.id]" data-val="y"><i class="fa fa-thumbs-o-up"></i> За</button>
							<button id="no" data-id="$[properties.id]" data-val="n">Против <i class="fa fa-thumbs-o-down"></i></button>
						</div>
						<?}else{?>
							<div class="ballon_content_action">
								<h4>Вы уже голосовали</h4>
							</div>
						<?}?>
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
						id: $(this).attr("data-id"), //Наименование магазина
						name: $(this).attr("data-name"), //Наименование магазина
						address: $(this).attr("data-address"), //Адрес
						count: $(this).attr("data-count"), //наличие документов
						yes: $(this).attr("data-yes"), // страница детального просмотра
						no: $(this).attr("data-no"), // страница детального просмотра
						iconContent: "<div class='marker-circ'></div>", //Порядковый номер на карте <span>"+$(this).attr("data-index")+"</span>

					}, { //Ниже некоторые параметры точки и балуна
						balloonContentLayout: myBalloonLayout,
						balloonOffset: [5, 0],
						balloonCloseButton: true,
						balloonMinWidth: 450,
						balloonMaxWidth: 450,
						balloonMinHeught: 150,
						balloonMaxHeught: 200,
						iconImageHref: '/bitrix/templates/app/images/map_ballon.png', //Путь к картинке точки
						iconImageSize: [50, 70],
						iconImageOffset: [-24, -80],
						iconLayout: 'default#imageWithContent',
						iconactive: '/bitrix/templates/app/images/map_ballon.png' //Путь к картинке точки при наведении курсора мыши
					});
					//Добавляем маркер (точку) через кластер
					myClusterer.add(Placemark[Obj]);
				});

				//Добавление кластеры на карту
				map.geoObjects.add(myClusterer);
				//Запрещаем изменение размеров карты по скролу мыши
				map.behaviors.disable("scrollZoom");

				// Слушаем клик на карте.
				<?if($isVote){?>
					map.events.add('click', function(e) {
						let coords = e.get('coords');
						
						// Если метка уже создана – просто передвигаем ее.
						if (myPlacemark) {
								myPlacemark.geometry.setCoordinates(coords);
								getAddress(coords);
						}
						// Если нет – создаем.
						else {
								myPlacemark = createPlacemark(coords);
								map.geoObjects.add(myPlacemark);
								// Слушаем событие окончания перетаскивания на метке.
								myPlacemark.events.add('dragend', function() {
									getAddress(myPlacemark.geometry.getCoordinates());
								});
								getAddress(coords);
						}
					});
				<?}?>

				// Создание метки.
				function createPlacemark(coords) {
					return new ymaps.Placemark(coords, {
						iconCaption: 'поиск...'
					}, {
						preset: 'islands#violetDotIconWithCaption',
						draggable: true
					});
				}

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
					// console.log(res);
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