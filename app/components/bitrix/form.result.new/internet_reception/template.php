<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
CJSCore::Init(array("jquery"));?>

<? if ($arResult["isFormErrors"] == "Y") { ?>
    <div class="alert alert-error mb20"><?= $arResult["FORM_ERRORS_TEXT"]; ?></div>
<? } ?>

<? if ($arResult["isFormNote"] === "Y") { ?>
    <div class="alert alert-success mb20"><?= GetMessage('FORM_RESULT_OK') ?></div>
<? } ?>

<? if ($arResult["isFormDescription"] == "Y") { ?>
    <div class="alert alert-success mb20"><?= $arResult["FORM_DESCRIPTION"] ?></div>
<? } ?>

<? if ($arResult["isFormNote"] != "Y") {
    ?>
    <?= $arResult["FORM_HEADER"] ?>
        <?
        $haveEmail = false;
        foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
            if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
                echo $arQuestion["HTML_CODE"];
            } else {
                if ($arQuestion["REQUIRED"] == "Y") {
                    if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'dropdown') {
                        $check_fields_names[] = $arQuestion["CAPTION"];
                        $check_fields[]       = 'form_dropdown_' . $FIELD_SID;
                    } else {
                        $check_fields_names[] = $arQuestion["CAPTION"];
                        $check_fields[]       = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                    }
                }
                if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'email') {
                    $check_email_fields_names[] = $arQuestion["CAPTION"];
                    $check_email_fields[]       = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                } elseif (strpos($FIELD_SID, "phone") !== false) {
                    $check_phone_fields_names[] = $arQuestion["CAPTION"];
                    $check_phone_fields[]       = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                }
                ?>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?echo $arQuestion["CAPTION"] ?><? if ($arQuestion["REQUIRED"] == "Y") { ?><span
                            class="required">*</span><? } ?>:
                    </div>
                    <div class="col col-mb-12 col-7">
                        <?echo $arQuestion["HTML_CODE"]; ?>
                    </div>
                </div>
                <?
            }
        }
        ?>

		<?
if($arResult["isUseCaptcha"] == "Y")
{
?>

<b><//?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b>






<div class="content form-control">
    <div class="col col-mb-12 col-5 form-label">
        <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
    </div>
    <div class="col col-mb-12 col-7">
        <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
		<input class="input input-block inputtext" type="text" name="captcha_word" size="30" maxlength="50" value=""/>
    </div>
</div>
<?
} // isUseCaptcha
?>

        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
            </div>
            <div class="col col-mb-12 col-7">
                <button class="btn" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"];?>"><?=strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"];?></button>
            </div>
        </div>
    <?= $arResult["FORM_FOOTER"] ?>


    <script type="text/javascript">

        function TrimString(sInString) {
            sInString = sInString.replace(/ /g, ' ');
            return sInString.replace(/(^\s+)|(\s+$)/g, "");
        }

        function checkForm() {
            var rez = "",
                reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/,
                reg2 = /^([0-9\-\(\)\+ ])+$/;
            
            <?
            if ($check_fields) {
                foreach ($check_fields as $k=>$cfld) {
                echo "            if (TrimString($('[name=\"" . $cfld . "\"]').val()) == \"\") rez = rez + \"" . GetMessage('FORM_FIELD_EMPTY') . " '" . $check_fields_names[$k] . "'\\r\\n\";\n";
                }
            }
    
            if ($check_email_fields) {
                foreach ($check_email_fields as $k=>$cfld) {
                    echo "            if (reg.test(TrimString($('[name=\"" . $cfld . "\"]').val())) == false) rez = rez + \"" . GetMessage('FORM_WRONG_EMAIL') . " '" . $check_email_fields_names[$k] . "'\\r\\n\";\n";
                }
            }

            if ($check_phone_fields) {
                foreach ($check_phone_fields as $k => $cfld) {
                    echo "            if (TrimString($('[name=\"" . $cfld . "\"]').val())) {\n";
                    echo "                if (reg2.test(TrimString($('[name=\"" . $cfld . "\"]').val())) == false) rez = rez + \"" . GetMessage('FORM_WRONG_PHONE') . " '" . $check_phone_fields_names[$k] . "'\\r\\n\";\n";
                    echo "            }\n";
                }
            }
            ?>

            return rez;
        }

        $(document).ready(function(){
            $('form[name="<?echo $arResult["arForm"]["VARNAME"]?>"]').submit(function(e){
                var checkResult = checkForm();
                if (checkResult != '') {
                    e.preventDefault();
                    alert(checkResult);
                }
            });
        });
    </script>

    <?
}
?>