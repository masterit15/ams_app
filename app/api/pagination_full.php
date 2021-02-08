<?
$strNavQueryString = ($this->NavQueryString != "" ? $this->NavQueryString."&amp;" : "");
$strNavQueryStringFull = ($this->NavQueryString != "" ? "?".$this->NavQueryString : "");
PR($strNavQueryStringFull);
if($this->NavPageNomer > 1)
{
?>
<div class="paginationjs-pages">
  <ul>
    <?if ($this->NavPageNomer > 1) {?>
      <li class="beginning act"><a href="<?=$this->sUrlPath?>'?PAGEN_1=1">Начало</a></li>
      <li class="previous act"><a href="<?=$this->sUrlPath.'?'.$strNavQueryString.'PAGEN_'.$this->NavNum.'='.($this->NavPageNomer-1)?>"><?=GetMessage("nav_prev")?></a></li>
    <?} else {?>
      <li class="beginning">Начало</li>
      <li class="previous"><?=GetMessage("nav_prev")?></li>
    <?}?>
<?
if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($this->NavPageNomer < $this->NavPageCount):
		?>
		<?
		
		if ($this->nStartPage < $this->NavPageCount):
			$bFirst = false;
			if($this->bSavePage):
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=$this->NavPageCount?>">1</a></li>
<?
			else:
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$this->sUrlPath?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
?>
			
<?
			if ($this->nStartPage < ($this->NavPageCount - 1)):
?>
			<span class="blog-page-dots">...</span>
			
<?
			endif;
		endif;
	endif;
	do
	{
		$NavRecordGroupPrint = $this->NavPageCount - $this->nStartPage + 1;
		
		if ($this->nStartPage == $this->NavPageNomer):
?>
		<li class="paginationjs-page active"><a href="#!"><?=$NavRecordGroupPrint?></a></li>
<?
		elseif($this->nStartPage == $this->NavPageCount && $this->bSavePage == false):
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
<?
		else:
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=$this->nStartPage?>"<?
			?> class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$NavRecordGroupPrint?></a></li>
		
<?
		endif;
		?>
		
		<?
		
		$this->nStartPage--;
		$bFirst = false;
	} while($this->nStartPage >= $this->nEndPage);
	
	if ($this->NavPageNomer > 1):
		if ($this->nEndPage > 1):
			if ($this->nEndPage > 2):
?>
		<span class="blog-page-dots">...</span>
		
<?
			endif;
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=1"><?=$this->NavPageCount?></a></li>
		
<?
		endif;
	
?>
		<li class="paginationjs-page"><a class="blog-page-next"href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer-1)?>"><?=GetMessage("nav_next")?></a></li>
<?
	endif; 

else:
	$bFirst = true;
	if ($this->NavPageNomer > 1):
		if ($this->nStartPage > 1):
			$bFirst = false;
			if($this->bSavePage):
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=1">1</a></li>
<?
			else:
?>
			<li class="paginationjs-page"><a class="blog-page-first" href="<?=$this->sUrlPath?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
?>
			
<?
			if ($this->nStartPage > 2):
?>
			<span class="blog-page-dots">...</span>
			
<?
			endif;
		endif;
	endif;

	do
	{
		if ($this->nStartPage == $this->NavPageNomer):
?>
		<li class="paginationjs-page active"><a href="#!"><?=$this->nStartPage?></a></li>
<?
		elseif($this->nStartPage == 1 && $this->bSavePage == false):
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$this->nStartPage?></a></li>
<?
		else:
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=$this->nStartPage?>"<?
			?> class="<?=($bFirst ? "blog-page-first" : "")?>"><?=$this->nStartPage?></a></li>
<?
		endif;
?>
		
<?
		$this->nStartPage++;
		$bFirst = false;
	} while($this->nStartPage <= $this->nEndPage);
	
	if($this->NavPageNomer < $this->NavPageCount):
		if ($this->nEndPage < $this->NavPageCount):
			if ($this->nEndPage < ($this->NavPageCount - 1)):
?>
		<span class="blog-page-dots">...</span>
		
<?
			endif;
?>
		<li class="paginationjs-page"><a href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=$this->NavPageCount?>"><?=$this->NavPageCount?></a></li>
		
<?
		endif;
	endif;
endif;

if ($this->bShowAll):
	if ($this->NavShowAll):
?>
		<li class="paginationjs-page"><a class="blog-page-pagen" href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>SHOWALL_<?=$this->NavNum?>=0"><?=GetMessage("nav_paged")?></a></li>
<?
	else:
?>
		<li class="paginationjs-page"><a class="blog-page-all" href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>SHOWALL_<?=$this->NavNum?>=1"><?=GetMessage("nav_all")?></a></li>
<?
	endif;
endif
?>
    <?if ($this->NavPageNomer < $this->NavPageCount) {?>
      <li class="end act"><a href="<?=$this->sUrlPath.'?PAGEN_1='.$this->NavPageCount?>">Конец</a></li>
      <li class="next act"><a href="<?=$this->sUrlPath?>?<?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer+1)?>"><?=GetMessage("nav_next")?></a></li>
    <?} else {?>
      <li class="end">Конец</a></li>
      <li class="next"><?=GetMessage("nav_next")?></li>
    <?}?>
  </ul>
</div>
<?
}
?>