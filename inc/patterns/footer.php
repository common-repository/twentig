<?php
/**
 * Footer block patterns.
 *
 * @package twentig
 */

$copyright    = esc_html_x( '© 2024. Made with Twentig.', 'Block pattern content', 'twentig' );
$social       = '<!-- wp:social-link {"url":"#","service":"twitter"} /--><!-- wp:social-link {"url":"#","service":"instagram"} /--><!-- wp:social-link {"url":"#","service":"linkedin"} /-->';
$nav_links    = '<!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /--><!-- wp:navigation-link {"isTopLevelLink":true} /-->';
$vertical_nav = '<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var:preset|spacing|15"}},"fontSize":"small"} -->' . $nav_links . '<!-- /wp:navigation -->';

twentig_register_block_pattern(
	'twentig/footer-inline-copyright-and-navigation',
	array(
		'title'      => __( 'Footer inline: copyright and navigation', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"full","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group alignfull"><!-- wp:paragraph {"fontSize":"small"} --><p class="has-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --><!-- wp:navigation {"overlayMenu":"never","fontSize":"small"} -->' . $nav_links . '<!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-inline-copyright-and-social-links',
	array(
		'title'         => __( 'Footer inline: copyright and social links', 'twentig' ),
		'categories'    => array( 'footer' ),
		'blockTypes'    => array( 'core/template-part/footer' ),
		'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"wide","layout":{"type":"flex","allowOrientation":false,"justifyContent":"space-between"}} --><div class="wp-block-group alignwide"><!-- wp:paragraph {"fontSize":"small"} --><p class="has-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --><!-- wp:social-links {"iconColor":"constrast","iconColorValue":"var(--wp--preset--color--constrast)","size":"has-small-icon-size","className":"is-style-logos-only","layout":{"type":"flex"},"twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only tw-hover-opacity-down"><!-- wp:social-link {"url":"#","service":"twitter"} /--><!-- wp:social-link {"url":"#","service":"instagram"} /--><!-- wp:social-link {"url":"#","service":"facebook"} /--></ul><!-- /wp:social-links --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-inline-2-rows',
	array(
		'title'      => __( 'Footer inline: 2 rows', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"backgroundColor":"contrast","textColor":"base"} --><div class="wp-block-group has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group"><!-- wp:site-title {"level":0} /--><!-- wp:social-links {"iconColor":"base","iconColorValue":"var(--wp--preset--color--base)","size":"has-small-icon-size","className":"is-style-logos-only","twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --></div><!-- /wp:group --><!-- wp:group {"style":{"border":{"top":{"color":"#80808066","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|30"},"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group" style="border-top-color:#80808066;border-top-width:1px;margin-top:var(--wp--preset--spacing--30);padding-top:var(--wp--preset--spacing--30)"><!-- wp:paragraph {"fontSize":"small"} --><p class="has-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --><!-- wp:navigation {"overlayMenu":"never","className":"tw-sm-order-first","fontSize":"small"} -->' . $nav_links . '<!-- /wp:navigation --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-stack-social-links',
	array(
		'title'      => __( 'Footer stack: social icons', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} --><div class="wp-block-group has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:social-links {"iconColor":"base","iconColorValue":"var(--wp--preset--color--base)","customIconBackgroundColor":"contrast-2","iconBackgroundColorValue":"var(--wp--preset--color--contrast-2)","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|20","left":"var:preset|spacing|20"}}},"layout":{"type":"flex","justifyContent":"center"},"twHover":"opacity-down"} --><ul class="wp-block-social-links has-icon-color has-icon-background-color tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --><!-- wp:paragraph {"align":"center","fontSize":"x-small"} --><p class="has-text-align-center has-x-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-2-columns-text-and-navigation',
	array(
		'title'      => __( 'Footer 2 columns: text and navigation', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|35","left":"8%"}}}} --><div class="wp-block-columns alignwide"><!-- wp:column {"layout":{"type":"constrained","justifyContent":"left","contentSize":"440px"}} --><div class="wp-block-column"><!-- wp:site-logo /--><!-- wp:paragraph {"fontSize":"small"} --><p class="has-small-font-size">16 Thompson Street<br>San Francisco, CA 94102</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"width":"200px"} --><div class="wp-block-column" style="flex-basis:200px">' . $vertical_nav . '</div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex"}} --><div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"fontSize":"x-small"} --><p class="has-x-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-2-columns-text-and-social-icons',
	array(
		'title'      => __( 'Footer 2 columns: text and social icons', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} --><div class="wp-block-group has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} --><div class="wp-block-columns alignwide"><!-- wp:column {"width":"440px","layout":{"type":"constrained","justifyContent":"left"}} --><div class="wp-block-column" style="flex-basis:440px"><!-- wp:site-title {"level":0} /--><!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"fontSize":"small"} --><p class="has-small-font-size" style="margin-top:var(--wp--preset--spacing--30)">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Duis aute irure dolor in reprehenderit in voluptate.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:social-links {"iconColor":"base","iconColorValue":"var(--wp--preset--color--base)","customIconBackgroundColor":"contrast-2","iconBackgroundColorValue":"var(--wp--preset--color--contrast-2)","size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|20","left":"var:preset|spacing|20"}}},"className":"tw-sm-justify-start","layout":{"type":"flex","justifyContent":"right"},"twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color has-icon-background-color tw-sm-justify-start tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --></div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap"}} --><div class="wp-block-group alignwide"><!-- wp:paragraph {"fontSize":"x-small"} --><p class="has-x-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-3-columns-social-icons-and-navigations',
	array(
		'title'      => __( 'Footer 3 columns: social icons and navigations', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|40"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} --><div class="wp-block-group has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40"}}}} --><div class="wp-block-columns alignwide"><!-- wp:column --><div class="wp-block-column"><!-- wp:site-title {"level":0} /--><!-- wp:social-links {"iconColor":"base","iconColorValue":"var(--wp--preset--color--base)","customIconBackgroundColor":"contrast-2","iconBackgroundColorValue":"var(--wp--preset--color--contrast-2)","size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|20","left":"var:preset|spacing|20"}}},"twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color has-icon-background-color tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --></div><!-- /wp:column --><!-- wp:column {"width":"400px"} --><div class="wp-block-column" style="flex-basis:400px"><!-- wp:columns {"twStack":"sm-2"} --><div class="wp-block-columns tw-cols-stack-sm-2"><!-- wp:column --><div class="wp-block-column">' . $vertical_nav . '</div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column">' . $vertical_nav . '</div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex"}} --><div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"fontSize":"x-small"} --><p class="has-x-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/footer-4-columns-navigations',
	array(
		'title'      => __( 'Footer 4 columns: navigations', 'twentig' ),
		'categories' => array( 'footer' ),
		'blockTypes' => array( 'core/template-part/footer' ),
		'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40"}}},"twStack":"sm-2"} --><div class="wp-block-columns alignwide tw-cols-stack-sm-2"><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|25"}}} --><div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="wp-block-heading has-medium-font-size">' . esc_html_x( 'About', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading -->' . $vertical_nav . '</div><!-- /wp:column --><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|25"}}} --><div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="wp-block-heading has-medium-font-size">' . esc_html_x( 'Info', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading -->' . $vertical_nav . '</div><!-- /wp:column --><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|25"}}} --><div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="wp-block-heading has-medium-font-size">' . esc_html_x( 'Careers', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading -->' . $vertical_nav . '</div><!-- /wp:column --><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|25"}}} --><div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="wp-block-heading has-medium-font-size">' . esc_html_x( 'Contact', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading -->' . $vertical_nav . '</div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"fontSize":"x-small"} --><p class="has-x-small-font-size">' . $copyright . '</p><!-- /wp:paragraph --><!-- wp:social-links {"iconColor":"contrast","iconColorValue":"var(--wp--preset--color--contrast)","size":"has-small-icon-size","className":"is-style-logos-only","twHover":"opacity-down"} --><ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only tw-hover-opacity-down">' . $social . '</ul><!-- /wp:social-links --></div><!-- /wp:group --></div><!-- /wp:group -->',
	)
);
