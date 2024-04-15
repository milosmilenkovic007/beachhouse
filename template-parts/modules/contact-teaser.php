<?php
/**
 * Contact Teaser module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		
		'title' => $args['contact_teaser_title'],
		'text'  => $args['contact_teaser_text'],
		'image' => $args['contact_teaser_image'],
		'link'  => $args['contact_teaser_link'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_contact_teaser_module( $config );