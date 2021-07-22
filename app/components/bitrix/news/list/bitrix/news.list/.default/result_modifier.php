<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

foreach ($arResult["ITEMS"] as $i => $arItem) {
    if (!empty($arItem["IBLOCK_SECTION_ID"])) {
        $arSection                             = GetIBlockSection($arItem["IBLOCK_SECTION_ID"]);
        $arResult["ITEMS"][$i]["SECTION_NAME"] = $arSection["NAME"];
    } else {
        $arResult["ITEMS"][$i]["SECTION_NAME"] = "";
    }
}

foreach ($arResult["ITEMS"] as &$arItem) {
    foreach ($arItem["DISPLAY_PROPERTIES"] as $property) {
        if ($property["PROPERTY_TYPE"] === "F") {
            if (is_array($property["DISPLAY_VALUE"])) {
                $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"] = array();
                foreach ($property["FILE_VALUE"] as $value) {
                    $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"][] = "<a href=\"" . $value["SRC"] . "\">" . $value["ORIGINAL_NAME"] . "</a> (" . Bitrix\Gossite\Tools::readableFileSize($value["FILE_SIZE"]) . ")";
                }
            } else {
                $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"] = "<a href=\"" . $property["FILE_VALUE"]["SRC"] . "\">" . $property["FILE_VALUE"]["ORIGINAL_NAME"] . "</a> (" . Bitrix\Gossite\Tools::readableFileSize($property["FILE_VALUE"]["FILE_SIZE"]) . ")";
            }
        }
    }
}