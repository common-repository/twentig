<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Twentig Settings class.
 */
class TwentigSettings {

	/**
	 * Initializes the class.
	 */
	public function __construct() {
		add_action( 'admin_init',  array( $this, 'register_settings' ) );
		add_action( 'plugins_loaded', array( $this, 'disable_core_block_features' ) );
	}

	/**
	 * Registers the necessary REST API routes.
	 */
	public function register_routes() {

		register_rest_route(
			'twentig/v1',
			'/update-settings',
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'save_settings' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			) 
		);
	}

	/**
	 * Registers the settings.
	 */
	public function register_settings() {

		register_setting(
			'twentig-options',
			'twentig-options',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_options' )
			)
		);

		register_setting(
			'twentig_typography',
			'twentig_typography',
			array(
				'type'              => 'object',
				'default'           => array( 'local' => true ),
				'sanitize_callback' => array( $this, 'sanitize_typography' ),
			)
		);
	}

	/**
	 * Sanitizes the Twentig settings.
	 *
	 * @param array $settings The settings to validate.
	 * @return array The sanitized settings.
	 */
	public function sanitize_options( array $settings ) {
		$allowed_settings = array(
			'twentig_core_block_directory',
			'twentig_widgets_block_editor',
			'twentig_core_block_patterns',
			'patterns',
			'openverse',
			'predefined_spacing',
			'portfolio',
			'portfolio_slug',
			'portfolio_category_slug',
			'portfolio_tag_slug'
		);

		foreach ( $settings as $key => &$value ) {
			if ( ! in_array( $key, $allowed_settings ) ) {
				// Ignore any parameters not in the allowed list
				unset( $settings[$key] );
				continue;
			}

			switch ( $key ) {
				case 'twentig_core_block_directory':
				case 'twentig_widgets_block_editor':
				case 'twentig_core_block_patterns':
				case 'patterns':
				case 'openverse':
				case 'predefined_spacing':
				case 'portfolio':
					$value = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
					break;
				case 'portfolio_slug':
				case 'portfolio_category_slug':
				case 'portfolio_tag_slug':
					$value = sanitize_title( $value );
					break;
			}
		}

		return $settings;
	}

	/**
	 * Sanitizes the typography settings.
	 *
	 * @param array $settings The settings to validate.
	 * @return array The sanitized settings.
	 */
	public function sanitize_typography( array $settings ) {
		$new_settings = [];
		foreach ( $settings as $key => $setting ) {
			if ( $key == 'local' && is_bool( $setting ) ) {
				$new_settings[ $key ] = (bool) $setting;
			} else if ( in_array( $key, array( 'font1', 'font2' ) ) && is_string( $setting ) ) {
				$new_settings[ $key ] = sanitize_text_field( $setting );
			} else if ( in_array( $key, array( 'font1_styles', 'font2_styles' ) ) && is_array( $setting ) ) {
				$new_settings[ $key ] = array_map( function( $item ) {
					return is_string( $item ) ? sanitize_text_field( $item ) : '';
				}, $setting );
			}
		}
		return $new_settings;
	}

	/**
	 * Saves the settings and returns a response.
	 *
	 * @param WP_REST_Request $request The WP request object.
	 * @return WP_REST_Response|WP_Error The response object.
	 */
	public function save_settings( WP_REST_Request $request ) {

		$sanitized_settings      = $this->sanitize_options( $request->get_param( 'settings' ) );
		$sanitized_font_settings = $this->sanitize_typography( $request->get_param( 'fontSettings' ) );

		update_option( 'twentig-options', $sanitized_settings );
		$typography_updated = update_option( 'twentig_typography', $sanitized_font_settings );

		if ( ! $typography_updated || ! class_exists( 'WP_Font_Library' ) ) {
			return new WP_REST_Response(array(
				'success' => true,
				'message' => __( 'Settings saved', 'twentig' ),
			) );
		}
		
		$user_cpt = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme() );
	
		if ( array_key_exists( 'post_content', $user_cpt ) ) {
			$decoded_data = json_decode( $user_cpt['post_content'], true );

			if ( ! empty( $decoded_data['settings']['typography']['fontFamilies']['theme'] ) ) {
				$font_families = $decoded_data['settings']['typography']['fontFamilies']['theme'];

				foreach ( $font_families as $key => $font ) {
					if ( isset( $font['slug'] ) ) {
						if ( 'tw-font-1' === $font['slug'] ) {
							if ( array_key_exists( 'font1', $sanitized_font_settings ) ) {
								$font_families[$key]['name'] = esc_html__( 'Font 1', 'twentig' ) . ': ' . twentig_get_font_name( $sanitized_font_settings['font1'] );
							} else {
								unset( $font_families[$key] );
							}
						} elseif ( 'tw-font-2' === $font['slug'] ) {
							if ( array_key_exists( 'font2', $sanitized_font_settings ) ) {
								$font_families[$key]['name'] = esc_html__( 'Font 2', 'twentig' ) . ': '. twentig_get_font_name( $sanitized_font_settings['font2'] );
							} else {
								unset( $font_families[$key] );
							}
						}
					}
				}

				$decoded_data['settings']['typography']['fontFamilies']['theme'] = array_values( $font_families );
			
				if ( array_key_exists( 'ID', $user_cpt ) ) {
					$request = new WP_REST_Request( 'POST', '/wp/v2/global-styles/' . $user_cpt['ID'] );
					$request->set_param( 'settings', $decoded_data['settings'] );
					rest_do_request( $request );
				}
			}
		}

		return new WP_REST_Response(array(
			'success' => true,
			'message' => __( 'Settings saved', 'twentig' ),
		) );
	}

	/**
	 * Disables core features based on user settings.
	 */
	public function disable_core_block_features() {
		if ( ! twentig_is_option_enabled( 'twentig_core_block_directory' ) ) {
			remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
		}
		if ( ! twentig_is_option_enabled( 'twentig_core_block_patterns' ) ) {
			remove_theme_support( 'core-block-patterns' );
		}
		if ( ! twentig_is_option_enabled( 'twentig_widgets_block_editor' ) ) {
			add_filter( 'use_widgets_block_editor', '__return_false' );
		}
		if ( ! twentig_is_option_enabled( 'openverse' ) ) {
			add_filter( 'block_editor_settings_all', function( $settings ) {
				$settings['enableOpenverseMediaCategory'] = false;
				return $settings;
			}, 10 );
		}
	}

}
