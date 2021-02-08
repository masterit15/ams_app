<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-section-list">
  <select name="news_cat" id="news_cat">
    <option value="#">Категории:</option>
    <?foreach($arResult["SECTIONS"] as $arSection){ ?>
      <option value="<?=$arSection["ID"]?>"><?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?></option>
    <?}?>
  </select>
</div>
