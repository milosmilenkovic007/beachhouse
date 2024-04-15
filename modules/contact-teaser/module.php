<?php
/**
 * Contact Teaser module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Contact Teaser module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_contact_teaser_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title' => '',
		'text'  => '',
		'image' => '',
		'link'  => null,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();
	?>
	<div class="row">
		<div class="col-md-8 col-md-offset-4">
			<div class="background-box">
				<div class="wrap-img">
					<?php super_img( image: $data['image'], css_class: 'portrait-3x4' ); ?>
				</div>
				<div class="description" >
					<h3><?php echo esc_html( $data['title'] ); ?></h3>
					<div><?php echo $data['text']; ?></div>
					<?php if ( $data['link'] ) : ?>
					<a class="link-cta" <?php the_link_href( $data['link'] ); ?> <?php the_link_target( $data['link'] ); ?>><?php the_link_label( $data['link'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'contact-teaser',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
