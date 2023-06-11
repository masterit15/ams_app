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
							Телефон контакт-центра
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
						<li>Главный редактор: Биазарти Д. К.</li>
						<li>Свидетельство о регистрации СМИ ЭЛ № ФС 77 – 75258 от 07.03.2019 выданное Федеральной Службой по надзору в сфере связи, информационных технологий и массовых коммуникаций</li>
						<li>Учредитель: Администрация местного самоуправления г. Владикавказ</li>
						<li>Адрес редакции: Владикавказ, пл. Штыба, №2</li>
						<li>Е-почта редакции: <a href="mailto:smi-ams@rso-a.ru">smi-ams@rso-a.ru</a></li>
						<li><a href="/legal/" target="_blank" rel="noopener noreferrer">Соглашение о пользовании информационными системами и ресурсами города Владикавказ</a></li>
					</ul>
				</div>
				<div class="copyright">© 2019—2020. Официальный сайт администрации местного самоуправления и Собрание представителей г. Владикавказ. <span class="soip">6+</span>
<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=91636455&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/91636455/3_0_6654E2FF_6654E2FF_1_uniques"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="91636455" data-lang="ru" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(91636455, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/91636455" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
			</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->
	<div id="toTop"><i class="fa fa-chevron-up"></i></div>
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
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.2/js.cookie.js"></script>
    <style>
        .cookie-notification {
            position: fixed;
            background-color: rgba(0, 0, 0, .8);
            bottom: 0;
						left: 0;
						right: 0;
            width: 100%;
						/* max-width: 1200px; */
            color: white;
						margin: auto;
            padding: 15px;
						z-index: 9999;
        }
        .cookie-notification_hidden_yes {
            display: none;
        }
        .cookie-notification__header {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .cookie-notification__body {
            margin-bottom: 10px;
						font-size: 14px;
        }
				.cookie-notification__button{
					cursor: pointer;
					padding: 10px 20px;
				}
    </style>
	<div class="cookie-notification cookie-notification_hidden_yes">
        <div class="cookie-notification__header">Мы используем Яндекс Метрику</div>
        <div class="cookie-notification__body">
            <p>Этот сайт использует сервис веб-аналитики Яндекс Метрика, предоставляемый компанией ООО «ЯНДЕКС», 119021, Россия, Москва, ул. Л. Толстого, 16 (далее&nbsp;— Яндекс).</p>
	     <p>Сервис Яндекс Метрика использует технологию “cookie”&nbsp;— небольшие текстовые файлы, размещаемые на компьютере пользователей с целью анализа их пользовательской активности.</p>
            <p>Собранная при помощи cookie информация не может идентифицировать вас, однако может помочь нам улучшить работу нашего сайта. Информация об использовании вами данного сайта, собранная при помощи cookie, будет передаваться Яндексу и храниться на сервере Яндекса в ЕС и Российской Федерации. Яндекс будет обрабатывать эту информацию для оценки использования вами сайта, составления для нас отчетов о деятельности нашего сайта, и предоставления других услуг. Яндекс обрабатывает эту информацию в порядке, установленном в условиях использования сервиса Яндекс Метрика.</p>
            <p>Вы можете отказаться от использования cookies, выбрав соответствующие настройки в браузере. Также вы можете использовать инструмент&nbsp;— https://yandex.ru/support/metrika/general/opt-out.html Однако это может повлиять на работу некоторых функций сайта. Используя этот сайт, вы соглашаетесь на обработку данных о вас Яндексом в порядке и целях, указанных выше.</p>
        </div>
        <div class="cookie-notification__buttons">
            <button class="cookie-notification__button" id="yes">Я согласен</button>
        </div>
    </div>
    <script type="text/javascript">
        var messageElement = document.querySelector('.cookie-notification');
        // Если нет cookies, то показываем плашку
        if (!Cookies.get('agreement')) {
            showMessage();
        } else {
            initCounter();
        }
        // Загружаем сам код счетчика сразу
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document,'script','//mc.yandex.ru/metrika/tag.js', 'ym')
        // Функция добавляет класс к DOM-элементу. Вы можете использовать библиотеку jQuery или другой фреймворк
        function addClass (o, c) {
            var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
            if (!o || re.test(o.className)) {
                return;
            }
            o.className = (o.className + " " + c).replace(/\s+/g, " ").replace(/(^ | $)/g, "");
        }
        // Функция удаляет класс из DOM-элемента. Вы можете использовать библиотеку jQuery или другой фреймворк
        function removeClass (o, c) {
            var re = new RegExp('(^|\\s)' + c + '(\\s|$)', 'g');
            if (!o) {
                return;
            }
            o.className = o.className.replace(re, '$1').replace(/\s+/g, ' ').replace(/(^ | $)/g, '');
        }
        // Функция, которая прячет предупреждение
        function hideMessage () {
            addClass(messageElement, 'cookie-notification_hidden_yes');
        }
        // Функция, которая показывает предупреждение
        function showMessage () {
            removeClass(messageElement, 'cookie-notification_hidden_yes');
        }
        function saveAnswer () {
            // Прячем предупреждение
            hideMessage();

            // Ставим cookies
            Cookies.set('agreement', '1');
        }
        function initCounter () {
            ym(91636455, 'init', {});
            saveAnswer();
        }
        // Нажатие кнопки "Я согласен"
        document.querySelector('#yes').addEventListener('click', function () {
            initCounter();
        });
    </script>
</body>
</html>