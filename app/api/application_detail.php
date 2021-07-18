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
    'DETAIL_TEXT',
    'PREVIEW_TEXT',
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
    $arResult = $arr;
  }
  function getTimeline($id){
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array("CODE"=>"TIMELINE"));
      if($ar_props = $db_props->Fetch());
        $json = json_decode($ar_props['VALUE'], true);
        foreach($json as $timeline){
          echo '<li class="timeline_item" style="background-color: '.$timeline['color'].'">';
          if($timeline['color']){
            echo '<span class="timeline_item_icon" style="color: #fff"><i class="fa ' .$timeline['icon']. '"></i></span>';
          }else{
            echo '<span class="timeline_item_icon" ><i class="fa ' .$timeline['icon']. '"></i></span>';
          }
            echo '<div class="timeline_item_wrap">';
              echo '<div class="timeline_item_content" style="border-color: '.$timeline['color'].'">';
                echo '<h3 class="timeline_item_title">' .$timeline['title']. '</h3>';
                echo '<p class="timeline_item_desc">' .$timeline['desc']. '</p>';
                echo '<span class="timeline_item_ava">' . getAvatarText($timeline['userName']) . '</span>';
                echo '<span class="timeline_item_date">' .$timeline['datetime']. '</span>';
              echo '</div>';
            echo '</div>';
          echo '</li>';
        }
  }
?>
<div class="feed-detail" data-elid="<?=$arResult['ID']?>">
    <!-- <span class="feed-detail-date"><?=$arResult['DATE_CREATE']?></span>
    <h3 class="feed-detail-title"><?=$arResult['NAME']?></h3> -->
    <ul class="feed-detail-status-line" data-status-active="<?=$arResult['PROPERTY_STATUS_ENUM_ID']?>">
      <li data-status-id="15" data-elid="<?=$arResult['ID']?>">Не обработана</li>
      <li data-status-id="16" data-elid="<?=$arResult['ID']?>">В работе</li>
      <li data-status-id="17" data-elid="<?=$arResult['ID']?>">Закрыта</li>
    </ul>
  <div class="row">
    <div class="col-12 col-xl-6">
      <div class="feed-detail-left">
      <fieldset class="fieldgroup">
        <legend>
          Данные об инициаторе
        </legend>
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
        </fieldset>
        <fieldset class="fieldgroup">
          <legend>
            Суть и ткекст обращения
          </legend>
        <div class="group">
          <textarea class="app_form_textarea" type="text" disabled><?=$arResult['PREVIEW_TEXT'];?></textarea>
          <label>Суть вопроса</label>
        </div>
        <div class="group">
          <textarea class="app_form_textarea" type="text" disabled><?=$arResult['DETAIL_TEXT'];?></textarea>
          <label>Тексть обращения</label>
        </div>
        </fieldset>
        <fieldset class="fieldgroup">
          <legend>
            Прикрепленные файлы обращения
          </legend>
          <ul class="file_list">
          <?foreach($arResult['PROPERTY_APPLICATION_FILES_VALUE'] as $fileId){
          $file = getFileArr($fileId);
          ?>
          <li class="file">
            <a href="<?=$file['path']?>" target="_blank" rel="noopener noreferrer" download title="<?=$file['name']?>">
            <?=$file['icon']?>
            </a>
          </li>
          <?}?>
          </ul>
        </fieldset>
      </div>
    </div>
    <div class="col-12 col-xl-6">
      <div class="feed-detail-right">
        <div class="feed-detail-action">
          <ul class="feed-detail-action-list">
            <li class="feed-detail-action-item addcomment"><i class="fa fa-comment-o"></i></li>
            <li class="feed-detail-action-item addresponsible"><i class="fa fa-users"></i></li>
            <li class="feed-detail-action-item addanswer"><i class="fa fa-pencil-square-o"></i></li>
          </ul>
          <div class="feed-detail-action-content"></div>
        </div>
        <ul class="timeline">
          <?getTimeline($arResult['ID']);?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?} // if(CModule::IncludeModule('iblock'))?>