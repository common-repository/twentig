<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues block assets for frontend and backend editor.
 */
function twentig_block_assets() {
	
	// Front end.
	$asset_file             = include TWENTIG_PATH . 'dist/index.asset.php';
	$block_library_filename = wp_should_load_separate_core_block_assets() ? 'blocks/common' : 'style-index';

	wp_enqueue_style(
		'twentig-blocks',
		plugins_url( 'dist/' . $block_library_filename . '.css', dirname( __FILE__ ) ),
		array(),
		$asset_file['version']
	);

	if ( ! is_admin() ) {
		return;
	}

	// Editor.
	global $pagenow;

	$deps = $asset_file['dependencies'];
	$env  = 'post-editor';
	
	if ( 'site-editor.php' === $pagenow ) {
		$env = 'site-editor';
	} else {
		$edit_site_key = array_search( 'wp-edit-site', $deps );
		if ( false !== $edit_site_key ) {
			unset( $deps[ $edit_site_key ] );
		}
	}

	// Removes editor related assets when viewing the customizer or widgets screen to prevent conflict with the widgets editor.
	if ( is_customize_preview() || 'widgets.php' === $pagenow ) {
		$env           = 'no-post-editor';
		$edit_post_key = array_search( 'wp-edit-post', $deps );
		if ( false !== $edit_post_key ) {
			unset( $deps[ $edit_post_key ] );
		}
	}

	wp_enqueue_script(
		'twentig-blocks-editor',
		plugins_url( '/dist/index.js', dirname( __FILE__ ) ),
		$deps,
		$asset_file['version'],
		false
	);
	
	$config = array(
		'theme'         => get_template(),
		'isBlockTheme'  => wp_is_block_theme(),
		'cssClasses'    => twentig_get_block_css_classes(),
		'spacingSizes'  => twentig_get_spacing_sizes(),
		'portfolioType' => post_type_exists( 'portfolio' ) ? 'portfolio' : '',
		'env'           => $env,
	);

	wp_localize_script( 'twentig-blocks-editor', 'twentigEditorConfig', $config );

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'twentig-blocks-editor', 'twentig' );
	}

	wp_enqueue_style(
		'twentig-editor',
		plugins_url( 'dist/index.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		$asset_file['version']
	);
}
add_action( 'enqueue_block_assets', 'twentig_block_assets' );

/**
 * Enqueue spacing styles inside the editor.
 */
function twentig_block_editor_spacing_styles() {
	$spacing_sizes = twentig_get_spacing_sizes();
	$css_spacing   = '';

	foreach ( $spacing_sizes as $preset ) {
		$css_spacing .= '.tw-mt-' . esc_attr( $preset['slug'] ) . '{margin-top:' . esc_attr( $preset['size'] ) . '!important;}';
		$css_spacing .= '.tw-mb-' . esc_attr( $preset['slug'] ) . '{margin-bottom:' . esc_attr( $preset['size'] ) . '!important;}';
	}

	wp_add_inline_style( 'wp-block-library', $css_spacing );
}
add_action( 'admin_init', 'twentig_block_editor_spacing_styles' );

/**
 * Override block styles.
 */
function twentig_override_block_styles() {

	if ( ! wp_should_load_separate_core_block_assets() ) {
		return;
	}

	// Override core blocks style.
	$overriden_blocks = array(
		'columns',
		'gallery',
		'media-text',
		'post-template',
		'latest-posts',
	);

	foreach ( $overriden_blocks as $block_name ) {
		$style_path = TWENTIG_PATH . "dist/blocks/$block_name/block.css";
		if ( file_exists( $style_path ) ) {
			wp_deregister_style( "wp-block-{$block_name}" );
			wp_register_style(
				"wp-block-{$block_name}",
				TWENTIG_ASSETS_URI . "/blocks/{$block_name}/block.css",
				array(),
				TWENTIG_VERSION
			);

			// Add a reference to the stylesheet's path to allow calculations for inlining styles in `wp_head`.
			wp_style_add_data( "wp-block-{$block_name}", 'path', $style_path );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'twentig_override_block_styles', 9 );

/**
 * Adds block-specific inline styles.
 */
function twentig_enqueue_block_styles() {

	if ( ! wp_should_load_separate_core_block_assets() ) {
		return;
	}

	foreach ( glob( TWENTIG_PATH . 'dist/blocks/*/style.css' ) as $path ) {
		$block_name = basename( dirname( $path ) );
		wp_enqueue_block_style(
			"core/$block_name",
			array(
				'handle' => "tw-block-$block_name",
				'src'    => TWENTIG_ASSETS_URI . "/blocks/{$block_name}/style.css",
				'path'   => $path,
			)
		);
	}
}
add_action( 'after_setup_theme', 'twentig_enqueue_block_styles' );

/**
 * Adds margin and visibility classes to the global styles.
 */
function twentig_enqueue_class_styles() {

	$spacing_sizes = twentig_get_spacing_sizes();
	$css_spacing   = '';

	foreach ( $spacing_sizes as $preset ) {
		$css_spacing .= '.tw-mt-' . esc_attr( $preset['slug'] ) . '{margin-top:' . esc_attr( $preset['size'] ) . '!important;}';
		$css_spacing .= '.tw-mb-' . esc_attr( $preset['slug'] ) . '{margin-bottom:' . esc_attr( $preset['size'] ) . '!important;}';
	}

	$breakpoints       = apply_filters( 'twentig_breakpoints', array( 'mobile' => 768, 'tablet' => 1024 ) );
	$mobile_breakpoint = $breakpoints['mobile'] ?? 768;

	$css_visibility  = '@media (max-width: '. esc_attr( (int) $mobile_breakpoint - 1 ) . 'px){.tw-sm-hidden{display:none !important;}}';
	$css_visibility .= '@media (min-width: '. esc_attr( (int) $mobile_breakpoint ) . 'px) and (max-width: 1023px){.tw-md-hidden{display:none !important;}}';	
	$css_visibility .= '@media (min-width: 1024px){.tw-lg-hidden {display:none !important;}}';

	$css_global = $css_spacing . $css_visibility;

	wp_add_inline_style( 'global-styles', $css_global );
}
add_action( 'wp_enqueue_scripts', 'twentig_enqueue_class_styles' );

/**
 * Gets spacing sizes.
 */
function twentig_get_spacing_sizes() {

	$sizes = array(
		array(
			'slug' => '0',
			'name' => '0px',
			'size' => '0px',
		),
		array(
			'slug' => '1',
			'name' => '5px',
			'size' => '5px',
		),
		array(
			'slug' => '2',
			'name' => '10px',
			'size' => '10px',
		),
		array(
			'slug' => '3',
			'name' => '15px',
			'size' => '15px',
		),
		array(
			'slug' => '4',
			'name' => '20px',
			'size' => '20px',
		),
		array(
			'slug' => '5',
			'name' => '30px',
			'size' => '30px',
		),
		array(
			'slug' => '6',
			'name' => '40px',
			'size' => '40px',
		),
		array(
			'slug' => '7',
			'name' => '50px',
			'size' => '50px',
		),
		array(
			'slug' => '8',
			'name' => '60px',
			'size' => '60px',
		),
		array(
			'slug' => '9',
			'name' => '80px',
			'size' => '80px',
		),
		array(
			'slug' => '10',
			'name' => '100px',
			'size' => '100px',
		),
		array(
			'slug' => 'auto',
			'name' => 'auto',
			'size' => 'auto',
		),
	);

	return apply_filters( 'twentig_spacing_sizes', $sizes );
}

/**
 * Filters the post template block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_post_template_block( $block_content, $block ) {

	$attributes  = $block['attrs'] ?? array();
	$layout      = $attributes['layout']['type'] ?? null;
	$class_names = array();

	if ( 'grid' === $layout ) {
		$columns_count = $attributes['layout']['columnCount'] ?? 3;
		if ( $columns_count !== 1 ) {
			if ( isset( $attributes['twVerticalAlignment'] ) ) {
				$class_names[] = sanitize_title( 'tw-valign-' . $attributes['twVerticalAlignment'] );
			}
			if ( isset( $attributes['twColumnWidth'] ) ) {
				$class_names[] = sanitize_title( 'tw-cols-' . $attributes['twColumnWidth'] );
			}
		}
	}

	if ( $class_names ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();

		foreach ( $class_names as $class_name ) {
			$tag_processor->add_class( $class_name );
		}
		$block_content = $tag_processor->get_updated_html();
	}

	return $block_content;
}
add_filter( 'render_block_core/post-template', 'twentig_filter_post_template_block', 10, 2 );

/**
 * Filters the cover block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_cover_block( $block_content, $block ) {

	$attributes = $block['attrs'] ?? array();

	$image_id = 0;
	if ( isset( $attributes['id'] ) ) {
		$image_id = $attributes['id'];
	} elseif ( isset( $attributes['useFeaturedImage'] ) ) {
		$image_id = get_post_thumbnail_id();
	}

	if ( $image_id ) {
		$image_meta = wp_get_attachment_metadata( $image_id );
		if ( $image_meta && isset( $image_meta['width'] ) ) {
			$width = absint( $image_meta['width'] );
			if ( $width ) {
				//cf wp_image_add_srcset_and_sizes()
				$sizes = sprintf( '(max-width: 799px) 200vw,(max-width: %1$dpx) 100vw,%1$dpx', $width );
				if ( isset( $attributes['twRatio'] ) ) {
					$sizes = sprintf( '(max-width: 799px) 125vw,(max-width: %1$dpx) 100vw,%1$dpx', $width );
				}
				$tag_processor = new WP_HTML_Tag_Processor( $block_content );
				$tag_processor->next_tag( 'img' );
				$tag_processor->set_attribute( 'sizes', $sizes );
				$block_content = $tag_processor->get_updated_html();
			}
		}
	}
	return $block_content;
}
add_filter( 'render_block_core/cover', 'twentig_filter_cover_block', 10, 2 );

/**
 * Filters the navigation block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_navigation_block( $block_content, $block ) {

	if ( ! empty( $block['attrs'] ) ) {

		$attributes   = $block['attrs'];
		$hover_style  = $attributes['twHoverStyle'] ?? '';
		$active_style = $attributes['twActiveStyle'] ?? $hover_style;
		$overlay_menu = $attributes['overlayMenu'] ?? 'mobile';

		$class_names  = array();

		if ( $hover_style ) {
			$class_names[] = sanitize_title( 'tw-nav-hover-' . $hover_style );
		}

		if ( $active_style ) {
			$class_names[] = sanitize_title( 'tw-nav-active-' . $active_style );
		}

		if ( in_array( $overlay_menu, array( 'mobile', 'always' ), true ) ) {
			if ( isset( $attributes['twBreakpoint'] ) && 'mobile' === $overlay_menu ) {
				$class_names[] = sanitize_title( 'tw-break-' . $attributes['twBreakpoint'] );
			}
			if ( isset( $attributes['twMenuIconSize'] ) ) {
				$class_names[] = sanitize_title( 'tw-icon-' . $attributes['twMenuIconSize'] );
			}
		}

		if ( isset( $attributes['twGap'] ) ) {
			$class_names[] = sanitize_title( 'tw-gap-' . $attributes['twGap'] );
		}

		if ( $class_names ) {
			$tag_processor = new WP_HTML_Tag_Processor( $block_content );
			$tag_processor->next_tag();
			foreach ( $class_names as $class_name ) {
				$tag_processor->add_class( $class_name );
			}
			$block_content = $tag_processor->get_updated_html();
		}

		if ( 'menu' === ( $block['attrs']['icon'] ?? null ) ) {
			$block_content = str_replace(
				'<path d="M5 5v1.5h14V5H5zm0 7.8h14v-1.5H5v1.5zM5 19h14v-1.5H5V19z" />',
				'<rect x="4" y="6.5" width="16" height="1.5"></rect><rect x="4" y="11.25" width="16" height="1.5"></rect><rect x="4" y="16" width="16" height="1.5"></rect>',
				$block_content 
			);
		}
	}

	return $block_content;
}
add_filter( 'render_block_core/navigation', 'twentig_filter_navigation_block', 10, 2 );

/**
 * Filters the site logo block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_site_logo_block( $block_content, $block ) {

	if ( isset( $block['attrs']['twWidthMobile'] ) ) {

		$logo_class = wp_unique_id( 'tw-logo-' );

		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		$tag_processor->add_class( $logo_class );
		$block_content = $tag_processor->get_updated_html();

		$style            = '@media(max-width:767px){.wp-block-site-logo.' . $logo_class . ' img{width: ' . esc_attr( $block['attrs']['twWidthMobile'] ) . 'px;height:auto;}}';
		$action_hook_name = wp_is_block_theme() ? 'wp_head' : 'wp_footer';
		add_action(
			$action_hook_name,
			static function () use ( $style ) {
				echo "<style>$style</style>";
			}
		);

	}
	return $block_content;
}
add_filter( 'render_block_core/site-logo', 'twentig_filter_site_logo_block', 10, 2 );

/**
 * Filters the separator block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_separator_block( $block_content, $block ) {
	$attributes = $block['attrs'] ?? array();
	$width      = $attributes['twWidth'] ?? '';
	$height     = $attributes['twHeight'] ?? '';
	$style      = '';

	if ( ( empty( $width ) && empty( $height ) ) || str_contains( $block_content, 'is-style-dots' ) || str_contains( $block_content, 'is-style-tw-asterisks' ) ) {
		return $block_content;
	}

	$tag_processor = new WP_HTML_Tag_Processor( $block_content );
	$tag_processor->next_tag();

	if ( ! empty( $width ) ) {
		$style .= 'width:' . esc_attr( $width ) . '; max-width:100%;';
	}

	if ( ! empty( $height ) ) {
		$style .= 'height:' . esc_attr( $height ) . ';';
		if ( ! empty( $width ) && intval( $height ) > intval( $width ) ) {
			$tag_processor->add_class( 'is-vertical' );
		}
	}

	$style_attr = $tag_processor->get_attribute( 'style' );
	$style     .= $style_attr;
	$tag_processor->set_attribute( 'style', $style );

	return $tag_processor->get_updated_html();
}
add_filter( 'render_block_core/separator', 'twentig_filter_separator_block', 10, 2 );

/**
 * Filters the post terms block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_post_terms_block( $block_content, $block ) {

	if ( ! empty( $block['attrs']['twUnlink'] ) ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		$tag_processor->add_class( 'tw-no-link' );
		while ( $tag_processor->next_tag( array( 'tag_name' => 'a' ) ) ) {
			$tag_processor->remove_attribute( 'href' );
			$tag_processor->remove_attribute( 'rel' );
		}
		$block_content = $tag_processor->get_updated_html();
	}
	return $block_content;
}
add_filter( 'render_block_core/post-terms', 'twentig_filter_post_terms_block', 10, 2 );

/**
 * Filters the post featured image block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_post_featured_image_block( $block_content, $block ) {
	if ( ! empty( $block['attrs']['twHover'] ) ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		$tag_processor->add_class( 'tw-hover-' . $block['attrs']['twHover'] );
		$block_content = $tag_processor->get_updated_html();
	}
	return $block_content;
}
add_filter( 'render_block_core/post-featured-image', 'twentig_filter_post_featured_image_block', 10, 2 );

/**
 * Filters the details block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_details_block( $block_content, $block ) {
	$icon_type = $block['attrs']['twIcon'] ?? '';
	
	if ( empty( $icon_type ) ) {
		return $block_content;
	}

	$icon_position = $block['attrs']['twIconPosition'] ?? 'right';
	$tag_processor = new WP_HTML_Tag_Processor( $block_content );
	$tag_processor->next_tag();
	$tag_processor->add_class( 'tw-has-icon' );

	if ( 'left' === $icon_position ) {
		$tag_processor->add_class( 'tw-has-icon-' . esc_html( $icon_position ) );
	}

	$block_content = $tag_processor->get_updated_html();

	$icon = '<svg class="details-arrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" version="1.1" aria-hidden="true" focusable="false"><path d="m12 15.375-6-6 1.4-1.4 4.6 4.6 4.6-4.6 1.4 1.4-6 6Z"></path></svg>';
	if ( 'plus' === $icon_type ) {
		$icon = '<svg class="details-plus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" version="1.1" aria-hidden="true" focusable="false"><path class="plus-vertical" d="M11 6h2v12h-2z"/><path d="M6 11h12v2H6z"/></svg>';
	} elseif ( 'plus-circle' === $icon_type ) {
		$icon = '<svg class="details-plus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" version="1.1" aria-hidden="true" focusable="false"><path d="M12 3.75c4.55 0 8.25 3.7 8.25 8.25s-3.7 8.25-8.25 8.25-8.25-3.7-8.25-8.25S7.45 3.75 12 3.75M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2Z" /><path d="M11.125 7.5h1.75v9h-1.75z" class="plus-vertical" /><path d="M7.5 11.125h9v1.75h-9z" /></svg>';
	}

	return str_replace( '</summary>', $icon . '</summary>', $block_content );
}
add_filter( 'render_block_core/details', 'twentig_filter_details_block', 10, 2 );

/**
 * Filters the blocks to add animation.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_add_block_animation( $block_content, $block ) {

	if ( ! empty( $block['attrs']['twAnimation'] ) ) {

		wp_enqueue_script( 
			'tw-block-animation', 
			plugins_url( '/dist/js/block-animation.js', dirname( __FILE__ ) ),
			array(),
			'1.0',
			array(
				'in_footer' => false,
				'strategy'  => 'defer',
			)
		);
		$attributes = $block['attrs'];
		$animation  = $attributes['twAnimation'];
		$duration   = $attributes['twAnimationDuration'] ?? '';
		$delay      = $attributes['twAnimationDelay'] ?? 0;

		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		$tag_processor->add_class( 'tw-block-animation' );
		$tag_processor->add_class( 'tw-animation-' . $animation );

		if ( $duration ) {
			$tag_processor->add_class( 'tw-duration-' . $duration );
		}

		if ( $delay ) {
			$style_attr = $tag_processor->get_attribute( 'style' );
			$style      = '--tw-animation-delay:' . esc_attr( $delay ) . 's;' . $style_attr;
			$tag_processor->set_attribute( 'style', esc_attr( $style ) );
		}

		return $tag_processor->get_updated_html();
	}

	return $block_content;
}
add_filter( 'render_block', 'twentig_add_block_animation', 10, 2 );

/**
 * Handles no JavaScript detection.
 * Adds a style tag element when no JavaScript is detected.
 */
function twentig_support_no_script() {
	echo "<noscript><style>.tw-block-animation{opacity:1;transform:none;clip-path:none;}</style></noscript>\n";
}
add_action( 'wp_head', 'twentig_support_no_script' );

require TWENTIG_PATH . 'inc/shape.php';
