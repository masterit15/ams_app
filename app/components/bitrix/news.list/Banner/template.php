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

			<div class="banner_row">
				<?foreach($arResult["ITEMS"] as $arItem):?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
				<div class="banner_item <?//=$arItem['PROPERTIES']['WIDTH']['VALUE_XML_ID']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>" 
				style="background-color: #<?=$arItem['DISPLAY_PROPERTIES']['BG_COLOR']['VALUE']?>; color: #<?=$arItem['DISPLAY_PROPERTIES']['TEXT_COLOR']['VALUE'];?>;">
					<?if($arItem['DISPLAY_PROPERTIES']['BANNER_CODE']['DISPLAY_VALUE']){

						echo $arItem['DISPLAY_PROPERTIES']['BANNER_CODE']['DISPLAY_VALUE'];

					}else{?>
						<div class="banner_wrap" style="">
							<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){?>
									<?echo $arItem["NAME"]?>
							<?}?>
							<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]){?>
								<?echo $arItem["PREVIEW_TEXT"];?>
							<?}?>
							<?if($arItem['DISPLAY_PROPERTIES']['BUTTON_COLOR']['VALUE']){?>
								<a href="http://" target="_blank" rel="noopener noreferrer" style="background-color: #<?=$arItem['DISPLAY_PROPERTIES']['BUTTON_COLOR']['VALUE']?>;"></a>
							<?}?>
						</div>
					<?}?>
					</div>
				<?endforeach;?>
		</div>