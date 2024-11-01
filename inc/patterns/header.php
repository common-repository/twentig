<?php
/**
 * Header block patterns.
 *
 * @package twentig
 */

$social = '<!-- wp:social-link {"url":"#","service":"twitter"} /--><!-- wp:social-link {"url":"#","service":"instagram"} /-->';

twentig_register_block_pattern(
	'twentig/header-with-social-icons',
	array(
		'title'         => __( 'Header with social icons', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /--><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet"} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:social-links {"iconColor":"constrast","iconColorValue":"var(--wp--preset--color--constrast)","size":"has-small-icon-size","className":"is-style-logos-only","twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-with-button',
	array(
		'title'         => __( 'Header with button', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /--><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet"} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Button', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-with-circle-logo-or-profile-picture',
	array(
		'title'         => __( 'Header with circle logo or profile picture', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|15"}},"layout":{"type":"flex","flexWrap":"nowrap"},"twStretchedLink":true} --><div class="wp-block-group tw-stretched-link"><!-- wp:site-logo {"width":52,"isLink":false,"className":"is-style-rounded","twWidthMobile":40} /--><!-- wp:site-title {"level":0} /--></div><!-- /wp:group --><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet"} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-with-left-navigation-and-social-icons',
	array(
		'title'      => __( 'Header with left navigation and social icons', 'twentig' ),
		'categories' => array( 'header' ),
		'blockTypes' => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'    => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} --><div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /--><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet","layout":{"type":"flex","justifyContent":"space-between"},"style":{"layout":{"selfStretch":"fill","flexSize":null}}} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:social-links {"iconColor":"constrast","size":"has-small-icon-size","iconColorValue":"var(--wp--preset--color--constrast)","className":"is-style-logos-only","twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-with-left-navigation-and-button',
	array(
		'title'         => __( 'Header with left navigation and button', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} --><div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /--><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet","layout":{"type":"flex","justifyContent":"space-between"},"style":{"layout":{"selfStretch":"fill","flexSize":null}}} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Button', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-with-left-navigation-and-search',
	array(
		'title'         => __( 'Header with left navigation and search', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} --><div class="wp-block-group alignwide"><!-- wp:site-title {"level":0} /--><!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"var:preset|spacing|35"}},"twBreakpoint":"tablet","layout":{"type":"flex","justifyContent":"space-between"},"style":{"layout":{"selfStretch":"fill","flexSize":null}}} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:search {"showLabel":false,"placeholder":"Search","width":230,"widthUnit":"px","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"className":"is-style-tw-underline","style":{"border":{"color":"#80808066"}}} /--><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/header-stack-center',
	array(
		'title'         => __( 'Header stack: center', 'twentig' ),
		'categories'    => array( 'header' ),
		'blockTypes'    => array( 'core/template-part/header' ),
		'viewportWidth' => 1280,
		'content'       => '<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} --><div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fill","flexSize":null}},"className":"tw-sm-justify-start","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} --><div class="wp-block-group tw-sm-justify-start"><!-- wp:site-title {"level":0,"fontSize":"large"} /--></div><!-- /wp:group --><!-- wp:spacer {"height":"0","width":"0px","className":"tw-sm-hidden","style":{"layout":{"flexSize":"100%","selfStretch":"fixed"}}} --><div style="height:0;width:0px" aria-hidden="true" class="wp-block-spacer tw-sm-hidden"></div><!-- /wp:spacer --><!-- wp:navigation {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|35"},"layout":{"selfStretch":"fill","flexSize":null}}} --><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);
