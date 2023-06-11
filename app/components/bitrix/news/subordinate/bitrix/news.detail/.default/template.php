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
//$this->addExternalJS('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
// PR($arResult['PROPERTIES']);
?>
<div class="row">
	<? if ($arResult['PROPERTIES']['address']['VALUE']) { ?>
		<div class="col-12 col-xl-6 np">
		<? } ?>
		<div <? if ($arResult['PROPERTIES']['address']['VALUE']) { ?>class="news-map" <? } else { ?>class="news-detail" <? } ?>>
			<? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])) : ?>
				<img class="detail_picture" src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" width="<?= $arResult["DETAIL_PICTURE"]["WIDTH"] ?>" height="<?= $arResult["DETAIL_PICTURE"]["HEIGHT"] ?>" alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>" title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>" />
			<? endif ?>
			<? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]) : ?>
				<span class="news-date-time"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
			<? endif; ?>
			<? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]) : ?>
				<h3><?= $arResult["NAME"] ?></h3>
			<? endif; ?>
			<h4 style="margin: 15px 0;">Руководитель: <?= $arResult['PROPERTIES']['manager']['VALUE'] ?></h4>
			<? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arResult["FIELDS"]["PREVIEW_TEXT"]) : ?>
				<p><?= $arResult["FIELDS"]["PREVIEW_TEXT"];
						unset($arResult["FIELDS"]["PREVIEW_TEXT"]); ?></p>
			<? endif; ?>
			<? if ($arResult["NAV_RESULT"]) : ?>
				<? if ($arParams["DISPLAY_TOP_PAGER"]) : ?><?= $arResult["NAV_STRING"] ?><br /><? endif; ?>
			<? echo $arResult["NAV_TEXT"]; ?>
			<? if ($arParams["DISPLAY_BOTTOM_PAGER"]) : ?><br /><?= $arResult["NAV_STRING"] ?><? endif; ?>
			<? elseif (strlen($arResult["DETAIL_TEXT"]) > 0) : ?>
				<? echo $arResult["DETAIL_TEXT"]; ?>
			<? else : ?>
				<? echo $arResult["PREVIEW_TEXT"]; ?>
			<? endif ?>
			<? if ($arResult['PROPERTIES']['phone']['VALUE']) { ?>
				<div class="contact tel">
					<h4>Тел:</h4>
					<? foreach ($arResult['PROPERTIES']['phone']['VALUE'] as $phone) { ?>
						<a href="tel:<?= $phone ?>"><?= $phone ?></a>
					<? } ?>
				</div>
			<? } ?>
			<? if ($arResult['PROPERTIES']['email']['VALUE']) { ?>
				<div class="contact">
					<h4>Е-почта:</h4>
					<? foreach ($arResult['PROPERTIES']['email']['VALUE'] as $email) { ?>
						<a href="mailto:<?= $email ?>"><?= $email ?></a>
					<? } ?>
				</div>
			<? } ?>
			<? if ($arResult['PROPERTIES']['site']['VALUE']) { ?>
				<div class="contact">
					<h4>Сайт:</h4>
					<a href="<?= $arResult['PROPERTIES']['site']['VALUE'] ?>"><?= $arResult['PROPERTIES']['site']['VALUE'] ?></a>
				</div>
			<? } ?>
			<? if ($arResult['PROPERTIES']['APPLICATION_FILE']['VALUE']) { ?>
				<div class="subord_documents">
					<?foreach($arResult['PROPERTIES']["APPLICATION_FILE"]['VALUE'] as $key => $doc){?>
							<? $file = getFileArr($doc); ?>
							<div class="doc_item item" title='<? echo $arResult['NAME'] ? $arResult['NAME'] : $file['name']; ?>'>
								<a href="<?= $file['path'] ?>" <? if ($file['type'] != 'pdf') { ?>download<? } ?>>
									<span class="doc_icon">
										<?= $file['icon'] ?>
									</span>
									<div class="doc_detail">
										<div class="doc_title">
											<? echo $arResult['PROPERTIES']["APPLICATION_FILE"]['DESCRIPTION'][$key] ? $arResult['PROPERTIES']["APPLICATION_FILE"]['DESCRIPTION'][$key] : $file['name']; ?>
										</div>
										<span class="doc_date">
											<?= $file['date']; ?>
										</span>
									</div>
									<span class="doc_size"><?= $file['size'] ?></span>
								</a>
							</div>
					<?}?>
				</div>
			<?}?>
			<? if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y") {
			?>
				<div class="news-detail-share">
					<noindex>
						<?
						$APPLICATION->IncludeComponent(
							"bitrix:main.share",
							"",
							array(
								"HANDLERS" => $arParams["SHARE_HANDLERS"],
								"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
								"PAGE_TITLE" => $arResult["~NAME"],
								"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
								"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
								"HIDE" => $arParams["SHARE_HIDE"],
							),
							$component,
							array("HIDE_ICONS" => "Y")
						);
						?>
					</noindex>
				</div>
			<?
			}
			?>
		</div>
		<? if ($arResult['PROPERTIES']['address']['VALUE']) { ?>
		</div>
	<? } ?>
	<? if ($arResult['PROPERTIES']['address']['VALUE']) { ?>
		<div class="interception-data" data-index="<?= $index ?>" data-interception="<?= $arResult['PROPERTIES']['interception']['VALUE'] ?>" data-address="<?= $arResult['PROPERTIES']['address']['VALUE'] ?>" data-ot-address="<?= $arResult['PROPERTIES']['ot_interception']['VALUE'] ?>" data-do-address="<?= $arResult['PROPERTIES']['do_interception']['VALUE'] ?>" data-img="<?= $GLOBALS['OBJECT_IMG_SRC']; ?>">
		</div>
		<div class="col-12 col-xl-6 np">
			<div id="map"></div>
		</div>
	<? } ?>
</div>