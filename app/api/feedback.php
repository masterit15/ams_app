<?
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/PHPMailer.php");
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/Exception.php");
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;

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
	$chaptcha = returnReCaptcha($_POST['token']);
	// if ($chaptcha['success']) {
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


			// Создаем письмо
			$mail = new PHPMailer();
			$mail->isSMTP();                   // Отправка через SMTP
			$mail->Host   		= 'smtp.yandex.ru';  // Адрес SMTP сервера
			$mail->SMTPAuth   	= true;          // Enable SMTP authentication
			// $mail->Username   = 'vladikavkaz';  // ваше имя пользователя (без домена и @)
			// $mail->Password   = 'vatikan34vatikan';  // ваш пароль
			$mail->Username   	= 'masterit15';  // ваше имя пользователя (без домена и @)
			$mail->Password   	= '4emilamazi';  // ваш пароль
			$mail->SMTPSecure 	= 'ssl';         // шифрование ssl
			$mail->Port   		= 465;               // порт подключения
			// // от кого (email и имя)
			// $mail->setFrom('vladikavkaz@rso-a.ru', 'Администрация Местного Самоуправления г. Владикавказ'); 
			// // кому (email и имя)
			// $mail->addAddress('vladikavkaz@rso-a.ru', 'Администрация Местного Самоуправления г. Владикавказ');  

			// от кого (email и имя)
			$mail->setFrom('masterit15@yandex.ru', 'Администрация Местного Самоуправления г. Владикавказ'); 
			// кому (email и имя)
			$mail->addAddress('masterit15@yandex.ru', 'Администрация Местного Самоуправления г. Владикавказ'); 
			// тема письма
			$mail->Subject = CUser::IsAuthorized() ? 'Обращение с сайта "http://vladikavkaz-osetia.ru" от пользователя' .$arUser['FIRST_NAME'].' '.$arUser['NAME'].' '.$arUser['LAST_NAME'] : 'Обращение от пользователя '. $PROP['FIO'] .' с IP адресом: ' .$_SERVER['REMOTE_ADDR'];
			$res = CIBlockSection::GetByID($PROP['DEPARTAMENT']);
			if($ar_res = $res->GetNext())
				$DEPARTAMENT =  $ar_res['NAME'];
			if($PROP['ORGANIZATION']){
				$html = '<html>
							<body>
							<p><b>Название организации:</b> '.$PROP['ORGANIZATION'].'</p>
							<p><b>ФИО руководителя:</b> '.$PROP['FIO'].'</p>
							<p><b>Телефон организации:</b> '.$PROP['PHONE'].'</p>
							<p><b>E-почта организации:</b> '.$PROP['EMAIL'].'</p>
							<p><b>Адреc организации:</b> '.$PROP['ADDRESS'].'</p>
							<p><b>Получатель обращения (Адресат):</b> '.$DEPARTAMENT.'</p>
							<div><b>Суть обращения:</b><br> <p>'.strip_tags($_REQUEST['description']).'</p></div>
							<div><b>Текст обращения:</b><br> <p>'.strip_tags($_REQUEST['description_detail']).'</p></div>
							</body>
						</html>';
			}else{
				$html = '<html>
							<body>
							<p><b>ФИО:</b> '.$PROP['FIO'].'</p>
							<p><b>Телефон:</b> '.$PROP['PHONE'].'</p>
							<p><b>E-почта:</b> '.$PROP['EMAIL'].'</p>
							<p><b>Адреc:</b> '.$PROP['ADDRESS'].'</p>
							<p><b>Получатель обращения (Адресат):</b> '.$DEPARTAMENT.'</p>
							<div><b>Суть обращения:</b><br> <p>'.strip_tags($_REQUEST['description']).'</p></div>
							<div><b>Текст обращения:</b><br> <p>'.strip_tags($_REQUEST['description_detail']).'</p></div>
							</body>
						</html>';
			}
			// html текст письма
			$mail->msgHTML($html);
			// Прикрепление файлов
			for ($ct = 0; $ct < count($_FILES['files']['tmp_name']); $ct++) {
				$uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['files']['name'][$ct]));
				$filename = $_FILES['files']['name'][$ct];
				if (move_uploaded_file($_FILES['files']['tmp_name'][$ct], $uploadfile)) {
					$mail->addAttachment($uploadfile, $filename);
				} else {
					$msg = 'Failed to move file to ' . $uploadfile;
				}
			} 

			if(!$mail->send()) {
				$result['message'] = 'Сообщение не отправлено. Ошибка: ' . $mail->ErrorInfo;
			} else {
				$result['message'] = 'Сообщение отправлено!';
			}
				
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
				$data = $ID.','.$PROP['FIO'].','.$PROP['PHONE'].','.$PROP['EMAIL'];
				CIBlockElement::SetPropertyValuesEx($ID, false, array(
				"ENCODE_LINK" => array("VALUE" => encript($data)),
				));
				$result['title'] = 'Ваше обращение под № '.$ID.'-1 принято!';
				$result['desc'] = 'Для уточнения информации по обращению звоните по номеру 30-30-30 или пишите на электроннию почту vladikavkaz@rso-a.ru';
				$result['status'] = 'success';
				
			} else {
				$result['title'] = 'Вы не заполнили обязательные поля.';
				$result['desc'] = 'Заполните все обязательные поля и попробуйте отправить обращение повторно.';
				$result['status'] = 'warning';
			}
		}
		// $result['status'] = "success";
		// }else{
		// 	$result['result'] = "Вы не Авторизованы!";
		// 	$result['status'] = 'warning';
		// }
	// } else {
	// 	$result['title'] = 'Вы подозрительный пользователь для google: ' . json_encode($chaptcha);
	// 	$result['status'] = 'warning';
	// }
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>