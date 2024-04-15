<?php
/**
 * Employees & Offices Finder module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'title'  => $args['finder_title'],
		'text'   => $args['finder_text'],
		'images' => $args['finder_items'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_employees_offices_finder_module( $config );
