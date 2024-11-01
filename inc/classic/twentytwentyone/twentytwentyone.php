<?php
/**
 * Additional options for Twenty Twenty-One.
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
require_once TWENTIG_PATH . 'inc/classic/twentytwentyone/template-tags.php';

/**
 * Include theme files "after_setup_theme".
 */
function twentig_twentyone_load_theme_files() {
	if ( 'twentytwentyone' !== get_template() ) {
		return;
	}

	require TWENTIG_PATH . 'inc/classic/twentytwentyone/customizer.php';
	require TWENTIG_PATH . 'inc/classic/theme-tools/starters.php';
	require TWENTIG_PATH . 'inc/classic/twentytwentyone/block-editor.php';
	require TWENTIG_PATH . 'inc/classic/twentytwentyone/front-end.php';
	require TWENTIG_PATH . 'inc/classic/twentytwentyone/front-style.php';
	require TWENTIG_PATH . 'inc/classic/twentytwentyone/font.php';
	require TWENTIG_PATH . 'inc/classic/twentytwentyone/plugins.php';
}
add_action( 'after_setup_theme', 'twentig_twentyone_load_theme_files', -1 );
