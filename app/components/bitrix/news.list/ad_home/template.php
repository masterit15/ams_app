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
<div class="news_head">
	<h3>Объявления</h3>
	<a href="/news/actual/">Все объявления <i class="fa fa-angle-right"></i></a>
</div>
<ul class="actual_list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li title="<?echo $arItem["NAME"];?>" data-toggle="tooltip" data-placement="right" class="actual_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">	
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]){?>
				<div class="actual_date">
				<?=CIBlockFormatProperties::DateFormat("j F Y в H:i", MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()))?>
				</div>
			<?}?>																	
			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){?>
				<h3 class="actual_title"><?if(mb_strlen($arItem["NAME"],'UTF-8') > 80){ echo mb_strimwidth($arItem["NAME"], 0, 80, "..."); }else{ echo$arItem["NAME"]; }?></h3>
			<?}?>
		</a>
	</li>
	<?endforeach;?>
</ul>