import $ from 'jquery';
import 'slick-carousel';

export default function initCarousel() {
	$.fn.carousel = function () {
		return this.each(function () {
			const $carousel = $(this);
			const $slick = $('.scroller', $carousel);
			const $prev = $('.control-slider-prev', $carousel);
			const $next = $('.control-slider-next', $carousel);

			const isAdvanced = $carousel.hasClass('advanced');
			const totalSlides = $('.item', $carousel).length;
			const lastIndex = totalSlides - 1;
			let direction = 'right';
			let animating = false;

			if (totalSlides > 0) {
				setTimeout(function () {
					$slick.slick({
						arrows: true,
						dots: false,
						variableWidth: true,
						centerMode: true,
						slidesToShow: 1,
						centerPadding: 0,
						accessibility: false,
						speed: 800,
						prevArrow: $prev,
						nextArrow: $next,
						slide: '.item',
					});
				}, 0);

				var xMoveDefault;
				if (window.innerWidth >= 1024) {
					xMoveDefault =
						-((1 / 6) * (window.innerWidth - 68 + 32)) +
						(window.innerWidth - $(window).width()) / 2;
				} else {
					xMoveDefault = 0;
				}

				$slick.on('init', function (event, slick, currentSlide, nextSlide) {
					$('.super-img', $carousel).superImg();

					$(this).find('.slick-active').prev().addClass('prev');
					$(this).find('.slick-active').next().addClass('next');

					$('.item.prev, .item.prev-prev, .item.to-be-prev').css({
						'-webkit-transform': 'translateX(' + xMoveDefault + 'px)',
						'-moz-transform': 'translateX(' + xMoveDefault + 'px)',
						'-o-transform': 'translateX(' + xMoveDefault + 'px  )',
						transform: 'translateX(' + xMoveDefault + 'px)',
					});

					// change position when resize
					$(window).on('resize', carouselResize);

					$(document).on('barba_before', function () {
						$(window).off('resize', carouselResize);
					});

					function carouselResize() {
						if (window.innerWidth >= 1024) {
							xMoveDefault =
								-((1 / 6) * (window.innerWidth - 68 + 32)) +
								(window.innerWidth - $(window).width()) / 2;

							$('.item.prev, .item.prev-prev, .item.to-be-prev').css({
								transform: 'translateX(' + xMoveDefault + 'px)',
							});

							if (direction == 'right') {
								$(this).find('.item.prev').addClass('prev-prev');
								setTimeout(function () {
									$('.item.prev-prev').removeAttr('style');
									$slick.find('.item').removeClass('prev-prev');
								}, 300);
								$('.item.prev').removeAttr('style');
								$(this).find('.item').removeClass('prev next');
								$(this).find('.slick-current').addClass('prev').css('transition', 'all .8s');
								$('.item.prev').css({
									transform: 'translateX(' + xMoveDefault + 'px)',
								});
							} else {
								var $prev = $(this).find('.item.prev');
								$prev.prev().addClass('to-be-prev');
								$('.item.to-be-prev').css({
									transform: 'translateX(' + xMoveDefault + 'px)',
								});
								$('.item.prev').removeAttr('style');
								$prev.addClass('to-be-current').removeClass('prev');
								$(this).find('.item').removeClass('next');
							}
						}
					}
				});

				// On before slide change
				$slick.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
					$('.item.prev, .item.prev-prev, .item.to-be-prev').css({
						transform: 'translateX(' + xMoveDefault + 'px)',
					});

					if (currentSlide === 0) {
						if (nextSlide == 1) {
							direction = 'right';
						} else {
							direction = 'left';
						}
					} else if (currentSlide == lastIndex) {
						if (nextSlide === 0) {
							direction = 'right';
						} else {
							direction = 'left';
						}
					} else {
						if (currentSlide < nextSlide) {
							direction = 'right';
						} else {
							direction = 'left';
						}
					}

					if (direction == 'right') {
						$(this).find('.item.prev').addClass('prev-prev');
						setTimeout(function () {
							$('.item.prev-prev').removeAttr('style');
							$slick.find('.item').removeClass('prev-prev');
						}, 300);
						$('.item.prev').removeAttr('style');
						$(this).find('.item').removeClass('prev next');
						$(this).find('.slick-current').addClass('prev').css('transition', 'all .8s');
						$('.item.prev').css({
							transform: 'translateX(' + xMoveDefault + 'px)',
						});
					} else {
						var $prev = $(this).find('.item.prev');
						$prev.prev().addClass('to-be-prev');
						$('.item.to-be-prev').css({
							transform: 'translateX(' + xMoveDefault + 'px)',
						});
						$('.item.prev').removeAttr('style');
						$prev.addClass('to-be-current').removeClass('prev');
						$(this).find('.item').removeClass('next');
					}

					animating = true;
				});

				// On after slide change
				$slick.on('afterChange', function (event, slick, currentSlide) {
					$(this)
						.find('.item')
						.removeClass('prev-prev to-be-current to-be-prev')
						.css('transition', '');
					$(this).find('.slick-active').prev().addClass('prev');
					$(this).find('.slick-active').next().addClass('next');

					$('.item.prev-prev, .item.to-be-prev').removeAttr('style');
					$('.item.prev').css({
						transform: 'translateX(' + xMoveDefault + 'px)',
						transition: 'all .8s',
					});

					animating = false;
				});

				$carousel
					.on('mouseenter', '.slick-next', function (event) {
						if (animating) return;
						$(this).prev().find('.slick-active').next().addClass('trans-margin-left');
					})
					.on('mouseleave', '.slick-next', function () {
						$(this).prev().find('.slick-active').next().removeClass('trans-margin-left');
					});

				$carousel
					.on('mouseenter', '.slick-prev ', function (event) {
						if (animating) return;
						$(this).next().find('.slick-active').prev().addClass('trans-margin-right');
					})
					.on('mouseleave', '.slick-prev', function () {
						$(this).next().find('.slick-active').prev().removeClass('trans-margin-right');
					});

				$carousel.on('click', '.slick-slide.prev', function (e) {
					e.preventDefault();
					$prev.trigger('click');
				});

				$carousel.on('click', '.slick-slide.next', function (e) {
					e.preventDefault();
					$next.trigger('click');
				});
			}
		});
	};
}
