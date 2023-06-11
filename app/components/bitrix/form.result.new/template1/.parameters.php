<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (class_exists('Bitrix\Main\UserConsent\Agreement')) {
    $arTemplateParameters = array(
        "USER_CONSENT" => array(),
    );
}