<?php
/**
 * Two Thumbs module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'align' => $args['two_thumb_align'],
		'items' => ! empty( $args['two_thumbs_items'] ) ? $args['two_thumbs_items'] : array(),
	),
	'module' => get_module_settings( $args ),
);

echo generate_two_thumbs_module( $config );
