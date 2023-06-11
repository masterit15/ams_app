<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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
//$this->addExternalJS('https://api-maps.yandex.ru/2.1/?lang=ru_RU');

?>
<div class="row">
<?if ($arResult['PROPERTIES']['interception']['VALUE']) {?>
	<div class="col-12 col-xl-6 np">
<?}?>
<div <?if ($arResult['PROPERTIES']['interception']['VALUE']) {?>class="news-map"<?} else {?>class="news-detail"<?}?>>
			<?if($arResult["PROPERTIES"]["VIDEO"]["VALUE"]){?>
				<div class="news_video">
					<iframe title="<?=$arResult["NAME"];?>" style="width: 100%; height: 100%;" src="<?=$arResult["PROPERTIES"]["VIDEO"]["VALUE"]?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
				</div>
			<?}else{?>
				<?if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])): ?>
					<img
						class="detail_picture"
						src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
						/>
				<?endif?>
			<?}?>
			<div class="news_info">
				<i class="fa fa-eye"></i>
				<span title="Количество просмотров: <?=$arResult['SHOW_COUNTER'];?>"
					data-toggle="tooltip" data-placement="top"><?=$arResult['SHOW_COUNTER'];?></span>
			</div>
	<?if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if ($arResult["NAV_RESULT"]): ?>
		<?if ($arParams["DISPLAY_TOP_PAGER"]): ?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"]; ?>
		<?if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
		<?echo preg_replace('#<a.*?>(.*?)</a>#is', '$1', $arResult["DETAIL_TEXT"]);?>
	<?else: ?>
		<?echo preg_replace('#<a.*?>(.*?)</a>#is', '$1', $arResult["PREVIEW_TEXT"]);?>
	<?endif?>

	<div class="popup-gallery">
		<div class="row">
			<?
			if (is_array($arResult["PROPERTIES"]["IMAGES_MORE"]["VALUE"]) && count($arResult["PROPERTIES"]["IMAGES_MORE"]["VALUE"]) > 0){
				?><?
			}
			$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], "SORT", "ASC", array("ACTIVE"=>"Y","CODE"=>"IMAGES_MORE"));
			while($arProperty = $rsProperties->Fetch())
			{
				if ($arProperty["VALUE"]){
					$rsFile = CFile::GetByID($arProperty["VALUE"]);
					$arFile = $rsFile->Fetch();
					$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];
					?>
					<div class="col-sm-3 img-grid np">
						<a class="" href="<?=$filename?>" alt="<?=$arProperty["DESCRIPTION"]?>" title="<?=$arResult["NAME"]?>">
							<img src="<?=$filename?>" alt="<?=$arProperty["DESCRIPTION"]?>" title="<?=$arResult["NAME"]?>">
						</a>
						<?if ($arProperty["DESCRIPTION"]){
							?>
							<?}?>
						</div>
						<?
					}
				}
				?>
			</div>
		</div>
		<?if($arResult["PROPERTIES"]["VOTE"]["VALUE"] == 'ДА'){?>
			
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:voting.current",
				"",
				Array(
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_TIME" => "3600",
					"CACHE_TYPE" => "A",
					"CHANNEL_SID" => "ANTICOR",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO",
					"VOTE_ALL_RESULTS" => "N",
					"VOTE_ID" => "20"
				)
			);?>
		<?}?>
		<div class="news-application-files">
			
			<?if(!arrCount($arResult["PROPERTIES"]['APPLICATION_FILES']['VALUE'])){?>
				<?if($arResult["PROPERTIES"]['APPLICATION_FILES']['VALUE']){?>
				<h3><?=$arResult["PROPERTIES"]['APPLICATION_FILES']['NAME']?></h3>
				<hr>
				<?}?>
				<?if($arResult["PROPERTIES"]['APPLICATION_FILES']['VALUE']){?>
					<?$file = getFileArr($arResult["PROPERTIES"]['APPLICATION_FILES']['VALUE']);?>
					<div class="doc_item item" title='<?=$file['NAME']?>'>
						<a href="<?=$file['path']?>" target="_blank" <?if($file['type'] != 'pdf'){?>download<?}?>>					
							<span class="doc_icon">
								<?=$file['icon']?>
							</span>				
							<div class="doc_detail">			
								<div class="doc_title">
									<?=$file['name'];?>
								</div>
								<span class="doc_date">
									<?=$file['date']?>
								</span>
							</div>
							<span class="doc_size"><?=$file['size']?></span>
						</a>
					</div>
				<?}?>
			<?}else{?>
				<?foreach($arResult["PROPERTIES"]['APPLICATION_FILES']['VALUE'] as $value){?>
					<?$file = getFileArr($value);?>
					<div class="doc_item item" title='<?=$file['NAME']?>'>
						<a href="<?=$file['path']?>" target="_blank" <?if($file['type'] != 'pdf'){?>download<?}?>>					
							<span class="doc_icon">
								<?=$file['icon']?>
							</span>				
							<div class="doc_detail">			
								<div class="doc_title">
									<?=$file['name'];?>
								</div>
								<span class="doc_date">
									<?=$file['date']?>
								</span>
							</div>
							<span class="doc_size"><?=$file['size']?></span>
						</a>
					</div>
				<?}?>
			<?}?>
		
	</div>
<div class="news-source">
	<?=$arResult["DISPLAY_PROPERTIES"]['SOURCE']['NAME']?>: <?=$arResult["DISPLAY_PROPERTIES"]['SOURCE']['VALUE']?>
	<?
	if($arResult["DISPLAY_PROPERTIES"]['SOURCE_LINK']['VALUE']){
		echo '<br><a href="'.$arResult["DISPLAY_PROPERTIES"]['SOURCE_LINK']['VALUE'].'">'.$arResult["DISPLAY_PROPERTIES"]['SOURCE_LINK']['NAME'].'</a>';
	}
	?>
</div>

<?if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {
    ?>
		<div class="news-detail-share">
			<noindex>
			<?
    $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
        "HANDLERS" => $arParams["SHARE_HANDLERS"],
        "PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
        "PAGE_TITLE" => $arResult["~NAME"],
        "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
        "HIDE" => $arParams["SHARE_HIDE"],
    ),
        $component,
        array("HIDE_ICONS" => "Y")
    );
    ?>
			</noindex>
		</div>
		<?
}
?>
	</div>
	<?if ($arResult['PROPERTIES']['interception']['VALUE']) {?>
	</div>
<?}?>
<?if ($arResult['PROPERTIES']['interception']['VALUE']) {?>
	<div class="interception-data"
    data-index="<?=$index?>"
    data-interception="<?=$arResult['PROPERTIES']['interception']['VALUE']?>"
    data-ot-interception="<?=$arResult['PROPERTIES']['ot_interception']['VALUE']?>"
    data-do-interception="<?=$arResult['PROPERTIES']['do_interception']['VALUE']?>"
    data-img="<?=$GLOBALS['OBJECT_IMG_SRC'];?>"
		>
	</div>
		<div class="col-12 col-xl-6 np">
			<div id="map"></div>
		</div>
<?}?>
</div>

<?
//PR($arResult);
// PR('https://connect.ok.ru/offer?url=http://vladikavkaz-osetia.ru'.$arResult['DETAIL_PAGE_URL'].'&title='.$arResult["NAME"].'&imageUrl=http://vladikavkaz-osetia.ru'.$arResult["DETAIL_PICTURE"]["SRC"]);
?>