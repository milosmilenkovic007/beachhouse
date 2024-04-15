import $ from 'jquery';

export default function initServicesGrid() {
	$('.module-services-grid').each(function () {
		const $this = $(this);

		$('.group a[target="_blank"]', $this).redirectPopup();
	});
}
