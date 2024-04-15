<?php
/**
 * Image/Video Text module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Image/Video Text module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_image_video_text_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'fullwidth'            => false,
		'has_image'            => false,
		'image'                => false,
		'image_alt'            => '',
		'image_position'       => 'left',
		'image_size'           => 'landscape',
		'has_video'            => false,
		'video_type'           => '',
		'video_url'            => '',
		'video_loop'           => true,
		'video_autoplay'       => true,
		'video_play_on_mobile' => true,
		'has_text'             => false,
		'title'                => '',
		'text'                 => '',
		'text_position'        => '',
		'text_center_mobile'   => false,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	if ( $data['fullwidth'] ) :
		$data['image_position'] = '';
		$data['text_position']  = 'below-image';
	endif;

	$row_classes = array(
		'row',
	);

	$column_classes = array(
		'col-xs-12',
	);

	if ( $data['fullwidth'] ) :
		$row_classes[]    = 'column-12';
		$column_classes[] = 'col-md-12';
	else :
		$column_classes[] = 'col-md-8';
	endif;

	if ( $data['text_center_mobile'] ) :
		$row_classes[] = 'text-center-mb';
	endif;

	if ( $data['image_position'] ) :
		$row_classes[] = 'image-' . $data['image_position'];
	endif;

	if ( $data['text_position'] ) :
		$row_classes[] = 'text-' . $data['text_position'];
	endif;

	ob_start();
	?>
	<div <?php the_css_class( $row_classes ); ?>>
		<div <?php the_css_class( $column_classes ); ?>>
		<?php if ( $data['has_image'] && ! $data['has_video'] ) : ?>
			<?php super_img( image: $data['image'], css_class: $data['image_size'], alt: $data['image_alt'] ); ?>
		<?php elseif ( $data['has_video'] ) : ?>
			<?php
			video(
				url: $data['video_url'],
				type: $data['video_type'],
				loop: $data['video_loop'],
				autoplay: $data['video_autoplay'],
				mobile: $data['video_play_on_mobile'],
				image: $data['has_image'] ? $data['image'] : null,
				alt: $data['image_alt'],
				size: $data['image_size']
			);
			?>
		<?php endif; ?>
		</div>
		<?php if ( $data['has_text'] ) : ?>
		<div class="col-xs-12 col-md-4 text-in-md">
			<?php if ( $data['title'] ) : ?>
			<h2 class="heading-06"><?php echo esc_html( $data['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( $data['text'] ) : ?>
			<div class="text"><?php echo $data['text']; ?></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'image-video-text',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
