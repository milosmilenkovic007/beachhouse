<?php
/**
 * Sectors Grid module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$sectors = array();

$sector_ids = $args['sectors_grid_items'];

if ( ! empty( $sector_ids ) ) :
	$sectors = array_map( 'Sector::get_instance', $sector_ids );
endif;

$config = array(
	'data'   => array(
		'sectors' => $sectors,
	),
	'module' => get_module_settings( $args ),
);

echo generate_sectors_grid_module( $config );
