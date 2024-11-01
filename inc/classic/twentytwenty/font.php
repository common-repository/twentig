<?php
/**
 * Fonts
 *
 * @package twentig
 */

/**
 * Returns font stack for a given setting.
 *
 * @param string $setting The name of the setting.
 */
function twentig_get_font_stack( $setting ) {
	$font        = get_theme_mod( 'twentig_' . $setting . '_font' );
	$font_custom = get_theme_mod( 'twentig_' . $setting . '_font_custom' );
	$font_stack  = 'body' === $setting ? "'NonBreakingSpaceOverride', 'Hoefler Text', Garamond, 'Times New Roman', serif" : "'Inter var', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Helvetica, sans-serif";

	if ( 'sans-serif' === $font ) {
		$font_stack = '-apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Helvetica, sans-serif';
	} elseif ( 'custom-google-font' === $font ) {
		if ( $font_custom ) {
			$font_stack = "'" . $font_custom . "', " . get_theme_mod( 'twentig_' . $setting . '_font_fallback', 'sans-serif' );
		}
	} elseif ( $font ) {
		$font_stack = "'" . $font . "', " . twentig_get_font_fallback( $font );
	}
	return $font_stack;
}

/**
 * Returns custom Google fonts URL based on Customizer settings.
 */
function twentig_twentytwenty_fonts_url() {
	$fonts_url           = '';
	$fonts               = array();
	$body_font           = get_theme_mod( 'twentig_body_font' );
	$body_font_custom    = get_theme_mod( 'twentig_body_font_custom' );
	$heading_font        = get_theme_mod( 'twentig_heading_font' );
	$heading_font_custom = get_theme_mod( 'twentig_heading_font_custom' );
	$heading_font_weight = get_theme_mod( 'twentig_heading_font_weight', '700' );
	$menu_font           = get_theme_mod( 'twentig_menu_font', 'heading' );
	$menu_font_weight    = get_theme_mod( 'twentig_menu_font_weight', '500' );
	$secondary_font      = get_theme_mod( 'twentig_secondary_font', 'heading' );
	$logo_font           = get_theme_mod( 'twentig_logo_font' );
	$logo_font_custom    = get_theme_mod( 'twentig_logo_font_custom' );

	if ( 'custom-google-font' === $body_font && $body_font_custom ) {
		$body_font = $body_font_custom;
	}

	if ( 'custom-google-font' === $heading_font && $heading_font_custom ) {
		$heading_font = $heading_font_custom;
	}

	if ( 'custom-google-font' === $logo_font ) {
		$logo_font = $logo_font_custom;
	}

	if ( '' === $logo_font ) {
		$logo_font = $heading_font;
	}

	if ( $body_font && ! in_array( $body_font, array( 'sans-serif', 'custom-google-font' ), true ) ) {
		$fonts[ $body_font ] = array( '400', '700' );
		if ( 'body' === $menu_font ) {
			$fonts[ $body_font ][] = $menu_font_weight;
		}
	}

	if ( $heading_font && ! in_array( $heading_font, array( 'sans-serif', 'custom-google-font' ), true ) ) {

		if ( ! isset( $fonts[ $heading_font ] ) ) {
			$fonts[ $heading_font ] = array();
		}
		$fonts[ $heading_font ][] = $heading_font_weight;

		if ( 'heading' === $menu_font ) {
			$fonts[ $heading_font ][] = $menu_font_weight;
		}

		if ( 'heading' === $secondary_font ) {
			if ( ! in_array( '400', $fonts[ $heading_font ], true ) ) {
				$fonts[ $heading_font ][] = '400';
			}

			if ( ! in_array( '600', $fonts[ $heading_font ], true ) && ! in_array( '700', $fonts[ $heading_font ], true ) ) {
				$fonts[ $heading_font ][] = '700';
			}
		}
	}

	if ( $logo_font && ! has_custom_logo() && 'sans-serif' !== $logo_font ) {
		if ( ! isset( $fonts[ $logo_font ] ) ) {
			$fonts[ $logo_font ] = array();
		}
		$fonts[ $logo_font ][] = get_theme_mod( 'twentig_logo_font_weight', '700' );
	}

	if ( ! empty( $fonts ) ) {

		$args_url = '';
		foreach ( $fonts as $font_family => $variants ) {
			$variants = array_unique( $variants );
			sort( $variants );
			if ( $font_family === $body_font ) {
				$args_url .= '&family=' . urlencode( $font_family . ':ital,wght@0,' . implode( ';0,', $variants ) . ';1,400' ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			} else {
				$args_url .= '&family=' . urlencode( $font_family . ':wght@' . implode( ';', $variants ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode
			}
		}
		$args_url .= '&display=swap';

		$fonts_url = 'https://fonts.googleapis.com/css2?' . trim( $args_url, '&' );
	}

	return apply_filters( 'twentig_google_fonts_url', esc_url_raw( $fonts_url ) );
}

/**
 * Returns Google Fonts choices for body.
 */
function twentig_get_body_fonts() {
	$font_options = array();

	$google_font_options = twentig_twentytwenty_get_fonts();
	foreach ( $google_font_options as $font ) {
		if ( isset( $font['bodyText'] ) && ! $font['bodyText'] ) {
			continue;
		}
		$font_options[ $font['family'] ] = $font['family'];
	}
	return $font_options;
}

/**
 * Returns Google Fonts choices for headings.
 */
function twentig_get_heading_fonts() {
	$font_options = array();

	$google_font_options = twentig_twentytwenty_get_fonts();
	foreach ( $google_font_options as $font ) {
		if ( isset( $font['headingText'] ) && ! $font['headingText'] ) {
			continue;
		}
		$font_options[ $font['family'] ] = $font['family'];
	}
	return $font_options;
}

/**
 * Returns font fallback for a given font.
 *
 * @param string $font_name The name of the font.
 */
function twentig_get_font_fallback( $font_name ) {
	$fonts = twentig_twentytwenty_get_fonts();
	foreach ( $fonts as $font ) {
		if ( $font_name === $font['family'] ) {
			return $font['category'];
		}
	}
	return 'sans-serif';
}

/**
 * Returns all available fonts.
 */
function twentig_twentytwenty_get_fonts() {

	$fonts = array(
		array(
			'family'   => 'Alegreya',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Alegreya Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '700', '800', '900' ),
		),
		array(
			'family'   => 'Anonymous Pro',
			'category' => 'monospace',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Archivo Narrow',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Arimo',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Arvo',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Arya',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Asap',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Asap Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'B612',
			'category' => 'sans-serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Barlow',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Barlow Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Big Shoulders Display',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'BioRhyme',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '700', '800' ),
		),
		array(
			'family'   => 'Bitter',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Cabin',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Cabin Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Cardo',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Chivo',
			'category' => 'sans-serif',
			'variants' => array( '400', '700', '900' ),
		),
		array(
			'family'   => 'Comfortaa',
			'category' => 'cursive',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Cormorant Garamond',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Cousine',
			'category' => 'monospace',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Crimson Pro',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'DM Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '700' ),
		),
		array(
			'family'   => 'Domine',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Dosis',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'EB Garamond',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Eczar',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Exo 2',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Fira Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Fira Sans Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Fraunces',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Gentium Basic',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'IBM Plex Mono',
			'category' => 'monospace',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'IBM Plex Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'IBM Plex Sans Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'IBM Plex Serif',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Inconsolata',
			'category' => 'monospace',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Inknut Antiqua',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Inria Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Inria Serif',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Josefin Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Josefin Slab',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Jost',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Kalam',
			'category' => 'cursive',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Karla',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Lato',
			'category' => 'sans-serif',
			'variants' => array( '400', '700', '900' ),
		),
		array(
			'family'   => 'Lekton',
			'category' => 'sans-serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Libre Baskerville',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Libre Franklin',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Lora',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Manrope',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Merriweather',
			'category' => 'serif',
			'variants' => array( '400', '700', '900' ),
		),
		array(
			'family'   => 'Merriweather Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Montserrat',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Muli',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Neuton',
			'category' => 'serif',
			'variants' => array( '400', '700', '800' ),
		),
		array(
			'family'   => 'Newsreader',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Noto Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Noto Sans Display',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Noto Serif',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Noto Serif Display',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Nunito',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Nunito Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Old Standard TT',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Open Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Oswald',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Overpass',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Piazzolla',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Playfair Display',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Poppins',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Proza Libre',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'PT Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'PT Sans Narrow',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'PT Serif',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Public Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Quattrocento',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Quattrocento Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Rajdhani',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Red Hat Display',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Red Hat Text',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Raleway',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Roboto',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '700', '900' ),
		),
		array(
			'family'   => 'Roboto Condensed',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Roboto Mono',
			'category' => 'monospace',
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Roboto Slab',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Rubik',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Rufina',
			'category' => 'serif',
			'bodyText' => false,
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Signika',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Source Code Pro',
			'category' => 'monospace',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Source Sans Pro',
			'category' => 'sans-serif',
			'variants' => array( '400', '600', '700', '900' ),
		),
		array(
			'family'   => 'Source Serif Pro',
			'category' => 'serif',
			'variants' => array( '400', '600', '700', '900' ),
		),
		array(
			'family'   => 'Space Grotesk',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Space Mono',
			'category' => 'monospace',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Spectral',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Syne',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700', '800' ),
		),
		array(
			'family'   => 'Taviraj',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Tinos',
			'category' => 'serif',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Titillium Web',
			'category' => 'sans-serif',
			'variants' => array( '400', '600', '700', '900' ),
		),
		array(
			'family'   => 'Ubuntu',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '700' ),
		),
		array(
			'family'   => 'Ubuntu Mono',
			'category' => 'monospace',
			'variants' => array( '400', '700' ),
		),
		array(
			'family'   => 'Vollkorn',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Work Sans',
			'category' => 'sans-serif',
			'variants' => array( '400', '500', '600', '700', '800', '900' ),
		),
		array(
			'family'   => 'Yanone Kaffeesatz',
			'category' => 'sans-serif',
			'bodyText' => false,
			'variants' => array( '400', '500', '600', '700' ),
		),
		array(
			'family'   => 'Zilla Slab',
			'category' => 'serif',
			'variants' => array( '400', '500', '600', '700' ),
		),
	);

	return apply_filters( 'twentig_fonts', $fonts );
}

/**
 * Returns font weight choices.
 */
function twentig_get_font_styles() {

	$list_font_weights = array(
		''    => esc_html__( 'Default', 'twentig' ),
		'300' => 'Light 300',
		'400' => 'Regular 400',
		'500' => 'Medium 500',
		'600' => 'Semi-Bold 600',
		'700' => 'Bold 700',
		'800' => 'Extra-Bold 800',
		'900' => 'Black 900',
	);
	return $list_font_weights;
}

/**
 * Returns default body font size. Back compat for early versions.
 */
function twentig_get_default_body_font_size() {
	if ( 'sans-serif' === get_theme_mod( 'twentig_body_font' ) && '' === get_theme_mod( 'twentig_body_font_size', '' ) ) {
		return 'medium';
	}
	return 'large';
}

/**
 * Returns font presets.
 */
function twentig_twentytwenty_get_font_presets() {

	$presets = array(
		array(
			'name' => 'Default',
			'mods' => array(
				'twentig_body_font'              => '',
				'twentig_body_font_size'         => 'large',
				'twentig_body_line_height'       => '',
				'twentig_heading_font'           => '',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => '',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '500',
				'twentig_menu_font_size'         => '',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Roboto + Roboto',
			'mods' => array(
				'twentig_body_font'              => 'Roboto',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Roboto',
				'twentig_heading_font_weight'    => '500',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '500',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Playfair Display + Lato',
			'mods' => array(
				'twentig_body_font'              => 'Lato',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Playfair Display',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'Merriweather Sans + Merriweather',
			'mods' => array(
				'twentig_body_font'              => 'Merriweather',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'loose',
				'twentig_heading_font'           => 'Merriweather Sans',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Source Serif Pro + Source Sans Pro',
			'mods' => array(
				'twentig_body_font'              => 'Source Sans Pro',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Source Serif Pro',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '600',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Libre Franklin + Libre Baskerville',
			'mods' => array(
				'twentig_body_font'              => 'Libre Baskerville',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'loose',
				'twentig_heading_font'           => 'Libre Franklin',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Raleway + Raleway',
			'mods' => array(
				'twentig_body_font'              => 'Raleway',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Raleway',
				'twentig_heading_font_weight'    => '500',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '500',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Alegreya + Alegreya Sans',
			'mods' => array(
				'twentig_body_font'              => 'Alegreya Sans',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => '',
				'twentig_heading_font'           => 'Alegreya',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => '',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Cabin + Crimson Pro',
			'mods' => array(
				'twentig_body_font'              => 'Crimson Pro',
				'twentig_body_font_size'         => 'large',
				'twentig_body_line_height'       => '',
				'twentig_heading_font'           => 'Cabin',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Barlow Condensed + Barlow',
			'mods' => array(
				'twentig_body_font'              => 'Barlow',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Barlow Condensed',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '600',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'Rufina + Tinos',
			'mods' => array(
				'twentig_body_font'              => 'Tinos',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => '',
				'twentig_heading_font'           => 'Rufina',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => '',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Open Sans + Open Sans',
			'mods' => array(
				'twentig_body_font'              => 'Open Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Open Sans',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Domine + Arimo',
			'mods' => array(
				'twentig_body_font'              => 'Arimo',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Domine',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'IBM Plex Sans + IBM Plex Serif',
			'mods' => array(
				'twentig_body_font'              => 'IBM Plex Serif',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'loose',
				'twentig_heading_font'           => 'IBM Plex Sans',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '600',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Quattrocento + Quattrocento Sans',
			'mods' => array(
				'twentig_body_font'              => 'Quattrocento Sans',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Quattrocento',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Montserrat + Montserrat',
			'mods' => array(
				'twentig_body_font'              => 'Montserrat',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Montserrat',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Nunito + Nunito Sans',
			'mods' => array(
				'twentig_body_font'              => 'Nunito Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Nunito',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '600',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Old Standard TT + Nunito Sans',
			'mods' => array(
				'twentig_body_font'              => 'Nunito Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Old Standard TT',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'Work Sans + Work Sans',
			'mods' => array(
				'twentig_body_font'              => 'Work Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Work Sans',
				'twentig_heading_font_weight'    => '600',
				'twentig_heading_letter_spacing' => '',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '600',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Oswald + Roboto',
			'mods' => array(
				'twentig_body_font'              => 'Roboto',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Oswald',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'Spectral + Spectral',
			'mods' => array(
				'twentig_body_font'              => 'Spectral',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => '',
				'twentig_heading_font'           => 'Spectral',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => '',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Lato + Lora',
			'mods' => array(
				'twentig_body_font'              => 'Lora',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Lato',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Roboto Slab + Roboto',
			'mods' => array(
				'twentig_body_font'              => 'Roboto',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Roboto Slab',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Rubik + Rubik',
			'mods' => array(
				'twentig_body_font'              => 'Rubik',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Rubik',
				'twentig_heading_font_weight'    => '500',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '500',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'BioRhyme + Cabin',
			'mods' => array(
				'twentig_body_font'              => 'Cabin',
				'twentig_body_font_size'         => 'medium',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'BioRhyme',
				'twentig_heading_font_weight'    => '400',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Noto Sans Display + Noto Serif',
			'mods' => array(
				'twentig_body_font'              => 'Noto Serif',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'loose',
				'twentig_heading_font'           => 'Noto Sans Display',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'PT Serif + PT Sans',
			'mods' => array(
				'twentig_body_font'              => 'PT Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'PT Serif',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'IBM Plex Sans + IBM Plex Sans',
			'mods' => array(
				'twentig_body_font'              => 'IBM Plex Sans',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'IBM Plex Sans',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Playfair Display + Lora',
			'mods' => array(
				'twentig_body_font'              => 'Lora',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Playfair Display',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'small',
				'twentig_menu_text_transform'    => 'uppercase',
			),
		),
		array(
			'name' => 'Arimo + Bitter',
			'mods' => array(
				'twentig_body_font'              => 'Bitter',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'loose',
				'twentig_heading_font'           => 'Arimo',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'heading',
				'twentig_menu_font'              => 'heading',
				'twentig_menu_font_weight'       => '700',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
		array(
			'name' => 'Red Hat Display + Red Hat Text',
			'mods' => array(
				'twentig_body_font'              => 'Red Hat Text',
				'twentig_body_font_size'         => 'small',
				'twentig_body_line_height'       => 'medium',
				'twentig_heading_font'           => 'Red Hat Display',
				'twentig_heading_font_weight'    => '700',
				'twentig_heading_letter_spacing' => 'normal',
				'twentig_h1_font_size'           => 'medium',
				'twentig_secondary_font'         => 'body',
				'twentig_menu_font'              => 'body',
				'twentig_menu_font_weight'       => '400',
				'twentig_menu_font_size'         => 'medium',
				'twentig_menu_text_transform'    => '',
			),
		),
	);

	return $presets;
}
add_filter( 'twentig_font_presets', 'twentig_twentytwenty_get_font_presets' );
