<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="document_list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<?//PR($arItem)?>
		<div class="doc_item item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<a target="_blank" href="<?=$arItem['DISPLAY_PROPERTIES']["FILE"]['FILE_VALUE']["SRC"];?>" download>
				<div class="doc_title"><?=$arItem["NAME"]?></div>
				<div class="doc_info">
				<span class="date"><?=$arItem['TIMESTAMP_X']?></span>
				<span class="size">
					<?=CFile::FormatSize($arItem['DISPLAY_PROPERTIES']["FILE"]['FILE_VALUE']['FILE_SIZE'])?>
				</span>
				<span class="icon">
					<?
					$fileType = explode(".", $arItem['DISPLAY_PROPERTIES']["FILE"]['FILE_VALUE']["FILE_NAME"])[1];
					switch ($fileType) {
						case 'pdf':
						case 'PDF':
						$ICON = 'fa-file-pdf-o';
						break;
						case 'jpeg':
						case 'png':
						case 'jpg':
						case 'tif':
						$ICON = 'fa-file-image-o';
						break;
						case 'doc':
						case 'docx':
						$ICON = 'fa-file-word-o';
						break;
						case 'xls':
						case 'xlsx':
						$ICON = 'fa-file-excel-o';
						break;     
						case 'zip':
						case '7zip':
						case 'rar':
						$ICON = 'fa-file-archive-o'; 
						break;       
					}
					?>
					<i class="fa <?=$ICON?>"></i>
				</span>
				</div>
			</a>
		</div>
	<?endforeach;?>          
</div>   
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>
