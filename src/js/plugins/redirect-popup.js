import $ from 'jquery';

export default function initRedirectPopup() {
	let popupTimeout;

	$.fn.redirectPopup = function () {
		let $popup = $('.redirect-popup');

		if (!$popup.exists()) {
			const template = `
                <div class="redirect-popup" style="display: none">
                    <div class="modal-body">
                        <h1></h1>
                        <h4></h4>
                        <div class="counter">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="front"></div>
                                    <div class="back"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

			$popup = $(template);

			$('h1', $popup).text(ThemeConfig.redirectPopup.header);
			$('h4', $popup).text(ThemeConfig.redirectPopup.title);

			$popup.on('click', function (e) {
				popupClose();
			});

			$('.modal-body', $popup).on('click', function (e) {
				e.stopPropagation();
			});

			$('body').append($popup);
		}

		const popupOpen = function (url) {
			$popup.addClass('animate').show();

			popupTimeout = setTimeout(function () {
				if (!window.open(url)) {
					window.location.href = url;
				}
				popupClose();
			}, 3000);
		};

		const popupClose = function () {
			if (popupTimeout) {
				clearTimeout(popupTimeout);
			}

			$popup.hide().removeClass('animate');
		};

		return this.each(function () {
			var $this = $(this);

			$this.on('click', function (e) {
				e.preventDefault();

				popupOpen(this.href);
			});
		});
	};
}
