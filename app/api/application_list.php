<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('iblock')) {
  function getElementProps($id, $ibId){
    $arProp = CIBlockElement::GetProperty($ibId, $id, Array("sort"=>"asc"), Array("CODE"=>"APPLICATION_FILE"));
    $arRes = array();
    while ($arPropRes = $arProp->Fetch()){
      $arRes[] = $arPropRes['VALUE'];
    }
    return $arRes;
  }
  $date = explode(" - ", $_REQUEST['date']);
  $from = $date[0];
  $to = $date[1];
  $arOrder  = array("ID" => $_REQUEST['sort']);
  $arSelect = array(
    "ID", 
    "NAME", 
    "IBLOCK_ID", 
    "DATE_CREATE", 
    "ACTIVE_FROM", 
    "DETAIL_TEXT",
    "PREVIEW_TEXT",
    "PROPERTY_FIO",
    "PROPERTY_PHONE",
    "PROPERTY_EMAIL",
    "PROPERTY_STATUS",
    "PROPERTY_ADDRESS",
    "PROPERTY_TIMELINE",
    "PROPERTY_DEPARTAMENT",
    "PROPERTY_ORGANIZATION",
    "PROPERTY_APPLICATION_FILES",
    
  );
  $arFilter = array(
    "IBLOCK_ID"=> IntVal($_REQUEST['iblock']),  
    "ACTIVE"=>"N",
    "?NAME" => '%'.$_REQUEST["name"].'%',
    ">=DATE_CREATE" => $from,
    "<=DATE_CREATE" => $to,
    'INCLUDE_SUBSECTIONS'=>'Y',
  );
  if($_REQUEST["section"]) $arFilter["PROPERTY_STATUS"] = $_REQUEST["section"];
  $res = CIBlockElement::GetList($arOrder, $arFilter, false, array(), $arSelect);
  $res->NavStart(20, false);
  if(!$res->arResult){
    echo '<div class="search_result_item" style="text-align: center;">';
      echo      '<h3>По вашему запросу ничего не найдено!</h3>';
    echo '</div>';
  }else{
  foreach($res->arResult as $doc)
  {
    $filesId = getElementProps($doc['ID'], $doc['IBLOCK_ID']);
	  getAvatarText($doc['PROPERTIES']['FIO']['VALUE']);
	?>
  <div class="folder">
    <div class="folder-summary">
      <?
      $date = explode(' ', $doc['DATE_CREATE']);

      switch ($doc['PROPERTY_STATUS_ENUM_ID']) {
        case 16:
          $color = '#f5b918';
          break;
        case 17:
          $color = '#00c99c';
          break;
        default:
        $color = '#fb7077';
          break;
      }?>
      <span class="folder-summary__status" style="background-color: <?=$color?>30; color: <?=$color?>"><?=$doc['PROPERTY_STATUS_VALUE']?></span>
        <div class="folder-summary__start">
        <div class="folder-summary__file-count">
          <div class="folder-summary__avatar">
            <span class="avatar"><?=getAvatarText($doc['PROPERTY_FIO_VALUE'])?></span>
          </div>
        </div>
      </div>
      <div class="folder-summary__details" data-panel data-date="<?=$date[0].' в '.$date[1];?>" data-title="<?=$doc["NAME"]?>" data-id="<?=$doc["ID"]?>" data-url="/bitrix/templates/app/api/application_detail.php">
      <div class="folder-summary__details__name">
        <?=strip_tags($doc["NAME"]);?>
      </div>
      <div class="folder-summary__details__share">
      <?=$date[0].' в '.$date[1];?>
      </div>
      </div>
      <div class="folder-summary__end">
      <div class="print_btn"><i class="fa fa-print" aria-hidden="true"></i></div>
      <div class="block_to_print" style="display:none; ">
        <div class="block_to_print_head">
          <h3 class="block_to_print_title" style="text-align:center;"><?=$doc['NAME']?></h3>
          <span class="block_to_print_number" style="display:block;float:left;">№ <?=$doc['ID']?>-1</span>
          <span class="block_to_print_date" style="display:block;float:right;"><strong>Дата подачи:</strong><?=$date[0].' в '.$date[1];?></span>
        </div>
        <br>
        <hr>
        <div class="block_to_print_text">
          <ul style="margin:0;padding:0;list-style:none;">
            <li><strong>ФИО:</strong> <?=$doc['PROPERTY_FIO_VALUE']?></li>
            <li><strong>Телефон:</strong> <?=$doc['PROPERTY_PHONE_VALUE']?></li>
            <li><strong>Е-почта:</strong> <?=$doc['PROPERTY_EMAIL_VALUE']?></li>
            <li><strong>Адрес:</strong> <?=$doc['PROPERTY_ADDRESS_VALUE']?></li>
            <li><strong>Название организации:</strong> <?=$doc['PROPERTY_ORGANIZATION_VALUE']?></li>
            <li><strong>Статус:</strong> <?=$doc['PROPERTY_STATUS_VALUE']?></li>
          </ul>
          <p class="block_to_print_quest"><strong>Тема обращения:</strong></br> <?=$doc['PREVIEW_TEXT']?></p>
          <p class="block_to_print_feedtext"><strong>Текст обращения:</strong></br> <?=$doc['DETAIL_TEXT']?></p>
        </div>
      </div>
      </div>
    </div>
  </div>
  <?
    } // foreach($res->arResult as $doc)
  } // if(!$res->arResult) }else{
		$res->NavPrint("", false, "", "/bitrix/templates/app/api/pagination.php");
}
?>