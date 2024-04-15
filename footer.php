<?php
/**
 * The template for displaying the footer
 *
 * @package Milos
 * @subpackage Chriss
 */

$footer_left_content    = get_field( 'footer_left_content', 'options' );
$footer_right_content   = get_field( 'footer_right_content', 'options' );
$brand_name             = get_field( 'brand_name', 'options' );
$company_address        = get_field( 'company_address', 'options' );
$company_vat_no         = get_field( 'company_vat_no', 'options' );
$company_phone          = get_field( 'company_phone', 'options' );
$company_email          = get_field( 'company_email', 'options' );
$company_invoice_email  = get_field( 'company_invoice_email', 'options' );
$footer_social_linkedin = get_field( 'footer_social_linkedin', 'options' );
$footer_social_youtube  = get_field( 'footer_social_youtube', 'options' );

?>
		</div>
	</div>
	<footer id="footer" class="main-footer">
		<div class="container-fluid">
		<div class="row full">
    <?php if (!empty($footer_left_content['title']) && !empty($footer_left_content['text']) && !empty($footer_left_content['button']['url']) && !empty($footer_left_content['button']['title'])): ?>
        <div class="col-xs-12 col-md-6">
            <h2 class="heading-04"><?php echo $footer_left_content['title']; ?></h2>
            <div><?php echo $footer_left_content['text']; ?></div>
            <div class="btn-cta">
                <a href="<?php echo esc_url($footer_left_content['button']['url']); ?>" target="<?php echo esc_attr(!empty($footer_left_content['button']['target']) ? $footer_left_content['button']['target'] : '_self'); ?>"><?php echo $footer_left_content['button']['title']; ?></a>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($footer_right_content['title']) && !empty($footer_right_content['text']) && !empty($footer_right_content['button']['url']) && !empty($footer_right_content['button']['title'])): ?>
        <div class="col-xs-12 col-md-6">
            <h2 class="heading-04"><?php echo $footer_right_content['title']; ?></h2>
            <div><?php echo $footer_right_content['text']; ?></div>
            <div class="btn-cta">
                <a href="<?php echo esc_url($footer_right_content['button']['url']); ?>" target="<?php echo esc_attr(!empty($footer_right_content['button']['target']) ? $footer_right_content['button']['target'] : '_self'); ?>"><?php echo $footer_right_content['button']['title']; ?></a>
            </div>
        </div>
    <?php endif; ?>
</div>

			</div>
			<div class="row full footer-bottom">
				<div class="col-md-12">
					
					<?php if ( get_field( 'company_credit_rating', 'options' ) ) : ?>
						<a class="logo" target="_blank" href="<?php echo esc_url( get_field( 'company_credit_rating', 'options' ) ); ?>">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Chriss_logo.svg">
						</a>
					<?php endif; ?>

					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer_mobile_menu',
								'container'      => false,
								'menu_id'        => '',
								'menu_class'     => 'sub-link mobile',
								'fallback_cb'    => false,
							)
						);
						?>

<?php if (!empty(get_field('brand_name', 'options')) || !empty(get_field('company_address', 'options')) || !empty(get_field('company_vat_no', 'options')) || !empty(get_field('company_phone', 'options')) || !empty(get_field('company_email', 'options')) || !empty(get_field('company_invoice_email', 'options'))): ?>
    <div class="left-content">
        <?php if (!empty(get_field('brand_name', 'options'))): ?>
            <span class="brand"><?php echo get_field('brand_name', 'options'); ?></span>
        <?php endif; ?>

        <?php if (!empty(get_field('company_address', 'options'))): ?>
            <span class="address"><?php echo get_field('company_address', 'options'); ?></span>
        <?php endif; ?>

        <?php if (!empty(get_field('company_vat_no', 'options'))): ?>
            <span><?php _e('VAT no:', 'milos'); ?> <?php echo get_field('company_vat_no', 'options'); ?></span>
        <?php endif; ?>

        <?php if (!empty(get_field('company_phone', 'options'))): ?>
            <span><?php _e('Tel:', 'milos'); ?> <a href="tel:<?php echo esc_attr(get_field('company_phone', 'options')); ?>"><?php echo get_field('company_phone', 'options'); ?></a></span>
        <?php endif; ?>

        <?php if (!empty(get_field('company_email', 'options'))): ?>
            <span><?php _e('E-mail:', 'milos'); ?> <a href="mailto:<?php echo esc_attr(get_field('company_email', 'options')); ?>"><?php echo get_field('company_email', 'options'); ?></a></span>
        <?php endif; ?>

        <?php if (!empty(get_field('company_invoice_email', 'options'))): ?>
            <span><?php _e('Invoices:', 'milos'); ?> <a href="mailto:<?php echo esc_attr(get_field('company_invoice_email', 'options')); ?>"><?php echo get_field('company_invoice_email', 'options'); ?></a></span>
        <?php endif; ?>
    </div>
<?php endif; ?>


					<div class="right-content">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer_menu',
									'container'      => false,
									'menu_id'        => '',
									'menu_class'     => 'sub-link desktop',
									'fallback_cb'    => false,
								)
							);
							?>

						<?php if ( get_field( 'footer_social_linkedin', 'options' ) ) : ?>
							<span class="icon-linkedin">
								<a href="<?php echo esc_url( get_field( 'footer_social_linkedin', 'options' ) ); ?>">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkedin-logo.svg" alt="<?php echo esc_attr( sprintf( __( 'Connect to %1$s on Linkedin', 'milos' ), get_field( 'brand_name', 'options' ) ) ); ?>" />
								</a>
							</span>
						<?php endif; ?>
						<?php if ( get_field( 'footer_social_youtube', 'options' ) ) : ?>
							<span class="icon-youtube">
								<a href="<?php echo esc_url( get_field( 'footer_social_youtube', 'options' ) ); ?>">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/youtube-logo.svg" alt="<?php echo esc_attr( sprintf( __( 'Watch %1$s on Youtube', 'milos' ), get_field( 'brand_name', 'options' ) ) ); ?>" />
								</a>
							</span>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
