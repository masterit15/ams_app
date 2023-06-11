<?
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
// include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/PHPMailer.php");
// include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/Exception.php");
// include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/SMTP.php");
// use PHPMailer\PHPMailer\PHPMailer;

if (CModule::IncludeModule('iblock')) {
	$result = array('success' => false, 'title' => '', 'desc'=> '', 'status' => '');
	$json = array(
    'event'=> '', 
    'title' => '', 
    'desc'=> '', 
    'icon' => '', 
    'datetime' => date('d.m.Y в H:i:s'),
    'userId' => '',
    'userCreate' => ''
  );
	$is_valid = $_POST['captcha'] == '' ? true : false;
	if(!$is_valid){
		$result['title'] = 'Вы не правильно ввели капчу, попробуйте открыть форму повторно';
		$result['status'] = 'warning';
	}else{
		if (!empty($_REQUEST['name']) and !empty($_REQUEST['description']) and !empty($_REQUEST['email']) and !empty($_REQUEST['first_name'])) {
			//Погнали 
			$el = new CIBlockElement;
			$iblock_id = 102;
			$PROP = array();

			//файлов
			for($i = 0; $i < count($_FILES["files"]['name']); $i++){
				$file = Array(
					'name' 			=> $_FILES["files"]['name'][$i],
					'size' 			=> $_FILES["files"]['size'][$i],
					'tmp_name' 	=> $_FILES["files"]['tmp_name'][$i],
					'type' 			=> $_FILES["files"]['type'][$i]
				);
				$arFiles[] = array('VALUE' => $file, 'DESCRIPTION' => '');
			}
			
			$rsUser = CUser::GetByID($USER->GetID());
			$arUser = $rsUser->Fetch();

			//Свойства
			$PROP['FIO']	= $_POST['first_name'] .' '. $_POST['name'] .' '. $_POST['last_name']; // ФИО
			$PROP['PHONE']	= $_POST['phone']; // Контактный телефон
			$PROP['EMAIL']	= $_POST['email']; // Е-почта
			$PROP['PERSON'] = $_POST['person']; // Получатель обращения (Адресат)
			$PROP['STATUS'] = Array("VALUE" => 15);
			$PROP['CONSENT'] = $_POST['userconsent']; // Пользовательское соглашение
			$PROP['ADDRESS'] = $_POST['address']; // Адрес
			$PROP['ORGANIZATION']	= $_POST['orgname']; // Название организации
			$PROP['APPLICATION_FILES'] = $arFiles; // Прикрепленные файлы
			$PROP['RESPONSIBLE_DEPARTAMENT']	= $_POST['departament']; // Получатель обращения (Департамент)

			//Основные поля элемента
			$fields = array(
					"DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
					"CREATED_BY" => CUser::IsAuthorized() ? $USER->GetID() : 15,    //Передаем ID пользователя кто добавляет
					// "IBLOCK_SECTION" => $_POST['CATEGORY'], //ID разделов
					"IBLOCK_ID" => $iblock_id, //ID информационного блока он 24-ый
					"PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
					"NAME" => 'Обращение от пользователя '. $PROP['FIO'],
					"ACTIVE" => "N", //поумолчанию делаем активным или ставим N для отключении поумолчанию
					"PREVIEW_TEXT" => strip_tags($_REQUEST['description']), // Тема обращения
					"DETAIL_TEXT" => strip_tags($_REQUEST['description_detail']), // Содержание обращения
			);

			//Результат в конце отработки
			if ($ID = $el->Add($fields)) {
				$json['event'] = 'add_application';
				$json['title'] = 'Создано обращение';
				$json['desc'] = 'Обращение от пользователя '. $PROP['FIO'];
				$json['color']    = '#eb4d4b';
				$json['icon'] = 'fa-envelope-o';
				$json['userId'] = CUser::IsAuthorized() ? $USER->GetID() : '';
				$json['userName'] = CUser::IsAuthorized() ? $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : $PROP['FIO'];
				$json['id'] = 1;
				addTimeline($ID, $json);
				$json['event']    = 'add_status';
				$json['title']    = 'Статус обращения';
				$json['desc']     = 'Не обработана';
				$json['icon']     = 'fa-exclamation';
				$json['color']    = '#fb7077';
				$json['datetime'] = date('d.m.Y в H:i:s');
				$json['userId']   = CUser::IsAuthorized() ? $USER->GetID() : '';
				$json['userName'] = CUser::IsAuthorized() ? $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : $PROP['FIO'];
				addTimeline($ID, $json);
				$data = $ID.','.$PROP['FIO'].','.$PROP['PHONE'].','.$PROP['EMAIL'];
				CIBlockElement::SetPropertyValuesEx($ID, false, array(
					"ENCODE_LINK" => array("VALUE" => encript($data)),
				));
				$PROP['ENCODE_LINK'] = 'http://localhost:3000/feedback/obrashchenie-detalno/?application='.encript($data);
				$PROP['ID'] = $ID;
				$result['mail_to_ams'] = sendMailToAMS($PROP, $_FILES);
				// $result['mail_to_iniciator'] = sendMailToIniciator($PROP);
				$result['title'] 	= 'Ваше обращение под № '.$ID.'-1 принято!';
				// $result['desc'] 	= 'Вам будет направлено письмо c разъяснениями, на указанную е-почту '.$PROP['EMAIL'].' Для уточнения информации по обращению звоните по номеру 30-30-30 или пишите на электроннию почту vladikavkaz@rso-a.ru';
				$result['desc'] 	= 'Для уточнения информации по обращению звоните по номеру 30-30-30 или пишите на электроннию почту vladikavkaz@rso-a.ru';
				$result['status'] = 'success';
				$result['success'] = true;
			} else {
				$result['title'] 	= 'Вы не заполнили обязательные поля.';
				$result['desc'] 	= 'Заполните все обязательные поля и попробуйте отправить обращение повторно.';
				$result['status'] = 'warning';
			}
		}
	}
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>