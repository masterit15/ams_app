<?
include $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
if (CModule::IncludeModule('iblock')) {
?>

<form method="POST" action="<?=SITE_TEMPLATE_PATH;?>/api/feedback.php" class="app_form" enctype="multipart/form-data">
    <input id="token" type="hidden" name="token">	
    <div class="close"><i class="fa fa-times"></i></div>
    <div class="container">
        <div class="row">
            <fieldset class="form_tab col-12" data-event-num="1">
                <span class="form_tab_event">1</span>
                <div class="row">
                    <div class="col-12">
                    <legend class="app_form_title"><b>Получатель обращения</b></legend>
                    <select class="select2" name="departament" id="app_form_departament">
                        <option value="#">Выберите получателя*</option>
                        <?
                        $arFilter = Array('IBLOCK_ID'=>95, 'GLOBAL_ACTIVE'=>'Y', '!=UF_WORKER' => 0);
                        $arSelect=array('ID','NAME','UF_WORKER');
                        $db_list = CIBlockSection::GetList(Array("left_margin"=>'asc', 'sort'=> 'asc'), $arFilter, true, $arSelect);
                        while($ar_result = $db_list->GetNext()){?>
                        <option value="<?=$ar_result['ID'];?>"><?=$ar_result['NAME'];?></option>
                        <?}?>
                    </select>

                    <!-- <label class="checkbox" for="need_person">
                        <input type="checkbox" name="needPerson" id="need_person">
                        <span>Обращение должностному лицу</span>
                    </label>

                    <select id="person" class="select2" name="person">
                        <option value="#">Выберите должностное лицо</option>
                    </select> -->
                    </div>
                </div>
            </fieldset>
            <fieldset class="form_tab col-12" data-event-num="2">
                <span class="form_tab_event">2</span>
                <div class="row">
                    <div class="col-12">
                        <legend class="app_form_title"><b>Сведения об отправителе</b></legend>
                        <p class="app_form_comments"></p>
                    </div>
                    <div class="col-xl-12">
                        <label for="app_form_persondata_juristic" class="checkbox" style="width: 0%;margin-right: 15px;">
                        <input type="checkbox" data-input="juristic" name="app_form_persondata" id="app_form_persondata_juristic" placeholder="Обращение от юридического лица" autocomplete="off" value="18">
                        <span>Обращение от юридического лица</span>
                        </label>
                        <div class="group" id="orgname">
                            <input required data-input="orgname" type="text" name="orgname" id="app_form_persondata_orgname" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="suggestions-input">
                            <label>Название организации*</label>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="group">
                            <input required data-input="firstName" type="text" name="first_name" id="app_form_persondata_firstname" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="suggestions-input" style="box-sizing: border-box;"><div class="suggestions-wrapper"><div class="suggestions-suggestions" style="display: none;"></div></div>
                            <label>Фамилия*</label>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="group">
                            <input required data-input="name" type="text" name="name" id="app_form_persondata_name" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="suggestions-input" style="box-sizing: border-box;"><div class="suggestions-wrapper"><div class="suggestions-suggestions" style="display: none;"></div></div>
                            <label>Имя*</label>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="group">
                            <input type="text" data-input="lastName" name="last_name" id="app_form_persondata_lastname" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="suggestions-input" style="box-sizing: border-box;"><div class="suggestions-wrapper"><div class="suggestions-suggestions" style="display: none;"></div></div>
                            <label>Отчество</label>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="group">
                            <input required data-input="phone" type="text" name="phone" id="app_form_persondata_phone" autocomplete="off" maxlength="18">
                            <label>Контактный телефон*</label>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="group">
                            <input required data-input="email" type="email" name="email" id="app_form_persondata_email" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="suggestions-input" style="box-sizing: border-box;"><div class="suggestions-wrapper"><div class="suggestions-suggestions" style="display: none;"></div></div>
                            <label>Е-почта*</label>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="group">
                            <input required  data-input="address" type="text" name="address" id="app_form_persondata_address" autocomplete="off">
                            <label>Адрес*</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="form_tab" data-event-num="3">
                <span class="form_tab_event">3</span>
                <div class="col-xl-12">	
                    <legend class="app_form_title"><b>Содержание обращения</b></legend>
                    <div class="group">
                        <textarea data-textarea="description" class="app_form_textarea" data-count="100" data-text="Тема обращеня (не более 100 символов)" rows="2" name="description" autocomplete="off" required></textarea>
                        <label>Тема обращеня (не более 100 символов)*</label>
                    </div>
                    <div class="group">
                        <textarea data-textarea="descriptionDetail" class="app_form_textarea" data-count="2000" data-text="Содержание обращения (не более 2000 символов)" rows="10" name="description_detail" autocomplete="off" required></textarea>
                        <label>Содержание обращения (не более 2000 символов)*</label>
                    </div>
                    <div class="uploader_files">
                        <input class="uploader_files_input" type="file" name="files[]" multiple id="js-photo-upload">
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
                </div>
            </fieldset>
            <fieldset class="form_tab col-xl-12" data-event-num="4">
                <span class="form_tab_event">4</span>
                <div class="row">
                    <div class="col-12">
                        <legend class="app_form_title"><b>Пользовательское соглашение</b></legend>
                        <p class="app_form_comments"></p>
                    </div>
                    <div class="col-12">
                        <label for="app_form_consent" class="checkbox">
                            <p class="app_form_comments"></p>
                            <input type="checkbox" name="userconsent" id="app_form_consent" placeholder="Я принимаю условия" autocomplete="off" value="36" required checked>
                            <span>Нажимая кнопку "Отправить", я принимаю <a href="/legal/" target="_blank" rel="noopener noreferrer">условия пользовательского соглашения.</a></span>
                        </label>
                    </div>
                </div>
            </fieldset>
            <div class="form_submit col-12">
                <div id="clock"></div>
                <div class="submit_disabled">
                    <button type="button" class="btn btn_submit_disabled ">Отправить <i class="fa fa-paper-plane-o"></i></button>
                </div>
                <button type="submit" class="btn btn_submit" disabled="">
                    Отправить <i class="fa fa-paper-plane-o"></i>
                </button>
            </div>
        </div>
    </div>
</form>
<?}?>