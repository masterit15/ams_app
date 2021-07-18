<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

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
<div class="bidding-list">
<?if ($arParams["DISPLAY_TOP_PAGER"]): ?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach ($arResult["ITEMS"] as $arItem): ?>
	<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<div class="folder" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
  <div class="folder-summary js_toggle-folder">
    <div class="folder-summary__start">
				<div class="folder-summary__file-count">
          <span class="folder-summary__file-count__amount"><?=count($arItem["DISPLAY_PROPERTIES"])?></span>
						<i class="fa fa-folder"></i>
						<i class="fa fa-folder-open"></i>
				</div>
			</div>
    <div class="folder-summary__details">
      <div class="folder-summary__details__name">
        <?if ($arItem["DETAIL_TEXT"]) {
            echo strip_tags($arItem["DETAIL_TEXT"]);
        } elseif($arItem["PREVIEW_TEXT"]) {
            echo strip_tags($arItem["PREVIEW_TEXT"]);
        }else{
            echo strip_tags($arItem["NAME"]);
        }
        ?>
      </div>
      <div class="folder-summary__details__share">
			<?if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]) {?>
				<?=$arItem["DISPLAY_ACTIVE_FROM"]?>
			<?}?>
      </div>
    </div>
    <div class="folder-summary__end">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" /></svg>
    </div>
  </div>
  <ul class="folder-content">
  <?foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
    <?if ($arProperty['FILE_VALUE']['FILE_NAME']) {
      $file = getFileArr($arProperty['FILE_VALUE']['ID']);
      ?>
			<li class="folder-item js_folder-item">
      <a class="folder-item-wrap" href="<?=$file['path']?>" <?if ($file['type'] != 'pdf') {?>download<?}?>>
        <div class="folder-item__icon"><?=$file['icon'];?></div>
        <div class="folder-item__details">
          <div class="folder-item__details__name"><?echo $arProperty["NAME"] ? $arProperty["NAME"] : $file['name'];?></div>
          <div class="folder-item__details__date"><?=$file['date'];?></div>
        </div>
        <div class="folder-item__size"><?=$file['size'];?></div>
      </a>
    </li>
      <?} else {?>
        <li class="folder-item js_folder-item">
          <div class="folder-item-wrap">
            <div class="folder-item__details">
              <div class="folder-item__details__name">
                <?=$arProperty["NAME"]?>
              </div>
            </div>
            <div class="folder-item__size"><?=$arProperty['VALUE']?></div>
          </div>
        </li>
      <?}?>
  <?endforeach;?>
  <?if(count($arItem["DISPLAY_PROPERTIES"]) > 1){?>
    <li class="folder-item js_folder-item download_zip">
      <div no-data-pjax class="folder-item-wrap">
        <div class="folder-item__icon"><i class="fa fa-file-archive-o" style="color:#f3aa16"></i></div>
        <div class="folder-item__details">
          <div class="folder-item__details__name">
            Скачать все файлы одним архивом
          </div>
        </div>
        <div class="folder-item__size"><i class="fa fa-download"></i></div>
      </div>
    </li>
  <?}?>
  </ul>
</div>
<?endforeach;?>
<?if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
