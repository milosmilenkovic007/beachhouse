<?php
/**
 * USP module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'red_background' => $args['usp_red_background'],
		'title'          => $args['usp_title'],
		'items'          => ! empty( $args['usp_items'] ) ? $args['usp_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_usp_module( $config );
