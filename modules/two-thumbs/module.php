<?php
/**
 * Two Thumbs module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Two Thumbs module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_two_thumbs_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'align' => 'center',
		'items' => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$align_class = match ( $data['align'] ) {
		'left' => 'left-top',
		'right' => 'right-top',
		default => ''
	};
	ob_start();
	?>
	<div class="row<?php echo $align_class ? ' ' . $align_class : ''; ?>">
		<?php foreach ( $data['items'] as $item ) : ?>
		<div class="col-xs-12 col-md-6 mouseover">
			<?php if ( $item['link'] ) : ?>
			<a <?php the_link_href( $item['link'] ); ?> <?php the_link_target( $item['link'] ); ?>>
			<?php endif; ?>
		    <div class="wrap-img">
                <?php
                    // Display video cover image with SVG play button
                    if ( $item['video'] ) {
                        echo '<div class="video-wrapper">';
                        echo '<img src="' . esc_url( $item['image']['url'] ) . '" alt="' . esc_attr( $item['image_alt_text'] ) . '">';
                        echo '<svg class="play-button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><polygon points="14,10 14,40 40,25" fill="#fff"/></svg>';
                        echo '<video controls style="display:none;">';
                        echo '<source src="' . esc_url( $item['video'] ) . '" type="video/mp4">';
                        echo 'Your browser does not support the video tag.';
                        echo '</video>';
                        echo '</div>';
                    } else {
                        // Display image if no video
                        super_img( image: $item['image'], alt: $item['image_alt_text'], css_class: 'landscape' );
                    }
                ?>
                <?php if ( $item['vertical_text'] ) : ?>
                <span class="vertical-text" ><?php echo esc_html( $item['vertical_text'] ); ?></span>
                <?php endif; ?>
            </div>
        <?php if ( $item['link'] ) : ?>
        </a>
        <?php endif; ?>
        <?php if ( $item['title'] || $item['text'] || $item['link'] ) : ?>
        <div class="text-in-md-thumb">
            <?php if ( $item['title'] ) : ?>
            <h2 class="heading-05" ><?php echo $item['title']; ?></h2>
            <?php endif; ?>
            <?php if ( $item['text'] ) : ?>
            <div class="text"><?php echo $item['text']; ?></div>
            <?php endif; ?>
            <?php if ( $item['link'] ) : ?>
            <a class="link-cta" href="<?php echo esc_url( $item['link']['url'] ); ?>" <?php the_link_target( $item['link'] ); ?>><?php the_link_label( $item['link'] ); ?></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<style>
    .video-wrapper {
        position: relative;
        display: inline-block;
    }

    .play-button,
    .pause-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 20%;
        width: 20%;
        fill: #fff; /* Set the color of the button */
        cursor: pointer;
        display: block; /* Initially show both buttons */
    }

    .video-wrapper:not(:hover) .pause-button,
    .video-playing .play-button {
        display: none; /* Hide pause button when not hovering and play button while video is playing */
    }

    .video-wrapper:hover .play-button {
        display: block; /* Display play button on hover */
    }

    .video-wrapper video {
        width: 100%;
        height: auto;
        object-fit: cover;
        min-height: 400px;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all play buttons on the page
    var playButtons = document.querySelectorAll('.play-button, .pause-button');

    // Iterate through each play/pause button
    playButtons.forEach(function(button) {
        // Add a click event listener to each play/pause button
        button.addEventListener('click', function() {
            // Find the closest video wrapper within the parent container
            var videoWrapper = this.closest('.video-wrapper');

            // Toggle the visibility of the video cover image and video element
            var videoImage = videoWrapper.querySelector('img');
            var videoElement = videoWrapper.querySelector('video');

            if (videoElement) {
                if (button.classList.contains('play-button')) {
                    // Play the video
                    videoImage.style.display = 'none';
                    videoElement.style.display = 'block';
                    videoElement.play();

                    // Toggle button visibility after the video starts playing
                    videoElement.addEventListener('playing', function() {
                        button.style.display = 'none';
                        button.nextElementSibling.style.display = 'block';
                    });
                } else if (button.classList.contains('pause-button')) {
                    // Pause the video
                    videoElement.pause();

                    // Toggle button visibility after a short delay
                    setTimeout(function() {
                        button.style.display = 'none';
                        button.previousElementSibling.style.display = 'block';
                    }, 100);
                }
            }
        });
    });
});
</script>


	<?php

	$html = ob_get_clean();

	$args = array(
		'name'  => 'two-thumbs',
		'html'  => $html,
		'fluid' => true,
	);

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}

