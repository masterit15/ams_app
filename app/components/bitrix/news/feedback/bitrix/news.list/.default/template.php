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
// PR($_SERVER);
?><?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?
	getAvatarText($arItem['PROPERTIES']['FIO']['VALUE']);
	?>
<div class="folder" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
  <div class="folder-summary js_toggle-folder">
		<?
		$date = explode(' ', $arItem['DATE_CREATE']);
		switch ($arItem['PROPERTIES']['STATUS']['VALUE_XML_ID']) {
			case 'in_progress':
				$color = '#f5b918';
				break;
			case 'is_closed':
				$color = '#00c99c';
				break;
			default:
			$color = '#fb7077';
				break;
		}?>
		<span class="folder-summary__status" style="background-color: <?=$color?>30; color: <?=$color?>"><?=$arItem['PROPERTIES']['STATUS']['VALUE']?></span>
    <div class="folder-summary__start">
			<div class="folder-summary__file-count">
				<div class="folder-summary__avatar">
					<span class="avatar"><?=getAvatarText($arItem['PROPERTIES']['FIO']['VALUE'])?></span>
				</div>
			</div>
		</div>
    <div class="folder-summary__details">
      <div class="folder-summary__details__name">
        <?=strip_tags($arItem["NAME"]);?> № <?=$arItem['ID']?>-1
      </div>
      <div class="folder-summary__details__share">
				<?=$date[0].' в '.$date[1];?>
      </div>
    </div>
    <div class="folder-summary__end">
			<div class="print_btn" data-id="<?=$arItem['ID']?>"><i class="fa fa-print" aria-hidden="true"></i></div>
			<div class="block_to_print" style="display:none; ">
					<div class="block_to_print_head">
						<h3 class="block_to_print_title" style="text-align:center;"><?=$arItem['NAME']?></h3>
						<span class="block_to_print_number" style="display:block;float:left;">№ <?=$arItem['ID']?>-1</span>
						<span class="block_to_print_date" style="display:block;float:right;"><strong>Дата подачи:</strong><?=$date[0].' в '.$date[1];?></span>
					</div>
					<br>
					<hr>
					<div class="block_to_print_text">
						<ul style="margin:0;padding:0;list-style:none;">
							<li><strong><?=$arItem['PROPERTIES']['FIO']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['FIO']['VALUE']?></li>
							<li><strong><?=$arItem['PROPERTIES']['PHONE']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['PHONE']['VALUE']?></li>
							<li><strong><?=$arItem['PROPERTIES']['EMAIL']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['EMAIL']['VALUE']?></li>
							<li><strong><?=$arItem['PROPERTIES']['ADDRESS']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></li>
							<li><strong><?=$arItem['PROPERTIES']['ORGANIZATION']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['ORGANIZATION']['VALUE']?></li>
							<li><strong><?=$arItem['PROPERTIES']['STATUS']['NAME']?>:</strong> <?=$arItem['PROPERTIES']['STATUS']['VALUE']?></li>
						</ul>
						<p class="block_to_print_quest"><strong>Тема обращения:</strong> <?=$arItem['PREVIEW_TEXT']?></p>
						<p class="block_to_print_feedtext"><strong>Текст обращения:</strong> <?=$arItem['DETAIL_TEXT']?></p>
					</div>
				</div>

    </div>
  </div>
  <ul class="folder-content">
	<?foreach ($arItem["DISPLAY_PROPERTIES"] as $arProperty):?>
		<?if ($arProperty['FILE_VALUE']) {?>
			<?if(is_countable($arProperty['VALUE']) && count($arProperty['VALUE']) > 1){?>
					<?foreach($arProperty['VALUE'] as $fid){
					$file = getFileArr($fid);
					?>
					<li class="folder-item js_folder-item">
						<a class="folder-item-wrap" href="<?=$file['path']?>" <?if ($file['type'] != 'pdf') {?>download<?}?>>
							<div class="folder-item__icon"><?=$file['icon'];?></div>
							<div class="folder-item__details">
								<div class="folder-item__details__name"><?echo $file['name'];?></div>
								<div class="folder-item__details__date"><?=$file['date'];?></div>
							</div>
							<div class="folder-item__size"><?=$file['size'];?></div>
						</a>
					</li>
					<?}?>
				<?}else{
					$file = getFileArr($arProperty['VALUE'][0]);
					?>
					<li class="folder-item js_folder-item">
						<a class="folder-item-wrap" href="<?=$file['path']?>" <?if ($file['type'] != 'pdf') {?>download<?}?>>
							<div class="folder-item__icon"><?=$file['icon'];?></div>
							<div class="folder-item__details">
								<div class="folder-item__details__name"><?echo $file['name'];?></div>
								<div class="folder-item__details__date"><?=$file['date'];?></div>
							</div>
							<div class="folder-item__size"><?=$file['size'];?></div>
						</a>
					</li>
				<?}?>
			<?} elseif(isset($arProperty["VALUE"]["TYPE"]) && $arProperty["VALUE"]["TYPE"] == "HTML") {?>
        <li class="folder-item js_folder-item">
          <div class="folder-item-wrap">
            <div class="folder-item__details">
              <div class="folder-item__details__name"><?=$arProperty["NAME"]?></div>
							<div class="folder-item__details__value"><?=$arProperty["VALUE"]["TEXT"]?></div>
            </div>
          </div>
        </li>
			<?}elseif($arProperty['CODE'] !== "STATUS"){?>
				<li class="folder-item js_folder-item">
          <div class="folder-item-wrap">
            <div class="folder-item__details">
						<div class="folder-item__details__name"><?=$arProperty["NAME"]?></div>
							<div class="folder-item__details__value"><?=$arProperty["VALUE"]?></div>
            </div>
          </div>
        </li>
			<?}?>
	<?endforeach;?>
	<li class="folder-item js_folder-item">
		<div class="folder-item-wrap">
				<div class="folder-item__details__action">
					<div data-panel data-title="<?=$arItem["NAME"]?>" data-date="<?=$arItem["DATE_CREATE"]?>" data-id="<?=$arItem["ID"]?>" data-url="/bitrix/templates/app/api/application_detail.php" class="folder-item__details__btn">Подробнее</div>
				</div>
		</div>
	</li>
  </ul>

</div>
<?endforeach;
if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>