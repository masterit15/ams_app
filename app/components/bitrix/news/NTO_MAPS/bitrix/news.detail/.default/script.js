$(function() {
// 	$('.item-slider').owlCarousel({
// 	loop: true,
// 	items: 1,
// 	nav: true,
// 	navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
// 	dots: false,
// });
	$('.image-popup').magnificPopup({
	type: 'image',
	closeOnContentClick: true,
	closeBtnInside: false,
	fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});



	$('.thumbs').each(function () {
  $('a', this).each(function () {
    var $a = $(this);
    // set ids, will use them later
    $a.attr({id: $a.attr('href').replace(/[\/\.-]/g, '')});
  });

  var $thumbs = $(this),
      $fotorama = $thumbs.clone();

  $fotorama
      .on('fotorama:show', function (e, fotorama) {
        // pick the active thumb by id
        $('#' + fotorama.activeFrame.id)
            .addClass('active')
            .siblings()
            .removeClass('active');
      })
      .addClass('fotorama')
      .removeClass('thumbs')
      .insertBefore(this)
      .fotorama({nav: false, width: '100%', maxHeight: 400, ratio: 3/2});

  // get access to the API
  var fotorama = $fotorama.data('fotorama');

  $thumbs.on('click', 'a', function (e) {
    e.preventDefault();
    // show frame by id
    fotorama.show(this.id);
  });
});
});