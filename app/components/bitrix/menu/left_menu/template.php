<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
	<div id="accordion-menu" class="accordion-menu">
		<ul class="left_menu">
<?
$previousLevel = 0;
foreach($arResult as $arItem):
$str 				=	str_ireplace("\"", "", $arItem["TEXT"]);
$strCount 	=	mb_strlen($str);
?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			
			<li><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"  class="<?if ($arItem["SELECTED"]):?>active<?else:?>root-item<?endif?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
				<span class="sub_open"><i class="fa fa-chevron-right"></i></span>
				<ul class="submenu">
		<?else:?>
			<li><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"  class="parent<?if ($arItem["SELECTED"]):?> active<?endif?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
				<span class="sub_open"><i class="fa fa-chevron-right"></i></span>
				<ul class="submenu">
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"  class="<?if ($arItem["SELECTED"]):?>active<?else:?>root-item<?endif?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
			<?else:?>
				<li <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"  <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href=""  class="<?if ($arItem["SELECTED"]):?>active<?else:?>root-item<?endif?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
			<?else:?>
				<li <?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href=""  class="denied"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
</div>
<?endif?>