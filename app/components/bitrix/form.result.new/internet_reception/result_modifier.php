<?
CModule::IncludeModule('iblock');

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$arQuestion) {
    if ($FIELD_SID == "TITLE" && $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'text' && $arParams["IBLOCK_THEMES"] > 0) {

        $rsSections = CIBlockSection::GetTreeList(array("IBLOCK_ID" => $arParams["IBLOCK_THEMES"]));
        if ($rsSections->SelectedRowsCount() > 0) {
            $arQuestion["HTML_CODE"] = "<select class=\"styler input-block\"
                    name=\"form_" . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . "_" . $arQuestion['STRUCTURE'][0]['ID'] . "\"
                    id=\"form_" . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . "_" . $arQuestion['STRUCTURE'][0]['ID'] . "\">";

            $firstLevel = '';
            while ($theme = $rsSections->GetNext()) {
                if ($theme['DEPTH_LEVEL'] == 1) {
                    $firstLevel = $theme['NAME'];
                    $opValue    = $theme['NAME'];
                    $opValue    = $theme['NAME'];
                } else {
                    $opValue = $firstLevel . ': ' . $theme['NAME'];
                }

                $arQuestion["HTML_CODE"] .= "<option value=\"" . $opValue . "\">" . str_repeat(" &middot; &nbsp;", $theme['DEPTH_LEVEL'] - 1) . $theme['NAME'] . "</option>";
            }

            $arQuestion["HTML_CODE"] .= "</select>";
        }
        else {
            $arQuestion["HTML_CODE"] = preg_replace('#size="(\d+)"#i', "", $arQuestion["HTML_CODE"]);
            $arQuestion["HTML_CODE"] = preg_replace('#class="(.+)"#i', "class=\"input input-block \\1\"",
                $arQuestion["HTML_CODE"]);
        }
    }
    else {
        $arQuestion["HTML_CODE"] = preg_replace('#size="(\d+)"#i', "", $arQuestion["HTML_CODE"]);
        if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'file') {
            $arQuestion["HTML_CODE"] = preg_replace('#class="(.+)"#i', "class=\"styler input-block \\1\"",
                $arQuestion["HTML_CODE"]);
        } else {
            $arQuestion["HTML_CODE"] = preg_replace('#class="(.+)"#i', "class=\"input input-block \\1\"",
                $arQuestion["HTML_CODE"]);
        }

        if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'email') {
            $arQuestion["HTML_CODE"] = str_replace('value=""', 'value="' . $GLOBALS["USER"]->GetEmail() . '"',
                $arQuestion["HTML_CODE"]);
        }
    }
}
?>