<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" language="javascript" src="/bitrix/templates/AMS/components/bitrix/catalog/adm_reg/bitrix/catalog.element/.default/jquery-1.js"></script>
<script type="text/javascript" src="/bitrix/templates/AMS/components/bitrix/catalog/adm_reg/bitrix/catalog.element/.default/jquery_002.js"></script>
<?
//--???????----------------------------------------------------------------------------

if(!function_exists("dateAfterMonth")){
function dateAfterMonth($m,$d,$y) // ?????????? 1 ?????
{
    if($m == 12){
        return strtotime("+1 month",mktime(0,0,0,$m,$d,$y));
    }

    ++$m;
    while(true){
        if(checkdate($m,$d,$y)){
           break;
        }
        --$d;
    }
    return mktime(0,0,0,$m,$d,$y);
}}

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
		$arSelect = Array("ID", "ACTIVE_FROM", "NAME", "DETAIL_PICTURE", "DETAIL_TEXT");
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

//   ????? ?????????? ?? ?????? ---------------------------------------------------------------------------------------------------------------------------------------------------------------

//print_r($arParams);

//	???????????? ???
	$arPropertyD = Array();
	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], "SORT", "ASC", array("ACTIVE"=>"Y"));
	while($arProperty = $rsProperties->Fetch())
	{

//print_r($arProperty);

		if($arProperty['PROPERTY_TYPE'] != "F")
		{
			$arPropertyD[$arProperty['CODE']] = Array
			(
				"NAME"		=> $arProperty['NAME'],
				"VALUE"		=> $arProperty['VALUE'],
				"VALUE_ENUM"	=> $arProperty['VALUE_ENUM']
			);
		}
	}
//   ????? ?????????????? ?????????? ?? ?????? ------------------------------------------------------------------------------------------------------------------------------------------------

//	?????? ?????????	- $arPropertyD['rmu_status']
//	??????????? ??????	- $arPropertyD['rmu_ispolnitel']
//	?????????? ??????????	- $arPropertyD['rmu_inform']

//print_r($arPropertyD);

/*
	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], "SORT", "ASC", array("ACTIVE"=>"Y","PROPERTY_TYPE"=>"F"));
	while($arProperty = $rsProperties->Fetch())
	{

//????????????? ????? -------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//print_r($arProperty);
		if ($arProperty["VALUE"] && $arProperty["NAME"]){
			$rsFile = CFile::GetByID($arProperty["VALUE"]);
			$arFile = $rsFile->Fetch();

//??? ????????? [ORIGINAL_NAME] ?? ???? ???????? ????? ----
			$file_len = strrpos($arFile["ORIGINAL_NAME"], '.');
			$file_name = substr($arFile["ORIGINAL_NAME"], 0, $file_len);
			$file_type = substr($arFile["ORIGINAL_NAME"], $file_len+1, strlen($arFile["ORIGINAL_NAME"])-$file_len);
			$file_name = intval($file_name);
//??? ????????? [ORIGINAL_NAME] ?? ???? ???????? ????? ---- end

			$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];


				if($arProperty["DESCRIPTION"])
				{
?>
<div style="padding: 10px 0px 0px 0px; color: 
<li style="padding: 10px 0px 0px 0px; color: black;"><a class="news_date_nav" href="<?=$filename?>" style="font: 10pt/10pt Arial, sans-serif;">
<?
					?><?=$arParams["NAME"];?><?
					if ($DATE_VIEW) {
						$arDATE = ParseDateTime($arParams["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
						?> (<?=$arDATE["DD"];?>.<?=$arDATE["MM"];?>.<?=$arDATE["YYYY"];?>) <?
					}
					?> <nobr><small>(<?=byteCount($arFile["FILE_SIZE"]);?>)</small></nobr><?
?>
</a></li>
<?
				}
		}
	}
*/

?>

<div id="yw0" class="yiiTab">
<ul class="tabs">
<li><a href="#tab1" class="active">????? ????????</a></li>
<li><a class="" href="#tab2">?????????</a></li>
</ul>
<div style="display: block;" class="view" id="tab1"><?// ???????? 1 -------------------------------------------------------------------------------------------------------------------------?>
<?
	if (strlen($arResult["DETAIL_TEXT"])>0){?>
		<div class="static_text"><?=$arResult["DETAIL_TEXT"]?></div>
<?	}?>
</div><!-- tab1 -->
<div class="view" id="tab2" style="display: none;"><?// ???????? 2 -------------------------------------------------------------------------------------------------------------------------?>

 <table width="100%" border="0" cellpadding="0" cellspacing="0">

<?if ($arPropertyD['rmu_status']['VALUE_ENUM'] != ""){?>
	<tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
?????? ?????????:
	</td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
<B><?=$arPropertyD['rmu_status']['VALUE_ENUM'];?></B>
	</td></tr>
<?}?>

<?if ($arResult['ACTIVE_FROM'] != ""){
$date_active_from_mk = MkDateTime($DB->FormatDate($arResult["ACTIVE_FROM"], Clang::GetDateFormat("SHORT"), "DD.MM.YYYY"), "d.m.Y");
?>
	<tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
???? ?????????? ?? ?????:
	</td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
<B><?=date("d.m.Y", $date_active_from_mk);?></B>
	</td></tr>
	<tr><td width="30%" class=le="padding: 0px 0px 10px 0px;">
<B><?=date("d.m.Y", $date_active_from_mk);?> - <?=date("d.m.Y", dateAfterMonth
	(
	date("m", $date_active_from_mk),
	date("d", $date_active_from_mk),
	date("Y", $date_active_from_mk)
	));?></B>
	</td></tr>
<?}?>

	<tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
?????????:
	</td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
<?	while (list($key, $arProperty) = each($arResult["PROPERTIES"]))
	{
		if ($arProperty["VALUE"] && $arProperty["NAME"] && $arProperty["PROPERTY_TYPE"] == "F" && $arProperty["ACTIVE"] == "Y"){
			$rsFile = CFile::GetByID($arProperty["VALUE"]);
			$arFile = $rsFile->Fetch();

			$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];
			?><a href="<?=$filename?>"><b><?
				if($arProperty["DESCRIPTION"]){?><?=$arProperty["DESCRIPTION"];?><?}else{?><?=$arProperty["NAME"];?><?}
				?></B> (<?=byteCount($arFile["FILE_SIZE"])?>)</a><BR><?
		}
	}
	?>
	</td></tr>

<?if ($arPropertyD['rmu_inform']['VALUE'] != ""){?>
	<tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
?????????? ??????????:
	</td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
<B><?=$arPropertyD['rmu_inform']['VALUE'];?></B>
	</td></tr>
<?}?>

 </table>

</div><!-- tab2 -->
</div>

<?/*
 <table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
	<tr><td width="100%" height="16" colspan="2" class="news" style="padding-bottom: 5px;">
<?
	if (is_array($arResult["DETAIL_PICTURE"])){?>
		<div class="news_img" style="width: <?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>; float: left;"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" hspace="0" vspace="2" align="left" border="0"></div>
<?	}
	elseif(is_array($arOfficer) && $arResult["PROPERTIES"]["STR_OFFICER"]["ile::GetByID($arOfficer["DETAIL_PICTURE"]);
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
*/?>
 <BR>

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
jQuery("#yw0").yiitab();
});
/*]]>*/
</script>

<?
//------------------------------------------------------------
$GLOBALS["BACK_PAGE"]["NAME"] = GetMessage("T_NEWS_DETAIL_BACK");
$GLOBALS["BACK_PAGE"]["URL"] = "?";
//------------------------------------------------------------
?>