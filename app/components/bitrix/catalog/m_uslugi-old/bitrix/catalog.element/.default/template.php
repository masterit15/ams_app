<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//--Функции----------------------------------------------------------------------------
if(!function_exists("byteCount")){
function byteCount ($x, $y = array("b","kb","mb")) {
	if ($x >= 1024 * 1000) 
		return((round(($x*100)/(1024*1024))/100) . " " . $y[2]);
	elseif ($x >= 1000)
		return(round($x/1024) . " " . $y[1]);
	else	return($x . " " . $y[0]);
}}
//-------------------------------------------------------------------------------------

//print_r($arResult);
	$arOfficer = false;
	if($arResult["PROPERTIES"]["STR_OFFICER"]["VALUE"]){
		$arSelect = Array("ID", "NAME", "DETAIL_PICTURE", "DETAIL_TEXT");
		$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
					"IBLOCK_ID"	=>	$arResult["PROPERTIES"]["STR_OFFICER"]["LINK_IBLOCK_ID"],
					"ACTIVE"	=>	"Y",
					"ID"		=>	$arResult["PROPERTIES"]["STR_OFFICER"]["VALUE"]
				);
		$res = CIBlockElement::GetList(0, $arFilter, false, 0,$arSelect);
		while($ob = $res->GetNextElement())
		{
		  $arOfficer = $ob->GetFields();
//print_r($arOfficer);
		}
	}
?>
 <table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
	<tr><td width="100%" height="16" colspan="2" class="news" style="padding-bottom: 5px;">
<?
	if (is_array($arResult["DETAIL_PICTURE"])){?>
		<div class="news_img" style="width: <?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>; float: left;"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" hspace="0" vspace="2" align="left" border="0"></div>
<?	}
	elseif(is_array($arOfficer) && $arResult["PROPERTIES"]["STR_OFFICER"]["VALUE"] && $arOfficer["DETAIL_PICTURE"]){
			$rsFile = CFile::GetByID($arOfficer["DETAIL_PICTURE"]);
			$arFile = $rsFile->Fetch();
			$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];
		?>
		<div class="news_img" style="width: <?=$arFile["WIDTH"]?>; float: left;"><img src="<?=$filename?>" width="<?=$arFile["WIDTH"]?>" height="<?=$arFile["HEIGHT"]?>" hspace="0" vspace="2" align="left" border="0"></div>
<?	}else{?>
		<div class="news_img" style="width: 150; float: left;"><img src="/bitrix/templates/AMS_Vladikavkaz/images/no_photo.gif" width="150" height="200" hspace="0" vspace="2" align="left" border="0"></div>
<?}

	if(is_array($arOfficer) && $arResult["PROPERTIES"]["STR_OFFICER"]["VALUE"] && strlen($arOfficer["~NAME"]) > 0){?>
		<font class="news" style="font: bold 11pt/11pt Arial, sans-serif;"><?=$arOfficer["~NAME"]?><br></font><br style="font: normal 2pt/2pt Arial, sans-serif;">
<?	}
	if(strlen($arResult["PROPERTIES"]["STR_POSITION"]["VALUE"]) > 0){?>
		<font class="news_text"><?=$arResult["PROPERTIES"]["STR_POSITION"]["VALUE"]?></font>
<?	}

	if (strlen($arResult["DETAIL_TEXT"])>0){?>
		<div class="static_text"><?=$arResult["DETAIL_TEXT"]?></div>
<?	}
	elseif(is_array($arOfficer) && $arResult["PROPERTIES"]["STR_OFFICER"]["VALUE"] && strlen($arOfficer["~DETAIL_TEXT"]) > 0){?>
		<div class="static_text"><?=$arOfficer["~DETAIL_TEXT"]?></div>
<?	}?>
		<ul type="square"><font color="#7d0000"><?
	while (list($key, $arProperty) = each($arResult["PROPERTIES"]))
	{
		if ($arProperty["VALUE"] && $arProperty["NAME"] && $arProperty["PROPERTY_TYPE"] == "F" && $arProperty["ACTIVE"] == "Y"){
			$rsFile = CFile::GetByID($arProperty["VALUE"]);
			$arFile = $rsFile->Fetch();

			$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];
			?><BR><li><a class="news_date_nav" href="<?=$filename?>"><b><?
				if($arProperty["DESCRIPTION"]){?><?=$arProperty["DESCRIPTION"];?><?}else{?><?=$arProperty["NAME"];?><?}
				?></B> (<?=byteCount($arFile["FILE_SIZE"])?>)</a></li><?
		}
	}
	?></ul>
	</td></tr>
 </table>
 <BR>
<?
//------------------------------------------------------------
$GLOBALS["BACK_PAGE"]["NAME"] = GetMessage("T_NEWS_DETAIL_BACK");
$GLOBALS["BACK_PAGE"]["URL"] = "?";
//------------------------------------------------------------
?>