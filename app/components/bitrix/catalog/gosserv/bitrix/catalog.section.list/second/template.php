<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table width="100%" border="0" style="padding:0;">

<?
// ??????? ????? "??????"

		$arSection=$arResult['SECTION'];
		$GLOBALS['APPLICATION']->SetTitle($arSection['NAME']);
// ???? ???????? ??? - ???? ?? ???????
		if (!$arSection['PICTURE']) foreach ($arSection['PATH'] as $el) if ($el['PICTURE']) $arSection['PICTURE']=$el['PICTURE'];
//		
		if ($arSection['PICTURE']) {
			$arSection['PICTURE']=CFile::GetFileArray($arSection['PICTURE']);
			$pic_src=$arSection['PICTURE']['SRC'];
		} else {
			$templateFolder = $this->GetFolder();
			$pic_src=$templateFolder.'/no_pic2.gif';
		}

?>

	<tr>
		<td width="120" valign="top" align="left">
			<img src="<?=$pic_src?>" width="100" height="100"/>
		</td>
		<td valign="top" align="left" style="border-bottom: 2px solid #DBDBDB;">
			<?=$arSection['DESCRIPTION']?>
		</td>
	</tr>
</table>
	
<div class="catalog-section-list">
	
<table width="100%" border="0" style="padding:0;">
<?
// ?????? ????? "??????"

$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;
$td=array();
$idx=0;
foreach($arResult["SECTIONS"] as $arSection) {
	if ($CURRENT_DEPTH==$arSection["DEPTH_LEVEL"]) {
		$txt='<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"];
		if($arParams["COUNT_ELEMENTS"]) $txt.='&nbsp;('.$arSection["ELEMENT_CNT"].')';
		$txt.='</a>';
// ????????? ???????? ?????????????		
		/*if ($arSection['PICTURE']) {
			$pic_name=$arSection['PICTURE']['SRC'];
		} else {
			$templateFolder = $this->GetFolder();
			$pic_name=$templateFolder.'/no_pic.gif';
		}
//
		$txt='<a href="'.$arSection["SECTION_PAGE_URL"].'">'
			.'<img style="float:left;margin-right:10px;" width="70" height="70" src="'.$pic_name.'" border="0"/>'
			.'</a>'
			.$txt;*/
		$txt.="<br/><br/>".$arSection['DESCRIPTION'];
		$td[]=array("text"=>$txt,"link"=>$arSection["SECTION_PAGE_URL"]);
	}
}
// ????????? ?? ??? ???????
for ($i=0;$i<count($td);$i++) {
?>
	<tr>
		<td width="90" valt"><?=$td[$i]['text']?></td>
	</tr>
<?
}

?>
</table>
</div>

<!--<pre><?/*print_r($arResult)*/?></pre>-->