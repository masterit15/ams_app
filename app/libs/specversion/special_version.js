(function () {
	'use strict';
	$(document)
		.on('click', '.special-settings a', function (e) {
			e.preventDefault();
			setSpecialVersion($(this).data());
		})
		.on('click', '[data-aa-off]', function(e) {
			e.preventDefault();
			unsetSpecialVersion();
		})
		.on('click keypress', '[data-aa-on]', function(e) {
			e.preventDefault();
			if ((e.type == 'keypress' && e.keyCode == '13') || e.type == 'click') {
				setDefaultsSpecialVersion();
			};
		});

	jQuery(document).ready(function ($) {
		setSpecialVersion();
	});
	function setSpecialVersion(data) {
		var
			cookieJson = $.cookie.json,
			$html = $('html'),
			htmlCurrentClass = $html.prop('class'),
			clearSpecialClasses = htmlCurrentClass.replace(/special-([a-z,A-Z,-]+)/g, ''),
			$aaVersion = {'aaVersion':'on'},
			htmlClass = '';

		$.cookie.json = true;

		if (data) {
			var $newCookies = $.extend($.cookie('aaSet'), data, $aaVersion);

			$.cookie('aaSet', $newCookies, {
				expires: 365,
				path: '/',
				secure: false
			});
		}

		$('.a-current').removeClass('a-current');

		if ($.cookie('aaSet')) {		
			$.each($.cookie('aaSet'), function (key, val) {
				htmlClass += ' special-' + key + '-' + val;
				$('.' + key + '-' + val).addClass('a-current');

			});
			
			$html
				.prop('class', clearSpecialClasses)
				.addClass(htmlClass);


			$.cookie.json = cookieJson;
		}

		$.fn.matchHeight._update();

		return false;
	}

	function unsetSpecialVersion() {
		var 
			htmlCurrentClass = $('html').prop('class'),
			clearSpecialClasses = htmlCurrentClass.replace(/special-([a-z,A-Z,-]+)/g, '');
		$('html').prop('class', clearSpecialClasses);
		$.removeCookie('aaSet', {path: '/'});
		
		$.fn.matchHeight._update();
	}
	function setDefaultsSpecialVersion(params) {
		var $specialDefaults = {
			'aaVersion':'on',
			'aaColor': 'black',
			'aaFontsize': 'small',
			'aaFont': 'serif',
			'aaKerning': 'normal',
			'aaImage': 'on'
		};

		var $setDefaulParams = $.extend($specialDefaults, params);

		setSpecialVersion($setDefaulParams);
	}

})();


