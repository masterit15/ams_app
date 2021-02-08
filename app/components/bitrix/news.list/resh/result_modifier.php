<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as $i => $arItem) {
  if (!empty($arItem["IBLOCK_SECTION_ID"])) {
    $arSection = GetIBlockSection($arItem["IBLOCK_SECTION_ID"]);
    $arResult["ITEMS"][$i]["SECTION_NAME"] = $arSection["NAME"];
  }
  else {
    $arResult["ITEMS"][$i]["SECTION_NAME"] = "";
  }
}
