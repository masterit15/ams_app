<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="document_list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<?$file = getFileArr($arItem['DISPLAY_PROPERTIES']["APPLICATION_FILE"]['FILE_VALUE']['ID']);?>
		<div class="doc_item item" title="<?=$doc['NAME']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<a no-data-pjax href="<?=$file['path']?>" <?if($file['type'] != 'pdf'){?>download<?}?>>				
	 	<span class="doc_icon">
      <?=$file['icon']?>
		</span>				
		<div class="doc_detail">			
    <div class="doc_title">
			<?
			if($arItem['DISPLAY_PROPERTIES']["FILE_NAME"]['VALUE']){
				echo $arItem['DISPLAY_PROPERTIES']["FILE_NAME"]['VALUE'];
			}elseif($arItem['NAME'] and $arItem['NAME'] != '-'){
				echo $arItem['NAME'];
			}else{
				echo $file['name'];
			}
			?>
		</div>
		<span class="doc_date"><?=$arItem['DATE_CREATE']?></span>
		</div>
    <span class="doc_size"><?=$file['size']?></span>
  </a>
  </div>
	<?endforeach;?>          
</div>   
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>
