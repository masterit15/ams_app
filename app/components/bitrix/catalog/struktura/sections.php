<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<? 
if(!$arParams["SECTION_ID"]) $arParams["SECTION_ID"] = $GLOBALS["SECTION_ID"]; 
IncludeTemplateLangFile(__FILE__);
global $USER, $APPLICATION; 
$arStruktura = Array();
$arSi = 0; 
if(!CModule::IncludeModule("iblock")) return; 
$arFilter = Array(
  "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], 
  "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
  "ACTIVE" => "Y", 
  "SECTION_ID" => $arParams["SECTION_ID"] 
);
$IIIIIIIIII1l = CIBlockSection::GetList(Array(
  "SORT"=>"ASC", 
  "PROPERTY_PRIORITY"=>"ASC"
), $arFilter, false); 
while($IIIIIIIIII11 = $IIIIIIIIII1l->GetNext()) { 
  $arStruktura[$arSi]['ID'] = $IIIIIIIIII11['ID']; 
  $arStruktura[$arSi]['NAME'] = $IIIIIIIIII11['NAME']; 
  $arStruktura[$arSi]['SORT'] = $IIIIIIIIII11['SORT']; 
  $arStruktura[$arSi]['SECTION'] = true; $arSi++; 
} 
$arSelect = Array("ID", "NAME", "SORT"); 
$arFilter = Array(
  "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], 
  "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
  "ACTIVE" => "Y", 
  "SECTION_ID" => $arParams["SECTION_ID"] 
);
$IIIIIIIIII1l = CIBlockElement::GetList(Array(
  "SORT"=>"ASC", 
  "PROPERTY_PRIORITY"=>"ASC"
), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($IIIIIIIIII11 = $IIIIIIIIII1l->GetNextElement()) { 
  $arFields = $IIIIIIIIII11->GetFields(); 
  $arStruktura[$arSi]['ID'] = $arFields['ID'];
  $arStruktura[$arSi]['NAME'] = $arFields['NAME'];
  $arStruktura[$arSi]['SORT'] = $arFields['SORT'];
  $arStruktura[$arSi]['SECTION'] = false; $arSi++; 
}
function IIIIIIIIIIII($IIIIIIIIIlI1, $IIIIIIIIIllI) { 
  if ($IIIIIIIIIlI1['SORT'] == $IIIIIIIIIllI['SORT']) return 0; 
  return ($IIIIIIIIIlI1['SORT'] > $IIIIIIIIIllI['SORT']) ? 1 : -1; 
}
usort($arStruktura, IIIIIIIIIIII); 
$arResult = $arStruktura;
if (!empty($arResult)) {
  $IIIIIIIIIll1=0; 
  $IIIIIIIIIl1I=""; 
  foreach($arResult as $arItem): 
    if (!$arItem['SECTION']){ 
      if($arItem['NAME'] == " " || $arItem['NAME'] == "-" || $arItem['NAME'] == "_"){ 
	    $IIIIIIIIIl11 = CIBlockElement::GetProperty(
	      $arParams["IBLOCK_ID"], 
		  $arItem["ID"], 
		  "sort", 
		  "asc",
		  array("CODE"=>"STR_OFFICER")
	    ); 
	    $IIIIIIIII1II = $IIIIIIIIIl11->Fetch(); 
	    $arSelect = Array("ID", "NAME"); 
	    $arFilter = Array(
	      "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], 
		  "IBLOCK_ID" => $IIIIIIIII1II["LINK_IBLOCK_ID"], 
		  "ACTIVE" => "Y", 
		  "ID" => $IIIIIIIII1II["VALUE"]
	    );
	    $IIIIIIIIII1l = CIBlockElement::GetList(
	      0, 
		  $arFilter, 
		  false, 
		  0, 
		  $arSelect
	    );
	    $arOfficer = $IIIIIIIIII1l->Fetch(); 
	    if($arOfficer['NAME'] != "") $arItem['NAME'] = $arOfficer['NAME'];
	  }
	  if ($arItem['NAME'] != " " && $arItem['NAME'] != "-" && $arItem['NAME'] != "_") {
	    $IIIIIIIIIl1I .= " <tr><td align=\"left\" valign=\"bottom\" height=\"4\" style=\"padding: 4px 10px 0px ".(0+(15*$IIIIIIIIIll1))."px;\"><b    ><a href=\"?IBLOCK_ID=".$arParams['IBLOCK_ID']."&SECTION_ID=0&ELEMENT_ID=".$arItem['ID']."\" class=\"submenu_l3\">".$arItem['NAME']."</a></b    ></td></tr> <tr><td align=\"left\" valign=\"bottom\" height=\"5\"></td></tr>"; 
	  }
    } elseif ($arItem['NAME'] != " " && $arItem['NAME'] != "-" && $arItem['NAME'] != "_") { 
	  $arSelect = Array("ID", "NAME", "SORT"); 
	  $arFilter = Array( 
	    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"], 
		"IBLOCK_ID" => $arParams["IBLOCK_ID"], 
		"ACTIVE" => "Y", 
		"SECTION_ID" => $arItem["ID"] 
	  ); 
	  $IIIIIIIIII1l = CIBlockElement::GetList(
	    Array(
          "SORT"=>"ASC", 
		  "NAME"=>"ASC", 
		  "PROPERTY_PRIORITY"=>"ASC"
		), 
		$arFilter, 
		false, 
		Array("nPageSize"=>50), $arSelect
	  );
	  $IIIIIIIII1I1 = "";
	  $IIIIIIIIIll1++;
	  while( $IIIIIIIIII11 = $IIIIIIIIII1l->GetNextElement()) { 
	    $arFields = $IIIIIIIIII11->GetFields(); 
		if($arFields['NAME'] != " " && $arFields['NAME'] != "-" && $arFields['NAME'] != "_") { 
		  $IIIIIIIII1I1.= " <tr><td align=\"left\" valign=\"bottom\" height=\"4\" style=\"padding: 2px 10px 0px ".(10+(15*$IIIIIIIIIll1))."px;\">- <a href=\"?IBLOCK_ID=".$arParams['IBLOCK_ID']."&SECTION_ID=".$arItem['ID']."&ELEMENT_ID=".$arFields['ID']."\" class=\"submenu_l2\">".$arFields['NAME']."</a></td></tr>"; } } $IIIIIIIIIll1--; if(strlen($IIIIIIIII1I1) == 0){ $IIIIIIIIIl1I.= " <tr><td align=\"left\" valign=\"bottom\" height=\"4\" style=\"padding: 4px 10px 0px ".(0+(15*$IIIIIIIIIll1))."px;\"><b    ><a href=\"?IBLOCK_ID=".$arParams['IBLOCK_ID']."&SECTION_ID=".$arItem['ID']."\" class=\"submenu_l3\">".$arItem['NAME']."</a></b   ></td></tr> <tr><td align=\"left\" valign=\"bottom\" height=\"5\"></td></tr>"; }else{ $IIIIIIIIIl1I.= " <tr><td align=\"left\" valign=\"bottom\" height=\"20\" style=\"padding: 10px 10px 0px".(7+(15*$IIIIIIIIIll1))."px;\"><b    ><font class=\"submenu_l3\">".$arItem['NAME']."</font></b    ></td></tr> <tr><td align=\"left\" valign=\"bottom\" height=\"5\" background=\"/bitrix/templates/AMS/images/submenu_divfill.gif\"></td></tr>". $IIIIIIIII1I1; } unset($IIIIIIIII1I1); } endforeach; if (strlen($IIIIIIIIIl1I) > 0){ ?> <table id="submenu-multilevel" width="100%" height="10" border="0" cellpadding="0" cellspacing="0" style="padding-left: 10px;"> <ul id="submenu-multilevel"><?echo $IIIIIIIIIl1I;?></ul> </table> <? } } ?>
