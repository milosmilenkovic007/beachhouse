import $ from 'jquery';

export default function initHero() {
	// clear event listeners
	$(window).off('scroll.landing-page');

	if ($('html').hasClass('landing-page')) {
		$('.module-hero-landing .super-img').superImg(function () {
			if ($('html').hasClass('mobile')) {
				var vH = $('#page').outerHeight();
				var vw = $('#page').outerWidth();
				$(
					'html.landing-page .module-hero-landing, html.landing-page .module-hero-landing .super-img'
				).css({
					height: vH,
					width: vw,
				});
			}

			$('html').addClass('img-loaded');
			var $top_super_img = $('.module-hero-landing').find('.super-img');
			var $fixed_block = $('.module-hero-landing').find('.fixed-block');
			var wTop = 0,
				topSuper = 0;

			$(window).on('scroll.landing-page', function () {
				if (!$('body').hasClass('openSearch')) {
					wTop = $(this).scrollTop();
					topSuper = wTop > 0 ? wTop / 2 : 0;

					if (wTop > 0 && $('html').hasClass('browser-ie')) {
						$('.module-hero-landing').addClass('hide-overlay');
					} else {
						$('.module-hero-landing').removeClass('hide-overlay');
					}

					$top_super_img.css({
						transform: 'translate3d(0px, ' + topSuper + 'px, 0px)',
						'-webkit-transform': 'translate3d(0px, ' + topSuper + 'px, 0px)',
						'-moz-transform': 'translate3d(0px, ' + topSuper + 'px, 0px)',
						'-o-transform': 'translate3d(0px, ' + topSuper + 'px, 0px)',
						bottom: 'auto',
						height: '100%',
					});

					$fixed_block.css({
						transform: 'translate3d(0px, ' + -wTop + 'px, 0px)',
						'-webkit-transform': 'translate3d(0px, ' + -wTop + 'px, 0px)',
						'-moz-transform': 'translate3d(0px, ' + -wTop + 'px, 0px)',
						'-o-transform': 'translate3d(0px, ' + -wTop + 'px, 0px)',
					});

					if (wTop > $top_super_img.outerHeight() + 50) {
						$top_super_img.css({
							visibility: 'hidden',
						});
					} else {
						$top_super_img.css({
							visibility: 'visible',
						});
					}
				}
			});
		});
	}
}
