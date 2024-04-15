<?php
/**
 * Add JSON support
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Allow additional MIME types
 * Use 'text/plain' instead of 'application/json' for JSON because of a current Wordpress core bug
 */

/**
 * Allow additional MIME types
 * Use 'text/plain' instead of 'application/json' for JSON because of a current Wordpress core bug.
 *
 * @param  mixed $types Allowed mime types for upload.
 * @return array
 */
function add_upload_mimes( $types ) {
	$types['json'] = 'text/plain';
	return $types;
}

add_filter( 'upload_mimes', 'add_upload_mimes' );
