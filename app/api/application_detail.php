<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('iblock')) {
  function getProps($id){
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array());
    $res = array();
    while($ar_props = $db_props->Fetch()){
      $res[] = $ar_props;
    }
    return $res;
  }
  //$file = getFileArr($filesId[0]);
  // $arFilter = array(
  //     'ID' => $_GET["id"],
  // );
  // $arSelect = array(
  //   'ID',
  //   'NAME',
  //   'DATE_CREATE',
  //   'DETAIL_TEXT',
  //   'PREVIEW_TEXT',
  //   'PROPERTY_FIO',
  //   'PROPERTY_PHONE',
  //   'PROPERTY_EMAIL',
  //   'PROPERTY_PERSON',
  //   'PROPERTY_STATUS',
  //   'PROPERTY_DEPARTAMENT',
  //   'PROPERTY_ORGANIZATION',
  //   'PROPERTY_APPLICATION_TEXT',
  //   'PROPERTY_APPLICATION_FILES',
  //   'PROPERTY_APPLICATION_QUESTION'
  // );
  // $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
  // while ($arr = $res->GetNext()) {
  //   $arResult = $arr;

  // }
  $res = CIBlockElement::GetByID($_GET["id"]);
  if($ar_res = $res->GetNext())
    $arResult = $ar_res;
    foreach(getProps($ar_res['ID']) as $prop){
      $arResult['PROP'][$prop['CODE']][] = $prop['VALUE'];
    }
    

  
  function getTimeline($id){
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array("CODE"=>"TIMELINE"));
      if($ar_props = $db_props->Fetch());
        $json = json_decode($ar_props['VALUE'], true);
        foreach($json as $timeline){
          echo '<li class="timeline_item" data-event="'.$timeline['event'].'" style="background-color: '.$timeline['color'].'">';
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
    <ul class="feed-detail-status-line" data-status-active="<?=$arResult['PROP']['STATUS'][0]?>">
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
        <?if($arResult['PROP']['FIO'][0]){?>
          <div class="group">
            <input type="text" disabled value="<?=$arResult['PROP']['FIO'][0];?>">
            <label>ФИО</label>
          </div>
        <?}?>
        <?if($arResult['PROP']['PHONE'][0]){?>
          <div class="group">
            <input type="text" disabled value="<?=$arResult['PROP']['PHONE'][0];?>">
            <label>Телефон</label>
          </div>
        <?}?>
        <?if($arResult['PROP']['EMAIL'][0]){?>
          <div class="group">
            <input type="text" disabled value="<?=$arResult['PROP']['EMAIL'][0];?>">
            <label>Е-почта</label>
          </div>
        <?}?>
        <?if($arResult['PROP']['ORGANIZATION'][0]){?>
          <div class="group">
            <input type="text" disabled value="<?=$arResult['PROP']['ORGANIZATION'][0];?>">
            <label>Название организации</label>
          </div>
        <?}?>
        </fieldset>
        <fieldset class="fieldgroup">
          <legend>
            Суть и текст обращения
          </legend>
        <div class="group">
          <textarea class="app_form_textarea" type="text" disabled><?=$arResult['PREVIEW_TEXT'];?></textarea>
          <label>Суть вопроса</label>
        </div>
        <div class="group">
          <textarea class="app_form_textarea" type="text" disabled><?=strip_tags($arResult['DETAIL_TEXT'], '<br />');?></textarea>
          <label>Тексть обращения</label>
        </div>
        </fieldset>
        <?if($arResult['PROP']['APPLICATION_FILES'][0]){?>
          <fieldset class="fieldgroup">
            <legend>
              Прикрепленные файлы обращения
            </legend>
            <?if(count($arResult['PROP']['APPLICATION_FILES'][0]) > 1){?>]
              <ul class="file_list">
              <?foreach($arResult['PROP']['APPLICATION_FILES'][0] as $fileId){
              $file = getFileArr($fileId);
              ?>
                <li class="file">
                  <a href="<?=$file['path']?>" target="_blank" rel="noopener noreferrer" download title="<?=$file['name']?>">
                  <?=$file['icon']?>
                  </a>
                </li>
              <?}?>
              </ul>
            <?}else{?>
              <ul class="file_list">
              <?$file = getFileArr($arResult['PROP']['APPLICATION_FILES'][0]);?>
                <li class="file">
                  <a href="<?=$file['path']?>" target="_blank" rel="noopener noreferrer" download title="<?=$file['name']?>">
                  <?=$file['icon']?>
                  </a>
                </li>
              </ul>
            <?}?>
          </fieldset>
        <?}?>
      </div>
    </div>
    <div class="col-12 col-xl-6">
      <div class="feed-detail-right">
        <div class="feed-detail-action">
          <ul class="tab_list feed-detail-action-list">
            <li class="tab_item feed-detail-action-item" data-tab="addcomment"><i class="fa fa-comment-o"></i></li>
            <li class="tab_item feed-detail-action-item" data-tab="addresponsible"><i class="fa fa-users"></i></li>
            <li class="tab_item feed-detail-action-item" data-tab="addanswer"><i class="fa fa-pencil-square-o"></i></li>
          </ul>
          <div class="tab_wrap feed-detail-action-content">
            <div class="tab_content" data-tab-content="addcomment">
              <fieldset class="fieldgroup">
                  <legend>Комментарий</legend>
                  <textarea class="comment_field"></textarea>
                  <button class="btn add">Добавить</button>
              </fieldset>
            </div>

            <div class="tab_content" data-tab-content="addresponsible">
              <fieldset class="fieldgroup">
                  <legend>Назначение ответственного</legend>
                  <div class="group">
                      <input id="" type="text" class="responsible_search"/>
                      <label>Ответственный</label>
                      <button class="btn responsible_add">Добавить</button>
                      <ul class="responsible_search_list"></ul>
                  </div>
              </fieldset>
            </div>

            <div class="tab_content" data-tab-content="addanswer">
              <fieldset class="fieldgroup">
                <legend>Комментарий</legend>
                <textarea class="comment_field"></textarea>
                <div class="uploader_files">
                    <input class="uploader_files_input" type="file" name="files[]" multiple id="answer_file_input">
                    <div class="uploader_files_content">
                        <div class="uploader_files_item"></div>
                        <ul class="uploader_files_list" id="uploadImagesList">
                            <li class="item">
                                <span class="img-wrap">
                                    <img src="" alt="">
                                </span>
                                <span class="icon-wrap">
                                    <i class="fa"></i>
                                </span>
                                <span class="delete-link" title="Удалить">
                                    <i class="fa fa-times"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="errormassege"></div>
                    <p class="app_form_comments">Не более 5 файлов, Допустимые форматы: jpeg,jpg,png,tif,gif,pdf,doc,docx,xls,xlsx,zip,rar Максимальный допустимый размер: 5МБ</p>
                </div>
                <button class="btn add">Добавить</button>
              </fieldset>
            </div>
          </div>
        </div>
        <ul class="timeline">
          <?getTimeline($arResult['ID']);?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?} // if(CModule::IncludeModule('iblock'))?>