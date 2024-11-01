<?php
/**
 * Functionalities for Twenty Twenty-Two.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue styles for the theme.
 */
function twentig_twentytwo_enqueue_scripts() {

	wp_enqueue_style(
		'twentig-twentytwo',
		TWENTIG_ASSETS_URI . '/css/twentytwentytwo/style.css',
		array(),
		TWENTIG_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'twentig_twentytwo_enqueue_scripts', 12 );

/**
 * Enqueue styles inside the editor.
 */
function twentig_twentytwo_editor_styles() {
	add_editor_style( TWENTIG_ASSETS_URI . '/css/twentytwentytwo/editor.css' );
}
add_action( 'admin_init', 'twentig_twentytwo_editor_styles' );

/**
 * Hooks into the data provided by the theme to add new font size options.
 */
function twentig_twentytwo_filter_theme_json_theme( $theme_json ) {

	$theme_data  = $theme_json->get_data();
	$theme_sizes = $theme_data['settings']['typography']['fontSizes']['theme'] ?? null;

	if ( is_array( $theme_sizes ) ) {

		$additional_sizes = array(
			array(
				'name' => __( 'Extra Extra Large', 'twentig' ),
				'size' => 'clamp(2rem, 4vw, 2.75rem)',
				'slug' => 'xx-large',
			),
		);

		$new_data = array(
			'version'  => 2,
			'settings' => array(
				'typography' => array(
					'fontSizes' => array(
						'theme' => array_merge( $theme_sizes, $additional_sizes ),
					),
				),
			),
		);
		return $theme_json->update_with( $new_data );
	}

	return $theme_json;
}
add_filter( 'wp_theme_json_data_theme', 'twentig_twentytwo_filter_theme_json_theme' );

/**
 * Unregister theme patterns.
 */
function twentig_twentytwo_register_block_patterns() {
	if ( ! twentig_is_option_enabled( 'twentig_core_block_patterns' ) ) {
		add_filter( 'twentytwentytwo_block_patterns', '__return_empty_array' );
	}
}
add_action( 'init', 'twentig_twentytwo_register_block_patterns', 9 );
