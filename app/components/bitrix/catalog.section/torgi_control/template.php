<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//$APPLICATION->AddChainItem($arParams["~PAGER_TITLE"], "?");?>
<BR>
<?
//------------------------------------------------------------
//   $GLOBALS["$XML_ID"] = 7;		//уникальный ID раздела отображаемого в структуре
if(CModule::IncludeModule("iblock")){
//	$getXML_ID = GetIBlock(3);		//Узнать уникальный XML_ID введя SECTION_ID.
//	echo "<hr>XML_ID = <B>".$getXML_ID["XML_ID"]."</B> [".$getXML_ID["NAME"]."]<hr>";$GLOBALS["$XML_ID"] = $getXML_ID["XML_ID"];
   $iblocks = GetIBlockList("torgi","control");	//Имя (ID)  "Типа информ. блока", Символьный код (ID) "Информ. блока"
   $iblocks = $iblocks->GetNext();
   $iblocks = $iblocks["ID"];
//   $iblocks = GetIBlockSectionList($iblocks,false,Array(),0,Array("XML_ID" => $GLOBALS["$XML_ID"]));
//   $iblocks = $iblocks->GetNext();
//   $iblocks = $iblocks["ID"];
   //---------------------------------------------------------
   $GLOBALS["SECTION_ID"] = $iblocks;			//ID раздела отображаемого в структуре
//   $_REQUEST["SECTION_ID"] = $GLOBALS["SECTION_ID"];
}
if(CModule::IncludeModule("iblock")){
//	$getXML_ID = GetIBlock(3);		//Узнать уникальный XML_ID введя SECTION_ID.
//	echo "<hr>XML_ID = <B>".$getXML_ID["XML_ID"]."</B> [".$getXML_ID["NAME"]."]<hr>";$GLOBALS["$XML_ID"] = $getXML_ID["XML_ID"];
   $iblocks_log = GetIBlockList("torgi","control_log");	//Имя (ID)  "Типа информ. блока", Символьный код (ID) "Информ. блока"
   $iblocks_log = $iblocks_log->GetNext();
   $iblocks_log = $iblocks_log["ID"];
//   $iblocks = GetIBlockSectionList($iblocks,false,Array(),0,Array("XML_ID" => $GLOBALS["$XML_ID"]));
//   $iblocks = $iblocks->GetNext();
//   $iblocks = $iblocks["ID"];
   //---------------------------------------------------------
   $GLOBALS["SECTION_ID_log"] = $iblocks_log;			//ID раздела отображаемого в структуре
//   $_REQUEST["SECTION_ID"] = $GLOBALS["SECTION_ID"];
}

//------------------------------------------------------------

//--Функции----------------------------------------------------------------------------
if(!function_exists("byteCount")){
function byteCount ($x, $y = array("b","kb","mb")) {
	if ($x >= 1024 * 1000) 
		return((round(($x*100)/(1024*1024))/100) . " " . $y[2]);
	elseif ($x >= 1000)
		return(round($x/1024) . " " . $y[1]);
	else	return($x . " " . $y[0]);
}}

if(!function_exists("crc32_file")){
function crc32_file($fileName)				//определяет CRC значение файла
{
	if (!file_exists($fileName)) return "00000000";
	$crc = abs(crc32(file_get_contents($fileName)));
	if($crc & 0x80000000){$crc ^= 0xffffffff;$crc += 1;}
	return $crc;
}}

if(!function_exists("Clear_array_empty")){
function Clear_array_empty($array)
{
	$ret_arr = array();
	foreach($array as $key=>$val)
	{
//	    if (!empty($val))		//если массив равен 0 тогда тоже удаляет
	    if ($val != "")		//удаляет только пустой "" массив
	    {
	        $ret_arr[] = trim($val);
	    }
	}
	return $ret_arr;
}}

if(!function_exists("Find_array_element")){ //ищит позицию элемента в массиве
function Find_array_element($array,$value)
{
	for($i=0;$i<count($array);$i++){
		if($array[$i] == $value) return $i;
	}
	return -1;
}}

//-------------------------------------------------------------------------------------
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?><div class="news_date_nav"><B><?=$arResult["NAV_STRING"]?></B></div><?endif;?>
<table width="100%" height="14" border="0" cellpadding="0" cellspacing="0">
<?
	$buffer = "";
	foreach($arResult["ITEMS"] as $cell=>$arElement):

		$arSelect = Array(	"ID",
					"DATE_ACTIVE_FROM",
					"DETAIL_TEXT",
					"LOCK_STATUS",
					"TIMESTAMP_X",
					"USER_NAME"
				);
		$arFilter = Array(	"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
					"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
					"ACTIVE"	=>	"Y",
					"ID"		=>	$arElement["ID"]
				);
		$res = CIBlockElement::GetList(0, $arFilter, false, 0, $arSelect);
		$arElement = $res->Fetch();

		$CONT_ar = Array();
		$CONT_rs = Array();
		$CONT_in = Array();

		$CONT_iblocks = GetIBlockElementList($GLOBALS["SECTION_ID"],0,Array("ID"=>"DESC"),0,Array("NAME"=>$arParams["IBLOCK_ID"]."|".$arElement["ID"]));
		$CONT_iblocks = $CONT_iblocks->GetNext();
		if($CONT_iblocks){					// если IBLOCK не найден
			$CONT_rsProperties = CIBlockElement::GetProperty($GLOBALS["SECTION_ID"], $CONT_iblocks["ID"], "SORT", "ASC", array("ACTIVE"=>"Y"));
			while($CONT_arProperty = $CONT_rsProperties->Fetch())
			{
				if($CONT_arProperty["CODE"])
					$CONT_ar[$CONT_arProperty["CODE"]] = $CONT_arProperty["VALUE"];
			}
		}

		//Создание пустой базы (это необходимо)
		$CONT_rs["IBLOCK_ID"]	 = $arParams["IBLOCK_ID"];
		$CONT_rs["ID"]		 = $arElement["ID"];
		$CONT_rs["FILES_DATE"]	 = false;
		$CONT_rs["FILES_LastM"]	 = false;
		$CONT_rs["FILES_CRC"]	 = false;
		$CONT_rs["FILES_NAME"]	 = false;

		$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arElement["ID"], "SORT", "ASC", array("ACTIVE"=>"Y","PROPERTY_TYPE"=>"F"));
		while($arProperty = $rsProperties->Fetch())
		{

			if ($arProperty["VALUE"] && $arProperty["NAME"]){
				$rsFile = CFile::GetByID($arProperty["VALUE"]);
				$arFile = $rsFile->Fetch();

//ДЛЯ ИЗМЕНЕНИЯ [ORIGINAL_NAME] на ДАТУ СОЗДАНИЯ ФАЙЛА ----
				$file_len = strrpos($arFile["ORIGINAL_NAME"], '.');
				$file_name = substr($arFile["ORIGINAL_NAME"], 0, $file_len);
//				$file_type = substr($arFile["ORIGINAL_NAME"], $file_len+1, strlen($arFile["ORIGINAL_NAME"])-$file_len);
				$file_name = intval($file_name);
//ДЛЯ ИЗМЕНЕНИЯ [ORIGINAL_NAME] на ДАТУ СОЗДАНИЯ ФАЙЛА ---- end

				$filename = "/".COption::GetOptionString("main", "upload_dir", "upload")."/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"];

				$CONT_rs["FILES_DATE"]	.= $arProperty["CODE"] . "|" . $file_name . "|";
				$CONT_rs["FILES_LastM"]	.= $arProperty["CODE"] . "|" . filemtime($_SERVER["DOCUMENT_ROOT"] . $filename) . "|";
				$CONT_rs["FILES_CRC"]	.= $arProperty["CODE"] . "|" . crc32_file($_SERVER["DOCUMENT_ROOT"] . $filename) . "|";
				$CONT_rs["FILES_NAME"]	.= $arProperty["CODE"] . "|" . $filename . "|";

//				// 1230757200 - это 01.01.2009 00:00:00
//				$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
//				if(intval($arDATE["YYYY"]) >= 2009 && $file_name>=1230757200 && $file_name<2000000000)
//				$CONT_in[$arProperty["CODE"]]["DATE_ACTIVE_FROM"] = $file_name;

			}

				if($arProperty["DESCRIPTION"])
				$CONT_in[$arProperty["CODE"]]["DESCRIPTION"]	 = $arProperty["DESCRIPTION"];
				else
				$CONT_in[$arProperty["CODE"]]["DESCRIPTION"]	 = $arProperty["NAME"];

		}

	//$CONT_ar - это значение из базы данных Контроля
	//$CONT_rs - это значение из эллемента

		if($CONT_ar != $CONT_rs && !empty($CONT_ar) && !empty($CONT_rs))	//Если Массив эллемента не соответствует массиву из базы включается проверка
		{
/*
	echo "<pre>";
echo "<B>CONT_ar</B><BR>";
print_r($CONT_ar);
echo "<B>CONT_rs</B><BR>";
print_r($CONT_rs);
*/
			$rsFILES = Array();
			$arFILES = Array();

			$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);
			$rsFILES["FILES_DATE"] = explode( "|", $CONT_rs["FILES_DATE"] );
			$rsFILES["FILES_DATE"] = Clear_array_empty($rsFILES["FILES_DATE"]);
			$rsFILES_count = floor(count($rsFILES["FILES_DATE"])/2);
			$rsFILES["FILES_LastM"] = explode( "|", $CONT_rs["FILES_LastM"] );
			$rsFILES["FILES_LastM"] = Clear_array_empty($rsFILES["FILES_LastM"]);
			$rsFILES["FILES_CRC"] = explode( "|", $CONT_rs["FILES_CRC"] );
			$rsFILES["FILES_CRC"] = Clear_array_empty($rsFILES["FILES_CRC"]);
			$rsFILES["FILES_NAME"] = explode( "|", $CONT_rs["FILES_NAME"] );
			$rsFILES["FILES_NAME"] = Clear_array_empty($rsFILES["FILES_NAME"]);

			$arFILES["FILES_DATE"] = explode( "|", $CONT_ar["FILES_DATE"] );
			$arFILES["FILES_DATE"] = Clear_array_empty($arFILES["FILES_DATE"]);
			$arFILES_count = floor(count($arFILES["FILES_DATE"])/2);
			$arFILES["FILES_LastM"] = explode( "|", $CONT_ar["FILES_LastM"] );
			$arFILES["FILES_LastM"] = Clear_array_empty($arFILES["FILES_LastM"]);
			$arFILES["FILES_CRC"] = explode( "|", $CONT_ar["FILES_CRC"] );
			$arFILES["FILES_CRC"] = Clear_array_empty($arFILES["FILES_CRC"]);
			$arFILES["FILES_NAME"] = explode( "|", $CONT_ar["FILES_NAME"] );
			$arFILES["FILES_NAME"] = Clear_array_empty($arFILES["FILES_NAME"]);
//-Сбор списка имен файлов с двух баз (rs и ar) ---------------------------------------------------
			$bufFILESname = Array();				
			for($i=0;$i<$rsFILES_count;$i++)
				$bufFILESname[] = $rsFILES["FILES_DATE"][$i*2];

			for($i=0;$i<$arFILES_count;$i++)
				$bufFILESname[] = $arFILES["FILES_DATE"][$i*2];

			$bufFILESname = array_unique($bufFILESname);		//Убрать дубликаты
			sort($bufFILESname);
//-------------------------------------------------------------------------------------------------

			$FILES_count = count($bufFILESname);

			$buffer.= "<tr><td align=\"left\" rowspan=\"".$FILES_count."\" valign=\"top\" width=\"45%\" height=\"9\" colspan=\"2\" style=\"padding: 0px 5px 10px 0px;border-bottom:1px solid black;\">\n";
			$buffer.= "<p class=\"static_text\"><B>".$arDATE["DD"].".".$arDATE["MM"].".".$arDATE["YYYY"]."</B><BR>".$arElement["DETAIL_TEXT"];
/*?><pre><?
print_r($arElement);
?><hr><?*/
			$buffer.= "</p></td>\n";

			for($i=0;$i<$FILES_count;$i++)
			{
				$find_colFILES_NAME = Array("FILES_DATE","FILES_LastM","FILES_CRC","FILES_NAME");
				$find_FILES = Array();
				$find_FILES["name"] = $bufFILESname[$i];

				$find_FILES["rs"]["id"] = Find_array_element($rsFILES["FILES_DATE"],$bufFILESname[$i]);
				if(Find_array_element($rsFILES["FILES_DATE"], $bufFILESname[$i]) != -1)
					$find_FILES["rs"]["find"] = true;
				else	$find_FILES["rs"]["find"] = false;

				$find_FILES["ar"]["id"] = Find_array_element($arFILES["FILES_DATE"],$bufFILESname[$i]);
				if(Find_array_element($arFILES["FILES_DATE"], $bufFILESname[$i]) != -1)
					$find_FILES["ar"]["find"] = true;
				else	$find_FILES["ar"]["find"] = false;

				for($j=0;$j<count($find_colFILES_NAME);$j++)
				{
					if($find_FILES["rs"]["find"])
						$find_FILES["rs"][$find_colFILES_NAME[$j]] = $rsFILES[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]], $bufFILESname[$i])+1];
					else	$find_FILES["rs"][$find_colFILES_NAME[$j]] = false;

					if($find_FILES["ar"]["find"])
						$find_FILES["ar"][$find_colFILES_NAME[$j]] = $arFILES[$find_colFILES_NAME[$j]][Find_array_element($arFILES[$find_colFILES_NAME[$j]], $bufFILESname[$i])+1];
					else	$find_FILES["ar"][$find_colFILES_NAME[$j]] = false;
				}

				if($find_FILES["rs"]["find"] && $find_FILES["ar"]["find"])
					$find_FILES["find"] = true;
				else	$find_FILES["find"] = false;
/*
?><PRE><?
print_r($find_FILES);
echo "[find: ".$find_FILES["name"]."]";
if ($find_FILES["rs"]["find"])
	echo "[".$find_FILES["rs"]["id"]."]";
else	echo "[X]";
echo "[".$find_FILES["rs"]["FILES_DATE"]."] = [".$find_FILES["ar"]["FILES_DATE"]."]";

				$FILEcheck = false;
echo "<B>[".$find_FILES["find"]."]</B>";
*/
				if (	$find_FILES["find"] &&
					$find_FILES["rs"]["FILES_DATE"] == $find_FILES["ar"]["FILES_DATE"]	&&
					$find_FILES["rs"]["FILES_CRC"] == $find_FILES["ar"]["FILES_CRC"]	)
					$FILEcheck = 1;		//Зеленый (дата старая, crc старый) - с файлом ничего не произошло
				else
				if (	$find_FILES["find"] && $arDATE["YYYY"] > 2009 &&
					$find_FILES["rs"]["FILES_DATE"] != $find_FILES["ar"]["FILES_DATE"]	&&
					$find_FILES["rs"]["FILES_CRC"] == $find_FILES["ar"]["FILES_CRC"]	)
					$FILEcheck = 1;		//Зеленый (дата другая (раньше небыло даты), crc старый) - с файлом ничего не произошло
				else
				if (	$find_FILES["find"] &&
					$find_FILES["rs"]["FILES_DATE"] > $find_FILES["ar"]["FILES_DATE"]	&&
					$find_FILES["rs"]["FILES_CRC"] == $find_FILES["ar"]["FILES_CRC"]	)
					$FILEcheck = 4;		//Ораньжевый (дата новая, crc старый) - файл корректно перезаписан заново (сам на себя)
				else
				if (	!$find_FILES["rs"]["find"] && $find_FILES["ar"]["find"]	)
					$FILEcheck = 5;		//Серый (в массиве rs нет информации) - файл корректно удален
				else
				if (	$find_FILES["rs"]["FILES_DATE"] != $find_FILES["ar"]["FILES_DATE"]	&&
					$find_FILES["rs"]["FILES_CRC"] != $find_FILES["ar"]["FILES_CRC"]	)
					$FILEcheck = 2;		//Желтый (дата новая, crc новый) - файл корректно загружен либо заменен на новый
				else
				if (	$find_FILES["find"] &&
					$find_FILES["rs"]["FILES_DATE"] == $find_FILES["ar"]["FILES_DATE"]	&&
					$find_FILES["rs"]["FILES_CRC"] != $find_FILES["ar"]["FILES_CRC"]	)
					$FILEcheck = 3;		//Красный (дата старая, crc новый) - изменен ТОЛЬКО сам файл

//echo "[".$FILEcheck."]<BR>";

				if($i!=0)
				$buffer.= "<tr>";
				$buffer.= "<td align=\"left\" valign=\"center\" width=\"55%\" height=\"9\" colspan=\"2\" style=\"padding: 0px 5px 0px 10px;";

				if ($i==($FILES_count-1))
				$buffer.= "border-bottom:1px solid black;";

				$buffer.= "\" bgcolor=\"#";
					    if($FILEcheck == 1)	$buffer.= "A9F9B4";
					elseif($FILEcheck == 2)	$buffer.= "F9F9B4";
					elseif($FILEcheck == 3)	$buffer.= "F99794";
					elseif($FILEcheck == 4)	$buffer.= "F9D497";
					elseif($FILEcheck == 5)	$buffer.= "CCCCCC";
					else			$buffer.= "FFFFFF";
				$buffer.= "\"><p class=\"static_text\"><small><B>";

					if ($arDATE["YYYY"] >= 2009)
						if ($FILEcheck == 5)
							$buffer.= date("d.m.Y",$find_FILES["ar"]["FILES_DATE"])." ".$CONT_in[$find_FILES["name"]]["DESCRIPTION"];
						else	$buffer.= date("d.m.Y",$find_FILES["rs"]["FILES_DATE"])." ".$CONT_in[$find_FILES["name"]]["DESCRIPTION"];
					else	$buffer.= $CONT_in[$find_FILES["name"]]["DESCRIPTION"];

//echo '<HR>'.date("d.m.Y",$find_FILES["rs"]["FILES_DATE"]).' '.$CONT_in[$find_FILES["name"]]["DESCRIPTION"].'<HR>';

				if ($FILEcheck == 2 || $FILEcheck == 4 || $FILEcheck == 5){

					$buffer.= "\n<big><BR>";

					    if ($FILEcheck == 4)
						$buffer.= "Перезаписан";
					elseif ($FILEcheck == 5)
						$buffer.= "Удален";
					elseif ($find_FILES["ar"]["FILES_LastM"] && $FILEcheck != 5 && $find_FILES["find"])
						$buffer.= "Заменен";
					else	$buffer.= "Загружен";

					    if ($FILEcheck != 5)
					$buffer.= ": ".date("d.m.Y H:i:s", $find_FILES["rs"]["FILES_LastM"]);

					    if ($find_FILES["ar"]["find"] && $find_FILES["ar"]["FILES_LastM"])
						$buffer.= "<BR>Создан: ".date("d.m.Y H:i:s", $find_FILES["ar"]["FILES_LastM"]);
					elseif ($FILEcheck != 5)
						$buffer.= "<BR>Новый файл";

					$buffer.= "</big>\n";

//-Подготовка к обновлению базы контроля, путем замены старыз дат и crc на новые----------------------------------------------------------------------------------------
//echo $GLOBALS["SECTION_ID"]." - ".$CONT_iblocks["ID"]."<BR>";
//echo "<pre>";
//print_r($find_FILES["rs"]);
//print_r($find_FILES["ar"]);
//					$arFILES_NAME = Array("FILES_DATE","FILES_LastM","FILES_CRC","FILES_NAME");
//					$rsFILES_new = Array();
					$rsFILES_new = $rsFILES;

					$buff			= Array();
					$buff["IBLOCK_ID"]	= $arParams["IBLOCK_ID"];
					$buff["ID"]		= $arElement["ID"];
//echo "<B>rsFILES_new</B><BR>";
//print_r($rsFILES_new);
//echo "<B>buff</B><BR>";
//print_r($buff);
//--------------------------------------------------------------------------------------------------------------------
					for($j=0;$j<count($find_colFILES_NAME);$j++){
						$rsFILES_new[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])]	= $rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]];
						$rsFILES_new[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])+1]	= $rsFILES[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])+1];
						reset($rsFILES_new[$find_colFILES_NAME[$j]]);
						while (list($key, $val) = each($rsFILES_new[$find_colFILES_NAME[$j]]))
							if($val != "")
								$buff[$find_colFILES_NAME[$j]]	.= $val . "|";
					}

//-Считать имя подраздела (Аукцион, Конкурс и т.д.)-------------------------------------------------------------------
					$arNAME = "";
					$res = CIBlock::GetByID($buff["IBLOCK_ID"]);
					if ($ar_res = $res->GetNext())
						$arNAME = $ar_res['NAME'];

//-Обновление базы контроля-------------------------------------------------------------------------------------------
					if(CModule::IncludeModule("iblock")){
						$el = new CIBlockElement;

						$arLoadProductArray = Array(
						  "ACTIVE"		=> "Y",            // активен
						  "NAME"		=> $buff["IBLOCK_ID"]."|".$buff["ID"],
						  "IBLOCK_TYPE"		=> $arParams["IBLOCK_TYPE"],
						  "IBLOCK_ID"		=> $GLOBALS["SECTION_ID"],
						  "PROPERTY_VALUES"	=> $buff
						  );
//print_r($arLoadProductArray);
						$PRODUCT_ID = $el->Update($CONT_iblocks["ID"],$arLoadProductArray);
//						if($PRODUCT_ID = $el->Update(($CONT_iblocks["ID"]-1),$arLoadProductArray))
//						  echo "New ID: ".$PRODUCT_ID;
//						else
//						  echo "Error: ".$el->LAST_ERROR;
//					}
//-Добавление лога в базу отчета контроля-----------------------------------------------------------------------------
//					if(CModule::IncludeModule("iblock")){
						$el2 = new CIBlockElement;

						if($FILEcheck != 5)
							$LOG_DATA_new = date("d.m.Y H:i:s", $find_FILES["rs"]["FILES_LastM"]);
						else	$LOG_DATA_new = "";

						if ($find_FILES["ar"]["FILES_LastM"])
							$LOG_DATE_old = date("d.m.Y H:i:s", $find_FILES["ar"]["FILES_LastM"]);
						else	$LOG_DATE_old = "";

						if ($find_FILES["ar"]["FILES_LastM"]){
							    if($FILEcheck == 4)
								$LOG_DETAIL_TEXT = "Перезаписан файл";
							elseif($FILEcheck == 5)
								$LOG_DETAIL_TEXT = "Удален файл";
							else	$LOG_DETAIL_TEXT = "Заменен файл";

							    if($FILEcheck == 5)
								$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["ar"]["FILES_NAME"] . "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
							else	$LOG_FILES_NAME  = "\nНовый файл: " . $find_FILES["rs"]["FILES_NAME"] . "\nСтарый файл: " . $find_FILES["ar"]["FILES_NAME"] . "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
						}else{	$LOG_DETAIL_TEXT = "Загружен файл";
							$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["rs"]["FILES_NAME"]. "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
						}

						$arLoadProductArray2 = Array(
						  "ACTIVE"		=> "Y",            // активен
						  "DATE_ACTIVE_FROM"	=> $arElement["DATE_ACTIVE_FROM"],
						  "NAME"		=> $arNAME,
						  "DETAIL_TEXT"		=> $LOG_DETAIL_TEXT." - ".$CONT_in[$find_FILES["name"]]["DESCRIPTION"] . $LOG_FILES_NAME,
						  "IBLOCK_TYPE"		=> $arParams["IBLOCK_TYPE"],
						  "IBLOCK_ID"		=> $GLOBALS["SECTION_ID_log"],
						  "PROPERTY_VALUES"	=> Array(
							"LOG_ID"	=> $buff["ID"],
							"LOG_Date_new"	=> $LOG_DATA_new,
							"LOG_Date_old"	=> $LOG_DATE_old
							)
						  );
//print_r($arLoadProductArray);
						$PRODUCT_ID2 = $el2->Add($arLoadProductArray2);
//						if($PRODUCT_ID2 = $el2->Add($arLoadProductArray2))
//						  echo "New ID: ".$PRODUCT_ID2;
//						else
//						  echo "Error: ".$el->LAST_ERROR;
					}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------

				}else if ($FILEcheck == 3){

					$buffer.= "<big>";
					if($find_FILES["rs"]["FILES_CRC"] != "00000000")
						$buffer.= "<BR>Заменен: ".date("d.m.Y H:i:s", $find_FILES["rs"]["FILES_LastM"]);
					else	$buffer.= "<BR>Файл не найден на сервере";
					$buffer.= "<BR>Загружался: ".date("d.m.Y H:i:s", $find_FILES["ar"]["FILES_LastM"]);
					$buffer.= "</big>";

//-Подготовка к обновлению базы контроля, путем замены старыз дат и crc на новые----------------------------------------------------------------------------------------
//echo $GLOBALS["SECTION_ID"]." - ".$CONT_iblocks["ID"]."<BR>";
//echo "<pre>";
//print_r($rsFILES);
//print_r($arFILES);
//					$arFILES_NAME = Array("FILES_DATE","FILES_LastM","FILES_CRC","FILES_NAME");
//					$rsFILES_new = Array();
					$rsFILES_new = $rsFILES;

					$buff			= Array();
					$buff["IBLOCK_ID"]	= $arParams["IBLOCK_ID"];
					$buff["ID"]		= $arElement["ID"];
//echo "<B>rsFILES_new</B><BR>";
//print_r($rsFILES_new);
//echo "<B>buff</B><BR>";
//print_r($buff);
//--------------------------------------------------------------------------------------------------------------------
					for($j=0;$j<count($find_colFILES_NAME);$j++){
						$rsFILES_new[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])]	= $rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]];
						$rsFILES_new[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])+1]	= $rsFILES[$find_colFILES_NAME[$j]][Find_array_element($rsFILES[$find_colFILES_NAME[$j]],$rsFILES[$find_colFILES_NAME[$j]][$find_FILES["rs"]["id"]])+1];
						reset($rsFILES_new[$find_colFILES_NAME[$j]]);
						while (list($key, $val) = each($rsFILES_new[$find_colFILES_NAME[$j]]))
							$buff[$find_colFILES_NAME[$j]]	.= $val . "|";
					}
//-Считать имя подраздела (Аукцион, Конкурс и т.д.)-------------------------------------------------------------------
					$arNAME = "";
					$res = CIBlock::GetByID($buff["IBLOCK_ID"]);
					if ($ar_res = $res->GetNext())
						$arNAME = $ar_res['NAME'];

//-Обновление базы контроля-------------------------------------------------------------------------------------------
/*					if(CModule::IncludeModule("iblock")){
						$el = new CIBlockElement;

						$arLoadProductArray = Array(
						  "ACTIVE"		=> "Y",            // активен
						  "NAME"		=> $buff["IBLOCK_ID"]."|".$buff["ID"],
						  "IBLOCK_TYPE"		=> $arParams["IBLOCK_TYPE"],
						  "IBLOCK_ID"		=> $GLOBALS["SECTION_ID"],
						  "PROPERTY_VALUES"	=> $buff
						  );
//print_r($arLoadProductArray);
						$PRODUCT_ID = $el->Update($CONT_iblocks["ID"],$arLoadProductArray);
//						if($PRODUCT_ID = $el->Update(($CONT_iblocks["ID"]-1),$arLoadProductArray))
//						  echo "New ID: ".$PRODUCT_ID;
//						else
//						  echo "Error: ".$el->LAST_ERROR;
//					}
*/
//-Добавление лога в базу отчета контроля-----------------------------------------------------------------------------
					if(CModule::IncludeModule("iblock")){
						$el3 = new CIBlockElement;

						if($find_FILES["rs"]["FILES_CRC"] != "00000000")
							$LOG_DATE_new = date("d.m.Y H:i:s", $find_FILES["rs"]["FILES_LastM"]);
						else	$LOG_DATE_new = "";

						if ($find_FILES["ar"]["FILES_LastM"])
							$LOG_DATE_old = date("d.m.Y H:i:s", $find_FILES["ar"]["FILES_LastM"]);
						else	$LOG_DATE_old = "";

						if ($find_FILES["ar"]["FILES_LastM"]){
							if($find_FILES["rs"]["FILES_CRC"] != "00000000")
								$LOG_DETAIL_TEXT = "ВНИМАНИЕ!!! Изменен файл";
							else	$LOG_DETAIL_TEXT = "ВНИМАНИЕ!!! Файл не найден на сервере";
							$LOG_FILES_NAME  = "\nАдрес файл: " . $find_FILES["rs"]["FILES_NAME"] . "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
						}else{	$LOG_DETAIL_TEXT = "Загружен файл";
							$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["rs"]["FILES_NAME"]. "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
						}

						$arLoadProductArray3 = Array(
						  "ACTIVE"		=> "Y",            // активен
						  "DATE_ACTIVE_FROM"	=> $arElement["DATE_ACTIVE_FROM"],
						  "NAME"		=> $arNAME,
						  "DETAIL_TEXT"		=> $LOG_DETAIL_TEXT." - ".$CONT_in[$find_FILES["name"]]["DESCRIPTION"] . $LOG_FILES_NAME,
						  "IBLOCK_TYPE"		=> $arParams["IBLOCK_TYPE"],
						  "IBLOCK_ID"		=> $GLOBALS["SECTION_ID_log"],
						  "PROPERTY_VALUES"	=> Array(
							"LOG_ID"	=> $buff["ID"],
							"LOG_Date_new"	=> $LOG_DATE_new,
							"LOG_Date_old"	=> $LOG_DATE_old
							)
						  );

						//Если запись еще не существует в базе логов тогда записать
						$el3_add = GetIBlockElementList($GLOBALS["SECTION_ID_log"],0,Array("ID"=>"DESC"),0,$arLoadProductArray3);
						$el3_add = $el3_add->GetNext();
						if(!$el3_add){					// если IBLOCK не найден
							$PRODUCT_ID3 = $el3->Add($arLoadProductArray3);
//							if($PRODUCT_ID3 = $el3->Add($arLoadProductArray3))
//							  echo "New ID: ".$PRODUCT_ID3;
//							else
//							  echo "Error: ".$el->LAST_ERROR;
						}
					}


				}
				$buffer.= "</B></small></p></td>\n";
				if($i!=0)
				$buffer.= "</tr>";
			}
			$buffer.= "</tr>";
		}

	endforeach;
	echo $buffer;
?>
  </table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><div class="news_date_nav"><B><?=$arResult["NAV_STRING"]?></B></div><?endif;?>
<?

?>