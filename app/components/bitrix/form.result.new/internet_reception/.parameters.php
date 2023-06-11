<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-" => " "));

$arIBlocks = Array();
$db_iblock = CIBlock::GetList(Array("SORT" => "ASC"), Array("SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while ($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = $arRes["NAME"];


$arTemplateParameters = array(
        "IBLOCK_TYPE"               => Array(
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
            "TYPE"    => "LIST",
            "VALUES"  => $arTypesEx,
            "DEFAULT" => "",
            "REFRESH" => "Y",
        ),
        "IBLOCK_THEMES"                 => Array(
            "PARENT"            => "BASE",
            "NAME"              => GetMessage("T_IBLOCK_DESC_THEMES"),
            "TYPE"              => "LIST",
            "VALUES"            => $arIBlocks,
            "DEFAULT"           => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH"           => "Y",
        ),
);

?><?
if (class_exists('Bitrix\Main\UserConsent\Agreement')) {
    $arTemplateParameters = array(
        "USER_CONSENT" => array(),
    );
}
?>