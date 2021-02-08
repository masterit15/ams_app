<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="catalog-section-list">
<table width="100%" border="0">
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
$td=array();
$tdc=array();
$idx=0;
foreach($arResult["SECTIONS"] as $arSection) {
	if ($CURRENT_DEPTH==$arSection["DEPTH_LEVEL"]) {

		if($arSection["ELEMENT_CNT"])
			$txt='<font style="font-size:12pt;"><B><a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a></B></font>';
		else	$txt='<font style="font-size:12pt;"><B>'.$arSection["NAME"].'</font>';
		if($arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"]) $txt.='&nbsp;<B><font style="font-size:10pt;">('.$arSection["ELEMENT_CNT"].')</font></B>';
// добавляем картинку предпросмотра		
		if ($arSection['PICTURE']) {
			$pic_name=$arSection['PICTURE']['SRC'];
		} else {
			$templateFolder = $this->GetFolder();
			$pic_name=$templateFolder.'/no_pic.gif';
		}
//
		$txt='<img style="float:left;margin-right:10px;" width="80" height="80" src="'.$pic_name.'"/>'.$txt;
		$txt.="<br/><br/><font style='font-size:8pt;'>".$arSection['DESCRIPTION']."</font>";
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
		<td width="50%" height="110px" valign="top" align="left"><div class="catalog-section-list"><?=$td[$lft_idx]?></div></td>
		<td width="50%" height="110px" valign="top" align="left"><div class="catalog-section-list"><?=$td[$rgh_idx]?></div></td>
	</tr>
<?
	$lft_idx++;
	$rgh_idx++;
}

?>
</table>
</div>

<pre><?/*print_r($arResult)*/?></pre>