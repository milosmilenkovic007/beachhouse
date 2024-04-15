<?php
/**
 * Double Video or Image module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$content_left  = $args['double_image_video_content_left'];
$content_right = $args['double_image_video_content_right'];

$config = array(
	'data'   => array(
		'title'                      => $args['double_image_video_title'],
		'text'                       => $args['double_image_video_text'],
		'left_image'                 => $content_left['image'],
		'left_image_alt'             => $content_left['image_alt'],
		'left_image_align'           => $content_left['image_align'],
		'left_image_size'            => $content_left['image_size'],
		'right_image'                => $content_right['image'],
		'right_image_alt'            => $content_right['image_alt'],
		'right_image_size'           => $content_right['image_size'],
		'right_video_type'           => $content_right['video_type'],
		'right_video_url'            => match ( $content_right['video_type'] ) {
			'youtube' => get_youtube_embed_url( $content_right['youtube_id'], $content_right['video_loop'] ),
			'local' => $content_right['video']['url'],
			default => ''
		},
		'right_video_autoplay'       => $content_right['video_autoplay'],
		'right_video_loop'           => $content_right['video_loop'],
		'right_video_play_on_mobile' => $content_right['video_play_on_mobile'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_double_video_image_module( $config );
