<?php
/**
 * Website Template Importer class.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TwentigWebsiteImporter {

	protected $importer;
	private $processed_ids = array();
	private $nav_ids       = array();
	private $has_styles    = true;
	private $has_content   = true;
	private $has_templates = true;
	private $site_options  = array();
	private $has_portfolio = false;

	/**
	 * Registers the necessary REST API routes.
	 */
	public function register_routes() {

		register_rest_route(
			'twentig/v1',
			'/upload-starter-file',
				array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'upload_starter_website_callback' ),
				'permission_callback' => function () {
					return current_user_can( 'import' ) && current_user_can( 'delete_posts' );
				},
			)
		);
	}

	/**
	 * Imports the selected starter website.
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure
	 */
	public function upload_starter_website_callback( $request ) {
		require_once( ABSPATH . 'wp-admin/includes/post.php' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		require_once( ABSPATH . 'wp-admin/includes/taxonomy.php' );

		$starters                = $this->get_website_templates();
		$starter_id              = $request->get_param( 'starter_index' );
		$delete_previous_content = wp_validate_boolean( $request->get_param( 'delete_previous_content' ) );

		if ( ! isset( $starters[ $starter_id ] ) ) {
			return new WP_Error( 'invalid_starter_index', 'Invalid starter index specified.', array( 'status' => 400 ) );
		}

		if ( $delete_previous_content ) {
			$this->delete_previous_content();
		}

		$starter             = $starters[ (int) $starter_id ];
		$this->site_options  = $starter['options'] ?? array();
		$this->has_portfolio = wp_validate_boolean( $this->site_options['portfolio'] ?? false );

		$file = $starter['file'];
		$this->import_and_update_site( $file );

		return new WP_REST_Response(
			array(
				'twentig_options' => twentig_get_options(),
			),
			200
		);
	}

	/**
	 * Imports the website template and updates the site options.
	 */
	public function import_and_update_site( $file ) {

		add_action( 'import_start', array( $this, 'delete_custom_files' ) );
		add_action( 'wp_import_insert_post', array( $this, 'match_post_id' ), 10, 4 );
		add_filter( 'wp_import_existing_post', array( $this, 'import_existing_post' ), 10, 2 );
		add_filter( 'wp_import_post_data_processed', array( $this, 'import_post_data_processed' ), 10, 2 );
		add_filter( 'wp_import_term_meta', array( $this, 'add_starter_term_meta' ), 10, 3 );
		add_filter( 'wp_import_posts', array( $this, 'filter_posts' ) );

		// Make sure importers constant is defined
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			require_once TWENTIG_PATH . 'inc/dashboard/wordpress-importer.php';
		}

		$this->importer                    = new WP_Import();
		$this->importer->fetch_attachments = true;

		if ( ! $this->has_content ) {
			add_filter( 'wp_import_categories', '__return_empty_array' );
			add_filter( 'wp_import_terms', '__return_empty_array' );
			add_filter( 'wp_import_tags', '__return_empty_array' );
		}

		
		if ( $this->has_content && $this->has_portfolio ) {
			$options              = twentig_get_options();
			$options['portfolio'] = true;
			update_option( 'twentig-options', $options );
		}

		ob_start();
		$this->importer->import( $file );
		ob_end_clean();

		if ( $this->has_content ) {
			$this->update_site_options();
			$this->update_nav_and_template_parts();
			
			if ( $this->has_portfolio ) {
				flush_rewrite_rules( false );
			}
		}

		$transient_name = 'global_styles_' . get_stylesheet();
		delete_transient( $transient_name );		
	}

	/**
	 * Checks if there are already imported posts.
	 */
	public function has_imported_posts() {
		global $wpdb;
		$post_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_twentig_website_imported_post'" );
		return $post_ids ? true : false;
	}

	/**
	 * Maps pre-import ID to local ID.
	 */
	public function match_post_id( $post_id, $original_post_id, $postdata, $post ) {
		$this->processed_ids[ (int) $original_post_id ] = (int) $post_id;
		if ( 'wp_navigation' === $post['post_type'] ) {
			$this->nav_ids[ (int) $original_post_id ] = (int) $post_id;
		}
	}

	/**
	 * Forces the import of existing posts.
	 */
	public function import_existing_post( $post_exists, $post ) {
		if ( $post_exists && in_array( $post['post_type'], array( 'page', 'post', 'portfolio', 'wp_navigation' ), true ) ) {
			$post_exists = 0;
		}
		return $post_exists;
	}

	/**
	 * Modifies the post data before it is inserted into the database.
	 */
	public function import_post_data_processed( $postdata, $post ) {
		if ( in_array( $postdata['post_type'], array( 'page', 'wp_template', 'wp_template_part' ), true ) ) {
			$postdata['post_content'] = str_replace( 'SITE_URL', get_site_url(), $postdata['post_content'] );
			$postdata['post_content'] = str_replace( 'THEME_URL', get_template_directory_uri(), $postdata['post_content'] );
			
			if ( 'wp_template' === $postdata['post_type'] ) {
				$default_template_types = get_default_block_template_types();
				$theme_templates        = wp_get_theme_data_custom_templates();
				$portfolio_templates    = array(
					'single-portfolio'            => array(
						'title' => sprintf( __( 'Single item: %s', 'twentig' ), esc_html__( 'Project', 'twentig' ) ),
					),
					'taxonomy-portfolio_category' => array(
						'title' => esc_html__( 'Project Categories', 'twentig' ),
					),
					'taxonomy-portfolio_tag'      => array(
						'title' => esc_html__( 'Project Tags', 'twentig' ),
					),
				);
				$all_templates          = $default_template_types + $theme_templates + $portfolio_templates;

				if ( isset( $all_templates[ $postdata['post_name'] ] ) ) {
					$postdata['post_title'] = $all_templates[ $postdata['post_name'] ]['title'];
					if ( isset( $all_templates[ $postdata['post_name'] ]['description'] ) ) {
						$postdata['post_excerpt'] = $default_template_types[ $postdata['post_name'] ]['description'];
					}
				}
			} elseif ( 'wp_template_part' === $postdata['post_type'] ) {
				$theme_parts = wp_get_theme_data_template_parts();
				if ( isset( $theme_parts[ $postdata['post_name'] ] ) ) {
					$postdata['post_title'] = $theme_parts[ $postdata['post_name'] ]['title'];
				}
			}
		}

		// Add meta to identify post as an import
		if ( in_array( $postdata['post_type'], array( 'page', 'post', 'portfolio', 'attachment', 'wp_navigation' ), true ) ) {
			if ( ! isset( $postdata['meta_input'] ) ) {
				$postdata['meta_input'] = array();
			}
			$postdata['meta_input']['_twentig_website_imported_post'] = true;
		}
		return $postdata;
	}

	/**
	 * Adds meta to identify term as an import.
	 */
	public function add_starter_term_meta( $termmeta, $term_id, $term ) {

		$term = get_term( $term_id );
		if ( $term instanceof WP_Term && ! str_starts_with( $term->taxonomy, 'wp_' ) ) {
			$termmeta[] = array(
				'key'   => '_twentig_website_imported_term',
				'value' => true,
			);
		}
		return $termmeta;
	}

	/**
	 * Deletes previously imported posts and terms.
	 */
	public function delete_previous_content() {

		global $wpdb;

		$post_ids = $wpdb->get_col( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_twentig_website_imported_post'" );
		$term_ids = $wpdb->get_col( "SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key='_twentig_website_imported_term'" );

		if ( isset( $post_ids ) && is_array( $post_ids ) && $post_ids ) {
			foreach ( $post_ids as $post_id ) {
				$worked = wp_delete_post( $post_id, true );
			}
		}

		if ( isset( $term_ids ) && is_array( $term_ids ) && $term_ids ) {
			foreach ( $term_ids as $term_id ) {
				$term = get_term( $term_id );
				if ( ! is_wp_error( $term ) ) {
					wp_delete_term( $term_id, $term->taxonomy );
				}
			}
		}
	}

	/**
	 * Deletes default content, custom styles, templates, and template parts.
	 */
	public function delete_custom_files() {

		$post_types = array();

		if ( $this->has_styles ) {
			$post_types[] = 'wp_global_styles';
		}

		if ( $this->has_templates ) {
			$post_types[] = 'wp_template';
			$post_types[] = 'wp_template_part';
		}

		if ( $post_types ) {

			$wp_query_args = array(
				'post_type'      => $post_types,
				'posts_per_page' => -1,
				'no_found_rows'  => true,
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'wp_theme',
						'field'    => 'name',
						'terms'    => wp_get_theme()->get_stylesheet(),
					),
				),
			);

			$template_query  = new WP_Query( $wp_query_args );
			$posts_to_delete = $template_query->posts;

			foreach ( $posts_to_delete as $post ) {
				wp_delete_post( $post->ID, true );
			}
		}
	}

	/**
	 * Filters the posts to import.
	 * @param array $posts The posts to import.
	 * @return array
	 */
	public function filter_posts( $posts ) {
		if ( ! $this->has_styles || ! $this->has_content || ! $this->has_templates ) {
			$posts = array_filter(
				$posts,
				function( $post ) {
					$post_type = $post['post_type'];

					if ( ! $this->has_styles && 'wp_global_styles' === $post_type ) {
						return false;
					}

					if ( ! $this->has_content && in_array( $post_type, array( 'page', 'post', 'portfolio', 'attachment', 'wp_navigation' ), true ) ) {
						return false;
					}

					if ( ! $this->has_templates && ( 'wp_template' === $post_type || 'wp_template_part' === $post_type ) ) {
						return false;
					}

					return true;
				}
			);
			return array_values( $posts );
		}
		return $posts;
	}

	/**
	 * Updates the site options.
	 */
	public function update_site_options() {

		if ( isset( $this->site_options['spacing'] ) ) {
			$options = twentig_get_options();
			$options['predefined_spacing'] = true;
			update_option( 'twentig-options', $options );
		}

		if ( isset( $this->site_options['posts_per_page'] ) ) {
			update_option( 'posts_per_page', (int) $this->site_options['posts_per_page'] );
		}

		if ( isset( $this->site_options['front_page'] ) && 'posts' === $this->site_options['front_page'] ) {
			update_option( 'show_on_front', 'posts' );
		} else {		
			$front_page_title = $this->site_options['front_page'] ?? 'Home';
			$blog_page_title  = $this->site_options['blog_page'] ?? 'Blog';

			foreach ( $this->processed_ids as $old => $new ) {
				$page_title = get_the_title( $new );
				if ( $front_page_title === $page_title ) {
					if ( 'page' === get_post_type( $new ) ) {
						update_option( 'show_on_front', 'page' );
						update_option( 'page_on_front', $new );
					}
				} elseif ( $blog_page_title === $page_title ) {
					update_option( 'page_for_posts', $new );
				}
			}
		}

	}

	/**
	 * Updates navigations and template parts.
	 */
	public function update_nav_and_template_parts() {

		$navigation_args = array(
			'post_type'     => 'wp_navigation',
			'no_found_rows' => true,
			'post_status'   => 'publish',
			'post__in'      => array_values( $this->nav_ids ),
		);

		$navigation_posts = new WP_Query( $navigation_args );

		foreach ( $navigation_posts->posts as $navigation_post ) {
			$navigation_blocks = block_core_navigation_filter_out_empty_blocks( parse_blocks( $navigation_post->post_content ) );

			foreach ( $navigation_blocks as $index => &$inner_block ) {
				if ( in_array( $inner_block['blockName'], array('core/navigation-link', 'core/navigation-submenu' ) ) ) {
					if ( isset( $inner_block['attrs']['id'] ) ) {
						$old_id                      = $inner_block['attrs']['id'];
						$page_id                     = $this->processed_ids[ $old_id ] ?? $old_id;
						$inner_block['attrs']['id']  = $page_id;
						$inner_block['attrs']['url'] = get_permalink( $page_id );
					}
				}
			}

			wp_update_post(
				array( 
					'ID'           => $navigation_post->ID,
					'post_content' => serialize_blocks( $navigation_blocks ),
				)
			);
		}

		if ( $this->has_templates ) {
			// Updates the navigation ref inside template parts
			$template_args = array(
				'post_status'    => array( 'publish' ),
				'post_type'      => 'wp_template_part',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'wp_theme',
						'field'    => 'name',
						'terms'    => wp_get_theme()->get_stylesheet(),
					),
				),
			);

			$template_part_query = new WP_Query( $template_args );
			foreach ( $template_part_query->posts as $post ) {
				$this->inject_nav_attribute_in_block_template_content( $post );
			}
		}
	}

	/**
	 * Parses content, injects the correct navigation id,
	 * and updates the post.
	 *
	 * @param WP_Post $post Template post.
	 * @see inject_theme_attribute_in_block_template_content
	 */
	public function inject_nav_attribute_in_block_template_content( $post ) {
		$has_updated_content = false;
		$new_content         = '';
		$template_blocks     = parse_blocks( $post->post_content );

		$blocks = $this->flatten_blocks( $template_blocks );
		foreach ( $blocks as &$block ) {
			if ( 'core/navigation' === $block['blockName'] && isset( $block['attrs']['ref'] ) ) {
				$nav_id = $block['attrs']['ref'];
				if ( isset( $this->nav_ids[ $nav_id ] ) && $nav_id !== $this->nav_ids[ $nav_id ] ) {
					$block['attrs']['ref'] = $this->nav_ids[ $nav_id ];
					$has_updated_content   = true;
				}
			}
		}

		if ( $has_updated_content ) {
			foreach ( $template_blocks as &$block ) {
				$new_content .= serialize_block( $block );
			}

			wp_update_post( 
				array(
					'ID'           => $post->ID,
					'post_content' => $new_content,
				)
			);
		}
	}

	/**
	 * Returns an array containing the references of
	 * the passed blocks and their inner blocks.
	 *
	 * @param array $blocks array of blocks.
	 *
	 * @return array block references to the passed blocks and their inner blocks.
	 */
	private function flatten_blocks( &$blocks ) {
		$all_blocks = array();
		$queue      = array();
		foreach ( $blocks as &$block ) {
			$queue[] = &$block;
		}

		while ( count( $queue ) > 0 ) {
			$block = &$queue[0];
			array_shift( $queue );
			$all_blocks[] = &$block;

			if ( ! empty( $block['innerBlocks'] ) ) {
				foreach ( $block['innerBlocks'] as &$inner_block ) {
					$queue[] = &$inner_block;
				}
			}
		}
		return $all_blocks;
	}

	/**
	 * Returns the website templates defined for the theme.
	 */
	public function get_website_templates() {
		$theme_support = get_theme_support( 'twentig-starter-website-templates' );

		if ( is_array( $theme_support ) && ! empty( $theme_support[0] ) ) {
			return $theme_support[0];
		}
		return [];
	}
	
}
