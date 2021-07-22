<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="news-list">
    <?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="doc-item-boby wow slideInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
       <div class="col-md-1">
        <div class="doc_icon">
            <i class="fa fa-file-text-o"></i>
        </div>
    </div>
    <div class="doc-body">
       <div class="col-md-9">  
        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
        <a href="<?=$arItem["DETAIL_PAGE_URL"];?>"><p class="news-title"><?echo $arItem["NAME"]?></p></a>
        <?endif;?>
    </div>
    <div class="col-md-2"> 
        <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
        <div class="doc-date"><i class="fa fa-calendar"></i> <span><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span></div>
        <?endif?>
    </div>
</div>
</div>
<?endforeach;?>          
</div>   
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<?=$arResult["NAV_STRING"]?>
<?endif;?>
