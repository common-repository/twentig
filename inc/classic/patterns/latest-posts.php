<?php
/**
 * Latest posts block patterns.
 *
 * @package twentig
 */

twentig_register_block_pattern(
	'twentig/posts-list',
	array(
		'title'      => __( 'Posts: list', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 tw-heading-size-medium","postsToShow":3,"displayPostDate":true} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-separator',
	array(
		'title'      => __( 'Posts: list with separator', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 is-style-tw-posts-border tw-heading-size-medium tw-hide-more-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-image-on-right',
	array(
		'title'      => __( 'Posts: list with image on right', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading --><h2>' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 is-style-tw-posts-border tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link tw-hide-more-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageAlign":"right","featuredImageSizeSlug":"medium"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-image-on-left',
	array(
		'title'      => __( 'Posts: list with image on left', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading --><h2>' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 tw-img-ratio-3-2 tw-heading-size-medium is-style-tw-posts-border tw-stretched-link tw-hide-more-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeSlug":"medium"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns-image-on-left',
	array(
		'title'      => __( 'Posts 2 columns: image on left', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-heading-size-small tw-img-ratio-3-2 tw-stretched-link","postsToShow":4,"displayPostDate":true,"postLayout":"grid","columns":2,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeSlug":"medium"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns',
	array(
		'title'      => __( 'Posts 2 columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-heading-size-medium tw-img-ratio-16-9 tw-stretched-link","postsToShow":2,"displayPostDate":true,"postLayout":"grid","columns":2,"displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns',
	array(
		'title'      => __( 'Posts 3 columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link","postsToShow":3,"displayPostDate":true,"postLayout":"grid","displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-column-cards',
	array(
		'title'      => __( 'Posts 3 columns: card', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-card tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link","postsToShow":3,"displayPostDate":true,"postLayout":"grid","displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-column-cards-text-only',
	array(
		'title'      => __( 'Posts 3 columns: card with text only', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-card tw-stretched-link tw-heading-size-medium tw-hide-more-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true,"postLayout":"grid"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns-top-border',
	array(
		'title'      => __( 'Posts 3 columns: top border', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-border tw-heading-size-medium","postsToShow":6,"displayPostDate":true,"postLayout":"grid"} /--></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-4-columns',
	array(
		'title'      => __( 'Posts 4 columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-heading-size-small tw-img-ratio-3-2 tw-stretched-link","postsToShow":4,"displayPostDate":true,"postLayout":"grid","columns":4,"displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div><!-- /wp:group -->',
	)
);
