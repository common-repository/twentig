<?php
/**
 * Block Patterns
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the block pattern categories.
 */
function twentig_register_block_pattern_categories() {
	register_block_pattern_category( 'posts', array( 'label' => _x( 'Posts', 'Block pattern category' ) ) );
	register_block_pattern_category( 'text', array( 'label' => esc_html_x( 'Text', 'Block pattern category' ) ) );
	register_block_pattern_category( 'text-image', array( 'label' => esc_html_x( 'Text and Image', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'hero', array( 'label' => esc_html_x( 'Hero', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'banner', array( 'label' => esc_html_x( 'Banners', 'Block pattern category' ) ) );
	register_block_pattern_category( 'call-to-action', array( 'label' => esc_html_x( 'Call to Action', 'Block pattern category' ) ) );
	register_block_pattern_category( 'list', array( 'label' => esc_html_x( 'List', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'numbers', array( 'label' => esc_html_x( 'Numbers, Stats', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'gallery', array( 'label' => esc_html_x( 'Gallery', 'Block pattern category' ) ) );
	register_block_pattern_category( 'media', array( 'label' => esc_html_x( 'Media', 'Block pattern category' ) ) );
	register_block_pattern_category( 'latest-posts', array( 'label' => esc_html_x( 'Latest Posts', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'contact', array( 'label' => esc_html_x( 'Contact', 'Block pattern category' ) ) );
	register_block_pattern_category( 'team', array( 'label' => esc_html_x( 'Team', 'Block pattern category' ) ) );
	register_block_pattern_category( 'testimonials', array( 'label' => esc_html_x( 'Testimonials', 'Block pattern category' ) ) );
	register_block_pattern_category( 'logos', array( 'label' => esc_html_x( 'Logos, Clients', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'pricing', array( 'label' => esc_html_x( 'Pricing', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'faq', array( 'label' => esc_html_x( 'FAQs', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'events', array( 'label' => esc_html_x( 'Events, Schedule', 'Block pattern category', 'twentig' ) ) );
	register_block_pattern_category( 'page', array( 'label' => _x( 'Pages', 'Block pattern category' ) ) );
	register_block_pattern_category( 'page-single', array( 'label' => _x( 'Single Pages', 'Block pattern category', 'twentig' ) ) );
}
add_action( 'init', 'twentig_register_block_pattern_categories', 9 );

/**
 * Registers the block patterns.
 */
function twentig_register_block_patterns() {

	if ( ! twentig_is_option_enabled( 'patterns' ) ) {
		return;
	}

	$path = TWENTIG_PATH . 'inc/patterns/';
	
	if ( ! wp_is_block_theme() ) {
		$path = TWENTIG_PATH . 'inc/classic/patterns/';
	}

	$files = array(
		'columns.php',
		'text.php',
		'contact.php',
		'text-image.php',
		'banner.php',
		'call-to-action.php',
		'events.php',
		'faq.php',
		'gallery.php',
		'hero.php',
		'latest-posts.php',
		'list.php',
		'logos.php',
		'numbers.php',
		'pricing.php',
		'team.php',
		'testimonials.php',
		'media.php',
		'pages.php',
		'single-page.php',
		'header.php',
		'footer.php',
		'posts.php',
		'portfolio.php',
	);

	if ( 'twentytwenty' === get_template() ) {
		$files[] = 'twentytwenty.php';
	}

	foreach ( $files as $file ) {
		if ( file_exists( $path . $file ) ) {
			require_once $path . $file;
		}
	}
}
add_action( 'init', 'twentig_register_block_patterns' );

/**
 * Registers a block pattern.
 *
 * @param string $pattern_name       Pattern name including namespace.
 * @param array  $pattern_properties Array containing the properties of the pattern.
 */
function twentig_register_block_pattern( $pattern_name, $pattern_properties ) {

	static $theme         = null;
	static $block_theme   = null;
	static $twentig_theme = null;

	if ( is_null( $theme ) ) {
		$theme = get_template();
	}

	if ( is_null( $block_theme ) ) {
		$block_theme = wp_is_block_theme();
	}

	if ( is_null( $twentig_theme ) ) {
		$twentig_theme = current_theme_supports( 'twentig-theme' );
	}

	if ( ! isset( $pattern_properties['viewportWidth'] ) ) {
		$pattern_properties['viewportWidth'] = 1366;
	}
	
	if ( $block_theme && ! $twentig_theme ) {
		$pattern_properties['content'] = twentig_replace_pattern_preset_to_values( $pattern_properties['content'] );
	}
	
	if ( ! $twentig_theme && ! in_array( $theme, array( 'twentytwentyfour', 'twentytwentythree', 'twentytwentytwo', 'twentytwentyone', 'twentytwenty' ), true ) ) {
		$theme = 'third-party';
	}

	$pattern_properties['content'] = twentig_replace_theme_patterns_strings( $pattern_properties['content'], $theme );

	register_block_pattern(
		$pattern_name,
		$pattern_properties
	);
}

/**
 * Replaces pattern styles for non Twentig theme.
 */
function twentig_replace_theme_patterns_strings( $content, $theme ) {
	
	$strings_replace = array();

	switch( $theme ) {
		case 'twentytwentythree':
			$strings_replace = array(
				array(
					'old' => '"backgroundColor":"base-2"',
					'new' => '"backgroundColor":"tertiary"',
				),
				array(
					'old' => 'has-base-2-background-color',
					'new' => 'has-tertiary-background-color',
				),	
				array(
					'old' => '"textColor":"contrast-2"',
					'new' => '"textColor":"contrast"',
				),
				array(
					'old' => 'has-contrast-2-background-color',
					'new' => 'has-contrast-background-color',
				),
			);
			break;
		case 'twentytwentytwo':
			$strings_replace = array(
				array(
					'old' => '"backgroundColor":"base"',
					'new' => '"backgroundColor":"background"',
				),
				array(
					'old' => '"textColor":"base"',
					'new' => '"textColor":"background"',
				),
				array(
					'old' => 'has-base-background-color',
					'new' => 'has-background-background-color',
				),
				array(
					'old' => 'has-base-color',
					'new' => 'has-background-color',
				),
				array(
					'old' => '"backgroundColor":"contrast"',
					'new' => '"backgroundColor":"foreground"',
				),
				array(
					'old' => '"textColor":"contrast"',
					'new' => '"textColor":"foreground"',
				),
				array(
					'old' => 'has-contrast-background-color',
					'new' => 'has-foreground-background-color',
				),
				array(
					'old' => 'has-contrast-color',
					'new' => 'has-foreground-color',
				),
				array(
					'old' => '"iconColor":"contrast"',
					'new' => '"iconColor":"foreground"',
				),
				array(
					'old' => '"iconColorValue":"var(--wp--preset--color--contrast)"',
					'new' => '"iconColorValue":"var(--wp--preset--color--foreground)"',
				),
				array(
					'old' => '"backgroundColor":"base-2"',
					'new' => '"backgroundColor":"tertiary"',
				),
				array(
					'old' => 'has-base-2-background-color',
					'new' => 'has-tertiary-background-color',
				),
				array(
					'old' => '"textColor":"contrast-2"',
					'new' => '"textColor":"foreground"',
				),
				array(
					'old' => 'has-contrast-2-background-color',
					'new' => 'has-foreground-background-color',
				),
			);
			break;
		case 'twentytwenty':
			$strings_replace = array(
				array(
					'old' => '<!-- wp:heading {"level":3,"fontSize":"large"',
					'new' => '<!-- wp:heading {"level":3,"fontSize":"h5"',
				),
				array(
					'old' => '<h3 class="has-large-font-size',
					'new' => '<h3 class="has-h-5-font-size',
				),
				array(
					'old' => '<!-- wp:heading {"fontSize":"large"} --><h2 class="has-large-font-size">',
					'new' => '<!-- wp:heading {"fontSize":"large"} --><h2 class="has-h-5-font-size">',
				),
				array(
					'old' => '<!-- wp:paragraph {"fontSize":"medium"',
					'new' => '<!-- wp:paragraph {"fontSize":"large"',
				),
				array(
					'old' => '<p class="has-medium-font-size',
					'new' => '<p class="has-large-font-size',
				),
				array(
					'old' => '"backgroundColor":"subtle"',
					'new' => '"backgroundColor":"subtle-background"',
				),
				array(
					'old' => 'has-subtle-background-color',
					'new' => 'has-subtle-background-background-color',
				),
				array(
					'old' => '<!-- wp:heading {"fontSize":"h3"} --><h2 class="has-h-3-font-size">',
					'new' => '<!-- wp:heading {"fontSize":"h4"} --><h2 class="has-h-4-font-size">',
				),
				array(
					'old' => '<!-- wp:heading {"fontSize":"extra-large"',
					'new' => '<!-- wp:heading {"fontSize":"h3"',
				),
				array(
					'old' => '<h2 class="has-extra-large-font-size',
					'new' => '<h2 class="has-h-3-font-size',
				),
				array(
					'old' => '"fontSize":"huge"',
					'new' => '"fontSize":"h1"',
				),
				array(
					'old' => 'has-huge-font-size',
					'new' => 'has-h-1-font-size',
				),
				array(
					'old' => 'tw-hide-more-link',
					'new' => '',
				),
				array(
					'old' => '<!-- wp:heading {"level":1,"fontSize":"extra-large"',
					'new' => '<!-- wp:heading {"level":1,"fontSize":"h3"',
				),
				array(
					'old' => '<h1 class="has-extra-large-font-size',
					'new' => '<h1 class="has-h-3-font-size',
				),
				array(
					'old' => '<!-- wp:media-text {"align":"full"',
					'new' => '<!-- wp:media-text {"align":"full","className":"tw-content-narrow"',
				),
				array(
					'old' => '<div class="wp-block-media-text alignfull',
					'new' => '<div class="wp-block-media-text alignfull tw-content-narrow',
				),
			);
			break;
		case 'third-party':
			$strings_replace = array(
				array(
					'old' => '<!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">',
					'new' => '<!-- wp:heading {"level":3} --><h3>',
				),
				array(
					'old' => '<!-- wp:heading {"level":3,"fontSize":"large",',
					'new' => '<!-- wp:heading {"level":3,',
				),
				array(
					'old' => '<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem"}}} --><h3 style="font-size:1.5rem">',
					'new' => '<!-- wp:heading {"level":3} --><h3>',
				),
				array(
					'old' => '<!-- wp:heading {"level":3,"fontSize":"x-large",',
					'new' => '<!-- wp:heading {"level":3,',
				),
				array(
					'old' => '<!-- wp:heading {"fontSize":"large"} --><h2 class="has-large-font-size">',
					'new' => '<!-- wp:heading --><h2>',
				),
				array(
					'old' => '<!-- wp:heading {"fontSize":"extra-large"} --><h2 class="has-extra-large-font-size">',
					'new' => '<!-- wp:heading --><h2>',
				),		
				array(
					'old' => '"textColor":"contrast-2",',
					'new' => '',
				),
				array(
					'old' => '{"textColor":"contrast-2"}',
					'new' => '',
				),
				array(
					'old' => 'has-contrast-2-color has-text-color ',
					'new' => '',
				),
				array(
					'old' => ' class="has-contrast-2-color has-text-color"',
					'new' => '',
				),
			);
			break;
	}

	return twentig_replace_pattern_array_strings( $content, $strings_replace );
}

/**
 * Replaces theme preset by values.
 */
function twentig_replace_pattern_preset_to_values( $content ) {

	$strings_replace = array(
		array(
			'old' => '<!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">',
			'new' => '<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem"}}} --><h3 style="font-size:1.5rem">',
		),
		array(
			'old' => '<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"medium"} --><h3 class="has-text-align-center has-medium-font-size">',
			'new' => '<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"1.5rem"}}} --><h3 class="has-text-align-center" style="font-size:1.5rem">',
		),
		array(
			'old' => '<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}},"fontSize":"medium"} --><h3 class="has-medium-font-size" style="margin-top:var(--wp--preset--spacing--35)">',
			'new' => '<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.5rem"},"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><h3 style="font-size:1.5rem;margin-top:var(--wp--preset--spacing--35)">',
		),
		array(
			'old' => '<!-- wp:heading {"fontSize":"xx-large"} --><h2 class="has-xx-large-font-size">',
			'new' => '<!-- wp:heading --><h2>',
		),
		array(
			'old' => '"fontSize":"xx-large"',
			'new' => '"fontSize":"x-large"',
		),
		array(
			'old' => 'has-xx-large-font-size',
			'new' => 'has-x-large-font-size',
		),
		array(
			'old' => '"fontSize":"x-small"',
			'new' => '"fontSize":"small"',
		),
		array(
			'old' => 'has-x-small-font-size',
			'new' => 'has-small-font-size',
		),
		array(
			'old' => '<!-- wp:paragraph {"fontSize":"large","align":"center","style":{"typography":{"lineHeight":1.4}}} --><p class="has-text-align-center has-large-font-size" style="line-height:1.4">',
			'new' => '<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.5rem","lineHeight":1.4}}} --><p class="has-text-align-center" style="font-size:1.5rem;line-height:1.4">',
		),
		array(
			'old' => '<!-- wp:paragraph {"fontSize":"large","style":{"typography":{"lineHeight":1.4}}} --><p class="has-large-font-size" style="line-height:1.4">',
			'new' => '<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem","lineHeight":1.4}}} --><p style="font-size:1.5rem;line-height:1.4">',
		),
		array(
			'old' => '<!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size">',
			'new' => '<!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">',
		),
		array(
			'old' => '<!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.1"}},"fontSize":"4-x-large"} --><p class="has-4-x-large-font-size has-text-align-center" style="line-height:1.1">',
			'new' => '<!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.1","fontSize":"3.5rem"}}} --><p class="has-text-align-center" style="font-size:3.5rem;line-height:1.1">',
		),
		array(
			'old' => '<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.1"}},"fontSize":"4-x-large"} --><p class="has-4-x-large-font-size" style="line-height:1.1">',
			'new' => '<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.1","fontSize":"3.5rem"}}} --><p style="font-size:3.5rem;line-height:1.1">',
		),
	);
	
	$content = twentig_replace_pattern_array_strings( $content, $strings_replace );

	$spacing_sizes = array(
		'60'   => '80px',
		'50'   => '60px',
		'45'   => '48px',
		'40'   => '40px',
		'35'   => '32px',
		'30'   => '24px',
		'25'   => '20px',
		'20'   => '16px',
		'15'   => '12px',
		'10'   => '8px',
		'5'    => '4px',
		'auto' => 'auto'
	);

	foreach ( $spacing_sizes as $size => $value ) {
		$content = str_replace( "var:preset|spacing|$size", $value, $content );
		$content = str_replace( "var(--wp--preset--spacing--$size)", $value, $content );
	}

	return $content;
}

/**
 * Performs a batch string replacement in the specified content.
 * 
 * @param string  $content The original content.
 * @param array   $replacements Array of arrays with 'old' and 'new' string pairs for replacement.
 * @return string Content with all occurrences of 'old' strings replaced by 'new' strings.
 */
function twentig_replace_pattern_array_strings( $content, $replacements ) {
	$old_strings = array_column( $replacements, 'old' );
	$new_strings = array_column( $replacements, 'new' );

	return str_replace( $old_strings, $new_strings, $content );
}

/**
 * Retrieves the url of asset stored inside the plugin that can be used in block patterns.
 *
 * @param string $asset_name Asset name.
 */
function twentig_get_pattern_asset( $asset_name ) {
	return esc_url( TWENTIG_ASSETS_URI . '/images/patterns/' . $asset_name );
}
