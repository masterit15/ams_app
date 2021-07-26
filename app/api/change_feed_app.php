<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (CUser::IsAuthorized()) {
  CModule::IncludeModule('iblock');
  function getSectionName($id){
    $res = CIBlockSection::GetByID($id);
    if($ar_res = $res->GetNext())
    return $ar_res['NAME'];
  }
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
    $PROP['STATUS'] = Array("VALUE" => $_REQUEST['value']);
    $oldStatus = getStatus($_REQUEST['element']);
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "STATUS" => array("VALUE" => $_REQUEST['value']),
    ));
    switch ($_REQUEST['value']) {
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
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'add_responsible'){ // назначен ответственный
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_REQUEST['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный департамент';
    $json['desc']     = ''.getSectionName($_REQUEST['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'change_responsible'){ // сменился ответственный
    $oldResponsible = getOldProp($_REQUEST['element'], 'RESPONSIBLE_DEPARTAMENT');
    CIBlockElement::SetPropertyValuesEx($_REQUEST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_REQUEST['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Изменен ответственный департамент';
    $json['desc']     = 'с '.getSectionName($oldResponsible).' на '.getSectionName($_REQUEST['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['success'] = true;
  }elseif($_REQUEST['action'] == 'add_comment'){ // дан комментарий
    $json['event']    = 'add_comment';
    $json['title']    = 'Комментарий';
    $json['desc']     = ''.$_REQUEST['value'];
    $json['icon']     = 'fa-comment';
    $json['color']    = '#ffeaa7';
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
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
      "ANSWER_TEXT" => array("VALUE" => $_REQUEST['text']),
      "ANSWER_FILES" => $arFiles,
    ));
    $files = getOldProp($_REQUEST['element'], 'ANSWER_FILES');
    $json['event']    = 'add_answer';
    $json['title']    = 'Дан ответ';
    $json['desc']     = $_REQUEST['text'];
    $json['icon']     = 'fa-handshake-o';
    $json['color']    = '#00b894';
    $json['files']    = $files;
    $json['userId']   = $USER->GetID();
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_REQUEST['element'], $json);
    $result['files'] = $files;
    $result['result'] = 'Назначен ответственный на обращения № '.$_REQUEST['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>
