<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if(CModule::IncludeModule('iblock')){?>
<div class="services_detail">
    <?
    $arOrder = array("SORT"=>"ASC");
    $arFilter = array('IBLOCK_ID'=> 51, 'ACTIVE'=> 'Y', 'ID'=> $_REQUEST['id']);
    $arSelect = array(
      // 'NAME', 
      // 'DETAIL_TEXT',
      // 'ACTIVE_FROM', 
      // 'PROPERTY_file_01', 
      // 'PROPERTY_file_02',
      // 'PROPERTY_file_03',
      // 'PROPERTY_file_04',
      // 'PROPERTY_file_05',
      // 'PROPERTY_file_06',
      // 'PROPERTY_file_07',
      // 'PROPERTY_file_08',
      // 'PROPERTY_file_09',
      // 'PROPERTY_file_010',
      // 'PROPERTY_rmu_status',
      // 'PROPERTY_rmu_inform',
      // 'PROPERTY_rmu_ispolnitel',
    );
    $res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
    if($ar_res = $res->GetNext())
    //PR($ar_res);
    ?>
			<ul class="tabs">
					<li class="active">Общие сведения</li>
					<li>Регламент</li>
				</ul>
				<ul class="tab__content">
					<li class="active">
						<div class="content__wrapper">
              <?PR($ar_res)?>
						  <?=$ar_res['DETAIL_TEXT']?>
						</div>
					</li>
					<li>
						<div class="content__wrapper">
            <p><b>Исполнитель:</b> <?=$ar_res['PROPERTY_RMU_ISPOLNITEL_VALUE'];?></p>
            <p><b>Cтатус:</b>  <?=$ar_res['PROPERTY_RMU_STATUS_VALUE'];?></p>
            <p><b>Дата размещения на сайте:</b></p>
            <p><b>Срок проведения независимой экпертизы:</b></p>
						<?
              while ($fruit_name = current($ar_res)) {
                if(stripos(key($ar_res), '~') !== 0 and !stripos(key($ar_res), '_ID')){
                  if(stripos(key($ar_res), '_FILE_0')){
                    $fileOb = CFile::GetByID($ar_res[key($ar_res)]);
                    $fileArr = $fileOb->Fetch();
                    $file['name'] = $fileArr['DESCRIPTION'] ? $fileArr['DESCRIPTION']: 'Скачать';
                    $file['type'] = explode('.', $fileArr['FILE_NAME'])[1];
                    $file['path'] = CFile::GetPath($fileArr["ID"]);
                    $file['size'] = CFile::FormatSize($fileArr['FILE_SIZE']);
                    echo '<a href="'.$file['path'].'">'.$file['name'].' ('.$file['size'].')</a><br>'; //key($ar_res).'file<br />';
                  }  
                }
                  next($ar_res);
              }
            ?>
						</div>
					</li>
				</ul>
    
  </div>
<?}?>