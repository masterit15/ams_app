<?
foreach($arResult["SECTIONS"] as &$arSection)
{
    $arSection["SECTION_PAGE_URL"] = $arSection["LIST_PAGE_URL"] . "?cat=s" . $arSection["ID"];
}
?>