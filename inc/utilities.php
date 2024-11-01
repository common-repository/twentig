<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieves Twentig options considering its defaults values.
 */
function twentig_get_options() {
	$default_themes   = array( 'twentytwentytwo', 'twentytwentythree', 'twentytwentyfour' );
	$is_default_theme = in_array( get_template(), $default_themes, true ) ? 1 : 0;

	$defaults = array(
		'twentig_core_block_directory' => 1,
		'twentig_core_block_patterns'  => 1,
		'twentig_widgets_block_editor' => 1,
		'patterns'                     => 1,
		'openverse'                    => 1,
		'portfolio'                    => 0,
		'predefined_spacing'           => get_option( 'twentig_global_spacing', $is_default_theme ),
	);

	$options = get_option( 'twentig-options' );

	if ( $options ) {
		$options = wp_parse_args( $options, $defaults );
	} else {
		$options = $defaults;
	}

	return $options;
}

/**
 * Checks whether the Twentig option is enabled.
 *
 * @param string $name The name of the option.
 */
function twentig_is_option_enabled( $name ) {
	$options = twentig_get_options();

	if ( isset( $options[ $name ] ) ) {
		return $options[ $name ];
	}
	return false;
}

/**
 * Removes line breaks and superfluous whitespace.
 *
 * @param string $css String containing CSS.
 */
function twentig_minify_css( $css ) {
	if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {

		// Remove breaks.
		$css = preg_replace( '/[\r\n\t ]+/', ' ', $css );

		// Remove whitespace around specific characters.
		$css = preg_replace( '/\s+([{};,!>\)])/', '$1', $css );
		$css = preg_replace( '/([{};,:>\(])\s+/', '$1', $css );

		// Remove semicolon followed by closing bracket.
		$css = str_replace( ';}', '}', $css );
	}
	return $css;
}

/**
 * Determines if the theme supports Twentig spacing.
 */
function twentig_theme_supports_spacing() {
	if ( current_theme_supports( 'tw-spacing' ) && twentig_is_option_enabled( 'predefined_spacing' ) ) {
		return true;
	}
	return false;
}

/**
 * Processes the fonts json file and returns an array with its contents.
 * @see read_json_file() in class-wp-theme-json-resolver.php
 */
function twentig_get_fonts_data() {
	$file_path = TWENTIG_PATH . 'dist/js/webfonts.json';
	$config    = array();

	if ( file_exists( $file_path ) ) {
		$decoded_file = wp_json_file_decode( $file_path, array( 'associative' => true ) );
		if ( is_array( $decoded_file ) ) {
			$config = $decoded_file;
		}
	}

	return apply_filters( 'twentig_fonts', $config );
}
