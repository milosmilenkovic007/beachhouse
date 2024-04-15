import $ from 'jquery';

export default function initEmployeesOfficesFinder() {
	$('.module-employees-offices-finder').each(function () {
		const $this = $(this);
		const $nav_items = $('.filter-contact > div', $this);
		const $tabs = $('.list-item-contact', $this);
		const $filters = $('.filter-alphabet li', $this);
		const $employeesContainer = $('.wrap-list-em', $this);
		const $employees = $(' > div', $employeesContainer).detach();
		let filterLetter = '';

		$nav_items.on('click', function () {
			const $nav_item = $(this);

			if ($nav_item.hasClass('active')) return;

			$nav_items.removeClass('active');
			$nav_item.addClass('active');

			console.log($nav_item.data('target'));
			console.log(
				$tabs
					.hide()
					.filter('.list-' + $nav_item.data('target'))
					.show()
			);

			//initHeightImgInContactList();
		});

		$filters.on('click', function () {
			var $li = $(this);

			if ($li.hasClass('active') || $li.hasClass('disabled')) {
				return;
			}

			const newFilterLetter = $li.html().toLowerCase();

			if (newFilterLetter !== filterLetter) {
				filterEmployees(newFilterLetter);
			}
		});

		filterEmployees('a');

		function filterEmployees(letter) {
			filterLetter = letter;

			$filters
				.removeClass('active')
				.filter(function () {
					return $(this).html() === filterLetter;
				})
				.addClass('active');

			$employees.detach();

			const $filtered_employees = $employees
				.filter(function () {
					return anyNameStartsWith($('h3', this).html(), filterLetter);
				})
				.appendTo($employeesContainer);
			const $images = $filtered_employees.find('.super-img');

			$images.removeClass('loaded');

			setTimeout(function () {
				$images.superImg();
			}, 0);
		}

		function anyNameStartsWith(fullname, search) {
			//validate if name is null or not a string if needed
			if (search === '') return true;

			var delimeterRegex = /[ _-]+/;
			var names = fullname.split(delimeterRegex);

			//do any of the names in the array start with the search string
			return (
				names.filter(name => name.toLowerCase().indexOf(search.toLowerCase()) === 0).length > 0
			);
		}
	});
}
