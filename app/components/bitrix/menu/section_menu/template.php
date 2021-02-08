<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))return;
?>
<ul class="section_menu">
<?
$previousLevel = 0;
$firstRoot = false;
foreach($arResult as $itemIdex => $arItem):?>

<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
    <?=str_repeat("     </ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
<?endif?>

<?if ($arItem["IS_PARENT"]):?>
    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
    <li class="<?if ($arItem["SELECTED"]):?><?else:?>parent<?endif?> list"><span><?=$arItem["TEXT"]?></span>
        <ul class="items">
    <?else:?>
    <li class="list"><span><?=$arItem["TEXT"]?></span>
        <ul class="items">
    <?endif?>
<?else:?>
    <?if ($arItem["PERMISSION"] > "D"):?>
        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
        <li class="<?if ($arItem["SELECTED"]):?><?else:?>parent<?endif?> deep1"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>parent-selected<?else:?>parent<?endif?>"><?=$arItem["TEXT"]?></a></li>
        <?else:
            $class = "";
            if ($arItem["SELECTED"])
                $class .= "item-selected";

            if (!isset($arResult[$itemIdex+1]) || (isset($arResult[$itemIdex+1]) && $arResult[$itemIdex+1]["DEPTH_LEVEL"] != $arResult[$itemIdex]["DEPTH_LEVEL"]))
                $class .= " item-last";

            if (strlen($class) > 0)
                $class = ' class="'.$class.'"';
        ?>
            <li  class="parent_deep"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
        <?endif?>
    <?else:?>
        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
        <li class="<?if ($arItem["SELECTED"]):?><?else:?>parent<?endif?> deep2"><a href="" class="<?if ($arItem["SELECTED"]):?>parent-selected<?else:?>parent<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
        <?else:?>
        <li><a href=""  title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li><?endif?>
    <?endif?>
<?endif;

    $previousLevel = $arItem["DEPTH_LEVEL"];
    if ($arItem["DEPTH_LEVEL"] == 1)
        $firstRoot = true;
?>
<?endforeach;

if ($previousLevel > 1)
    echo str_repeat("</ul></li>", ($previousLevel-1));
?>
</ul>
<div class="menu-clear-left"></div>