<?php
/**
 * Full Video Text module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Full Video Text module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_full_video_text_module( $config ) {

    $config_defaults = array(
        'data'   => array(),
        'module' => array(),
    );

    $config = wp_parse_args( $config, $config_defaults );

    $data_defaults = array(
        'fvt_columns'          => 12,
        'fvt_image_enable'     => false,
        'fvt_image'            => '',
        'fvt_image_alt'        => '',
        'fvt_image_size'       => 'landscape',
        'fvt_image_position'   => 'left',
        'fvt_video_enable'     => false,
        'fvt_video_type'       => '',
        'fvt_video'            => '',
        'fvt_youtube_id'       => '',
        'fvt_video_loop'       => true,
        'fvt_video_autoplay'   => true,
        'fvt_video_play_on_mobile' => true,
        'fvt_text_enable'      => false,
        'fvt_title'            => '',
        'fvt_text'             => '',
        'fvt_text_position'    => '',
        'fvt_text_center_mobile' => false,
    );

    $data = wp_parse_args( $config['data'], $data_defaults );

    $row_classes = array(
        'row',
    );

    $column_classes = array(
        'col-xs-12',
    );

    if ( $data['fvt_columns'] == 12 ) :
        $row_classes[]    = 'column-12';
        $column_classes[] = 'col-md-12';
    else :
        $column_classes[] = 'col-md-8';
    endif;

    if ( $data['fvt_text_center_mobile'] ) :
        $row_classes[] = 'text-center-mb';
    endif;

    if ( $data['fvt_image_position'] ) :
        $row_classes[] = 'image-' . $data['fvt_image_position'];
    endif;

    if ( $data['fvt_text_position'] ) :
        $row_classes[] = 'text-' . $data['fvt_text_position'];
    endif;

    ob_start();
    ?>
    <div <?php the_css_class( $row_classes ); ?>>
        <div <?php the_css_class( $column_classes ); ?>>
            <?php if ( $data['fvt_image_enable'] && ! empty( $data['fvt_image'] ) ) : ?>
                <?php super_img( image: $data['fvt_image'], css_class: $data['fvt_image_size'], alt: $data['fvt_image_alt'] ); ?>
            <?php elseif ( $data['fvt_video_enable'] ) : ?>
                <?php
                video(
                    url: $data['fvt_video_type'] === 'local' ? $data['fvt_video'] : '',
                    type: $data['fvt_video_type'],
                    loop: $data['fvt_video_loop'],
                    autoplay: $data['fvt_video_autoplay'],
                    mobile: $data['fvt_video_play_on_mobile'],
                    image: $data['fvt_image_enable'] ? $data['fvt_image'] : null,
                    alt: $data['fvt_image_alt'],
                    size: $data['fvt_image_size']
                );
                ?>
            <?php endif; ?>
        </div>
        <?php if ( $data['fvt_text_enable'] ) : ?>
            <div class="col-xs-12 col-md-4 text-in-md">
                <?php if ( ! empty( $data['fvt_title'] ) ) : ?>
                    <h2 class="heading-06"><?php echo esc_html( $data['fvt_title'] ); ?></h2>
                <?php endif; ?>
                <?php if ( ! empty( $data['fvt_text'] ) ) : ?>
                    <div class="text"><?php echo $data['fvt_text']; ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    $html = ob_get_clean();

    $args = array(
        'name'  => 'full-video-text',
        'html'  => $html,
        'fluid' => true,
    );

    $args = array_merge( $args, $config['module'] );

    ob_start();

    get_template_part( slug: 'template-parts/module', args: $args );

    return ob_get_clean();
}
