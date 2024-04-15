import $ from 'jquery';

export default function initOfficeEmployees() {
	$('.module-office-employees').each(function () {
		const $this = $(this);

		$('.super-img', $this).superImg();
	});
}
