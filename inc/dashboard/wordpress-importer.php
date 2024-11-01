<?php
// Based on the WordPress Importer plugin. https://wordpress.org/plugins/wordpress-importer/

/** Display verbose errors */
if ( ! defined( 'IMPORT_DEBUG' ) ) {
	define( 'IMPORT_DEBUG', WP_DEBUG );
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require $class_wp_importer;
	}
}

/** WXR_Parser class */
require_once TWENTIG_PATH . 'inc/dashboard/parsers/class-wxr-parser.php';

/** WXR_Parser_SimpleXML class */
require_once TWENTIG_PATH . 'inc/dashboard/parsers/class-wxr-parser-simplexml.php';

/** WXR_Parser_XML class */
require_once TWENTIG_PATH . 'inc/dashboard/parsers/class-wxr-parser-xml.php';

/** WXR_Parser_Regex class */
require_once TWENTIG_PATH . 'inc/dashboard/parsers/class-wxr-parser-regex.php';

/** WP_Import class */
require_once TWENTIG_PATH . 'inc/dashboard/class-wp-import.php';
