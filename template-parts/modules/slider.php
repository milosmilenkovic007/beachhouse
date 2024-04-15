<?php
/**
 * Slider module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'advanced'      => 'advanced' === $args['slider_type'],
		'vertical_text' => $args['slider_vertical_text'],
		'items'         => ! empty( $args['slider_items'] ) ? $args['slider_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_slider_module( $config );
