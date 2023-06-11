<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}
?>
<? if (!empty($arResult)) { ?>
	<?
	$ul = [];
	foreach ($arResult as $arItem) {
		if($arItem["TEXT"] == 'Глава МО'){
			$ul['mo']['params'] = $arItem['PARAMS'];
		} elseif($arItem["TEXT"] == 'Глава АМС'){
			$ul['ams']['params'] = $arItem['PARAMS'];
		}
		if($arItem["DEPTH_LEVEL"] == 2 && $arItem["CHAIN"][0] == 'Глава МО'){
			$ul['mo']['ul'][] = $arItem;
		} elseif($arItem["DEPTH_LEVEL"] == 2 && $arItem["CHAIN"][0] == 'Глава АМС'){
			$ul['ams']['ul'][] = $arItem;
		}
	}
	// PR($ul);
	foreach ($arResult as $arItem) {?>
		<? if ($arItem["DEPTH_LEVEL"] == 1) { ?>
			<div id="root-panel-<?= $arItem['PARAMS']['departament'] ?>">
			<div class="cheif_wrap">
				<div class="cheif_img" style="background-image: url('<?=$arItem['PARAMS']['IMG']?>');"></div>
				<h3><?= $arItem['PARAMS']['FIO'] ?></h3>
				
				<p><?= $arItem['PARAMS']['POST'] ?></p>
				
					<ul class="cheif_menu">
						<?foreach ($ul[$arItem['PARAMS']['departament']]['ul'] as $li) {?>
							<li><a class="<? if ($li["SELECTED"]){?>selected<?}?>" href="<?=$li['LINK']?>"><?=$li['TEXT']?></a></li>
						<?}?>
					</ul>
				</div>
			</div>
		<? } ?>
	<? } ?>
<? } ?>