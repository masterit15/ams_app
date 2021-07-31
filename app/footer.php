<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
					</div>
				</div>
				<!-- end #WORK_AREA -->
			</div>
			<!-- end row -->
		</div>
		<!-- begin container or container-fluid -->
	</main>
	<!-- end content -->
	</div>
	<!-- end wrapper -->
	<!-- begin footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
			<div class="col-12 col-xl-4">
					<div class="logo">
						<a href="/">
							<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" alt="">
							<p>Администрация местного самоуправления и Собрания представителей г. Владикавказ.</p>
						</a>
					</div>
					<ul class="footer_info">
						<li>С понедельника по пятницу – с 9.00 до 18.00</li>
						<li>
							Телефон справочной службы
							АМС г. Владикавказ
							<a href="tel:+78867303030">30-30-30</a>
							звонки принимаются
							с 9:00 до 18:00
						</li>
						<li>
								Круглосуточный телефон
								Единой дежурной диспетчерской службы
								<a href="tel:+78867531919">53-19-19</a>
						</li>
						<li>Электронная почта: <a href="mailto:vladikavkaz@rso-a.ru">vladikavkaz@rso-a.ru</a> </li>
					</ul>
				</div>
				<div class="col-12 col-xl-4">
				<?$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"footer_menu", 
						array(
							"ALLOW_MULTI_SELECT" => "N",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"ROOT_MENU_TYPE" => "top",
							"USE_EXT" => "Y",
							"COMPONENT_TEMPLATE" => "footer_menu"
						),
						false
					);?>
				</div>
				<div class="col-12 col-xl-4">
				<ul class="footer_info">
						<li>Владикавказ, пл. Штыба, №2</li>
						<li>Тел: (8672) 70-72-14</li>
						<li>И.о. гл. редактора: Каллагова З. М.</li>
						<li>Свидетельство о регистрации СМИ ЭЛ № ФС 77 – 75258 от 07.03.2019 выданное Федеральной Службой по надзору в сфере связи, информационных технологий и массовых коммуникаций</li>
						<li>Учредитель: Администрация местного самоуправления г. Владикавказ</li>
						<li><a href="/legal/" target="_blank" rel="noopener noreferrer">Соглашение о пользовании информационными системами и ресурсами города Владикавказ</a></li>
					</ul>
				</div>
				<div class="copyright">© 2019—2020. Официальный сайт администрации самоуправления и Собрание представителей г. Владикавказ. <span class="soip">12+</span>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->
	<div id="toTop"><i class="fa fa-chevron-up"></i></div>
	<nav id="footer_nav">
		<ul>
			<li>
				<a href="tel:303030"><i class="fa fa-phone"></i></a>
			</li>
			<li>
				<div class="search">
					<i class="fa fa-search"></i>
				</div>
			</li>
			<li>
				<span class="aa-enable aa-hide" tabindex="1" data-aa-on>
					<i class="fa fa-low-vision"></i>
				</span>
			</li>
			<li>
				<a class="appliction" href="javascript:void(0)" data-izimodal-open="#modal_app_form" data-izimodal-transitionin="fadeInDown">
					<i class="fa fa-pencil-square-o"></i>
				</a>
			</li>
		</ul>
	</nav>
	<!-- begin modal -->
	<div id="modal_app_form" data-iziModal-fullscreen="true" data-iziModal-title="Форма электронного обращения"
		data-iziModal-subtitle="Поля, отмеченные *, обязательны для заполнения" data-iziModal-icon="icon-home">
		
		<div class="modal_loader">
			<svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
				y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
				<path fill="#fff"
					d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z"
					transform="rotate(312.597 50 50)">
					<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50"
						to="360 50 50" repeatCount="indefinite"></animateTransform>
				</path>
				<path fill="#fff"
					d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z"
					transform="rotate(-265.194 50 50)">
					<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50"
						to="-360 50 50" repeatCount="indefinite"></animateTransform>
				</path>
				<path fill="#fff"
					d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5L82,35.7z"
					transform="rotate(312.597 50 50)">
					<animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50"
						to="360 50 50" repeatCount="indefinite"></animateTransform>
				</path>
			</svg>
		</div>
		<div class="modal_content">
			
		</div>
	</div>
	<!-- end modal -->
</body>
</html>