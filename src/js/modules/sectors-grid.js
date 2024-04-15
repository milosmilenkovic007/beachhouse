import $ from 'jquery';

export default function initSectorsGrid() {
	$('.module-sectors-grid').each(function () {
		const $this = $(this);

		$('.services-list a[target="_blank"]', $this).redirectPopup();
	});
}
