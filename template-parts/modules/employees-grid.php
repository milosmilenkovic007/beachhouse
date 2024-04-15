<?php
/**
 * Employees Grid module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$items = array();

$employee_ids = $args['employees_grid_items'];

if ( ! empty( $employee_ids ) ) :

	foreach ( $employee_ids as $employee_id ) :

		$items[] = new Employee( $employee_id );

	endforeach;

endif;

$config = array(
	'data'   => array(
		'title' => $args['employees_grid_title'],
		'items' => $items,
		'link'  => ! empty( $args['employees_grid_link'] ) ? $args['employees_grid_link'] : null,
	),
	'module' => get_module_settings( $args ),
);

echo generate_employees_grid_module( $config );
