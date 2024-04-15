<?php
/**
 * Four Thumbs module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'items' => ! empty( $args['four_thumbs_items'] ) ? $args['four_thumbs_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_four_thumbs_module( $config );
