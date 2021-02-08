<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="container" id="widget_res">
	<div class="row">
		<?
		if (!empty($arResult["ERROR_MESSAGE"])) :
			?>
			<div class="vote-note-box vote-note-error">
				<div class="vote-note-box-text"><?= $arResult["ERROR_MESSAGE"]; ?></div>
			</div>
		<?
		endif;

		if (!empty($arResult["OK_MESSAGE"])) :
			?>
			<div class="col-12">
				<h4><?= ShowNote($arResult["OK_MESSAGE"]) ?></h4><br>
			</div>
		<?
		endif;

		if (empty($arResult["VOTE"]) || empty($arResult["QUESTIONS"])) :
			return true;
		endif;
		?>
		<div class="col-12">
			<ul>
				<?
				$iCount = 0;
				foreach ($arResult["QUESTIONS"] as $arQuestion) :
					$iCount++;
					?>
					<li class="vote-item-vote vote-item-<?= $arQuestion["DIAGRAM_TYPE"] ?> <?= ($iCount == 1 ? "vote-item-vote-first " : "") ?>
			<?= ($iCount == count($arResult["QUESTIONS"]) ? "vote-item-vote-last " : "") ?>
			<?= ($iCount % 2 == 1 ? "vote-item-vote-odd " : "vote-item-vote-even ") ?>">
						<div class="vote-item-header">

							<? if ($arQuestion["IMAGE"] !== false) : ?>
								<div class="vote-item-image"><img src="https://dobromed15.ru/<?= $arQuestion["IMAGE"]["SRC"] ?>"/></div>
							<? endif; ?>
							<div class="vote-item-title vote-item-question"><?= $arQuestion["QUESTION"] ?></div>
							<div class="vote-clear-float"></div>
						</div>
						<? if ($arQuestion["DIAGRAM_TYPE"] == "circle") : ?>
							<table>
								<tbody>
									<tr class="row">
										<td class="col-12 col-xl-6">
											<div class="legend"></div>
										</td>
										<td width="150" class="charts">
											<? foreach ($arQuestion["ANSWERS"] as $arAnswer) { ?>
												<div id="charts_data" data-color="#<?= $arAnswer["COLOR"]; ?>" data-counter="<?= $arAnswer["COUNTER"]; ?>" data-message="<? echo '(' . $arAnswer["PERCENT"] . '%) ' ?><?= $arAnswer["~MESSAGE"] ?>">
												</div>
											<? } ?>
											<canvas id="charts_canvas" width="150" height="150" data-color="<?= $arr['colors'] ?>"></canvas>
										</td>

									</tr>
								</tbody>
							</table>

						<? else : //histogram
								?>

							<table width="100%" class="vote-answer-table">
								<? foreach ($arQuestion["ANSWERS"] as $arAnswer) : ?>
									<? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])) : ?>
										<tr>
											<td></td>
											<td style='vertical-align:middle;'>
												<div style='width:80%; height:1px; background-color:#<?= htmlspecialcharsbx($arAnswer["COLOR"]) ?>;'></div>
											</td>
										</tr>
									<? endif; ?>
									<tr>
										<? $percent = round($arAnswer["BAR_PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td 
													?>
										<td width="24%" style=''>
											<?= htmlspecialcharsbx($arAnswer["~MESSAGE"]) ?>
											<? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])) {
															if (trim($arAnswer["MESSAGE"]) != '')
																echo '&nbsp';
															echo '(' . GetMessage('VOTE_GROUP_TOTAL') . ')';
														}
														?>
											&nbsp;</td>
										<td>
											<div class="vote-answer-bar" style="width:<?= $percent ?>%;background-color:#<?= htmlspecialcharsbx($arAnswer["COLOR"]) ?>"></div>
											<span class="vote-answer-counter">
												<nobr><?= ($arAnswer["COUNTER"] > 0 ? '&nbsp;' : '') ?><?= $arAnswer["COUNTER"] ?> (<?= $arAnswer["PERCENT"] ?>%)</nobr>
											</span>
										</td>
										<? if (isset($arResult['GROUP_ANSWERS'][$arAnswer['ID']])) : ?>
											<? $arGroupAnswers = $arResult['GROUP_ANSWERS'][$arAnswer['ID']]; ?>
									</tr>
									<? foreach ($arGroupAnswers as $arGroupAnswer) : ?>
										<? $percent = round($arGroupAnswer["PERCENT"] * 0.8); // (100% bar * 0.8) + (20% span counter) = 100% td 
															?>
										<tr>
											<td width="24%">
												<? if (trim($arAnswer["MESSAGE"]) != '') { ?>
													<span class='vote-answer-lolight'><?= htmlspecialcharsbx($arAnswer["MESSAGE"]) ?>:&nbsp;</span>
												<? } ?>
												<?= htmlspecialcharsbx($arGroupAnswer["MESSAGE"]) ?>
											</td>
											<td>
												<div class="vote-answer-bar" style="width:<?= $percent ?>%;background-color:#<?= htmlspecialcharsbx($arAnswer["COLOR"]) ?>"></div>
												<span class="vote-answer-counter">
													<nobr><?= ($arGroupAnswer["COUNTER"] > 0 ? '&nbsp;' : '') ?><?= $arGroupAnswer["COUNTER"] ?> (<?= $arGroupAnswer["PERCENT"] ?>%)</nobr>
												</span>
											</td>
										</tr>
									<? endforeach ?>
									<tr>
										<td></td>
										<td style='vertical-align:middle;'>
											<div style='width:80%; height:1px; background-color:#<?= htmlspecialcharsbx($arAnswer["COLOR"]) ?>;'></div>
										</td>
									</tr>
								<? else : ?>
									</tr>
								<? endif; // USER_ANSWERS 
											?>
							<? endforeach ?>
							</table>
						<?
							endif;
							?>
					</li>
				<?
				endforeach;

				?>
			</ul>
		</div>
	</div>
</div>