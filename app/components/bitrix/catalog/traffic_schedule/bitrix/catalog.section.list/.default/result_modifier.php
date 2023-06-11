<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
$rsStations = CIBlockElement::GetList(array('SORT'=>'ASC'),array('IBLOCK_ID'=>$arParams['IBLOCK_ID']),false,false,array('NAME','IBLOCK_SECTION_ID'));
$arResult['STATIONS'] = array();
while ($arStation = $rsStations->GetNext()) {
	$arResult['STATIONS'][$arStation['IBLOCK_SECTION_ID']][] = $arStation['NAME'];
}


?>