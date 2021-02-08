<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<?if (!empty($arResult)) {?>
<ul>
	<li class="left">
		<div class="specversion">
			<span class="aa-enable aa-hide" tabindex="1" data-aa-on><i class="fa fa-low-vision"></i></span></span>
		</div>
	</li>
	<li class="left">
		<div class="phone">
			<a href="tel:303030">Тел: 30-30-30</a>
		</div>
	</li>
	
	<li class="right">
	<a class="appliction" href="javascript:void(0)" data-izimodal-open="#modal_app_form"
		data-izimodal-transitionin="fadeInDown">
		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
		Подать обращение
	</a>
</li>
<li class="right">
	<a class="soc_icon" href="#!">
		<i class="fa fa-instagram" aria-hidden="true"></i>
	</a>
</li>
<!-- <li class="right">
	<a class="soc_icon" href="#!">
		<i class="fa fa-youtube" aria-hidden="true"></i>
	</a>
</li>
<li class="right">
	<a class="soc_icon"
		href="#!">
		<i class="fa fa-facebook" aria-hidden="true"></i>
	</a>
</li> -->
<li class="right">
		<?Weather()?>
	</li>
<?$previousLevel = 0;
		foreach ($arResult as $arItem) {?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) {?>
		<?=str_repeat('</ul></div></div></li>', ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?}?>
	<?if ($arItem["IS_PARENT"]) {?>
		<?if ($arItem["DEPTH_LEVEL"] == 1) {?>
			<li class="left popup_trigger"><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]) {?>root-item-selected<?} else {?>root-item<?}?>"><?=$arItem["TEXT"]?></a>
				<div class="popup_content">
					<div class="popup_head">
						<h3><?=$arItem['PARAMS']['FIO']?>"</h3>
						<p><?=$arItem['PARAMS']['POST']?>"</p>
					</div>
					<div class="row">
					<div class="col-6">
							<div class="popup_left">
								<img src="<?=$arItem['PARAMS']['IMG']?>" alt="">
							</div>
						</div>
							<div class="col-6">
								<div class="popup_right">
				<ul>
			<?} else {?>
		<li <?if ($arItem["SELECTED"]) {?> class="item-selected"<?}?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
				<ul>
		<?}?>

	<?} else {?>

		<?if ($arItem["PERMISSION"] > "D") {?>

			<?if ($arItem["DEPTH_LEVEL"] == 1) {?>
				<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]) {?>root-item-selected<?} else {?>root-item<?}?>"><?=$arItem["TEXT"]?></a></li>
			<?} else {?>
				<li <?if ($arItem["SELECTED"]) {?> class="item-selected"<?}?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?}?>

		<?} else {?>

			<?if ($arItem["DEPTH_LEVEL"] == 1) {?>
			<li><a href="" class="<?if ($arItem["SELECTED"]) {?>root-item-selected<?} else {?>root-item<?}?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?} else {?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?}?>
		<?}?>
		<?}?>
	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
	<?}?>
<?if ($previousLevel > 1) {?>
	<?=str_repeat('</ul></div></div></div></li>', ($previousLevel - 1));?>
<?}?>
</ul>
<?}?>