<?php
/**
 * Form module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(),
	'module' => get_module_settings( $args ),
);

echo generate_form_module( $config );
