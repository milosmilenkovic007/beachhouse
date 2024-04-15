import $ from 'jquery';

export default function initHeader() {
	const $header = $('header');
	const $search_input = $('#search');

	$(window).on('scroll', setScrollDown);

	$(document).on('barba_before', function () {
		closeMenu();
		closeSearch();
	});

	$(document).on('click touch', '.wrap-icon-burger', function (e) {
		e.stopPropagation();
		$header.toggleClass('opened');
		$('html').toggleClass('menu--opened');
	});

	$(document).on('click touch', '.mask-menu', function (e) {
		// e.preventDefault();
		e.stopPropagation();
		if ($('html').hasClass('menu--opened')) {
			closeMenu();
		}
	});

	$(document).on('click touch', '.wrap-icon-search .icon-search', function () {
		$('html').addClass('search--opened');
		$search_input.focus();
	});

	function closeMenu() {
		$('html').removeClass('menu--opened');
		$header.removeClass('opened');
	}

	function closeSearch() {
		$('html').removeClass('search--opened');
	}

	function setScrollDown() {
		if ($(window).scrollTop() > 0) {
			$('body').addClass('scroll-down');
		} else {
			$('body').removeClass('scroll-down');
		}
	}

	setScrollDown();
}
