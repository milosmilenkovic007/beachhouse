<?php
/**
 * Template for hero_type = landing.
 *
 * @package Milos
 * @subpackage Chriss
 */

$title         = get_field( 'hero_title' );
$text          = get_field( 'hero_text' );
$link          = get_field( 'hero_link' );
$vertical_text = get_field( 'hero_vertical_text' );
$slides        = ! empty( get_field( 'hero_slides' ) ) ? get_field( 'hero_slides' ) : array();
$random_slide  = $slides[ rand( 0, count( $slides ) - 1 ) ] ?? array();
$image         = $random_slide['image'] ?? null;
$video         = $random_slide['video'] ?? null;
?>
<div class="module-hero module-hero-landing">
	<div class="fixed-block">
		<?php super_img( image: $image, video: $video ); ?>
	</div>
	<div class="container-fluid module-hero-text">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="wrapper">
							<h1 class="heading-01"><?php echo esc_html( $title ); ?></h1>
							<?php echo $text; ?>
							<?php if ( $link ) : ?>
								<a class="btn-cta" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo ! empty( $link['target'] ) ? $link['target'] : '_self'; ?>" ><?php echo esc_html( $link['title'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php if ( $vertical_text ) : ?>
				<a href="javascript:void(0);" class="show-the-road"><?php echo esc_html( $vertical_text ); ?></a>
				<?php endif; ?>
				<span class="wrapper-icon-arrow">
					<i class="icon-arrow down"></i>
				</span>
			</div>
		</div>
	</div>
</div>
