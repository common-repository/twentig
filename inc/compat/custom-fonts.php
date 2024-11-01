<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue styles for block themes: spacing, layout, fonts.
 */
function twentig_block_theme_enqueue_font_scripts() {

	/* Enqueue fonts */
	$fonts = twentig_get_additional_fonts();

	if ( ! empty ( $fonts ) ) {

		/* Adds font css variables. */
		$font_css = twentig_get_custom_font_css_variables();
		wp_add_inline_style( 'global-styles', twentig_minify_css( $font_css ) );

		$enqueue_fonts = array();

		if ( count( $fonts ) < 3 ) {
			foreach ( $fonts as $font ) {
				$enqueue_fonts[] = $font['src'];
			}
		} else {

			global $template_html;
		
			$merged_json      = WP_Theme_JSON_Resolver::get_merged_data()->get_raw_data();
			$theme_fonts      = $merged_json['settings']['typography']['fontFamilies']['theme'];
			$global_styles    = wp_get_global_styles();
			$stylesheet       = json_encode( $global_styles );		
			$content_to_check = $stylesheet . $template_html;

			foreach ( $theme_fonts as $index => $font ) {
				if ( 'google' === ( $font['provider'] ?? null ) || empty($font['fontFace'] ) ) {
					unset( $theme_fonts[ $index ] );
				}
			}

			foreach ( $fonts as $font ) {
				$family_slug = sanitize_title( $font['slug'] );
				$family      = $font['fontFamily'];

				if ( in_array( $family_slug, array_column( $theme_fonts, 'slug' ), true ) ) {
					continue;
				}

				if ( str_contains( $content_to_check, json_encode( $family ) ) || 
					str_contains( $content_to_check, 'var(--wp--preset--font-family--' . $family_slug . ')' ) ||
					str_contains( $content_to_check, 'has-' . $family_slug . '-font-family' ) ||
					str_contains( $content_to_check, 'var:preset|font-family|' . $family_slug ) ) {
						$enqueue_fonts[] = $font['src'];
				}
			}
		}

		if ( ! empty( $enqueue_fonts ) ) {
			$typography = get_option( 'twentig_typography' );
			$local      = $typography['local'] ?? true;
			$remote_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_unique( array_values( $enqueue_fonts ) ) ) . '&display=swap';

			if ( $local ) {
				require TWENTIG_PATH . 'inc/compat/wptt-webfont-loader.php';
				wp_register_style( 'twentig-webfonts', '' );
				wp_enqueue_style( 'twentig-webfonts' );
				wp_add_inline_style( 'twentig-webfonts', twentig_minify_css( wptt_get_webfont_styles( $remote_url ) ) );
			} else {
				wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
					'twentig-google-fonts',
					esc_url_raw( $remote_url ),
					array(),
					null
				);
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'twentig_block_theme_enqueue_font_scripts', 11 );

/**
 * Enqueue styles inside the editor.
 */
function twentig_block_theme_editor_font_styles() {

	$fonts = twentig_get_additional_fonts();

	if ( ! empty ( $fonts ) ) {
		$enqueue_fonts = array();
		$css           = twentig_get_custom_font_css_variables();

		foreach ( $fonts as $font ) {
			$enqueue_fonts[] = $font['src'];
		}

		if ( ! empty( $enqueue_fonts ) ) {
			require TWENTIG_PATH . 'inc/compat/wptt-webfont-loader.php';
			$remote_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_unique( array_values( $enqueue_fonts ) ) ) . '&display=swap';
			if ( count( $enqueue_fonts ) < 3 ) {
				$css .= wptt_get_webfont_styles( $remote_url );
			} else {
				$css .= twentig_get_cached_remote_font_styles( $remote_url );
			}
		}

		wp_add_inline_style( 'wp-block-library', twentig_minify_css( $css ) );
	}
}
add_action( 'admin_init', 'twentig_block_theme_editor_font_styles' );

/**
 * Hooks into the data provided by the theme to add new font options.
 */
function twentig_filter_theme_json_font_theme( $theme_json ) {

	$current_data = $theme_json->get_data();
	$fonts        = twentig_get_additional_fonts();

	if ( empty ( $fonts ) || ! isset( $current_data['version'] ) || $current_data['version'] !== 2 ) {
		return $theme_json;
	}

	$default_font_families = $current_data['settings']['typography']['fontFamilies']['theme'] ?? array();
	$default_font_families = twentig_merge_fonts_to_theme_fonts( $default_font_families );

	$new_data = array(
		'version'  => 2,
		'settings' => array(
			'typography' => array(
				'fontFamilies' => array(
					'theme' => $default_font_families,
				),
			),
		),
	);

	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'twentig_filter_theme_json_font_theme' );

/**
 * Gets Twentig custom font settings.
 */
function twentig_get_custom_font_settings() {
	$typography   = get_option( 'twentig_typography' );
	$font1        = $typography['font1'] ?? '';
	$font1_styles = $typography['font1_styles'] ?? array();
	$font2        = $typography['font2'] ?? '';
	$font2_styles = $typography['font2_styles'] ?? array();

	return array( $font1, $font2, $font1_styles, $font2_styles );
}

/**
 * Gets custom font CSS variables.
 */
function twentig_get_custom_font_css_variables() {
	$css = '';

	list( $font1, $font2 ) = twentig_get_custom_font_settings();

	if ( $font1 ) {
		$css .= '--tw-font-1:' . $font1 . ';';
	}

	if ( $font2 ) {
		$css .= '--tw-font-2:' . $font2 . ';';
	}

	if ( $css ) {
		$css = 'body{' . $css . '}';
	}

	return $css;
}

/**
 * Gets Twentig additional fonts.
 */
function twentig_get_additional_fonts() {

	$fonts = array();

	list( $font1, $font2, $font1_styles, $font2_styles ) = twentig_get_custom_font_settings();

	if ( $font1 ) {
		$font_name = twentig_get_font_name( $font1 );
		$fonts[]   = array(
			'fontFamily' => 'var(--tw-font-1)',
			'slug'       => 'tw-font-1',
			'name'       => esc_html__( 'Font 1', 'twentig' ) . ': ' . $font_name,
			'src'        => twentig_build_google_font_url_part( $font_name, $font1_styles ),
			'provider'   => 'google',
		);
	}

	if ( $font2 ) {
		$font_name = twentig_get_font_name( $font2 );
		$fonts[]   = array(
			'fontFamily' => 'var(--tw-font-2)',
			'slug'       => 'tw-font-2',
			'name'       => esc_html__( 'Font 2', 'twentig' ) . ': ' . $font_name,
			'src'        => twentig_build_google_font_url_part( $font_name, $font2_styles ),
			'provider'   => 'google',
		);
	}

	$show_curated  = apply_filters( 'twentig_show_curated_fonts', false );
	$curated_fonts = $show_curated ? twentig_get_curated_fonts() : array();
	$fonts         = array_merge( $fonts, $curated_fonts );

	return $fonts;
}

/**
 * Gets list of curated fonts.
 */
function twentig_get_curated_fonts() {

	$curated_fonts = array(
		array(
			'fontFamily' => '"Alegreya", serif',
			'slug'       => 'alegreya',
			'name'       => 'Alegreya',
			'src'        => 'Alegreya:ital,wght@0,400..900;1,400..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Cabin", sans-serif',
			'slug'       => 'cabin',
			'name'       => 'Cabin',
			'src'        => 'Cabin:ital,wght@0,400..700;1,400..700',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Crimson Pro", serif',
			'slug'       => 'crimson-pro',
			'name'       => 'Crimson Pro',
			'src'        => 'Crimson+Pro:ital,wght@0,200..900;1,200..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"EB Garamond", serif',
			'slug'       => 'eb-garamond',
			'name'       => 'EB Garamond',
			'src'        => 'EB+Garamond:ital,wght@0,400..800;1,400..800',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Inter", sans-serif',
			'slug'       => 'inter',
			'name'       => 'Inter',
			'src'        => 'Inter:wght@100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Libre Franklin", sans-serif',
			'slug'       => 'libre-franklin',
			'name'       => 'Libre Franklin',
			'src'        => 'Libre+Franklin:ital,wght@0,100..900;1,100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Lora", serif',
			'slug'       => 'lora',
			'name'       => 'Lora',
			'src'        => 'Lora:ital,wght@0,400..700;1,400..700',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Open Sans", sans-serif',
			'slug'       => 'open-sans',
			'name'       => 'Open Sans',
			'src'        => 'Open+Sans:ital,wght@0,300..800;1,300..800',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Playfair Display", serif',
			'slug'       => 'playfair-display',
			'name'       => 'Playfair Display',
			'src'        => 'Playfair+Display:ital,wght@0,400..900;1,400..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Raleway", sans-serif',
			'slug'       => 'raleway',
			'name'       => 'Raleway',
			'src'        => 'Raleway:ital,wght@0,100..900;1,100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Roboto Flex", sans-serif',
			'slug'       => 'roboto-flex',
			'name'       => 'Roboto Flex',
			'src'        => 'Roboto+Flex:wght@100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Roboto Mono", monospace',
			'slug'       => 'roboto-mono',
			'name'       => 'Roboto Mono',
			'src'        => 'Roboto+Mono:ital,wght@0,100..700;1,100..700',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Roboto Serif", serif',
			'slug'       => 'roboto-serif',
			'name'       => 'Roboto Serif',
			'src'        => 'Roboto+Serif:ital,wght@0,100..900;1,100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Roboto Slab", serif',
			'slug'       => 'roboto-slab',
			'name'       => 'Roboto Slab',
			'src'        => 'Roboto+Slab:wght@100..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Rubik", sans-serif',
			'slug'       => 'rubik',
			'name'       => 'Rubik',
			'src'        => 'Rubik:ital,wght@0,300..900;1,300..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Source Sans 3", sans-serif',
			'slug'       => 'source-sans-3',
			'name'       => 'Source Sans 3',
			'src'        => 'Source+Sans+3:ital,wght@0,200..900;1,200..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Source Serif 4", serif',
			'slug'       => 'source-serif-4',
			'name'       => 'Source Serif 4',
			'src'        => 'Source+Serif+4:ital,wght@0,200..900;1,200..900',
			'provider'   => 'google',
		),
		array(
			'fontFamily' => '"Work Sans", sans-serif',
			'slug'       => 'work-sans',
			'name'       => 'Work Sans',
			'src'        => 'Work+Sans:ital,wght@0,100..900;1,100..900',
			'provider'   => 'google',
		),
	);

	return apply_filters( 'twentig_curated_google_fonts', $curated_fonts );
}

/**
 * Gets the font name of a given font stack.
 *
 * @param string  $font_stack The font stack.
 */
function twentig_get_font_name( $font_stack ) {
	$font_name = explode( ',', $font_stack )[0];
	$font_name = str_replace( "'", '', $font_name );
	return $font_name;
}

/**
 * Builds the URL part for the Google Font.
 * 
 *  @param string  $font_family The font family.
 *  @param array   $weights     The weights to load.
 */
function twentig_build_google_font_url_part( $font_family, $weights = array() ) {
	$normal_weights = array();
	$italic_weights = array();

	foreach ( $weights as $index => $weight ) {
		if ( str_contains( $weight, 'italic' ) ) {
			$italic_weights[] = str_replace( 'italic', '', $weight );
		} else {
			$normal_weights[] = $weight;
		}
	}

	// Remove duplicates.
	$normal_weights = array_unique( $normal_weights );
	$italic_weights = array_unique( $italic_weights );

	// Tuples must be sorted
	sort( $normal_weights );
	sort( $italic_weights );

	// Build the font-style with its font-weights.
	$url_part = urlencode( $font_family );
	if ( empty( $italic_weights ) && ! empty( $normal_weights ) ) {
		$url_part .= ':wght@' . implode( ';', $normal_weights );
	} elseif ( ! empty( $italic_weights ) && empty( $normal_weights ) ) {
		$url_part .= ':ital,wght@1,' . implode( ';', $normal_weights );
	} elseif ( ! empty( $italic_weights ) && ! empty( $normal_weights ) ) {
		$url_part .= ':ital,wght@0,' . implode( ';0,', $normal_weights ) . ';1,' . implode( ';1,', $italic_weights );
	}

	return $url_part;
}

/**
 * Merges our additional fonts with the theme fonts and make sure the values are unique.
 *
 * @param array $theme_fonts The theme fonts.
 * @return array             The merged fonts.
 */
function twentig_merge_fonts_to_theme_fonts( $theme_fonts = array() ) {
	$new_fonts = twentig_get_additional_fonts();
	foreach ( $new_fonts as $font ) {
		if ( in_array( $font['slug'], array_column( $theme_fonts, 'slug' ), true ) ) {
			continue;
		}
		$theme_fonts[] = $font;
	}
	return $theme_fonts;
}

/**
 * Gets cached CSS from a remote URL.
 *
 * @param string $url  The remote URL.
 *
 * @return string The CSS.
*/
function twentig_get_cached_remote_font_styles( $url ) {

	$cache_key = 'twentig_google_fonts_' . md5( $url );
	$css       = get_site_transient( $cache_key );
	
	if ( false === $css ) {

		// Use a modern user-agent to get woff2 files.
		$user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36';

		// Gets styles from the remote font URL.
		$response = wp_safe_remote_get( $url, array( 'user-agent' => $user_agent ) );

		if ( is_wp_error( $response ) || ! str_contains( wp_remote_retrieve_header( $response, 'content-type' ), 'text/css') ) {
			$css = '';
		} else {
			$contents = wp_remote_retrieve_body( $response );
			$css      = twentig_minify_css( $contents );
		}

		// Cache the CSS.
		if ( empty( $css ) ) {
			set_site_transient( $cache_key, '', MINUTE_IN_SECONDS );
			return '';
		}
		set_site_transient( $cache_key, $css, MONTH_IN_SECONDS );
	}
	return $css;
}

/**
 * Adds preconnect for Google Fonts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 */
function twentig_google_fonts_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentig-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'twentig_google_fonts_resource_hints', 10, 2 );

/**
 * Searches if Twentig curated fonts are inside global styles.
 */
function twentig_find_curated_fonts() {
	
	$curated_fonts   = array_column( twentig_get_curated_fonts(), 'slug' );
	$merged_settings = WP_Theme_JSON_Resolver::get_merged_data()->get_settings();
	$theme_fonts     = $merged_settings['typography']['fontFamilies']['theme'] ?? array();
	$custom_fonts    = $merged_settings['typography']['fontFamilies']['custom'] ?? array();
	$all_fonts       = array_merge( $theme_fonts, $custom_fonts );

	foreach ( $all_fonts as $index => $font ) {
		$key = array_search( $font['slug'], $curated_fonts );
		if ( $key !== false ) {
			if ( empty( $font['fontFace'] ) ) {
				return true;
			} else {
				unset( $curated_fonts[$key] );
			}
		}
	}

	$curated_fonts = array_values( $curated_fonts );

	$user_cpt = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme() );
	
	if ( empty( $user_cpt['post_content'] ) ) {
		return false;
	}

	$decoded_data = json_decode( $user_cpt['post_content'], true );
	
	if ( ! isset( $decoded_data['styles'] ) ) {
		return false;
	}

	$style = wp_json_encode( $decoded_data['styles'] );

	foreach ( $curated_fonts as $curated_font ) {	
		$presetString = "\"var:preset|font-family|{$curated_font}\"";
		$varString = "var(--wp--preset--font-family--{$curated_font})";
		if ( str_contains( $style, $presetString ) || str_contains( $style, $varString ) ) {
			return true;
		}
	}

	return false;
}
