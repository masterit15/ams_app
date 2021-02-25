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
  $arOrder  = Array("ID" => $_REQUEST['sort']);
  $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_CREATE", "ACTIVE_FROM");
  $arFilter = Array(
    "IBLOCK_ID"=> IntVal($_REQUEST['iblock']),  
    "ACTIVE"=>"Y",
    "?NAME" => '%'.$_REQUEST["name"].'%',
    ">=DATE_ACTIVE_FROM" => $from,
    "<=DATE_ACTIVE_FROM" => $to,
    'INCLUDE_SUBSECTIONS'=>'Y',
  );
  if($_REQUEST["section"]) $arFilter["SECTION_ID"] = $_REQUEST["section"];
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
    if(count($filesId) > 1){?>
      <div class="folder">
				<div class="folder-summary js_toggle-folder">
					<div class="folder-summary__start">
						<div class="folder-summary__file-count">
								<span class="folder-summary__file-count__amount"><?=count($filesId)?></span>
								<i class="fa fa-folder"></i>
								<i class="fa fa-folder-open"></i>
						</div>
					</div>
					<div class="folder-summary__details">
						<div class="folder-summary__details__name">
							<?=$doc['NAME']?>
						</div>
						<div class="folder-summary__details__share">
              <?echo $doc['ACTIVE_FROM'] ? $doc['ACTIVE_FROM'] : $doc['DATE_CREATE'];?>
						</div>
					</div>
					<div class="folder-summary__end">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							<path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" /></svg>
					</div>
				</div>	
				<ul class="folder-content">
          <?foreach ($filesId as $arProperty){
          $file = getFileArr($arProperty);
          ?>
            <li class="folder-item js_folder-item">
              <a class="folder-item-wrap" href="<?=$file['path']?>" <?if ($file['type'] != 'pdf') {?>download<?}?>>
                <div class="folder-item__icon"><?=$file['icon'];?></div>
                <div class="folder-item__details">
                  <div class="folder-item__details__name">
                    <?=$file['desc'] ? $file['desc'] : $file['name'];?>
                  </div>
                  <!-- <div class="folder-item__details__date"><?//=$file['date'];?></div> -->
                </div>
                <div class="folder-item__size"><?=$file['size'];?></div>
              </a>
            </li>
          <?}?>
          <?if(count($filesId) > 1){?>
            <li class="folder-item js_folder-item download_zip">
              <a class="folder-item-wrap" href="">
                <div class="folder-item__icon"><i class="fa fa-file-archive-o" style="color:#f3aa16"></i></div>
                <div class="folder-item__details">
                  <div class="folder-item__details__name">
                    Скачать все файлы одним архивом
                  </div>
                </div>
                <div class="folder-item__size"><i class="fa fa-download"></i></div>
              </a>
            </li>
          <?}?>
				</ul>
		</div>
    <?}else{
      $file = getFileArr($filesId[0]);
      ?>
      <div class="doc_item item" title='<?=$doc['NAME']?>'>
        <a href="<?=$file['src']?>" <?if($file['type'] != 'pdf'){?>download<?}?>>					
          <span class="doc_icon">
            <?=$file['icon']?>
          </span>				
          <div class="doc_detail">			
            <div class="doc_title">
              <?echo $doc['NAME'] ? $doc['NAME'] : $file['name'];?>
            </div>
            <span class="doc_date">
              <?echo $doc['ACTIVE_FROM'] ? $doc['ACTIVE_FROM'] : $doc['DATE_CREATE'];?>
            </span>
          </div>
          <span class="doc_size"><?=$file['size']?></span>
        </a>
      </div>
<?
    } // if(count($filesId) > 1)
  } // foreach($res->arResult as $doc)
} // if(!$res->arResult) }else{
		$res->NavPrint("", false, "", "/bitrix/templates/app/api/pagination.php");
  }
  
?>