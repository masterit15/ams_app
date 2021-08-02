<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (CUser::IsAuthorized()) {
  CModule::IncludeModule('iblock');
  $rsUser = CUser::GetByID($USER->GetId());
	$arUser = $rsUser->Fetch();
  $result = array('success' => false, 'result' => '', 'status' => 'warning');
  if($_POST['action'] == 'change_status'){ // сменился статус
    $oldStatus = getStatus($_POST['element']);
    CIBlockElement::SetPropertyValuesEx($_POST['element'], false, array(
      "STATUS" => array("VALUE" => $_POST['value']),
    ));
    switch ($_POST['value']) {
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
    $newStatus = getStatus($_POST['element']);
    $json['event']    = 'change_status';
    $json['title']    = 'Статус изменился';
    $json['desc']     = 'c "'.$oldStatus.'" на "'.$newStatus.'"';
    $json['icon']     = 'fa-exchange';
    $json['color']    = $color;
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_POST['element'], $json);
    $result['result'] = 'Сменился статус обращения № '.$_POST['element'].'-1 c "'.$oldStatus.'" на "'.$newStatus.'"';
    $result['success'] = true;
  }elseif($_POST['action'] == 'add_responsible'){ // назначен ответственный
    $json = array();
    CIBlockElement::SetPropertyValuesEx($_POST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_POST['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный департамент';
    $json['desc']     = ''.getSectionName($_POST['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_POST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_POST['element'].'-1';
    $result['success'] = true;
  }elseif($_POST['action'] == 'change_responsible'){ // сменился ответственный
    $json = array();
    $oldResponsible = getOldProp($_POST['element'], 'RESPONSIBLE_DEPARTAMENT');
    CIBlockElement::SetPropertyValuesEx($_POST['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $_POST['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Изменен ответственный департамент';
    $json['desc']     = 'с '.getSectionName($oldResponsible[0]).' на '.getSectionName($_POST['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_POST['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$_POST['element'].'-1';
    $result['success'] = true;
  }elseif($_POST['action'] == 'add_comment'){ // дан комментарий
    $json = array();
    $json['event']    = 'add_comment';
    $json['title']    = 'Комментарий';
    $json['desc']     = ''.$_POST['value'];
    $json['icon']     = 'fa-comment';
    $json['color']    = '#00ABA9';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_POST['element'], $json);
    $result['success'] = true;
  }elseif($_POST['action'] == 'add_answer'){ // дан ответ
    $json = array();
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
    CIBlockElement::SetPropertyValuesEx($_POST['element'], false, array(
      "ANSWER_TEXT" => array("VALUE" => $_POST['text']),
      "ANSWER_FILES" => $arFiles,
    ));
    $files = getOldProp($_POST['element'], 'ANSWER_FILES');
    $json['event']    = 'add_answer';
    $json['title']    = 'Дан ответ';
    $json['desc']     = $_POST['text'];
    $json['icon']     = 'fa-handshake-o';
    $json['color']    = '#00b894';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['files']    = $files;
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($_POST['element'], $json);
    $result['result'] = 'Дан ответ на обращения № '.$_POST['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($_POST['action'] == 'delete_timeline'){ // удаление елемента таймлайна
    deleteTimeline($_POST['element'], $_POST['id']);
    $result['success'] = true;
  }else{
    $result['success'] = false;
  }
}else{
  $result = array('success' => false, 'status' => 'warning');
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>
