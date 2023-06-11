<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="catalog-section-list">
<table width="100%" border="0">
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
$td=array();
$idx=0;
foreach($arResult["SECTIONS"] as $arSection) {
	if ($CURRENT_DEPTH==$arSection["DEPTH_LEVEL"]) {
		$txt='<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"];
		if($arParams["COUNT_ELEMENTS"]) $txt.='&nbsp;('.$arSection["ELEMENT_CNT"].')';
		$txt.='</a>';
// добавляем картинку предпросмотра		
		if ($arSection['PICTURE']) {
			$pic_name=$arSection['PICTURE']['SRC'];
		} else {
			$templateFolder = $this->GetFolder();
			$pic_name=$templateFolder.'/no_pic.gif';
		}
//
		$txt='<img style="float:left;margin-right:10px;" width="70" height="70" src="'.$pic_name.'"/>'.$txt;
		$txt.="<br/><br/>".$arSection['DESCRIPTION'];
		$td[]=$txt;
	}
}
if ((count($td)%2)==1) $td[]='&nbsp';

// разбираем на две колонки
$lft_idx = 0;
$rgh_idx = count($td) >> 1;
for ($i=0;$i<count($td);$i+=2) {
?>
	<tr>
		<td width="50%" valign="top" align="left"><?=$td[$lft_idx]?></td>
		<td width="50%" valign="top" align="left"><?=$td[$rgh_idx]?></td>
	</tr>
<?
	$lft_idx++;
	$rgh_idx++;
}

?>
</table>
</div>

<pre><?/*print_r($arResult)*/?></pre>