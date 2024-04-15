import $ from 'jquery';

export default function initVideo() {
	$.fn.video = function () {
		return this.each(function () {
			const $this = $(this);
			const $poster = $('.video-poster', $this);
			const $posterImg = $('img', $poster);
			const $video = $('video, iframe', $this);

			$poster.on('click', function (e) {
				e.preventDefault();

				if (playVideo()) {
					$poster.css('opacity', 0);
					setTimeout(() => $poster.hide(), 500);
				}
			});

			if (
				$video.exists() &&
				$video.data('autoplay') === 'yes' &&
				$video.closest('.wrap').is(':visible')
			) {
				$poster.hide();
				playVideo();
			} else {
				if ($posterImg.exists()) {
					$('.video-poster img', $this).imgLoaded(function () {
						$poster.css('opacity', 1);
					});
				} else {
					$poster.css('opacity', 1);
				}
			}

			function playVideo() {
				if (!$this.hasClass('video-played') && $video.exists() && $video.data('src')) {
					$video.attr('src', $video.data('src'));
					$video.data('src', undefined).removeAttr('data-src');
					$this.addClass('video-played');

					return true;
				}

				return false;
			}
		});
	};
}
