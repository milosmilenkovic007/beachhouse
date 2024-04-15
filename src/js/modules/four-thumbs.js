import $ from 'jquery';

export default function initFourThumbs() {
	$('.module-four-thumbs').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
