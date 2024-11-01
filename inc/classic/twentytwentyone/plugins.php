<?php

/**
 * Add compatibility for various plugins.
 */
function twentig_twentyone_plugins_setup() {
	if ( class_exists( 'Jetpack' ) ) {
		// Add theme support for Jetpack Infinite Scroll.
		if ( function_exists( 'twentytwentyone_infinite_scroll_render' ) ) {
			add_theme_support(
				'infinite-scroll',
				array(
					'type'      => 'click',
					'container' => 'main',
					'wrapper'   => false,
					'render'    => 'twentytwentyone_infinite_scroll_render',
					'footer'    => 'main',
				)
			);
		}
	}

	if ( class_exists( 'C_NextGEN_Bootstrap' ) ) {
		// Disable NextGen resource manager that breaks custom footer.
		if ( ! defined( 'NGG_DISABLE_RESOURCE_MANAGER' ) ) {
			define( 'NGG_DISABLE_RESOURCE_MANAGER', true );
		}
	}

	if ( class_exists( 'WPCF7_ContactForm' ) && get_theme_mod( 'twentig_page_contact' ) ) {
		add_filter( 'wpcf7_load_css', '__return_false' );
		add_filter( 'wpcf7_load_js', '__return_false' );
	}
}
add_action( 'after_setup_theme', 'twentig_twentyone_plugins_setup', 11 );

/**
 * Add custom CSS to improve plugins styling.
 *
 * @param string $css The css to enqueue in the header.
 */
function twentig_twentyone_plugins_css( $css ) {

	// Jetpack infinite scroll.
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {

		$button_text_transform   = get_theme_mod( 'twentig_button_text_transform' );
		$button_text_color       = get_theme_mod( 'twentig_button_text_color' );
		$button_background       = get_theme_mod( 'twentig_button_background_color' );
		$button_hover_background = get_theme_mod( 'twentig_button_hover_background_color' );

		$css .= '
		.tw-blog-grid #infinite-handle,
		.tw-blog-grid .infinite-loader {
			width: 100%;
			max-width: none;
			grid-column: 1 / -1;
			margin-top: 30px;
		}

		.tw-blog-grid.tw-blog-card #infinite-handle,
		.tw-blog-grid.tw-blog-card .infinite-loader {
			margin-top: 45px;
		}

		body[class*=" infinity-"] main#main > article:last-of-type .entry-footer {
			border: 0 !important;
		}

		body[class*="tw-blog-img-ratio"] .hentry .post-thumbnail img {
			height: 100% !important;
		}

		#infinite-handle span {
			display: block;
			line-height: var(--button--line-height);
			color: var(--button--color-text);
			font-weight: var(--button--font-weight);
			font-family: var(--button--font-family);
			font-size: var(--button--font-size);
			background-color: var(--button--color-background);
			border-radius: var(--button--border-radius);
			border: var(--button--border-width) solid var(--button--color-background);
		}

		#infinite-handle span:focus-within {
			outline-offset: -6px;
			outline: 1px dotted currentcolor; 
		}

		#infinite-handle span button:focus {
			outline: 0;
		}

		.infinite-loader {
			height: 58px;
			margin-top: calc(3 * var(--global--spacing-vertical));
			display: flex;
			align-items: center;
			justify-content: center;
		}';

		if ( 'uppercase' === $button_text_transform ) {
			$css .= '#infinite-handle button { text-transform: uppercase; }';
		}

		if ( $button_background ) {
			$css .= '#infinite-handle span { 
				background-color:' . $button_background . ';
				border-color:' . $button_background . ';';
			if ( $button_text_color ) {
				$css .= 'color:' . $button_text_color . ';';
			}
			$css .= '}';
			if ( $button_hover_background ) {
				$css .= '
				#infinite-handle span:hover,
				#infinite-handle span:focus-within { 
					background-color:' . $button_hover_background . ' !important;
					border-color:' . $button_hover_background . ' !important;';
				if ( $button_text_color ) {
					$css .= 'color:' . $button_text_color . ' !important;';
				}
				$css .= '}';
			} else {
				$css .= '
				#infinite-handle span:hover,
				#infinite-handle span:focus-within { 
					background-color: transparent !important;
					border-color:' . $button_background . ' !important;
					color:' . $button_background . ' !important;';
				$css .= '}';
			}
		}
	}

	// Contact Form 7.
	if ( class_exists( 'WPCF7_ContactForm' ) ) {
		$css .= '
		.wpcf7-form p { 
			margin-bottom: 30px;
		}

		span.wpcf7-form-control-wrap {
			display: block;
			margin-top: 10px;
		}

		div.wpcf7 .ajax-loader,
		div.wpcf7 wpcf7-spinner {
			margin-left: 20px;
			vertical-align: text-top;
		}
		
		.wpcf7-not-valid-tip {
			font-size: var(--global--font-size-xs);
			margin-top: 5px;
			color: var(--error--color);
		}
		
		.wpcf7-text {
			width: 100%;
		}

		.wpcf7 form .wpcf7-response-output {
			margin: 40px 0 0;
			border: 0;
			padding: 0;
			color: var(--error--color);
		}
		
		.wpcf7 form.sent .wpcf7-response-output {
			color: currentcolor;
		}

		.wpcf7-list-item.first {
			margin-left: 0;
		}
		
		.wpcf7-list-item label {
			display: flex;
		}

		input + .wpcf7-list-item-label,
		.wpcf7-list-item-label + input { 
			margin-left: 10px; 
		}
		';
	}

	return $css;
}
add_filter( 'twentig_twentyone_custom_css', 'twentig_twentyone_plugins_css' );

/**
 * Enqueue plugin scripts.
 */
function twentig_twentyone_enqueue_plugin_scripts() {
	if ( class_exists( 'WPCF7_ContactForm' ) ) {
		$contact_page = get_theme_mod( 'twentig_page_contact' );
		if ( $contact_page && is_page( $contact_page ) ) {
			if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
				wpcf7_enqueue_scripts();
			}
			if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
				wpcf7_enqueue_styles();
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'twentig_twentyone_enqueue_plugin_scripts' );
