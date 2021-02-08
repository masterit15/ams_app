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
//echo "<pre>";
//--Функции----------------------------------------------------------------------------
if(!function_exists("crc32_file")){
function crc32_file($fileName)				//определяет CRC значение файла
{
	if (!file_exists($fileName)) return "00000000";
	$crc = abs(crc32(file_get_contents($fileName)));
	if($crc & 0x80000000){$crc ^= 0xffffffff;$crc += 1;}
	return $crc;
}}

//-------------------------------------------------------------------------------------
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

		$buff = Array();
		$buff["IBLOCK_ID"]	= $arParams["IBLOCK_ID"];
		$buff["ID"]		= $arElement["ID"];

		$find_FILES = Array();

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
					// 1230757200 - это 01.01.2009 00:00:00
//					$arDATE = ParseDateTime($arElement["DATE_ACTIVE_FROM"], FORMAT_DATETIME);

				$buff["FILES_DATE"]	.= $arProperty["CODE"] . "|" . $file_name . "|";
				$buff["FILES_LastM"]	.= $arProperty["CODE"] . "|" . filemtime($_SERVER["DOCUMENT_ROOT"] . $filename) . "|";
				$buff["FILES_CRC"]	.= $arProperty["CODE"] . "|" . crc32_file($_SERVER["DOCUMENT_ROOT"] . $filename) . "|";
				$buff["FILES_NAME"]	.= $arProperty["CODE"] . "|" . $filename . "|";

				$find_FILES["rs"][$arProperty["CODE"]]["FILES_DATE"] = $file_name;
				$find_FILES["rs"][$arProperty["CODE"]]["FILES_LastM"] = filemtime($_SERVER["DOCUMENT_ROOT"] . $filename);
				$find_FILES["rs"][$arProperty["CODE"]]["FILES_CRC"] = crc32_file($_SERVER["DOCUMENT_ROOT"] . $filename);
				$find_FILES["rs"][$arProperty["CODE"]]["FILES_NAME"] = $filename;

				if($arProperty["DESCRIPTION"])
					$find_FILES["rs"][$arProperty["CODE"]]["DESCRIPTION"]	 = $arProperty["DESCRIPTION"];
				else
					$find_FILES["rs"][$arProperty["CODE"]]["DESCRIPTION"]	 = $arProperty["NAME"];

			}
		}

//print_r($buff);

		if(CModule::IncludeModule("iblock")){
			$iblocks = GetIBlockElementList($GLOBALS["SECTION_ID"],0,Array("ID"=>"DESC"),0,Array("NAME"=>$buff["IBLOCK_ID"]."|".$buff["ID"]));
			$iblocks = $iblocks->GetNext();
			if(!$iblocks){					// если IBLOCK не найден

				$el = new CIBlockElement;

				$arLoadProductArray = Array(
				  "ACTIVE"         => "Y",            // активен
				  "NAME"           => $buff["IBLOCK_ID"]."|".$buff["ID"],
				  "IBLOCK_TYPE"    => $arParams["IBLOCK_TYPE"],
				  "IBLOCK_ID"      => $GLOBALS["SECTION_ID"],
				  "PROPERTY_VALUES"=> $buff,
				  );

				$PRODUCT_ID = $el->Add($arLoadProductArray);
//				if($PRODUCT_ID = $el->Add($arLoadProductArray))
//				  echo "New ID: ".$PRODUCT_ID;
//				else
//				  echo "Error: ".$el->LAST_ERROR;

//-Считать имя подраздела (Аукцион, Конкурс и т.д.)-------------------------------------------------------------------
				$arNAME = "";
				$res = CIBlock::GetByID($buff["IBLOCK_ID"]);
				if ($ar_res = $res->GetNext())
					$arNAME = $ar_res['NAME'];

				reset($find_FILES["rs"]);
				while (list($key, $val) = each($find_FILES["rs"])){

//-Добавление лога в базу отчета контроля-----------------------------------------------------------------------------
//					if(CModule::IncludeModule("iblock")){
						$el2 = new CIBlockElement;

						$LOG_DATA_new = date("d.m.Y H:i:s", $find_FILES["rs"][$key]["FILES_LastM"]);
//						if($FILEcheck != 5)
//							$LOG_DATA_new = date("d.m.Y H:i:s", $find_FILES["rs"]["FILES_LastM"]);
//						else	$LOG_DATA_new = "";

//						if ($find_FILES["ar"]["FILES_LastM"])
//							$LOG_DATE_old = date("d.m.Y H:i:s", $find_FILES["ar"]["FILES_LastM"]);
//						else	$LOG_DATE_old = "";

						$LOG_DETAIL_TEXT = "Загружен файл";
//						if ($find_FILES["ar"]["FILES_LastM"]){
//							    if($FILEcheck == 4)
//								$LOG_DETAIL_TEXT = "Перезаписан файл";
//							elseif($FILEcheck == 5)
//								$LOG_DETAIL_TEXT = "Удален файл";
//							else	$LOG_DETAIL_TEXT = "Заменен файл";

						$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["rs"][$key]["FILES_NAME"]. "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
//							    if($FILEcheck == 5)
//								$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["ar"]["FILES_NAME"] . "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
//							else	$LOG_FILES_NAME  = "\nНовый файл: " . $find_FILES["rs"]["FILES_NAME"] . "\nСтарый файл: " . $find_FILES["ar"]["FILES_NAME"] . "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
//						}else{	$LOG_DETAIL_TEXT = "Загружен файл";
//							$LOG_FILES_NAME  = "\nАдрес файла: " . $find_FILES["rs"]["FILES_NAME"]. "\nПоследнее изменение: " . $arElement["TIMESTAMP_X"] . " - " . $arElement["USER_NAME"];
//						}

						$arLoadProductArray2 = Array(
						  "ACTIVE"		=> "Y",            // активен
						  "DATE_ACTIVE_FROM"	=> $arElement["DATE_ACTIVE_FROM"],
						  "NAME"		=> $arNAME,
						  "DETAIL_TEXT"		=> $LOG_DETAIL_TEXT." - ".$find_FILES["rs"][$key]["DESCRIPTION"] . $LOG_FILES_NAME,
						  "IBLOCK_TYPE"		=> $arParams["IBLOCK_TYPE"],
						  "IBLOCK_ID"		=> $GLOBALS["SECTION_ID_log"],
						  "PROPERTY_VALUES"	=> Array(
							"LOG_ID"	=> $buff["ID"],
							"LOG_Date_new"	=> $LOG_DATA_new,
							"LOG_Date_old"	=> ""
							)
						  );
//print_r($arLoadProductArray);
						$PRODUCT_ID2 = $el2->Add($arLoadProductArray2);
//						if($PRODUCT_ID2 = $el2->Add($arLoadProductArray2))
//						  echo "New ID: ".$PRODUCT_ID2;
//						else
//						  echo "Error: ".$el->LAST_ERROR;
//					}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------
				}

				?><HR><B><?=$arNAME;?> - Добавлен новый</B><?

			}
		}

	endforeach;

?>