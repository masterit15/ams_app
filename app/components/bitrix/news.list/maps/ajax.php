<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("iblock");

if($_REQUEST['action'] == 'add'){
    $result = array('success' => false, 'title' => '', 'desc'=> '');

    //Погнали 
    $el = new CIBlockElement;
    $iblock_id = 105;
    $PROP = array();

    
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();

    //Свойства
    $PROP['OBJECT_COORDINAT']	= $_REQUEST['coords']; // координаты адреса
    $PROP['IP_ADDRESS']	= $_REQUEST['ip_address']; // IP адрес голосовавшего
    $PROP['ADDRESS']	= $_REQUEST['address']; // адрес
    $PROP['COUNT']	= 1; // количество голосовавших
    $PROP['YES']	= 1; // количество голосовавших за
    $PROP['NO']	= 0; // количество голосовавших против


    
    //Основные поля элемента
    $fields = array(
        "DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
        "CREATED_BY" => 1,    //Передаем ID пользователя кто добавляет
        "IBLOCK_ID" => $iblock_id, //ID информационного блока он 24-ый
        "PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
        "NAME" => 'Адрес установки фонтана по адресу: '.$_REQUEST['address'],//.'от гражданина',//  с IP: '.$_REQUEST['ip_address'],
        "ACTIVE" => "Y", //поумолчанию делаем активным или ставим N для отключении поумолчанию
        "PREVIEW_TEXT" => strip_tags($_REQUEST['description']), // Суть вопроса
        "DETAIL_TEXT" => strip_tags($_REQUEST['description_detail']), // Содержание обращения
    );

    //Результат в конце отработки
    if ($ID = $el->Add($fields)) {
      $result['title'] = 'Ваше предложение принято!';
      $result['desc'] = 'Спасибо за участие в голосовании!';
      $result['success'] = true;
      
    } else {
      $result['title'] = 'Вы не можете проголосовать.';
      $result['desc'] = '';
      $result['success'] = false;
    }
}elseif($_REQUEST['action'] == 'vote'){
  $resElement = CIBlockElement::GetList([],['IBLOCK_ID' => 105,'ID' => $_REQUEST['elid'],],false,false,
    [
        'ID',
        'PROPERTY_OBJECT_COORDINAT',
        'PROPERTY_IP_ADDRESS',
        'PROPERTY_ADDRESS',
        'PROPERTY_COUNT',
        'PROPERTY_YES',
        'PROPERTY_NO'
    ]
  );
  if($obj = $resElement->GetNext())
  $ips = explode(',', $obj['PROPERTY_IP_ADDRESS_VALUE']);
  $ipArr = walkArr($ips);
    $propField = array(
      'COUNT' => $obj['PROPERTY_COUNT_VALUE'] + 1,
    );
  if(!in_array($_REQUEST['ip_address'], $ipArr)){
    $propField['IP_ADDRESS'] = $obj['PROPERTY_IP_ADDRESS_VALUE'].','.$_REQUEST['ip_address'];
  }
  if($_REQUEST['vote'] == 'y'){
    $propField['YES'] = $obj['PROPERTY_YES_VALUE'] + 1;
  }elseif($_REQUEST['vote'] == 'n'){
    $propField['NO'] = $obj['PROPERTY_NO_VALUE'] + 1;
  }
  $result['fie'] = $propField;
  CIBlockElement::SetPropertyValuesEx(
    $_REQUEST['elid'], 
    false, 
    $propField
  );
  $result['title'] = 'Ваш голос принят!';
  $result['desc'] = 'Спасибо за участие в голосовании!';
  $result['success'] = true;
}
$result['res'] = $_REQUEST;
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>