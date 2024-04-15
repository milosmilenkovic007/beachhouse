<?php
/**
 * Slider module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Slider module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_slider_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'advanced'      => false,
		'vertical_text' => '',
		'items'         => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$items = array();

	foreach ( $data['items'] as $item ) :

		$items[] = array(
			'image'         => $item['image'],
			'alt'           => ! empty( $item['image_alt_text'] ) ? $item['image_alt_text'] : $item['image']['alt'],
			'title'         => $item['title'],
			'link'          => ! empty( $item['link'] ) ? $item['link'] : '',
		);

	endforeach;

	$total_items = count( $items );

	$css_classes = array(
		'carousel',
	);

	if ( $data['advanced'] ) :
		$css_classes[] = 'advanced';
	endif;

	ob_start();
	?>
	<div <?php the_css_class( $css_classes ); ?>>
		<div class="wrap-vertical-text" >
			<span class="vertical-text" ><?php echo esc_html( $data['vertical_text'] ); ?></span>

			<div class="control-slider">
				<div class="control-slider-btn control-slider-prev">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-arrow-white-down.png" alt="">
				</div>
				<div class="control-slider-btn control-slider-next">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slider-arrow-white-up.png" alt="">
				</div>
			</div>
		</div>
		<div class="wrapper-slider" >
			<div class="wrapper-scroll">
				<div class="scroller">
					<?php foreach ( $items as $index => $item ) : ?>
					<div class="item mouseover">
						<div class="space-active"></div>
						<div class="inner">
							<div class="counter-slider">
								<div class="slide-current"><?php echo str_pad( string: strval( $index + 1 ), length: 2, pad_type: STR_PAD_LEFT ); ?></div>
								<span>/</span>
								<div class="slide-all"><?php echo str_pad( string: strval( $total_items ), length: 2, pad_type: STR_PAD_LEFT ); ?></div>
							</div>

							<?php if ( $item['link'] ) : ?>
							<a <?php the_link_href( $item['link'] ); ?> <?php the_link_target( $item['link'] ); ?>>
							<?php endif; ?>
								<div class="wrap-img">
								<?php super_img( image: $item['image'], alt: $item['alt'], css_class: 'landscape' ); ?>
								</div>
							<?php if ( $item['link'] ) : ?>
							</a>
							<?php endif; ?>

							<?php if (!empty($item['title']) || !empty($item['text']) || !empty($item['link'])): ?>
    <div class="slider-description">
        <?php if (!empty($item['title'])): ?>
            <h3><?php echo esc_html($item['title']); ?></h3>
        <?php endif; ?>

        <?php if (!empty($item['text'])): ?>
            <p <?php echo $data['advanced'] ? 'class="has-margin"' : ''; ?>><?php echo $item['text']; ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>


							<div class="counter-slider">
								<div class="slide-current"><?php echo str_pad( string: strval( $index + 1 ), length: 2, pad_type: STR_PAD_LEFT ); ?></div>
								<span>/</span>
								<div class="slide-all"><?php echo str_pad( string: strval( $total_items ), length: 2, pad_type: STR_PAD_LEFT ); ?></div>
							</div>
						</div>

					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'slider',
		'html'  => $html,
		'fluid' => false,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}

