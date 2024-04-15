import $ from 'jquery';

export default function initCtaContact() {
	$('.module-cta-contact').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
