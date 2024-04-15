<?php
/**
 * Theme customizations
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Instantly duplicate post instead of attempting to create new.
 *
 * @param  int    $post_id ID of the post to duplicate.
 * @param  string $lang Language to which to duplicate.
 * @return int ID of the duplicated post.
 */
function wpml_duplicate_post( $post_id, $lang ) {
	global $sitepress;
	return $sitepress->make_duplicate( $post_id, $lang );
}

/**
 * Get post ID in source language from translation id
 *
 * @param  int $trid Translation ID.
 * @return int Source language Post ID.
 */
function get_source_post_id_from_trid( $trid ) {
	global $wpdb;

	$sql = $wpdb->prepare(
		'SELECT element_id FROM ' . $wpdb->prefix . 'icl_translations WHERE trid = %d AND source_language_code IS NULL ',
		$trid
	);

	return $wpdb->get_var( $sql );
}

/**
 * Return WPML post language.
 *
 * @param  int $post_id Post ID.
 * @return string Post's WPML language code.
 */
function get_post_language( $post_id ) {

	$args    = array(
		'element_id'   => $post_id,
		'element_type' => get_post_type( $post_id ),
	);
	$details = apply_filters( 'wpml_element_language_details', null, $args );

	return $details ? $details->language_code : 'da';
}

/**
 * Return array of all post translations.
 *
 * @param  int $source_post_id Source post ID.
 * @return int[] Array of translation post IDs.
 */
function get_post_translations( $source_post_id ) {

	$items = array();

	$type = apply_filters( 'wpml_element_type', get_post_type( $source_post_id ) );
	$trid = apply_filters( 'wpml_element_trid', false, $source_post_id, $type );

	$translations = apply_filters( 'wpml_get_element_translations', array(), $trid, $type );

	if ( $translations ) :
		foreach ( $translations as  $translation ) :
			if ( ! $translation->original ) :
				$items[] = $translation->element_id;
			endif;
		endforeach;
	endif;

	return $items;
}

add_action(
	'current_screen',
	function () {

		$screen = get_current_screen();

		if ( 'post' === $screen->base && 'add' === $screen->action && isset( $_GET['lang'] ) && isset( $_GET['trid'] ) && isset( $_GET['source_lang'] ) ) :

			$trid           = $_GET['trid'];
			$lang           = $_GET['lang'];
			$master_post_id = get_source_post_id_from_trid( $trid );

			$translated_post_id = wpml_duplicate_post( $master_post_id, $lang );

			global $iclTranslationManagement;
			$iclTranslationManagement->reset_duplicate_flag( $translated_post_id );

			$query_args = array(
				'post'   => $translated_post_id,
				'action' => 'edit',
				'lang'   => $lang,
			);

			$edit_page_url = add_query_arg( $query_args, admin_url( 'post.php' ) );
			wp_redirect( $edit_page_url );
			exit;
		endif;
	}
);

add_action(
	'wpml_before_make_duplicate',
	function () {
		global $iclTranslationManagement;
		$section = 'custom_fields_translation';

		if ( isset( $iclTranslationManagement->settings[ $section ] ) ) {
			foreach ( $iclTranslationManagement->settings[ $section ] as $meta_key => $translation_type ) {
				if ( 0 === strpos( $meta_key, 'modules_' ) || 0 === strpos( $meta_key, '_modules_' ) ) :
					$iclTranslationManagement->settings[ $section ][ $meta_key ] = WPML_COPY_ONCE_CUSTOM_FIELD;
				endif;
			}
		}

		$section = 'custom_fields_readonly_config';

		if ( isset( $iclTranslationManagement->settings[ $section ] ) ) {
			foreach ( $iclTranslationManagement->settings[ $section ] as $meta_key => $translation_type ) {
				if ( 0 === strpos( $meta_key, 'modules_' ) || 0 === strpos( $meta_key, '_modules_' ) ) :
					$iclTranslationManagement->settings[ $section ][ $meta_key ] = WPML_COPY_ONCE_CUSTOM_FIELD;
				endif;
			}
		}
	}
);

/**
 * When custom field has been copied, adjusts its values to represent translated objects.
 *
 * @param int    $post_id_from The ID of the original post.
 * @param int    $post_id_to   The ID of translated post.
 * @param string $meta_key     The meta key of copied custom field.
 */
function after_copy_custom_field( $post_id_from, $post_id_to, $meta_key ) {

	$field = acf_get_field( $meta_key );

	if ( $field ) :
		return;
	endif;

	global $wpdb;

	$field_key = $wpdb->get_var(
		$wpdb->prepare(
			'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE post_id = %d AND meta_key = %s',
			$post_id_from,
			$meta_key
		)
	);

	if ( ! $field_key ) :
		return;
	endif;

	$field = acf_get_field( $field_key );

	if ( $field ) {

		$value_meta_key = ltrim( $meta_key, '_' );

		if ( $value_meta_key !== $meta_key ) :

			$meta_value = $wpdb->get_var(
				$wpdb->prepare(
					'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE post_id = %d AND meta_key = %s',
					$post_id_from,
					substr( $meta_key, 1 )
				)
			);

			$meta_value_converted = $meta_value;

			if ( $meta_value ) :
				update_post_meta( $post_id_to, $value_meta_key, $meta_value_converted );
			endif;

		endif;
	}
}

add_action( 'wpml_after_copy_custom_field', 'after_copy_custom_field', 10, 3 );

add_filter(
	'acf/load_value/name=employee_office',
	function ( $value ) {

		if ( ! empty( $value ) ) :

			$is_serialized = is_string( $value );

			$value = $is_serialized ? maybe_unserialize( $value ) : $value;

			foreach ( $value as $index => $value_post_id ) :

				$translated_value_post_id = apply_filters( 'wpml_object_id', $value_post_id );

				if ( ! $translated_value_post_id ) :
					continue;
				endif;

				$value[ $index ] = $translated_value_post_id;

			endforeach;

		endif;

		return $value;
	}
);

/**
 * Switch ACF current language after WPML changes language.
 *
 * @return void
 */
function switch_acf_language() {
	acf_update_setting( 'current_language', get_current_language_code() );
}

add_action( 'wpml_language_has_switched', 'switch_acf_language' );
