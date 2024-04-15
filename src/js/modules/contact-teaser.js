import $ from 'jquery';

export default function initContactTeaser() {
	$('.module-contact-teaser').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
