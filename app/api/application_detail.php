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
  $pictures = array('jpg', 'gif', 'jpeg', 'png');
  $res = CIBlockElement::GetByID($_GET["id"]);
  if($ar_res = $res->GetNext())
    $arResult = $ar_res;
  foreach(getProps($ar_res['ID']) as $prop){
    $arResult['PROP'][$prop['CODE']][] = $prop['VALUE'];
  }
  function printTimeline($id){
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array("CODE"=>"TIMELINE"));
      if($ar_props = $db_props->Fetch());
        $json = json_decode($ar_props['VALUE'], true);
        foreach($json as $timeline){
          echo '<li class="timeline_item" data-id="' . $timeline['id'] .'">';
          if($timeline['color']){
            echo '<span class="timeline_item_icon" style="color: #fff"><i class="fa ' .$timeline['icon']. '"></i></span>';
          }else{
            echo '<span class="timeline_item_icon" ><i class="fa ' .$timeline['icon']. '"></i></span>';
          }
            echo '<div class="timeline_item_wrap">';
              echo '<div class="timeline_item_content">';
              echo '<header class="timeline_item_header">';
                echo '<h3 class="timeline_item_title">' . $timeline['title']. '</h3>';
                echo '<span class="timeline_item_ava">' . $timeline['userName'] . '</span>';
              echo '</header>';
                echo '<div class="timeline_item_middle">';
                  echo '<p class="timeline_item_desc">' .$timeline['desc']. '</p>';
                  echo '<ul class="timeline_item_files file_list">';
                  foreach($timeline['files'] as $fileId){
                    $file = getFileArr($fileId);
                    echo '<li class="file">';
                      echo '<a href="'.$file['path'].'" target="_blank" rel="noopener noreferrer" download title="'.$file['name'].'">'.$file['icon'].'</a>';
                    echo '</li>';
                  }
                  echo '</ul>';
                echo '</div>';
                echo '<footer class="timeline_item_footer">';
                  echo '<span class="timeline_item_date">' .$timeline['datetime']. '</span>';
                echo '</footer>';
              echo '</div>';
            echo '</div>';
            echo '<hr>';
          echo '</li>';
        }
  }
  function getTimeline($id){
    $pictures = array('jpg', 'gif', 'jpeg', 'png');
    $db_props = CIBlockElement::GetProperty(102, $id, array("sort" => "asc"), Array("CODE"=>"TIMELINE"));
      if($ar_props = $db_props->Fetch());
        $json = json_decode($ar_props['VALUE'], true);
        foreach($json as $timeline){
          echo '<li class="timeline_item" data-id="' . $timeline['id'] .'" data-event="'.$timeline['event'].'" style="background-color: '.$timeline['color'].'">';
          if($timeline['color']){
            echo '<span class="timeline_item_icon" style="color: #fff"><i class="fa ' .$timeline['icon']. '"></i></span>';
          }else{
            echo '<span class="timeline_item_icon" ><i class="fa ' .$timeline['icon']. '"></i></span>';
          }
            echo '<div class="timeline_item_wrap">';
              echo '<div class="timeline_item_content" style="border-color: '.$timeline['color'].'">';
              echo '<header class="timeline_item_header">';
                echo '<h3 class="timeline_item_title">' . $timeline['title']. '</h3>';
                echo '<span class="timeline_item_ava">' . getAvatarText($timeline['userName']) . '</span>';
              echo '</header>';
                echo '<div class="timeline_item_middle">';
                  echo '<p class="timeline_item_desc">' .$timeline['desc']. '</p>';
                  echo '<ul class="timeline_item_files file_list">';
                  foreach($timeline['files'] as $fileId){
                    $file = getFileArr($fileId);
                    if(in_array($file['type'], $pictures)){
                      echo '<li class="file_item">';
                        echo '<a no-data-pjax class="file_item_link popup" href="' . $file['path'] . '" data-source="' . $file['path'] . '" title="'. $file['name'] .'">';
                          echo '<span class="file_item_link_icon"><img src="' . $file['path'] . '"></span>';
                          echo '<span class="file_item_link_name">'.$file['name'].'</span>';
                        echo '</a>';
                      echo '</li>';
                    }else{
                      echo '<li class="file_item">';
                        echo '<a no-data-pjax class="file_item_link" href="'.$file['path'].'" download title="'.$file['name'].'">';
                          echo '<span class="file_item_link_icon">'.$file['icon'].'</span>';
                          echo '<span class="file_item_link_name">'.$file['name'].'</span>';
                        echo '</a>';
                      echo '</li>';
                    }
                  }
                  echo '</ul>';
                echo '</div>';
                echo '<footer class="timeline_item_footer">';
                  echo '<span class="timeline_item_date">' .$timeline['datetime']. '</span>';
                  $events = array(
                    'add_application',
                    'add_status'
                  );
                  if(!in_array($timeline['event'] ,$events)){
                    echo '<button class="timeline_item_action_btn outsideclick"><i class="fa fa-ellipsis-v"></i></button>';
                    echo '<ul class="timeline_item_action outsideclick">';
                      echo '<li data-action="delete" data-id="' . $timeline['id'] .'">Удалить</li>';
                    echo '</ul>';
                  }
                echo '</footer>';
              echo '</div>';
            echo '</div>';
          echo '</li>';
        }
  }
  // PR($arResult);
?>
<div class="feed-detail" data-elid="<?=$arResult['ID']?>">
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
          Ответственный
        </legend>
        <div class="group">
          <input type="text" disabled value="<?=$arResult['PROP']['RESPONSIBLE_DEPARTAMENT'][0];?>">
          <label>Ответственный департамент</label>
        </div>
      </fieldset>
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
            <input type="text" disabled value="<?=str_replace('"', '', $arResult['PROP']['ORGANIZATION'][0])?>">
            <label>Название организации</label>
          </div>
        <?}?>
        </fieldset>
        <fieldset class="fieldgroup">
          <legend>
            Тема обращения
          </legend>
          <div class="group">
            <textarea class="app_form_textarea" rows="2" type="text" disabled><?=strip_tags($arResult['PREVIEW_TEXT']);?></textarea>
            <label>Суть вопроса</label>
          </div>
          <div class="group">
            <textarea class="app_form_textarea" rows="10" type="text" disabled><?=strip_tags($arResult['DETAIL_TEXT'], '<br />');?></textarea>
            <label>Тексть обращения</label>
          </div>
        </fieldset>
        <?if($arResult['PROP']['APPLICATION_FILES']){?>
          <fieldset class="fieldgroup">
            <legend>
              Прикрепленные файлы
            </legend>
            
            <?if(count($arResult['PROP']['APPLICATION_FILES']) > 1){?>
              <ul class="file_list">
              <?foreach($arResult['PROP']['APPLICATION_FILES'] as $fileId){
              $file = getFileArr($fileId);
              ?>
                <?if(in_array($file['type'], $pictures)){?>
                  <li class="file_item">
                    <a no-data-pjax class="file_item_link popup" href="<?=$file['path']?>" title="<?=$file['name']?>">
                      <span class="file_item_link_icon"><?=$file['icon']?></span>
                      <span class="file_item_link_name"><?=$file['name']?></span>
                    </a>
                  </li>
                <?}else{?>
                  <li class="file_item">
                    <a no-data-pjax class="file_item_link" href="<?=$file['path']?>" download title="<?=$file['name']?>">
                      <span class="file_item_link_icon"><?=$file['icon']?></span>
                      <span class="file_item_link_name"><?=$file['name']?></span>
                    </a>
                  </li>
                <?}?>
              <?}?>
              </ul>
            <?}else{?>
              <ul class="file_list">
              <?$file = getFileArr($arResult['PROP']['APPLICATION_FILES'][0]);?>
              <?if(in_array($file['type'], $pictures)){?>
                <li class="file_item">
                  <a no-data-pjax class="file_item_link popup" href="<?=$file['path']?>" title="<?=$file['name']?>">
                    <span class="file_item_link_icon"><?=$file['icon']?></span>
                    <span class="file_item_link_name"><?=$file['name']?></span>
                  </a>
                </li>
              <?}else{?>
                <li class="file_item">
                  <a no-data-pjax class="file_item_link" href="<?=$file['path']?>" download title="<?=$file['name']?>">
                    <span class="file_item_link_icon"><?=$file['icon']?></span>
                    <span class="file_item_link_name"><?=$file['name']?></span>
                  </a>
                </li>
              <?}?>
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
                  <button class="btn add_comment">Добавить</button>
              </fieldset>
            </div>

            <div class="tab_content" data-tab-content="addresponsible">
              <fieldset class="fieldgroup">
                  <legend>Назначение ответственного</legend>
                  <div class="group">
                      <input data-elid="0" type="text" class="responsible_search"/>
                      <label>Ответственный</label>
                      <button class="btn responsible_add">Добавить</button>
                      <ul class="responsible_search_list"></ul>
                  </div>
              </fieldset>
            </div>

            <div class="tab_content" data-tab-content="addanswer">
              <fieldset class="fieldgroup">
                <legend>Ответ на обращение</legend>
                <textarea class="answer_field"></textarea>
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
                <button class="btn add_answer">Добавить</button>
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