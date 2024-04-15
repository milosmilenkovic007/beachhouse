import $ from 'jquery';

export default function initSlider() {
	$('.module-slider').each(function () {
		const $this = $(this);
		const $carousel = $('.carousel', $this);

		$carousel.carousel();
	});
}
