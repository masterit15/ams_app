<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSectionsNames = array();
if (!empty($arResult["IBLOCK_SECTION_ID"])) {
    $arSection                = GetIBlockSection($arResult["IBLOCK_SECTION_ID"]);
    $arResult["SECTION_NAME"] = $arSection["NAME"];
} else {
    $arResult["SECTION_NAME"] = "";
}

$dbVideo = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], array("sort" => "asc"),
    Array("CODE" => "VIDEO"));
$arVideo = $dbVideo->GetNext();

if (!empty($arVideo['VALUE'])) {
    $arVideo = GetIBlockElement($arVideo['VALUE']);

    if (!empty($arVideo['PROPERTIES']['FILE']['VALUE'])) {
        $arResult['MEDIA_VIDEO'] = $arVideo['PROPERTIES']['FILE']['VALUE'];
    }
}

$dbPhoto = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], array("sort" => "asc"),
    Array("CODE" => "PHOTOGALLERY"));
$arPhoto = $dbPhoto->GetNext();

if (!empty($arPhoto['VALUE'])) {
    $arPhoto = GetIBlockSection($arPhoto['VALUE']);

    if (!empty($arPhoto['ID'])) {
        $arResult['MEDIA_PHOTO']        = $arPhoto['ID'];
        $arResult['MEDIA_PHOTO_IBLOCK'] = $arPhoto['IBLOCK_ID'];
        $arResult['MEDIA_PHOTO_URL']    = $arPhoto['LIST_PAGE_URL'];
    }
}


$arResult["BACK_BTN_TITLE"] = str_replace("[".SITE_ID."]", "", $arResult["IBLOCK"]['NAME']);