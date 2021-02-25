<?php
// Файлы phpmailer
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/PHPMailer.php");
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/PHPMailer/SMTP.php");
$result = array('success'=> false, 'message'=> '');
// Переменные
$name = $_POST['fio'];
$email = $_POST['email'];
$title = $_POST['title'];
$text = $_POST['text'];
$files = $_POST['files'];
$applicationId = $_POST['application'];

// Настройки
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->Host = 'smtp.yandex.ru'; 
$mail->SMTPAuth = true; 
$mail->Username = 'yourlogin'; // Ваш логин в Яндексе. Именно логин, без @yandex.ru
$mail->Password = 'yourpass'; // Ваш пароль
$mail->SMTPSecure = 'ssl'; 
$mail->Port = 465;
$mail->setFrom('masterit15@yandex.ru'); // Ваш Email
$mail->addAddress('example@mail.ru'); // Email получателя

// Прикрепление файлов
 for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
  $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));
  $filename = $_FILES['userfile']['name'][$ct];
  if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
    $mail->addAttachment($uploadfile, $filename);
  } else {
    $msg .= 'Failed to move file to ' . $uploadfile;
  }
 } 
 
// Письмо
$mail->isHTML(true); 
$mail->Subject = $title; // Заголовок письма
$mail->Body = 'Имя $name . Телефон $number . Почта $email'; // Текст письма

// Результат
if(!$mail->send()) {
 $result['message'] = 'Сообщение не отправлено. Ошибка: ' . $mail->ErrorInfo;
} else {
  $result['success'] = true;
  $result['message'] = 'Сообщение отправлено!';
}
header('Content-Type: application/json');
echo json_encode($result);
?>