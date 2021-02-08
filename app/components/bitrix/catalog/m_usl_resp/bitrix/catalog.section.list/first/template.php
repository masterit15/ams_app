<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="catalog-section-list">
<div width="100%" border="0">
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
$td=array();
$tdc=array();
$idx=0;
foreach($arResult["SECTIONS"] as $arSection) {
	if ($CURRENT_DEPTH==$arSection["DEPTH_LEVEL"]) {

		if($arSection["ELEMENT_CNT"])
			$txt='<font style="font-size:12pt;"><B><a href="/ams/m_uslugi'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a></B></font>';
		else	$txt='<font style="font-size:12pt;"><B>'.$arSection["NAME"].'</font>';
		if($arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"]) $txt.='&nbsp;<B><font style="font-size:10pt;">('.$arSection["ELEMENT_CNT"].')</font></B>';
// ????????? ???????? ?????????????		
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

// ????????? ?? ??? ???????
$lft_idx = 0;
$rgh_idx = count($td) >> 1;
for ($i=0;$i<count($td);$i+=2) {
?>
		<div class="col-sm-6"><div class="catalog-item"><?=$td[$lft_idx]?></div></div>
		<div class="col-sm-6"><div class="catalog-item"><?=$td[$rgh_idx]?></div></div>
<?
	$lft_idx++;
	$rgh_idx++;
}

?>
</div>
</div>

<pre><?/*print_r($arResult)*/?></pre>