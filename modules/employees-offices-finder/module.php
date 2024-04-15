<?php
/**
 * Employees & Offices Finder module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Employees & Offices Finder module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_employees_offices_finder_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title'  => '',
		'text'   => '',
		'images' => array(),
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$offices   = get_offices();
	$employees = get_employees();

	$employees_names_letters = array();

	foreach ( $employees as $employee ) :

		$name_parts = array_filter( preg_split( '#[ _-]#', strtolower( $employee->get_name() ) ) );

		foreach ( $name_parts as $name_part ) :

			$name_letters = mb_str_split( $name_part );

			if ( ! empty( $name_letters ) ) :

				$first_letter = $name_letters[0];

				if ( ! isset( $employees_names_letters[ $first_letter ] ) ) :

					$employees_names_letters[ $first_letter ] = 0;

				endif;

				$employees_names_letters[ $first_letter ] += 1;

			endif;

		endforeach;

	endforeach;

	$pagination_letters = 'abcdefghijklmnopqrstuvwxyz';

	$current_lang = apply_filters( 'wpml_current_language', null );

	switch ( $current_lang ) :
		case 'da':
			$pagination_letters .= 'æøå';
			break;
	endswitch;

	$pagination_array = mb_str_split( $pagination_letters );

	ob_start();
	?>
	<div class="row info-type-contact">
		<div class="col-xs-12 col-md-8 col-md-offset-2">
			<h2><?php echo esc_html( $data['title'] ); ?></h2>
			<p><?php echo $data['text']; ?></p>
			<div class="row filter-contact">
				<div class="office active" data-target="office"><?php _e( 'Find office', 'milos' ); ?></div>
				<div class="employee"  data-target="employee" ><?php _e( 'Find employee', 'milos' ); ?></div>

			</div>
		</div>
	</div>
	<div class="row list-item-contact list-office">
		<?php
		foreach ( $offices as $index => $office ) :
			$column_classes = array(
				'col-xs-12',
			);

			$column_classes[] = 'col-md-4';
			$column_classes[] = 'item-contact';
			?>
		<div <?php the_css_class( $column_classes ); ?> ng-class="{'col-md-4 item-contact': item.name, 'item-image': !item.name}">
			
			<a class="group" href="<?php echo esc_url( $office->get_url() ); ?>" >
				<div>
					<h3 class="heading-05"><?php echo esc_html( $office->get_name() ); ?></h3>
					<div><?php echo esc_html( $office->get_address() ); ?></div>
					<?php if ( $office->get_phone() ) : ?>
					<div ><?php _e( 'Tel.', 'milos' ); ?> <?php echo esc_html( $office->get_phone() ); ?></div>
					<?php endif; ?>
				</div>
			</a>

			<?php if ( $office->get_email() ) : ?>
			<a href="mailto:<?php echo esc_attr( $office->get_email() ); ?>"><?php echo esc_html( $office->get_email() ); ?></a>
			<?php endif; ?>
			<?php if ( $office->get_map_url() ) : ?>
			<div class="wrap-has-margin-top">
				<div>
					<a class="link-map" href="<?php echo esc_url( $office->get_map_url() ); ?>" target="_blank"><?php _e( 'View on map', 'milos' ); ?></a>
				</div>
			</div>
			<?php endif; ?>
			<!--
			<div ng-if="!item.name">
				<super-img image="item.src" class="landscape"></super-img>
			</div>
		-->
		</div>
		<?php endforeach; ?>
	</div>

	<div class="row  list-item-contact list-employee">
		<div class="col-xs-12 wrap-filter-alphabet">
			<div class="filter-alphabet">
				<p><span><?php _e( 'Filter', 'milos' ); ?></span> <?php _e( 'alphabetically', 'milos' ); ?>:</p>
				<ul>
				<?php
				foreach ( $pagination_array as  $index => $letter ) :

					$classes = array();

					if ( 0 === $index ) :
						$classes[] = 'active';
					endif;

					if ( ! isset( $employees_names_letters[ $letter ] ) ) :
						$classes[] = 'disabled';
					endif;

					printf(
						'<li %2$s>%1$s</li>',
						$letter,
						$classes ? 'class="' . join( ' ', $classes ) . '"' : ''
					);

				endforeach;
				?>
				</ul>
			</div>
		</div>
		<div class="wrap-list-em">
			<?php foreach ( $employees as $employee ) : ?>
			<div class="col-xs-6 col-md-3">
				<?php super_img( image: $employee->get_image_id(), alt: $employee->get_name(), css_class: 'portrait-3x4', size: 'medium_large' ); ?>
				<div class="text-in-md-thumb">
					<h3 class="heading-05"><?php echo esc_html( $employee->get_name() ); ?></h3>
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
			<?php endforeach; ?>
		</div>

		<div class="col-xs-12 wrap-filter-alphabet">
			<div class="filter-alphabet">
				<p><span><?php _e( 'Filter', 'milos' ); ?></span> <?php _e( 'alphabetically', 'milos' ); ?>:</p>
				<ul>
				<?php
				foreach ( $pagination_array as  $index => $letter ) :

					$classes = array();

					if ( 0 === $index ) :
						$classes[] = 'active';
					endif;

					if ( ! isset( $employees_names_letters[ $letter ] ) ) :
						$classes[] = 'disabled';
					endif;

					printf(
						'<li %2$s>%1$s</li>',
						$letter,
						$classes ? 'class="' . join( ' ', $classes ) . '"' : ''
					);

				endforeach;
				?>
				</ul>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	$args = array(
		'name'  => 'employees-offices-finder',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
