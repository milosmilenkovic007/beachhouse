<?php
/**
 * Services Grid module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Services Grid module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_services_grid_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'services' => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$services_groups = array_keys( $data['services'] );

	usort(
		$services_groups,
		function ( $a, $b ) {
			return strnatcasecmp( $a, $b );
		}
	);

	ob_start();
	?>
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1 groups">
			<?php
			foreach ( $services_groups as $index => $services_group ) :
				$service_group_items = $data['services'][ $services_group ];
				usort(
					$service_group_items,
					function ( $a, $b ) {
						return strnatcasecmp( $a->get_name(), $b->get_name() );
					}
				);
				?>
			<div class="group">
				<input type="checkbox" id="ydelser-group-<?php echo $index; ?>" <?php checked( $index, 0 ); ?>>
				<label for="ydelser-group-<?php echo $index; ?>"><?php echo $services_group; ?></label>
				<ul>
					<?php foreach ( $service_group_items as $service ) : ?>
						<?php $target = $service->is_external_url() ? 'target="_blank"' : ''; ?>
						<?php $href = $service->has_url() ? sprintf( 'href="%1$s"', esc_url( $service->get_url() ) ) : ''; ?>
					<li>
						<a <?php echo $href; ?> <?php echo $target; ?> >
							<span>
								<span><?php echo $service->get_name(); ?></span>
								<?php if ( $service->is_external_url() && $service->is_it34_url() ) : ?>
								<span class="tooltip"><?php _e( 'Opening new tab at our digital twin, IT34', 'milos' ); ?> <i class="redirect-icon"></i></span>
								<?php endif; ?>
							</span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'services-grid',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
