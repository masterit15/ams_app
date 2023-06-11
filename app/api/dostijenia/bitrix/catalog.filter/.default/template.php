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
?>
<div class="container">
	<div class="row">
		<div class="filter-news">
			<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
				<div class="row">
					<?foreach($arResult["ITEMS"] as $arItem):?>
					<?if(array_key_exists("HIDDEN", $arItem)):?>
					<?=$arItem["INPUT"]?>
					<?elseif ($arItem["TYPE"] == "RANGE"):?>
					<div class="col col-xl-3">
						<div class="filter-input">
							<input
							type="text"
							value="<?=$arItem["INPUT_VALUES"][0]?>"
							name="<?=$arItem["INPUT_NAMES"][0]?>"
							placeholder="<?=GetMessage("CT_BCF_FROM")?>"
							/>
						</div>
					</div>
					<div class="col col-xl-3">
						<div class="filter-input">
							<input
							type="text"
							value="<?=$arItem["INPUT_VALUES"][1]?>"
							name="<?=$arItem["INPUT_NAMES"][1]?>"
							placeholder="<?=GetMessage("CT_BCF_TO")?>"
							/>
						</div>
					</div>
					<?elseif ($arItem["TYPE"] == "DATE_RANGE"):?>
					<div class="col col-xl-3">
						<div class="filter-input">
							<?$APPLICATION->IncludeComponent(
								'bitrix:main.calendar',
								'main',
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
						</div>
					</div>
					<div class="col col-xl-3">
						<div class="filter-input">
							<?$APPLICATION->IncludeComponent(
								'bitrix:main.calendar',
								'main',
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
					</div>
					<?elseif ($arItem["TYPE"] == "SELECT"):
					?>
					<div class="col col-xl-3">
						<select id="doccat" class="form_control dropdown sl" name="<?=$arItem["INPUT_NAME"]?>">
							<?foreach ($arItem["LIST"] as $key => $value):?>
							<option
							value="<?=htmlspecialcharsBx($key)?>"
							<?if ($key == $arItem["INPUT_VALUE"]) echo 'selected="selected"'?>
							><?=htmlspecialcharsEx($value)?></option>
							<?endforeach?>
						</select>
					</div>
					<?elseif ($arItem["TYPE"] == "CHECKBOX"):
					?>
					<div class="col col-xl-3">
						<div class="filter-input">
							<?
							$arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
							foreach ($arItem["LIST"] as $key => $value):?>
								<div class="checkbox">
									<label class="bx-filter-param-label">
										<input
										type="checkbox"
										value="<?=htmlspecialcharsBx($key)?>"
										name="<?echo $arItem["INPUT_NAME"]?>[]"
										<?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
										>
										<span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
									</label>
								</div>
								<?endforeach?>
							</div>
						</div>
						<?elseif ($arItem["TYPE"] == "RADIO"):
						?>
						<div class="col col-xl-3">
							<div class="filter-input">
								<?
								$arListValue = (is_array($arItem["~INPUT_VALUE"]) ? $arItem["~INPUT_VALUE"] : array($arItem["~INPUT_VALUE"]));
								foreach ($arItem["LIST"] as $key => $value):?>
									<div class="radio">
										<label class="bx-filter-param-label">
											<input
											type="radio"
											value="<?=htmlspecialcharsBx($key)?>"
											name="<?echo $arItem["INPUT_NAME"]?>"
											<?if (in_array($key, $arListValue)) echo 'checked="checked"'?>
											>
											<span class="bx-filter-param-text"><?=htmlspecialcharsEx($value)?></span>
										</label>
									</div>
									<?endforeach?>
								</div>
							</div>
							<?else:?>
							<div class="col col-xl-3">
								<div class="filter-input">
									<?=$arItem["INPUT"]?>
								</div>
							</div>
							<?endif?>
							<?endforeach;?>
							<div class="col col-xl-3">
								<div class="filter-btn">
									<input type="submit" name="set_filter" value="<?=GetMessage("CT_BCF_SET_FILTER")?>" class="btn btn-primary" />
									<input type="hidden" name="set_filter" value="Y" />
									<input type="submit" name="del_filter" value="<?=GetMessage("CT_BCF_DEL_FILTER")?>" class="btn btn-link" />
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>