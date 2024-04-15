<?php
/**
 * Template for hero_type = landing.
 *
 * @package Milos
 * @subpackage Chriss
 */

$title         = get_field( 'hero_title' );
$text          = get_field( 'hero_text' );
$hero_link     = get_field( 'hero_link' );
$vertical_text = get_field( 'hero_vertical_text' );

$classes = array(
    'module-hero',
    'module-hero-standard',
);

$is_narrow = get_field( 'hero_is_narrow' );
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
                            <?php if ( $hero_link ) : ?>
                                <a class="btn-cta" href="<?php echo esc_url( $hero_link['url'] ); ?>" target="<?php echo ! empty( $hero_link['target'] ) ? $hero_link['target'] : '_self'; ?>" ><?php echo esc_html( $hero_link['title'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="show-the-road"><?php echo esc_html( $vertical_text ); ?></a>
            </div>
        </div>
    </div>
</div>
