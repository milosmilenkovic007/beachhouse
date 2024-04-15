import $ from 'jquery';

export default function initThumb8Col() {
	$('.module-thumb-8col').each(function () {
		const $this = $(this);

		$('.video', $this).video();

		$('.super-img', $this).superImg();
	});
}
