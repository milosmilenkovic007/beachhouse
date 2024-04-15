<?php
/**
 * Three Thumbs module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Three Thumbs module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_three_thumbs_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'items' => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();
	?>
	<div class="row">
		<?php foreach ( $data['items'] as $item ) : ?>
		<div class="thumb col-xs-12 col-md-4 mouseover">
			<?php if ( $item['link'] ) : ?>
			<a href="<?php echo esc_url( $item['link']['url'] ); ?>" <?php the_link_target( $item['link'] ); ?>>
			<?php endif; ?>
				<div class="wrap-img">
					<?php super_img( image: $item['image'], alt: $item['image_alt_text'], css_class: $item['image_size'] ); ?>
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
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'three-thumbs',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
