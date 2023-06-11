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
$ajaxPage = "/bitrix/templates/app/components/bitrix/news.list/vote_roads/ajax.php";
$ips = array();
?>
<div class="vote_container">
	<?
	$index = 1; // Порядковый номер объекта на карте
	foreach ($arResult["ITEMS"] as $arItem) { ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	<label for="vote-v-<?=$arItem['ID']?>" class="vote_label">
		<input class="vote_input" type="checkbox" name="<?=$arItem['ID']?>" id="vote-v-<?=$arItem['ID']?>">
		<?=$arItem['NAME']?>
	</label>
	<? 
	$ips[] = explode(',', $arItem["PROPERTIES"]['IP_ADDRESS']['VALUE']);
	++$index;

	unset($index); 
	// PR($arItem);
	?>
<?
}
$ipArr = walkArr($ips);
if(in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
	$isVote = true;
}else{
	$isVote = false;
}
?>
</div>
<div class="bottom_panel">
	<?if(!$isVote){?>
		<button class="vote_button">Голосовать</button>
	<?}else{?>
		<h3>Вы уже голосовали</h3>
	<?}?>	
</div>
<script>
			let count = 0
			let elids = []
		$('.vote_input').on('change',function(){
			if($(this).is(':checked')){
				count+=1
				let index = elids.findIndex(e=>e == $(this).attr('name'))
				if(index == -1){
					elids.push($(this).attr('name'))
				}
			}else{
				count-=1
				let index = elids.findIndex(e=>e == $(this).attr('name'))
				if(index > -1){
					elids.splice(index, 1)
				}
			}
			if(count >= 3){
				
				$('.vote_input').attr("disabled", true)
				$('.vote_input:checked').removeAttr("disabled")
			}else{
				$('.vote_input').removeAttr("disabled")
			}

			if (count > 0){
				$('.bottom_panel').addClass('active')
			}else{
				$('.bottom_panel').removeClass('active')
			}
		})
			<?if(!$isVote){?>
				$('.vote_button').on('click', function(){
					let data = {
						elids,
						action: 'vote',
						ip_address: "<?=$_SERVER['REMOTE_ADDR']?>",
					};
					actionAjax(data)
				})
			<?}?>

			function actionAjax(data){
			let ajaxresult = {}
			return $.ajax({
				method: "POST",
				url: "<?= $ajaxPage; ?>",
				data: data,
				success: function(res) {
					console.log(res);
					if(res.success){
						alert(res.title)
						$('.bottom_panel').html(res.desc)
					}
				},
				error: function(res) {
					$(".results").attr("data-status", "error").text('Ошибка отправки, попробуйте презагрузить страницу');
				}
				
			})
			return ajaxresult
		}
</script>