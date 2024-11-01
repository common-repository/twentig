<?php

/**
 * Add compatibility for various plugins.
 */
function twentig_twentytwenty_plugins_setup() {
	if ( class_exists( 'Jetpack' ) ) {
		// Add theme support for Jetpack Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			array(
				'type'           => 'click',
				'container'      => 'site-content',
				'wrapper'        => false,
				'render'         => 'twentytwenty_infinite_scroll_render',
				'footer'         => 'site-content',
				'footer_widgets' => array(
					'sidebar-1',
					'sidebar-2',
				),
			)
		);
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

	if ( class_exists( 'woocommerce' ) ) {
		add_action( 'woocommerce_sidebar', 'twentig_twentytwenty_wc_footer_widgets', 100 );
	}
}
add_action( 'after_setup_theme', 'twentig_twentytwenty_plugins_setup', 11 );

/**
 * Fix footer widgets not showing on WooCommerce pages.
 */
function twentig_twentytwenty_wc_footer_widgets() {
	if ( 0 === did_action( 'get_template_part_template-parts/footer-menus-widgets' ) ) {
		get_template_part( 'template-parts/footer-menus-widgets' );
	}
}

/**
 * Add custom CSS to improve plugins styling.
 *
 * @param string $css The css to enqueue in the header.
 */
function twentig_twentytwenty_plugins_css( $css ) {

	// Jetpack infinite scroll.
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {

		$hex = get_theme_mod( 'twentig_accent_hex_color' );

		if ( $hex ) {
			$css .= '.infinite-scroll #site-content #infinite-handle span button { background-color:' . $hex . '}';
		}

		$css .= '
		.infinite-loader {
			margin: 4rem auto 0;
			width: 100%;
			height: 63px;
			display: flex;
			align-items: center;
		}
		
		body:not(.tw-blog-grid) #site-content #infinite-handle {
			margin-top: 4rem;
		}
		
		.tw-blog-grid #site-content #infinite-handle {
			max-width: 100%;
			width: 100%;
			margin: 2rem auto 0;
		}
		
		.tw-blog-grid-basic #site-content #infinite-handle,
		.tw-blog-grid-basic .infinite-loader {
			margin-top: 0;
		}
		
		.tw-blog-grid-basic.infinity-end #site-content {
			margin-bottom: -6rem;
		}
		
		.tw-blog-grid-card.infinity-end #site-content {
			margin-bottom: -32px;
		}
		
		@media (min-width: 700px) {
		
			body:not(.tw-blog-grid) #site-content .infinite-loader,
			body:not(.tw-blog-grid) #site-content #infinite-handle {
				margin-top: 7rem;
			}
		
			.tw-blog-grid-card #site-content #infinite-handle {
				margin-top: 5rem;
			}
		
		}';
	}

	// Contact Form 7.
	if ( class_exists( 'WPCF7_ContactForm' ) ) {
		$css .= '
		.wpcf7-form p { 
			margin-bottom: 2.5rem;
		}

		span.wpcf7-form-control-wrap {
			display: block;
			margin-top: 5px;
		}

		div.wpcf7 .ajax-loader,
		div.wpcf7 wpcf7-spinner {
			margin-left: 20px;
			vertical-align: text-top;
		}
		
		.wpcf7-not-valid-tip {
			font-size: 1.4rem;
			margin-top: 5px;
			color: #eb0017;
		}
		
		.wpcf7 form .wpcf7-response-output {
			margin: 40px 0 0;
			border: 0;
			padding: 0;
			color: #eb0017;
		}
		
		.wpcf7 form.sent .wpcf7-response-output {
			color: currentcolor;
		}

		.wpcf7-list-item.first {
			margin-left: 0;
		}

		.wpcf7-list-item input[type="radio"],
		.wpcf7-list-item input[type="checkbox"] {
			margin: 0;
			top: initial;
		}
		
		.wpcf7-list-item label {
			display: flex;
			align-items: center;
		}

		input + .wpcf7-list-item-label,
		.wpcf7-list-item-label + input[type="radio"],
		.wpcf7-list-item-label + input[type="checkbox"] { 
			margin-left: 10px; 
		}
		';
	}

	return $css;
}
add_filter( 'twentig_customizer_css', 'twentig_twentytwenty_plugins_css' );

/**
 * Enqueue plugin scripts.
 */
function twentig_twentytwenty_enqueue_plugin_scripts() {
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
add_action( 'wp_enqueue_scripts', 'twentig_twentytwenty_enqueue_plugin_scripts' );
