<?php
/**
 * Adds SVG support
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Allow SGV upload.
 *
 * @param array         $data {
 *     Values for the extension, mime type, and corrected filename.
 *
 *     @type string|false $ext             File extension, or false if the file doesn't match a mime type.
 *     @type string|false $type            File mime type, or false if the file doesn't match a mime type.
 *     @type string|false $proper_filename File name with its correct extension, or false if it cannot be determined.
 * }
 * @param string        $file                      Full path to the file.
 * @param string        $filename                  The name of the file (may differ from $file due to
 *                                                 $file being in a tmp directory).
 * @param string[]|null $mimes                     Array of mime types keyed by their file extension regex, or null if
 *                                                 none were provided.
 * @return array
 */
function allow_svg_file_type( $data, $file, $filename, $mimes ) {
	$filetype = wp_check_filetype( $filename, $mimes );
	return array(
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	);
}

add_filter( 'wp_check_filetype_and_ext', 'allow_svg_file_type', 10, 4 );

/**
 * Add SVG mime type to allowed mime types for upload.
 *
 * @param  array $mimes Array of allowed mime types.
 * @return array
 */
function add_svg_mime_type( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter( 'upload_mimes', 'add_svg_mime_type' );
