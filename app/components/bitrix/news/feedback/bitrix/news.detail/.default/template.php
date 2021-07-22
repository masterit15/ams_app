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
<a href="/feedback/view.php?RESULT_ID=<?=$arResult["ID"]?>&print" class="btn_print">Распечатать</a>
<ul class="feed-detail">
	<?foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
		<?if ($arProperty['FILE_VALUE']) {?>
			<strong><?=$arProperty["NAME"]?>:</strong><br>
			<?if(count($arProperty['VALUE']) > 1){?>
					<?foreach($arProperty['VALUE'] as $fid){
					$file = getFileArr($fid);
					?>
					<li <?if($file['type'] == 'jpeg' || $file['type'] == 'jpg' || $file['type'] == 'png'){?>class="popup-gallery"<?}?>>
						<?if($file['type'] == 'jpeg' || $file['type'] == 'jpg' || $file['type'] == 'png'){?>
								<a href="<?=$file['path']?>" title="<?=$file['name'];?>"><img src="<?=$file['path']?>" alt="<?=$file['name'];?>"></a>
						<?}else{?>
							<div class="doc_item item" title='<?=$file['name']?>'>
								<a href="<?=$file['src']?>" <?if($file['type'] != 'pdf'){?>download<?}?>>					
									<span class="doc_icon">
										<?=$file['icon']?>
									</span>				
									<div class="doc_detail">			
										<div class="doc_title">
											<?=$file['name'];?>
										</div>
										<span class="doc_date">
											<?=$file['date'];?>
										</span>
									</div>
									<span class="doc_size"><?=$file['size']?></span>
								</a>
							</div>
						<?}?>
					</li>
					<?}?>
				<?}else{
					$file = getFileArr($arProperty['VALUE']);
					?>
					<li <?if($file['type'] == 'jpeg' || $file['type'] == 'jpg' || $file['type'] == 'png'){?>class="popup-gallery"<?}?>>
						<?if($file['type'] == 'jpeg' || $file['type'] == 'jpg' || $file['type'] == 'png'){?>
								<a href="<?=$file['path']?>"><img src="<?=$file['path']?>" alt="<?=$file['name'];?>"></a>
						<?}else{?>
							<div class="doc_item item" title='<?=$file['name']?>'>
								<a href="<?=$file['src']?>" <?if($file['type'] != 'pdf'){?>download<?}?>>					
									<span class="doc_icon">
										<?=$file['icon']?>
									</span>				
									<div class="doc_detail">			
										<div class="doc_title">
											<?=$file['name'];?>
										</div>
										<span class="doc_date">
											<?=$file['date'];?>
										</span>
									</div>
									<span class="doc_size"><?=$file['size']?></span>
								</a>
							</div>
						<?}?>
					</li>
				<?}?>
			<?} elseif($arProperty["VALUE"]["TYPE"] == "HTML") {?>
				<li >
					<div class="feed-detail-value-name"><?=$arProperty["NAME"]?>:</div>
					<textarea disabled><?=$arProperty["VALUE"]['TEXT']?></textarea>
				</li>
			<?}elseif($arProperty['CODE'] !== "STATUS"){?>
				<li >
					<div class="feed-detail-value-name"><?=$arProperty["NAME"]?>:</div>
					<div class="feed-detail-value"><?=$arProperty["VALUE"]?></div>
				</li>
			<?}?>
	<?endforeach;?>
  </ul>