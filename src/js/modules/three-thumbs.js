import $ from 'jquery';

export default function initThreeThumbs() {
	$('.module-three-thumbs').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
