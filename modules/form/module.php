<?php
/**
 * Form module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Form module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_form_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array();

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();

	// module's html here.

	$html = ob_get_clean();

	$args = array(
		'name'  => 'form',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
