<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("iblock");

if($_REQUEST['action'] == 'vote'){
  foreach($_REQUEST['elids'] as $id){
    $resElement = CIBlockElement::GetList([],['IBLOCK_ID' => 68,'ID' => $id,],false,false,
      [
          'ID',
          'PROPERTY_IP_ADDRESS',
          'PROPERTY_COUNT',
      ]
    );
    if($obj = $resElement->GetNext())
    $ips = explode(',', $obj['PROPERTY_IP_ADDRESS_VALUE']);
    $ipArr = walkArr($ips);
      $propField = array(
        'COUNT' => $obj['PROPERTY_COUNT_VALUE'] + 1,
      );
    if(!in_array($_REQUEST['ip_address'], $ipArr)){
      $propField['IP_ADDRESS'] = $obj['PROPERTY_IP_ADDRESS_VALUE'].','.$_REQUEST['ip_address'];
    }
    $result['fie'] = $propField;
    CIBlockElement::SetPropertyValuesEx(
      $id, 
      false, 
      $propField
    );
  }
  $result['title'] = 'Ваш голос принят!';
  $result['desc'] = 'Спасибо за участие в голосовании!';
  $result['success'] = true;
}
$result['res'] = $_REQUEST;
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($result);
?>