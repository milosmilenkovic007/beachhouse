<?php
/**
 * CTA Contact module template part.
 *
 * @package Milos
 * @subpackage Chriss
 */

switch ( $args['cta_contact_link_type'] ) :

	case 'url':
		$button = array(
			'title'  => $args['cta_contact_link']['title'],
			'url'    => $args['cta_contact_link']['url'],
			'target' => $args['cta_contact_link']['target'],
		);
		break;

	case 'phone':
		$button = array(
			'title'  => $args['cta_contact_button_title'],
			'url'    => sprintf(
				'tel:%1$s',
				$args['cta_contact_phone']
			),
			'target' => '',
		);
		break;

	case 'email':
		$button = array(
			'title'  => $args['cta_contact_button_title'],
			'url'    => sprintf(
				'mailto:%1$s',
				$args['cta_contact_email']
			),
			'target' => '_blank',
		);
		break;

endswitch;

$config = array(
	'data'   => array(
		'title'    => $args['cta_contact_title'],
		'subtitle' => $args['cta_contact_subtitle'],
		'text'     => $args['cta_contact_text'],
		'image'    => $args['cta_contact_image'],
		'button'   => $button,
	),
	'module' => get_module_settings( $args ),
);

echo generate_cta_contact_module( $config );
