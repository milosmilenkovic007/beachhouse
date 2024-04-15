<?php
/**
 * Office Employees module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$title = $args['office_employees_title'];
$link  = $args['office_employees_link'];
$items = get_office_employees( get_the_ID() );

if ( ! $link && get_field( 'contact_page', 'options' ) ) :
	$link = array(
		'title'  => __( 'View All', 'milos' ),
		'url'    => get_permalink( get_field( 'contact_page', 'options' ) ),
		'target' => '',
	);
endif;

$config = array(
	'data'   => array(
		'title' => $title,
		'link'  => $link,
		'items' => $items,
	),
	'module' => get_module_settings( $args ),
);

echo generate_office_employees_module( $config );
