<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="news-list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?
	switch ($arItem['DISPLAY_PROPERTIES']["APPLICATION_FILE"]['FILE_VALUE']['CONTENT_TYPE']) {
		case 'application/pdf':
		$ICON_PATH = 'fa-file-pdf-o';
		break;
		case 'image/jpeg':
		$ICON_PATH = 'fa-file-image-o';
		break;
		case 'image/png':
		$ICON_PATH = 'fa-file-image-o';  
		break; 
		case 'application/msword':
		$ICON_PATH = 'fa-file-word-o';
		break;
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
		$ICON_PATH = 'fa-file-word-o';
		break;
		case 'application/vnd.ms-excel':
		$ICON_PATH = 'fa-file-excel-o';
		break;   
		case 'application/octet-stream':
		$ICON_PATH = 'fa-file-archive-o'; 
		break;
		case 'application/x-zip-compressed':
		$ICON_PATH = 'fa-file-archive-o'; 
		break;       
	}
	?>
	<div class="doc-item-boby wow slideInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="col-md-1">
			<div class="doc_icon">
				<i class="fa <?=$ICON_PATH;?>" aria-hidden="true"></i>
			</div>
		</div>
		<div class="doc-body">
			<div class="col-md-7">  
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<p class="doc-title"><?echo $arItem["NAME"]?></p>
				<?endif;?>
			</div>
			<div class="col-md-2"> 
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
				<div class="doc-date"><i class="fa fa-calendar"></i> <span><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span></div>
				<?endif?>
			</div>
			<div class="col-md-2">
				<div class="doc_download">
					<? echo '<a href="'.$arItem['DISPLAY_PROPERTIES']["APPLICATION_FILE"]["FILE_VALUE"]["SRC"].'"><? echo $productTitle; ?>Скачать</a> '; ?>
				</div>
			</div>
		</div>
	</div>
	<?endforeach;?>          
</div>   
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>
