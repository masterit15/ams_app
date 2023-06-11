<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
	<table class="table table-bordered table-responsive">
	<tr>
		<th>Остановки</th>
		<th>Время отправления</th>
	</tr>
		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
			<?if (empty($arElement['PROPERTIES']['MONDAY']['VALUE']['TEXT']) && !$USER->IsAdmin()) continue;?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
		<tr>
			<td valign="top">
				<h3><?=$arElement['NAME']?></h3>
				<?if(is_array($arElement["PREVIEW_PICTURE"])):?>
					<p>
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a><br />
					</p>
				<?elseif(is_array($arElement["DETAIL_PICTURE"])):?>
						<p>
							<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arElement["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arElement["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a><br />
						</p>
				<?endif?>
			</td>
			<td class="timeTD">
				<?if (empty($arElement['PROPERTIES']['MONDAY']['VALUE']['TEXT']) && $USER->IsAdmin()):?>
					<?=GetMessage('TS_EMPTY_SCHEDULE')?>
				<?else:?>
					<?$timetable = explode('; ',$arElement['PROPERTIES']['MONDAY']['VALUE']['TEXT'])?>
					<?foreach ($timetable as $time):?>
						<span>
							<?=$time?>
						</span>
					<?endforeach?>
				<?endif;?>
			</td>
		</tr>
	<?endforeach?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
