<?php
/**
 * Query block patterns.
 *
 * @package twentig
 */

if ( ! twentig_is_option_enabled( 'portfolio' ) ) {
	return;
}

twentig_register_block_pattern(
	'twentig/portfolio-2-columns',
	array(
		'title'      => __( 'Portfolio 2 columns', 'twentig' ),
		'categories' => array( 'portfolio' ),
		'blockTypes' => array( 'core/query/twentig/portfolio-list' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"24","pages":0,"offset":0,"postType":"portfolio","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"namespace":"twentig/portfolio-list","align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"40px"}},"layout":{"type":"grid","columnCount":2}} -->
		<!-- wp:group {"className":"tw-mb-4","twStretchedLink":true} --><div class="wp-block-group tw-mb-4 tw-stretched-link"><!-- wp:post-featured-image {"aspectRatio":"4/3","sizeSlug":"large","className":"tw-mb-4"} /--><!-- wp:post-title {"isLink":true,"className":"tw-mt-0","fontSize":"large"} /--></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-8","layout":{"type":"flex","justifyContent":"center"},"fontSize":"small"} --><!-- wp:query-pagination-previous {"label":"' . esc_html__( 'Previous', 'twentig' ) . '"} /--><!-- wp:query-pagination-numbers {"midSize":1,"className":"is-style-tw-circle"} /--><!-- wp:query-pagination-next {"label":"' . esc_html__( 'Next', 'twentig' ) . '"} /--><!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);
