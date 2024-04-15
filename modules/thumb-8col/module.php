<?php
/**
 * Thumb 8 col module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Thumb 8 col module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_thumb_8col_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'grey_background'      => false,
		'has_image'            => false,
		'image'                => false,
		'image_alt'            => '',
		'image_align'          => 'left',
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
		'link'                 => null,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$image_column_classes = array(
		'col-xs-12',
		'col-md-8',
	);

	$text_column_classes = array(
		'col-xs-12',
		'wrap-text',
	);

	if ( 'center' === $data['image_align'] ) :
		$image_column_classes[] = 'col-md-offset-2';
		$text_column_classes[]  = 'col-md-8';
		$text_column_classes[]  = 'col-md-offset-2';
	else :
		$text_column_classes[] = 'col-md-4';
	endif;

	ob_start();
	?>
	<div class="row">
		<div <?php the_css_class( $image_column_classes ); ?>>
			<?php if ( $data['has_image'] && ! $data['has_video'] ) : ?>
				<?php 
                    // Check if $data['image'] is an array before accessing it
                    if ( is_array( $data['image'] ) ) {
                        super_img( image: $data['image'], css_class: $data['image_size'], alt: $data['image_alt'] );
                    }
                ?>
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
		<div <?php the_css_class( $text_column_classes ); ?>>
			<div class="text-in-md-thumb">
			<?php if ( $data['title'] ) : ?>
				<h2 class="heading-05"><?php echo esc_html( $data['title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( $data['text'] ) : ?>
				<div class="text"><?php echo $data['text']; ?></div>
			<?php endif; ?>
			<?php if ( $data['link'] ) : ?>
				<a class="link-cta" <?php the_link_href( $data['link'] ); ?> <?php the_link_target( $data['link'] ); ?>><?php the_link_label( $data['link'] ); ?></a>
			<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'            => 'thumb-8col',
		'html'            => $html,
		'fluid'           => true,
		'container_class' => $data['grey_background'] ? 'bg-gray' : '',
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
