<?php
/**
 * Custom post type registration & customizations
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Register Post Type Sector.
 *
 * @return void
 */
function post_type_sector() {

	$labels = array(
		'name'                     => __( 'Sectors', 'milos' ),
		'singular_name'            => __( 'Sector', 'milos' ),
		'add_new'                  => __( 'Add New', 'milos' ),
		'add_new_item'             => __( 'Add New Sector', 'milos' ),
		'edit_item'                => __( 'Edit Sector', 'milos' ),
		'new_item'                 => __( 'New Sector', 'milos' ),
		'view_item'                => __( 'View Sector', 'milos' ),
		'view_items'               => __( 'View Sectors', 'milos' ),
		'search_items'             => __( 'Search Sectors', 'milos' ),
		'not_found'                => __( 'No sectors found.', 'milos' ),
		'not_found_in_trash'       => __( 'No sectors found in Trash.', 'milos' ),
		'all_items'                => __( 'All Sectors', 'milos' ),
		'archives'                 => __( 'Sector Archives', 'milos' ),
		'attributes'               => __( 'Sector Attributes', 'milos' ),
		'insert_into_item'         => __( 'Insert into sector', 'milos' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this sector', 'milos' ),
		'featured_image'           => __( 'Featured Image', 'milos' ),
		'set_featured_image'       => __( 'Set featured image', 'milos' ),
		'remove_featured_image'    => __( 'Remove featured image', 'milos' ),
		'use_featured_image'       => __( 'Use as featured image', 'milos' ),
		'filter_items_list'        => __( 'Filter sectors list', 'milos' ),
		'items_list_navigation'    => __( 'Sectors list navigation', 'milos' ),
		'items_list'               => __( 'Sectors list', 'milos' ),
		'item_published'           => __( 'Sector published.', 'milos' ),
		'item_published_privately' => __( 'Sector published privately.', 'milos' ),
		'item_reverted_to_draft'   => __( 'Sector reverted to draft.', 'milos' ),
		'item_scheduled'           => __( 'Sector scheduled.', 'milos' ),
		'item_updated'             => __( 'Sector updated.', 'milos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'menu_icon'         => 'dashicons-format-aside',
		'show_in_nav_menus' => true,
		'menu_position'     => 5,
		'has_archive'       => false,
		'capability_type'   => 'page',
		'supports'          => array( 'title' ),
		'show_in_rest'      => false,
		'rewrite'           => array(
			'slug' => 'sector',
		),
	);

	// register_post_type( 'sector', $args );
}

add_action( 'init', 'post_type_sector' );

/**
 * Register Post Type Project.
 *
 * @return void
 */
function post_type_project() {

	$labels = array(
		'name'                     => __( 'Projects', 'milos' ),
		'singular_name'            => __( 'Project', 'milos' ),
		'add_new'                  => __( 'Add New', 'milos' ),
		'add_new_item'             => __( 'Add New Project', 'milos' ),
		'edit_item'                => __( 'Edit Project', 'milos' ),
		'new_item'                 => __( 'New Project', 'milos' ),
		'view_item'                => __( 'View Project', 'milos' ),
		'view_items'               => __( 'View Projects', 'milos' ),
		'search_items'             => __( 'Search Projects', 'milos' ),
		'not_found'                => __( 'No projects found.', 'milos' ),
		'not_found_in_trash'       => __( 'No projects found in Trash.', 'milos' ),
		'all_items'                => __( 'All Projects', 'milos' ),
		'archives'                 => __( 'Project Archives', 'milos' ),
		'attributes'               => __( 'Project Attributes', 'milos' ),
		'insert_into_item'         => __( 'Insert into project', 'milos' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this project', 'milos' ),
		'featured_image'           => __( 'Featured Image', 'milos' ),
		'set_featured_image'       => __( 'Set featured image', 'milos' ),
		'remove_featured_image'    => __( 'Remove featured image', 'milos' ),
		'use_featured_image'       => __( 'Use as featured image', 'milos' ),
		'filter_items_list'        => __( 'Filter projects list', 'milos' ),
		'items_list_navigation'    => __( 'Projects list navigation', 'milos' ),
		'items_list'               => __( 'Projects list', 'milos' ),
		'item_published'           => __( 'Project published.', 'milos' ),
		'item_published_privately' => __( 'Project published privately.', 'milos' ),
		'item_reverted_to_draft'   => __( 'Project reverted to draft.', 'milos' ),
		'item_scheduled'           => __( 'Project scheduled.', 'milos' ),
		'item_updated'             => __( 'Project updated.', 'milos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'menu_icon'         => 'dashicons-format-aside',
		'show_in_nav_menus' => true,
		'menu_position'     => 5,
		'has_archive'       => false,
		'capability_type'   => 'page',
		'supports'          => array( 'title', 'editor', 'thumbnail' ), // Updated supports array
		'show_in_rest'      => false,
		'rewrite'           => array(
			'slug' => 'project',
		),
	);

	register_post_type( 'project', $args );
}

add_action( 'init', 'post_type_project' );

/**
 * Register Post Type Employee.
 *
 * @return void
 */
function post_type_employee() {

	$labels = array(
		'name'                     => __( 'Employees', 'milos' ),
		'singular_name'            => __( 'Employee', 'milos' ),
		'add_new'                  => __( 'Add New', 'milos' ),
		'add_new_item'             => __( 'Add New Employee', 'milos' ),
		'edit_item'                => __( 'Edit Employee', 'milos' ),
		'new_item'                 => __( 'New Employee', 'milos' ),
		'view_item'                => __( 'View Employee', 'milos' ),
		'view_items'               => __( 'View Employees', 'milos' ),
		'search_items'             => __( 'Search Employees', 'milos' ),
		'not_found'                => __( 'No employees found.', 'milos' ),
		'not_found_in_trash'       => __( 'No employees found in Trash.', 'milos' ),
		'all_items'                => __( 'All Employees', 'milos' ),
		'archives'                 => __( 'Employee Archives', 'milos' ),
		'attributes'               => __( 'Employee Attributes', 'milos' ),
		'insert_into_item'         => __( 'Insert into employee', 'milos' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this employee', 'milos' ),
		'featured_image'           => __( 'Featured Image', 'milos' ),
		'set_featured_image'       => __( 'Set featured image', 'milos' ),
		'remove_featured_image'    => __( 'Remove featured image', 'milos' ),
		'use_featured_image'       => __( 'Use as featured image', 'milos' ),
		'filter_items_list'        => __( 'Filter employees list', 'milos' ),
		'items_list_navigation'    => __( 'Employees list navigation', 'milos' ),
		'items_list'               => __( 'Employees list', 'milos' ),
		'item_published'           => __( 'Employee published.', 'milos' ),
		'item_published_privately' => __( 'Employee published privately.', 'milos' ),
		'item_reverted_to_draft'   => __( 'Employee reverted to draft.', 'milos' ),
		'item_scheduled'           => __( 'Employee scheduled.', 'milos' ),
		'item_updated'             => __( 'Employee updated.', 'milos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'menu_icon'         => 'dashicons-format-aside',
		'show_in_nav_menus' => true,
		'menu_position'     => 5,
		'has_archive'       => false,
		'capability_type'   => 'page',
		'supports'          => array( 'title' ),
		'show_in_rest'      => false,
		'rewrite'           => array(
			'slug' => 'employee',
		),
	);

	register_post_type( 'employee', $args );
}

add_action( 'init', 'post_type_employee' );

/**
 * Register Taxonomy "Positions"
 *
 * @return void
 */
function taxonomy_employee_position() {

	$labels = array(
		'name'              => _x( 'Positions', 'taxonomy general name', 'milos' ),
		'singular_name'     => _x( 'Position', 'taxonomy singular name', 'milos' ),
		'search_items'      => __( 'Search Positions', 'milos' ),
		'all_items'         => __( 'All Positions', 'milos' ),
		'parent_item'       => __( 'Parent Position', 'milos' ),
		'parent_item_colon' => __( 'Parent Position:', 'milos' ),
		'edit_item'         => __( 'Edit Position', 'milos' ),
		'update_item'       => __( 'Update Position', 'milos' ),
		'add_new_item'      => __( 'Add New Position', 'milos' ),
		'new_item_name'     => __( 'New Position Name', 'milos' ),
		'menu_name'         => __( 'Position', 'milos' ),
	);

	$args = array(
		'public'             => false,
		'hierarchical'       => false,
		'labels'             => $labels,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => false,
		'show_in_nav_menus'  => true,
		'meta_box_cb'        => false,
	);

	register_taxonomy( 'employee_position', 'employee', $args );
}

add_action( 'init', 'taxonomy_employee_position' );

/**
 * Adds Position & Office filters to the admin table.
 *
 * @return void
 */
function add_employee_filters() {

	if ( 'edit-employee' === get_current_screen()->id ) :

		$selected_employee = isset( $_GET['employee_position'] ) ? $_GET['employee_position'] : '';

		$options = array();

		$positions = get_terms(
			array(
				'taxonomy'   => 'employee_position',
				'hide_empty' => false,
			)
		);

		$options[] = sprintf(
			'<option class="level-0" value="" %2$s>%1$s</option>',
			esc_html__( 'Select all Employees', 'milos' ),
			selected( '', $selected_employee, false )
		);

		foreach ( $positions as $position ) :
			$options[] = sprintf(
				'<option class="level-0" value="%2$s" %3$s>%1$s</option>',
				esc_html( $position->name ),
				esc_attr( $position->slug ),
				selected( $position->slug, $selected_employee, false )
			);
		endforeach;

		echo '<select name="employee_position" id="employee_position" class="postform">' . join( PHP_EOL, $options ) . '</select>';

		$selected_office = isset( $_GET['employee_office'] ) ? $_GET['employee_office'] : '';

		$options = array();

		$offices = get_posts(
			array(
				'post_type'      => 'office',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);

		$options[] = sprintf(
			'<option class="level-0" value="" %2$s>%1$s</option>',
			esc_html__( 'Select all Offices', 'milos' ),
			selected( '', $selected_office, false )
		);

		foreach ( $offices as $office ) :
			$options[] = sprintf(
				'<option class="level-0" value="%2$s" %3$s>%1$s</option>',
				esc_html( $office->post_title ),
				esc_attr( $office->post_name ),
				selected( $office->post_name, $selected_office, false )
			);
		endforeach;

		echo '<select name="employee_office" id="employee_office" class="postform">' . join( PHP_EOL, $options ) . '</select>';

	endif;
}

add_action( 'restrict_manage_posts', 'add_employee_filters' );

/**
 * Filter employees by selected office.
 *
 * @param object $query WP_Query object.
 * @return object $query WP_Query object.
 */
function modify_main_employee_query( $query ) {

	global $wpdb;

	if ( is_admin() && function_exists( 'get_current_screen' ) ) :

		$current_screen = get_current_screen();

		if ( $query->is_main_query() && $current_screen && 'edit-employee' === $current_screen->id ) :

			$selected_office = isset( $_GET['employee_office'] ) ? $_GET['employee_office'] : '';

			if ( $selected_office ) :

				$selected_office_id = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_type = "office" AND post_name = %s ',
						$selected_office
					)
				);

				if ( $selected_office_id ) :

					$meta_query = $query->get( 'meta_query' );

					if ( ! $meta_query ) :
						$meta_query = array();
					endif;

					/**
					 * Compare with LIKE because ID is saved as serialized array value.
					 */
					$meta_query[] = array(
						'key'     => 'employee_office',
						'value'   => '"' . $selected_office_id . '"',
						'compare' => 'LIKE',
					);

					$query->set( 'meta_query', $meta_query );

				endif;

			endif;

		endif;

	endif;

	return $query;
}

add_filter( 'parse_query', 'modify_main_employee_query' );

/**
 * Modify Employee admin table columns.
 *
 * @param  array $columns Admin table columns.
 * @return array $columns Admin table columns.
 */
function modify_employee_columns( $columns ) {

	$columns = array(
		'cb'                         => $columns['cb'],
		'image'                      => __( 'Image', 'milos' ),
		'title'                      => $columns['title'],
		'taxonomy-employee_position' => $columns['taxonomy-employee_position'],
		'office'                     => __( 'Office', 'milos' ),
	);

	return $columns;
}

add_filter( 'manage_employee_posts_columns', 'modify_employee_columns', PHP_INT_MIN );


/**
 * Outputs custom Employee admin table columns.
 *
 * @param  string $column Column name.
 * @param  int    $post_id Post ID of current post in the loop.
 * @return void
 */
function output_employee_columns( $column, $post_id ) {

	switch ( $column ) :

		case 'image':
			$image = get_field( 'employee_image', $post_id );
			if ( $image ) :
				echo wp_get_attachment_image( $image['ID'], 'thumbnail' );
			endif;
			break;

		case 'position':
			echo get_field( 'employee_position', $post_id );
			break;

		case 'office':
			$office_ids = get_field( 'employee_office', $post_id );
			if ( ! empty( $office_ids ) ) :
				$offices = array();
				foreach ( $office_ids as $office_id ) :
					$post = get_post( $office_id );
					if ( $post ) :
						$offices[] = sprintf(
							'<a href="edit.php?post_type=employee&employee_office=%2$s" >%1$s</a>',
							esc_html( $post->post_title ),
							$post->post_name
						);
					endif;
				endforeach;

				echo join( ', ', $offices );
			endif;
			break;

	endswitch;
}

add_action( 'manage_employee_posts_custom_column', 'output_employee_columns', 10, 2 );

/**
 * Register Post Type Office.
 *
 * @return void
 */
function post_type_office() {

	$labels = array(
		'name'                     => __( 'Offices', 'milos' ),
		'singular_name'            => __( 'Office', 'milos' ),
		'add_new'                  => __( 'Add New', 'milos' ),
		'add_new_item'             => __( 'Add New Office', 'milos' ),
		'edit_item'                => __( 'Edit Office', 'milos' ),
		'new_item'                 => __( 'New Office', 'milos' ),
		'view_item'                => __( 'View Office', 'milos' ),
		'view_items'               => __( 'View Offices', 'milos' ),
		'search_items'             => __( 'Search Offices', 'milos' ),
		'not_found'                => __( 'No offices found.', 'milos' ),
		'not_found_in_trash'       => __( 'No offices found in Trash.', 'milos' ),
		'all_items'                => __( 'All Offices', 'milos' ),
		'archives'                 => __( 'Office Archives', 'milos' ),
		'attributes'               => __( 'Office Attributes', 'milos' ),
		'insert_into_item'         => __( 'Insert into office', 'milos' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this office', 'milos' ),
		'featured_image'           => __( 'Featured Image', 'milos' ),
		'set_featured_image'       => __( 'Set featured image', 'milos' ),
		'remove_featured_image'    => __( 'Remove featured image', 'milos' ),
		'use_featured_image'       => __( 'Use as featured image', 'milos' ),
		'filter_items_list'        => __( 'Filter offices list', 'milos' ),
		'items_list_navigation'    => __( 'Offices list navigation', 'milos' ),
		'items_list'               => __( 'Offices list', 'milos' ),
		'item_published'           => __( 'Office published.', 'milos' ),
		'item_published_privately' => __( 'Office published privately.', 'milos' ),
		'item_reverted_to_draft'   => __( 'Office reverted to draft.', 'milos' ),
		'item_scheduled'           => __( 'Office scheduled.', 'milos' ),
		'item_updated'             => __( 'Office updated.', 'milos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'menu_icon'         => '',
		'show_in_nav_menus' => true,
		'menu_position'     => 5,
		'has_archive'       => false,
		'capability_type'   => 'page',
		'supports'          => array( 'title' ),
		'show_in_rest'      => false,
		'rewrite'           => array(
			'slug' => 'office',
		),
	);

	register_post_type( 'office', $args );
}

add_action( 'init', 'post_type_office' );

/**
 * Register Post Type Service.
 *
 * @return void
 */
function post_type_service() {

	$labels = array(
		'name'                     => __( 'Services', 'milos' ),
		'singular_name'            => __( 'Service', 'milos' ),
		'add_new'                  => __( 'Add New', 'milos' ),
		'add_new_item'             => __( 'Add New Service', 'milos' ),
		'edit_item'                => __( 'Edit Service', 'milos' ),
		'new_item'                 => __( 'New Service', 'milos' ),
		'view_item'                => __( 'View Service', 'milos' ),
		'view_items'               => __( 'View Services', 'milos' ),
		'search_items'             => __( 'Search Services', 'milos' ),
		'not_found'                => __( 'No services found.', 'milos' ),
		'not_found_in_trash'       => __( 'No services found in Trash.', 'milos' ),
		'all_items'                => __( 'All Services', 'milos' ),
		'archives'                 => __( 'Service Archives', 'milos' ),
		'attributes'               => __( 'Service Attributes', 'milos' ),
		'insert_into_item'         => __( 'Insert into service', 'milos' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this service', 'milos' ),
		'featured_image'           => __( 'Featured Image', 'milos' ),
		'set_featured_image'       => __( 'Set featured image', 'milos' ),
		'remove_featured_image'    => __( 'Remove featured image', 'milos' ),
		'use_featured_image'       => __( 'Use as featured image', 'milos' ),
		'filter_items_list'        => __( 'Filter services list', 'milos' ),
		'items_list_navigation'    => __( 'Services list navigation', 'milos' ),
		'items_list'               => __( 'Services list', 'milos' ),
		'item_published'           => __( 'Service published.', 'milos' ),
		'item_published_privately' => __( 'Service published privately.', 'milos' ),
		'item_reverted_to_draft'   => __( 'Service reverted to draft.', 'milos' ),
		'item_scheduled'           => __( 'Service scheduled.', 'milos' ),
		'item_updated'             => __( 'Service updated.', 'milos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'menu_icon'         => 'dashicons-format-aside',
		'show_in_nav_menus' => true,
		'menu_position'     => 5,
		'has_archive'       => false,
		'capability_type'   => 'page',
		'supports'          => array( 'title' ),
		'show_in_rest'      => false,
		'rewrite'           => array(
			'slug' => 'service',
		),
	);

	//register_post_type( 'service', $args );
}

add_action( 'init', 'post_type_service' );
