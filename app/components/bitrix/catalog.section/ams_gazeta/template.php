<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<ul>
	<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
  <li>
<? $inf = GetIBlockElement($arElement['ID']); 
//print_r($inf);

$fid = $inf['PROPERTIES']['SOURCE']['VALUE'];
//PROPERTY_VALUE_ID
$dopFile = '';
if ($fid>0) {
if(is_array($fid))	$rsFile = CFile::GetById(intval($fid[0]));
else			$rsFile = CFile::GetById(intval($fid));
  if ($arFile = $rsFile->Fetch()) {
//     $desc_f = trim($arFile['DESCRIPTION']);
//     if ($desc_f=='') $desc_f = 'Приложение';
     $bs = $arFile['FILE_SIZE'];
     $s = intval($bs/(1024*1024)); if ($s>0) $ts = $s.'Мб';
     else { $s = intval($bs/1024); if ($s>0) $ts = $s.'Кб'; 
     else $ts = $s.'б'; }
    $dopFile = '<a href="http://'.$_SERVER['HTTP_HOST'].'/upload/'.$arFile['SUBDIR'].'/'.$arFile['FILE_NAME'].'" title="Скачать выпуск">'.$arElement["NAME"].'</a> <i>('.$ts.')</i>';
  }
};
	if ($dopFile!='') echo $dopFile;
	else	echo $arElement["NAME"];
	?>
	<?if ($arElement["DETAIL_TEXT"]){?><br>
	<?=$arElement["DETAIL_TEXT"]?>
	<?}?>
  </li>
		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
</ul>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>