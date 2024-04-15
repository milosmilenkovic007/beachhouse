<?php
/**
 * CTA Contact module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for CTA Contact module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_cta_contact_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title'    => '',
		'subtitle' => '',
		'image'    => array(),
		'button'   => array(
			'url'    => '',
			'title'  => '',
			'target' => '',
		),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();

	?>
	<div class="title-wrap-rotate">
		<h2><?php echo esc_html( $data['title'] ); ?></h2>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-sm-offset-2">
			<div class="row">
				<div class="col-sm-4 col-sm-push-8">
				<?php super_img( image: $data['image'], css_class: 'portrait-3x4' ); ?>
				</div>
				<div class="col-sm-6 col-sm-pull-4">
					<?php if ( $data['subtitle'] ) : ?>
					<h3><?php echo esc_html( $data['subtitle'] ); ?></h3>
					<?php endif; ?>
					<?php if ( $data['text'] ) : ?>
					<div class="wrap-desc"><?php echo $data['text']; ?></div>
					<?php endif; ?>
					<a class="btn-cta" <?php the_link_href( $data['button'] ); ?> <?php the_link_target( $data['button'] ); ?>> <?php the_link_label( $data['button'] ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php

	$html = ob_get_clean();

	$args = array(
		'name'            => 'cta-contact',
		'html'            => $html,
		'fluid'           => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
