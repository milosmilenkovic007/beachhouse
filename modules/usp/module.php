<?php
/**
 * USP module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for USP module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_usp_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'red_background' => false,
		'title'          => '',
		'items'          => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();
	?>
	<div class="row">
		<div class="col-xs-12">
			<h2><?php echo esc_html( $data['title'] ); ?></h2>
			<div class="row">
				<?php foreach ( $data['items'] as $item ) : ?>
				<div class="col-sm-4">
					<?php if ( $item['title'] ) : ?>
					<h3 ng-if="column.sub_title" ><?php echo esc_html( $item['title'] ); ?></h3>
					<?php endif; ?>
					<div><?php echo $item['text']; ?></div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$container_classes = array(
		'md-usp',
	);

	if ( $data['red_background'] ) :
		$container_classes[] = 'red-background';
	endif;

	$args = array(
		'name'            => 'usp',
		'html'            => $html,
		'fluid'           => true,
		'container_class' => join( ' ', $container_classes ),
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
