<h1>Сообщения, поступившие на официальный сервер АМС г.Владикавказа</h1>
<b>Дата создания:</b> <?=$arPrint["RESULT_DATE_CREATE"]?><br/>
<b>Регистрационный номер обращения:</b> <? echo $arPrint["RESULT_ID"].'-'.$arPrint["WEB_FORM_ID"]; ?><br/>
<b>IP адрес отправителя:</b> <?$ses = CSession::GetByID($arPrint["RESULT_STAT_SESSION_ID"])->Fetch(); echo $ses['IP_FIRST']; ?><br/>
<b>Текущий статус сообщения:</b> <?=$arPrint["RESULT_STATUS_TITLE"]?><br/>
<? 
$post = trim(@$arPrint["RESULT"]['SIMPLE_QUESTION_924']['ANSWER_VALUE'][0]['USER_TEXT']); 
if ($post!='') $post.=' ';
$dep = trim(@$arPrint["RESULT"]['SIMPLE_QUESTION_919']['ANSWER_VALUE'][0]['USER_TEXT']); 
if ($dep!='') $dep =' ('.$dep.')';
foreach ($arPrint["RESULT"] as $FIELD_SID => $arQuestion) {
  ob_start();
  if (is_array($arQuestion['ANSWER_VALUE'])) {
	foreach ($arQuestion['ANSWER_VALUE'] as $key => $arAnswer) { 
	  if ($arAnswer["ANSWER_IMAGE"]) {
	    if (strlen($arAnswer["USER_TEXT"]) > 0) echo $arAnswer["USER_TEXT"].'<br />';
		?><img src="<?=$arAnswer["ANSWER_IMAGE"]["URL"]?>" <?=$arAnswer["ANSWER_IMAGE"]["ATTR"]?> border="0" /><?
	  } elseif ($arAnswer["ANSWER_FILE"]) {
		echo $arAnswer["ANSWER_FILE"]["URL"];
	  } elseif (strlen($arAnswer["USER_TEXT"]) > 0) echo $arAnswer["USER_TEXT"];
	  else {
		if (strlen($arAnswer["ANSWER_TEXT"])>0) { ?>
		  [<?=$arAnswer["ANSWER_TEXT"]?>]<?
		  if (strlen($arAnswer["ANSWER_VALUE"])>0) { ?>&nbsp;(<i><?=$arAnswer["ANSWER_VALUE"]?></i>)<? } ?>
		  <br /><?
		}
	  }
	}
  }
  $text = trim(ob_get_clean());
  if ($text!='') {
    switch ($FIELD_SID) {
	  case 'SIMPLE_QUESTION_837': echo '<b>Ф.И.О. отправителя:</b> '; break;
	  case 'SIMPLE_QUESTION_493': echo '<b>Кому: </b> '; $text = $post.$text.$dep; break;
	  case 'SIMPLE_QUESTION_974': echo '<br/><b>'.$arQuestion["CAPTION"].':</b><br/>'; break;
	  case 'SIMPLE_QUESTION_116': echo '<br/>'; break;
	  case 'SIMPLE_QUESTION_924': 
	  case 'SIMPLE_QUESTION_919': $text = ''; break;
	  default: echo '<b>'.$arQuestion["CAPTION"].':</b> ';
	}
	if ($text!='') echo $text.'<br/>';
  }
} ?>