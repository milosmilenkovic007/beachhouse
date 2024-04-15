<?php
/**
 * Employees Grid module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Employees Grid module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_employees_grid_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title' => '',
		'image' => null,
		'items' => array(),
		'link'  => null,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();
	?>
	<div class="title-wrap-rotate">
		<h2><?php echo esc_html( $data['title'] ); ?></h2>
	</div>

	<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-2">
        <div class="row people">
            <?php foreach ( $data['items'] as $employee ) : ?>
                <div class="person col-xs-6 col-sm-4 col-md-3">
                    <div class="person-inner">
                        <?php the_image( $employee->get_image_id(), 'medium-large', $employee->get_name() ); ?>
                        <div class="text-in-md-thumb">
                            <h3 class="heading-05"><?php echo esc_html( $employee->get_name() ); ?></h3>
                            <div class="small-text">
                                <div><?php echo esc_html( join( ' / ', $employee->get_positions() ) ); ?></div>
                                <div><?php echo esc_html( join( ', ', $employee->get_offices() ) ); ?></div>
                                <?php if ( $employee->get_phone() || $employee->get_email() ) : ?>
                                    <div class="bottom-text">
                                        <?php if ( $employee->get_phone() ) : ?>
                                            <div><?php _e( 'Tel.', 'milos' ); ?> <a href="tel:<?php echo esc_attr( $employee->get_phone() ); ?>"><?php echo esc_html( $employee->get_phone() ); ?></a></div>
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
                <div class="about-side col-md-8">
				<?php echo $employee->get_about(); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ( $data['link'] ) : ?>
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn-cta employee-active-btn" <?php the_link_href( $data['link'] ); ?> <?php the_link_target( $data['link'] ); ?>><?php the_link_label( $data['link'] ); ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'employees-grid',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
