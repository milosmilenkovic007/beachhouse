<?php
/**
 * New CTA module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

switch ( $args['new_cta_type'] ) :

	case 'url':
		$title  = $args['new_cta_link']['title'];
		$url    = $args['new_cta_link']['url'];
		$target = $args['new_cta_link']['target'];
		break;

	case 'phone':
		$title  = $args['new_cta_button_title'];
		$url    = sprintf(
			'tel:%1$s',
			$args['new_cta_phone']
		);
		$target = '';
		break;

	case 'email':
		$title  = $args['new_cta_button_title'];
		$url    = sprintf(
			'mailto:%1$s',
			$args['new_cta_email']
		);
		$target = '_blank';
		break;

endswitch;

$config = array(
	'data'   => array(
		'title'  => $title,
		'url'    => $url,
		'target' => $target,
		'center' => boolval( $args['new_cta_center'] ),
	),
	'module' => get_module_settings( $args ),
);

echo generate_new_cta_module( $config );
