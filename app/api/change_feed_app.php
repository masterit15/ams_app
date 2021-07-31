<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if (CUser::IsAuthorized()) {
  CModule::IncludeModule('iblock');
  function getSectionName($id){
    $res = CIBlockSection::GetByID($id);
    if($ar_res = $res->GetNext())
    return $ar_res['NAME'];
  }
  $rsUser = CUser::GetByID($arUser['ID']);
	$arUser = $rsUser->Fetch();

  function addActionToTimeline($post, $arrFiles){
    $result = array('success' => false, 'result' => '', 'status' => 'warning');
    if($post['action'] == 'change_status'){ // сменился статус
    $oldStatus = getStatus($post['element']);
    CIBlockElement::SetPropertyValuesEx($post['element'], false, array(
      "STATUS" => array("VALUE" => $post['value']),
    ));
    switch ($post['value']) {
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
    $newStatus = getStatus($post['element']);
    $json['event']    = 'change_status';
    $json['title']    = 'Статус изменился';
    $json['desc']     = 'c "'.$oldStatus.'" на "'.$newStatus.'"';
    $json['icon']     = 'fa-exchange';
    $json['color']    = $color;
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($post['element'], $json);
    $result['result'] = 'Сменился статус обращения № '.$post['element'].'-1 c "'.$oldStatus.'" на "'.$newStatus.'"';
    $result['success'] = true;
  }elseif($post['action'] == 'add_responsible'){ // назначен ответственный
    $json = array();
    CIBlockElement::SetPropertyValuesEx($post['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $post['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Назначен ответственный департамент';
    $json['desc']     = ''.getSectionName($post['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($post['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$post['element'].'-1';
    $result['success'] = true;
  }elseif($post['action'] == 'change_responsible'){ // сменился ответственный
    $json = array();
    $oldResponsible = getOldProp($post['element'], 'RESPONSIBLE_DEPARTAMENT');
    CIBlockElement::SetPropertyValuesEx($post['element'], false, array(
      "RESPONSIBLE_DEPARTAMENT" => array("VALUE" => $post['value']),
    ));
    $json['event']    = 'add_responsible';
    $json['title']    = 'Изменен ответственный департамент';
    $json['desc']     = 'с '.getSectionName($oldResponsible).' на '.getSectionName($post['value']);
    $json['icon']     = 'fa-users';
    $json['color']    = '#0984e3';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($post['element'], $json);
    $result['result'] = 'Назначен ответственный на обращения № '.$post['element'].'-1';
    $result['success'] = true;
  }elseif($post['action'] == 'add_comment'){ // дан комментарий
    $json = array();
    $json['event']    = 'add_comment';
    $json['title']    = 'Комментарий';
    $json['desc']     = ''.$post['value'];
    $json['icon']     = 'fa-comment';
    $json['color']    = '#00ABA9';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($post['element'], $json);
    $result['success'] = true;
  }elseif($post['action'] == 'add_answer'){ // дан ответ
    $json = array();
    // перебор файлов
    for($i = 0; $i < count($arrFiles["answer_files"]['name']); $i++){
      $file = Array(
        'name' 			=> $arrFiles["answer_files"]['name'][$i],
        'size' 			=> $arrFiles["answer_files"]['size'][$i],
        'tmp_name' 	=> $arrFiles["answer_files"]['tmp_name'][$i],
        'type' 			=> $arrFiles["answer_files"]['type'][$i]
      );
      $arFiles[] = array('VALUE' => $file, 'DESCRIPTION' => '');
    }
    CIBlockElement::SetPropertyValuesEx($post['element'], false, array(
      "ANSWER_TEXT" => array("VALUE" => $post['text']),
      "ANSWER_FILES" => $arFiles,
    ));
    $files = getOldProp($post['element'], 'ANSWER_FILES');
    $json['event']    = 'add_answer';
    $json['title']    = 'Дан ответ';
    $json['desc']     = $post['text'];
    $json['icon']     = 'fa-handshake-o';
    $json['color']    = '#00b894';
    $json['datetime'] = date('d.m.Y в H:i:s');
    $json['files']    = $files;
    $json['userId']   = $arUser['ID'];
		$json['userName'] = $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'];
    addTimeline($post['element'], $json);
    $result['result'] = 'Дан ответ на обращения № '.$post['element'].'-1';
    $result['status'] = 'success';
    $result['success'] = true;
  }elseif($post['action'] == 'delete_timeline'){ // удаление елемента таймлайна
    deleteTimeline($post['element'], $post['id']);
    $result['success'] = true;
  }else{
    $result['success'] = false;
  }
  return $result;
}
if(isset($_POST)){
  $post = $_POST;
  $arrFiles = $arrFiles;
  $result = addActionToTimeline($post, $arrFiles);
}
}else{
  $result = array('success' => false, 'status' => 'warning');
}

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>
