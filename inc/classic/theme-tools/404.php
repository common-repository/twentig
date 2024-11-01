<?php
/**
 * 404 Page
 *
 * @package twentig
 */

/**
 * Set the 404 page.
 *
 * @param string $template The path of the template to include.
 */
function twentig_set_404_template( $template ) {
	$page404 = get_theme_mod( 'twentig_page_404' );
	if ( $page404 && in_array( get_post_status( $page404 ), array( 'private', 'publish' ), true ) ) {
		global $wp_query;
		global $post;
		$wp_query = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		$wp_query = new WP_Query(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		$wp_query->query(
			array(
				'page_id'     => $page404,
				'post_status' => array( 'private', 'publish' ),
			)
		);
		$wp_query->the_post();
		$template = get_page_template();
		add_filter(
			'document_title_parts',
			function ( $title ) {
				$title['title'] = esc_html__( 'Page not found' );
				return $title;
			}
		);
		add_filter(
			'body_class',
			function ( $classes ) {
				$classes[] = 'error-404';
				return $classes;
			}
		);
		rewind_posts();
	}
	return $template;
}
add_filter( '404_template', 'twentig_set_404_template' );

/**
 * Removes private prefix from the 404 page title.
 *
 * @param string $prepend Text displayed before the post title. Default 'Private: %s'.
 */
function twentig_private_title_format( $prepend ) {
	if ( is_404() || is_page( get_theme_mod( 'twentig_page_404' ) ) ) {
		return '%s';
	}
	return $prepend;
}
add_filter( 'private_title_format', 'twentig_private_title_format' );

/**
 * Adds 404 label to the selected page in the posts list table.
 *
 * @param array   $post_states An array of post display states.
 * @param WP_Post $post The current post object.
 */
function twentig_filter_display_post_states( $post_states, $post ) {
	$page404 = get_theme_mod( 'twentig_page_404' );
	if ( $page404 && $page404 === $post->ID ) {
		$post_states['404'] = esc_html__( '404 Page', 'twentig' );
	}
	return $post_states;
}
add_filter( 'display_post_states', 'twentig_filter_display_post_states', 10, 2 );
