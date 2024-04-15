<?php
/**
 * Register additional menus.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Register Menus.
 *
 * @return void
 */
function register_theme_menus() {
	register_nav_menus(
		array(
			'header_menu'        => __( 'Header Menu', 'milos' ),
			'footer_menu'        => __( 'Footer Menu', 'milos' ),
			'footer_mobile_menu' => __( 'Footer Mobile Menu', 'milos' ),
		)
	);
}

add_action( 'after_setup_theme', 'register_theme_menus' );
