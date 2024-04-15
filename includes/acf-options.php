<?php
/**
 * ACF customizations
 *
 * @package Milos
 * @subpackage Chriss
 */

/** ACF options */

add_filter(
	'acf/load_field/type=flexible_content',
	function ( $field ) {

		global $current_acf_screen;
		global $current_flexible_content_field;
		global $in_load_field_flexible_content_filter;

		if ( $in_load_field_flexible_content_filter ) :
			return $field;
		endif;

		$in_load_field_flexible_content_filter = true;

		if ( function_exists( 'get_current_screen' ) ) :
			$screen = get_current_screen();

			if ( $screen && 'acf-field-group' === $screen->id ) :
				return $field;
			endif;
		endif;

		$current_flexible_content_field = $field['key'];

		foreach ( $field['layouts'] as $id => $layout ) :
			if ( '' === $layout['name'] ) :
				unset( $field['layouts'][ $id ] );
			endif;
		endforeach;

		$extra_layouts = array();

		foreach ( acf_get_field_groups() as $field_group ) :

			$locations_with_flexible_content_condition = array();

			foreach ( $field_group['location'] as $rules ) :

				$rules_group = array();

				/**
				 * On frontend or inside ajax request, ignore all other location parameters othen than flexible content location.
				 * That will allow all modules that are assigned to this flexible content field to appear so that they can be saved / validated.
				 * It could be coded to check for all possible conditions and filter based on location rules but it would take a lot of time.
				 * */

				if ( ! is_admin() || is_post_request() || wp_doing_ajax() ) :
					$rules = array_filter(
						$rules,
						function ( $item ) {
							return 'flexible_content' === $item['param'];
						}
					);
				endif;

				foreach ( $rules as $rule ) :
					if ( 'flexible_content' === $rule['param'] ) :
						$rules_group = $rules;
						break;
					endif;
				endforeach;

				if ( $rules_group ) :
					$locations_with_flexible_content_condition[] = $rules_group;
				endif;

			endforeach;

			if ( ! empty( $locations_with_flexible_content_condition ) ) :

				$field_group['location'] = $locations_with_flexible_content_condition;

				if ( acf_get_field_group_visibility( $field_group, $current_acf_screen ) ) :

					$title = preg_replace( '#^Module: #', '', $field_group['title'] );
					$slug  = str_replace( 'group_', '', $field_group['key'] );

					$extra_layouts[] = array(
						'id'     => str_replace( 'group_', 'layout_', $field_group['key'] ),
						'label'  => $title,
						'name'   => $slug,
						'fields' => acf_get_fields( $field_group['key'] ),
					);

				endif;

				usort(
					$extra_layouts,
					function ( $a, $b ) {
						return strnatcasecmp( $a['label'], $b['label'] );
					}
				);

				foreach ( $extra_layouts as $extra_layout ) :
					$field['layouts'][ $extra_layout['id'] ] = array(
						'key'        => $extra_layout['id'],
						'label'      => $extra_layout['label'],
						'name'       => $extra_layout['name'],
						'display'    => 'block',
						'min'        => '',
						'max'        => '',
						'sub_fields' => $extra_layout['fields'],
					);
				endforeach;

			endif;

		endforeach;

		$current_flexible_content_field = null;

		$in_load_field_flexible_content_filter = false;

		return $field;
	}
);

/**
 * Cache last used acf location screen so that we can reuse it later to check location rules of flexible content layout.
 *
 * @param  mixed[] $screen ACF location screen.
 * @return mixed[] $screen ACF location screen.
 */
function cache_last_acf_location_screen( $screen ) {

	global $current_acf_screen, $in_load_field_flexible_content_filter;

	if ( ! $in_load_field_flexible_content_filter ) :
		$current_acf_screen = $screen;
	endif;

	return $screen;
}

add_filter( 'acf/location/screen', 'cache_last_acf_location_screen', PHP_INT_MAX );


/**
 * Configure paths for saving modules' ACF JSON files.
 *
 * @param  string $path ACF Field Group's JSON save path.
 * @return string
 */
function save_module_acf( $path ) {

	/** If blocks acf, save it to the module folder if exists */
	if ( isset( $_POST['acf_field_group']['key'] ) ) :

		$module_id  = preg_replace( '#^group_#', '', $_POST['acf_field_group']['key'] );
		$module_dir = THEME_MODULES_DIR . '/' . $module_id;

		if ( is_dir( $module_dir ) ) :

			$module_acf_dir = $module_dir . '/acf-json';

			if ( ! is_dir( $module_acf_dir ) ) :
				mkdir( $module_acf_dir );
			endif;

			return $module_acf_dir;

		endif;

	endif;

	return $path;
}

add_filter( 'acf/settings/save_json', 'save_module_acf', 15, 2 );

/**
 * Get all paths to modules' ACF JSON files..
 *
 * @return array
 */
function get_modules_acf_json() {

	$paths = array();

	if ( file_exists( THEME_MODULES_DIR ) ) :

		$paths = glob( THEME_MODULES_DIR . '/*/acf-json', GLOB_ONLYDIR );

	endif;

	return $paths;
}

/**
 * Add modules' json paths to default ACF JSON save paths.
 *
 * @param  array $paths default ACF JSON save paths.
 * @return array
 */
function load_module_acf( $paths ) {

	/** Append our modules' json paths. */
	$paths = array_merge( $paths, get_modules_acf_json() );

	return $paths;
}

add_filter( 'acf/settings/load_json', 'load_module_acf', 15, 2 );

/** Forminator's post title isn't the title that we set in the settings. So we need to override default ACF behaviour */
/**
 * Replace ID with Forminator form name.
 *
 * @param  string  $title Forminator ID.
 * @param  WP_Post $post Current post object.
 * @return string
 */
function acf_form_field_post_title_override( $title, $post ): string {

	if ( function_exists( 'forminator_get_form_name' ) ) :
		$title = forminator_get_form_name( $post->ID );
	endif;

	return $title;
}

add_filter( 'acf/fields/post_object/result/name=form', 'acf_form_field_post_title_override', 10, 4 );

/**
 * Overwrite "Blocks" label to "Flexible Content Modules".
 *
 * @param  mixed $object ACF Object.
 * @return mixed
 */
function override_acf_object_types( $object ) { //phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.objectFound

	if ( 'block' === $object->type ) :
		$object->label = __( 'Flexible Content Module', 'acf' );
	endif;

	return $object;
}

add_filter( 'acf/get_object_type', 'override_acf_object_types' );

/**
 * Get internal field group.. When using "acf_get_field_group", it doesn't return the same data as when using "acf_get_internal_post_type_posts".
 *
 * @param  string $key Field group key.
 * @return mixed[] Internal Field Group.
 */
function acf_get_internal_post_type_post_by_key( $key ) {

	$field_groups = acf_get_internal_post_type_posts( 'acf-field-group' );

	foreach ( $field_groups as $field_group ) :

		if ( $key === $field_group['key'] ) :
			return $field_group;
		endif;

	endforeach;

	return false;
}

/**
 * Automatically sync acf field groups.
 *
 * This will mostly run after pulling updated field groups from the repository
 * removing the need to manually go to ACF -> Field Groups -> Sync Available
 *
 * @return void
 */
function auto_sync_acf_field_groups() {

	// run this only in admin and only if sync is already not in progress.
	if ( ! is_admin() || get_transient( 'acf_json_auto_import_running' ) ) :
		return;
	endif;

	$field_groups_to_sync = array();

	$field_groups = acf_get_internal_post_type_posts( 'acf-field-group' );

	foreach ( $field_groups as $field_group ) :

		if ( acf_is_field_group_sync_available( $field_group ) ) :
			$field_groups_to_sync[] = $field_group;
		endif;

	endforeach;

	if ( $field_groups_to_sync ) :
		foreach ( $field_groups_to_sync as $field_group ) :
			auto_sync_acf_field_group( $field_group );
		endforeach;
	endif;
}

add_action( 'acf/init', 'auto_sync_acf_field_groups', PHP_INT_MAX );

/**
 * Synchronize single field group.
 *
 * Either field group key or internal field group can be passed. In autosync function we already have the entire field group,
 * but if we want to call this function manually after some changes, we can pass in just the "key" and it will work with it too.
 *
 * @param  string|mixed[] $field_group Internal Field Group array or ACF Field group key.
 * @return void
 */
function auto_sync_acf_field_group( $field_group ) {

	if ( get_transient( 'acf_json_auto_import_running' ) ) :
		return;
	endif;

	// If $field group is string, it is a field_group key then.

	if ( is_string( $field_group ) ) :
		$field_group = acf_get_internal_post_type_post_by_key( $field_group );
	endif;

	if ( $field_group ) :

		if ( acf_is_field_group_sync_available( $field_group ) ) :

			// Disabled "Local JSON" controller to prevent the .json file from being modified during import.
			acf_update_setting( 'json', false );

			// Set transient so that we don't run this code multiple times while it is still running.
			set_transient( 'acf_json_auto_import_running', 'yes', MINUTE_IN_SECONDS );

			$local_field_group       = json_decode( file_get_contents( $field_group['local_file'] ), true );
			$local_field_group['ID'] = $field_group['ID'];

			$result = acf_import_internal_post_type( $local_field_group, 'acf-field-group' );

			// Clear transient that stops auto importing.
			delete_transient( 'acf_json_auto_import_running' );

			// Reenable "Local JSON" controller to allow the .json file to be modified.
			acf_update_setting( 'json', true );

		endif;

	endif;
}

/**
 * Checks if field group's sync is available.
 *
 * @param  mixed[] $field_group ACF Field Group array.
 * @return boolean Is this group syncable.
 */
function acf_is_field_group_sync_available( $field_group ) {

	$local    = acf_maybe_get( $field_group, 'local' );
	$modified = acf_maybe_get( $field_group, 'modified' );
	$private  = acf_maybe_get( $field_group, 'private' );

	// Ignore if is private or not local "json".
	if ( $private || 'json' !== $local ) :
		return false;

		// Ignore if local file doesn't exist.
	elseif ( ! $field_group['local_file'] || ! file_exists( $field_group['local_file'] ) ) :
		return false;

		// Check if group is already in database or if timestamp in database is lower than the one in the local file.
	elseif ( 0 === $field_group['ID'] || ( $modified && $modified > get_post_modified_time( 'U', true, $field_group['ID'] ) ) ) :
		return true;
	else :
		return false;
	endif;
}

/**
 * Start buffering output before flexible content field render,
 * so that we can collapse fields programatically.
 *
 * @return void
 */
function flexible_content_before_render() {
	ob_start();
}

add_action( 'acf/render_field/type=flexible_content', 'flexible_content_before_render', PHP_INT_MIN );

/**
 * After flexible content field has rendered, add -collapsed class to each layout,
 * so that on page load all layouts are collapsed.
 *
 * @return void
 */
function flexible_content_after_render() {
	echo str_replace( 'class="layout"', 'class="layout -collapsed"', ob_get_clean() );
}

add_action( 'acf/render_field/type=flexible_content', 'flexible_content_after_render', PHP_INT_MAX );

/**
 * Add employee images to the search results of "employees_grid_items" field.
 *
 * @param  string $title HTML for the search result.
 * @param  object $post WP_Post object.
 * @return string $title HTML for the search result.
 */
function add_employee_images_to_grid( $title, $post ) {

	$image = get_field( 'employee_image', $post->ID );

	if ( $image ) :

		$image_html = wp_get_attachment_image( $image['ID'], 'thumbnail' );

		$title = '<div class="thumbnail">' . $image_html . '</div>' . $title;

	endif;

	return $title;
}

add_filter( 'acf/fields/relationship/result/name=employees_grid_items', 'add_employee_images_to_grid', 10, 2 );
