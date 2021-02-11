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
<div id="numbers">
	<div class="row">
		<?
		$index = 0;
		foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			// PR($arItem["PROPERTIES"]["COUNT"]["VALUE"]);
			?>
			<div class="col-12 col-xl-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="num_item" data-target="<?=$index?>" data-start="0" data-end="<?=$arItem["PROPERTIES"]["COUNT"]["VALUE"]?>">
					<div class="count">0</div>
					<h3><?=$arItem["NAME"]?></h3>
				</div>
			</div>
		<?
	$index++;
	endforeach;?>
	</div>
</div>