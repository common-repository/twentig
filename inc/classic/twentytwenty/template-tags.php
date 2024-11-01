<?php
/**
 * Custom template tags for this theme.
 *
 * @package twentig
 */

/**
 * Set the excerpt more link.
 *
 * @param string $more The string shown within the more link.
 */
function twentig_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'twentig_excerpt_more' );

/**
 * Display Continue Reading link after the excerpt.
 *
 * @param string  $post_excerpt The post excerpt.
 * @param WP_Post $post         Post object.
 */
function twentig_add_more_to_excerpt( $post_excerpt, $post ) {
	if ( 'summary' === get_theme_mod( 'blog_content', 'full' ) && get_theme_mod( 'twentig_blog_excerpt_more', false ) && 'post' === $post->post_type && ! is_singular() && ! is_search() ) {
		return $post_excerpt . '<a href="' . get_permalink( $post->ID ) . '" class="more-link"><span>' . esc_html__( 'Continue reading', 'twentytwenty' ) . '</span><span class="screen-reader-text">' . $post->post_title . '</span></a>';
	}
	return $post_excerpt;
}
add_filter( 'get_the_excerpt', 'twentig_add_more_to_excerpt', 10, 2 );

/**
 * Set excerpt length.
 *
 * @param int $excerpt_length The maximum number of words.
 */
function twentig_custom_excerpt_length( $excerpt_length ) {
	if ( is_home() || is_archive() ) {
		$newlength = get_theme_mod( 'twentig_blog_excerpt_length' );
		if ( $newlength ) {
			return $newlength;
		}
	}
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'twentig_custom_excerpt_length' );

/**
 * Change the read more button style to a normal link when changing blog layout.
 *
 * @param string $more_link_element Read More link element.
 */
function twentig_read_more_tag( $more_link_element ) {
	if ( '' === get_theme_mod( 'twentig_blog_layout' ) ) {
		return $more_link_element;
	}
	return str_replace( 'faux-button', 'link-button', $more_link_element );
}
add_filter( 'the_content_more_link', 'twentig_read_more_tag', 20 );

/**
 * Removes the post content displayed on the archive pages based on Customizer setting.
 */
function twentig_filter_content() {
	if ( class_exists( 'bbPress' ) && is_bbpress() ) {
		return;
	}

	if ( ( is_home() || is_archive() ) && ! get_theme_mod( 'twentig_blog_content', true ) ) {
		if ( 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
			add_filter( 'the_excerpt', '__return_empty_string' );
		} else {
			add_filter( 'the_content', '__return_empty_string' );
		}
	}
}
add_action( 'get_template_part_template-parts/content', 'twentig_filter_content' );

/**
 * Hide the top categories.
 */
function twentig_hide_categories_in_entry_header() {
	if ( is_singular() ) {
		$post_meta = get_theme_mod( 'twentig_post_meta', array( 'top-categories', 'author', 'post-date', 'comments', 'tags' ) );
		if ( ! in_array( 'top-categories', $post_meta, true ) ) {
			return false;
		}
	} else {
		$post_meta = get_theme_mod( 'twentig_blog_meta', array( 'top-categories', 'author', 'post-date', 'comments', 'tags' ) );
		if ( ! in_array( 'top-categories', $post_meta, true ) ) {
			return false;
		}
	}
	return true;
}
add_filter( 'twentytwenty_show_categories_in_entry_header', 'twentig_hide_categories_in_entry_header' );

/**
 * Display the post top meta.
 *
 * @param array $meta The post meta.
 */
function twentig_post_meta_top( $meta ) {
	$post_meta   = is_singular() ? get_theme_mod( 'twentig_post_meta', $meta ) : get_theme_mod( 'twentig_blog_meta', $meta );
	$blog_layout = get_theme_mod( 'twentig_blog_layout' );

	$tags_key = array_search( 'tags', $post_meta, true );
	if ( false !== $tags_key ) {
		unset( $post_meta[ $tags_key ] );
	}

	if ( ! is_singular() ) {
		$post_meta[] = 'sticky';
		if ( in_array( $blog_layout, array( 'grid-card', 'grid-basic' ), true ) ) {
			$post_meta = array();
		}
	}

	return $post_meta;
}
add_filter( 'twentytwenty_post_meta_location_single_top', 'twentig_post_meta_top' );

/**
 * Display the post bottom meta.
 *
 * @param array $meta The post meta.
 */
function twentig_post_meta_bottom( $meta ) {
	$post_meta   = is_singular() ? get_theme_mod( 'twentig_post_meta', $meta ) : get_theme_mod( 'twentig_blog_meta', $meta );
	$blog_layout = get_theme_mod( 'twentig_blog_layout' );

	if ( ! in_array( 'tags', $post_meta, true ) ) {
		$meta = array();
	}

	if ( ! is_singular() && in_array( $blog_layout, array( 'grid-card', 'grid-basic' ), true ) ) {
		$meta   = get_theme_mod( 'twentig_blog_meta', $meta );
		$meta[] = 'sticky';
	}

	return $meta;
}
add_filter( 'twentytwenty_post_meta_location_single_bottom', 'twentig_post_meta_bottom' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param string[] $classes An array of post class names.
 * @param string[] $class   An array of additional class names added to the post.
 * @param int      $post_id The post ID.
 */
function twentig_post_class( $classes, $class, $post_id ) {
	$post = get_post( $post_id );

	if ( 'post' === $post->post_type ) {
		if ( ! is_singular() && ! is_search() ) {
			if ( ! get_theme_mod( 'twentig_blog_content', true ) ) {
				$classes[] = 'tw-post-no-content';
			}
			$image_ratio = get_theme_mod( 'twentig_blog_image_ratio' );
			if ( in_array( 'has-post-thumbnail', $classes, true ) && $image_ratio ) {
				$classes[] = 'tw-post-has-image-' . $image_ratio;
			}
		}
		if ( ! get_theme_mod( 'twentig_blog_meta_icon', true ) ) {
			$classes[] = 'tw-meta-no-icon';
		}
	}
	return $classes;
}
add_filter( 'post_class', 'twentig_post_class', 10, 3 );

/**
 * Add link to featured image on archives page.
 *
 * @param string $html The post thumbnail HTML.
 * @param int    $post_id The post ID.
 */
function twentig_twentytwenty_add_link_to_featured_image( $html, $post_id ) {
	if ( ( is_home() || is_archive() || is_post_type_archive( 'post' ) ) ) {
		return '<a href="' . esc_url( get_permalink( $post_id ) ) . '" tabindex="-1" aria-hidden="true">' . $html . '</a>';
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'twentig_twentytwenty_add_link_to_featured_image', 10, 2 );

/**
 * Determines if post thumbnail should be displayed.
 *
 * @param bool $has_thumbnail Whether the post has a thumbnail.
 */
function twentig_display_featured_image( $has_thumbnail ) {

	static $ran = false;

	if ( ! get_theme_mod( 'twentig_blog_image', true ) && ( is_home() || is_archive() || is_post_type_archive( 'post' ) ) ) {
		return false;
	}

	if ( is_singular( 'post' ) && ( 'no-image' === get_theme_mod( 'twentig_post_hero_layout' ) ) && ! is_page_template( 'templates/template-cover.php' ) ) {
		if ( in_the_loop() ) {
			if ( $ran ) {
				remove_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );
			}
			$ran = true;
		}
		return false;
	}

	if ( is_singular( 'page' ) && ( 'no-image' === get_theme_mod( 'twentig_page_hero_layout' ) ) && ( ! is_page_template() || is_page_template( 'templates/template-full-width.php' ) ) ) {
		if ( in_the_loop() ) {
			if ( $ran ) {
				remove_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );
			}
			$ran = true;
		}
		return false;
	}

	return $has_thumbnail;
}
add_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 */
function twentig_calculate_image_sizes( $sizes ) {

	if ( ! in_the_loop() ) {
		return $sizes;
	}

	if ( is_home() || is_author() || is_category() || is_tag() || is_date() || is_tax( get_object_taxonomies( 'post' ) ) ) {
		$blog_layout = get_theme_mod( 'twentig_blog_layout' );
		if ( 'grid-basic' === $blog_layout || 'grid-card' === $blog_layout ) {
			$blog_columns = get_theme_mod( 'twentig_blog_columns', '3' );
			if ( '2' === $blog_columns ) {
				$sizes = '(min-width: 1280px) 584px, (min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';
			} else {
				$sizes = '(min-width: 1280px) 378px, (min-width: 1220px) calc(33.33vw - 48px), (min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';
			}
		} elseif ( 'stack' === $blog_layout ) {
			$content_width = get_theme_mod( 'twentig_text_width' );
			if ( 'wide' === $content_width ) {
				$sizes = '(min-width: 880px) 800px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
			} elseif ( 'medium' === $content_width ) {
				$sizes = '(min-width: 780px) 700px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
			} else {
				$sizes = '(min-width: 620px) 580px, calc(100vw - 40px)';
			}
		}
	} elseif ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() && ! is_page_template() ) {
		$hero_layout = is_page() ? get_theme_mod( 'twentig_page_hero_layout' ) : get_theme_mod( 'twentig_post_hero_layout' );
		if ( 'narrow-image' === $hero_layout ) {
			static $ran = false;
			if ( ! $ran ) {
				$content_width = get_theme_mod( 'twentig_text_width' );
				if ( 'wide' === $content_width ) {
					$sizes = '(min-width: 880px) 800px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
				} elseif ( 'medium' === $content_width ) {
					$sizes = '(min-width: 780px) 700px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
				} else {
					$sizes = '(min-width: 620px) 580px, calc(100vw - 40px)';
				}
			}
			$ran = true;
		}
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentig_calculate_image_sizes' );

/**
 * Changes the hero image size based on selected layout.
 */
function twentig_content_hero_image() {
	if ( is_singular( array( 'post', 'page' ) ) ) {
		$hero_layout = is_page() ? get_theme_mod( 'twentig_page_hero_layout' ) : get_theme_mod( 'twentig_post_hero_layout' );
		if ( 'full-image' === $hero_layout ) {
			add_filter(
				'post_thumbnail_size',
				function() {
					return 'full';
				}
			);
		}
	}
}
add_action( 'get_template_part_template-parts/featured-image', 'twentig_content_hero_image' );

/**
 * Hide excerpt on single post.
 */
function twentig_remove_excerpt_single_post() {
	if ( is_singular( 'post' ) && ! get_theme_mod( 'twentig_post_excerpt', true ) ) {
		add_filter( 'the_excerpt', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/entry-header', 'twentig_remove_excerpt_single_post', 10, 2 );
add_action( 'get_template_part_template-parts/content-cover', 'twentig_remove_excerpt_single_post', 10, 2 );

/**
 * Filters whether all posts are open for comments.
 *
 * @param bool $open Whether the current post is open for comments.
 */
function twentig_comments_open( $open ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'twentig_comments_open' );

/**
 * Filters the comment count for all posts.
 *
 * @param string|int $count A string representing the number of comments a post has, otherwise 0.
 */
function twentig_comments_number( $count ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return 0;
	}
	return $count;
}
add_filter( 'get_comments_number', 'twentig_comments_number' );

/**
 * Removes the single navigation by excluding all the terms.
 */
function twentig_filter_navigation() {
	if ( 'none' === get_theme_mod( 'twentig_post_navigation' ) ) {
		add_filter( 'get_next_post_excluded_terms', 'twentig_exclude_terms' );
		add_filter( 'get_previous_post_excluded_terms', 'twentig_exclude_terms' );

		if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			echo '<hr class="styled-separator is-style-wide section-inner" aria-hidden="true">';
		}
	}
}
add_action( 'get_template_part_template-parts/navigation', 'twentig_filter_navigation' );

/**
 * Returns all the post categories.
 */
function twentig_exclude_terms() {
	$cat_ids = get_terms(
		'category',
		array(
			'fields' => 'ids',
			'get'    => 'all',
		)
	);
	return $cat_ids;
}

/**
 * Adds featured image as background image to single post navigation elements.
 */
function twentig_twentytwenty_post_nav_background() {
	if ( is_singular( 'post' ) && 'image' === get_theme_mod( 'twentig_post_navigation' ) ) {
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		$css       = '';

		if ( $prev_post && (bool) get_post_thumbnail_id( $prev_post ) ) {
			$prev_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'large' );
			$css       .= 'a.previous-post { background-image: url(' . esc_url( $prev_thumb[0] ) . '); }';
		}

		if ( $next_post && (bool) get_post_thumbnail_id( $next_post ) ) {
			$next_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'large' );
			$css       .= 'a.next-post { background-image: url(' . esc_url( $next_thumb[0] ) . '); }';
		}

		wp_add_inline_style( 'twentig-twentytwenty', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'twentig_twentytwenty_post_nav_background', 13 );

/**
 * Filters the content of the latest posts block to change the image sizes attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attribute.
 */
function twentig_twentytwenty_change_latest_posts_image_sizes( $block_content, $block ) {
	if ( 'core/latest-posts' === $block['blockName'] ) {
		$image = $block['attrs'] && isset( $block['attrs']['displayFeaturedImage'] ) ? $block['attrs']['displayFeaturedImage'] : 0;

		if ( $image ) {
			$image_width = $block['attrs'] && isset( $block['attrs']['featuredImageSizeWidth'] ) ? $block['attrs']['featuredImageSizeWidth'] : '';
			$sizes       = '';

			if ( '' === $image_width ) {
				$layout        = $block['attrs'] && isset( $block['attrs']['postLayout'] ) ? $block['attrs']['postLayout'] : '';
				$block_align   = $block['attrs'] && isset( $block['attrs']['align'] ) ? $block['attrs']['align'] : '';
				$image_align   = $block['attrs'] && isset( $block['attrs']['featuredImageAlign'] ) ? $block['attrs']['featuredImageAlign'] : '';
				$content_width = get_theme_mod( 'twentig_text_width' );

				if ( 'grid' === $layout ) {
					$columns      = $block['attrs'] && isset( $block['attrs']['columns'] ) ? $block['attrs']['columns'] : 3;
					$medium_sizes = '(min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';

					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 700px) 96px, calc(25vw - 10px)';
						} elseif ( 'wide' === $block_align ) {
							$sizes = '(min-width: 1280px) 146px, (min-width: 700px) calc(12.5vw - 14px), calc(25vw - 10px)';
						}
					} else {
						if ( 'wide' === $block_align ) {
							$sizes = '(min-width: 1280px) 276px, (min-width: 1024px) calc(25vw - 44px),' . $medium_sizes;
							if ( 2 === $columns ) {
								$sizes = '(min-width: 1280px) 584px,' . $medium_sizes;
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1280px) 378px, (min-width: 1024px) calc(33.33vw - 48px), ' . $medium_sizes;
							}
						} elseif ( 'full' === $block_align ) {
							$sizes = '(min-width: 1024px) calc(25vw - 44px),' . $medium_sizes;
							if ( 2 === $columns ) {
								$sizes = $medium_sizes;
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1024px) calc(33.33vw - 48px),' . $medium_sizes;
							}
						} else {
							if ( 'wide' === $content_width ) {
								$sizes = '(min-width: 1024px) 245px, (min-width: 880px) 384px, ' . $medium_sizes;
								if ( 2 === $columns ) {
									$sizes = '(min-width: 880px) 384px,' . $medium_sizes;
								}
							} elseif ( 'medium' === $content_width ) {
								$sizes = '(min-width: 1024px) 212px, (min-width: 780px) 334px, ' . $medium_sizes;
								if ( 2 === $columns ) {
									$sizes = '(min-width: 780px) 334px, ' . $medium_sizes;
								}
							} else {
								$sizes = '(min-width: 700px) 274px, (min-width: 620px) 580px, calc(100vw - 40px)';
							}
						}
					}
				} else {
					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 620px) 145px, calc(25vw - 10px)';
							if ( 'wide' === $content_width ) {
								$sizes = '(min-width: 880px) 200px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
							} elseif ( 'medium' === $content_width ) {
								$sizes = '(min-width: 780px) 175px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
							}
						} else {
							$sizes = '(min-width: 1280px) 300px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
						}
					}
				}
			} else {
				$sizes = $image_width . 'px';
			}
			if ( $sizes ) {
				return preg_replace( '/sizes="([^>]+?)"/', 'sizes="' . $sizes . '"', $block_content );
			}
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'twentig_twentytwenty_change_latest_posts_image_sizes', 10, 2 );


/**
 * Displays transparent logo on Cover & Transparent Header templates.
 *
 * @param string $html Custom logo HTML output.
 */
function twentig_logo_transparent( $html ) {

	$custom_logo_id             = get_theme_mod( 'custom_logo' );
	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_transparent' );

	if ( ! $custom_logo_id || ! $custom_logo_transparent_id ) {
		return $html;
	}

	// We have a logo. Logo is go.
	if ( is_page_template( array( 'templates/template-cover.php', 'tw-header-transparent-light.php' ) ) ) {
		$custom_logo_attr = array(
			'class' => 'custom-logo',
		);

		$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		if ( empty( $image_alt ) ) {
			$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
		}

		if ( get_theme_mod( 'twentig_header_sticky' ) ) {
			$custom_logo_attr['class']             = 'custom-logo logo-primary';
			$custom_logo_transparent_attr          = $custom_logo_attr;
			$custom_logo_transparent_attr['class'] = 'custom-logo logo-transparent';

			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr ) . ' ' .
				wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_transparent_attr )
			);
		} else {
			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_attr )
			);
		}
	}

	return $html;
}
add_filter( 'get_custom_logo', 'twentig_logo_transparent', 0 );

/**
 * Hide the tagline by returning an empty string.
 *
 * @param string $html  The HTML for the site description.
 */
function twentig_twentytenty_hide_tagline( $html ) {
	if ( ! get_theme_mod( 'twentig_header_tagline', true ) ) {
		return '';
	}
	return $html;
}
add_filter( 'twentytwenty_site_description', 'twentig_twentytenty_hide_tagline' );

/**
 * Determines if social icons should be displayed in the location.
 *
 * @param string $location Social location identifier.
 */
function twentig_twentytwenty_is_socials_location( $location ) {
	$locations = get_theme_mod( 'twentig_socials_location', array( 'modal-desktop', 'modal-mobile', 'footer' ) );
	return in_array( $location, $locations, true );
}

/**
 * Adds social links in the primary menu.
 *
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 */
function twentig_twentytenty_nav_menu_social_icons( $items, $args ) {
	if ( 'primary' === $args->theme_location && has_nav_menu( 'social' ) && twentig_twentytwenty_is_socials_location( 'primary-menu' ) ) {
		$items = $items . '<li class="menu-item-socials"><ul class="social-menu reset-list-style social-icons fill-children-current-color">' .
			wp_nav_menu(
				array(
					'echo'            => false,
					'theme_location'  => 'social',
					'container'       => '',
					'container_class' => '',
					'items_wrap'      => '%3$s',
					'menu_id'         => '',
					'menu_class'      => '',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'fallback_cb'     => '',
				)
			) . '</ul></li>';
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'twentig_twentytenty_nav_menu_social_icons', 20, 2 );

/**
 * Disable the social icons menu inside the modal menu depending on the Customizer setting.
 */
function twentig_twentytenty_modal_menu() {
	remove_filter( 'wp_nav_menu_items', 'twentig_nav_menu_social_icons', 20 );
	if ( ! twentig_twentytwenty_is_socials_location( 'modal-mobile' ) && ! twentig_twentytwenty_is_socials_location( 'modal-desktop' ) ) {
		add_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials', 10, 2 );
	}
}
add_action( 'get_template_part_template-parts/modal-menu', 'twentig_twentytenty_modal_menu', 10, 2 );

/**
 * Disable social icons menu for a given location.
 *
 * @param bool   $has_nav_menu Whether there is a social menu assigned to a location.
 * @param string $location     Social menu location.
 */
function twentig_twentytwenty_disable_socials( $has_nav_menu, $location ) {
	if ( 'social' === $location ) {
		return false;
	}
	return $has_nav_menu;
}

/**
 * Add support for excerpt to page.
 */
function twentig_twentytenty_support_page_excerpt() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'twentig_twentytenty_support_page_excerpt' );

/**
 * Set template for page cover with excerpt.
 *
 * @param string $template The path of the template to include.
 */
function twentig_twentytenty_page_cover_excerpt( $template ) {
	if ( is_page_template( 'templates/template-cover.php' ) && is_page() && has_excerpt() ) {
		return TWENTIG_PATH . 'inc/classic/twentytwenty/templates/template-cover.php';
	}
	return $template;
}
add_filter( 'template_include', 'twentig_twentytenty_page_cover_excerpt' );


/**
 * Add support for blocks inside widgets.
 */
function twentig_twentytwenty_support_widget_block() {
	add_filter( 'widget_text', 'do_blocks', 9 );
}
add_action( 'init', 'twentig_twentytwenty_support_widget_block' );

/**
 * Changes the footer "menu widgets" area based on selected layout.
 */
function twentig_footer_menu_widgets() {
	$footer_layout = get_theme_mod( 'twentig_footer_layout' );
	if ( $footer_layout ) {
		add_filter( 'has_nav_menu', 'twentig_disable_top_footer_menus', 10, 2 );
	} else {
		if ( twentig_twentytwenty_is_socials_location( 'footer' ) ) {
			remove_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials' );
		} else {
			add_filter( 'has_nav_menu', 'twentig_twentytwenty_disable_socials', 10, 2 );
		}
	}
}
add_action( 'get_template_part_template-parts/footer-menus-widgets', 'twentig_footer_menu_widgets' );

/**
 * Disables default top footer menus.
 *
 * @param bool   $has_nav_menu Whether there is a menu assigned to a location.
 * @param string $location     Menu location.
 */
function twentig_disable_top_footer_menus( $has_nav_menu, $location ) {
	if ( 'footer' === $location || 'social' === $location ) {
		return false;
	}
	return $has_nav_menu;
}

/**
 * Displays custom footer based on Customizer settings.
 *
 * @param string|null $name Name of the specific footer file to use. null for the default footer.
 */
function twentig_get_footer( $name = null ) {

	$footer_layout = get_theme_mod( 'twentig_footer_layout' );
	$footer_credit = get_theme_mod( 'twentig_footer_credit' );

	if ( '' == $footer_credit && '' == $footer_layout ) {
		return;
	}

	if ( twentig_twentytwenty_footer_exists( $name ) ) {
		return;
	}

	if ( 'hidden' !== $footer_layout ) : ?>

		<?php if ( 'custom' === $footer_layout ) : ?>
			<footer id="site-footer" class="footer-custom header-footer-group">
			<?php
				$block_id = get_theme_mod( 'twentig_footer_content' );
				twentig_render_reusable_block( $block_id );
			?>
			</footer>
		<?php else : ?>
			<footer id="site-footer" class="header-footer-group">

				<?php if ( in_array( $footer_layout, array( 'inline-left', 'inline-right', 'inline-center' ), true ) ) : ?>
					<div class="section-inner footer-inline footer-<?php echo esc_attr( $footer_layout ); ?>">

						<?php twentig_get_footer_credits(); ?>
						<?php twentig_get_footer_menu(); ?>
						<?php twentig_get_footer_social_menu(); ?>			

					</div><!-- .section-inner -->

				<?php elseif ( 'stack' === $footer_layout ) : ?>

					<div class="section-inner footer-stack">

						<?php twentig_get_footer_social_menu(); ?>
						<?php twentig_get_footer_menu(); ?>
						<?php twentig_get_footer_credits(); ?>

					</div><!-- .section-inner -->

				<?php else : ?>

					<div class="section-inner">

						<?php twentig_get_footer_credits(); ?>

						<a class="to-the-top" href="#site-header">
							<span class="to-the-top-long">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( 'To the top %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span>
							<span class="to-the-top-short">
								<?php
								/* translators: %s: HTML character for up arrow */
								printf( __( 'Up %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span>
						</a><!-- .to-the-top -->

					</div><!-- .section-inner -->

				<?php endif; ?>	

			</footer><!-- #site-footer -->
		<?php endif; ?>

	<?php elseif ( in_array( 'footer-top-hidden', get_body_class(), true ) ) : ?>
		<div id="footer-placeholder"></div>
	<?php endif; ?>

	<?php wp_footer(); ?>

	</body>
</html>

	<?php
	$templates = array( 'footer.php' );

	ob_start();
	locate_template( $templates, true );
	ob_get_clean();
}
add_action( 'get_footer', 'twentig_get_footer', 9 );

/**
 * Determines whether the given footer template name exists.
 *
 * @param string|null $name Name of the specific footer file.
 */
function twentig_twentytwenty_footer_exists( $name ) {
	if ( null === $name ) {
		return false;
	}

	$template_name = "footer-{$name}.php";
	if ( 'embed' === $name || file_exists( STYLESHEETPATH . '/' . $template_name ) || file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
		return true;
	}
	return false;
}

/**
 * Determines whether a registered nav menu location inside the footer has a menu assigned to it.
 * Rewrites the 'has_nav_menu' function to avoid the 'has_nav_menu' filter.
 *
 * @param string $location Menu location identifier.
 */
function twentig_footer_has_nav_menu( $location ) {
	$has_nav_menu = false;

	$registered_nav_menus = get_registered_nav_menus();
	if ( isset( $registered_nav_menus[ $location ] ) ) {
		$locations    = get_nav_menu_locations();
		$has_nav_menu = ! empty( $locations[ $location ] );
	}

	return $has_nav_menu;
}

/**
 * Displays footer menu.
 */
function twentig_get_footer_menu() {

	if ( twentig_footer_has_nav_menu( 'footer' ) ) {
		?>

		<nav aria-label="<?php esc_attr_e( 'Footer', 'twentytwenty' ); ?>" class="footer-menu-wrapper">

			<ul class="footer-menu reset-list-style">
				<?php
					wp_nav_menu(
						array(
							'container'      => '',
							'depth'          => 1,
							'items_wrap'     => '%3$s',
							'theme_location' => 'footer',
						)
					);
				?>
			</ul>

		</nav>
		<?php
	}
}

/**
 * Displays footer social menu.
 */
function twentig_get_footer_social_menu() {

	if ( twentig_footer_has_nav_menu( 'social' ) && twentig_twentytwenty_is_socials_location( 'footer' ) ) {
		?>

		<nav aria-label="<?php esc_attr_e( 'Social links', 'twentytwenty' ); ?>" class="footer-social-wrapper">

			<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'social',
							'container'       => '',
							'container_class' => '',
							'items_wrap'      => '%3$s',
							'menu_id'         => '',
							'menu_class'      => '',
							'depth'           => 1,
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							'fallback_cb'     => '',
						)
					);
				?>

			</ul>

		</nav>
		<?php
	}
}

/**
 * Displays footer credits.
 */
function twentig_get_footer_credits() {

	$footer_credit = get_theme_mod( 'twentig_footer_credit' );
	$credit_text   = get_theme_mod( 'twentig_footer_credit_text' );

	if ( 'none' !== $footer_credit ) :
		?>

	<div class="footer-credits">			

		<p class="footer-copyright">
		<?php if ( 'custom' === $footer_credit && $credit_text ) { ?>
			<?php echo do_shortcode( twentig_twentytwenty_sanitize_credit( str_replace( '[Y]', date_i18n( 'Y' ), $credit_text ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php } else { ?>
			&copy;
			<?php
			echo date_i18n(
				/* translators: Copyright date format, see https://secure.php.net/date */
				_x( 'Y', 'copyright date format', 'twentytwenty' )
			);
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo bloginfo( 'name' ); ?></a>			
		<?php } ?>
		</p>

		<?php if ( '' === $footer_credit ) { ?>
			<p class="powered-by-wordpress">
				<a href="<?php echo esc_url( 'https://wordpress.org/' ); ?>">
					<?php esc_html_e( 'Powered by WordPress', 'twentytwenty' ); ?>
				</a>
			</p>
		<?php } ?>

	</div><!-- .footer-credits -->

	<?php endif; ?>

	<?php
}

/**
 * Adds social icons svg sources.
 */
function twentig_twentytwenty_social_svg( $icons ) {
	$icons['patreon'] = '<svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M21 9.847a6.471 6.471 0 1 1-6.46-6.487A6.472 6.472 0 0 1 21 9.847ZM3 20.64h3.164V3.36H3Z"></path></svg>';
	return $icons;
}
add_filter( 'twentytwenty_svg_icons_social', 'twentig_twentytwenty_social_svg' );

/**
 * Adds social icons domain mappings.
 */
function twentig_twentytwenty_social_map( $icons ) {
	$icons['mastodon'] = array(
		'mastodon.social',
	);
	$icons['telegram'] = array(
		't.me',
		'telegram.me',
	);
	$icons['whatsapp'] = array(
		'wa.me',
		'whatsapp.com',
	);
	return $icons;
}
add_filter( 'twentytwenty_social_icons_map', 'twentig_twentytwenty_social_map' );
