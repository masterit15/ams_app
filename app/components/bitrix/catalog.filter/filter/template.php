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
$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css"); 
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
?>
<div class="bx-flat-filter">
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
		<div class="bx-filter-section">
<?foreach($arResult["ITEMS"] as $arItem):?>
<?if(array_key_exists("HIDDEN", $arItem)):?>
	<?=$arItem["INPUT"]?>
	<?elseif ($arItem["TYPE"] == "RANGE"):?>
		<div class="bx-filter-parameters-box">
			<div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
			<div class="bx-filter-block">
				<div class="row bx-filter-parameters-box-container">
					<div class="bx-filter-parameters-box-container-block">
						<div class="bx-filter-input-container">
							<input
							type="text"
							class="input"
							value="<?=$arItem["INPUT_VALUES"][0]?>"
							name="<?=$arItem["INPUT_NAMES"][0]?>"
							placeholder="<?=GetMessage("CT_BCF_FROM")?>"
							/>
						</div>
					</div>
					<div class="bx-filter-parameters-box-container-block">
						<div class="bx-filter-input-container">
							<input
							type="text"
							class="input"
							value="<?=$arItem["INPUT_VALUES"][1]?>"
							name="<?=$arItem["INPUT_NAMES"][1]?>"
							placeholder="<?=GetMessage("CT_BCF_TO")?>"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?elseif ($arItem["TYPE"] == "DATE_RANGE"):?>
			<div class="bx-filter-parameters-box">
					<?$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'calendar',
						array(
							'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
							'SHOW_INPUT' => 'Y',
							'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'"',
							'INPUT_NAME' => $arItem["INPUT_NAMES"][0],
							'INPUT_VALUE' => $arItem["INPUT_VALUES"][0],
							'SHOW_TIME' => 'N',
							'HIDE_TIMEBAR' => 'Y',
						),
						null,
						array('HIDE_ICONS' => 'Y')
						);?>
					<?$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'calendar',
						array(
							'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
							'SHOW_INPUT' => 'Y',
							'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'"',
							'INPUT_NAME' => $arItem["INPUT_NAMES"][1],
							'INPUT_VALUE' => $arItem["INPUT_VALUES"][1],
							'SHOW_TIME' => 'N',
							'HIDE_TIMEBAR' => 'Y',
						),
						null,
						array('HIDE_ICONS' => 'Y')
						);?>
					</div>
			<?elseif ($arItem["TYPE"] == "SELECT"):
					?>
					<div class="bx-filter-parameters-box">
						<div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
							<select name="<?=$arItem["INPUT_NAME"]?>">
							<?foreach ($arItem["LIST"] as $key => $value):?>
								<option
								value="<?=htmlspecialcharsBx($key)?>"
								<?if ($key == $arItem["INPUT_VALUE"]) echo 'selected="selected"'?>
								><?=htmlspecialcharsEx($value)?></option>
								<?endforeach?>
							</select>
						</div>
						<?elseif ($arItem["TYPE"] == "CHECKBOX"):?>
						<div class="bx-filter-parameters-box">
							<div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
							<?
								$arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
								foreach ($arItem["LIST"] as $key => $value):?>
									<label class="bx-filter-param-label">
										<input
										type="checkbox"
										class="input"
										value="<?=htmlspecialcharsBx($key)?>"
										name="<?echo $arItem["INPUT_NAME"]?>[]"
										<?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
										>
										<span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
									</label>
								<?endforeach?>
						</div>
						<?elseif ($arItem["TYPE"] == "RADIO"):
						?>
						<div class="bx-filter-parameters-box">
							<div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
							<?
								$arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
								foreach ($arItem["LIST"] as $key => $value):?>
									<label class="bx-filter-param-label">
										<input
										type="radio"
										class="input"
										value="<?=htmlspecialcharsBx($key)?>"
										name="<?echo $arItem["INPUT_NAME"]?>"
										<?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
										>
										<span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
									</label>
								<?endforeach?>
						</div>
						<?else:?>
							<div class="bx-filter-parameters-box">
								<div class="bx-filter-parameters-box-title"><span><?=$arItem["NAME"]?></span></div>
								<?=$arItem["INPUT"]?>
							</div>
							<?endif?>
							<?endforeach;?>
							<div class="bx-filter-parameters-box">
										<input type="submit" name="set_filter" value="ПОКАЗАТЬ" class="btn btn-primary" />
										<input type="hidden" name="set_filter" value="Y" />
										<input type="submit" name="del_filter" value="СБРОСИТЬ" class="btn btn-primary" />
							</div>
					</div>
				</form>
			</div>