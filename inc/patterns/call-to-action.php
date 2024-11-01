<?php
/**
 * Call-To-Action block patterns.
 *
 * @package twentig
 * @phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
 */

$group_name = esc_html_x( 'Call to Action', 'Block pattern category' );

twentig_register_block_pattern(
	'twentig/cta-colored-background',
	array(
		'title'      => __( 'CTA: colored background', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","backgroundColor":"base-2","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull has-base-2-background-color has-background"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-colored-background-with-text',
	array(
		'title'      => __( 'CTA: colored background with text', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","backgroundColor":"base-2","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull has-base-2-background-color has-background"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-wide-cover',
	array(
		'title'      => __( 'CTA: wide cover', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'wide.jpg' ) . '","dimRatio":50,"minHeight":500,"align":"wide","textColor":"white","layout":{"type":"constrained"}} --><div class="wp-block-cover alignwide has-white-color has-text-color" style="min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="' . twentig_get_pattern_asset( 'wide.jpg' ) . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button {"backgroundColor":"white","textColor":"black"} --><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-cover-with-buttons',
	array(
		'title'      => __( 'CTA: cover with buttons', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'wide.jpg' ) . '","dimRatio":50,"minHeight":500,"align":"full","textColor":"white","layout":{"type":"constrained"}} --><div class="wp-block-cover alignfull has-white-color has-text-color" style="min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="' . twentig_get_pattern_asset( 'wide.jpg' ) . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button {"backgroundColor":"white","textColor":"black"} --><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --><!-- wp:button {"textColor":"white","className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-white-color has-text-color wp-element-button">' . esc_html_x( 'Learn more', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-heading-on-left',
	array(
		'title'      => __( 'CTA: heading on left', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|50"}}},"twStack":"md"} --><div class="wp-block-columns alignwide tw-cols-stack-md"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading --><h2>' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --><!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-image-on-right',
	array(
		'title'      => __( 'CTA: image on right', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|35","left":"var:preset|spacing|50"}}},"twStack":"md"} --><div class="wp-block-columns alignwide are-vertically-aligned-center tw-cols-stack-md"><!-- wp:column {"verticalAlignment":"center","layout":{"type":"constrained"}} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore.</p><!-- /wp:paragraph --><!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center","className":"tw-md-order-first","layout":{"type":"constrained"}} --><div class="wp-block-column is-vertically-aligned-center tw-md-order-first"><!-- wp:image --><figure class="wp-block-image"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><!-- /wp:image --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-horizontal-card',
	array(
		'title'      => __( 'CTA: horizontal card', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","backgroundColor":"base-2","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull has-base-2-background-color has-background"><!-- wp:media-text {"mediaType":"image","imageFill":true,"backgroundColor":"base"} --><div class="wp-block-media-text alignwide is-stacked-on-mobile is-image-fill has-base-background-color has-background"><figure class="wp-block-media-text__media" style="background-image:url(' . twentig_get_pattern_asset( 'landscape1.jpg' ) . ');background-position:50% 50%"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"fontSize":"xx-large"} --><h2 class="has-xx-large-font-size">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-2-columns',
	array(
		'title'      => __( 'CTA: 2 columns', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:group {"metadata":{"name":"' . $group_name . '"},"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|45","left":"var:preset|spacing|50"}}},"twStack":"md"} --><div class="wp-block-columns alignwide tw-cols-stack-md"><!-- wp:column {"layout":{"type":"constrained"}} --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- wp:separator {"opacity":"css","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"className":"tw-lg-hidden is-style-wide"} --><hr class="wp-block-separator has-css-opacity tw-lg-hidden is-style-wide" style="margin-top:var(--wp--preset--spacing--50)"/><!-- /wp:separator --></div><!-- /wp:column --><!-- wp:column {"layout":{"type":"constrained"}} --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html_x( 'Contact us', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-2-columns-with-cover',
	array(
		'title'      => __( 'CTA: 2 columns with cover', 'twentig' ),
		'categories' => array( 'call-to-action' ),
		'content'    => '<!-- wp:columns {"metadata":{"name":"' . $group_name . '"},"align":"full","style":{"spacing":{"blockGap":"0px"}},"twStack":"md"} --><div class="wp-block-columns alignfull tw-cols-stack-md"><!-- wp:column --><div class="wp-block-column"><!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '","dimRatio":50,"textColor":"white","layout":{"type":"constrained"},"twStretchedLink":true,"twHover":"opacity"} --><div class="wp-block-cover has-white-color has-text-color tw-stretched-link tw-hover-opacity"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button {"backgroundColor":"white","textColor":"black"} --><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '","dimRatio":50,"textColor":"white","layout":{"type":"constrained"},"twStretchedLink":true,"twHover":"opacity"} --><div class="wp-block-cover has-white-color has-text-color tw-stretched-link tw-hover-opacity"><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|35"}}}} --><div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--35)"><!-- wp:button {"backgroundColor":"white","textColor":"black"} --><div class="wp-block-button"><a class="wp-block-button__link has-black-color has-white-background-color has-text-color has-background wp-element-button">' . esc_html_x( 'Contact us', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div><!-- /wp:column --></div><!-- /wp:columns -->',
	)
);
