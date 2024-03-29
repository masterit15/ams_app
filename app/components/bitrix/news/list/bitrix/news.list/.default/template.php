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
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<a class="news-item" href="<?echo $arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if ($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])) {?>
				<div class="news-media" style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>);" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"></div>
			<?} else {?>
				<div class="news-media" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/no_image.png);" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"></div>
			<?}?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<span class="news-datetime">
				<?$date = explode('.', $arItem["DISPLAY_ACTIVE_FROM"]);
				echo $date[0].'<br>'.$date[1].'<br>'.$date[2];
				?>
			</span>
		<?endif?>
		<div class="news-content">
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<h3><?echo $arItem["NAME"]?></h3>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>
		<div class="news_info">
				<i class="fa fa-eye"></i>
				<span title="Количество просмотров: <?=$arItem['SHOW_COUNTER'];?>"
					data-toggle="tooltip" data-placement="top"><?=$arItem['SHOW_COUNTER'];?></span>
			</div>
		</div>
	</a>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
