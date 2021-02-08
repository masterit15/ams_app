<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
if (!empty($arResult["ERROR_MESSAGE"])) :
	?>
	<div class="vote-note-box vote-note-error">
		<div class="vote-note-box-text"><?= ShowError($arResult["ERROR_MESSAGE"]) ?></div>
	</div>
<?
endif;

if (!empty($arResult["OK_MESSAGE"])) :
	?>
	<div class="vote-note-box vote-note-note">
		<div class="vote-note-box-text"><?= ShowNote($arResult["OK_MESSAGE"]) ?></div>
	</div>
<?
endif;

if (empty($arResult["VOTE"])) :
	return false;
elseif (empty($arResult["QUESTIONS"])) :
	return true;
endif;

?>
<div class="container">
	<div class="voting-form-box">
		<? //PR($arResult['VOTE']['IMAGE']['SRC']);
		?>

		<h3><?= $arResult['VOTE']["TITLE"] ?></h3>
		<div class="img">
			<img class="v_img" src="https://dobromed15.ru/<?= $arResult['VOTE']['IMAGE']['SRC'] ?>" alt="">
		</div>
		<div class="desc" style="margin-bottom: 30px;"><?= $arResult['VOTE']['DESCRIPTION']; ?></div>
		<span style="float: left;font-weight:bold; margin: 20px 0;"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $arResult['VOTE']['DATE_START']; ?></span>
		<form action="<?= POST_FORM_ACTION_URI ?>" method="post" class="vote-form">
			<input type="hidden" name="vote" value="Y">
			<input type="hidden" name="PUBLIC_VOTE_ID" value="<?= $arResult["VOTE"]["ID"] ?>">
			<input type="hidden" name="VOTE_ID" value="<?= $arResult["VOTE"]["ID"] ?>">
			<?= bitrix_sessid_post() ?>



			<div class="tabs">
				<!--  Контейнер с вкладками   -->
				<ul class="tab-header">
					<? $i = 1;
					foreach ($arResult["QUESTIONS"] as $arQuestion) {
						?>
						<li class="tab-header__item js-tab-trigger" data-tab="<?= $i ?>"><?= $i ?></li>
					<? $i++;
					} ?>
					<!-- <li class="tab-header__item js-tab-trigger active" data-tab="1">Первая</li>
					<li class="tab-header__item js-tab-trigger" data-tab="2">Вторая</li>
					<li class="tab-header__item js-tab-trigger" data-tab="3">Третья</li> -->
				</ul>

				<ol class="tab-content vote-items-list vote-question-list">
					<?
					$iCount = 0;
					$i = 1;
					foreach ($arResult["QUESTIONS"] as $arQuestion) :
						$iCount++;
						?>
						<li data-tab="<?= $i; ?>" class="tab-content__item js-tab-content vote-item-vote <?= ($iCount == 1 ? "vote-item-vote-first " : "") ?><?
																																																																										?><?= ($iCount == count($arResult["QUESTIONS"]) ? "vote-item-vote-last " : "") ?><?
																																																																																																																				?><?= ($iCount % 2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ") ?><?
																																																																																																																																																											?>">

							<div class="vote-item-header">

								<?
									if ($arQuestion["IMAGE"] !== false) :
										?>
									<div class="vote-item-image"><img class="v_img" src="https://dobromed15.ru/<?= $arQuestion["IMAGE"]["SRC"] ?>" width="30" height="30" /></div>
								<?
									endif;
									?>
								<div class="vote-item-title vote-item-question"><?= $arQuestion["QUESTION"] ?><? if ($arQuestion["REQUIRED"] == "Y") {
																																																	echo "<span class='starrequired'>*</span>";
																																																} ?></div>
								<div class="vote-clear-float"></div>
							</div>

							<ol class="vote-items-list vote-answers-list">
								<?
									$iCountAnswers = 0;
									foreach ($arQuestion["ANSWERS"] as $arAnswer) :
										$iCountAnswers++;
										?>
									<li class="vote-item-vote <?= ($iCountAnswers == 1 ? "vote-item-vote-first " : "") ?><?
																																																						?><?= ($iCountAnswers == count($arQuestion["ANSWERS"]) ? "vote-item-vote-last " : "") ?><?
																																																																																																				?><?= ($iCountAnswers % 2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ") ?>">
										<?
												switch ($arAnswer["FIELD_TYPE"]):
													case 0: //radio
														$value = (isset($_REQUEST['vote_radio_' . $arAnswer["QUESTION_ID"]]) &&
															$_REQUEST['vote_radio_' . $arAnswer["QUESTION_ID"]] == $arAnswer["ID"]) ? 'checked="checked"' : '';
														break;
													case 1: //checkbox
														$value = (isset($_REQUEST['vote_checkbox_' . $arAnswer["QUESTION_ID"]]) &&
															array_search($arAnswer["ID"], $_REQUEST['vote_checkbox_' . $arAnswer["QUESTION_ID"]]) !== false) ? 'checked="checked"' : '';
														break;
													case 2: //select
														$value = (isset($_REQUEST['vote_dropdown_' . $arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_dropdown_' . $arAnswer["QUESTION_ID"]] : false;
														break;
													case 3: //multiselect
														$value = (isset($_REQUEST['vote_multiselect_' . $arAnswer["QUESTION_ID"]])) ? $_REQUEST['vote_multiselect_' . $arAnswer["QUESTION_ID"]] : array();
														break;
													case 4: //text field
														$value = isset($_REQUEST['vote_field_' . $arAnswer["ID"]]) ? htmlspecialcharsbx($_REQUEST['vote_field_' . $arAnswer["ID"]]) : '';
														break;
													case 5: //memo
														$value = isset($_REQUEST['vote_memo_' . $arAnswer["ID"]]) ?  htmlspecialcharsbx($_REQUEST['vote_memo_' . $arAnswer["ID"]]) : '';
														break;
												endswitch;
												?>
											<?
													switch ($arAnswer["FIELD_TYPE"]):
														case 0: //radio
															?>
													<span class="vote-answer-item vote-answer-item-radio">
														<input type="radio" <?= $value ?> name="vote_radio_<?= $arAnswer["QUESTION_ID"] ?>" <?
																																																											?>id="vote_radio_<?= $arAnswer["QUESTION_ID"] ?>_<?= $arAnswer["ID"] ?>" <?
																																																																																																			?>value="<?= $arAnswer["ID"] ?>" <?= $arAnswer["~FIELD_PARAM"] ?> />
														<label for="vote_radio_<?= $arAnswer["QUESTION_ID"] ?>_<?= $arAnswer["ID"] ?>"><?= $arAnswer["MESSAGE"] ?></label>
													</span>
												<?
															break;
														case 1: //checkbox
															?>
													<span class="vote-answer-item vote-answer-item-checkbox">
														<input <?= $value ?> type="checkbox" name="vote_checkbox_<?= $arAnswer["QUESTION_ID"] ?>[]" value="<?= $arAnswer["ID"] ?>" <?
																																																																															?> id="vote_checkbox_<?= $arAnswer["QUESTION_ID"] ?>_<?= $arAnswer["ID"] ?>" <?= $arAnswer["~FIELD_PARAM"] ?> />
														<label for="vote_checkbox_<?= $arAnswer["QUESTION_ID"] ?>_<?= $arAnswer["ID"] ?>"><?= $arAnswer["MESSAGE"] ?></label>
													</span>
													<? break ?>

												<?
														case 2: //dropdown
															?>
													<span class="vote-answer-item vote-answer-item-dropdown">
														<select name="vote_dropdown_<?= $arAnswer["QUESTION_ID"] ?>" <?= $arAnswer["~FIELD_PARAM"] ?>>
															<? foreach ($arAnswer["DROPDOWN"] as $arDropDown) : ?>
																<option value="<?= $arDropDown["ID"] ?>" <?= ($arDropDown["ID"] === $value) ? 'selected="selected"' : '' ?>><?= $arDropDown["MESSAGE"] ?></option>
															<? endforeach ?>
														</select>
													</span>
													<? break ?>

												<?
														case 3: //multiselect
															?>
													<span class="vote-answer-item vote-answer-item-multiselect">
														<select name="vote_multiselect_<?= $arAnswer["QUESTION_ID"] ?>[]" <?= $arAnswer["~FIELD_PARAM"] ?> multiple="multiple">
															<? foreach ($arAnswer["MULTISELECT"] as $arMultiSelect) : ?>
																<option value="<?= $arMultiSelect["ID"] ?>" <?= (array_search($arMultiSelect["ID"], $value) !== false) ? 'selected="selected"' : '' ?>><?= $arMultiSelect["MESSAGE"] ?></option>
															<? endforeach ?>
														</select>
													</span>
													<? break ?>

												<?
														case 4: //text field
															?>
													<span class="vote-answer-item vote-answer-item-textfield">
														<label for="vote_field_<?= $arAnswer["ID"] ?>"><?= $arAnswer["MESSAGE"] ?></label>
														<input type="text" name="vote_field_<?= $arAnswer["ID"] ?>" id="vote_field_<?= $arAnswer["ID"] ?>" <?
																																																																			?>value="<?= $value ?>" size="<?= $arAnswer["FIELD_WIDTH"] ?>" <?= $arAnswer["~FIELD_PARAM"] ?> /></span>
													<? break ?>

												<?
														case 5: //memo
															?>
													<span class="vote-answer-item vote-answer-item-memo">
														<label for="vote_memo_<?= $arAnswer["ID"] ?>"><?= $arAnswer["MESSAGE"] ?></label><br />
														<textarea name="vote_memo_<?= $arAnswer["ID"] ?>" id="vote_memo_<?= $arAnswer["ID"] ?>" <?
																																																													?><?= $arAnswer["~FIELD_PARAM"] ?> cols="<?= $arAnswer["FIELD_WIDTH"] ?>" <?
																																																																																																					?>rows="<?= $arAnswer["FIELD_HEIGHT"] ?>"><?= $value ?></textarea>
													</span>
												<? break;
													endswitch;
													?>
									</li>
								<?
									endforeach
									?>
							</ol>
						</li>
					<?
						$i++;
					endforeach
					?>
				</ol>
			</div>
			<div class="row">
				<div class="col-12 col-xl-3">
					<span class="btn js-tab-prev" style="background-color: #00c2ff">
						< Предыдущий вопрос</span> </div> <div class="col-12 col-xl-3 offset-xl-6">
							<span class="btn js-tab-next" style="background-color: #00c2ff">Следующий вопрос ></span>
				</div>
			</div>
			<? if (isset($arResult["CAPTCHA_CODE"])) :  ?>
				<div class="vote-item-header">
					<div class="vote-item-title vote-item-question"><?= GetMessage("F_CAPTCHA_TITLE") ?></div>
					<div class="vote-clear-float"></div>
				</div>
				<div class="vote-form-captcha">
					<input type="hidden" name="captcha_code" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
					<div class="vote-reply-field-captcha-image">
						<img src="/bitrix/tools/captcha.php?captcha_code=<?= $arResult["CAPTCHA_CODE"] ?>" alt="<?= GetMessage("F_CAPTCHA_TITLE") ?>" />
					</div>
					<div class="vote-reply-field-captcha-label">
						<label for="captcha_word"><?= GetMessage("F_CAPTCHA_PROMT") ?><span class='starrequired'>*</span></label><br />
						<input type="text" size="20" name="captcha_word" />
					</div>
				</div>
			<? endif // CAPTCHA_CODE 
			?>

			<div class="vote-form-box-buttons vote-vote-footer">
				<input class="btn" type="submit" name="vote" value="<?= GetMessage("VOTE_SUBMIT_BUTTON") ?>" style="float:left;margin-right:20px;" />
				<?/*?>	<span class="vote-form-box-button vote-form-box-button-last"><input type="reset" value="<?=GetMessage("VOTE_RESET")?>" /></span><?*/ ?>
				<a class="btn vote_result" name="show_result" href="<?= $arResult["URL"]["RESULT"] ?>"><?= GetMessage("VOTE_RESULTS") ?></a>
				<? if (CUser::IsAuthorized() and $USER->IsAdmin()) { ?>
					<span class="get_vote_widget">Получить код виджета голосования</span>
				<? } ?>
			</div>
		</form>
	</div>
	<? if (CUser::IsAuthorized() and $USER->IsAdmin()) { ?>
		<div class="vote-widget">
			<h3>Код для встраивания голосования</h3>
			<p>Для использования виджета, скопируйте разметку и разместите в нужном местестраницы</p>
			<code>
				&lt;div id="polls" data-id="<?= $_REQUEST["VOTE_ID"] ?>"&gt;&lt;/div&gt;<br>
				&lt;script src="//dobromed15.ru/polls/widget/widget.js" type="text/javascript"&gt;&lt;/script&gt;<br>
				<!-- &lt;script type="text/javascript"&gt;	wrgsv.init(); &lt;/script&gt;<br> -->
			</code>
		</div>
	<? } ?>
</div>