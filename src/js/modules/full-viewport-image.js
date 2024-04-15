import $ from 'jquery';

export default function initFullViewportImage() {
	$('.module-full-viewport-image').each(function () {
		const $this = $(this);
		// custom animation need for this module on Single Project page.
		$('.super-img', $this).superImg();

		if ($('body').hasClass('single-project') && $this.index() === 0) {
			var $wrapperContentModules = $this.parent();
			var $absElement = $('.super-img', $this);
			var $fixedElement = $('.module__fixed', $this);
			var maxScroll = 0;
			var offsetImage = 0;
			var wTop = $(window).scrollTop();
			var vH = document.documentElement.clientHeight;

			$fixedElement.addClass('fixed-bg');

			resizeListener();

			$(window).on('scroll', scrollListener);
			$(window).on('resize', resizeListener);

			$(document).on('barba_before', function () {
				$(window).off('scroll', scrollListener);
				$(window).off('resize', resizeListener);
			});

			function scrollListener() {
				wTop = $(this).scrollTop();
				scrollCalculator();
			}

			function resizeListener() {
				wTop = $(window).scrollTop();
				vH = document.documentElement.clientHeight;

				$this.css({
					height: $(window).width() > 1024 ? vH - 70 : vH - 50,
				});

				offsetImage = $this.offset().top - parseInt($wrapperContentModules.css('margin-top'));

				maxScroll = $(window).width() > 1024 ? offsetImage - 70 : offsetImage - 50;

				$wrapperContentModules.css({
					'margin-top': $fixedElement.outerHeight(),
				});

				scrollCalculator();
			}

			function scrollCalculator() {
				$this.removeAttr('style');
				console.log(wTop, maxScroll, offsetImage, vH);

				if (wTop <= maxScroll) {
					$fixedElement.css({
						transform: 'translate3d(0px, 0px, 0px)',
						top: offsetImage - wTop,
						height: $(window).width() > 1024 ? vH - 70 : vH - 50,
					});
				} else {
					$absElement.css({
						position: 'absolute',
						transform: 'translate3d(0px, 0px, 0px)',
						top: wTop - offsetImage > 10 ? (offsetImage - wTop) / 4 + 'px' : 0,
						bottom: 'auto',
						height: $(window).width() > 1024 ? vH - 70 : vH - 50,
					});

					$fixedElement.css({
						transform: 'translate(0, -' + 0 + 'px) translate3d(0px, 0px, 0px)',
						top: $(window).width() > 1024 ? 70 : 50,
					});
				}
			}
		}
	});
}
