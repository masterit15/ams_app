<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
$result = array('success' => false, 'result' => '');
if(CModule::IncludeModule('iblock')){

  function getWorker($id){
    $res = CIBlockElement::GetByID($id);
    if($ar_res = $res->GetNext())
      return $ar_res;
  }
  $arFilter = Array(
    "IBLOCK_ID" =>95, 
    "ACTIVE"    =>"Y", 
    "ID"        =>$_REQUEST['id']
  );
  $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter,false,false, Array('PROPERTY_PERSON'));
  $section = CIBlockSection::GetList(
		array(),
		$arFilter,
		false,
		array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'SORT', 'UF_WORKER', 'UF_POST')
	);
  if($ar_res = $section->GetNext())
    $result['result'][] = getWorker($ar_res['UF_WORKER']);
  
  // while($ar_result = $res->GetNext()){
    // $ar_result['person'][] = getWorker($ar_result['PROPERTY_PERSON_VALUE']);
    // $result['result'][] = $ar_result;

  // }
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);