<?php
//Заархивируем файлы
$arFiles = json_decode($_REQUEST['files'], true);
$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
$DelFilePath = date("d-m-Y_H-i-s")."_archive.zip";
// if(file_exists($_SERVER['DOCUMENT_ROOT']."/upload/zip/".$DelFilePath)) {

//         unlink ($_SERVER['DOCUMENT_ROOT']."/upload/zip/".$DelFilePath); 

// }
if ($zip->open($_SERVER['DOCUMENT_ROOT']."/upload/zip/".$DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
        die ("Could not open archive");
}
foreach($arFiles as $file){
  $zip->addFile($_SERVER['DOCUMENT_ROOT'].$file['filepath'], $file['filename']);
}
// close and save archive

$zip->close(); 
$res['path'] = $_SERVER['DOCUMENT_ROOT']."/upload/zip/".$DelFilePath;
$res['name'] = $DelFilePath;
$res['download'] = 'Y';
header('Content-Type: application/json');
echo json_encode($res);
?>