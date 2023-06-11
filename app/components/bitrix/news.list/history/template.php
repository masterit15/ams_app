<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<div class="history_list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
<div class="history_item">
	<div class="history_item_media popup-gallery">
		<a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
			<img
			src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
			width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
			height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			/>
		</a>
	</div>
	<div class="history_item_text">
		<h4><?echo $arItem["NAME"]?></h4></br>
		<?echo $arItem["PREVIEW_TEXT"];?></br></br>
		<?if($arItem["PROPERTIES"]['AUTOR']['VALUE']){?>
			<b>Автор(ы): <?echo $arItem["PROPERTIES"]['AUTOR']['VALUE']?></b>
		<?}?>
	</div>
</div>
<hr>

<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
