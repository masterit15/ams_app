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
$this->addExternalJS('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
?>

<div class="shop-list">
    <?
$index = 1; // Порядковый номер объекта на карте
foreach($arResult["ITEMS"] as $arItem) { ?>
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
    switch ($arItem['PREVIEW_PICTURE']['SRC']) {
        case true:
        $GLOBALS['OBJECT_IMG_SRC'] = $arItem['PREVIEW_PICTURE']['SRC'];
        break;
        case false:
        $GLOBALS['OBJECT_IMG_SRC'] = "/local/templates/vladikavkaz/images/nto.png";
        break;
    }
    ?>
    <!--Засовываем данные для формирования точки на карте в атрибуты контейнера div-->
    <div class="institution-data" 
    data-index="<?=$index?>" 
    data-name="<?=$arItem["NAME"]?>"
    data-yandex-x="<?=$Yandex_X;?>"
    data-yandex-y="<?=$Yandex_Y;?>"
    data-address="<?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"];?>"
    data-hours="<?=$arItem["PROPERTIES"]["MODE"]["VALUE"];?>"
    data-docs="<?=$GLOBALS['OBJECT_COLOR'];?>"
    data-img="<?=$GLOBALS['OBJECT_IMG_SRC'];?>"
    data-url="<?=$arItem['DETAIL_PAGE_URL'];?>"
    >
        <!-- <ul>
            <li><b>Адрес:</b> <?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"];?></li>
            <li><b>Характеристики:</b> <?=$arItem["PROPERTIES"]["MODE"]["VALUE"];?></li>
            <li><b>Наличие документов:</b> <?=$GLOBALS['OBJECT_COLOR']?></li>
            <li><b>Фотографии:</b> <?$imgArray = &$arItem['DISPLAY_PROPERTIES']['PHOTO'];
            if ( is_array( $imgArray['VALUE'] ) ) {
                $arrFiles = $imgArray['VALUE'];
            } else {
                $arrFiles = array( $imgArray['VALUE'] );
            }
            for ( $i = 0; $i < sizeof($arrFiles); $i++ ) {
                $fileID = $arrFiles[$i];
                $arFileData = CFile::GetFileArray($fileID);
                if ( !empty($arFileData['SRC']) ):?>
                    <?echo '<img class="image-popup" src="'.$arFileData['SRC'].'"/>'?>
                    <?endif;?>
                    <?}?></li>
                </ul> -->
            </div>
            <? ++$index; } unset($index); ?>
            <!--Контейнер в который прилетит сформированная яндекс карта-->
            <div id="map_container"></div>
        </div>
        <script>
$(document).ready(function(){

    //Если на странице есть контейнер для яндекс карты с id map_container, начинаем её формировать
    if($("#map_container").length > 0)  
    {

        //yandex map
        ymaps.ready(function() {
            var map = new ymaps.Map("map_container", {
                center: [43.024270378846325, 44.67674405029294],    //Создаём карту с центром в городе "Ростов-на-Дону"
                zoom: 12,   //Увеличение 11
                controls: ['zoomControl',  'fullscreenControl'] // 'searchControl',
            },{
                searchControlProvider: 'yandex#search'
            });

                //Кластера - группируем близко расположенные друг к другу объекты, чтобы при отдалении карты появлялась другая иконка
                // с количеством объектов в данной точке 
                var ClusterContent = ymaps.templateLayoutFactory.createClass('<div class="claster" ><span>$[properties.geoObjects.length]</span></div>');

                //Параметры иконки кластера, обычно её делают отличной от точки, чтобы пользователь не путал номер объекта
                // и количество объектов

                var clusterIcons=[{
                    href: '/local/templates/vladikavkaz/images/map-claster.png',
                    size:[58, 80],
                    offset:[-24, -80],

                }];

                //Создание самого кластера
                myClusterer = new ymaps.Clusterer({
                    clusterIcons: clusterIcons,
                    clusterNumbers:[1],
                    zoomMargin: [30],
                    clusterIconContentLayout: ClusterContent,
                });

            //HTML шаблон балуна, того самого всплывающего блока, который появляется при щелчке на карту
            var myBalloonLayout = ymaps.templateLayoutFactory.createClass(
                '<div class="row"><p class="object-title"><strong>$[properties.name]</strong></p>'+
                '<div class="col-sm-5">'+
                '<img class="object-img" src="$[properties.img]" alt="" />'+
                '</div>'+
                '<address class="col-sm-7 address-map" >'+
                '<ul class="balloon-info" >'+
                '<li><strong>Адрес:&nbsp;</strong>$[properties.address]</li>'+
                '<li><strong>Характеристики:&nbsp;</strong>$[properties.manager]</li>'+
                '</ul>'+
                '</address><a class="object-detail" href="$[properties.url]">Подробнее</a></div>'
                );

                var Placemark = {}; //Пустой объекта, куда будут помещены точки на для карты
                
                //Перебираем все блоки с картой и считываем данные для формирования точки и балуна по ранее заданному шаблону
                $(".institution-data").each(function(){

                    //Координаты точки
                    var X = $(this).attr("data-yandex-x");
                    var Y = $(this).attr("data-yandex-y");
                    var color = $(this).attr("data-docs");
                    Obj = $(this).attr("pointindex");

                        //Создаём объект с заданными координатами и доп.свойствами
                        Placemark[Obj] = new ymaps.Placemark([X,Y], {
                            name:       $(this).attr("data-name"),    //Наименование магазина
                            address:    $(this).attr("data-address"),  //Адрес
                            hours:      $(this).attr("data-hours"),  //Часы работы
                            img:        $(this).attr("data-img"),  //Контактный телефон
                            manager:    $(this).attr("data-manager"),  //Руководитель
                            docs:       $(this).attr("data-docs"),  //наличие документов
                            url:        $(this).attr("data-url"), // страница детального просмотра
                        iconContent: "<div class='marker-circ'></div>", //Порядковый номер на карте <span>"+$(this).attr("data-index")+"</span><i class='fa fa-hospital-o'></i>
                    },{ //Ниже некоторые параметры точки и балуна
                        balloonContentLayout: myBalloonLayout,  
                        balloonOffset: [5,0],
                        balloonCloseButton: true,
                        balloonMinWidth: 450,
                        balloonMaxWidth:450,
                        balloonMinHeught:150,
                        balloonMaxHeught:200,
                        iconImageHref: '/local/templates/vladikavkaz/images/'+color+'.png',   //Путь к картинке точки
                        iconImageSize: [58, 80],
                        iconImageOffset: [-24, -80],
                        iconLayout: 'default#imageWithContent',
                        iconactive: '/local/templates/vladikavkaz/images/map-a.png' //Путь к картинке точки при наведении курсора мыши
                    });
                    //Добавляем маркер (точку) через кластер
                    myClusterer.add(Placemark[Obj]);
                });
                //Добавление кластеры на карту
                map.geoObjects.add(myClusterer); 
                //Запрещаем изменение размеров карты по скролу мыши
                map.behaviors.disable("scrollZoom");
            });
       
}
});
</script>
