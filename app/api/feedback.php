<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('form')) {
	$result = array('success' => false, 'result' => '');
	$sicret_key = '6Lf3hssZAAAAAGxtkoDZ11iJp0pTcwsKarIxwDUt';

	// Функция для получения данных reCaptcha
	function returnReCaptcha($token, $sicret_key) {
		// URL куда отправлять токин и секретный ключ
		$url = 'https://www.google.com/recaptcha/api/siteverify';

		// Параметры отправленных данных
		$params = [
			'secret' => $sicret_key, // Секретный ключ
			'response' => $token, // Токин
			'remoteip' => $_SERVER['REMOTE_ADDR'], // IP-адрес пользователя
		];

		// Делаем запрос
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Отправляем запрос
		$response = curl_exec($ch);

		// Возвращаем массив полученных данных
		return json_decode($response, true);
	}
	$chaptcha = returnReCaptcha($_POST['token'], $sicret_key);
	if ($chaptcha['success']) {
		if ($_FILES) {
			$files = $_FILES["files"];
			foreach ($files['name'] as $key => $value) {
				if ($files['name'][$key]) {
					$file = array(
						'name' => $files['name'][$key],
						'type' => $files['type'][$key],
						'tmp_name' => $files['tmp_name'][$key],
						'error' => $files['error'][$key],
						'size' => $files['size'][$key],
					);
					$filesArr[] = $file;
				}
			}
		}
		//$result = array('post' => $_POST, 'files' => $filesArr);

		$FORM_ID = 4;
		// массив значений ответов
		$arValues = array(
			// Получатель обращения
			"form_hidden_38" => $_POST['departament'],
			"form_hidden_39" => $_POST['person'],
			// Сведения об отправителе
			"form_checkbox_app_form_persondata" => array($_POST['app_form_persondata_18']), //Обращение от юридического лица
			"form_text_19" => $_POST['app_form_persondata_19'], //Название организации
			"form_text_20" => $_POST['app_form_persondata_20'], //Фамилия
			"form_text_21" => $_POST['app_form_persondata_21'], //Имя
			"form_text_22" => $_POST['app_form_persondata_22'], //Отчество
			"form_text_23" => $_POST['app_form_persondata_23'], //Контактный телефон
			"form_text_24" => $_POST['app_form_persondata_24'], //Е-почта
			"form_text_25" => $_POST['app_form_persondata_25'], //Адрес
			//Содержание обращения
			"form_textarea_29" => $_POST['app_form_claim_29'], //Суть вопроса
			"form_textarea_30" => $_POST['app_form_claim_30'], //Содержание обращения (не более 2000 символов)
			// Прикрепленные файлы
			"form_file_31" => $filesArr[0],
			"form_file_32" => $filesArr[1],
			"form_file_33" => $filesArr[2],
			"form_file_34" => $filesArr[3],
			"form_file_35" => $filesArr[4],
			// Пользовательское соглашение
			"form_checkbox_app_form_consent" => array($_POST['app_form_consent']),
		);

		// создадим новый результат
		if ($RESULT_ID = CFormResult::Add($FORM_ID, $arValues)) {
			$result['result'] = $RESULT_ID;
			$result['success'] = true;
		} else {
			global $strError;
			$result['result'] = $strError;
		}










	if (CUser::IsAuthorized()) { //if auth

				$rsUser = CUser::GetByID(CUser::GetID());
				$arUser = $rsUser->Fetch();
				if (!$arUser['UF_CONSENT']) {
						$user = new CUser;
						$fields = array(
								"UF_CONSENT" => $_REQUEST['user_consent'],
						);
						$user->Update(CUser::GetID(), $fields);
				}
				
		$status = array();
		if (!empty($_REQUEST['name']) and !empty($_REQUEST['description'])) {
			CModule::IncludeModule('iblock');
			
			//Погнали
			$el = new CIBlockElement;
			$iblock_id = 28;
			$PROP = array();

			//фотографии
			for($i = 0; $i < count($_FILES["files"]['name']); $i++){
				$file = Array(
					'name' 			=> $_FILES["files"]['name'][$i],
					'size' 			=> $_FILES["files"]['size'][$i],
					'tmp_name' 	    => $_FILES["files"]['tmp_name'][$i],
					'type' 			=> $_FILES["files"]['type'][$i]
				);
				$arFiles[] = array('VALUE' => $file, 'DESCRIPTION' => '');
			}
			$PROP['MORE_PHOTO'] = $arFiles;
			$rsUser = CUser::GetByID($USER->GetID());
			$arUser = $rsUser->Fetch();

			//Свойства
			$PROP['NAME']                   = $arUser['NAME'];
			$PROP['HIDDEN']                 = $_POST['HIDDEN'];
			$PROP['EMAIL']                  = $arUser['EMAIL'];
			$PROP['LAST_NAME']              = $arUser['LAST_NAME'];
			$PROP['SECOND_NAME']            = $arUser['SECOND_NAME'];
			$PROP['INSTITUTIONS']           = $_POST['INSTITUTIONS'];
			$PROP['CITY']                   = $arUser['PERSONAL_CITY'];
			$PROP['PHONE']                  = $arUser['PERSONAL_MOBILE'];
			$PROP['STREET']                 = $arUser['PERSONAL_STREET'];
			$PROP['PERSONAL_BIRTHDAY']      = $arUser['PERSONAL_BIRTHDAY'];
			$PROP['SNILS']                  = $arUser['UF_SNILS'];
			$PROP['APPLICATION_CATEGORY']   = $_POST['APPLICATION_CATEGORY'];

			//Основные поля элемента
			$fields = array(
					"DATE_CREATE" => date("d.m.Y H:i:s"), //Передаем дата создания
					"CREATED_BY" => $GLOBALS['USER']->GetID(),    //Передаем ID пользователя кто добавляет
					"IBLOCK_SECTION" => $_POST['CATEGORY'], //ID разделов
					"IBLOCK_ID" => $iblock_id, //ID информационного блока он 24-ый
					"PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
					"NAME" => date("m.d.y H:i:s"),
					"ACTIVE" => "N", //поумолчанию делаем активным или ставим N для отключении поумолчанию
					"PREVIEW_TEXT" => strip_tags($_REQUEST['description']), //Анонс
					"PREVIEW_PICTURE" => $_FILES['image'], //изображение для анонса
					"DETAIL_TEXT"    => strip_tags($_REQUEST['description_detail']),
					"DETAIL_PICTURE" => $_FILES['image_detail'] //изображение для детальной страницы
			);

			//Результат в конце отработки
			if ($ID = $el->Add($fields)) {
					$status["text"] = 'Вашая заявка принята и отправлена на модерацию';
					$status["status"] = 'success';
			} else {
					$status["text"] = 'Произошла ошибка! Попробуйте еще раз';
					$status["status"] = 'warning';
					}
			}
		// $status = "success";
		}else{
			$status["text"] = "Вы не Авторизованы!";
			$status["status"] = 'warning';
		}
	} else {
		$result['result'] = 'Вы подозрительный пользователь для google: ' . json_encode($chaptcha);
	}
}
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>