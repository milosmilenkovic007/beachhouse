<?php
/**
 * Template for hero for single office page.
 *
 * @package Milos
 * @subpackage Chriss
 */

$office = new Office( get_the_ID() );

$title = get_field( 'hero_title' );
if ( ! $title ) :
	$title = $office->get_name();
endif;

$text          = get_field( 'hero_text' );
$vertical_text = get_field( 'hero_vertical_text' );

$classes = array(
	'module-hero',
	'module-hero-office',
);

$contact_post_id    = get_field( 'contact_page', 'options' );
$contact_post_title = get_the_title( $contact_post_id );

?>
<div <?php the_css_class( $classes ); ?>>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="wrapper">
						<h1 class="heading-01"><?php echo esc_html( $title ); ?></h1>
						<h2 class="heading-04"><?php echo esc_html( $contact_post_title ); ?></h2>
						<?php echo $text; ?>
						<?php if ( $office->get_map_url() ) : ?>
						<a class="address" href="<?php echo esc_url( $office->get_map_url() ); ?>" target="_blank"><?php echo esc_html( $office->get_address() ); ?></a>
						<?php else : ?>
						<p class="address"><?php echo esc_html( $office->get_address() ); ?></p>
						<?php endif; ?>
						<?php if ( $office->get_email() || $office->get_phone() ) : ?>
						<p class="mail-tel">
							<?php if ( $office->get_email() ) : ?>
								<a href="mailto:<?php echo esc_attr( $office->get_email() ); ?>"><?php echo esc_html( $office->get_email() ); ?></a>
							<?php endif; ?>
							<?php if ( $office->get_phone() ) : ?>
								<a href="tel:<?php echo esc_attr( $office->get_phone() ); ?>"><?php _e( 'Tel.', 'milos' ); ?> <?php echo esc_html( $office->get_phone() ); ?></a>
							<?php endif; ?>
						</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if ( $vertical_text ) : ?>
			<a href="javascript:void(0);" class="show-the-road" ><?php echo esc_html( $vertical_text ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
