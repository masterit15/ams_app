<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//$APPLICATION->AddChainItem($arPath['NAME'], $arPath['SECTION_PAGE_URL']);?>
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
<div class="content">
	<div class="row">
	  <p class="col-sm-3"><small>Наименование услуги</small></p>
	  <p class="col-sm-3"><small><nobr>Исполнитель услуги</nobr> <nobr>(разработчик регламента)</nobr></small></p>
	  <p class="col-sm-2"><small><nobr>Дата размещения</nobr> проекта регламента на сайте</small></p>
	  <p class="col-sm-2"><small><nobr>Срок проведения</nobr> независимой экпертизы</small></p>
	  <p class="col-sm-2"><small>Статус</small></p>
	</div>
	
<?
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------
$arResult = $arStruktura;
if (!empty($arResult)){
   $l=0;
   $sub_str="";
   foreach($arResult as $arItem):

//ЗАГОЛОВОК ------------------
//   Вывод информации о СФЕРЕ услуг -----------------------------------------------------------------------------------------------------------------------------------------------------------
?>
<h3 class="static_text"><?=$arItem['NAME'];?></h3>
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
	}elseif	($arItem['NAME'] != " " && $arItem['NAME'] != "-" && $arItem['NAME'] != "_"){
		$arSelect = Array("ID", "NAME", "SORT");
		$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
					"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
					"ACTIVE"	=>	"Y",
					"SECTION_ID"	=>	$arItem["ID"]
				);
		$res = CIBlockElement::GetList(Array("NAME"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), array());

		$l++;
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			if($arFields['NAME'] != " " && $arFields['NAME'] != "-" && $arFields['NAME'] != "_"){

?>
<div class="table_row row">
<?
//   Вывод информации об УСЛУГЕ ---------------------------------------------------------------------------------------------------------------------------------------------------------------
	$arPropertyD = Array();
	$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arFields["ID"], "SORT", "ASC", array("ACTIVE"=>"Y"));
	while($arProperty = $rsProperties->Fetch())
	{
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
$date_active_from_mk = MkDateTime($DB->FormatDate($arFields["ACTIVE_FROM"], Clang::GetDateFormat("SHORT"), "DD.MM.YYYY"), "d.m.Y");
?>
	<div class="col-sm-3 np">
		<p><a href="?IBLOCK_ID=<?=$arParams['IBLOCK_ID'];?>&SECTION_ID=0&ELEMENT_ID=<?=$arFields['ID'];?>" class=\"submenu_l3\"><?=$arFields['NAME'];?></a></p>
	</div>
	<div class="col-sm-3 np">
		<p><?=$arPropertyD['rmu_ispolnitel']['VALUE'];?></p>
	</div>
	<div class="col-sm-2 np">
		<p><center><?=date("d.m.Y", $date_active_from_mk);?></center></p>
	</div>
	<div class="col-sm-2 np">
		<p><center><?=date("d.m.Y", $date_active_from_mk);?> - <?=date("d.m.Y", dateAfterMonth(date("m", $date_active_from_mk),date("d", $date_active_from_mk),date("Y", $date_active_from_mk)));?></center></p>
	</div>
	<div class="col-sm-2 np">
		<p><center><?=$arPropertyD['rmu_status']['VALUE_ENUM'];?></center></p>
	</div>
</div>
<?
			}
		}
		$l--;
?>
<?

//КОНЕЦ ----------------------
	}

   endforeach;

   if (strlen($sub_str) > 0){
?>
</div>
<?
   }
}

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