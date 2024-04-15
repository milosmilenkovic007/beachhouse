<?php
/**
 * Thumb 8 col module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'grey_background'      => $args['thumb_8col_grey_background'],
		'has_image'            => $args['thumb_8col_image_enable'],
		'image'                => $args['thumb_8col_image'],
		'image_alt'            => $args['thumb_8col_image_alt'],
		'image_align'          => $args['thumb_8col_image_align'],
		'image_size'           => $args['thumb_8col_image_size'],
		'has_video'            => $args['thumb_8col_video_enable'],
		'video_type'           => $args['thumb_8col_video_type'],
		'video_url'            => 'youtube' === $args['thumb_8col_video_type'] ? get_youtube_embed_url( $args['thumb_8col_youtube_id'] ) : $args['thumb_8col_video']['url'],
		'video_loop'           => $args['thumb_8col_video_loop'],
		'video_autoplay'       => $args['thumb_8col_video_autoplay'],
		'video_play_on_mobile' => $args['thumb_8col_video_play_on_mobile'],
		'has_text'             => $args['thumb_8col_text_enable'],
		'title'                => $args['thumb_8col_title'],
		'text'                 => $args['thumb_8col_text'],
		'link'                 => $args['thumb_8col_link'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_thumb_8col_module( $config );
