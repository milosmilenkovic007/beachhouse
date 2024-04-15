<?php
/**
 * Image/Video Text module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$config = array(
	'data'   => array(
		'fullwidth'            => 12 === intval( $args['ivt_columns'] ),
		'has_image'            => $args['ivt_image_enable'],
		'image'                => $args['ivt_image'],
		'image_alt'            => $args['ivt_image_alt'],
		'image_size'           => $args['ivt_image_size'],
		'image_position'       => $args['ivt_image_position'],
		'has_video'            => $args['ivt_video_enable'],
		'video_type'           => $args['ivt_video_type'],
		'video_url'            => 'youtube' === $args['ivt_video_type'] ? get_youtube_embed_url( $args['ivt_youtube_id'] ) : $args['ivt_video']['url'],
		'video_play_on_mobile' => $args['ivt_video_play_on_mobile'],
		'video_autoplay'       => $args['ivt_video_autoplay'],
		'video_loop'           => $args['ivt_video_loop'],
		'has_text'             => $args['ivt_text_enable'],
		'title'                => $args['ivt_title'],
		'text'                 => $args['ivt_text'],
		'text_position'        => $args['ivt_text_position'],
		'text_center_mobile'   => $args['ivt_text_center_mobile'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_image_video_text_module( $config );
