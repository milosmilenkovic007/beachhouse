import $ from 'jquery';

export default function initImgLoaded() {
	$.fn.imgLoaded = function (loadCallback) {
		return this.each(function () {
			const $image = $(this);

			const triggerLoadCallback = () => {
				if (typeof loadCallback === 'function') {
					loadCallback.call(this);
				}
			};

			if ($image.prop('complete')) {
				triggerLoadCallback();
			} else {
				$image.on('load', triggerLoadCallback);
			}
		});
	};
}
