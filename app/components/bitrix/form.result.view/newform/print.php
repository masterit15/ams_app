<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (isset($arParams["F_RIGHT"])) {
  if ($arParams["F_RIGHT"]<25) die();
  $listMode = true;
} else {
  $listMode = false;
  if ($arResult["isAccessFormResultEdit"] != "Y") die();
}
while (@ob_end_clean()); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<style>
h1 {
  font-family: Verdana;
  font-size: 12pt;
}
body {
  font-family: Verdana;
  font-size: 9pt;
  color: black;
}
hr {  margin: 30px 10px; page-break-after: always; }
</style>
<body onload="window.print()">
<?
if ($listMode) {   
$i = 0;
$c = count($arResult["arrResults"]);
  foreach ($arResult["arrResults"] as $arPrint) { 
  echo '';
$i++;
    $DBRes = CFormResult::GetByID($arPrint["ID"]);
    if ($arResultData = $DBRes->Fetch()) {
      $arParams["WEB_FORM_ID"] = intval($arResultData["FORM_ID"]);
	  if (intval($arParams["WEB_FORM_ID"]) <= 0) $arParams["WEB_FORM_ID"] = intval($_REQUEST["WEB_FORM_ID"]);
	  $arParams["WEB_FORM_ID"] = CForm::GetDataByID($arParams["WEB_FORM_ID"], $arPrint["arForm"], $arPrint["arQuestions"], $arPrint["arAnswers"], $arPrint["arDropDown"], $arPrint["arMultiSelect"], "ALL");
	  if ($arParams["WEB_FORM_ID"] == 0) continue;
	  $arPrint["arResultData"] = $arResultData;
	  CForm::GetResultAnswerArray($arParams["WEB_FORM_ID"], $arPrint["arrResultColumns"], $arPrint["arrVALUES"], $arPrint["arrResultAnswersSID"], array("RESULT_ID" => $arPrint["ID"]));
	  $arPrint["arrVALUES"] = $arPrint["arrVALUES"][$arPrint["ID"]];
	  
	  $arPrint = array_merge(
			$arPrint,
			array(
				"RESULT_ID" => $arPrint["ID"], // web form id
				"WEB_FORM_ID" => $arParams["WEB_FORM_ID"], // web form id
				"RESULT_DATE_CREATE" => $arPrint["arResultData"]["DATE_CREATE"],
				"RESULT_STAT_SESSION_ID" => $arPrint["arResultData"]["STAT_SESSION_ID"]
			)
		);		
      $arPrint["RESULT"] = array();
	  foreach ($arPrint["arQuestions"] as $arQuestion)	{ 
	    $FIELD_SID = $arQuestion["SID"];
		$arPrint["RESULT"][$FIELD_SID] = array(
		  "CAPTION" => // field caption
		  $arPrint["arQuestions"][$FIELD_SID]["TITLE_TYPE"] == "html" ? 
		  $arPrint["arQuestions"][$FIELD_SID]["TITLE"] : 
		  nl2br(htmlspecialchars($arPrint["arQuestions"][$FIELD_SID]["TITLE"])), 
		  "ANSWER_VALUE" => $arPrint["arrVALUES"][$arQuestion["ID"]]
		);			
		$out = "";
		$arResultAnswers = array();
		if (is_array($arPrint["RESULT"][$FIELD_SID]["ANSWER_VALUE"])) {
		  $count = count($arPrint["RESULT"][$FIELD_SID]["ANSWER_VALUE"]);
		  $i=0;
		  foreach ($arPrint["RESULT"][$FIELD_SID]["ANSWER_VALUE"] as $key => $arrA) {
		    $i++;
			$arResultAnswer = array();
			if (strlen(trim($arrA["USER_TEXT"]))>0) {
			  if (intval($arrA["USER_FILE_ID"])>0) {
			    if ($arrA["USER_FILE_IS_IMAGE"]=="Y" && $USER->IsAdmin()) $arResultAnswer["USER_TEXT"] = htmlspecialchars($arrA["USER_TEXT"]);
			  } else $arResultAnswer["USER_TEXT"] = TxtToHTML(trim($arrA["USER_TEXT"]),true,50);
			}
			if (strlen(trim($arrA["USER_DATE"]))>0)	$arResultAnswer["USER_TEXT"] = $DB->FormatDate($arrA["USER_DATE"], FORMAT_DATETIME, FORMAT_DATE);
			$arResultAnswers[] = $arResultAnswer;
		  }
		}
		$arPrint["RESULT"][$FIELD_SID]["ANSWER_VALUE"] = $arResultAnswers;
	  }
    } else continue;
    include('item.php');
	if ($i<$c) echo "<hr>\n";
  }
} else {
  $arPrint = $arResult;
  include('item.php');
}
?>
</body>
</html>
