<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('iblock')) {

  //$file = getFileArr($filesId[0]);
  $arFilter = array(
      'ID' => $_GET["id"],
  );
  $arSelect = array(
    'ID',
    'NAME',
    'DATE_CREATE',
    'PROPERTY_FIO',
    'PROPERTY_PHONE',
    'PROPERTY_EMAIL',
    'PROPERTY_PERSON',
    'PROPERTY_STATUS',
    'PROPERTY_DEPARTAMENT',
    'PROPERTY_ORGANIZATION',
    'PROPERTY_APPLICATION_TEXT',
    'PROPERTY_APPLICATION_FILES',
    'PROPERTY_APPLICATION_QUESTION'
  );
  $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
  while ($arr = $res->GetNext()) {
    $files[] = $arr['PROPERTY_APPLICATION_FILES_VALUE'];
    $arResult = $arr;
  }
					
  $arResult['PROPERTY_APPLICATION_FILES_VALUE'] = $files;

  function getTimeline($id){
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array("CODE"=>"TIMELINE"));
      if($ar_props = $db_props->Fetch());
        $json = json_decode($ar_props['VALUE'], true);
        foreach($json as $timeline){
          echo '<li class="timeline_item">';
            echo '<span class="timeline_item_icon"><i class="fa ' .$timeline['icon']. '"></i></span>';
            echo '<div class="timeline_item_content">';
              echo '<h3 class="timeline_item_title">' .$timeline['title']. '</h3>';
              echo '<p class="timeline_item_desc">' .$timeline['desc']. '</p>';
              $ava = explode(' ', $timeline['userName']);
              $abrev = mb_substr($ava[0], 0, 1).mb_substr($ava[1], 0, 1);
              echo '<span class="timeline_item_ava">' . $abrev . '</span>';
              echo '<span class="timeline_item_date">' .$timeline['datetime']. '</span>';
            echo '</div>';
          echo '</li>';
        }
  }
  // $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), array());
  //   while ($ar_props = $db_props->Fetch()) {
  //     PR($ar_props);
  //   }
?>
<div class="feed-detail">
  <h3 class="feed-detail-title"><?=$arResult['NAME']?></h3>
  <ul class="feed-detail-status-line" data-status-active="<?=$arResult['PROPERTY_STATUS_ENUM_ID']?>">
    <li data-status-id="15" data-elid="<?=$arResult['ID']?>">Не обработана</li>
    <li data-status-id="16" data-elid="<?=$arResult['ID']?>">В работе</li>
    <li data-status-id="17" data-elid="<?=$arResult['ID']?>">Закрыта</li>
  </ul>
  <div class="row">
    <div class="col-12 col-xl-6">
      <div class="feed-detail-left">
        <div class="group">
          <input type="text" disabled value="<?=$arResult['PROPERTY_FIO_VALUE'];?>">
          <label>ФИО</label>
        </div>
        <div class="group">
          <input type="text" disabled value="<?=$arResult['PROPERTY_PHONE_VALUE'];?>">
          <label>Телефон</label>
        </div>
        <div class="group">
          <input type="text" disabled value="<?=$arResult['PROPERTY_EMAIL_VALUE'];?>">
          <label>Е-почта</label>
        </div>
        <div class="group">
          <input type="text" disabled value="<?=$arResult['PROPERTY_ORGANIZATION_VALUE'];?>">
          <label>Название организации</label>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-6">
      <div class="feed-detail-left">
        <ul class="timeline">
          <?getTimeline($arResult['ID']);?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?} // if(CModule::IncludeModule('iblock'))?>