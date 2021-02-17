<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('iblock')) {
	$result = array('success' => false, 'result' => '', 'status' => '');
	$json = array(
    'event'=> '', 
    'title' => '', 
    'desc'=> '', 
    'icon' => '', 
    'datetime' => date('d.m.Y в H:i:s'),
    'userId' => '',
    'userCreate' => ''
  );
	$chaptcha = returnReCaptcha($_POST['token']);
	if ($chaptcha['success']) {
	//if (CUser::IsAuthorized()) { //if auth

				// $rsUser = CUser::GetByID(CUser::GetID());
				// $arUser = $rsUser->Fetch();
				// if (!$arUser['UF_CONSENT']) {
				// 		$user = new CUser;
				// 		$fields = array(
				// 				"UF_CONSENT" => $_REQUEST['user_consent'],
				// 		);
				// 		$user->Update(CUser::GetID(), $fields);
				// }
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
			$PROP['DEPARTAMENT']	= $_POST['departament']; // Получатель обращения (Департамент)
			$PROP['ORGANIZATION']	= $_POST['orgname']; // Название организации
			$PROP['APPLICATION_FILES'] = $arFiles; // Прикрепленные файлы
			
			//Основные поля элемента
			$fields = array(
					"DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
					"CREATED_BY" => CUser::IsAuthorized() ? $USER->GetID() : 15,    //Передаем ID пользователя кто добавляет
					// "IBLOCK_SECTION" => $_POST['CATEGORY'], //ID разделов
					"IBLOCK_ID" => $iblock_id, //ID информационного блока он 24-ый
					"PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
					"NAME" => CUser::IsAuthorized() ? 'Обращение от пользователя' .$arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : 'Обращение от пользователя '. $PROP['FIO'] .' с IP адресом: ' .$_SERVER['REMOTE_ADDR'],
					"ACTIVE" => "N", //поумолчанию делаем активным или ставим N для отключении поумолчанию
					"PREVIEW_TEXT" => strip_tags($_REQUEST['description']), // Суть вопроса
					"DETAIL_TEXT" => strip_tags($_REQUEST['description_detail']), // Содержание обращения
			);

			//Результат в конце отработки
			if ($ID = $el->Add($fields)) {
				$json['event'] = 'add_application';
				$json['title'] = 'Создано обращение';
				$json['desc'] = CUser::IsAuthorized() ? 'Обращение от пользователя' .$arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : 'Обращение от пользователя '. $PROP['FIO'] .' с IP адресом: ' .$_SERVER['REMOTE_ADDR'];
				$json['icon'] = 'fa-exclamation';
				$json['userId'] = CUser::IsAuthorized() ? $USER->GetID() : '';
				$json['userName'] = CUser::IsAuthorized() ? $arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : $PROP['FIO'];
				addTimeline($ID, $json);
				$result['result'] = 'Ваше обращение под № '.$ID.'-1 принято и отправлено на модерацию.';
				$result['status'] = 'success';
			} else {
				$result['result'] = 'Произошла ошибка, попробуйте еще раз.';
				$result['status'] = 'warning';
			}
		}else{
			$result['result'] = 'Вы не заполнили обязательные поля, пожалуста попробуйте еще раз.';
			$result['status'] = 'warning';
		}
		// $result['status'] = "success";
		// }else{
		// 	$result['result'] = "Вы не Авторизованы!";
		// 	$result['status'] = 'warning';
		// }
	} else {
		$result['result'] = 'Вы подозрительный пользователь для google: ' . json_encode($chaptcha);
		$result['status'] = 'warning';
	}
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>