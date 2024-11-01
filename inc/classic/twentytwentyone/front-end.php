<?php
/**
 * Front-end (blog, header, footer) functionalities.
 *
 * @package twentig
 */

/**
 * Set the excerpt more link.
 *
 * @param string $more The string shown within the more link.
 */
function twentig_twentyone_excerpt_more( $more ) {
	if ( is_home() || is_archive() || ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) ) ) {
		if ( ! get_theme_mod( 'twentig_blog_excerpt_more', true ) ) {
			return '&hellip;';
		}
		return '&hellip; <div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . twenty_twenty_one_continue_reading_text() . '</a></div>';
	}

	return $more;
}
add_filter( 'excerpt_more', 'twentig_twentyone_excerpt_more', 20 );

/**
 * Set excerpt length.
 *
 * @param int $excerpt_length The maximum number of words.
 */
function twentig_twentyone_custom_excerpt_length( $excerpt_length ) {
	if ( is_home() || is_archive() || ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) ) ) {
		$newlength = get_theme_mod( 'twentig_blog_excerpt_length' );
		if ( $newlength ) {
			return $newlength;
		}
	}
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'twentig_twentyone_custom_excerpt_length' );

/**
 * Removes the post excerpt displayed on the archive pages based on Customizer setting.
 */
function twentig_twentyone_filter_excerpt() {
	if ( ! get_theme_mod( 'twentig_blog_content', true ) && ( is_home() || is_archive() ) ) {
		add_filter( 'the_excerpt', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/content/content-excerpt', 'twentig_twentyone_filter_excerpt' );

/**
 * Removes the post content displayed on the archive pages based on Customizer setting.
 */
function twentig_twentyone_filter_content() {
	if ( ! get_theme_mod( 'twentig_blog_content', true ) && ( is_home() || is_archive() ) ) {
		add_filter( 'the_content', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/content/content', 'twentig_twentyone_filter_content' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param string[] $classes An array of post class names.
 * @param string[] $class   An array of additional class names added to the post.
 * @param int      $post_id The post ID.
 */
function twentig_twentyone_post_class( $classes, $class, $post_id ) {
	if ( is_singular() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( 'no-image' === $hero_layout ) {
			$classes = array_diff( $classes, array( 'has-post-thumbnail' ) );
		}
	}
	return $classes;
}
add_filter( 'post_class', 'twentig_twentyone_post_class', 10, 3 );

/**
 * Determines if post thumbnail should be displayed.
 *
 * @param bool $can_show Whether the post thumbnail can be displayed.
 */
function twentig_twentyone_display_featured_image( $can_show ) {

	if ( twentig_twentyone_is_blog_page()
		|| ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) )
		|| ( 'blog' === get_theme_mod( 'twentig_cpt_archive_layout' ) && twentig_twentyone_is_cpt_archive() )
	) {
		if ( ! get_theme_mod( 'twentig_blog_image', true ) ) {
			return false;
		}
	} elseif ( is_singular() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( 'no-image' === $hero_layout ) {
			return false;
		}
	}
	return $can_show;
}
add_filter( 'twenty_twenty_one_can_show_post_thumbnail', 'twentig_twentyone_display_featured_image' );

/**
 * Filters the content of the latest posts block to change the image sizes attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attribute.
 */
function twentig_twentyone_change_latest_posts_image_sizes( $block_content, $block ) {
	if ( 'core/latest-posts' === $block['blockName'] ) {
		$image = $block['attrs'] && isset( $block['attrs']['displayFeaturedImage'] ) ? $block['attrs']['displayFeaturedImage'] : 0;

		if ( $image ) {
			$image_width = $block['attrs'] && isset( $block['attrs']['featuredImageSizeWidth'] ) ? $block['attrs']['featuredImageSizeWidth'] : '';
			$sizes       = '';

			if ( '' === $image_width ) {
				$layout        = $block['attrs'] && isset( $block['attrs']['postLayout'] ) ? $block['attrs']['postLayout'] : '';
				$block_align   = $block['attrs'] && isset( $block['attrs']['align'] ) ? $block['attrs']['align'] : '';
				$image_align   = $block['attrs'] && isset( $block['attrs']['featuredImageAlign'] ) ? $block['attrs']['featuredImageAlign'] : '';
				$wide_width    = get_theme_mod( 'twentig_wide_width', 1240 );
				$wide_width    = $wide_width ? $wide_width : 1240;
				$default_width = get_theme_mod( 'twentig_default_width', 610 );
				$default_width = $default_width ? $default_width : 610;

				if ( 'grid' === $layout ) {
					$columns = $block['attrs'] && isset( $block['attrs']['columns'] ) ? intval( $block['attrs']['columns'] ) : 3;

					if ( 'left' === $image_align || 'right' === $image_align ) {
						$sizes = '(min-width: 1280px) ' . intval( $wide_width * 0.125 - 5 ) . 'px, (min-width: 652px) calc(12.5vw - 15px), calc(25vw - 10px)';
					} else {
						if ( 'wide' === $block_align || 'full' === $block_align ) {
							$sizes = '(min-width: 1280px) ' . intval( $wide_width / 4 - 30 ) . 'px, (min-width: 1024px) calc(25vw - 60px), (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							if ( 2 === $columns ) {
								$sizes = '(min-width: 1280px) ' . intval( $wide_width / 2 - 20 ) . 'px, (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1280px) ' . intval( $wide_width / 3 - 27 ) . 'px, (min-width: 1024px) calc(33.33vw - 66px), (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							}
						} else {
							$sizes = '(min-width: 1024px) ' . intval( $default_width / 3 - 27 ) . 'px, (min-width: 652px) ' . intval( $default_width / 2 - 16 ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							if ( 2 === $columns ) {
								$sizes = '(min-width: 652px) ' . intval( $default_width / 2 - 16 ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							}
						}
					}
				} else {
					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 652px) ' . intval( $default_width * 0.25 ) . 'px, calc(25vw - 10px)';
						} else {
							$sizes = '(min-width: 1280px) ' . intval( $wide_width * 0.25 ) . 'px, (min-width: 652px) calc(25vw - 25px), calc(25vw - 10px)';
						}
					} else {
						$sizes = '(min-width: 652px) ' . intval( $default_width ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
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
add_filter( 'render_block', 'twentig_twentyone_change_latest_posts_image_sizes', 10, 2 );

/**
 * Filters whether all posts are open for comments.
 *
 * @param bool $open Whether the current post is open for comments.
 */
function twentig_twentyone_comments_open( $open ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'twentig_twentyone_comments_open' );

/**
 * Filters the comment count for all posts.
 *
 * @param string|int $count A string representing the number of comments a post has, otherwise 0.
 */
function twentig_twentyone_comments_number( $count ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return 0;
	}
	return $count;
}
add_filter( 'get_comments_number', 'twentig_twentyone_comments_number' );

/**
 * Removes the single navigation by excluding all the terms.
 */
function twentig_twentyone_filter_navigation() {
	if ( 'none' === get_theme_mod( 'twentig_post_navigation' ) ) {
		add_filter( 'get_next_post_excluded_terms', 'twentig_twentyone_exclude_terms' );
		add_filter( 'get_previous_post_excluded_terms', 'twentig_twentyone_exclude_terms' );
	}
}
add_action( 'get_template_part_template-parts/post/author-bio', 'twentig_twentyone_filter_navigation' );

/**
 * Returns all the post categories.
 */
function twentig_twentyone_exclude_terms() {
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
 * Wraps the archive title prefix with a span.
 *
 * @param string $prefix Archive title prefix.
 */
function twentig_twentyone_set_archive_title_prefix( $prefix ) {
	return '<span class="archive-title-prefix">' . $prefix . '</span>';
}
add_filter( 'get_the_archive_title_prefix', 'twentig_twentyone_set_archive_title_prefix' );


/**
 * Displays transparent logo on Hero Cover & Header Transparent template.
 *
 * @param string $html Custom logo HTML output.
 */
function twentig_twentyone_logo_transparent( $html ) {

	$custom_logo_id             = get_theme_mod( 'custom_logo' );
	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_alt' );
	$header_sticky              = get_theme_mod( 'twentig_header_sticky' );
	$is_transparent             = false;

	if ( ! $custom_logo_id || ! $custom_logo_transparent_id ) {
		return $html;
	}

	if ( is_page_template( 'tw-header-transparent-light.php' ) ) {
		$is_transparent = true;
	} elseif ( is_singular() && ! is_page_template() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( str_contains( $hero_layout, 'cover' ) && has_post_thumbnail() ) {
			$is_transparent = true;
		}
	}

	if ( $is_transparent ) {
		$custom_logo_attr = array(
			'class'   => 'custom-logo',
			'loading' => false,
		);

		$unlink_homepage_logo = (bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' );

		if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
			$custom_logo_attr['alt'] = '';
		} else {
			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
			if ( empty( $image_alt ) ) {
				$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
			}
		}

		$custom_logo_transparent_attr = $custom_logo_attr;

		if ( $header_sticky ) {
			$custom_logo_attr['class']             = 'custom-logo logo-primary';
			$custom_logo_transparent_attr['class'] = 'custom-logo logo-transparent';
		}

		$image             = wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
		$image_transparent = wp_get_attachment_image( $custom_logo_transparent_id, 'full', false, $custom_logo_transparent_attr );
		$logo_output       = $header_sticky ? $image . ' ' . $image_transparent : $image_transparent;

		if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
			$html = sprintf(
				'<span class="custom-logo-link">%1$s</span>',
				$logo_output
			);
		} else {
			$aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';

			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
				esc_url( home_url( '/' ) ),
				$aria_current,
				$logo_output
			);
		}
	}

	remove_filter( 'get_custom_logo', 'twentig_twentyone_logo_transparent' );
	return $html;
}
add_filter( 'get_custom_logo', 'twentig_twentyone_logo_transparent' );

/**
 * Hide the tagline by returning an empty string.
 *
 * @param mixed  $output The requested non-URL site information.
 * @param string $show   Type of information requested.
 */
function twentig_twentyone_hide_tagline( $output, $show ) {
	if ( get_theme_mod( 'twentig_hide_tagline', false ) && 'description' === $show ) {
		return '';
	}
	return $output;
}
add_filter( 'bloginfo', 'twentig_twentyone_hide_tagline', 10, 2 );

require_once TWENTIG_PATH . 'inc/classic/twentytwentyone/class-twentig-nav-menu.php';
new Twentig_Nav_Menu();

/**
 * Renders the "white logo" for dark background footer.
 *
 * @param string $mods_name The value of the current theme modification.
 */
function twentig_twentyone_footer_logo( $mods_name ) {

	$custom_logo_transparent_id = get_theme_mod( 'twentig_custom_logo_alt' );
	if ( ! $custom_logo_transparent_id ) {
		return $mods_name;
	}

	$footer_bg = get_theme_mod( 'twentig_footer_background_color' );

	if ( empty( $footer_bg ) ) {
		$footer_bg = get_theme_mod( 'background_color', 'D1E4DD' );
		if ( get_theme_mod( 'twentig_site_width' ) ) {
			$footer_bg = get_theme_mod( 'twentig_inner_background_color', $footer_bg );
		}
	}

	if ( 127 > Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $footer_bg ) ) {
		return $custom_logo_transparent_id;
	}

	return $mods_name;
}

/**
 * Displays custom footer based on Customizer settings.
 *
 * @param string|null $name Name of the specific footer file to use. null for the default footer.
 */
function twentig_twentyone_get_footer( $name = null ) {

	if ( get_theme_mod( 'custom_logo' ) ) {
		add_filter( 'theme_mod_custom_logo', 'twentig_twentyone_footer_logo' );
	}

	if ( ! get_theme_mod( 'twentig_footer_social_icons', true ) ) {
		remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_nav_menu_social_icons', 10, 4 );
	}

	remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_add_sub_menu_toggle', 10, 4 );
	twentig_twentyone_remove_image_inline_size_style();

	$footer_layout   = get_theme_mod( 'twentig_footer_layout' );
	$footer_branding = get_theme_mod( 'twentig_footer_branding', true );
	$footer_credit   = get_theme_mod( 'twentig_footer_credit' );
	$has_sidebar     = twentig_twentyone_has_sidebar();

	if ( empty( $footer_credit ) && empty( $footer_layout ) && ! $has_sidebar && $footer_branding ) {
		return;
	}

	if ( twentig_twentyone_footer_exists( $name ) ) {
		return;
	}

	?>

			</main><!-- #main -->

			<?php if ( $has_sidebar ) : ?>
				<aside class="blog-sidebar">
					<?php dynamic_sidebar( 'sidebar-blog' ); ?>
				</aside> 
			<?php endif; ?>

			</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<?php

	if ( 'hidden' !== $footer_layout ) :
		$extra_class = '';
		if ( $footer_layout ) {
			$extra_class .= ' footer-' . $footer_layout;
		}
		?>
		<footer id="colophon" class="site-footer<?php echo esc_attr( $extra_class ); ?>">
			<?php if ( 'inline' === $footer_layout ) : ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
					<?php twentig_twentyone_get_footer_menu(); ?>			
				</div><!-- .site-info -->
			<?php elseif ( 'stack' === $footer_layout ) : ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_menu(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
				</div><!-- .site-info -->
			<?php elseif ( 'custom' === $footer_layout ) :
				remove_filter( 'the_content', '__return_empty_string' );
				$block_id = get_theme_mod( 'twentig_footer_content' );
				twentig_render_reusable_block( $block_id );
				?>
			<?php else : ?>
				<?php twentig_twentyone_get_footer_menu(); ?>
				<div class="site-info">
					<?php twentig_twentyone_get_footer_branding(); ?>
					<?php twentig_twentyone_get_footer_credits(); ?>
				</div><!-- .site-info -->			
			<?php endif; ?>	
		</footer><!-- #site-footer -->

	<?php endif; ?>

	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>

	<?php
	$templates = array( 'footer.php' );
	ob_start();
	locate_template( $templates, true );
	ob_get_clean();
}
add_action( 'get_footer', 'twentig_twentyone_get_footer', 9 );

/**
 * Determines whether the given footer template name exists.
 *
 * @param string|null $name Name of the specific footer file.
 */
function twentig_twentyone_footer_exists( $name ) {
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
 * Displays footer branding.
 */
function twentig_twentyone_get_footer_branding() {
	if ( get_theme_mod( 'twentig_footer_branding', true ) ) :
		?>
		<div class="site-name">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
					<?php if ( is_front_page() && ! is_paged() ) : ?>
						<?php bloginfo( 'name' ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	endif;
}

/**
 * Displays footer menu.
 */
function twentig_twentyone_get_footer_menu() {
	if ( has_nav_menu( 'footer' ) ) :
		?>
		<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'twentytwentyone' ); ?>" class="footer-navigation">
			<ul class="footer-navigation-wrapper">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'items_wrap'     => '%3$s',
						'container'      => false,
						'depth'          => 1,
						'link_before'    => '<span>',
						'link_after'     => '</span>',
						'fallback_cb'    => false,
					)
				);
				?>
			</ul><!-- .footer-navigation-wrapper -->
		</nav><!-- .footer-navigation -->
		<?php
	endif;
}

/**
 * Displays footer credits.
 */
function twentig_twentyone_get_footer_credits() {

	$footer_credit = get_theme_mod( 'twentig_footer_credit' );
	$credit_text   = get_theme_mod( 'twentig_footer_credit_text' );

	if ( 'none' !== $footer_credit ) :
		?>

		<div class="powered-by">
			<?php if ( 'custom' === $footer_credit && $credit_text ) : ?>
				<?php echo do_shortcode( wp_kses_post( str_replace( '[Y]', date_i18n( 'Y' ), $credit_text ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<?php
				printf(
					/* translators: %s: WordPress. */
					esc_html__( 'Proudly powered by %s.', 'twentytwentyone' ),
					'<a href="' . esc_url( __( 'https://wordpress.org/', 'twentytwentyone' ) ) . '">WordPress</a>'
				);
				?>
			<?php endif; ?>				
		</div>
		<?php
	endif;
}

/**
 * Add a social-item class to help styling.
 *
 * @param array    $menu_items The menu items, sorted by each menu item's menu order.
 * @param stdClass $args       An object containing wp_nav_menu() arguments.
 */
function twentig_twentyone_wp_nav_menu_objects_footer( $menu_items, $args ) {

	if ( 'footer' === $args->theme_location && get_theme_mod( 'twentig_footer_social_icons', true ) ) {
		foreach ( $menu_items as $index => &$item ) {
			$svg = twenty_twenty_one_get_social_link_svg( $item->url );
			if ( ! empty( $svg ) ) {
				$item->classes[] = 'social-item';
			}
		}
	}
	return $menu_items;
}
add_filter( 'wp_nav_menu_objects', 'twentig_twentyone_wp_nav_menu_objects_footer', 10, 2 );

/**
 * Add support for blocks inside widgets.
 */
function twentig_twentyone_support_widget_block() {
	add_filter( 'widget_text', 'do_blocks', 9 );
}
add_action( 'init', 'twentig_twentyone_support_widget_block' );

/**
 * Detect if custom built footer has background.
 */
function twentig_twentyone_has_footer_block_background() {

	$footer_layout = get_theme_mod( 'twentig_footer_layout' );

	if ( 'custom' !== $footer_layout ) {
		return false;
	}

	$block_id       = get_theme_mod( 'twentig_footer_content' );
	$reusable_block = get_post( $block_id );

	if ( $reusable_block ) {
		$blocks = parse_blocks( $reusable_block->post_content );

		if ( isset( $blocks[0] ) ) {
			if ( 'core/group' === $blocks[0]['blockName'] && isset( $blocks[0]['innerHTML'] ) && str_contains( $blocks[0]['innerHTML'], 'has-background' ) ) {
				return true;
			}
			if ( 'core/cover' === $blocks[0]['blockName'] ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Add script to fix anchor tag that toggle the burger menu.
 */
function twentig_twentyone_add_footer_script() {
	if ( twentig_is_amp_endpoint() ) {
		return;
	}
	?>
	<script>
	(function() {
		document.addEventListener( 'click', function( event ) {
			if ( event.target.hash && event.target.hash.includes( '#' ) && ! document.getElementById( 'site-navigation' ).contains( event.target ) ) {
				var mobileButton = document.getElementById( 'primary-mobile-menu' );
				twentytwentyoneToggleAriaExpanded( mobileButton );
			}
		} );
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'twentig_twentyone_add_footer_script' );
