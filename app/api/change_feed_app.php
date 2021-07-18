<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (CModule::IncludeModule('iblock')) {
  $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
  // function getProps($id){
  //   $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), array());
  //   while ($ar_props = $db_props->Fetch()) {
  //     PR($ar_props);
  //   }
  // }
  $rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
  $result = array('success' => false, 'result' => '', 'status' => 'warning');
  $json = array(
    'event'=> '', 
    'title' => '', 
    'desc'=> '', 
    'icon' => '', 
    'datetime' => date('d.m.Y в H:i:s'),
    'userId' => '',
  );
  if($_REQUEST['action'] == 'change_status'){
    $PROP['STATUS'] = Array("VALUE" => $_REQUEST['status']);

    $oldStatus = getStatus($_REQUEST['element']);

    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "STATUS" => array("VALUE" => $_REQUEST['status']),
    ));
    switch ($_REQUEST['status']) {
      case '16':
        $color = '#f5b918';
        break;
      case '17':
        $color = '#00c99c';
        break;
      case '15':
        $color = '#fb7077';
        break;
    }
    $newStatus = getStatus($_REQUEST['element']);
    $json['event']    = 'change_status';
    $json['title']    = 'Статус изменился';
    $json['desc']     = 'c "'.$oldStatus.'" на "'.$newStatus.'"';
    $json['icon']     = 'fa-exchange';
    $json['color']    = $color;
    $json['userId']   = CUser::IsAuthorized() ? $USER->GetID() : '';
		$json['userName'] = CUser::IsAuthorized() ? $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : '';
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Сменился статус обращения № '.$_REQUEST['element'].'-1 c "'.$oldStatus.'" на "'.$newStatus.'"';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'add_responsible'){
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_REQUEST['responsible']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный';
    $json['desc']     = 'Ответственный департамент: '.$_REQUEST['responsible'];
    $json['icon']     = 'fa-users';
    $json['color']    = '';
    $json['userId']   = CUser::IsAuthorized() ? $USER->GetID() : '';
		$json['userName'] = CUser::IsAuthorized() ? $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : '';
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>
