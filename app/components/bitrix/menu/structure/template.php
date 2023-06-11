<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))return;
CModule::IncludeModule('iblock')
?>
<!-- <div class="view_btn">
	<button class="small" data-view="small"><i class="fa fa-outdent"></i></button>
	<button class="utter" data-view="utter"><i class="fa fa-sitemap"></i></button>
</div> -->
<div class="tree" data-view='small'>
<ul>
<?
$previousLevel = 0;
$firstRoot = false;
function getWorker($lnk, $item){
	$sectionId = array_pop(explode('/', $lnk));
	// получаем поля раздела по ИД
	
	$section = CIBlockSection::GetList(
		array(),
		array("IBLOCK_ID" => 99, 'ID' =>$sectionId),
		false,
		array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'SORT', 'UF_WORKER', 'UF_POST')
	);
	
	if($ar_res = $section->Fetch()){
		if(isset($ar_res['UF_WORKER'])){	// если сотрудник существует
			// получаем елемент подразделения по ИД привязанного сотрудника
			// $oDep = CIBlockElement::GetList(array(),
			// array('PROPERTY_STR_OFFICER' =>$ar_res['UF_WORKER']),
			// false,
			// false,
			// array('ID'));
			// if($departament = $oDep->Fetch())
			// получаем сотрудника по ИД
			$res = CIBlockElement::GetList(array(),
			array('ID' =>$ar_res['UF_WORKER']),
			false,
			false,
			array('ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DETAIL_PICTURE', 'PROPERTY_DUTY'));
			if($worker = $res->Fetch()){
				$worker['IMG'] = CFile::GetPath($worker['DETAIL_PICTURE']);
				$worker['POST'] = $ar_res['UF_POST'];
			}
		}
	}
	if($worker){// рендерим элемент 
		// PR($ar_res['NAME']);
		if($worker['IMG']){
			echo '<div class="tree_item" data-trigger="hover" data-placement="right" title="'.$worker['PROPERTY_DUTY_VALUE'].'" data-content="<img src=\''.$worker['IMG'].'\'>">';
		}else{
			echo '<div class="tree_item" data-toggle="popover" data-trigger="hover" data-placement="right" title="'.$worker['PROPERTY_DUTY_VALUE'].'">';
		}
			echo '<a href="?WORKER='.$worker['ID'].'" title="'.$worker['POST'].'">';
				echo '<div class="tree_item_content">';
					echo '<div class="tree_item_head">';
						echo '<p>'.$ar_res['NAME'].'</p>';
						// echo '<p>'.$worker['POST'].'</p>';
						echo '<div class="mid">';
							echo  $worker['POST'] ? '<p>'.$worker['POST'].':</p>': '';
							echo '<h3>'.$worker['NAME'].'</h3>';
						echo '</div>';
					echo '</div>';
					echo '<div class="tree_item_media">';
					if($worker['IMG']){
						// echo '<img src="'.$worker['IMG'].'" alt="'.$worker['NAME'].'">';
					}
					echo '</div>';
				echo '</div>';
			echo '</a>';
			//echo '<button class="select_btn">Свернуть <i class="fa fa-chevron-up"></i></button>';
		echo '</div>';
		}else{
			echo '<div class="tree_item">';
				echo '<a href="#">'.$item["TEXT"].'</a>';
				//echo '<button class="select_btn">Свернуть <i class="fa fa-chevron-up"></i></button>';
			echo '</div>';
		}
	}
foreach($arResult as $itemIdex => $arItem){?>
<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
	<?=str_repeat("		</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
<?endif?>
<?if ($arItem["IS_PARENT"]){?>
	<?if ($arItem["DEPTH_LEVEL"] == 1){?>
		<li>
			<?getWorker($arItem["LINK"], $arItem);?>
		<ul>
	<?}else{?>
		<li>
			<?getWorker($arItem["LINK"], $arItem);?>
		<ul>
	<?}?>
<?}else{?>
	<?if ($arItem["PERMISSION"] > "D"){?>
		<?if ($arItem["DEPTH_LEVEL"] == 1){?>
		<li>
			<?getWorker($arItem["LINK"], $arItem);?>
		</li>
		<?}else{?>
			<li>
				<?getWorker($arItem["LINK"], $arItem);?>
			</li>
		<?}?> 
	<?}else{?>
			<?if ($arItem["DEPTH_LEVEL"] == 1){?>
				<li>
					<?getWorker($arItem["LINK"], $arItem);?>
				</li>
			<?}else{?>
				<li>
					<?getWorker($arItem["LINK"], $arItem);?>
				</li>
			<?}?>
	<?}?>
<?}
	$previousLevel = $arItem["DEPTH_LEVEL"];
	if ($arItem["DEPTH_LEVEL"] == 1)
		$firstRoot = true;
?>
<?}
if ($previousLevel > 1)
	echo str_repeat("</ul></li>", ($previousLevel-1));
?>
</ul>
</div>