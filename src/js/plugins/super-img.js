import $ from 'jquery';

export default function initSuperImg() {
	$.fn.superImg = function (loadCallback) {
		return this.each(function () {
			const $this = $(this),
				$video = $('video', $this),
				$image = $('img', $this);

			if ($video.length === 0) {
				if ($image.length !== 0) {
					if ($image.prop('complete')) {
						triggerLoadCallback();
					} else {
						$image.off('load').on('load', triggerLoadCallback);
					}
				}
			} else {
				if ($video.prop('readyState') > 0) {
					triggerLoadCallback();
				} else {
					$video.off('loadeddata').on('loadeddata', function () {
						if ($video.prop('readyState') > 0) {
							triggerLoadCallback();
						}
					});
				}
			}

			function triggerLoadCallback() {
				$this.addClass('loaded');
				if (typeof loadCallback === 'function') {
					loadCallback.call(null);
				}
			}
		});
	};
}
