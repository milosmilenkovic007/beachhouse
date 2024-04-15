<?php
/**
 * New CTA module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for New CTA module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_new_cta_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'url'    => '',
		'title'  => '',
		'target' => '',
		'center' => true,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$classes = array(
		'col-xs-12',
	);

	if ( $data['center'] ) :
		$classes[] = 'center-align';
	else :
		$classes[] = 'col-md-8 col-md-offset-4';
	endif;

	ob_start();

	?>
	<div class="row cta-buttons-module">
		<div <?php the_css_class( $classes ); ?>>
			<a class="btn-cta" <?php the_link_href( $data ); ?> <?php the_link_target( $data ); ?>><?php the_link_label( $data ); ?></a>
		</div>
	</div>
	<?php

	$html = ob_get_clean();

	$args = array(
		'name'  => 'new-cta',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
