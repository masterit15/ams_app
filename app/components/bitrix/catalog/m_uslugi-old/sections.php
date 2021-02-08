<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//print_r($arParams);
	if(!$arParams["SECTION_ID"]) $arParams["SECTION_ID"] = $GLOBALS["SECTION_ID"];

IncludeTemplateLangFile(__FILE__);
global $USER, $APPLICATION;

$arStruktura = Array();
$arSi = 0;

if(!CModule::IncludeModule("iblock"))
	return;

	$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
				"ACTIVE"	=>	"Y",
//				"SECTION_ID"	=>	$arParams["SECTION_ID"]
				"SECTION_ID"	=>	$arParams["VARIABLE_ALIASES"]["SECTION_ID"]
			);

if ($arParams["VARIABLE_ALIASES"]["DATE_VIEW"] == "0")
	$DATE_VIEW = false;
else	$DATE_VIEW = true;

	$res = CIBlockSection::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false);
	while($ob = $res->GetNext())
	{
//print_r($ob);
		$arStruktura[$arSi]['ID'] = $ob['ID'];
		$arStruktura[$arSi]['NAME'] = $ob['NAME'];
		$arStruktura[$arSi]['SORT'] = $ob['SORT'];
		$arStruktura[$arSi]['SECTION'] = true;
		$arSi++;
	}


	$arSelect = Array("ID", "NAME", "SORT");
	$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
				"ACTIVE"	=>	"Y",
				"SECTION_ID"	=>	$arParams["SECTION_ID"]
			);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
	while($ob = $res->GetNextElement())
	{
	  $arFields = $ob->GetFields();
		$arStruktura[$arSi]['ID'] = $arFields['ID'];
		$arStruktura[$arSi]['NAME'] = $arFields['NAME'];
		$arStruktura[$arSi]['SORT'] = $arFields['SORT'];
		$arStruktura[$arSi]['SECTION'] = false;
		$arSi++;
	}

function sortStruktura($a, $b) {
    if ($a['NAME'] == $b['NAME']) return 0;
    return ($a['NAME'] > $b['NAME']) ? 1 : -1;
}
usort($arStruktura, sortStruktura);

//print_r($arStruktura);

?>

<div border="0" cellpadding="0" cellspacing="0" height="14" width="100%">

<?
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------
$arResult = $arStruktura;
if (!empty($arResult)){
   $l=0;
   $sub_str="";
   foreach($arResult as $arItem):

//ЗАГОЛОВОК ------------------

?>
<div colspan="2" style="padding: 0px 0px 0px 20px;" align="left" height="9" valign="bottom"><p class="static_text"><font class="news" style="font: bold 11pt/11pt Arial,sans-serif;"><?=$arItem['NAME'];?></font></p></div>
<?

	if	(!$arItem['SECTION']){
		if($arItem['NAME'] == " " || $arItem['NAME'] == "-" || $arItem['NAME'] == "_"){
			$db_props = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arItem["ID"], "sort", "asc",array("CODE"=>"STR_OFFICER"));
			$ar_props = $db_props->Fetch();

			$arSelect = Array("ID", "NAME");
			$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"	=>	$ar_props["LINK_IBLOCK_ID"],
						"ACTIVE"	=>	"Y",
						"ID"	=>	$ar_props["VALUE"]
					);
			$res = CIBlockElement::GetList(0, $arFilter, false, 0, $arSelect);
			$arOfficer = $res->Fetch();
			if($arOfficer['NAME'] != "")
				$arItem['NAME'] = $arOfficer['NAME'];
		}
		if($arItem['NAME'] != " " && $arItem['NAME'] != "-" && $arItem['NAME'] != "_"){
//					$sub_str.= "
//	<tr><td align=\"left\" valign=\"bottom\" height=\"4\" style=\"padding: 2px 10px 0px ".(7+(15*$l))."px;\"><li><a href=\"?IBLOCK_ID=".$arParams['IBLOCK_ID']."&SECTION_ID=0&ELEMENT_ID=".$arItem['ID']."\" class=\"submenu_l3\">".$arItem['NAME']."</a></li></td></tr>
//	<tr><td align=\"left\" valign=\"bottom\" height=\"5\" background=\"/bitrix/templates/AMS_Vladikavkaz/images/submenu_divfill.gif\"><img src=\"/bitrix/templates/AMS_Vladikavkaz/images/submenu_divdot.gif\" width=\"5\" height=\"5\"></td></tr>";
		}
	}elseif	($arItem['NAME'] != " " && $arItem['NAME'] != "-" && $arItem['NAME'] != "_"){
		$arSelect = Array("ID", "NAME", "SORT");
		$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
					"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
					"ACTIVE"	=>	"Y",
					"SECTION_ID"	=>	$arItem["ID"]
				);
		$res = CIBlockElement::GetList(Array("NAME"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), array());
?>
<div style="padding: 0px 10px 10px 20px;" align="left" valign="bottom">
<ul type="1"><font class="application" style="font: bold 10pt/10pt Arial,sans-serif;" color="#7d0000">
<?
//ПРИКРЕПЛЕННЫЕ ФАЙЛЫ ------------

		$l++;
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			if($arFields['NAME'] != " " && $arFields['NAME'] != "-" && $arFields['NAME'] != "_"){

	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arFields["ID"], "SORT", "ASC", array("ACTIVE"=>"Y","PROPERTY_TYPE"=>"F"));
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


				if($arProperty["DESCRIPTION"])
				{
?>
<div style="padding: 10px 0px 0px 0px; color: black;"><a class="news_date_nav" href="<?=$filename?>" style="font: 10pt/10pt Arial, sans-serif;">
<?
					?><?=$arProperty["DESCRIPTION"]?><?
					if ($DATE_VIEW) {
						?> (<?=date("d.m.Y",$file_name);?>) <?
					}
					?> <nobr><small>(<?=byteCount($arFile["FILE_SIZE"]);?>)</small></nobr><?
?>
</a>

</div>
<?
				}else{
?>
<li style="padding: 10px 0px 0px 0px; color: black;"><a class="news_date_nav" href="<?=$filename?>" style="font: 10pt/10pt Arial, sans-serif;">
<?
					?><?=$arFields["NAME"];?><?
					if ($DATE_VIEW) {
						$arDATE = ParseDateTime($arFields["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
						?> (<?=$arDATE["DD"];?>.<?=$arDATE["MM"];?>.<?=$arDATE["YYYY"];?>) <?
					}
					?> <nobr><small>(<?=byteCount($arFile["FILE_SIZE"]);?>)</small></nobr><?
?>

</a>
</li>
<?
				}
		}
	}
			}
		}
		$l--;
?>

</font></ul>
</div>
<?

//КОНЕЦ ----------------------
	}

   endforeach;

   if (strlen($sub_str) > 0){
?>
<?
   }
}

function byteCount ($x, $y = array("b","kb","mb")) {
	if ($x >= 1024 * 1000) 
		return((round(($x*100)/(1024*1024))/100) . " " . $y[2]);
	elseif ($x >= 1000)
		return(round($x/1024) . " " . $y[1]);
	else	return($x . " " . $y[0]);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>
</div>
