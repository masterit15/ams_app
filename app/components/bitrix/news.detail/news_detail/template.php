<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-detail">
	<? if(is_array($arResult["DETAIL_PICTURE"])) { ?>
		<div class="news-item-image">
			<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			align="left">
		</div>
	<? } ?>
	<? if ($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]) { ?>
		<h2><?=$arResult["NAME"]?></h2>
	<? } ?>

	<? if(strlen($arResult["DETAIL_TEXT"])>0) { ?>
		<p><?echo $arResult["DETAIL_TEXT"];?></p>
	<? } else { ?>
		<p><?echo $arResult["PREVIEW_TEXT"];?></p>
	<? } ?>
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
						<a class="" href="<?=$filename?>" alt="<?=$arProperty["DESCRIPTION"]?>" title="<?=$arProperty["DESCRIPTION"]?>">
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
		<? $inf = GetIBlockElement($arResult['ID']); 

		$source_link = trim($inf['PROPERTIES']['SOURCE_LINK']['VALUE']);
		$source = trim($inf['PROPERTIES']['SOURCE']['VALUE']);
		$fid = intval($inf['PROPERTIES']['APPLICATION_FILE']['VALUE']);
		$dopFile = '';
		if ($fid>0) {
			$rsFile = CFile::GetById($fid);
			if ($arFile = $rsFile->Fetch()) {
				$desc_f = trim($arFile['DESCRIPTION']);
				if ($desc_f=='') $desc_f = 'Приложение';
				$bs = $arFile['FILE_SIZE'];
				$s = intval($bs/(1024*1024)); if ($s>0) $ts = $s.'Мб';
				else { $s = intval($bs/1024); if ($s>0) $ts = $s.'Кб'; 
				else $ts = $s.'б'; }
				$dopFile = (($source_link.$source!='')?'<br/>':'').'<a href="http://'.$_SERVER['HTTP_HOST'].'/upload/'.$arFile['SUBDIR'].'/'.$arFile['FILE_NAME'].'" title="Открыть приложение">'.$desc_f.' ('.$ts.')</a>';
			}
		};
		if ($source.$source_link.$dopFile!='') echo '<div style="text-align: right; margin-top: 20px; font-size: 9pt; color: gray;">';
		if ($source.$source_link!='') echo 'Источник: ';
		if ($source_link!='') echo '<a href="http://'.$source_link.'" target="_blank" title="Открыть страницу источника">';
		if ($source!='') echo $source; elseif ($source_link!='') echo $source_link;
		if ($source_link!='') echo '</a>';
		echo $dopFile;
		if ($source.$source_link!='') echo '</div>';

		?>

		<div style="clear:both"></div>
		<br />
		<?foreach($arResult["FIELDS"] as $code=>$value):?>
		<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
		<br />
		<?endforeach;?>
		<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
		<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
		<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
		<?endforeach;?>
	</div>
