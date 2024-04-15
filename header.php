<?php
/**
 * The header.
 *
 * @package Milos
 * @subpackage Chriss
 */

$translations = get_current_post_languages();
?>
<!DOCTYPE html>
<html <?php html_class(); ?> <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<!-- ****** Favicon ****** -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/site.webmanifest">
<link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/favicon.ico">
<meta name="apple-mobile-web-app-title" content="Beach House Entertaiment">
<meta name="application-name" content="Beach House Entertaiment">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
	<!-- ****** Favicon ****** -->
	<meta name="msapplication-tap-highlight" content="no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<?php wp_body_open(); ?>
<header id="header" class="main-header">
	<a href="<?php echo esc_url( get_home_url() ); ?>" class="logo">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/The-Beach-House-Entertainment.svg" />
	</a>

	<div class="wrap-icon-burger">
		<span class="icon-burger">
			<span></span>
			<span></span>
			<span></span>
		</span>
		<span class="icon-close"></span>
	</div>
	<div class="mask-menu"></div>
	<nav>
		<a class="logo" >
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/The-Beach-House-Entertainment.svg" />
		</a>
		
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'header_menu',
				'container'      => false,
				'menu_id'        => '',
				'menu_class'     => '',
				'fallback_cb'    => false,
			)
		);
		?>

		
	</nav>

	
			
		</div>

	
</header>

<div id="page" >
	<div class="main-content">
		<div class="page-content">
		<?php get_template_part( 'template-parts/hero', get_hero_type() ); ?>
