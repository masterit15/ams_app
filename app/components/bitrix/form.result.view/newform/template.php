<?if(in_array('print',array_keys($_GET))) { include('print.php'); exit; }?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?=$arResult["FormErrors"]?><?=$arResult["FORM_NOTE"]?>
<?
if ($arResult["isAccessFormResultEdit"] == "Y" && strlen($arParams["EDIT_URL"]) > 0) {
	$href = $arParams["SEF_MODE"] == "Y" ? str_replace("#RESULT_ID#", $arParams["RESULT_ID"], $arParams["EDIT_URL"]) : $arParams["EDIT_URL"].(strpos($arParams["EDIT_URL"], "?") === false ? "?" : "&")."RESULT_ID=".$arParams["RESULT_ID"]."&WEB_FORM_ID=".$arParams["WEB_FORM_ID"];
?>
<p>
[&nbsp;<a href="<?=$href?>"><?=GetMessage("FORM_EDIT")?></a>&nbsp;]<a href="http://<? echo $_SERVER['HTTP_HOST'].$APPLICATION->GetCurUri("print"); ?>" target="_blank" class="feedback_print" title="Распечатать обращение">Печать</a>
</p>
<?
}
?>
<table class="form-info-table data-table">
	<thead>
		<tr>
			<th colspan="2"><?if ($arResult["isAccessFormResultEdit"] == "Y") { ?>Рег. №:&nbsp;&nbsp;&nbsp;<b style="color:red"><?echo $arResult["RESULT_ID"].'-'.$arResult["WEB_FORM_ID"]; ?></b><?}?>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b><?=GetMessage("FORM_DATE_CREATE")?></b></td>
			<td><?=$arResult["RESULT_DATE_CREATE"]?></td>
		</tr>
		<tr>
			<td><b><?=GetMessage("FORM_TIMESTAMP")?></b></td>
			<td><?=$arResult["RESULT_TIMESTAMP_X"]?></td>
		</tr>
		<?
		if ($arResult["isAccessFormResultEdit"] == "Y")
		{
			if ($arResult["isStatisticIncluded"] == "Y")
			{
		?>
		<tr>
			<td><b>IP адрес:</b></td>
			<td><a href="/bitrix/admin/session_list.php?lang=<?=LANGUAGE_ID?>&find_id=<?=$arResult["RESULT_STAT_SESSION_ID"]?>&find_id_exact_match=Y&set_filter=Y"><?
$ses = CSession::GetByID($arResult["RESULT_STAT_SESSION_ID"])->Fetch();
echo $ses['IP_FIRST'];
			?></a></td>
		</tr>
			<?
			}
			?>
		<?
		}
		?>
	</tbody>
</table>
<table class="form-table data-table">
	<thead>
		<tr>
			<th colspan="2"><? if ($arParams["SHOW_STATUS"] == "Y"){ ?><?=GetMessage("FORM_CURRENT_STATUS")?></b>&nbsp;[<span class='<?=$arResult["RESULT_STATUS_CSS"]?>'><?=$arResult["RESULT_STATUS_TITLE"]?></span>]<?}?>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?
foreach ($arResult["RESULT"] as $FIELD_SID => $arQuestion) {
  ob_start();
  if (is_array($arQuestion['ANSWER_VALUE'])) {
	foreach ($arQuestion['ANSWER_VALUE'] as $key => $arAnswer) { 
	  if ($arAnswer["ANSWER_IMAGE"]) {
	    if (strlen($arAnswer["USER_TEXT"]) > 0) echo $arAnswer["USER_TEXT"].'<br />';
		?><img src="<?=$arAnswer["ANSWER_IMAGE"]["URL"]?>" <?=$arAnswer["ANSWER_IMAGE"]["ATTR"]?> border="0" /><?
	  } elseif ($arAnswer["ANSWER_FILE"]) {?>
		<a title="<?=GetMessage("FORM_VIEW_FILE")?>" target="_blank" href="<?=$arAnswer["ANSWER_FILE"]["URL"]?>"><?=$arAnswer["ANSWER_FILE"]["NAME"]?></a><br />(<?=$arAnswer["ANSWER_FILE"]["SIZE_FORMATTED"]?>)<br />[&nbsp;<a title="<?=str_replace("#FILE_NAME#", $arAnswer["ANSWER_FILE"]["NAME"], GetMessage("FORM_DOWNLOAD_FILE"))?>" href="<?=$arAnswer["ANSWER_FILE"]["URL"]?>&action=download"><?=GetMessage("FORM_DOWNLOAD")?></a>&nbsp;]<?
	  } elseif (strlen($arAnswer["USER_TEXT"]) > 0) echo $arAnswer["USER_TEXT"];
	  else {
		if (strlen($arAnswer["ANSWER_TEXT"])>0) { ?>
		  [<span class="form-anstext"><?=$arAnswer["ANSWER_TEXT"]?></span>]<?
		  if (strlen($arAnswer["ANSWER_VALUE"])>0) { ?>&nbsp;(<span class="form-ansvalue"><?=$arAnswer["ANSWER_VALUE"]?></span>)<? } ?>
		  <br /><?
		}
	  }
	}
  }
  $text = trim(ob_get_clean());
  if ($text=='') continue;
		?>
		<tr>
			<td><?=$arQuestion["CAPTION"]?><?=$arResult["arQuestions"][$FIELD_SID]["REQUIRED"] == "Y" ? $arResult["REQUIRED_SIGN"] : ""?>
			<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>			
			</td>
			<td><?=$text?></td>
		</tr>
<? } ?>
	</tbody>
</table>