<?php
/**
 * Big Small Thumbs module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Big Small Thumbs module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_big_small_thumbs_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'grey_background' => false,
		'align'           => 'top',
		'items'           => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$classes = array(
		'row',
		'align-' . $data['align'],
	);
	ob_start();
	?>
	<div <?php the_css_class( $classes ); ?>>
		<?php foreach ( $data['items'] as $index => $item ) : ?>
		<div class="col-xs-12 col-md-6">
			<?php super_img( image: $item['image'], alt: $item['image_alt_text'], css_class: 0 === $index ? 'square' : 'landscape' ); ?>
			<?php if ( $item['title'] || $item['text'] || $item['link'] ) : ?>
			<div class="text-in-md-thumb">
				<?php if ( $item['title'] ) : ?>
				<h5><?php echo esc_html( $item['title'] ); ?></h5>
				<?php endif; ?>
				<?php if ( $item['text'] ) : ?>
				<div class="text"><?php echo $item['text']; ?></div>
				<?php endif; ?>
				<?php if ( $item['link'] ) : ?>
				<a class="link-cta" <?php the_link_href( $item['link'] ); ?> <?php the_link_target( $item['link'] ); ?>><?php the_link_label( $item['link'] ); ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'            => 'big-small-thumbs',
		'html'            => $html,
		'fluid'           => true,
		'container_class' => $data['grey_background'] ? 'bg-gray' : '',
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
