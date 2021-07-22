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
<div class="news-detail">
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
	<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
	<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?
	$usen_name = strip_tags($arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_RESPONSIBLE_NAME"]["DISPLAY_VALUE"]);
	$OPEN_DATA_PUBLIC_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_PUBLIC_DATE"]["VALUE"]));
	$OPEN_DATA_ACTUEL_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_ACTUEL_DATE"]["VALUE"]));
	$OPEN_DATA_LOST_CANGE_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_LOST_CANGE_DATE"]["VALUE"]));
	$OPEN_DATA_SET_CREATE_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_SET_CREATE_DATE"]["VALUE"]));
	$OPEN_DATA_CREATE_STRUCTURE_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_CREATE_STRUCTURE_DATE"]["VALUE"]));
	$OPEN_DATA_CREATE_RELEVANT_STRUCTURE_DATE = CIBlockFormatProperties::DateFormat('Y.m.d', strtotime($arResult["PROPERTIES"]["OPEN_DATA_CREATE_RELEVANT_STRUCTURE_DATE"]["VALUE"]));

	$OPEN_DATA_FORMAT_DATA 					= explode(".", $arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_FILE"]["FILE_VALUE"]["FILE_NAME"]);
	$OPEN_DATA_STRUCTURE_DATASET 	= explode(".", $arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_STRUCTURE_FILE"]["FILE_VALUE"]["FILE_NAME"]);
	?>
	<table cellspacing="1" cellpadding="1" border="2" style="border: 2px solid #ddd;">
		<tbody>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_ID"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_ID"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_NAME"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_NAME"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_TEXT"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_TEXT"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_OWNER"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_OWNER"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_PUBLIC_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_PUBLIC_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_LOST_CANGE_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_LOST_CANGE_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_KEY_WORDS"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_KEY_WORDS"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_FORMAT_DATA"]["NAME"];?>
					Формат данных
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_FORMAT_DATA[1];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_SRC_FILE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<a href="<?=$arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_FILE"]["FILE_VALUE"]["SRC"];?>"><?=$arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_FILE"]["FILE_VALUE"]["ORIGINAL_NAME"];?></a>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_SET_CREATE_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_SET_CREATE_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_DESCRIPTION_CHANGES"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_DESCRIPTION_CHANGES"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_ACTUAL_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_ACTUAL_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_CREATE_RELEVANT_STRUCTURE_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_CREATE_RELEVANT_STRUCTURE_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_STRUCTURE_DATASET"]["NAME"];?>
					Структура набора открытых данных
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_STRUCTURE_DATASET[1];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_SRC_STRUCTURE_FILE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<a target="_blanck" href="<?=$arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_STRUCTURE_FILE"]["FILE_VALUE"]["SRC"];?>"><?=$arResult["DISPLAY_PROPERTIES"]["OPEN_DATA_SRC_STRUCTURE_FILE"]["FILE_VALUE"]["ORIGINAL_NAME"];?></a>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_CREATE_STRUCTURE_DATE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$OPEN_DATA_CREATE_STRUCTURE_DATE;?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_NAME"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$usen_name;?>
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_NAME_TEXT"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_PHONE"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_PHONE"]["VALUE"];?>
				</td>
			</tr>
			<tr style="border: 2px solid #ddd;">
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_EMAIL"]["NAME"];?>
				</td>
				<td style="border: 2px solid #ddd;padding: 12px;max-width:50%;">
					<?=$arResult["PROPERTIES"]["OPEN_DATA_RESPONSIBLE_EMAIL"]["VALUE"];?>
				</td>
			</tr>
		</tbody>
	</table>
</div>