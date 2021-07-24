<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (CUser::IsAuthorized()) {
  CModule::IncludeModule('iblock');
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
  if($_REQUEST['action'] == 'change_status'){ // сменился статус
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
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Сменился статус обращения № '.$_REQUEST['element'].'-1 c "'.$oldStatus.'" на "'.$newStatus.'"';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'add_responsible'){ // назначен ответственный
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_REQUEST['responsible']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный департамент';
    $json['desc']     = ''.$_REQUEST['responsible'];
    $json['icon']     = 'fa-users';
    $json['color']    = '';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'change_responsible'){ // назначен ответственный
    $oldResponsible = getOldProp($_REQUEST['element'], 'RESPONSIBLE_DEPARTAMENT');
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_REQUEST['responsible']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Изменен ответственный департамент';
    $json['desc']     = 'с '.$oldResponsible.' на '.$_REQUEST['responsible'];
    $json['icon']     = 'fa-users';
    $json['color']    = '';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'add_answer'){ // дан ответ
    // перебор файлов
    for($i = 0; $i < count($_FILES["answer_files"]['name']); $i++){
      $file = Array(
        'name' 			=> $_FILES["answer_files"]['name'][$i],
        'size' 			=> $_FILES["answer_files"]['size'][$i],
        'tmp_name' 	=> $_FILES["answer_files"]['tmp_name'][$i],
        'type' 			=> $_FILES["answer_files"]['type'][$i]
      );
      $arFiles[] = array('VALUE' => $file, 'DESCRIPTION' => '');
    }
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "IN_CHARGE_TEXT_VALUE" => array("VALUE" => $_REQUEST['answer_text']),
      "IN_CHARGE_FILES_VALUE" => array("VALUE" => $arFiles),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный департамент';
    $json['desc']     = ''.$_REQUEST['responsible'];
    $json['icon']     = 'fa-users';
    $json['color']    = '';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
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
