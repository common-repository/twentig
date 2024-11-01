<?php
/**
 * Query block patterns.
 *
 * @package twentig
 */

$pagination = '<!-- wp:query-pagination-previous {"label":"' . esc_html__( 'Previous', 'twentig' ) . '"} /--><!-- wp:query-pagination-numbers {"midSize":1,"className":"is-style-tw-circle"} /--><!-- wp:query-pagination-next {"label":"' . esc_html__( 'Next', 'twentig' ) . '"} /-->';

twentig_register_block_pattern(
	'twentig/posts-2-columns',
	array(
		'title'      => __( 'Posts 2 columns', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"4","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":2}} --><!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|25"}}},"twStretchedLink":true} --><div class="wp-block-group tw-stretched-link" style="margin-bottom:var(--wp--preset--spacing--25)"><!-- wp:post-featured-image {"aspectRatio":"3/2","sizeSlug":"large"} /--><!-- wp:post-title {"isLink":true,"fontSize":"large"} /--><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"var:preset|spacing|15"}},"typography":{"lineHeight":"1.3"}},"textColor":"contrast-2","layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} -->	<div class="wp-block-group has-contrast-2-color has-text-color has-small-font-size" style="margin-top:var(--wp--preset--spacing--15);line-height:1.3"><!-- wp:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}}} /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-date /--></div><!-- /wp:group --></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-8 tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns-text-only',
	array(
		'title'      => __( 'Posts 2 columns: text only', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"4","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":2}} --><!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"bottom":"var:preset|spacing|35"}},"border":{"bottom":{"width":"1px"}},"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"space-between"},"twStretchedLink":true} --><div class="wp-block-group tw-stretched-link" style="border-bottom-width:1px;min-height:100%;padding-bottom:var(--wp--preset--spacing--35)"><!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:post-title {"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|10"}}},"fontSize":"large"} /--><!-- wp:post-excerpt {"excerptLength":40,"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} /--></div><!-- /wp:group --><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"var:preset|spacing|35"}},"typography":{"lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} --><div class="wp-block-group has-contrast-2-color has-text-color has-link-color has-small-font-size" style="margin-top:var(--wp--preset--spacing--35);line-height:1.3"><!-- wp:post-terms {"term":"category"} /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-date /--></div><!-- /wp:group --></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-8 tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns-cover',
	array(
		'title'      => __( 'Posts 2 columns: cover', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"4","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":2}} --><!-- wp:cover {"useFeaturedImage":true,"customGradient":"linear-gradient(0deg,rgba(0,0,0,0.8) 0%,rgba(0,0,0,0) 80%)","contentPosition":"bottom left","style":{"spacing":{"padding":{"top":"var:preset|spacing|35","right":"var:preset|spacing|35","bottom":"var:preset|spacing|35","left":"var:preset|spacing|35"}},"elements":{"link":{"color":{"text":"#fff"}}},"border":{"radius":"16px"},"color":{"text":"#fff"}},"twStretchedLink":true,"twHover":"zoom","twRatio":"1-1"} --><div class="wp-block-cover has-custom-content-position is-position-bottom-left has-text-color has-link-color tw-stretched-link tw-hover-zoom tw-ratio-1-1" style="border-radius:16px;color:#fff;padding-top:var(--wp--preset--spacing--35);padding-right:var(--wp--preset--spacing--35);padding-bottom:var(--wp--preset--spacing--35);padding-left:var(--wp--preset--spacing--35)"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim has-background-gradient" style="background:linear-gradient(0deg,rgba(0,0,0,0.8) 0%,rgba(0,0,0,0) 80%)"></span><div class="wp-block-cover__inner-container"><!-- wp:post-title {"isLink":true,"className":"tw-link-no-underline","fontSize":"large"} /--><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"var:preset|spacing|15"}},"typography":{"lineHeight":"1.3"}},"layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} --><div class="wp-block-group has-small-font-size" style="margin-top:var(--wp--preset--spacing--15);line-height:1.3"><!-- wp:post-terms {"term":"category"} /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-date {"style":{"color":{"text":"#fff"}}} /--></div><!-- /wp:group --></div></div><!-- /wp:cover --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-8 tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->'
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns',
	array(
		'title'      => __( 'Posts 3 columns', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"3","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"enhancedPagination":true,"align":"wide","layout":{"type":"constrained"}} --><div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"layout":{"type":"grid","columnCount":3}} --><!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}},"twStretchedLink":true} --><div class="wp-block-group tw-stretched-link" style="margin-bottom:var(--wp--preset--spacing--30)"><!-- wp:post-featured-image {"aspectRatio":"3/2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} /--><!-- wp:post-title {"isLink":true,"fontSize":"large"} /--><!-- wp:post-excerpt {"moreText":"","excerptLength":20,"style":{"spacing":{"margin":{"top":"var:preset|spacing|15"}}}} /--><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"var:preset|spacing|25"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","layout":{"type":"flex","allowOrientation":false},"fontSize":"small"} --><div class="wp-block-group has-contrast-2-color has-text-color has-link-color has-small-font-size" style="margin-top:var(--wp--preset--spacing--25)"><!-- wp:post-date /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-terms {"term":"category","className":"tw-link-hover-underline"} /--></div><!-- /wp:group --></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-7 tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns-card',
	array(
		'title'      => __( 'Posts 3 columns: card', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"3","offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3}} --><!-- wp:group {"style":{"dimensions":{"minHeight":"100%"},"border":{"radius":"16px"},"spacing":{"blockGap":"var:preset|spacing|15"}},"backgroundColor":"base-2","layout":{"type":"flex","orientation":"vertical","verticalAlignment":"space-between"},"twStretchedLink":true} --><div class="wp-block-group has-base-2-background-color has-background tw-stretched-link" style="border-radius:16px;min-height:100%"><!-- wp:group --><div class="wp-block-group"><!-- wp:post-featured-image {"aspectRatio":"16/9","sizeSlug":"large","style":{"border":{"radius":"0px"}},"twHover":"zoom"} /--><!-- wp:post-title {"isLink":true,"style":{"spacing":{"padding":{"left":"var:preset|spacing|30","right":"var:preset|spacing|30","top":"var:preset|spacing|30"},"margin":{"top":"0","bottom":"0"}}},"className":"tw-link-no-underline","fontSize":"large"} /--></div><!-- /wp:group --><!-- wp:group {"style":{"spacing":{"blockGap":"6px","padding":{"right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}},"typography":{"lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} --><div class="wp-block-group has-contrast-2-color has-text-color has-link-color has-small-font-size" style="padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);line-height:1.3"><!-- wp:post-terms {"term":"category"} /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-date /--></div><!-- /wp:group --></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-mt-8 tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-image-on-left',
	array(
		'title'      => __( 'Posts: image on left', 'twentig' ),
		'blockTypes' => array( 'core/query' ),
		'categories' => array( 'posts' ),
		'content'    => '<!-- wp:query {"query":{"perPage":"3","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide"} --><div class="wp-block-query alignwide"><!-- wp:post-template --><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|35","left":"var:preset|spacing|50"}}}} --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /--></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:post-title {"isLink":true,"fontSize":"x-large"} /--><!-- wp:post-excerpt {"excerptLength":30,"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} /--><!-- wp:group {"style":{"spacing":{"blockGap":"6px","margin":{"top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast-2"}}}},"textColor":"contrast-2","layout":{"type":"flex","allowOrientation":false},"fontSize":"small"} --><div class="wp-block-group has-contrast-2-color has-text-color has-link-color has-small-font-size" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:post-date /--><!-- wp:paragraph --><p>·</p><!-- /wp:paragraph --><!-- wp:post-terms {"term":"category"} /--></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"className":"is-style-wide"} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" style="margin-top:var(--wp--preset--spacing--50);margin-bottom:var(--wp--preset--spacing--50)"/><!-- /wp:separator --><!-- /wp:post-template --><!-- wp:query-pagination {"className":"tw-link-hover-underline","layout":{"type":"flex","justifyContent":"center"}} -->' . $pagination . '<!-- /wp:query-pagination --></div><!-- /wp:query -->',
	)
);
