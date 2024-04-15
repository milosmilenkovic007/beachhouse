<?php
/**
 * Big Small Thumbs module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'grey_background' => boolval( $args['big_small_thumbs_grey_background'] ),
		'align'           => $args['big_small_thumbs_align'],
		'items'           => ! empty( $args['big_small_thumbs_items'] ) ? $args['big_small_thumbs_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_big_small_thumbs_module( $config );
