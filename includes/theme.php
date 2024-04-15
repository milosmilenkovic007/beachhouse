<?php
/**
 * Theme customizations
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Setup theme supports
 *
 * @return void
 */
function setup_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	remove_post_type_support( 'page', 'editor' );
}

add_action( 'after_setup_theme', 'setup_theme_support' );

/**
 * Remove new lines from the menu's html.
 *
 * @param  array $nav_menu Generated menu's HTML.
 * @return array
 */
function remove_new_lines_from_nav_menu_html( $nav_menu ) {
	$nav_menu = preg_replace( "#\n#", '', $nav_menu );
	$nav_menu = preg_replace( '#class="[^"]*current-menu-item[^"]*"#', 'class="active"', $nav_menu );
	$nav_menu = preg_replace( '# class="menu-item [^"]*"#', '', $nav_menu );
	$nav_menu = preg_replace( '# id="[^"]*"#', '', $nav_menu );
	$nav_menu = preg_replace( '# class=""#', '', $nav_menu );
	return $nav_menu;
}

add_filter( 'wp_nav_menu', 'remove_new_lines_from_nav_menu_html' );

add_action(
	'admin_head',
	function () {
		?>
	<style>
		.menu-icon-office > .wp-menu-image:before,
		.menu-icon-employee > .wp-menu-image:before,
		.menu-icon-sector > .wp-menu-image:before,
		.menu-icon-feedback > .wp-menu-image:before,
		.menu-icon-service > .wp-menu-image:before,
		.menu-icon-project > .wp-menu-image:before {
			content: '';
			width: 20px;
			height: 20px;
			background-position: center center;
			background-repeat: no-repeat;
			background-size: contain;
		}

		.menu-icon-office > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/office.svg);
		}

		.menu-icon-project > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/project.svg);
		}

		.menu-icon-employee > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/employee.svg);
		}

		.menu-icon-sector > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/sector.svg);
		}

		.menu-icon-feedback > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/feedback.svg);
		}

		.menu-icon-service > .wp-menu-image:before {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/service.svg);
		}
	</style>
		<?php
	}
);

/**
 * Hiding POST post type.
 *
 * @param  array  $args Post type register arguments.
 * @param  string $post_type Name of the post type.
 * @return array $args
 */
function remove_default_post_type( $args, $post_type ) {

	if ( 'post' === $post_type ) {
		$args['public']              = false;
		$args['show_ui']             = false;
		$args['show_in_menu']        = false;
		$args['show_in_admin_bar']   = false;
		$args['show_in_nav_menus']   = false;
		$args['can_export']          = false;
		$args['has_archive']         = false;
		$args['exclude_from_search'] = true;
		$args['publicly_queryable']  = false;
		$args['show_in_rest']        = false;
	}

	return $args;
}

add_filter( 'register_post_type_args', 'remove_default_post_type', 0, 2 );

/**
 * Output class attribute for HTML element. Similar to body_class function.
 *
 * @return void
 */
function html_class() {

	$classes = array(
		'no-js',
	);

	echo 'class="' . join( ' ', apply_filters( 'html_class', $classes ) ) . '"';
}

/**
 * Add additional html classes.
 *
 * @param  array $classes Array of css classes.
 * @return array $classes
 */
function add_additional_html_classes( $classes ) {

	if ( get_hero_type() === 'landing' ) :
		$classes[] = 'landing-page';
	endif;

	return $classes;
}

add_filter( 'html_class', 'add_additional_html_classes' );

/**
 * Buffer output so that we can replace special characters
 *
 * @return void
 */
function start_buffering() {
	ob_start();
}

add_action( 'wp_head', 'start_buffering', PHP_INT_MIN );

/**
 * Output buffer
 *
 * @return void
 */
function output_buffer() {
	echo replace_special_chars( ob_get_clean() );
}

add_action( 'wp_footer', 'output_buffer', PHP_INT_MAX );
