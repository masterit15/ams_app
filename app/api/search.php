<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$result = array();
if (CModule::IncludeModule('search')){
  $obSearch = new CSearch;
  $searchQuery = $_REQUEST['search']; // фраза для поиска
  $iblockType = $_REQUEST['iblocktype']; // тип инфоблока.
  $iblockId = $_REQUEST['iblockid']; // ид инфоблока.
  $obSearch->SetOptions(array(//мы добавили еще этот параметр, чтобы не ругался на форматирование запроса
     'ERROR_ON_EMPTY_STEM' => false,
  ));
  if($iblockType){
    $searchArr = array('QUERY' => $searchQuery,'SITE_ID' => SITE_ID,'MODULE_ID'=> 'iblock','PARAM1'=> $iblockType);
  }elseif($iblockId){
    $searchArr = array('QUERY' => $searchQuery,'SITE_ID' => SITE_ID,'MODULE_ID'=> 'iblock','PARAM1'=> $iblockType,'PARAM2' => $iblockId);
  }elseif(!$iblockType && !$iblockId){
    $searchArr = array('QUERY' => $searchQuery,'SITE_ID' => SITE_ID);
  }
  $obSearch->Search($searchArr);
  if (!$obSearch->selectedRowsCount()) {//и делаем резапрос, если не найдено с морфологией...
     $obSearch->Search($searchArr, array(), array('STEMMING' => false));//... уже с отключенной морфологией
  }
  if ($obSearch->selectedRowsCount() === 0){
    echo '<div class="search_result_item" style="text-align: center;">';
        echo      '<h3>По вашему запросу ничего не найдено!</h3>';
    echo '</div>';
  }else{
    $obSearch->NavStart(20, false);
    while ($row = $obSearch->fetch()) { 
        $el = CIBlockElement::GetByID($row['ITEM_ID']);
        if($ar_res = $el->GetNext())
        
        
        echo '<div class="search_result_item">';
            echo      '<a href="'.$row['URL'].'"><h3>'.$row['TITLE'].'</h3></a>';
        echo '</div>';
    }
    $obSearch->NavPrint("", false, "", "/bitrix/templates/app/api/pagination.php");
  }
}
?>