<?php
/**
 * Full Viewport Image module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Full Viewport Image module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_full_viewport_image_module( $config ) {

    // Default configurations
    $config_defaults = [
        'data'   => [],
        'module' => [],
    ];

    $config = wp_parse_args( $config, $config_defaults );

    // Default data values
    $data_defaults = [
        'image'       => null,
        'image_alt'   => '',
        'video'       => null,
    ];

    $data = wp_parse_args( $config['data'], $data_defaults );

    // Extract video URL if it's an array
    $video_url = is_array( $data['fvi_video'] ) ? $data['video']['url'] : $data['fvi_video'];

    // Debugging: Print video URL
    echo 'Video URL: ' . esc_url( $video_url ) . '<br>';

    ob_start();
    ?>
    <div class="module__fixed">
        <?php if ( $video_url ) : ?>
            <video controls poster="<?php echo esc_attr( $data['image'] ); ?>" class="module__video" id="fviVideo">
                <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button id="playPauseBtn">Play</button>
        <?php else : ?>
            <?php super_img( image: $data['image'], alt: $data['image_alt'], size: '4k' ); ?>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var video = document.getElementById('fviVideo');
            var playPauseBtn = document.getElementById('playPauseBtn');

            if (video) {
                playPauseBtn.addEventListener('click', function () {
                    if (video.paused) {
                        video.play();
                        playPauseBtn.textContent = 'Pause';
                    } else {
                        video.pause();
                        playPauseBtn.textContent = 'Play';
                    }
                });
            }
        });
    </script>
    <?php

    $html = ob_get_clean();

    // Module configurations
    $args = [
        'name'  => 'full-viewport-image',
        'html'  => $html,
        'fluid' => false,
    ];

    $args = array_merge( $args, $config['module'] );

    ob_start();

    // Include module template
    get_template_part( slug: 'template-parts/module', args: $args );

    return ob_get_clean();
}
