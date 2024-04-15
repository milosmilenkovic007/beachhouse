<?php
/**
 * Template for hero for single employee page.
 *
 * @package Milos
 * @subpackage Chriss
 */

$employee = new Employee( get_the_ID() );

$classes = array(
	'module-hero',
	'module-hero-employee',
);

?>
<div <?php the_css_class( $classes ); ?>>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="wrapper wrap-list-em clearfix">
						<div class="col-md-6">
							<div class="portrait-3x4__wrapper">
							<?php super_img( image: $employee->get_image_id(), alt: $employee->get_name(), css_class: 'portrait-3x4', size: 'medium_large' ); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-in-md-thumb">
								<h1 class="heading-02"><?php echo esc_html( $employee->get_name() ); ?></h1>
								<div class="small-text">
									<div><?php echo esc_html( join( ' / ', $employee->get_positions() ) ); ?></div>
									<div><?php echo esc_html( join( ', ', $employee->get_offices() ) ); ?></div>
									<?php if ( $employee->get_phone() || $employee->get_email() ) : ?>
									<div class="bottom-text">
										<?php if ( $employee->get_phone() ) : ?>
										<div><?php _e( 'Tel.', 'milos' ); ?> <a href="tel:<?php echo esc_attr( $employee->get_phone() ); ?>" ><?php echo esc_html( $employee->get_phone() ); ?></a></div>
										<?php endif; ?>
										<?php if ( $employee->get_email() ) : ?>
										<div><a href="mailto:<?php echo esc_attr( $employee->get_email() ); ?>"><?php echo esc_html( $employee->get_email() ); ?></a></div>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
