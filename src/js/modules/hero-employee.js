import $ from 'jquery';

export default function initHeroEmployee() {
	$('.module-hero-employee').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
