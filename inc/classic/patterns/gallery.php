<?php
/**
 * Gallery block patterns.
 *
 * @package twentig
 * @phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
 */

twentig_register_block_pattern(
	'twentig/gallery-stack',
	array(
		'title'      => __( 'Gallery: stack', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center","className":"tw-mb-8"} --><h2 class="has-text-align-center tw-mb-8">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:gallery {"ids":[null,null,null],"columns":1,"imageCrop":false,"sizeSlug":"full","twGutter":"large"} --><figure class="wp-block-gallery columns-1 tw-gutter-large"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'square2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-2-columns',
	array(
		'title'      => __( 'Gallery 2 columns', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:gallery {"ids":[null,null,null,null],"columns":2,"imageCrop":false,"align":"wide","twImageRatio":"3-2","twStackedSm":true} --><figure class="wp-block-gallery alignwide columns-2 tw-img-ratio-3-2 tw-stack-sm"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape4.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-alternating-widths',
	array(
		'title'      => __( 'Gallery: alternating widths', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:image {"align":"wide","className":"tw-mb-3"} --><figure class="wp-block-image alignwide tw-mb-3"><img src="' . twentig_get_pattern_asset( 'wide.jpg' ) . '" alt=""/></figure><!-- /wp:image --><!-- wp:gallery {"ids":[null,null],"columns":2,"align":"wide","className":"tw-mb-3 tw-mt-3"} --><figure class="wp-block-gallery alignwide columns-2 is-cropped tw-mb-3 tw-mt-3"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'square3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'square4.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --><!-- wp:image {"align":"wide","className":"tw-mt-3"} --><figure class="wp-block-image alignwide tw-mt-3"><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt=""/></figure><!-- /wp:image --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-stretched-images',
	array(
		'title'      => __( 'Gallery: stretched images', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:gallery {"ids":[null,null,null,null,null],"align":"wide"} --><figure class="wp-block-gallery alignwide columns-3 is-cropped"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape4.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape5.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-center-alignment',
	array(
		'title'      => __( 'Gallery: center alignment', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:gallery {"ids":[null,null,null,null,null],"columns":3,"align":"wide","className":"tw-img-center","twFixedWidthCols":true,"twGutter":"medium"} --><figure class="wp-block-gallery alignwide columns-3 is-cropped tw-img-center tw-fixed-cols tw-gutter-medium"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape4.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape5.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-3-columns',
	array(
		'title'      => __( 'Gallery 3 columns', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:gallery {"ids":[null,null,null,null,null,null],"columns":3,"imageCrop":false,"align":"wide","twFixedWidthCols":true,"twImageRatio":"4-3","twStackedSm":true} --><figure class="wp-block-gallery alignwide columns-3 tw-fixed-cols tw-img-ratio-4-3 tw-stack-sm"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape4.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape5.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape6.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/gallery-3-columns-full-width-no-gutter',
	array(
		'title'      => __( 'Gallery 3 columns: full width', 'twentig' ),
		'categories' => array( 'gallery' ),
		'content'    => '<!-- wp:gallery {"ids":[null,null,null,null,null,null],"columns":3,"imageCrop":false,"align":"full","twImageRatio":"3-2","twGutter":"no","twStackedSm":true} --><figure class="wp-block-gallery alignfull columns-3 tw-img-ratio-3-2 tw-gutter-no tw-stack-sm"><ul class="blocks-gallery-grid"><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape4.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape5.jpg' ) . '" alt="" data-id=""/></figure></li><li class="blocks-gallery-item"><figure><img src="' . twentig_get_pattern_asset( 'landscape6.jpg' ) . '" alt="" data-id=""/></figure></li></ul></figure><!-- /wp:gallery -->',
	)
);

