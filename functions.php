<?php
/**
 * Theme functions and definitions
 *
 * @package Milos
 * @subpackage Chriss
 */

// Include all required files.
require_once get_template_directory() . '/includes/constants.php';
require_once get_template_directory() . '/includes/theme.php';
require_once get_template_directory() . '/includes/enqueue-styles-scripts.php';
require_once get_template_directory() . '/includes/disable-gutenberg.php';
require_once get_template_directory() . '/includes/disable-comments.php';
require_once get_template_directory() . '/includes/disable-emojis.php';
require_once get_template_directory() . '/includes/svg-support.php';
require_once get_template_directory() . '/includes/acf-options.php';
require_once get_template_directory() . '/includes/json-support.php';
require_once get_template_directory() . '/includes/images-sizes.php';
require_once get_template_directory() . '/includes/custom-post-types.php';
require_once get_template_directory() . '/includes/clear_wp_meta.php';
require_once get_template_directory() . '/includes/register_menu.php';
require_once get_template_directory() . '/includes/register_sidebar.php';
require_once get_template_directory() . '/includes/helpers.php';
require_once get_template_directory() . '/includes/cli.php';
require_once get_template_directory() . '/includes/wpml.php';
require_once get_template_directory() . '/includes/acf-location-flexible-content.php';
require_once get_template_directory() . '/includes/acf-location-visibility.php';
require_once get_template_directory() . '/includes/modules.php';
require_once get_template_directory() . '/includes/import.php';

// Include model classes.
require_once get_template_directory() . '/includes/models/class.employee.php';
require_once get_template_directory() . '/includes/models/class.office.php';
require_once get_template_directory() . '/includes/models/class.sector.php';
require_once get_template_directory() . '/includes/models/class.service.php';
