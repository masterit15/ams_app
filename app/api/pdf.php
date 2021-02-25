<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/app/modules/mpdf/mpdf.php");
$pdfFile = $_SERVER["DOCUMENT_ROOT"].'/upload/pdf/test_'.date('d-m-Y').'_.pdf';
$result = array('success'=> false, 'message'=> '', 'file' => $pdfFile);
$html = '
<div style="text-align: left; margin: 50px">
  Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Наш языком единственное точках. Встретил речью вопрос там дорогу. Речью за страну, парадигматическая подзаголовок они запятой то приставка даль вопроса.
</div>
';
//настройки для работы с кириллическими символами
$mpdf = new mPDF('utf-8', 'A4', '10', 'Arial');
$mpdf->charset_in = 'utf-8'; 
// формируем шапку
$mpdf->SetHTMLHeader('
<div style="text-align: left; font-weight: bold;">
    Шапка документа
</div>');

// формируем тело документа
$mpdf->WriteHTML($html);

// добавляем автора документа
$mpdf->SetAuthor('Администрация местного самоуправления г. Владикавказ');

// формируем низ документа
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="100%">Администрация местного самоуправления г. Владикавказ</td>
    </tr>
</table>');

//генерируем PDF
$mpdf->Output($pdfFile, 'F');
if(file_exists($pdfFile)){
  $result['success'] = true;
  $result['message'] = 'Файл успешно сгенерирован!';
}else{
  $result['message'] = 'Произошла ошибка, попробуйте еще раз!';
}
header('Content-Type: application/json');
echo json_encode($result);
?>