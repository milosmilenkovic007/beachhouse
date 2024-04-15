<?php
/**
 * Template for hero_type = contact.
 *
 * @package Milos
 * @subpackage Chriss
 */

$title = get_field( 'hero_title' );
if ( ! $title ) :
	$title = get_the_title();
endif;

$text          = get_field( 'hero_text' );
$vertical_text = get_field( 'hero_vertical_text' );
$is_narrow     = get_field( 'hero_is_narrow' );
$phone         = get_field( 'hero_phone' );
$email         = get_field( 'hero_email' );
$opening_hours = get_field( 'hero_opening_hours' );

$classes = array(
	'module-hero',
	'module-hero-contact',
);

if ( $is_narrow ) :
	$classes[] = 'module-hero-narrow';
endif;

?>
<div <?php the_css_class( $classes ); ?>>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-offset-2 col-sm-8">
						<div class="wrapper">
							<h1 class="heading-01"><?php echo esc_html( $title ); ?></h1>
							<?php echo $text; ?>
							<div class="mail-tel">
								<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?> &nbsp;</a>
								<span class="hidden-mobile"><?php _e( 'Tel', 'milos' ); ?> <?php echo esc_attr( $phone ); ?></span>
								<a ng-href="tel:<?php echo esc_attr( $phone ); ?>" class="hidden-desktop" >&nbsp; <?php _e( 'Tel', 'milos' ); ?> <?php echo esc_html( $phone ); ?></a>
							</div>
							<div class="hour"><?php echo $opening_hours; ?></div>
						</div>
					</div>
				</div>
				<a href="javascript:void(0);" class="show-the-road"><?php echo esc_html( $vertical_text ); ?></a>
			</div>
		</div>
	</div>
</div>
