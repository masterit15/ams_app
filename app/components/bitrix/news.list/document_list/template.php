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
<div class="row">
	<div class="doc_list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		
		$file = getFileArr($arItem['DISPLAY_PROPERTIES']["DOC_FILE"]['FILE_VALUE']['ID']);
		?>

		<div class="doc_item item" title="<?=$arItem['NAME']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	 <a href="<?=$file['path']?>" download>					
	 	<span class="doc_icon">
      <?=$file['icon']?>
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
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]){?>
		<?=$arResult["NAV_STRING"]?>
	<?}?>
</div>