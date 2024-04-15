import $ from 'jquery';

export default function initCtaContact() {
	$('.module-big-small-thumbs').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
