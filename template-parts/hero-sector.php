<?php
/**
 * Template for hero for single sector page.
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

$classes = array(
	'module-hero',
	'module-hero-sector',
);

$sectors_post_id    = get_field( 'sectors_page', 'options' );
$sectors_post_title = get_the_title( $sectors_post_id );

?>
<div <?php the_css_class( $classes ); ?>>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="wrapper">
						<h1 class="heading-01"><?php echo esc_html( $title ); ?></h1>
						<h2 class="heading-04"><?php echo esc_html( $sectors_post_title ); ?></h2>
						<?php echo $text; ?>
					</div>
				</div>
			</div>
			<?php if ( $vertical_text ) : ?>
			<a href="javascript:void(0);" class="show-the-road" ><?php echo esc_html( $vertical_text ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>
