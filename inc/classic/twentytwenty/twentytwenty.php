<?php
/**
 * Additional options for Twenty Twenty
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include files.
 */
require_once TWENTIG_PATH . 'inc/classic/theme-tools/customizer-functions.php';
require_once TWENTIG_PATH . 'inc/classic/theme-tools/class-twentig-page-templater.php';
require_once TWENTIG_PATH . 'inc/classic/theme-tools/404.php';

/**
 * Include theme files "after_setup_theme".
 */
function twentig_twentytenty_load_theme_files() {
	if ( 'twentytwenty' !== get_template() ) {
		return;
	}

	require TWENTIG_PATH . 'inc/classic/twentytwenty/customizer.php';
	require TWENTIG_PATH . 'inc/classic/theme-tools/starters.php';
	require TWENTIG_PATH . 'inc/classic/twentytwenty/block-editor.php';
	require TWENTIG_PATH . 'inc/classic/twentytwenty/front-style.php';
	require TWENTIG_PATH . 'inc/classic/twentytwenty/font.php';
	require TWENTIG_PATH . 'inc/classic/twentytwenty/template-tags.php';
	require TWENTIG_PATH . 'inc/classic/twentytwenty/plugins.php';
}
add_action( 'after_setup_theme', 'twentig_twentytenty_load_theme_files', -1 );
