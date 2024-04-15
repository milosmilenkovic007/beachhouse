<?php
/**
 * Includes all modules
 *
 * @package Milos
 * @subpackage Chriss
 */

foreach ( glob( THEME_MODULES_DIR . '/*/module.php' ) as $module_file ) :
	require_once $module_file;
endforeach;
