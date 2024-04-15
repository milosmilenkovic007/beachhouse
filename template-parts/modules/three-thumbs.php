<?php
/**
 * Three Thumbs module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'items' => ! empty( $args['three_thumbs_items'] ) ? $args['three_thumbs_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_three_thumbs_module( $config );
