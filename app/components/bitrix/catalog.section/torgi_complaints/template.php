<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->AddChainItem($arParams["~PAGER_TITLE"], "?");?>
<BR>
<?if($arParams["DISPLAY_TOP_PAGER"]):?><div class="news_date_nav"><B><?=$arResult["NAV_STRING"]?></B></div><?endif;?>
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
					"DATE_ACTIVE_FROM",	//Дата извещения
					"NAME",			//Лицо, подавшее жалобу
					"DETAIL_TEXT",		//Содержание жалобы
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

	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arElement["ID"], "SORT", "ASC", array("ACTIVE"=>"Y"));
	while($rsProperty = $rsProperties->Fetch())
	{
		$arProperty[$rsProperty["CODE"]] = $rsProperty;
	}

	?><td align="left" valign="bottom" height="9" colspan="2" style="padding: 0px 10px 0px 24px;"><?
	?><table border="0" cellpadding="2" cellspacing="0" width="100%" class="torgi_complaints"><?
	if($arProperty["SUD"]["VALUE"])
	{
		?><tr><th width="200px" valign="top" align="left"><?=$arProperty["SUD"]["NAME"];?>:</td><td valign="top" align="justify"><?=$arProperty["SUD"]["VALUE"];?></td></tr><?
	};
	if($arElement["NAME"])
	{
		?><tr><th width="200px" valign="top" align="left">Лицо, подавшее жалобу:</td><td valign="top" align="justify"><?=$arElement["NAME"];?></td></tr><?
	};
	if($arProperty["SUBJECT"]["VALUE"])
	{
		?><tr><th width="200px" valign="top" align="left"><?=$arProperty["SUBJECT"]["NAME"];?>:</td><td valign="top" align="justify"><?=$arProperty["SUBJECT"]["VALUE"];?></td></tr><?
	};
	if($arProperty["NUMBER"]["VALUE"])
	{
		?><tr><th width="200px" valign="top" align="left"><?=$arProperty["NUMBER"]["NAME"];?>:</td><td valign="top" align="justify"><?=$arProperty["NUMBER"]["VALUE"];?></td></tr><?
	};
	if($arElement["DATE_ACTIVE_FROM"])
	{
		$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
		?><tr><th width="200px" valign="top" align="left">Дата извещения:</td><td valign="top" align="justify"><?=$arDATE["DD"].".".$arDATE["MM"].".".$arDATE["YYYY"];?></td></tr><?
	};
	if($arProperty["OBJECT"]["VALUE"])
	{
		?><tr><th width="200px" valign="top" align="left"><?=$arProperty["OBJECT"]["NAME"];?>:</td><td valign="top" align="justify"><?=$arProperty["OBJECT"]["VALUE"];?></td></tr><?
	};
	if($arElement["DETAIL_TEXT"])
	{
		?><tr><th width="200px" valign="top" align="left">Содержание жалобы:</td><td valign="top" align="justify"><?=$arElement["DETAIL_TEXT"];?></td></tr><?
	};
	if($arProperty["NOTE"]["VALUE"])
	{
		?><tr><th width="200px" valign="top" align="left"><?=$arProperty["NOTE"]["NAME"];?>:</td><td valign="top" align="justify"><?=nl2br($arProperty["NOTE"]["VALUE"]);?></td></tr><?
	};
	if($arProperty["RESULT"]["VALUE"])
	{
		?><tr><th style="border:0px;" width="200px" valign="top" align="left"><?=$arProperty["RESULT"]["NAME"];?>:</td><td valign="top" align="justify"><?=nl2br($arProperty["RESULT"]["VALUE"]);?></td></tr><?
	};

	?></table><?
	?></td></tr>
<?
/*
  <tr><td align="left" valign="bottom" style="padding: 10px 10px 10px 24px;"><?

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
			?><font class="small_news_date" color=#7D0000><a class="news_date_nav" href="<?=$filename?>">[<?if($arProperty["DESCRIPTION"])echo $arProperty["DESCRIPTION"]; else echo $arProperty["NAME"];?><?
				// 1230757200 - это 01.01.2009 00:00:00
				$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
				if(intval($arDATE["YYYY"]) >= 2009 && $file_name>=1230757200 && $file_name<2000000000){?> (<?=date("d.m.Y H:i",$file_name)?>) <?}
			?> - <?=byteCount($arFile["FILE_SIZE"])?>]</a></font>&nbsp;<BR><?
		}
	}

	?></td><td align="right" valign="bottom"><font class="small_news_date" color=#7D7D78><b><?
		$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
		echo $arDATE["DD"].".".$arDATE["MM"].".".$arDATE["YYYY"];
		?></b></font></td></tr>
*/
?>
  <tr><td align="left" valign="bottom" height="45" colspan="2"><hr></td></tr>
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