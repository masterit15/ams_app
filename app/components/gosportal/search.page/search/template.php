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
?>
<div class="search-page">
<form action="" method="get">
<?if ($arParams["USE_SUGGEST"] === "Y"):
	if (strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"])) {
		$arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
		$obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
		$obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
	}
	?>
					<div class="search_filter">
						<div class="search_filter_input">
							<?$APPLICATION->IncludeComponent(
		"bitrix:search.suggest.input",
		"",
		array(
			"NAME" => "q",
			"VALUE" => $arResult["REQUEST"]["~QUERY"],
			"INPUT_SIZE" => 40,
			"DROPDOWN_SIZE" => 10,
			"FILTER_MD5" => $arResult["FILTER_MD5"],
		),
		$component, array("HIDE_ICONS" => "Y")
	);?>
							<?else: ?>
			<input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
			<?endif;?>
			<input type="submit" value="<?=GetMessage("SEARCH_GO")?>" />
			<input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>" />
		</div>
		<a class="search-page-params" href="#!" title="<?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS') ?>"><i class="fa fa-sliders"></i></a>
	</div>
<?if ($arParams["SHOW_WHEN"]): ?>
	<div id="search_params">
		<input placeholder="По дате (от - до)" id="search_filter_date" type="text" data-range="true" data-multiple-dates-separator=" - " class="datepicker-here" autocomplete="off"/>
		<input class="date_from" type="hidden" name="from" value="<?=$arResult["REQUEST"]["~FROM"]?>"/>
		<input class="date_to" type="hidden" name="to" value="<?=$arResult["REQUEST"]["~TO"]?>"/>
		<?if ($arParams["SHOW_WHERE"]): ?>
			<select name="where" class="select2">
				<option value=""><?=GetMessage("SEARCH_ALL")?></option>
				<?foreach ($arResult["DROPDOWN"] as $key => $value): ?>
					<option value="<?=$key?>"<?if ($arResult["REQUEST"]["WHERE"] == $key) {echo " selected";}?>>
						<?=$value?>
					</option>
				<?endforeach?>
			</select>
		<?endif;?>

	<div class="search_filter_sort">
		<?if ($arResult["REQUEST"]["HOW"] == "d"): ?>
			<div class="search_filter_sort_item">
				<a href="<?=$arResult["URL"]?>&amp;how=r<?echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><?echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?=GetMessage("SEARCH_SORT_BY_RANK")?></a>
			</div>
			<div class="search_filter_sort_item active">
				<b><?=GetMessage("SEARCH_SORTED_BY_DATE")?></b>
			</div>
		<?else: ?>
			<div class="search_filter_sort_item active">
				<b><?=GetMessage("SEARCH_SORTED_BY_RANK")?></b>
			</div> 
			<div class="search_filter_sort_item">
				<a href="<?=$arResult["URL"]?>&amp;how=d<?echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><?echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?=GetMessage("SEARCH_SORT_BY_DATE")?></a>
			</div>
			
		<?endif;?>
	</div>
	</div>
<?endif?>

</form><br />

<?if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
	</div><br /><?
endif;?>

<?if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>
<?elseif ($arResult["ERROR_CODE"] != 0): ?>
	<p><?=GetMessage("SEARCH_ERROR")?></p>
	<?ShowError($arResult["ERROR_TEXT"]);?>
	<p><?=GetMessage("SEARCH_CORRECT_AND_CONTINUE")?></p>
	<br /><br />
	<p><?=GetMessage("SEARCH_SINTAX")?><br /><b><?=GetMessage("SEARCH_LOGIC")?></b></p>
	<table border="0" cellpadding="5">
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OPERATOR")?></td><td valign="top"><?=GetMessage("SEARCH_SYNONIM")?></td>
			<td><?=GetMessage("SEARCH_DESCRIPTION")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_AND")?></td><td valign="top">and, &amp;, +</td>
			<td><?=GetMessage("SEARCH_AND_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_OR")?></td><td valign="top">or, |</td>
			<td><?=GetMessage("SEARCH_OR_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top"><?=GetMessage("SEARCH_NOT")?></td><td valign="top">not, ~</td>
			<td><?=GetMessage("SEARCH_NOT_ALT")?></td>
		</tr>
		<tr>
			<td align="center" valign="top">( )</td>
			<td valign="top">&nbsp;</td>
			<td><?=GetMessage("SEARCH_BRACKETS_ALT")?></td>
		</tr>
	</table>
<?elseif (count($arResult["SEARCH"]) > 0): ?>
	<?if ($arParams["DISPLAY_TOP_PAGER"] != "N") {
	echo $arResult["NAV_STRING"];
}
?>
	<br />
	<?foreach ($arResult["SEARCH"] as $arItem):

		?>
		
	<?
		$filesId = getElementProps($arItem['ITEM_ID'], $arItem['PARAM2']);
		// если это документы
		if($filesId){
		if(count($filesId) > 1){?>
      <div class="folder">
				<div class="folder-summary js_toggle-folder">
					<div class="folder-summary__start">
						<div class="folder-summary__file-count">
								<span class="folder-summary__file-count__amount"><?=count($filesId)?></span>
								<i class="fa fa-folder"></i>
								<i class="fa fa-folder-open"></i>
						</div>
					</div>
					<div class="folder-summary__details">
						<div class="folder-summary__details__name">
							<?=$arItem['TITLE_FORMATED']?>
						</div>
						<div class="folder-summary__details__share">
              <?=$arItem['DATE_CHANGE'];?>
						</div>
					</div>
					<div class="folder-summary__end">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							<path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" /></svg>
					</div>
				</div>	
				<ul class="folder-content">
          <?foreach ($filesId as $arProperty){
          $file = getFileArr($arProperty);
          ?>
            <li class="folder-item js_folder-item">
              <a no-data-pjax class="folder-item-wrap" href="<?=$file['path']?>" <?if ($file['type'] != 'pdf') {?>download<?}?>>
                <div class="folder-item__icon"><?=$file['icon'];?></div>
                <div class="folder-item__details">
                  <div class="folder-item__details__name">
                    <?=$file['desc'] ? $file['desc'] : $file['name'];?>
                  </div>
                  <!-- <div class="folder-item__details__date"><?//=$file['date'];?></div> -->
                </div>
                <div class="folder-item__size"><?=$file['size'];?></div>
              </a>
            </li>
          <?}?>
          <?if(count($filesId) > 1){?>
            <li class="folder-item js_folder-item download_zip">
              <div no-data-pjax class="folder-item-wrap">
                <div class="folder-item__icon"><i class="fa fa-file-archive-o" style="color:#f3aa16"></i></div>
                <div class="folder-item__details">
                  <div class="folder-item__details__name">
                    Скачать все файлы одним архивом
                  </div>
                </div>
                <div class="folder-item__size"><i class="fa fa-download"></i></div>
              </div>
            </li>
          <?}?>
				</ul>
		  </div>
    <?}else{
      $file = getFileArr($filesId[0]);
      ?>
      <div class="doc_item item" title='<?=$doc['NAME']?>'>
        <a no-data-pjax href="<?=$file['path']?>" <?if($file['type'] != 'pdf'){?>download<?}?>>					
          <span class="doc_icon">
            <?=$file['icon']?>
          </span>				
          <div class="doc_detail">			
            <div class="doc_title">
              <?=$arItem['TITLE_FORMATED'] ? $arItem['TITLE_FORMATED'] : $file['name'];?>
            </div>
            <span class="doc_date">
              <?=$arItem['DATE_CHANGE'];?>
            </span>
          </div>
          <span class="doc_size"><?=$file['size']?></span>
        </a>
      </div>
		<?}?>
		<!-- если это документы -->
		<?}elseif($arItem['PARAM2'] == 23 || $arItem['PARAM2'] == 24){
			$arProp = CIBlockElement::GetProperty($arItem['PARAM2'], $arItem['ITEM_ID'], Array("sort"=>"asc"), Array('CODE'=>array('file_01', 'file_02')));
			$arRes = array();
			while ($arPropRes = $arProp->Fetch()){
				$arRes[] = $arPropRes['VALUE'];
			}

foreach($arRes as $value){
	$file = getFileArr($value);

}

		}else{?>
		<div class="search_query_item">
		<a href="<?echo $arItem["URL"] ?>"><?= $arItem["TITLE_FORMATED"] != '-' ? $arItem["TITLE_FORMATED"] : $arItem["BODY_FORMATED"]?></a>
		<p><?= $arItem["TITLE_FORMATED"] == '-' ? $arItem["TITLE_FORMATED"] : $arItem["BODY_FORMATED"]?></p>
		<!-- <small><?//=GetMessage("SEARCH_MODIFIED")?> <?//=$arItem["DATE_CHANGE"]?></small><br /> -->
		</div>
		<?}?>
		
	<?endforeach;?>
	<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") {
		echo $arResult["NAV_STRING"];
	}
	?>
	<br />

<?else: ?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?endif;?>
</div>