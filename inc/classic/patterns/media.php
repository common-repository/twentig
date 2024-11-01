<?php
/**
 * Video & audio block patterns.
 *
 * @package twentig
 */

twentig_register_block_pattern(
	'twentig/hero-with-video',
	array(
		'title'      => __( 'Hero with video', 'twentig' ),
		'categories' => array( 'media', 'hero' ),
		'content'    => '<!-- wp:group {"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center","level":1} --><h1 class="has-text-align-center">' . esc_html_x( 'Write the page title', 'Block pattern content', 'twentig' ) . '</h1><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"large","align":"center","style":{"typography":{"lineHeight":1.4}}} --><p class="has-text-align-center has-large-font-size" style="line-height:1.4">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed.</p><!-- /wp:paragraph --><!-- wp:video {"align":"wide"} --><figure class="wp-block-video alignwide"><video controls poster="' . twentig_get_pattern_asset( 'wide.jpg' ) . '" src="#"></video></figure><!-- /wp:video --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/Text and Video',
	array(
		'title'      => __( 'Text and video', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent.</p><!-- /wp:paragraph --><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"tw-mt-8 wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube tw-mt-8 wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/video-with-text-on-left',
	array(
		'title'      => __( 'Video with text on left', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:columns {"verticalAlignment":"center","align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide are-vertically-aligned-center tw-gutter-large tw-cols-stack-md"><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus, suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/video-with-frame-and-text-on-right',
	array(
		'title'      => __( 'Video with frame and text on right', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:columns {"verticalAlignment":"center","align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide are-vertically-aligned-center tw-gutter-large tw-cols-stack-md"><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio is-style-tw-frame"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio is-style-tw-frame"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus, suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/Text Columns and Video',
	array(
		'title'      => __( 'Text columns and video', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:columns {"align":"wide","className":"tw-mb-8","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide tw-mb-8 tw-gutter-large tw-cols-stack-md"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","align":"wide","className":"tw-mt-8wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube alignwide wp-block-embed is-type-video is-provider-youtube tw-mt-8 wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/audio-list',
	array(
		'title'      => __( 'Audio list', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center","className":"tw-mb-8"} --><h2 class="has-text-align-center tw-mb-8">' . esc_html_x( 'All episodes', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">01: Lorem ipsum dolor sit amet</h3><!-- /wp:heading --><!-- wp:audio --><figure class="wp-block-audio"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --><!-- wp:separator {"className":"tw-mt-6 tw-mb-6"} --><hr class="wp-block-separator tw-mt-6 tw-mb-6"/><!-- /wp:separator --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">02: Integer enim risus suscipit eu iaculis sed</h3><!-- /wp:heading --><!-- wp:audio --><figure class="wp-block-audio"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --><!-- wp:separator {"className":"tw-mt-6 tw-mb-6"} --><hr class="wp-block-separator tw-mt-6 tw-mb-6"/><!-- /wp:separator --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">03: Aliquam tempus mi eu nulla porta luctus</h3><!-- /wp:heading --><!-- wp:audio --><figure class="wp-block-audio"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/media-list-with-image-and-button',
	array(
		'title'      => __( 'Media list with image and button', 'twentig' ),
		'categories' => array( 'media' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'All episodes', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">01: Lorem ipsum dolor sit amet</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">02: Integer enim risus suscipit</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Fusce sed magna eu ligula commodo hendrerit fringilla ac purus. Integer sagittis efficitur rhoncus justo.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">03: Aliquam tempus mi eu nulla</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Mauris dui tellus mollis quis varius, sit amet ultrices in leo. Cras et purus sit amet velit congue convallis nec id diam.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --></div><!-- /wp:group -->',
	)
);
