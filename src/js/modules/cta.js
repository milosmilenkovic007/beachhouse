import $ from 'jquery';

export default function initCta() {
	$('.module-cta').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
