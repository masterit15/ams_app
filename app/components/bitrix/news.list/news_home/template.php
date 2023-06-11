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
	<h3>Новости</h3>
	<a href="/news/">Все новости <i class="fa fa-angle-right"></i></a>
</div>
<div class="news_list">
<?foreach($arResult["ITEMS"] as $arItem):
	// PR($arItem["PROPERTIES"]["VIDEO_LOCAL"]['VALUE']['path']);
	?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<?if($arItem["PROPERTIES"]["VIDEO_LOCAL"]['VALUE']){?>
						<div class="news_media">
						<video controls="controls">
							<source src="<?=$arItem["PROPERTIES"]["VIDEO_LOCAL"]['VALUE']['path']?>" type='video/ogg; codecs="theora, vorbis"'>
							<source src="<?=$arItem["PROPERTIES"]["VIDEO_LOCAL"]['VALUE']['path']?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
							<source src="<?=$arItem["PROPERTIES"]["VIDEO_LOCAL"]['VALUE']['path']?>" type='video/webm; codecs="vp8, vorbis"'>
						</video>
						</div>
					<?}else{?>
			<?if($arItem["PROPERTIES"]["VIDEO"]["VALUE"]){?>
				<div class="news_media">
					<iframe title="<?=$arItem["NAME"];?>" style="width: 100%; height: 100%;" src="<?=$arItem["PROPERTIES"]["VIDEO"]["VALUE"]?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
				</div>
			<?}else{?>
				<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
					<div class="news_media" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')"></div>
				<?endif?>
			<?}?>
			<?}?>
			
			<div class="news_content">
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]){?>
					<div class="news_date">
						<?=CIBlockFormatProperties::DateFormat("j F Y в H:i", MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()))?>
					</div>
				<?}?>
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){?>
					<a  href="<?=$arItem["DETAIL_PAGE_URL"]?>"><h3 class="news_title"><?if(mb_strlen($arItem["NAME"],'UTF-8') > 60){ echo mb_strimwidth($arItem["NAME"], 0, 50, "..."); }else{ echo$arItem["NAME"]; }?></h3></a>
				<?}?>
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]){?>
					<div class="news_text"><?echo $arItem["PREVIEW_TEXT"];?></div>
				<?}?>
			</div>
			<div class="news_info">
				<i class="fa fa-eye"></i>
				<span title="Количество просмотров: <?=$arItem['SHOW_COUNTER'];?>"
					data-toggle="tooltip" data-placement="top"><?=$arItem['SHOW_COUNTER'];?></span>
			</div>
				</div>
<?endforeach;?>
</div>