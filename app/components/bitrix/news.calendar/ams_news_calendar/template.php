<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-calendar">
	<?if($arParams["SHOW_CURRENT_DATE"]):?>
		<!-- <p align="right" class="NewsCalMonthNav"><b><?//=$arResult["TITLE"]?></b></p> -->
	<?endif?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="NewsCalMonthNav" align="left">
				<?if($arResult["PREV_MONTH_URL"]):?>
					<a href="<?=$arResult["PREV_MONTH_URL"]?>" title="<?=$arResult["PREV_MONTH_URL_TITLE"]?>"><?=GetMessage("IBL_NEWS_CAL_PR_M")?></a>
				<?endif?>
				<?if($arResult["PREV_MONTH_URL"] && $arResult["NEXT_MONTH_URL"] && !$arParams["SHOW_MONTH_LIST"]):?>
					&nbsp;&nbsp;|&nbsp;&nbsp;
				<?endif?>
				<?if($arResult["SHOW_MONTH_LIST"]):?>
					&nbsp;&nbsp;
					<select onChange="b_result(this)" name="MONTH_SELECT" id="month_sel">
						<?foreach($arResult["SHOW_MONTH_LIST"] as $month => $arOption):?>
							<option value="<?=$arOption["VALUE"]?>" <?if($arResult["currentMonth"] == $month) echo "selected";?>><?=$arOption["DISPLAY"]?></option>
						<?endforeach?>
					</select>
					&nbsp;&nbsp;
					<script language="JavaScript" type="text/javascript">
					<!--
					function b_result(el)
					{
//						var idx=document.getElementById(el.id).selectedIndex;
var idx = el.selectedIndex;
						<?if($arParams["AJAX_ID"]):?>
							jsAjaxUtil.InsertDataToNode(el.options[idx].value, 'comp_<?echo $arParams['AJAX_ID']?>', <?echo $arParams["AJAX_OPTION_SHADOW"]=="Y"? "true": "false"?>);
						<?else:?>
							window.document.location.href=el.options[idx].value;
						<?endif?>
					}
					-->
					</script>
				<?endif?>
				<?if($arResult["NEXT_MONTH_URL"]):?>
					<a href="<?=$arResult["NEXT_MONTH_URL"]?>" title="<?=$arResult["NEXT_MONTH_URL_TITLE"]?>"><?=GetMessage("IBL_NEWS_CAL_N_M")?></a>
				<?endif?>
			</td>
			<?if($arParams["SHOW_YEAR"]):?>
			<td class="NewsCalMonthNav" align="right">
				<?if($arResult["PREV_YEAR_URL"]):?>
					<a href="<?=$arResult["PREV_YEAR_URL"]?>" title="<?=$arResult["PREV_YEAR_URL_TITLE"]?>"><?=GetMessage("IBL_NEWS_CAL_PR_Y")?></a>
				<?endif?>
				<?if($arResult["PREV_YEAR_URL"] && $arResult["NEXT_YEAR_URL"]):?>
					&nbsp;&nbsp;|&nbsp;&nbsp;
				<?endif?>
&nbsp;&nbsp;
					<select onChange="b_result(this)" name="YEAR_SELECT" id="year_sel"><?
$cy = intval(@$arResult['currentYear']);
if ($cy==0) $cy = intval(date('Y'));
$r = $DB->Query('select YEAR(ACTIVE_FROM) as Y from b_iblock_element where IBLOCK_ID='.$arParams['IBLOCK_ID'].' group by Y order by Y',true);
while ($el = $r->Fetch()) echo '<option value="'.$APPLICATION->GetCurPageParam($arParams["MONTH_VAR_NAME"]."=".$arResult['currentMonth']."&".$arParams["YEAR_VAR_NAME"]."=".$el['Y'], array($arParams["MONTH_VAR_NAME"], $arParams["YEAR_VAR_NAME"])).'"'.(($el['Y']==$cy)?' selected':'').'> '.$el['Y']."</option>\n";

?></select>&nbsp;&nbsp;
				<?if($arResult["NEXT_YEAR_URL"]):?>
					<a href="<?=$arResult["NEXT_YEAR_URL"]?>" title="<?=$arResult["NEXT_YEAR_URL_TITLE"]?>"><?=GetMessage("IBL_NEWS_CAL_N_Y")?></a>
				<?endif?>
			</td>
			<?endif?>
		</tr>
	</table>
	<br />
	<table width='100%' border='0' cellspacing='1' cellpadding='4' class='NewsCalTable'>
	<tr>
	<?foreach($arResult["WEEK_DAYS"] as $WDay):?>
		<td class='NewsCalHeader'><?=$WDay["FULL"]?></td>
	<?endforeach?>
	</tr>
	<?foreach($arResult["MONTH"] as $arWeek):?>
	<tr>
		<?foreach($arWeek as $arDay):?>
		<td align="left" valign="top" class='<?=$arDay["td_class"]?> <?if(count($arDay["events"]) > 0){?>active<?}?>' width="14%" >
			<span class="day"><?=$arDay["day"]?></span>
				<div class="NewsCalNews" style="padding-top:5px;" 
				<?if(count($arDay["events"]) > 0){?>
				data-toggle="popover" 
				data-content="
				<?foreach($arDay["events"] as $arEvent):
					$eventUrl = explode('?news=', $arEvent["url"]);
					$event 		= explode('&', $eventUrl[1]);
					?>
				<?=$arEvent["time"]?><a href='/news/<?=$event[0]?>/' title='<?=$arEvent["preview"]?>'><?=$arEvent["title"]?></a>
				<?endforeach?>"
				<?}?>
				>
				<?if(count($arDay["events"]) > 0){?>
					<span class="count"><?=count($arDay["events"]);?></span>
				<?}?>
			</div>	
		</td>
		<?endforeach?>
	</tr >
	<?endforeach?>
	</table>
</div>
