<?php
/**
 * Double Image or Video module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Double Image or Video module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_double_video_image_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title'                      => '',
		'text'                       => '',
		'left_image'                 => null,
		'left_image_alt'             => '',
		'left_image_align'           => 'top',
		'left_image_size'            => 'landscape',
		'right_image'                => null,
		'right_image_alt'            => '',
		'right_image_size'           => '',
		'right_video_type'           => 'local',
		'right_video_url'            => '',
		'right_video_autoplay'       => false,
		'right_video_loop'           => true,
		'right_video_play_on_mobile' => true,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$row_classes = array(
		'row',
	);

	$first_column_classes = array(
		'col-xs-12',
		'col-md-4',
	);

	if ( 'bottom' === $data['left_image_align'] ) :
		$row_classes[] = 'img-align-bottom';
	endif;

	if ( $data['left_image'] ) :
		$first_column_classes[] = 'has-content';
	endif;

	$video_attributes = array(
		'autoplay',
		'muted',
		'playsinline',
	);

	if ( $data['right_video_loop'] ) :
		$video_attributes[] = 'loop';
	endif;

	ob_start();
	?>
	<div <?php the_css_class( $row_classes ); ?>>
		<div <?php the_css_class( $first_column_classes ); ?>>
			<?php if ( 'top' === $data['left_image_align'] ) : ?>
			<div>
				<?php
				if ( $data['left_image'] ) :
					super_img( image: $data['left_image'], alt: $data['left_image_alt'], css_class: $data['left_image_size'] );
				endif;
				?>
				<?php if ( $data['title'] || $data['text'] ) : ?>
				<div class="text-in-md">
					<h2 class="heading-06"><?php echo esc_html( $data['title'] ); ?></h2>
					<p><?php echo esc_html( $data['text'] ); ?></p>
				</div>
				<?php endif; ?>
			</div>
			<?php else : ?>
			<div>
				<?php if ( $data['title'] || $data['text'] ) : ?>
				<div class="text-in-md">
					<h2 class="heading-06"><?php echo esc_html( $data['title'] ); ?></h2>
					<p><?php echo esc_html( $data['text'] ); ?></p>
				</div>
				<?php endif; ?>
				<?php
				if ( $data['left_image'] ) :
					super_img( image: $data['left_image'], alt: $data['left_image_alt'], css_class: $data['left_image_size'] );
				endif;
				?>
			</div>
			<?php endif; ?>
		</div>

		<div class="col-xs-12 col-md-8">

			<?php if ( ! $data['right_video_url'] ) : ?>
				<?php if ( $data['right_image'] ) : ?>
				<div><?php super_img( image: $data['right_image'], alt: $data['right_image_alt'], css_class: $data['right_image_size'] ); ?></div>
				<?php endif; ?>
			<?php else : ?>
			<div>
				<?php
				video(
					url: $data['right_video_url'],
					type: $data['right_video_type'],
					loop: $data['right_video_loop'],
					autoplay: $data['right_video_autoplay'],
					mobile: $data['right_video_play_on_mobile'],
					image: $data['right_image'],
					alt: $data['right_image_alt'],
					size: $data['right_image_size']
				);
				?>
			</div>
			<?php endif; ?>

		</div>
				<?php if ( $data['title'] || $data['text'] ) : ?>
		<div class="col-xs-12 col-md-4 text-in-md">
			<h2 class="heading-06"><?php echo esc_html( $data['title'] ); ?></h2>
			<p><?php echo esc_html( $data['text'] ); ?></p>
		</div>
		<?php endif; ?>
	</div>
				<?php
				$html = ob_get_clean();

				$args = array(
					'name'  => 'double-video-image',
					'html'  => $html,
					'fluid' => true,
				);

				$args = array_merge( $args, $config['module'] );

				ob_start();

				get_template_part( slug: 'template-parts/module', args: $args );

				return ob_get_clean();
}
