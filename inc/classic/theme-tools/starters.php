<?php
/**
 * Starter Websites.
 *
 * @package twentig
 */

/**
 * Return starter websites list.
 */
function twentig_get_starter_library() {
	return apply_filters( 'twentig_starter_websites', array() );
}

/**
 * Adds ajax handler to load starter content.
 */
function twentig_customize_register_starter_content_load() {
	add_action( 'wp_ajax_customize_load_starter_content', 'twentig_ajax_customize_load_starter_content' );
}
add_action( 'customize_register', 'twentig_customize_register_starter_content_load' );

/**
 * Removes default starter content.
 */
function twentig_remove_starter_content() {
	remove_theme_support( 'starter-content' );
}
add_action( 'after_setup_theme', 'twentig_remove_starter_content', 12 );

/**
 * Returns starter content.
 *
 * @param string $id Starter website id.
 */
function twentig_get_starter_content( $id ) {
	$starter_content = array();
	$starters        = twentig_get_starter_library();
	$content_url     = '';

	if ( 'default' === $id ) {
		$theme = get_template();
		if ( 'twentytwentyone' === $theme ) {
			$starter_content               = twenty_twenty_one_get_starter_content();
			$starter_content['theme_mods'] = array();
		} elseif ( 'twentytwenty' === $theme ) {
			$starter_content               = twentytwenty_get_starter_content();
			$starter_content['theme_mods'] = array();
		}
		return $starter_content;
	}

	if ( ! empty( $starters ) ) {
		foreach ( $starters as $starter ) {
			if ( $id === $starter['id'] ) {
				$content_url = $starter['content'];
				break;
			}
		}
	}

	if ( $content_url ) {
		$request = wp_remote_get( $content_url );
		if ( is_wp_error( $request ) ) {
			return $starter_content;
		}
		$body            = wp_remote_retrieve_body( $request );
		$starter_content = json_decode( $body, true );
	}

	$starter_content = wp_unslash( $starter_content );
	return $starter_content;
}

/**
 * Handles the Ajax request to load the starter content.
 */
function twentig_ajax_customize_load_starter_content() {

	global $wp_customize;

	$error = esc_html__( 'An unexpected error occurred.', 'twentig' );

	if ( empty( $wp_customize ) || ! $wp_customize->is_preview() || ! is_user_logged_in() ) {
		wp_send_json_error( $error );
	}

	if ( ! check_ajax_referer( 'preview-customize_' . $wp_customize->get_stylesheet(), 'nonce', false ) ) {
		wp_send_json_error( $error );
	}

	// Get data.
	$import_type     = isset( $_POST['type'] ) ? wp_unslash( $_POST['type'] ) : 'all';
	$starter_id      = isset( $_POST['starter'] ) ? wp_unslash( $_POST['starter'] ) : '';
	$starter_content = twentig_get_starter_content( $starter_id );

	if ( ! $starter_content ) {
		wp_send_json_error( $error );
	}

	// Add a single post.
	if ( isset( $starter_content['posts'] ) ) {
		foreach ( $starter_content['posts'] as $id => $item ) {
			if ( is_string( $item ) && 'blog_post' === $item ) {
				$starter_content['posts']['blog_post'] = array(
					'post_type'    => 'post',
					'post_title'   => esc_html__( 'Sharing your stories has never been easier', 'twentig' ),
					'post_name'    => 'sharing-your-stories-has-never-been-easier',
					'thumbnail'    => '{{post-featured-image}}',
					'post_content' => '<!-- wp:paragraph --> <p>Nunc id sapien finibus faucibus odio vitae aliquam eros. Ante ex mauris a mus lobortis, urna elit odio nibh ac aliquet ipsum leo commodo quam. Proin semper leo ligula aenean utt erat non quam amet. Morbi fames tempor purus, at semper velit sapien vel in blandit ante. Etiam feugiat ligula turpis enim pulvinar mollis sed. Maecenas in ornare justo in magna.</p> <!-- /wp:paragraph --> <!-- wp:paragraph --> <p>Proin purus purus dapibus eget lacus nec, placerat aliquam mauris. Nulla vel ante ullamcorper, mattis massa nec suscipit risus. In suscipit luctus gravida. Nulla faucibus quis nulla sed faucibus, nunc malesuada est sed diam porta posuere. In hac habitasse platea dictumst. Pellentesque elementum sit amet dui id fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> <!-- /wp:paragraph --> <!-- wp:paragraph --> <p>Venenatis elit vel luctus. Nulla venenatis libero at sem semper, id ultricies ipsum mollis. Phasellus vitae consequat urna. Suspendisse gravida velit magna vitae euismod libero vulputate ut. Vestibulum eu dignissim nisl sed lobortis diam in tellus.</p> <!-- /wp:paragraph --> <!-- wp:paragraph --> <p>Vivamus eleifend malesuada scelerisque. Sed dignissim sapien sit amet nunc pharetra malesuada. Phasellus ut dolor ultricies dolor laoreet finibus id sit amet nisl. Morbi porttitor imperdiet congue etiam enim, finibus interdum elit malesuada.</p> <!-- /wp:paragraph --> <!-- wp:paragraph --> <p>Suspendisse id faucibus elit eget euismod neque. Donec tortor velit sagittis non ante sit amet, semper vehicula diam. Donec faucibus ipsum sed mauris cursus, ac placerat nulla pharetra. Morbi id velit vitae augue efficitur elementum. Nulla id ante lacinia commodo est nec aliquet sapien. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p> <!-- /wp:paragraph -->',
				);

				if ( ! isset( $starter_content['attachments'] ) ) {
					$starter_content['attachments'] = array();
				}

				$starter_content['attachments']['post-featured-image'] = array(
					'post_title' => 'Dune',
					'post_name'  => 'dune',
					'file'       => TWENTIG_PATH . 'dist/images/patterns/wide.jpg',
				);
			}
		}
	}

	// Retrieve content.
	add_theme_support( 'starter-content', $starter_content );
	$content = get_theme_starter_content();

	if ( 'style' === $import_type ) {
		unset( $content['posts'] );
		unset( $content['options'] );
		unset( $content['nav_menus'] );
		unset( $content['widgets'] );
	} elseif ( 'pages' === $import_type ) {
		unset( $content['theme_mods'] );
		unset( $content['options'] );
		unset( $content['nav_menus'] );
		unset( $content['widgets'] );
		unset( $content['posts']['blog_post'] );
		unset( $content['posts']['blog'] );
		unset( $content['posts']['news'] );
	} elseif ( 'content' === $import_type ) {
		unset( $content['theme_mods'] );
	}

	if ( 'all' === $import_type || 'content' === $import_type ) {
		if ( ! isset( $content['widgets']['sidebar-1'] ) ) {
			$content['widgets']['sidebar-1'] = array();
		}
		if ( ! isset( $content['widgets']['sidebar-2'] ) ) {
			$content['widgets']['sidebar-2'] = array();
		}
	}

	if ( isset( $content['theme_mods'] ) ) {
		foreach ( $wp_customize->settings() as $setting ) {
			if ( 'theme_mod' === $setting->type && str_contains( $setting->id, 'twentig_' ) ) {
				if ( ! isset( $content['theme_mods'][ $setting->id ] ) && ! in_array( $setting->id, array( 'twentig_page_404' ), true ) ) {
					$content['theme_mods'][ $setting->id ] = $setting->default;
				}
			}
			if ( in_array(
				$setting->id,
				array( 
					'custom_logo',
					'display_title_and_tagline',
					'background_color',
					'header_footer_background_color',
					'background_image',
					'enable_header_search',
					'display_excerpt_or_full_post',
					'blog_content',
					'accent_hue_active',
					'respect_user_color_preference',
				),
				true 
			) && ! isset( $content['theme_mods'][ $setting->id ] ) ) {
				$content['theme_mods'][ $setting->id ] = $setting->default;
			}
		}
	}

	if ( isset( $content['posts'] ) ) {
		foreach ( $content['posts'] as $post_id => $post ) {
			if ( 'page' === $post['post_type'] ) {
				$post_slug = isset( $post['post_name'] ) ? $post['post_name'] : sanitize_title( $post['post_title'] );
				if ( ! in_array( $post_slug, array( 'blog', 'news' ), true ) ) {
					$content['posts'][ $post_id ]['post_name'] = twentig_unique_post_slug( $post_slug );
				}
			}
		}
	}

	$wp_customize->import_theme_starter_content( $content );
	wp_send_json_success( $content );
}

/**
 * Computes a unique slug for a given desired slug.
 *
 * @param string $slug Post slug.
 * Based on wp_unique_post_slug() core function.
 */
function twentig_unique_post_slug( $slug ) {
	global $wpdb;
	$check_sql       = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s LIMIT 1";
	$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $slug ) );
	if ( $post_name_check ) {
		$suffix = 2;
		do {
			$alt_post_name   = _truncate_post_slug( $slug, 200 - ( strlen( $suffix ) + 1 ) ) . "-$suffix";
			$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $alt_post_name ) );
			$suffix++;
		} while ( $post_name_check );
		$slug = $alt_post_name;
	}
	return $slug;
}

require TWENTIG_PATH . 'inc/classic/theme-tools/class-twentig-starter-loop-posts.php';
