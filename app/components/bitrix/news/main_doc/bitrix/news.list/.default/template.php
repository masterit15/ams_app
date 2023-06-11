<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<div id="filter_document">
	<div class="filter_item">
		<input placeholder="По названию" id="filter_name" type="text" />
	</div>
	<div class="filter_item">
		<input placeholder="По дате (от - до)" id="filter_date" type="text" data-range="true" data-multiple-dates-separator=" - " class="datepicker-here" autocomplete="off" />
	</div>
	<div class="filter_item">
		<select name="section" id="filter_section">
			<option value="">Тип документа</option>
			<?
			$arFilter = array('IBLOCK_ID' => $arResult['ID'], 'ACTIVE' => 'Y', 'DEPTH_LEVEL' => 1);
			$rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter);
			while ($arSection = $rsSections->Fetch()) { ?>
				<option value="<?= $arSection['ID'] ?>"><?= $arSection['NAME'] ?></option>
			<? } ?>
		</select>
	</div>
	<div class="filter_item">
		<button id="filter_sort" data-sort="desc"><i class="fa fa-sort-amount-desc"></i> По убыванию</button>
	</div>
</div>
<div class="document_list" data-section="<?=$_REQUEST['SECTION_ID']?>" data-iblock="<?= $arResult['ID'] ?>">
</div>