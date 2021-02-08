<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
global $USER, $APPLICATION, $MESS;

if(!CModule::IncludeModule("iblock"))
	return;

//print_r($arResult);
//print_r($arParams);

//--Считывает информацию о папке ---------------------------------------------------------------------------------------------------------------------------------------
	$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
				"ACTIVE"	=>	"Y",
				"ID"		=>	$arResult["VARIABLES"]["SECTION_ID"]
			);
	$res1 = CIBlockSection::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false);
	while($arFields1 = $res1->Fetch())
	{
		if(!$arFields1) require("sections.php");
		else{
			//--Задает заголовок страницы -------------------------------------------------------------------------------------------------------------------
			$APPLICATION->SetTitle($arFields1["NAME"]);

			$this_SECTION_ID = $arResult["VARIABLES"]["SECTION_ID"];

			//--Разработка индекса сортировки----------------------------------------------------------------------------------------------------------------
			$arSORT_INDEX = array();
			$arSelect = Array("ID", "NAME", "SORT");
			$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
						"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
						"ACTIVE"	=>	"Y",
						"SECTION_ID"	=>	$this_SECTION_ID
					);
			$resSORT = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
			while($arSORT = $resSORT->Fetch())
			{
				if ($arSORT["NAME"] == " " || $arSORT["NAME"] == "-" || $arSORT["NAME"] == "_"){
					//--Считывает дополнительную информацию из папки о элементе ----------------------------------------------------------------------------
					$db_props = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arSORT["ID"], "sort", "asc",array("CODE"=>"STR_OFFICER"));
					while($ar_props = $db_props->Fetch()){
						$arSelect = Array("NAME");
						$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
									"IBLOCK_ID"	=>	$ar_props["LINK_IBLOCK_ID"],
									"ACTIVE"	=>	"Y",
									"ID"		=>	$ar_props["VALUE"]
								);
						$resSORT2 = CIBlockElement::GetList(0, $arFilter, false, 0, $arSelect);
						while($arSORT2 = $resSORT2->Fetch())
							$arSORT["NAME"] = $arSORT2["NAME"];
					}
				}
				$arSORT_INDEX[] = array("NAME"=>$arSORT["NAME"], "SORT"=>$arSORT["SORT"], "ID"=>$arSORT["ID"]);
			}
			$arSORT_INDEX=php_multisort($arSORT_INDEX, array(array('key'=>'SORT','sort'=>'asc'),array('key'=>'NAME')));


			while(list( $key, $val ) = each($arSORT_INDEX)){
				//--Считывает информацию из папки о элементе ----------------------------------------------------------------------------------------------------
				$arSelect = Array("ID", "NAME", "SORT", "DETAIL_PICTURE", "DETAIL_TEXT");
				$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
							"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
							"ACTIVE"	=>	"Y",
							"SECTION_ID"	=>	$this_SECTION_ID,
							"ID"		=>	$val["ID"]
						);
				$res2 = CIBlockElement::GetList(Array("SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
				while($arResult = $res2->Fetch())
				{
					//--Считывает дополнительную информацию из папки о элементе ----------------------------------------------------------------------------
					$db_props = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arResult["ID"], "sort", "asc");
					while($ar_props = $db_props->Fetch())
						$arResult["PROPERTIES"][$ar_props["CODE"]] = $ar_props;
					require("bitrix/catalog.element/.default/template.php");
				}
			}
		}
	}
//------------------------------------------------------------
require("bitrix/catalog.element/.default/lang/".LANGUAGE_ID."/template.php");
$GLOBALS["BACK_PAGE"]["NAME"] = GetMessage("T_NEWS_DETAIL_BACK");
$GLOBALS["BACK_PAGE"]["URL"] = "?";
//------------------------------------------------------------

//--FUNCTIONS-----------------------------------------------------------------------------------------------------------------------------------------------------------
function php_multisort($data,$keys){ 
  // List As Columns 
  foreach ($data as $key => $row) { 
    foreach ($keys as $k){ 
      $cols[$k['key']][$key] = $row[$k['key']]; 
    } 
  } 
  // List original keys 
  $idkeys=array_keys($data); 
  // Sort Expression 
  $i=0; 
  foreach ($keys as $k){ 
    if($i>0){$sort.=',';} 
    $sort.='$cols['.$k['key'].']'; 
    if($k['sort']){$sort.=',SORT_'.strtoupper($k['sort']);} 
    if($k['type']){$sort.=',SORT_'.strtoupper($k['type']);} 
    $i++; 
  } 
  $sort.=',$idkeys'; 
  // Sort Funct 
  $sort='array_multisort('.$sort.');'; 
  eval($sort); 
  // Rebuild Full Array 
  foreach($idkeys as $idkey){ 
    $result[$idkey]=$data[$idkey]; 
  } 
  return $result; 
} 
?>
