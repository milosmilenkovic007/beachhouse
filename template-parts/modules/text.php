<?php
/**
 * Text module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

$image         = null;
$image_alt     = '';
$sidebar_items = array();
$content_items = array();

switch ( $args['text_sidebar_type'] ) :

	case 'text':
		if ( ! empty( $args['text_sidebar_items'] ) ) :
			foreach ( $args['text_sidebar_items'] as $item ) :
				$links = array();
				foreach ( $item['links'] as $link ) :
					$links[] = array(
						'title' => $link['title'],
						'url'   => $link['url'],
					);
				endforeach;
				$sidebar_items[] = array(
					'title' => $item['title'],
					'links' => $links,
				);
			endforeach;
		endif;

		break;

	case 'image':
		$image     = $args['text_image'];
		$image_alt = $args['text_image_alt'];

		break;

endswitch;

if ( ! empty( $args['text_items'] ) ) :
	foreach ( $args['text_items'] as $item ) :
		switch ( $item['type'] ) :

			case 'text':
				$content_items[] = array(
					'type'       => 'text',
					'title'      => $item['title'],
					'title_size' => $item['title_size'],
					'text'       => $item['text'],
					'text_size'  => $item['text_size'],
				);
				break;

			case 'links':
				$content_items[] = array(
					'type'  => 'links',
					'links' => $item['links'],
				);
				break;

		endswitch;
	endforeach;
endif;

$config = array(
	'data'   => array(
		'vertical_text' => $args['text_vertical_text'],
		'image'         => $image,
		'image_alt'     => $image_alt,
		'sidebar_items' => $sidebar_items,
		'content_items' => $content_items,
	),
	'module' => get_module_settings( $args ),
);

echo generate_text_module( $config );
