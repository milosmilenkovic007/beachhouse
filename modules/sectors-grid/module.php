<?php
/**
 * Sectors Grid module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Sectors Grid module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_sectors_grid_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'sectors' => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();
	?>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<ul class="services-list row">
				<?php foreach ( $data['sectors'] as $sector ) : ?>
					<?php $target = $sector->is_external_url() ? 'target="_blank"' : ''; ?>
				<li class="service col-sm-4 col-xs-12">

					<a href="<?php echo esc_url( $sector->get_url() ); ?>" <?php echo $target; ?>>
						<div class="icons-service"><?php echo $sector->get_icon_svg(); ?></div>
						<div>
							<h2 class="heading-04">
								<span>
									<title><?php echo esc_html( $sector->get_name() ); ?></title>
									<?php if ( $sector->is_external_url() && $sector->is_it34_url() ) : ?>
									<span class="tooltip"><?php _e( 'Opening new tab at our digital twin, IT34', 'milos' ); ?> <i class="redirect-icon"></i></span>
									<?php endif; ?>
								</span>
							</h2>
							<div><?php echo $sector->get_teaser_text(); ?></div>
						</div>
					</a>

				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'sectors-grid',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
