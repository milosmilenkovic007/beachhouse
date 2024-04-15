<?php
/**
 * Full Viewport Image module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'image'     => $args['fvi_image'],
		'image_alt' => $args['fvi_image_alt'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_full_viewport_image_module( $config );
