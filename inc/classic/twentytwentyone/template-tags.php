<?php
/**
 * Override Custom template tags for Twenty Twenty-One.
 *
 * @package twentig
 */

if ( ! function_exists( 'twenty_twenty_one_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 */
	function twenty_twenty_one_post_thumbnail() {

		if ( is_singular( 'post' ) && get_theme_mod( 'twentig_post_excerpt', false ) && has_excerpt() ) : ?>
			<div class="intro-text"><?php the_excerpt(); ?></div>
		<?php endif; ?>

		<?php twentig_twentyone_entry_meta_header(); ?>
		<?php
		if ( ! twenty_twenty_one_can_show_post_thumbnail() ) {
			if ( is_singular() ) {
				remove_filter( 'wp_calculate_image_sizes', 'twentig_twentyone_calculate_image_sizes' );
			}
			return;
		}
		?>

		<?php
		if ( is_singular() ) :
			$size        = 'post-thumbnail';
			$hero_layout = is_page() ? get_theme_mod( 'twentig_page_hero_layout' ) : get_theme_mod( 'twentig_post_hero_layout' );
			if ( in_array( $hero_layout, array( 'full-image', 'cover', 'cover-full' ), true ) ) {
				$size = 'full';
			}
			?>
			<figure class="post-thumbnail">
				<?php the_post_thumbnail( $size, array( 'loading' => false ) ); ?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

			<?php remove_filter( 'wp_calculate_image_sizes', 'twentig_twentyone_calculate_image_sizes' ); ?>

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure>

		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'twenty_twenty_one_the_posts_navigation' ) ) {
	/**
	 * Print the next and previous posts navigation.
	 */
	function twenty_twenty_one_the_posts_navigation() {

		$style = get_theme_mod( 'twentig_blog_pagination' );

		the_posts_pagination(
			array(
				'before_page_number' => empty( $style ) ? esc_html__( 'Page', 'twentytwentyone' ) . ' ' : '',
				'mid_size'           => empty( $style ) ? 0 : 1,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ),
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
				),
			)
		);
	}
}

if ( ! function_exists( 'twenty_twenty_one_entry_meta_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function twenty_twenty_one_entry_meta_footer() {

		// Early exit if not a post.
		if ( 'post' !== get_post_type() ) {
			return;
		}

		if ( ! is_single() ) {

			$post_meta = get_theme_mod( 'twentig_blog_meta', array( 'date', 'categories', 'tags' ) );

			ob_start();

			if ( is_sticky() ) {
				echo '<p>' . esc_html_x( 'Featured post', 'Label for sticky posts', 'twentytwentyone' ) . '</p>';
			}

			$post_format = get_post_format();
			if ( 'aside' === $post_format || 'status' === $post_format ) {
				echo '<p><a href="' . esc_url( get_permalink() ) . '">' . twenty_twenty_one_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			if ( in_array( 'date', $post_meta, true ) ) {
				twenty_twenty_one_posted_on();
			}

			if ( in_array( 'author', $post_meta, true ) ) {
				twentig_twentyone_posted_by();
			}

			// Edit post link.
			if ( 'stack' === get_theme_mod( 'twentig_blog_layout', 'stack' ) ) {
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post. Only visible to screen readers. */
						esc_html__( 'Edit %s', 'twentytwentyone' ),
						'<span class="screen-reader-text">' . get_the_title() . '</span>'
					),
					'<span class="edit-link">',
					'</span><br>'
				);
			}

			if ( ( has_category() && in_array( 'categories', $post_meta, true ) )
				||
				( has_tag() && in_array( 'tags', $post_meta, true ) )
			) {

				echo '<div class="post-taxonomies">';

				/* translators: used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( __( ', ', 'twentytwentyone' ) );
				if ( in_array( 'categories', $post_meta, true ) && $categories_list ) {
					printf(
						/* translators: %s: list of categories. */
						'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'twentytwentyone' ) . '</span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', __( ', ', 'twentytwentyone' ) );
				if ( in_array( 'tags', $post_meta, true ) && $tags_list ) {
					printf(
						/* translators: %s: list of tags. */
						'<span class="tags-links">' . esc_html__( 'Tagged %s', 'twentytwentyone' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}

			if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				?>
				<span class="comment-link"><?php comments_popup_link(); ?></span>	
				<?php
			}

			$meta_output = ob_get_clean();
			if ( $meta_output ) {
				twentig_twentyone_print_meta_info( $meta_output );
			}
		} else {
			$post_meta = get_theme_mod( 'twentig_post_bottom_meta', array( 'date', 'author', 'categories', 'tags' ) );

			ob_start();

			if ( in_array( 'date', $post_meta, true ) || in_array( 'author', $post_meta, true ) ) {
				echo '<div class="posted-by">';
				// Posted on.
				if ( in_array( 'date', $post_meta, true ) ) {
					twenty_twenty_one_posted_on();
				}
				// Posted by.
				if ( in_array( 'author', $post_meta, true ) ) {
					twentig_twentyone_posted_by();
				}
				// Edit post link.
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post. Only visible to screen readers. */
						esc_html__( 'Edit %s', 'twentytwentyone' ),
						'<span class="screen-reader-text">' . get_the_title() . '</span>'
					),
					'<span class="edit-link">',
					'</span>'
				);
				echo '</div>';
			}

			if ( ( has_category() && in_array( 'categories', $post_meta, true ) )
				||
				( has_tag() && in_array( 'tags', $post_meta, true ) )
			) {
				echo '<div class="post-taxonomies">';

				/* translators: used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( __( ', ', 'twentytwentyone' ) );
				if ( in_array( 'categories', $post_meta, true ) && $categories_list ) {
					printf(
						/* translators: %s: list of categories. */
						'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'twentytwentyone' ) . ' </span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( '', __( ', ', 'twentytwentyone' ) );
				if ( in_array( 'tags', $post_meta, true ) && $tags_list ) {
					printf(
						/* translators: %s: list of tags. */
						'<span class="tags-links">' . esc_html__( 'Tagged %s', 'twentytwentyone' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}

			$meta_output = ob_get_clean();
			// If there is meta to output, return it.
			if ( $meta_output ) {
				twentig_twentyone_print_meta_info( $meta_output );
			}
		}
	}
}

/**
 * Prints HTML with meta information about post author.
 */
function twentig_twentyone_posted_by() {
	if ( post_type_supports( get_post_type(), 'author' ) ) {
		$html  = '<span class="byline">';
		$html .= sprintf(
			/* translators: %s author name. */
			esc_html__( 'By %s', 'twentytwentyone' ),
			'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a>'
		);
		$html .= '</span>';
		echo apply_filters( 'twentig_twentyone_posted_by_html', $html ); 
	}
}

/**
 * Prints all HTML meta information.
 *
 * @param string $html   Meta html.
 */
function twentig_twentyone_print_meta_info( $html ) {
	if ( ! get_theme_mod( 'twentig_blog_meta_label', true ) ) {
		$html = preg_replace( '/<span class="posted-on">(.*?)<time/', '<span class="posted-on"><span class="screen-reader-text">$1</span><time', $html, 1 );
		$html = preg_replace( '/<span class="cat-links">(.*?)<a/', '<span class="cat-links"><span class="screen-reader-text">$1</span><a', $html, 1 );
		$html = preg_replace( '/<span class="tags-links">(.*?)<a/', '<span class="tags-links"><span class="screen-reader-text">$1</span><a', $html, 1 );
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Prints post meta information below the title.
 */
function twentig_twentyone_entry_meta_header() {

	// Early exit if not a post.
	if ( 'post' !== get_post_type() || empty( get_theme_mod( 'twentig_post_top_meta' ) ) || ! is_single() ) {
		return;
	}

	ob_start();

	echo '<div class="entry-top-meta">';

	$post_meta = get_theme_mod( 'twentig_post_top_meta', array() );

	if ( in_array( 'date', $post_meta, true ) ) {
		twenty_twenty_one_posted_on();
	}

	if ( in_array( 'author', $post_meta, true ) ) {
		twentig_twentyone_posted_by();
	}

	/* translators: used between list items, there is a space after the comma. */
	$categories_list = get_the_category_list( __( ', ', 'twentytwentyone' ) );
	if ( in_array( 'categories', $post_meta, true ) && $categories_list ) {
		printf(
			/* translators: %s: list of categories. */
			'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'twentytwentyone' ) . ' </span>',
			$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
		);
	}

	/* translators: used between list items, there is a space after the comma. */
	$tags_list = get_the_tag_list( '', __( ', ', 'twentytwentyone' ) );
	if ( in_array( 'tags', $post_meta, true ) && $tags_list ) {
		printf(
			/* translators: %s: list of tags. */
			'<span class="tags-links">' . esc_html__( 'Tagged %s', 'twentytwentyone' ) . '</span>',
			$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
		);
	}

	if ( in_array( 'comments', $post_meta, true ) && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		?>
		<span class="comment-link">
			<?php comments_popup_link(); ?>
		</span>	
		<?php
	}

	echo '</div>';

	$meta_output = ob_get_clean();
	if ( $meta_output ) {
		twentig_twentyone_print_meta_info( $meta_output );
	}
}
