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
<div class="useful_link_list" data-amount="8" data-url="/useful_link/">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<a href="<?=$arItem["PROPERTIES"]['LINK']['VALUE']?>" class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" target="_blank">
			<div class="item_icon"><i class="fa fa-external-link"></i></div>
			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
					<div class="item_title"><?echo $arItem["NAME"]?></div>
			<?endif;?>
		</a>
	<?endforeach;?>
	<button class="show_more">Раскрыть <i class="fa fa-chevron-down"></i></button>
</div>
