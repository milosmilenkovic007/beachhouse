<?php
/**
 * Enqueue CSS & JS
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Enqueue theme's CSS & JS
 *
 * @return void
 */
function enqueue_theme_assets() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css', array(), $theme_version, 'all' );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $theme_version, true );
	wp_localize_script(
		'main',
		'ThemeConfig',
		array(
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			'redirectPopup' => array(
				'header' => __( 'Don\'t worry. You\'ll stay right here.', 'milos' ),
				'title'  => __( 'Opening new tab at our digital twin, IT34', 'milos' ),
			),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_assets' );

/**
 * Enqueue admin's CSS & JS
 *
 * @return void
 */
function enqueue_admin_assets() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'admin', get_template_directory_uri() . '/admin_assets/css/admin.css', array(), $theme_version, 'all' );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/admin_assets/js/admin.js', array( 'jquery' ), $theme_version, true );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_assets' );
