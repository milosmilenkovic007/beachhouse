<?php
/**
 * _module_title_ module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(),
	'module' => get_module_settings( $args ),
);

echo generate__module_id__module( $config );
