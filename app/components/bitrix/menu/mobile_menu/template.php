<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) : ?>
	<div class="mmenu_btn">
		<div class="hamburger">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
	<div class="m_menu_wrap">
		<div class="m_menu">
			<div id="root-panel-menu">
				<ul class="menu">
					<?
					$previousLevel = 0;
					foreach ($arResult as $arItem) : ?>

						<? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) : ?>
							<?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
						<? endif ?>

						<? if ($arItem["IS_PARENT"]) : ?>

							<? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
								<li><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="<? if ($arItem["SELECTED"]) : ?>root-item-selected<? else : ?>root-item<? endif ?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
									<ul>
									<? else : ?>
										<li<? if ($arItem["SELECTED"]) : ?> class="item-selected" <? endif ?>><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="parent"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
											<ul>
											<? endif ?>

										<? else : ?>

											<? if ($arItem["PERMISSION"] > "D") : ?>

												<? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
													<li><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="<? if ($arItem["SELECTED"]) : ?>root-item-selected<? else : ?>root-item<? endif ?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
												<? else : ?>
													<li<? if ($arItem["SELECTED"]) : ?> class="item-selected" <? endif ?>><a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
								</li>
							<? endif ?>

						<? else : ?>

							<? if ($arItem["DEPTH_LEVEL"] == 1) : ?>
								<li><a href="" class="<? if ($arItem["SELECTED"]) : ?>root-item-selected<? else : ?>root-item<? endif ?>" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
							<? else : ?>
								<li><a href="" class="denied" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a></li>
							<? endif ?>

						<? endif ?>

					<? endif ?>

					<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

				<? endforeach ?>

				<? if ($previousLevel > 1) : //close last item tags
				?>
					<?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
				<? endif ?>

				</ul>
			</div>
			<? $APPLICATION->IncludeComponent(
				"bitrix:menu",
				"cheif_menu_mobile",
				array(
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"DELAY" => "N",
					"MAX_LEVEL" => "2",
					"MENU_CACHE_GET_VARS" => array(),
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "chief",
					"USE_EXT" => "Y",
					"COMPONENT_TEMPLATE" => "cheif_menu_mobile",
					"COMPOSITE_FRAME_MODE" => "A",
					"COMPOSITE_FRAME_TYPE" => "AUTO"
				),
				false
			); ?>

		</div>
	</div>
<? endif ?>