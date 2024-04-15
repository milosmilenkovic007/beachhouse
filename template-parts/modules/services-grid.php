<?php
/**
 * Services Grid module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$services = array();

foreach ( get_services( $args['service_grid_items'] ) as $service ) :

	$service_key = strtolower( substr( $service->get_name(), 0, 1 ) );

	if ( ! isset( $services[ $service_key ] ) ) :
		$services[ $service_key ] = array();
	endif;

	$services[ $service_key ][] = $service;

endforeach;

$config = array(
	'data'   => array(
		'services' => $services,
	),
	'module' => get_module_settings( $args ),
);

echo generate_services_grid_module( $config );
