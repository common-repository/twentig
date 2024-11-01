<?php

/**
 * Filters the columns block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_compat_columns_block( $block_content, $block ) {

	$attributes     = $block['attrs'] ?? array();
	$classnames     = $attributes['className'] ?? '';
	$gap            = $attributes['style']['spacing']['blockGap'] ?? null;
	$horizontal_gap = is_array( $gap ) ? ( $gap['left'] ?? null ) : $gap;

	if ( twentig_theme_supports_spacing() && $horizontal_gap && str_contains( $horizontal_gap, 'px' ) ) {
		$gap_value = intval( $horizontal_gap );
		if ( $gap_value > 32 ) {
			$tag_processor = new WP_HTML_Tag_Processor( $block_content );
			$tag_processor->next_tag();
			$tag_processor->add_class( 'tw-large-gap' );
			$block_content = $tag_processor->get_updated_html();
		}
	}

	if ( str_contains( $classnames, 'tw-cols-' ) || str_contains( $classnames, 'tw-row-gap' ) ) {
		wp_enqueue_block_style(
			'core/columns',
			array(
				'handle' => 'tw-block-columns-compat',
				'src'    => TWENTIG_ASSETS_URI . '/blocks/columns/compat.css',
				'path'   => TWENTIG_PATH . 'dist/blocks/columns/compat.css',
			) 
		);
	}

	return $block_content;
}
add_filter( 'render_block_core/columns', 'twentig_filter_compat_columns_block', 10, 2 );

/**
 * Filters the column block output to add a CSS var to store the width attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_compat_column_block( $block_content, $block ) {

	if ( wp_should_load_separate_core_block_assets() ) {
		return $block_content;
	}

	if ( isset( $block['attrs']['width'] ) ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		
		$style_attr = $tag_processor->get_attribute( 'style' );
		$style      = '--col-width:' . $block['attrs']['width'] . ';' . $style_attr;
		
		$tag_processor->set_attribute( 'style', $style );
		$block_content = $tag_processor->get_updated_html();
	}

	return $block_content;
}
add_filter( 'render_block_core/column', 'twentig_filter_compat_column_block', 10, 2 );

/**
 * Handles deprecation for our block settings by filtering the block before it's processed.
 *
 * @param array $parsed_block The block being rendered.
 */
function twentig_filter_compat_render_block_data( $parsed_block ) {
	$block_name = $parsed_block['blockName'];
	if ( 'core/post-author' === $block_name ) {
		if ( ! empty( $parsed_block['attrs']['twIsLink'] ) ) {
			$parsed_block['attrs']['isLink'] = true;
		}
	} elseif ( 'core/post-excerpt' === $block_name ) {
		$attributes = $parsed_block['attrs'];
		if ( isset( $attributes['twExcerptLength'] ) ) {
			$parsed_block['attrs']['excerptLength'] = $attributes['twExcerptLength'];
		}
	}

	return $parsed_block;
}
add_filter( 'render_block_data', 'twentig_filter_compat_render_block_data' );

/**
 * Filters the query block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_compat_query_block( $block_content, $block ) {

	$attributes = $block['attrs'] ?? array();
	$layout     = $attributes['displayLayout']['type'] ?? null;

	if ( ! $layout ) {
		return $block_content;
	}

	$class_names = array();
	$style       = '';

	if ( isset( $attributes['twBlockGapVertical'] ) ) {
		$style .= '--tw-gap-y:' . $attributes['twBlockGapVertical'] . ';';
	}

	if ( isset( $attributes['twBlockGapHorizontal'] ) ) {
		$style .= '--tw-gap-x:' . $attributes['twBlockGapHorizontal'] . ';';
	}

	if ( !empty( $style ) ) {
		$class_names[] = 'tw-custom-gap';
	}

	if ( isset( $attributes['twVerticalAlignment'] ) ) {
		$class_names[] = sanitize_title( 'tw-valign-' . $attributes['twVerticalAlignment'] );
	}

	if ( isset( $attributes['twColumnWidth'] ) && ( 'flex' === $layout || str_contains( $block_content, 'wp-block-post-template-is-layout-grid' ) ) ) {
		$class_names[] = sanitize_title( 'tw-cols-' . $attributes['twColumnWidth'] );
	}

	if ( $style || $class_names ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag( array( 'class_name' => 'wp-block-post-template' ) );
		if ( $style ) {
			$style_attr = $tag_processor->get_attribute( 'style' );
			$style     .= $style_attr;
			$tag_processor->set_attribute( 'style', $style );
		}

		if ( $class_names ) {
			foreach ( $class_names as $class_name ) {
				$tag_processor->add_class( $class_name );
			}
		}

		$block_content = $tag_processor->get_updated_html();
	}

	return $block_content;
}
add_filter( 'render_block_core/query', 'twentig_filter_compat_query_block', 10, 2 );

/**
 * Filters the navigation link block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_compat_navigation_link_block( $block_content, $block ) {

	$classnames = $block['attrs']['className'] ?? '';

	if ( str_contains( $classnames, 'is-style-tw-button-fill' ) || str_contains( $classnames, 'is-style-tw-button-outline' ) ) {
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();
		$tag_processor->add_class( 'wp-element-button' );
		$block_content = $tag_processor->get_updated_html();

		$buttons_colors     = wp_get_global_styles( array( 'elements', 'button', 'color' ) );
		$buttons_colors_css = '';

		if ( isset( $buttons_colors['background'] ) ) {
			$buttons_colors_css .= 'background-color: ' . esc_attr( $buttons_colors['background'] ) . ';';
		}

		if ( isset( $buttons_colors['text'] ) ) {
			$buttons_colors_css .= 'color: ' . esc_attr( $buttons_colors['text'] ) . ';';
		}

		$style = 'wp-block-navigation-link.wp-element-button a::before {
			content: none !important;
		}

		.wp-block-navigation-link.wp-element-button {
			font: inherit;
		}

		.wp-block-navigation .wp-block-navigation-link.wp-element-button a {
			padding: 0.625rem max(1rem,0.75em) !important;
			text-decoration: none !important;
			opacity: 1;
			border: 2px solid currentcolor;
			border-radius: inherit;
		}

		.wp-block-navigation .wp-block-navigation-link.is-style-tw-button-outline {
			background-color: transparent;
			background-image: none;
			color: currentcolor !important;
		}

		.wp-block-navigation .wp-block-navigation-link.is-style-tw-button-fill a {
			border-color: transparent;'
			. $buttons_colors_css .';
		}';

		add_action( 'wp_head', static function () use ( $style ) {
			echo '<style>' . twentig_minify_css( $style ) . '</style>';
		} );
	}

	return $block_content;
}
add_filter( 'render_block_core/navigation-link', 'twentig_filter_compat_navigation_link_block', 10, 2 );

/**
 * Filters the gallery block output.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_compat_gallery_block( $block_content, $block ) {

	if ( twentig_theme_supports_spacing() ) {
		$gap = $block['attrs']['style']['spacing']['blockGap'] ?? null;
		$gap = is_array( $gap ) && isset( $gap['left'] ) ? $gap['left'] : null;
		$gap = $gap ? $gap : '16px';

		if ( $gap && str_contains( $gap, 'px' ) ) {
			$tag_processor = new WP_HTML_Tag_Processor( $block_content );
			$tag_processor->next_tag();

			$gap_value = intval( $gap );

			if ( $gap_value > 32 ) {
				$tag_processor->add_class( 'tw-large-gap' );
			} elseif ( $gap_value > 16 ) {
				$tag_processor->add_class( 'tw-medium-gap' );
			}

			$block_content = $tag_processor->get_updated_html();
		}
	}

	$block_content = str_replace( 'tw-stack-sm', 'tw-cols-large', $block_content );

	return $block_content;
}
add_filter( 'render_block_core/gallery', 'twentig_filter_compat_gallery_block', 0, 2 );
