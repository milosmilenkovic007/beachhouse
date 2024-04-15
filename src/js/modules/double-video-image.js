import $ from 'jquery';

export default function initDoubleVideoImage() {
	$('.module-double-video-image').each(function () {
		const $this = $(this);

		$('.video', $this).video();

		$('.super-img', $this).superImg();
	});
}
