<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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

$strTitle      = "";
$TOP_DEPTH     = $arResult["SECTION"]["DEPTH_LEVEL"];
$CURRENT_DEPTH = $TOP_DEPTH;

foreach ($arResult["SECTIONS"] as $arSection)
{
    if ($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"]) {
        echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH), "<ul class=\"arrow-list\">";
    } elseif ($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"]) {
        echo "</li>";
    } else {
        while ($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"]) {
            echo "</li>";
            echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</ul>", "\n", str_repeat("\t",
                $CURRENT_DEPTH - $TOP_DEPTH - 1);
            $CURRENT_DEPTH--;
        }
        echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</li>";
    }

    $count = $arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? "&nbsp;(" . $arSection["ELEMENT_CNT"] . ")" : "";

    if ($_REQUEST['SECTION_ID'] == $arSection['ID']) {
        $link     = '<b>' . $arSection["NAME"] . $count . '</b>';
        $strTitle = $arSection["NAME"];
    } else {
        $link = '<a href="' . $arSection["SECTION_PAGE_URL"] . '">' . $arSection["NAME"] . $count . '</a>';
    }

    echo "\n", str_repeat("\t", $arSection["DEPTH_LEVEL"] - $TOP_DEPTH);
    ?>
    <li class="col col-mb-12 col-6 equal"><?= $link ?><?

    $CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
}

while ($CURRENT_DEPTH > $TOP_DEPTH) {
    echo "</li>";
    echo "\n", str_repeat("\t", $CURRENT_DEPTH - $TOP_DEPTH), "</ul>", "\n", str_repeat("\t",
        $CURRENT_DEPTH - $TOP_DEPTH - 1);
    $CURRENT_DEPTH--;
}
?>
<?= ($strTitle ? '<br/><h2>' . $strTitle . '</h2>' : '') ?>
