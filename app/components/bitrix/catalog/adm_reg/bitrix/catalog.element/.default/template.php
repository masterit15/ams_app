<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//--Функции----------------------------------------------------------------------------

if(!function_exists("dateAfterMonth")){
function dateAfterMonth($m,$d,$y) // Прибовляет 1 месяц
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

//   Вывод информации об УСЛУГЕ ---------------------------------------------------------------------------------------------------------------------------------------------------------------

//print_r($arParams);

//	Наименование услуги	- $arResult['NAME']
//	Дата размещения		- $arResult['ACTIVE_FROM']
//	Общие сведения		- $arResult['DETAIL_TEXT']

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
//   Вывод ДОПОЛНИТЕЛЬНОЙ информации об услуге ------------------------------------------------------------------------------------------------------------------------------------------------

//	Статус документа	- $arPropertyD['rmu_status']
//	Исполнитель услуги	- $arPropertyD['rmu_ispolnitel']
//	Контактная информация	- $arPropertyD['rmu_inform']

//print_r($arPropertyD);

/*
	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], "SORT", "ASC", array("ACTIVE"=>"Y","PROPERTY_TYPE"=>"F"));
	while($arProperty = $rsProperties->Fetch())
	{

//ПРИКРЕПЛЕННЫЕ ФАЙЛЫ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//print_r($arProperty);
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
</a></div>
<?
				}else{
?>
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
<section class="tabs">

<ul class="tabs">
	<li class="active">Общие сведения</li>
	<li>Регламент</li>
</ul>
<ul class="tab__content">
	<li class="active">
		<div class="content__wrapper">
			<?if (strlen($arResult["DETAIL_TEXT"])>0){?>
					<div class="static_text"><?=$arResult["DETAIL_TEXT"]?></div>
			<?}?>
		</div>
	</li>
	<li>
	<div class="content__wrapper">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">

		 <?if ($arPropertyD['rmu_status']['VALUE_ENUM'] != ""){?>
			 <tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 Статус документа:
			 </td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 <B><?=$arPropertyD['rmu_status']['VALUE_ENUM'];?></B>
			 </td></tr>
		 <?}?>
		 
		 <?if ($arResult['ACTIVE_FROM'] != ""){
		 $date_active_from_mk = MkDateTime($DB->FormatDate($arResult["ACTIVE_FROM"], Clang::GetDateFormat("SHORT"), "DD.MM.YYYY"), "d.m.Y");
		 ?>
			 <tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 Дата размещения на сайте:
			 </td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 <B><?=date("d.m.Y", $date_active_from_mk);?></B>
			 </td></tr>
			 <tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 Срок проведения независимой экпертизы:
			 </td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
		 <B><?=date("d.m.Y", $date_active_from_mk);?> - <?=date("d.m.Y", dateAfterMonth
			 (
			 date("m", $date_active_from_mk),
			 date("d", $date_active_from_mk),
			 date("Y", $date_active_from_mk)
			 ));?></B>
			 </td></tr>
		 <?}?>
		 
			 <tr><td width="30%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
				Документы:
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
				Контактная информация:
					</td><td width="70%" class="news" valign="top" style="padding: 0px 0px 10px 0px;">
				<B><?=$arPropertyD['rmu_inform']['VALUE'];?></B>
					</td></tr>
				<?}?>
			</table>
		</div>
	</li>
</ul>
</section>
<?
//------------------------------------------------------------
$GLOBALS["BACK_PAGE"]["NAME"] = GetMessage("T_NEWS_DETAIL_BACK");
$GLOBALS["BACK_PAGE"]["URL"] = "?";
//------------------------------------------------------------
?>