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
function ConvertedPDF($value)
{
	$pdfbx = $value;
	$pdfsrc = explode('.', $pdfbx);
	// $pdf = $_SERVER['DOCUMENT_ROOT']."".$pdfsrc[0].".pdf[0]";
	$pdf = $_SERVER['DOCUMENT_ROOT']."".$pdfsrc[0]."."."$pdfsrc[1]"."[0]";
	$save_to  = $_SERVER['DOCUMENT_ROOT']."".$pdfsrc[0].".jpg";
	if (file_exists($save_to)) {?>
		<?}else{?>
			<?php
			$imagick = new Imagick();
			$imagick->readImage($pdf);
			$imagick->setImageFormat("jpg");
			$imagick->writeImages($save_to, false);
		}
		$prevImg = $pdfsrc[0].".jpg";
		return $prevImg;
}
?>
<div class="progress-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
<?
$arrProp=false;
foreach($arItem["DISPLAY_PROPERTIES"]['IMAGES_MORE']['FILE_VALUE'] as $var){
	if (is_array($var)){
		$arrProp = true;
		break;
	}
}
?>
<?if ($arItem["DISPLAY_PROPERTIES"]['IMAGES_MORE']['FILE_VALUE'] and $arrProp) {?>
	<?foreach($arItem["DISPLAY_PROPERTIES"]['IMAGES_MORE']['FILE_VALUE'] as $pid=>$arProperty){?>
		<?if ($arProperty['CONTENT_TYPE'] == "application/pdf") {?>
			<div class="progress-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>"> 
				<div class="progress-item-img">
					<a href="<?=$arProperty["SRC"];?>" target="_blank">
						<div class="img" style="background-image: url(<?=ConvertedPDF($arProperty["SRC"]);?>);"></div>
					</a>
				</div>
			</div>
		<?}else{?>
			<div class="progress-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="progress-item-img">
					<a href="<?=$arProperty['SRC'];?>" class="popup-image" title="<?=$arProperty['DESCRIPTION'];?>">
						<div class="img" style="background-image: url(<?=$arProperty['SRC'];?>);" title="<?=$arProperty['DESCRIPTION'];?>"></div>
					</a>
				</div>
			</div>
		<?}?>
	<?}?>
	<?}elseif ($arItem["DISPLAY_PROPERTIES"]['IMAGES_MORE']['FILE_VALUE'] and !$arrProp) {?>
		<?$arProperty = $arItem["DISPLAY_PROPERTIES"]['IMAGES_MORE']['FILE_VALUE'];
		if ($arProperty['CONTENT_TYPE'] == "application/pdf") {?>
		<?//PR($arItem)?>
				<div class="progress-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>"> 
				<div class="progress-item-img">
					<a href="<?=$arProperty["SRC"];?>" target="_blank">
						<div class="img" style="background-image: url(<?=ConvertedPDF($arProperty["SRC"]);?>);"></div>
					</a>
				</div>
			</div>
		<?}?>
	<?}else{?>
		<div class="progress-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="progress-item-img">
				<a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>" class="popup-image" title="<?=$arItem["PREVIEW_PICTURE"]['DESCRIPTION'];?>">
					<div class="img" style="background-image: url(<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>);" title="<?=$arItem["PREVIEW_PICTURE"]['DESCRIPTION'];?>"></div>
				</a>
			</div>
		</div>
	<?}?>
<?endforeach;?>
</div>			
<div class="page_vavigation">
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>

