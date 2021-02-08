<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-element">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
		<?if(is_array($arResult["PREVIEW_PICTURE"]) || is_array($arResult["DETAIL_PICTURE"])):?>
			<td width="0%" valign="top">
				<?if(is_array($arResult["PREVIEW_PICTURE"]) && is_array($arResult["DETAIL_PICTURE"])):?>
					<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" id="image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>" style="display:block;cursor:pointer;cursor: hand;" OnClick="document.getElementById('image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>').style.display='none';document.getElementById('image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>').style.display='block'" />
					<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" id="image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>" style="display:none;cursor:pointer; cursor: hand;" OnClick="document.getElementById('image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>').style.display='none';document.getElementById('image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>').style.display='block'" />
				<?elseif(is_array($arResult["DETAIL_PICTURE"])):?>
					<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				<?elseif(is_array($arResult["PREVIEW_PICTURE"])):?>
					<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				<?endif?>
				<?if(count($arResult["MORE_PHOTO"])>0):?>
					<br /><a href="#more_photo"><?=GetMessage("CATALOG_MORE_PHOTO")?></a>
				<?endif;?>
			</td>
		<?endif;?>
			<td width="100%" valign="top">
				<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
					<?=$arProperty["NAME"]?>:<b>&nbsp;<?
					if(is_array($arProperty["DISPLAY_VALUE"])):
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($pid=="MANUAL"):
						?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
					else:
						echo $arProperty["DISPLAY_VALUE"];?>
					<?endif?></b><br />
				<?endforeach?>
			</td>
		</tr>
	</table>
		<br />
	<?if($arResult["DETAIL_TEXT"]):?>
		<br /><?=$arResult["DETAIL_TEXT"]?><br />
	<?elseif($arResult["PREVIEW_TEXT"]):?>
		<br /><?=$arResult["PREVIEW_TEXT"]?><br />
	<?endif;?>
	<?if(count($arResult["LINKED_ELEMENTS"])>0):?>
		<br /><b><?=$arResult["LINKED_ELEMENTS"][0]["IBLOCK_NAME"]?>:</b>
		<ul>
	<?foreach($arResult["LINKED_ELEMENTS"] as $arElement):?>
		<li><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
	<?endforeach;?>
		</ul>
	<?endif?>
	<?
	// additional photos
	$LINE_ELEMENT_COUNT = 2; // number of elements in a row
	if(count($arResult["MORE_PHOTO"])>0):?>
		<a name="more_photo"></a>
		<?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>
			<img border="0" src="<?=$PHOTO["SRC"]?>" width="<?=$PHOTO["WIDTH"]?>" height="<?=$PHOTO["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" /><br />
		<?endforeach?>
	<?endif?>

</div>
  <table width="100%" height="14" border="0" cellpadding="0" cellspacing="0">
  <?
//Кнопка добавления - документа
	if($USER->IsAuthorized() && $APPLICATION->GetPublicShowMode()!== 'view'):
		$ar = CIBlock::ShowPanel($arParams["IBLOCK_ID"], 0, 0, $arParams["IBLOCK_TYPE"], true);
		if(is_array($ar)):
//		        CIBlock::ShowPanel($arParams["IBLOCK_ID"], 0, 0, $arParams["IBLOCK_TYPE"]);//добавление кнопки на панель администрирования
			foreach($ar as $arButton):
				?><tr><td colspan="3"><?
				?><table class="menubgoff" onmouseover="tdbgover(this)" onmouseout="tdbgout(this)" style="border-bottom: 1px dotted #555555;" width="100%" border="0" cellpadding="4" cellspacing="0"><?
				?><tr><td width="4" valign="top"><a href="<?echo htmlspecialchars($arButton["URL"])?>"><img src="<?=$arButton["IMAGE"]?>" width="20" height="20" border="0"></a></td><?
				?><td class="mm"><a href="<?echo htmlspecialchars($arButton["URL"])?>"><B><?echo htmlspecialchars($arButton["TITLE"])?></B></a></td></tr><?
				?></table><?
				?></td></tr><?
			endforeach;
		endif;
	endif;
//-----------------------------

	foreach($arResult["ITEMS"] as $cell=>$arElement):
	?><tr><?

		$arSelect = Array(	"ID",
					"NAME",
					"DATE_ACTIVE_FROM",
					"DETAIL_TEXT",
					"LOCK_STATUS"
				);
		$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
					"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
					"ACTIVE"	=>	"Y",
					"ID"		=>	$arElement["ID"]
				);
		$res = CIBlockElement::GetList(0, $arFilter, false, 0, $arSelect);
		$arElement = $res->Fetch();

//Кнопка изменения - документа
	if($USER->IsAuthorized() && $APPLICATION->GetPublicShowMode()!== 'view'):
		$ar = CIBlock::ShowPanel($arParams["IBLOCK_ID"], $arElement["ID"], 0, $arParams["IBLOCK_TYPE"], true);
		if(is_array($ar))
			foreach($ar as $arButton):
				if(preg_match("/[^A-Z0-9_]ID=\d+/", $arButton["URL"])):
				?><td rowspan="3" valign="top" width="150"><?
				?><table class="menubgoff" onmouseover="tdbgover(this)" onmouseout="tdbgout(this)" style="border-bottom: 1px dotted #555555;" width="100%" border="0" cellpadding="4" cellspacing="0"><?
				?><tr><td width="4" valign="top"><a href="<?echo htmlspecialchars($arButton["URL"])?>"><img src="<?=$arButton["IMAGE"]?>" width="20" height="20" border="0"></a></td><?
				?><td class="mm"><a href="<?echo htmlspecialchars($arButton["URL"])?>"><B><?echo htmlspecialchars($arButton["TITLE"])?></B></a></td></tr><?
				?><tr><td width="4" valign="top"><img src="/bitrix/images/workflow/<?=$arElement["LOCK_STATUS"]?>.gif" width="14" height="14" border="0"></td><?
				?><td class="mm"><a><B>Блокировка</B></a></td></tr><?
				?></table><?
				?></td><?
				endif;
			endforeach;
	endif;
//-----------------------------

	?><td align="left" valign="bottom" height="9" colspan="2" style="padding: 0px 0px 0px 20px;"><p class="static_text"><font class="news" style="font: bold 11pt/11pt Arial, sans-serif;"><?=$arElement["NAME"]?></font></p></td></tr>
  <tr><td align="left" valign="bottom" style="padding: 0px 10px 10px 20px;">
	<ul type="1"><font color="#7d0000" class="application" style="font: bold 10pt/10pt Arial, sans-serif;"><?

	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arElement["ID"], "SORT", "ASC", array("ACTIVE"=>"Y","PROPERTY_TYPE"=>"F"));
	while($arProperty = $rsProperties->Fetch())
	{
		if ($arProperty["VALUE"] && $arProperty["NAME"]){
			$rsFile = CFile::GetByID($arProperty["VALUE"]);
			$arFile = $rsFile->Fetch();

//ДЛЯ ИЗМЕНЕНИЯ [ORIGINAL_NAME] на ДАТУ СОЗДАНИЯ ФАЙЛА ----
			$file_len = strrpos($arFile["ORIGINAL_NAME"], '.');
			$file_name = substr($arFile["ORIGINAL_NAME"], 0, $file_len);
			$file_type = substr($arFile["ORIGINAL_NAME"], $file_len+1, strlen($arFile["ORIGINAL_NAME"])-$file_len);
			$file_name = intval($file_name);
//ДЛЯ ИЗМЕНЕНИЯ [ORIGINAL_NAME] на ДАТУ СОЗДАНИЯ ФАЙЛА ---- end

			$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];
			?>
    <li style="padding: 10px 0px 0px 0px; color: black;"><a class="news_date_nav" href="<?=$filename?>" style="font: 10pt/10pt Arial, sans-serif;"><?if($arProperty["DESCRIPTION"])echo $arProperty["DESCRIPTION"]; else echo $arProperty["NAME"];?><?
/*				// 1230757200 - это 01.01.2009 00:00:00
				$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
				if(intval($arDATE["YYYY"]) >= 2009 && $file_name>=1230757200 && $file_name<2000000000){?> (<?=date("d.m.Y",$file_name)?>) <?}
*/
			?> <small>(<?=byteCount($arFile["FILE_SIZE"])?>)</small></a></li>
<?
		}
	}

	?></font></ul>
  </td></tr>
  <tr><td align="left" valign="bottom" height="5" colspan="2"></td></tr>
<?
	endforeach;
?>
  </table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><div class="news_date_nav"><B><?=$arResult["NAV_STRING"]?></B></div><?endif;?>
<?
function byteCount ($x, $y = array("b","kb","mb")) {
	if ($x >= 1024 * 1000) 
		return((round(($x*100)/(1024*1024))/100) . " " . $y[2]);
	elseif ($x >= 1000)
		return(round($x/1024) . " " . $y[1]);
	else	return($x . " " . $y[0]);
}
?>