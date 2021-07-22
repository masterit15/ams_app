<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

if($arResult["NavPageCount"] > 1)
{
?>
<div class="paginationjs-pages">
  <ul>
    <?if ($arResult["NavPageNomer"] > 1) {?>
      <li class="beginning act"><a href="<?=$arResult["sUrlPath"]?>'?PAGEN_1=1">Начало</a></li>
      <li class="previous act"><a href="<?=$arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a></li>
    <?} else {?>
      <li class="beginning">Начало</li>
      <li class="previous"><?=GetMessage("nav_prev")?></li>
    <?}?>
<?
if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		?>
		<?
		
		if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a></li>
<?
			else:
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
?>
			
<?
			if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
?>
			<span class="blog-page-dots">...</span>
			
<?
			endif;
		endif;
	endif;
	do
	{
		$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
		
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<li class="paginationjs-page active"><a href="#!"><?=$NavRecordGroupPrint?></a></li>
<?
		elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
<?
		else:
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
			?> class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
		
<?
		endif;
		?>
		
		<?
		
		$arResult["nStartPage"]--;
		$bFirst = false;
	} while($arResult["nStartPage"] >= $arResult["nEndPage"]);
	
	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nEndPage"] > 1):
			if ($arResult["nEndPage"] > 2):
?>
		<span class="blog-page-dots">...</span>
		
<?
			endif;
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a></li>
		
<?
		endif;
	
?>
		<li class="paginationjs-page"><a class="blog-page-next"href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a></li>
<?
	endif; 

else:
	$bFirst = true;
	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a></li>
<?
			else:
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
?>
			
<?
			if ($arResult["nStartPage"] > 2):
?>
			<span class="blog-page-dots">...</span>
			
<?
			endif;
		endif;
	endif;

	do
	{
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<li class="paginationjs-page active"><a href="#!"><?=$arResult["nStartPage"]?></a></li>
<?
		elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$arResult["nStartPage"]?></a></li>
<?
		else:
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
			?> class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$arResult["nStartPage"]?></a></li>
<?
		endif;
?>
		
<?
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while($arResult["nStartPage"] <= $arResult["nEndPage"]);
	
	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
?>
		<span class="blog-page-dots">...</span>
		
<?
			endif;
?>
		<li class="paginationjs-page"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li>
		
<?
		endif;
	endif;
endif;

if ($arResult["bShowAll"]):
	if ($arResult["NavShowAll"]):
?>
		<li class="paginationjs-page"><a class="blog-page-pagen" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a></li>
<?
	else:
?>
		<li class="paginationjs-page"><a class="blog-page-all" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a></li>
<?
	endif;
endif
?>
    <?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {?>
      <li class="end act"><a href="<?=$arResult["sUrlPath"].'?PAGEN_1='.$arResult["NavPageCount"]?>">Конец</a></li>
      <li class="next act"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_next")?></a></li>
    <?} else {?>
      <li class="end">Конец</a></li>
      <li class="next"><?=GetMessage("nav_next")?></li>
    <?}?>
  </ul>
</div>
<?
}
?>