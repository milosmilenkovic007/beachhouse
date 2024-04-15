import $ from 'jquery';

export default function initTwoThumbs() {
	$('.module-two-thumbs').each(function () {
		const $this = $(this);

		var checkedVText = false;

		function checkSizeVText() {
			if (checkedVText || !$('.wrap-img .vertical-text', $this).length) return;
			checkedVText = true;
			$('.wrap-img .vertical-text', $this).each(function () {
				$(this).removeAttr('style');
				$(this).css({
					height:
						$(this).outerHeight() % 2 == 0 ? $(this).outerHeight() : $(this).outerHeight() + 1,
					width:
						$(this).outerWidth() % 2 == 0 ? $(this).outerWidth() + 1 : $(this).outerWidth() + 2,
				});
			});
		}
		$(window).on('resize', function () {
			checkedVText = false;
			checkSizeVText();
		});

		$('.super-img', $this).superImg(checkSizeVText);
	});
}
