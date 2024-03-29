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
<h2 class="section_title">к сведению жителей города</h2>
<div class="row">
	<div class="doc_list" data-amount="4" data-url="/consideration/">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$file = getFileArr($arItem['DISPLAY_PROPERTIES']["APPLICATION_FILE"]['FILE_VALUE']['ID']);
		$link = $arItem['PROPERTIES']["LINK"]['VALUE'];
		?>

		<div class="doc_item item" title="<?=$arItem['NAME']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	 <a href="<?=$link ? $link : $file['path']?>" <?if(!$link){?>download<?}?>>					
	 	<span class="doc_icon">
		 <?=$link? '<i class="fa fa-external-link"></i>' : $file['icon']?>
		</span>				
		<div class="doc_detail">			
    <div class="doc_title">
			<?echo $arItem['NAME'] ? $arItem['NAME'] : $file['name'];?>
		</div>
		<span class="doc_date"><?echo $arItem['ACTIVE_FROM'] ? $arItem['ACTIVE_FROM'] : $file['size'];?></span>
		</div>
    <span class="doc_size"><?=$file['size']?></span>
  </a>
  </div>
		<?endforeach;?>
		<button class="show_more">Раскрыть <i class="fa fa-chevron-down"></i></button>
	</div>
</div>