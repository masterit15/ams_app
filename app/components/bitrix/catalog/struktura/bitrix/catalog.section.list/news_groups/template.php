<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-section-list">
Группы новостей: <?
$c = 0;
foreach($arResult["SECTIONS"] as $arSection): if ($c>0) echo ' | '; $c++;
?><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?></a>
<?endforeach?>
</div>
