<?php
/**
 * Importing functionality
 *
 * @package Milos
 * @subpackage Chriss
 */

if ( defined( 'LIVE_SITE_URL' ) && rtrim( get_site_url(), '/' ) !== LIVE_SITE_URL ) :

	/**
	 * Adds "Import Live Data" page.
	 *
	 * @return void
	 */
	function register_import_page() {
		add_submenu_page( 'tools.php', 'Import Live Data', 'Import Live Data', 'manage_options', 'import-live-data', 'output_import_page' );
	}

	add_action( 'admin_menu', 'register_import_page' );

	/**
	 * Outputs Import Live Data page.
	 *
	 * @return void
	 */
	function output_import_page() {

		get_template_part( 'template-parts/admin/import_page' );
	}

	/**
	 * Finds existing post ID using the post ID from the live site.
	 *
	 * @param  int $import_post_id Post ID from live site.
	 * @return int|boolean Post ID from current site.
	 */
	function get_existing_post_id( $import_post_id ) {

		$args = array(
			'post_type'        => array(
				'service',
				'project',
				'page',
				'sector',
				'employee',
				'office',
				'attachment',
			),
			'meta_query'       => array(
				array(
					'key'   => '_import_id',
					'value' => $import_post_id,
				),
			),
			'post_status'      => 'any',
			'suppress_filters' => true,
			'fields'           => 'ids',
		);

		$posts = get_posts( $args );

		return $posts ? $posts[0] : false;
	}

	/**
	 * Create new post from import data.
	 *
	 * @param  mixed $data Post data from live site.
	 * @return int Post ID of newly created post.
	 */
	function create_new_post( $data ) {

		$post = $data['post'];
		$acf  = $data['acf'];

		$args = array(
			'post_type'     => $data['post']['post_type'],
			'post_date'     => $data['post']['post_date'],
			'post_modified' => $data['post']['post_modified'],
			'post_name'     => $data['post']['post_name'],
			'post_status'   => $data['post']['post_status'],
			'post_title'    => $data['post']['post_title'],
			'menu_order'    => $data['post']['menu_order'],
		);

		$meta_input = array(
			'_import_id'        => $data['post']['ID'],
			'_import_parent_id' => $data['post']['post_parent'],
			'_import_url'       => $data['url'],
			'_acf'              => $data['acf'],
		);

		do_action( 'wpml_switch_language', $data['lang'] );

		$post_id = wp_insert_post( $args );

		foreach ( $meta_input as $meta_key => $meta_value ) :
			update_post_meta( $post_id, $meta_key, $meta_value );
		endforeach;

		return $post_id;
	}

	/**
	 * Create new translation from import data.
	 *
	 * @param  mixed $data Post data from live site.
	 * @param  mixed $source_post_id Translation source post id.
	 * @return int Post ID of newly created post.
	 */
	function create_new_translation( $data, $source_post_id ) {

		$post = $data['post'];
		$acf  = $data['acf'];

		$args = array(
			'post_type'     => $data['post']['post_type'],
			'post_date'     => $data['post']['post_date'],
			'post_modified' => $data['post']['post_modified'],
			'post_name'     => $data['post']['post_name'],
			'post_status'   => $data['post']['post_status'],
			'post_title'    => $data['post']['post_title'],
			'menu_order'    => $data['post']['menu_order'],
		);

		$meta_input = array(
			'_import_id'        => $data['post']['ID'],
			'_import_parent_id' => $data['post']['post_parent'],
			'_import_url'       => $data['url'],
			'_acf'              => $data['acf'],
		);

		do_action( 'wpml_switch_language', $data['lang'] );

		$post_id = wp_insert_post( $args );

		foreach ( $meta_input as $meta_key => $meta_value ) :
			update_post_meta( $post_id, $meta_key, $meta_value );
		endforeach;

		$wpml_element_type = apply_filters( 'wpml_element_type', $data['post']['post_type'] );

		$get_language_args           = array(
			'element_id'   => $source_post_id,
			'element_type' => $data['post']['post_type'],
		);
		$original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );

		$set_language_args = array(
			'element_id'           => $post_id,
			'element_type'         => $wpml_element_type,
			'trid'                 => $original_post_language_info->trid,
			'language_code'        => $data['lang'],
			'source_language_code' => $original_post_language_info->language_code,
		);

		do_action( 'wpml_set_element_language_details', $set_language_args );

		return $post_id;
	}

	/**
	 * Create new attachment from import data.
	 *
	 * @param  mixed $data Attachment data from live site.
	 * @return int Post ID of newly created post.
	 */
	function create_new_attachment( $data ) {

		do_action( 'wpml_switch_language', 'da' );

		$post = $data['post'];

		$upload_dir = wp_upload_dir();

		$image_data = file_get_contents( $data['url'] );

		$filename = basename( $data['file'] );

		$dir  = $upload_dir['basedir'] . '/' . dirname( $data['file'] );
		$file = $dir . '/' . $filename;

		wp_mkdir_p( $dir );

		file_put_contents( $file, $image_data );

		$args = array(
			'post_type'      => 'attachment',
			'post_date'      => $data['post']['post_date'],
			'post_modified'  => $data['post']['post_modified'],
			'post_name'      => $data['post']['post_name'],
			'post_status'    => $data['post']['post_status'],
			'post_title'     => $data['post']['post_title'],
			'menu_order'     => $data['post']['menu_order'],
			'post_mime_type' => $data['post']['post_mime_type'],
		);

		$meta_input = array(
			'_import_id'               => $data['post']['ID'],
			'_import_parent_id'        => $data['post']['post_parent'],
			'_import_url'              => $data['url'],
			'_wp_attachment_image_alt' => $data['alt'],
		);

		$attachment_id = wp_insert_attachment( $args, $file );

		foreach ( $meta_input as $meta_key => $meta_value ) :
			update_post_meta( $attachment_id, $meta_key, $meta_value );
		endforeach;

		require_once ABSPATH . 'wp-admin/includes/image.php';
		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $file ) );

		return $attachment_id;
	}

	/**
	 * Ajax function for importing posts.
	 *
	 * @return void
	 */
	function ajax_import_posts() {

		set_time_limit( 300 );

		global $sitepress;

		$posts_to_import = json_decode( stripslashes( $_POST['posts'] ), true );

		$items = array();

		foreach ( $posts_to_import as $data ) :

			$post_id = get_existing_post_id( $data['source']['post']['ID'] );

			if ( ! $post_id ) :
				$post_id = create_new_post( $data['source'] );
			endif;

			update_post_meta( $post_id, '_acf', $data['source']['acf'] );

			// Update Yoast meta.
			foreach ( $data['source']['yoast'] as $meta_key => $meta_value ) :
				update_post_meta( $post_id, $meta_key, $meta_value );
			endforeach;

			if ( ! empty( $data['translations'] ) ) :

				foreach ( $data['translations'] as $translation ) :

					$translation_post_id = get_existing_post_id( $translation['post']['ID'] );

					if ( ! $translation_post_id ) :
						$translation_post_id = create_new_translation( $translation, $post_id );
					endif;

					update_post_meta( $translation_post_id, '_acf', $translation['acf'] );

					// Update Yoast meta.
					foreach ( $translation['yoast'] as $meta_key => $meta_value ) :
						update_post_meta( $translation_post_id, $meta_key, $meta_value );
					endforeach;

				endforeach;

			endif;

			$items[] = $post_id;

		endforeach;

		wp_send_json(
			array(
				'items' => array_unique( $items ),
			)
		);
		exit;
	}

	add_action( 'wp_ajax_import_posts', 'ajax_import_posts' );

	/**
	 * Ajax function for importing media.
	 *
	 * @return void
	 */
	function ajax_import_media() {

		set_time_limit( 300 );

		$media_to_import = json_decode( stripslashes( $_POST['media'] ), true );

		foreach ( $media_to_import as $media ) :

			$post_id = get_existing_post_id( $media['post']['ID'] );

			if ( ! $post_id ) :
				$post_id = create_new_attachment( $media );
			endif;

		endforeach;

		exit;
	}

	add_action( 'wp_ajax_import_media', 'ajax_import_media' );

	/**
	 * Converts old parent post IDs to IDs from this site.
	 *
	 * @return void
	 */
	function ajax_import_fix_parent_ids() {

		set_time_limit( 300 );

		$post_ids = json_decode( stripslashes( $_POST['post_ids'] ), true );

		foreach ( $post_ids as $import_post_id ) :

			$post_id = get_existing_post_id( $import_post_id );

			if ( ! $post_id ) :
				continue;
			endif;

			do_action( 'wpml_switch_language', get_post_language( $post_id ) );

			$import_post_parent_id = get_post_meta( $post_id, '_import_parent_id', true );

			if ( ! $import_post_parent_id ) :
				continue;
			endif;

			$post_parent_id = get_existing_post_id( $import_post_parent_id );

			if ( ! $post_parent_id ) :
				continue;
			endif;

			wp_update_post(
				array(
					'ID'          => $post_id,
					'post_parent' => $post_parent_id,
				)
			);

		endforeach;

		exit;
	}

	add_action( 'wp_ajax_import_fix_parent_ids', 'ajax_import_fix_parent_ids' );


	/**
	 * Ajax action that converts ACF data to the current format.
	 *
	 * @return void
	 */
	function ajax_import_convert_acf() {

		set_time_limit( 300 );

		$post_ids = json_decode( stripslashes( $_POST['post_ids'] ), true );

		foreach ( $post_ids as $import_post_id ) :

			$post_id = get_existing_post_id( $import_post_id );

			if ( ! $post_id ) :
				continue;
			endif;

			convert_post_acf( $post_id );

			foreach ( get_post_translations( $post_id ) as $translation_post_id ) :
				convert_post_acf( $translation_post_id );
			endforeach;

		endforeach;

		exit;
	}

	add_action( 'wp_ajax_import_convert_acf', 'ajax_import_convert_acf' );

	/**
	 * Converts ACF data to the current format.
	 *
	 * @param  int $post_id Post ID.
	 * @return void
	 */
	function convert_post_acf( $post_id ) {

		do_action( 'wpml_switch_language', get_post_language( $post_id ) );

		$acf = get_post_meta( $post_id, '_acf', true );

		$post_type = get_post_type( $post_id );

		$function_name = 'sync_' . str_replace( '-', '_', $post_type ) . '_acf_post_data';

		if ( function_exists( $function_name ) ) :
			call_user_func( $function_name, $post_id, $acf );
		endif;
	}

	/**
	 * Syncs employee ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_employee_acf_post_data( $post_id, $acf ) {

		$image_attachment_id = get_existing_post_id( $acf['profile_image'] );
		$phone               = $acf['tel'];
		$email               = $acf['email'];
		$raw_positions       = array_filter( array_map( 'trim', explode( '/', $acf['position'] ) ) );
		$positions           = array();

		foreach ( $raw_positions as $raw_position ) :

			$term = get_term_by( 'name', $raw_position, 'employee_position' );

			if ( ! $term ) :

				$term = wp_insert_term( $raw_position, 'employee_position' );

				if ( is_wp_error( $term ) ) :
					continue;
				else :
					$term_id = $term['term_id'];
				endif;

			else :
				$term_id = $term->term_id;
			endif;

			$positions[] = $term_id;

		endforeach;

		$office_ids = array();

		$exclude_names = array( 'sverige', 'sweden', 'danmark', 'denmark' );

		$office_titles = array_diff( array_filter( array_map( 'strtolower', array_map( 'trim', explode( ',', $acf['address'] ) ) ) ), $exclude_names );

		$offices = get_offices();

		foreach ( $office_titles as $office_title ) :

			foreach ( $offices as $office ) :

				if ( strtolower( $office->get_name() ) === $office_title ) :

					$office_ids[] = $office->get_id();
					break;

				endif;

			endforeach;

		endforeach;

		update_field( 'employee_image', $image_attachment_id, $post_id );
		update_field( 'employee_office', $office_ids, $post_id );
		update_field( 'employee_positions', $positions, $post_id );
		wp_set_object_terms( $post_id, $positions, 'employee_positions' );
		update_field( 'employee_phone', $phone, $post_id );
		update_field( 'employee_email', $email, $post_id );
	}

	/**
	 * Syncs office ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_office_acf_post_data( $post_id, $acf ) {

		$phone    = $acf['tel'];
		$email    = $acf['email'];
		$address  = $acf['position'];
		$map_link = $acf['link_map'];

		update_field( 'office_address', $address, $post_id );
		update_field( 'office_phone', $phone, $post_id );
		update_field( 'office_email', $email, $post_id );
		update_field( 'office_map_link', $map_link, $post_id );

		if ( ! empty( $acf['module_tops'] ) ) :

			$hero_type          = 'standard';
			$hero_text          = $acf['module_tops'][0]['text'];
			$hero_vertical_text = $acf['module_tops'][0]['vertical_text'];

			update_field( 'hero_type', $hero_type, $post_id );
			update_field( 'hero_text', $hero_text, $post_id );
			update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

		endif;

		$modules = array();

		$modules = convert_modules( $post_id, $acf );

		update_field( 'modules', $modules, $post_id );
	}

	/**
	 * Syncs page ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_page_acf_post_data( $post_id, $acf ) {

		if ( isset( $acf['image_search'] ) && isset( $acf['alt_thumbnail'] ) ) :
			$search_image     = $acf['image_search'] ? get_existing_post_id( $acf['image_search'] ) : '';
			$search_image_alt = $acf['alt_thumbnail'];
			update_field( 'search_image', $search_image, $post_id );
			update_field( 'search_image_alt', $search_image_alt, $post_id );
		endif;

		if ( ! empty( $acf['module_tops'] ) ) :

			$acf_hero = $acf['module_tops'][0];

			switch ( $acf['page_template'] ) :

				case 'landing':
					$hero_type          = 'landing';
					$hero_title         = $acf_hero['title'];
					$hero_text          = $acf_hero['head'];
					$hero_vertical_text = $acf_hero['vertical_text'];
					$hero_link          = generate_acf_link( $acf_hero['link_type'], $acf_hero['landing_internal_link'], $acf_hero['landing_external_link'], $acf_hero['link_title'] );
					$hero_slides        = array();

					if ( ! empty( $acf_hero['images'] ) ) :

						foreach ( $acf_hero['images'] as $hero_slide ) :

							$hero_slides[] = array(
								'image' => $hero_slide['background_image'] ? get_existing_post_id( $hero_slide['background_image'] ) : '',
								'video' => $hero_slide['video_mp4'] ? get_existing_post_id( $hero_slide['video_mp4'] ) : '',
							);

						endforeach;

					endif;

					update_field( 'hero_type', $hero_type, $post_id );
					update_field( 'hero_title', $hero_title, $post_id );
					update_field( 'hero_text', $hero_text, $post_id );
					update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );
					update_field( 'hero_link', $hero_link, $post_id );
					update_field( 'hero_slides', $hero_slides, $post_id );

					break;

				case 'contact':
					$hero_type          = 'contact';
					$hero_title         = $acf_hero['title'];
					$hero_text          = $acf_hero['teaser'];
					$hero_phone         = $acf_hero['telephone'];
					$hero_email         = $acf_hero['email'];
					$hero_opening_hours = $acf_hero['text'];
					$hero_vertical_text = isset( $acf_hero['vertical_text'] ) ? $acf_hero['vertical_text'] : '';

					update_field( 'hero_type', $hero_type, $post_id );
					update_field( 'hero_title', $hero_title, $post_id );
					update_field( 'hero_text', $hero_text, $post_id );
					update_field( 'hero_phone', $hero_phone, $post_id );
					update_field( 'hero_email', $hero_email, $post_id );
					update_field( 'hero_opening_hours', $hero_opening_hours, $post_id );
					update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

					break;

				case 'service':
					$hero_type          = 'standard';
					$hero_is_narrow     = true;
					$hero_text          = isset( $acf_hero['head'] ) ? $acf_hero['head'] : $acf_hero['text'];
					$hero_vertical_text = isset( $acf_hero['vertical_text'] ) ? $acf_hero['vertical_text'] : '';

					update_field( 'hero_type', $hero_type, $post_id );
					update_field( 'hero_is_narrow', $hero_is_narrow, $post_id );
					update_field( 'hero_text', $hero_text, $post_id );
					update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );
					break;

				default:
					$hero_type          = 'standard';
					$hero_is_narrow     = false;
					$hero_text          = isset( $acf_hero['head'] ) ? $acf_hero['head'] : $acf_hero['text'];
					$hero_vertical_text = isset( $acf_hero['vertical_text'] ) ? $acf_hero['vertical_text'] : '';

					update_field( 'hero_type', $hero_type, $post_id );
					update_field( 'hero_is_narrow', $hero_is_narrow, $post_id );
					update_field( 'hero_text', $hero_text, $post_id );
					update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

					break;

			endswitch;

		elseif ( ! empty( $acf['article_modules_top'] ) ) :

			$acf_hero = $acf['article_modules_top'][0];

			$hero_type          = 'standard';
			$hero_text          = $acf_hero['text'];
			$hero_vertical_text = $acf_hero['vertical_text'];

			update_field( 'hero_type', $hero_type, $post_id );
			update_field( 'hero_text', $hero_text, $post_id );
			update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );
		endif;

		$modules = convert_modules( $post_id, $acf );

		update_field( 'modules', $modules, $post_id );

		switch ( $acf['page_template'] ) :

			case 'carierre':
				$career_page         = $post_id;
				$career_teaser_image = $acf['thumbnail_image'] ? get_existing_post_id( $acf['thumbnail_image'] ) : '';
				$career_teaser_title = $acf['title'];
				$career_teaser_text  = $acf['description'];

				update_field( 'career_page', $career_page, 'options' );
				update_field( 'career_teaser_image', $career_teaser_image, 'options' );
				update_field( 'career_teaser_title', $career_teaser_title, 'options' );
				update_field( 'career_teaser_text', $career_teaser_text, 'options' );
				break;

			case 'about-us':
				$about_us_page         = $post_id;
				$about_us_teaser_image = $acf['thumbnail_image'] ? get_existing_post_id( $acf['thumbnail_image'] ) : '';
				$about_us_teaser_title = $acf['title'];
				$about_us_teaser_text  = $acf['description'];

				update_field( 'about_us_page', $about_us_page, 'options' );
				update_field( 'about_us_teaser_image', $about_us_teaser_image, 'options' );
				update_field( 'about_us_teaser_title', $about_us_teaser_title, 'options' );
				update_field( 'about_us_teaser_text', $about_us_teaser_text, 'options' );
				break;

			case 'service':
				$sectors_page = $post_id;
				update_field( 'sectors_page', $sectors_page, 'options' );
				break;

			case 'contact':
				$contact_page = $post_id;
				update_field( 'contact_page', $contact_page, 'options' );
				break;

			case 'project':
				$projects_page = $post_id;
				update_field( 'projects_page', $projects_page, 'options' );
				break;

		endswitch;
	}

	/**
	 * Syncs service ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_service_acf_post_data( $post_id, $acf ) {

		$service_show_link        = true;
		$service_has_external_url = false;
		$service_external_url     = '';

		update_field( 'service_show_link', $service_show_link, $post_id );
		update_field( 'service_has_external_url', $service_has_external_url, $post_id );
		update_field( 'service_external_url', $service_external_url, $post_id );

		if ( isset( $acf['image_search'] ) && isset( $acf['alt_thumbnail'] ) ) :
			$search_image     = $acf['image_search'] ? get_existing_post_id( $acf['image_search'] ) : '';
			$search_image_alt = $acf['alt_thumbnail'];
			update_field( 'search_image', $search_image, $post_id );
			update_field( 'search_image_alt', $search_image_alt, $post_id );
		endif;

		if ( ! empty( $acf['article_modules_top'] ) ) :

			$acf_hero = $acf['article_modules_top'][0];

			$hero_type          = 'standard';
			$hero_text          = $acf_hero['text'];
			$hero_vertical_text = $acf_hero['vertical_text'];

			update_field( 'hero_type', $hero_type, $post_id );
			update_field( 'hero_text', $hero_text, $post_id );
			update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

		endif;

		$modules = convert_modules( $post_id, $acf );

		update_field( 'modules', $modules, $post_id );
	}

	/**
	 * Syncs project ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_project_acf_post_data( $post_id, $acf ) {

		if ( ! empty( $acf['module_tops'] ) ) :

			$acf_hero = $acf['module_tops'][0];

			$hero_type          = 'standard';
			$hero_text          = $acf_hero['text'];
			$hero_vertical_text = $acf_hero['vertical_text'];

			update_field( 'hero_type', $hero_type, $post_id );
			update_field( 'hero_text', $hero_text, $post_id );
			update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

		endif;

		$modules = convert_modules( $post_id, $acf );

		update_field( 'modules', $modules, $post_id );
	}

	/**
	 * Syncs sector ACF data.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf ACF data from the live site.
	 * @return void
	 */
	function sync_sector_acf_post_data( $post_id, $acf ) {

		$sector_teaser_text     = $acf['teaser'];
		$sector_is_external_url = isset( $acf['reference'] ) ? (bool) $acf['reference'] : false;
		$sector_external_url    = isset( $acf['link_external'] ) && ! empty( $acf['link_external'] ) ? $acf['link_external']['url'] : '';

		update_field( 'sector_teaser_text', $sector_teaser_text, $post_id );
		update_field( 'sector_is_external_url', $sector_is_external_url, $post_id );
		update_field( 'sector_external_url', $sector_external_url, $post_id );

		/* Update icon only first time, so that we do not overwrite our new icons */
		if ( ! get_field( 'sector_icon', $post_id ) ) :
			$sector_icon = $acf['icon_normal'] ? get_existing_post_id( $acf['icon_normal'] ) : '';
			update_field( 'sector_icon', $sector_icon, $post_id );
		endif;

		if ( ! empty( $acf['module_tops'] ) ) :

			$acf_hero = $acf['module_tops'][0];

			$hero_type          = 'standard';
			$hero_text          = $acf_hero['text'];
			$hero_vertical_text = $acf_hero['vertical_text'];

			update_field( 'hero_type', $hero_type, $post_id );
			update_field( 'hero_text', $hero_text, $post_id );
			update_field( 'hero_vertical_text', $hero_vertical_text, $post_id );

		endif;

		$modules = convert_modules( $post_id, $acf );

		update_field( 'modules', $modules, $post_id );
	}

	add_action(
		'init',
		function () {

			if ( isset( $_GET['convert_acf'] ) ) :
				convert_post_acf( $_GET['convert_acf'] );
				exit;
			endif;
			if ( isset( $_GET['delete_pages'] ) ) :

				$args = array(
					'post_type'      => 'page',
					'post_status'    => 'any',
					'fields'         => 'ids',
					'posts_per_page' => -1,
				);

				foreach ( get_posts( $args ) as $post_id ) :
					wp_delete_post( $post_id, true );
				endforeach;

				exit;
			endif;
		},
		PHP_INT_MAX
	);

	/**
	 * Converts ACF modules to the new format.
	 *
	 * @param  int     $post_id Post ID.
	 * @param  mixed[] $acf Post ACF data.
	 * @return mixed[] ACF modules data.
	 */
	function convert_modules( $post_id, $acf ) {

		$modules = array();

		switch ( $acf['page_template'] ) :

			case 'service':
				$modules[] = convert_sectors_grid( $acf );
				break;

			case 'ydelser':
				$modules[] = convert_services_grid( $acf );
				break;

		endswitch;

		$acf_modules = isset( $acf['modules'] ) && ! empty( $acf['modules'] ) ? $acf['modules'] : array();

		foreach ( $acf_modules as $module ) :

			$function_name = 'convert_' . str_replace( '-', '_', $module['acf_fc_layout'] );

			if ( function_exists( $function_name ) ) :

				$converted_module = call_user_func( $function_name, $module, $post_id );

				$modules[] = $converted_module;

			endif;

		endforeach;

		switch ( $acf['page_template'] ) :

			case 'contact':
				$modules[] = convert_employees_offices_finder( $acf );
				break;

		endswitch;

		return $modules;
	}


	/**
	 * Checks if URL matches some of the old URLs and replace it with new URL.
	 *
	 * @param  string $url URL.
	 * @return string URL.
	 */
	function maybe_convert_url( $url ) {

		global $wpdb;

		$url_parts = explode( '#', $url );

		$sanitized_url = rtrim( $url_parts[0], '/' );

		$sql = $wpdb->prepare(
			"SELECT p.ID FROM {$wpdb->posts} as p, {$wpdb->postmeta} as pm WHERE pm.post_id = p.ID AND pm.meta_key = '_import_url' AND pm.meta_value = %s AND p.post_type <> 'revision'",
			$sanitized_url
		);

		$post_id = $wpdb->get_var( $sql );

		if ( $post_id ) :

			if ( 'attachment' === get_post_type( $post_id ) ) :

				$url = wp_get_attachment_url( $post_id );

			else :

				$url = get_permalink( $post_id );

				if ( isset( $url_parts[1] ) && $url_parts[1] ) :
					$url .= '#' . $url_parts[1];
				endif;

			endif;

		endif;

		return $url;
	}

	/**
	 * Generate ACF link.
	 *
	 * @param  int    $type Link type.
	 * @param  int    $internal Post ID.
	 * @param  string $external URL.
	 * @param  string $title Link title.
	 * @return mixed[] Serialized ACF link.
	 */
	function generate_acf_link( $type, $internal = 0, $external = '', $title = '' ) {

		$link = '';

		switch ( (int) $type ) :

			case 0:
				if ( ! empty( $internal ) ) :

					$link_post_id = get_existing_post_id( $internal );

					$url = $link_post_id ? get_permalink( $link_post_id ) : '';

					$link = array(
						'url'    => $url,
						'title'  => $title,
						'target' => '',
					);

				endif;

				break;

			case 1:
				if ( ! empty( $external ) ) :

					$link = array(
						'url'    => maybe_convert_url( $external ),
						'title'  => $title,
						'target' => '',
					);

				endif;

				break;

		endswitch;

		return $link ? $link : '';
	}

	/**
	 * Converts the old module settings to the new module settings.
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module settings for the new site.
	 */
	function convert_module_settings( $module ) {

		$module_id                     = isset( $module['module_id'] ) ? $module['module_id'] : '';
		$module_spacing_top            = 'default';
		$module_spacing_top_desktop    = '';
		$module_spacing_top_mobile     = '';
		$module_spacing_bottom         = 'default';
		$module_spacing_bottom_desktop = '';
		$module_spacing_bottom_mobile  = '';

		if ( isset( $module['spacing_top'] ) ) :

			switch ( (int) $module['spacing_top'] ) :

				case 0:
					$module_spacing_top = 'large';
					break;

				case 1:
					$module_spacing_top = 'small';
					break;

				case 2:
					$module_spacing_top = 'none';
					break;

				case 3:
					$module_spacing_top         = 'custom';
					$module_spacing_top_desktop = $module['desktop_top_margin'];
					$module_spacing_top_mobile  = $module['mobile_top_margin'];
					break;

			endswitch;

		endif;

		if ( isset( $module['spacing_bottom'] ) ) :

			switch ( (int) $module['spacing_bottom'] ) :

				case 0:
					$module_spacing_bottom = 'large';
					break;

				case 1:
					$module_spacing_bottom = 'small';
					break;

				case 2:
					$module_spacing_bottom = 'none';
					break;

				case 3:
					$module_spacing_bottom         = 'custom';
					$module_spacing_bottom_desktop = $module['desktop_bottom_margin'];
					$module_spacing_bottom_mobile  = $module['mobile_bottom_margin'];
					break;

			endswitch;

		endif;

		$module_settings = compact(
			'module_id',
			'module_spacing_top',
			'module_spacing_top_desktop',
			'module_spacing_top_mobile',
			'module_spacing_bottom',
			'module_spacing_bottom_desktop',
			'module_spacing_bottom_mobile',
		);

		return $module_settings;
	}

	/**
	 * Converts the old "Quote Module" to the new "Quote".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_quote_module( $module ) {

		$quote_title = $module['head'];
		$quote_text  = $module['text'];

		$quote_link = generate_acf_link( $module['link_type'], $module['link_internal'], $module['link_external'], $module['link_title'] );

		$new_module = array(
			'acf_fc_layout' => 'quote',
			'quote_title'   => $quote_title,
			'quote_text'    => $quote_text,
			'quote_link'    => $quote_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Contact of Office" to the new "Office Employees".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_contact_of_office( $module ) {

		$office_employees_title = $module['title'];
		$office_employees_link  = generate_acf_link( $module['link_type'], $module['link_internal'], $module['link_external'], $module['link_title'] );

		$new_module = array(
			'acf_fc_layout'          => 'office-employees',
			'office_employees_title' => $office_employees_title,
			'office_employees_link'  => $office_employees_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Image video text" to the new "Image/Video Text".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_image_video_text( $module ) {

		$ivt_columns              = 0 === (int) $module['column_image'] ? '8' : '12';
		$ivt_image_enable         = ! empty( $module['image'] );
		$ivt_video_enable         = ! empty( $module['video_mp4'] ) || ! empty( $module['youtube_video_id'] );
		$ivt_text_enable          = ! empty( $module['head'] ) || ! empty( $module['text'] );
		$ivt_image                = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$ivt_image_alt            = $module['alt_text'];
		$ivt_image_size           = 0 === (int) $module['image_size'] ? 'landscape' : 'square';
		$ivt_image_position       = 0 === (int) $module['position_image'] ? 'left' : 'right';
		$ivt_video_type           = ! empty( $module['youtube_video_id'] ) ? 'youtube' : 'local';
		$ivt_video                = ! empty( $module['video_mp4'] ) ? get_existing_post_id( $module['video_mp4'] ) : '';
		$ivt_youtube_id           = $module['youtube_video_id'];
		$ivt_video_play_on_mobile = $module['play_video_on_mobile'] ? true : false;
		$ivt_video_autoplay       = $module['autoplay'] ? true : false;
		$ivt_video_loop           = $module['loop'] ? true : false;
		$ivt_title                = $module['head'];
		$ivt_text                 = $module['text'];
		$ivt_text_position        = match ( (int) $module['position_text'] ) {
			0 => 'top-left',
			1 => 'top-right',
			2 => 'bottom-left',
			3 => 'bottom-right',
			4 => 'below-image',
			default => 'top-left',
		};
		$ivt_text_center_mobile = $module['text_center_on_mobile'] ? true : false;

		$new_module = array(
			'acf_fc_layout'            => 'image-video-text',
			'ivt_columns'              => $ivt_columns,
			'ivt_image_enable'         => $ivt_image_enable,
			'ivt_video_enable'         => $ivt_video_enable,
			'ivt_text_enable'          => $ivt_text_enable,
			'ivt_image'                => $ivt_image,
			'ivt_image_alt'            => $ivt_image_alt,
			'ivt_image_size'           => $ivt_image_size,
			'ivt_image_position'       => $ivt_image_position,
			'ivt_video_type'           => $ivt_video_type,
			'ivt_video'                => $ivt_video,
			'ivt_youtube_id'           => $ivt_youtube_id,
			'ivt_video_play_on_mobile' => $ivt_video_play_on_mobile,
			'ivt_video_autoplay'       => $ivt_video_autoplay,
			'ivt_video_loop'           => $ivt_video_loop,
			'ivt_title'                => $ivt_title,
			'ivt_text'                 => $ivt_text,
			'ivt_text_position'        => $ivt_text_position,
			'ivt_text_center_mobile'   => $ivt_text_center_mobile,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Text Module" to the new "Text".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_text_module( $module ) {

		$project_details_translated = match ( get_current_language_code() ) {
			'da' => 'FAKTA',
			'en' => 'PROJECT DETAILS',
			'sv' => 'PROJEKT DETALJER',
			default => '',
		};

		$text_vertical_text = $module['has_vertical_text'] ? $project_details_translated : '';
		$text_items         = array();
		$text_sidebar_type  = $module['has_image'] ? 'image' : 'text';
		$text_image         = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$text_image_alt     = $module['alt_text'];
		$text_sidebar_items = array();

		if ( ! empty( $module['content_right'] ) ) :

			foreach ( $module['content_right'] as $content_right_item ) :

				$text_item = array();

				switch ( $content_right_item['acf_fc_layout'] ) :

					case 'text':
						$text_item['type']       = 'text';
						$text_item['title_size'] = match ( (int) $content_right_item['title_size'] ) {
							0 => 'small',
							1 => 'medium',
							2 => 'big',
						};
						$text_item['text_size'] = match ( (int) $content_right_item['text_size'] ) {
							0 => 'small',
							1 => 'medium',
							2 => 'big',
						};
						$text_item['title'] = $content_right_item['title'];
						$text_item['text']  = $content_right_item['text'];
						break;

					case 'list_link':
						$text_item['type']  = 'links';
						$text_item['links'] = array();

						if ( ! empty( $content_right_item['text_list_link'] ) ) :

							foreach ( $content_right_item['text_list_link'] as $link ) :

								$text_item['links'][] = array(
									'title' => $link['text'],
									'url'   => maybe_convert_url( $link['url'] ),
								);

								endforeach;

							endif;

						break;

				endswitch;

				$text_items[] = $text_item;

			endforeach;

		endif;

		if ( ! empty( $module['content_left'] ) ) :

			foreach ( $module['content_left'] as $content_left_item ) :

				$text_sidebar_item = array(
					'title' => $content_left_item['head'],
					'links' => array(),
				);

				if ( ! empty( $content_left_item['link_list'] ) ) :

					foreach ( $content_left_item['link_list'] as $link ) :

						$text_sidebar_item['links'][] = array(
							'title' => $link['text'],
							'url'   => maybe_convert_url( $link['url'] ),
						);

					endforeach;

				endif;

				$text_sidebar_items[] = $text_sidebar_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'      => 'text',
			'text_vertical_text' => $text_vertical_text,
			'text_items'         => $text_items,
			'text_sidebar_type'  => $text_sidebar_type,
			'text_image'         => $text_image,
			'text_image_alt'     => $text_image_alt,
			'text_sidebar_items' => $text_sidebar_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Two Thumb" to the new "Two Thumbs".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_thumbs_2( $module ) {

		$two_thumb_align = match ( (int) $module['case'] ) {
			0 => 'left',
			1 => 'right',
			2 => 'center',
		};

			$two_thumbs_items = array();

		if ( ! empty( $module['thumb_list'] ) ) :

			foreach ( $module['thumb_list'] as $thumb ) :

				$two_thumbs_item = array(
					'image'          => ! empty( $thumb['image'] ) ? get_existing_post_id( $thumb['image'] ) : '',
					'image_alt_text' => $thumb['alt_text'],
					'vertical_text'  => $thumb['vertial_text'],
					'title'          => $thumb['head'],
					'text'           => $thumb['text'],
					'link'           => generate_acf_link( $thumb['link_type'], $thumb['link_internal'], $thumb['link_external'], $thumb['link_title'] ),
				);

				$two_thumbs_items[] = $two_thumbs_item;

				endforeach;

			endif;

			$new_module = array(
				'acf_fc_layout'    => 'two-thumbs',
				'two_thumb_align'  => $two_thumb_align,
				'two_thumbs_items' => $two_thumbs_items,
			);

			$new_module = array_merge( $new_module, convert_module_settings( $module ) );

			return $new_module;
	}

	/**
	 * Converts the old "Slider" to the new "Slider".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_slider_module( $module ) {

		$slider_type          = $module['advance'] ? 'advanced' : 'simple';
		$slider_vertical_text = $module['text_vertical'];
		$slider_items         = array();

		if ( ! empty( $module['slider'] ) ) :

			foreach ( $module['slider'] as $slide ) :

				$slider_item = array(
					'image'          => ! empty( $slide['image'] ) ? get_existing_post_id( $slide['image'] ) : '',
					'image_alt_text' => $slide['alt_text'],
					'title'          => $slide['header'],
					'text'           => $slide['content'],
					'link'           => array(
						'title'  => $slide['link_title'],
						'url'    => maybe_convert_url( $slide['link'] ),
						'target' => '',
					),
				);

				$slider_items[] = $slider_item;

				endforeach;

			endif;

		$new_module = array(
			'acf_fc_layout'        => 'slider',
			'slider_type'          => $slider_type,
			'slider_vertical_text' => $slider_vertical_text,
			'slider_items'         => $slider_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "New CTA" to the new "New CTA".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_new_cta( $module ) {

		$new_cta_type         = $module['type'];
		$new_cta_link         = $module['link'];
		$new_cta_phone        = $module['phone'];
		$new_cta_email        = $module['email'];
		$new_cta_button_title = $module['button_title'];
		$new_cta_center       = 'center' === $module['position'];

		if ( $new_cta_link && $new_cta_link['url'] ) :
			$new_cta_link['url'] = maybe_convert_url( $new_cta_link['url'] );
			endif;

		$new_module = array(
			'acf_fc_layout'        => 'new-cta',
			'new_cta_type'         => $new_cta_type,
			'new_cta_link'         => $new_cta_link,
			'new_cta_phone'        => $new_cta_phone,
			'new_cta_email'        => $new_cta_email,
			'new_cta_button_title' => $new_cta_button_title,
			'new_cta_center'       => $new_cta_center,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Double Image or Video" to the new "Double Image or Video".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_double_video_image( $module ) {

		$double_image_video_title        = $module['head'];
		$double_image_video_text         = $module['text'];
		$double_image_video_content_left = array(
			'image'       => ! empty( $module['image_1'] ) ? get_existing_post_id( $module['image_1'] ) : '',
			'image_alt'   => $module['alt_text_first'],
			'image_size'  => match ( (int) $module['size_image_1'] ) {
			0 => 'square',
			1 => 'landscape',
			},
			'image_align' => match ( (int) $module['align_image_1'] ) {
				0 => 'top',
				1 => 'bottom',
			},
		);
		$double_image_video_content_right = array(
			'image'                => ! empty( $module['image_second'] ) ? get_existing_post_id( $module['image_second'] ) : '',
			'image_alt'            => $module['alt_text_second'],
			'image_size'           => match ( (int) $module['size_image_2'] ) {
			0 => 'square',
			1 => 'landscape',
			},
			'video_type'           => match ( (int) $module['case_image_video_2'] ) {
				0 => 'none',
				1 => $module['youtube_video_id'] ? 'youtube' : ( $module['video_mp4'] ? 'local' : 'none' ),
			},
			'video'                => ! empty( $module['video_mp4'] ) ? get_existing_post_id( $module['video_mp4'] ) : '',
			'youtube_id'           => $module['youtube_video_id'],
			'video_play_on_mobile' => (bool) $module['play_video_on_mobile'],
			'video_autoplay'       => (bool) $module['autoplay'],
			'video_loop'           => (bool) $module['loop'],
		);

		$new_module = array(
			'acf_fc_layout'                    => 'double-video-image',
			'double_image_video_title'         => $double_image_video_title,
			'double_image_video_text'          => $double_image_video_text,
			'double_image_video_content_left'  => $double_image_video_content_left,
			'double_image_video_content_right' => $double_image_video_content_right,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "CTA Contact" to the new "CTA Contact".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_cta_contact( $module ) {

		$cta_contact_title     = $module['title'];
		$cta_contact_subtitle  = $module['sub_title'];
		$cta_contact_image     = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$cta_contact_text      = $module['description'];
		$cta_contact_link_type = match ( $module['link_type'] ) {
			'email' => 'email',
			'phone' => 'phone',
			'internal', 'external' => 'url',
			default => 'url',
		};
		$cta_contact_link = match ( $module['link_type'] ) {
			'email', 'phone' => '',
			'internal' => generate_acf_link( type: 0, internal: $module['link_internal'], title: $module['link_title'] ),
			'external' => generate_acf_link( type: 1, external: $module['link_external'], title: $module['link_title'] ),
			default => '',
		};
		$cta_contact_phone        = 'phone' === $cta_contact_link_type ? $module['link_external'] : '';
		$cta_contact_email        = 'email' === $cta_contact_link_type ? $module['link_external'] : '';
		$cta_contact_button_title = $module['link_title'];

		$new_module = array(
			'acf_fc_layout'            => 'cta-contact',
			'cta_contact_title'        => $cta_contact_title,
			'cta_contact_subtitle'     => $cta_contact_subtitle,
			'cta_contact_image'        => $cta_contact_image,
			'cta_contact_text'         => $cta_contact_text,
			'cta_contact_link_type'    => $cta_contact_link_type,
			'cta_contact_link'         => $cta_contact_link,
			'cta_contact_phone'        => $cta_contact_phone,
			'cta_contact_email'        => $cta_contact_email,
			'cta_contact_button_title' => $cta_contact_button_title,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Big/small thumbs" to the new "Big Small Thumbs".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_big_small_thumbs( $module ) {

		$big_small_thumbs_grey_background = (bool) $module['gray_background'];
		$big_small_thumbs_align           = match ( (int) $module['align'] ) {
			0 => 'bottom',
			1 => 'center',
			2 => 'top',
			default => 'top',
		};
		$big_small_thumbs_items = array();

		if ( ! empty( $module['thumb_list'] ) ) :

			foreach ( $module['thumb_list'] as $item ) :

				$big_small_thumbs_item = array(
					'image'          => ! empty( $item['image'] ) ? get_existing_post_id( $item['image'] ) : '',
					'image_alt_text' => $item['alt_text'],
					'title'          => $item['head'],
					'text'           => $item['text'],
					'link'           => generate_acf_link( $item['link_type'], $item['link_internal'], $item['link_external'], $item['link_title'] ),
				);

				$big_small_thumbs_items[] = $big_small_thumbs_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'                    => 'big-small-thumbs',
			'big_small_thumbs_grey_background' => $big_small_thumbs_grey_background,
			'big_small_thumbs_align'           => $big_small_thumbs_align,
			'big_small_thumbs_items'           => $big_small_thumbs_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Three thumbs" to the new "Three Thumbs".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_thumbs_3( $module ) {

		$three_thumbs_items = array();

		if ( ! empty( $module['thumb_list'] ) ) :

			foreach ( $module['thumb_list'] as $item ) :

				$three_thumbs_item = array(
					'image'          => ! empty( $item['image'] ) ? get_existing_post_id( $item['image'] ) : '',
					'image_alt_text' => $item['alt_text'],
					'image_size'     => match ( (int) $item['image_size'] ) {
						0 => 'square',
						1 => 'portrait',
						2 => 'landscape',
						default => 'square',
					},
					'title'          => $item['head'],
					'text'           => $item['text'],
					'link'           => generate_acf_link( $item['link_type'], $item['link_internal'], $item['link_external'], $item['link_title'] ),
				);

				$three_thumbs_items[] = $three_thumbs_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'      => 'three-thumbs',
			'three_thumbs_items' => $three_thumbs_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "USP" to the new "USP".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_usp( $module ) {

		$usp_red_background = (bool) $module['red_background'];
		$usp_title          = $module['title'];

		$usp_items = array();

		if ( ! empty( $module['columns'] ) ) :

			foreach ( $module['columns'] as $item ) :

				$usp_item = array(
					'title' => $item['title'],
					'text'  => $item['content'],
				);

				$usp_items[] = $usp_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'      => 'usp',
			'usp_red_background' => $usp_red_background,
			'usp_title'          => $usp_title,
			'usp_items'          => $usp_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Full viewport image" to the new "Full Viewport Image".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_full_viewport_image( $module ) {

		$fvi_image     = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$fvi_image_alt = $module['alt_text'];

		$new_module = array(
			'acf_fc_layout' => 'full-viewport-image',
			'fvi_image'     => $fvi_image,
			'fvi_image_alt' => $fvi_image_alt,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "List Employee" to the new "Employees Grid".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_list_employee( $module ) {

		$employees_grid_title = $module['title'];
		$employees_grid_items = array();
		$employees_grid_link  = generate_acf_link( $module['link_type'], $module['link_internal'], $module['link_external'], $module['link_title'] );

		if ( ! empty( $module['list_employee'] ) ) :

			foreach ( $module['list_employee'] as $item ) :

				if ( ! empty( $item['employee'] ) ) :

					$employee_post_id = get_existing_post_id( $item['employee'] );

					if ( $employee_post_id ) :
						$employees_grid_items[] = $employee_post_id;
					endif;

				endif;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'        => 'employees-grid',
			'employees_grid_title' => $employees_grid_title,
			'employees_grid_items' => $employees_grid_items,
			'employees_grid_link'  => $employees_grid_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Thumb 8 col" to the new "Thumb 8 col".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_thumb_8col( $module ) {

		$thumb_8col_grey_background = (bool) $module['gray_backround'];
		$thumb_8col_image_enable    = ! empty( $module['image'] );
		$thumb_8col_video_enable    = ! empty( $module['video_mp4'] ) || ! empty( $module['youtube_video_id'] );
		$thumb_8col_text_enable     = ! empty( $module['head'] ) || ! empty( $module['text'] );
		$thumb_8col_image           = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$thumb_8col_image_alt       = $module['alt_text'];
		$thumb_8col_image_size      = 'landscape';
		$thumb_8col_image_align     = match ( (int) $module['align_image'] ) {
			0 => 'left',
			1 => 'center',
			default => 'left',
		};
		$thumb_8col_video_type           = ! empty( $module['youtube_video_id'] ) ? 'youtube' : 'local';
		$thumb_8col_video                = ! empty( $module['video_mp4'] ) ? get_existing_post_id( $module['video_mp4'] ) : '';
		$thumb_8col_youtube_id           = $module['youtube_video_id'];
		$thumb_8col_video_play_on_mobile = (bool) $module['play_video_on_mobile'];
		$thumb_8col_video_autoplay       = (bool) $module['autoplay'];
		$thumb_8col_video_loop           = (bool) $module['loop'];
		$thumb_8col_title                = $module['head'];
		$thumb_8col_text                 = $module['text'];
		$thumb_8col_link                 = generate_acf_link( $module['link_type'], $module['link_internal'], $module['link_external'], $module['link_title'] );

		$new_module = array(
			'acf_fc_layout'                   => 'thumb-8col',
			'thumb_8col_grey_background'      => $thumb_8col_grey_background,
			'thumb_8col_image_enable'         => $thumb_8col_image_enable,
			'thumb_8col_video_enable'         => $thumb_8col_video_enable,
			'thumb_8col_text_enable'          => $thumb_8col_text_enable,
			'thumb_8col_image'                => $thumb_8col_image,
			'thumb_8col_image_alt'            => $thumb_8col_image_alt,
			'thumb_8col_image_size'           => $thumb_8col_image_size,
			'thumb_8col_image_align'          => $thumb_8col_image_align,
			'thumb_8col_video_type'           => $thumb_8col_video_type,
			'thumb_8col_video'                => $thumb_8col_video,
			'thumb_8col_youtube_id'           => $thumb_8col_youtube_id,
			'thumb_8col_video_play_on_mobile' => $thumb_8col_video_play_on_mobile,
			'thumb_8col_video_autoplay'       => $thumb_8col_video_autoplay,
			'thumb_8col_video_loop'           => $thumb_8col_video_loop,
			'thumb_8col_title'                => $thumb_8col_title,
			'thumb_8col_text'                 => $thumb_8col_text,
			'thumb_8col_link'                 => $thumb_8col_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "CTA" to the new "CTA".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_cta_ydelser( $module ) {

		$cta_image        = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$cta_image_alt    = '';
		$cta_image_align  = $module['image_position'];
		$cta_contact_text = $module['description'];
		$cta_image_size   = 'square';
		$cta_title        = $module['title'];
		$cta_subtitle     = $module['sub_title'];
		$cta_text         = $module['description'];
		$cta_link         = generate_acf_link( $module['link_type'], $module['link_internal'], $module['link_external'], $module['link_title'] );

		$new_module = array(
			'acf_fc_layout'   => 'cta',
			'cta_image'       => $cta_image,
			'cta_image_alt'   => $cta_image_alt,
			'cta_image_align' => $cta_image_align,
			'cta_image_size'  => $cta_image_size,
			'cta_title'       => $cta_title,
			'cta_subtitle'    => $cta_subtitle,
			'cta_text'        => $cta_text,
			'cta_link'        => $cta_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}


	/**
	 * Converts the old "Four thumbs Version 2" to the new "Four Thumbs".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_new_thumbs_4( $module ) {

		$four_thumbs_items = array();

		if ( ! empty( $module['thumb_list'] ) ) :

			foreach ( $module['thumb_list'] as $item ) :

				$four_thumbs_item = array(
					'image'          => ! empty( $item['image'] ) ? get_existing_post_id( $item['image'] ) : '',
					'image_alt_text' => $item['alt'],
					'image_size'     => 'square',
					'title'          => $item['headline'],
					'subtitle'       => $item['title'],
					'text'           => '',
					'position'       => $item['position'],
					'phone'          => $item['phone'],
					'email'          => $item['email'],
					'link'           => '',
				);

				$four_thumbs_items[] = $four_thumbs_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'     => 'four-thumbs',
			'four_thumbs_items' => $four_thumbs_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Contact/Download" to the new "Contact Teaser".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_contact_download( $module ) {

		$contact_teaser_image = ! empty( $module['image'] ) ? get_existing_post_id( $module['image'] ) : '';
		$contact_teaser_title = $module['head'];
		$contact_teaser_text  = $module['text'];
		$contact_teaser_link  = ! empty( $module['link'] ) ? generate_acf_link( type: 1, external: $module['link'], title: $module['link_title'] ) : '';

		$new_module = array(
			'acf_fc_layout'        => 'contact-teaser',
			'contact_teaser_image' => $contact_teaser_image,
			'contact_teaser_title' => $contact_teaser_title,
			'contact_teaser_text'  => $contact_teaser_text,
			'contact_teaser_link'  => $contact_teaser_link,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts the old "Contact Form Module" to the new "Form".
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_contact_form_module( $module ) {

		$form_title = $module['head'];
		$form_text  = $module['text'];

		$new_module = array(
			'acf_fc_layout' => 'form',
			'form_title'    => $form_title,
			'form_text'     => $form_text,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts Sectors page to "Sectors Grid" module.
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_sectors_grid( $module ) {

		$sectors_grid_items = array();

		if ( ! empty( $module['list_service'] ) ) :

			foreach ( $module['list_service'] as $item ) :

				$sector_post_id = ! empty( $item['service'] ) ? get_existing_post_id( $item['service'] ) : '';

				if ( $sector_post_id ) :

					$sectors_grid_items[] = $sector_post_id;

				endif;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'      => 'sectors-grid',
			'sectors_grid_items' => $sectors_grid_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts Contact page to "Employees & Offices Finder" module.
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_employees_offices_finder( $module ) {

		$finder_title = $module['find_us_title'];
		$finder_text  = $module['find_us_teaser'];
		$finder_items = array();

		if ( ! empty( $module['office_image_list'] ) ) :

			foreach ( $module['office_image_list'] as $item ) :

				$image_post_id = ! empty( $item['image'] ) ? get_existing_post_id( $item['image'] ) : '';

				if ( $image_post_id ) :

					$finder_items[] = array(
						'image'     => $image_post_id,
						'image_alt' => $item['alt_text'],
					);

				endif;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout' => 'employees-offices-finder',
			'finder_title'  => $finder_title,
			'finder_text'   => $finder_text,
			'finder_items'  => $finder_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}

	/**
	 * Converts Ydelser page to "Services Grid" module.
	 *
	 * @param  mixed $module ACF module data from the old site.
	 * @return mixed ACF module data for the new site.
	 */
	function convert_services_grid( $module ) {

		$service_grid_items = array();

		if ( ! empty( $module['list_ydelser'] ) ) :

			foreach ( $module['list_ydelser'] as $item ) :

				$service_grid_item = array();

				if ( 'internal' === $item['link_type'] && ! empty( $item['ydelser'] ) ) :
					$service_grid_item['link_type']    = 'internal';
					$service_grid_item['title']        = $item['title'];
					$service_grid_item['post']         = ! empty( $item['ydelser'] ) ? get_existing_post_id( $item['ydelser'] ) : '';
					$service_grid_item['external_url'] = '';
				elseif ( 'external' === $item['link_type'] && ! empty( $item['link_external'] ) ) :
					$service_grid_item['link_type']    = 'external';
					$service_grid_item['title']        = $item['title'];
					$service_grid_item['post']         = '';
					$service_grid_item['external_url'] = $item['link_external'];
				else :
					$service_grid_item['link_type']    = 'none';
					$service_grid_item['title']        = $item['title'];
					$service_grid_item['post']         = '';
					$service_grid_item['external_url'] = '';
				endif;

				$service_grid_items[] = $service_grid_item;

			endforeach;

		endif;

		$new_module = array(
			'acf_fc_layout'      => 'services-grid',
			'service_grid_items' => $service_grid_items,
		);

		$new_module = array_merge( $new_module, convert_module_settings( $module ) );

		return $new_module;
	}


endif;
