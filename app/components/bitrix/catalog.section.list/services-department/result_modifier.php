<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock")) {
    return;
}

if ($arResult["SECTIONS"]) {
    foreach ($arResult["SECTIONS"] as $key => $arSection) {
        $arFilter = Array(
            "IBLOCK_ID"    => $arParams['IBLOCK_ID'],
            "ACTIVE_DATE"  => "Y",
            "ACTIVE"       => "Y",
            "PROPERTY_FOR" => $arParams['~PROPERTY_FOR'],
            "SECTION_ID"   => $arSection['ID']
        );
        $rs       = CIBlockElement::GetList(Array(), $arFilter, false, array("nTopCount" => 1), array("ID"));
        if ($rs->SelectedRowsCount() == 0) {
            unset($arResult["SECTIONS"][$key]);
        }
    }
}