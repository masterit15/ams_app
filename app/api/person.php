<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
$result = array('success' => false);
if(CModule::IncludeModule('iblock')){
  function getWorker($id){
    $res = CIBlockElement::GetByID($id);
    if($ar_res = $res->GetNext())
      return $ar_res['NAME']; 
  }
  $arFilter = Array(
    "IBLOCK_ID" =>99, 
    "ACTIVE"    =>"Y", 
    "%NAME"     => $_REQUEST['query']
  );
  $section = CIBlockSection::GetList(
		array(),
		$arFilter,
		false,
		array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'SORT', 'UF_WORKER', 'UF_POST')
	);
  while($ar_res = $section->GetNext()){
    $result['departament'][] = array(
      'id'  => $ar_res['ID'],
      'name'  => $ar_res['NAME'], 
      'cheif' => getWorker($ar_res['UF_WORKER']) ? getWorker($ar_res['UF_WORKER']) : 'Не найден руководитель'
    );
  }
  if(!$result['departament']){
    $result['success'] = false;
  }else{
    $result['success'] = true;
  }
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);