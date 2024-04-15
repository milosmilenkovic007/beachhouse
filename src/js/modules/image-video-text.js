import $ from 'jquery';

export default function initImageVideoText() {
	$('.module-image-video-text').each(function () {
		const $this = $(this);

		$('.video', $this).video();

		$('.super-img', $this).superImg();
	});
}
