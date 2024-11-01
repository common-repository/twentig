<?php
/**
 * Twentig plugin file.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require TWENTIG_PATH . 'inc/dashboard/class-twentig-dashboard.php';
require TWENTIG_PATH . 'inc/utilities.php';
require TWENTIG_PATH . 'inc/blocks.php';
require TWENTIG_PATH . 'inc/compat/blocks.php';
require TWENTIG_PATH . 'inc/block-styles.php';
require TWENTIG_PATH . 'inc/block-presets.php';
require TWENTIG_PATH . 'inc/block-patterns.php';
require TWENTIG_PATH . 'inc/twentig_portfolio.php';

function twentig_theme_support_includes() {
	$template = get_template();

	if ( wp_is_block_theme() ) {
		require TWENTIG_PATH . 'inc/block-themes.php';
		if ( in_array( $template, ['twentytwentyfour', 'twentytwentytwo'], true ) ) {
			require TWENTIG_PATH . 'inc/compat/' . $template . '.php';
		}
	} elseif ( 'twentytwentyone' === $template ) {
		require TWENTIG_PATH . 'inc/classic/twentytwentyone/twentytwentyone.php';
	} elseif ( 'twentytwenty' === $template ) {
		require TWENTIG_PATH . 'inc/classic/twentytwenty/twentytwenty.php';
	}
}
twentig_theme_support_includes();
