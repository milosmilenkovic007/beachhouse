import $ from 'jquery';

export default function initText() {
	$('.module-text').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
