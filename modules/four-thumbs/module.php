<?php
/**
 * Four Thumbs module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Four Thumbs module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_four_thumbs_module( $config ) {

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
		<div class="col-xs-6 col-md-3">
			<?php if ( $item['link'] ) : ?>
			<a href="<?php echo esc_url( $item['link']['url'] ); ?>" <?php the_link_target( $item['link'] ); ?>>
			<?php endif; ?>
				<?php super_img( image: $item['image'], alt: $item['image_alt_text'], css_class: $item['image_size'] ); ?>
			<?php if ( $item['link'] ) : ?>
			</a>
			<?php endif; ?>
			<div class="text-in-md-thumb">
				<h2 class="heading-05"><?php echo esc_html( $item['title'] ); ?></h2>
				<div class="small-text">
					<div><?php echo esc_html( $item['subtitle'] ); ?></div>
					<div><?php echo $item['position']; ?></div>
					<div class="text"><?php echo $item['text']; ?></div>
					<?php if ( $item['phone'] || $item['email'] ) : ?>
					<div class="bottom-text">
						<?php if ( $item['phone'] ) : ?>
						<div><?php _e( 'Tel.', 'milos' ); ?> <?php echo esc_html( $item['phone'] ); ?></div>
						<?php endif; ?>
						<?php if ( $item['email'] ) : ?>
						<a href="mailto:<?php echo esc_attr( $item['email'] ); ?>"><?php echo esc_html( $item['email'] ); ?></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( $item['link'] ) : ?>
				<a class="link-cta" href="<?php echo esc_url( $item['link']['url'] ); ?>" <?php the_link_target( $item['link'] ); ?>><?php the_link_label( $item['link'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'four-thumbs',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
