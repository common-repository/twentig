<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders out the shape style and SVG.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_render_shape_support( $block_content, $block ) {

	if ( ! empty( $block['attrs']['twShape'] ) ) {
		$shape            = $block['attrs']['twShape'];
		$action_hook_name = wp_is_block_theme() ? 'wp_body_open' : 'wp_footer';

		add_action(
			$action_hook_name,
			function() use ( $shape ) {
				twentig_enqueue_shape_svg( $shape );
			},
			11 
		);
		
		$tag_processor = new WP_HTML_Tag_Processor( $block_content );
		$tag_processor->next_tag();

		$style_attr = $tag_processor->get_attribute( 'style' );
		$style      = "--shape:url(#tw-shape-$shape);";
		$style     .= $style_attr;

		$tag_processor->set_attribute( 'style', esc_attr( $style ) );

		$block_content = $tag_processor->get_updated_html();
	}
	return $block_content;
}
add_filter( 'render_block_core/image', 'twentig_render_shape_support', 10, 2 );
add_filter( 'render_block_core/cover', 'twentig_render_shape_support', 10, 2 );
add_filter( 'render_block_core/post-featured-image', 'twentig_render_shape_support', 10, 2 );

/**
 * Returns the shapes with their path.
 */
function twentig_get_shapes() {

	$shapes = array(
		'diamond'          => '<path d="M.9393.6464.6464.9393a.207.207 0 0 1-.2929 0L.0607.6464a.207.207 0 0 1 0-.2929L.3536.0606a.207.207 0 0 1 .2929 0l.2929.2929a.2072.2072 0 0 1-.0001.2929z"/>',
		'squircle'         => '<path d="M0 .5C0 .08.08 0 .5 0s.5.08.5.5-.08.5-.5.5S0 .92 0 .5z"/>',
		'organic-square'   => '<path d="M.602.042.637.027a.256.256 0 0 1 .336.336L.958.398a.256.256 0 0 0 0 .204l.015.035a.256.256 0 0 1-.336.336L.602.958a.256.256 0 0 0-.204 0L.363.973A.256.256 0 0 1 .027.637L.042.602a.256.256 0 0 0 0-.204L.027.363A.256.256 0 0 1 .363.027l.035.015a.256.256 0 0 0 .204 0Z"/>',
		'star-1'           => '<path d="M.3628.0418a.246.246 0 0 1 .2744 0A.246.246 0 0 0 .727.079a.246.246 0 0 1 .194.194.246.246 0 0 0 .0372.09.246.246 0 0 1 0 .2744A.246.246 0 0 0 .921.727a.246.246 0 0 1-.194.194.246.246 0 0 0-.09.0372.246.246 0 0 1-.2744 0A.246.246 0 0 0 .273.921.246.246 0 0 1 .079.727a.246.246 0 0 0-.0372-.09.246.246 0 0 1 0-.2744A.246.246 0 0 0 .079.273.246.246 0 0 1 .273.079.246.246 0 0 0 .3628.0418Z"/>',
		'star-2'           => '<path d="m.4031.0393.0462-.026a.1034.1034 0 0 1 .1015 0l.0461.026a.1034.1034 0 0 0 .05.0133l.0525.0005a.1034.1034 0 0 1 .0879.0508l.027.0456a.1034.1034 0 0 0 .0363.0363l.0456.027a.1034.1034 0 0 1 .0507.0878l.0005.0529a.1034.1034 0 0 0 .0133.05l.026.0461a.1034.1034 0 0 1 0 .1015l-.026.0458a.1034.1034 0 0 0-.0133.05L.9469.6994a.1034.1034 0 0 1-.0508.0879L.8506.8142a.1034.1034 0 0 0-.0364.0364L.7873.8961a.1034.1034 0 0 1-.0879.0508L.6465.9474a.1034.1034 0 0 0-.05.0133l-.0458.026a.1034.1034 0 0 1-.1015 0L.4031.9607a.1034.1034 0 0 0-.05-.0133L.3006.9469A.1034.1034 0 0 1 .2127.8961L.1858.8506A.1034.1034 0 0 0 .1494.8142L.1039.7873A.1034.1034 0 0 1 .0531.6994L.0526.6465a.1034.1034 0 0 0-.0133-.05L.0133.5507a.1034.1034 0 0 1 0-.1015l.026-.0461a.1034.1034 0 0 0 .0133-.05L.0531.3006A.1034.1034 0 0 1 .1039.2127L.1494.1858A.1034.1034 0 0 0 .1858.1494L.2127.1039A.1034.1034 0 0 1 .3006.0531L.3535.0526A.1034.1034 0 0 0 .4031.0393Z"/>',
		'star-3'           => '<path d="M.4257.0293.4683.0076a.07.07 0 0 1 .0635 0l.0425.0217a.07.07 0 0 0 .0372.0075L.6591.033a.07.07 0 0 1 .0586.0243l.031.0363A.07.07 0 0 0 .78.1147l.0457.0147a.07.07 0 0 1 .0449.0449L.8853.22a.07.07 0 0 0 .0211.0313l.0363.031A.07.07 0 0 1 .967.3409L.9632.3885a.07.07 0 0 0 .0075.0372l.0217.0426a.07.07 0 0 1 0 .0635L.9707.5743a.07.07 0 0 0-.0075.0372L.967.6591a.07.07 0 0 1-.0243.0586l-.0363.031A.07.07 0 0 0 .8853.78L.8706.8257a.07.07 0 0 1-.0449.0449L.78.8853a.07.07 0 0 0-.0313.0211l-.031.0363A.07.07 0 0 1 .6591.967L.6115.9632a.07.07 0 0 0-.0372.0075L.5317.9924a.07.07 0 0 1-.0635 0L.4257.9707A.07.07 0 0 0 .3885.9632L.3409.967A.07.07 0 0 1 .2823.9427L.2513.9064A.07.07 0 0 0 .22.8853L.1743.8706A.07.07 0 0 1 .1294.8257L.1147.78A.07.07 0 0 0 .0936.7487L.0573.7177A.07.07 0 0 1 .033.6591L.0368.6115A.07.07 0 0 0 .0293.5743L.0076.5317a.07.07 0 0 1 0-.0635L.0293.4257A.07.07 0 0 0 .0368.3885L.033.3409A.07.07 0 0 1 .0573.2823l.0363-.031A.07.07 0 0 0 .1147.22L.1294.1743A.07.07 0 0 1 .1743.1294L.22.1147A.07.07 0 0 0 .2513.0936l.031-.0363A.07.07 0 0 1 .3409.033l.0476.0038A.07.07 0 0 0 .4257.0293Z"/>',
		'organic-circle-1' => '<path d="M.9916.6255a.381.381 0 0 1-.1051.1972C.832.8774.7712.9196.7039.9495S.566.996.4917.9995a.3642.3642 0 0 1-.207-.0511C.221.9107.1665.8639.1212.8077S.0423.688.0204.617-.0058.4731.0077.3986.054.2593.1064.2046.2168.102.2804.0608.4149-.0007.4927 0s.1518.0174.2218.0501.1238.0821.1613.1481c.0375.0661.0701.1346.0976.2057s.0337.1449.0182.2216z"/>',
		'organic-circle-2' => '<path d="M.9952.6114a.4448.4448 0 0 1-.0839.2085C.8653.8825.8062.9268.7339.9527S.588.9941.513.9992C.4379 1.0042.3686.9866.3048.9463S.1816.8595.1264.8069.034.6895.0149.6125-.0049.4581.0128.3803.068.2381.1253.187.2428.0902.3058.0498s.1317-.0562.206-.0475.1435.0295.2072.0626.1179.0781.1625.135c.0446.0569.0772.1206.0977.1912s.0259.144.016.2203z"/>',
		'organic-circle-3' => '<path d="M.9891.6044A.416.416 0 0 1 .8852.799C.8333.8541.7749.9018.71.9419s-.1363.0595-.2141.058S.3456.9795.2785.943.1534.8591.1044.8011.0236.6771.0092.6033-.0027.4568.0168.3851.0683.248.113.1885.2143.0846.2828.0552.423.0079.498.0015s.1464.0079.2141.043.1233.0828.1666.1429C.922.2476.9555.3135.9793.3852s.0271.1447.0098.2192z"/>',
		'organic-circle-4' => '<path d="M.9918.6317a.406.406 0 0 1-.0864.2076C.8571.9005.797.9424.7252.965S.5812.9992.5086 1 .3636.9898.291.9672.163.9002.1246.8339.0528.698.0244.6251-.0076.4776.0137.4011.0677.2536.1118.188.2135.0725.2846.0383.4293-.0072.5054.0044.654.0361.723.0645s.1301.0714.1835.1289.0832.1257.0896.2044.005.1567-.0043.2339z"/>',
		'flower-1'         => '<path d="M1 .3A.3.3 0 0 0 .5.0765.3.3 0 0 0 .0765.5.3.3 0 0 0 .5.9235.3.3 0 0 0 .9235.5.2986.2986 0 0 0 1 .3z"/>',
		'flower-2'         => '<path d="M1 .3757A.2.2 0 0 0 .8229.1771.2.2 0 0 0 .5.0435a.2.2 0 0 0-.3229.1336A.2.2 0 0 0 .0435.5a.2.2 0 0 0 .1336.3229A.2.2 0 0 0 .5.9565.2.2 0 0 0 .8229.8229.2.2 0 0 0 .9565.5.1987.1987 0 0 0 1 .3757z"/>',
		'flower-3'         => '<path d="M.96.5A.1.1 0 0 0 .9254.3238a.1.1 0 0 0-.0863-.15L.8255.1745.8266.1609a.1.1 0 0 0-.15-.0863A.1.1 0 0 0 .5.04a.1.1 0 0 0-.1762.035.1.1 0 0 0-.15.0863l.001.0135L.1609.1734a.1.1 0 0 0-.0863.15A.1.1 0 0 0 .04.5a.1.1 0 0 0 .035.1762.1.1 0 0 0 .0863.15L.1745.8255.1734.8391a.1.1 0 0 0 .15.0863A.1.1 0 0 0 .5.96.1.1 0 0 0 .6762.9254a.1.1 0 0 0 .15-.0863L.8255.8255l.0135.001a.1.1 0 0 0 .0863-.15A.1.1 0 0 0 .96.5Z"/>',
		'peanut-1'         => '<path d="M1 .3A.3.3 0 0 0 .7 0H.3a.3.3 0 0 0-.2235.5A.3.3 0 0 0 .3 1h.4A.3.3 0 0 0 .9235.5.2988.2988 0 0 0 1 .3Z"/>',
		'peanut-2'         => '<path d="M.3 0a.3.3 0 0 0-.3.3v.4a.3.3 0 0 0 .5.2235A.3.3 0 0 0 1 .7V.3A.3.3 0 0 0 .5.0765.2988.2988 0 0 0 .3 0Z"/>',
		'hourglass-1'      => '<path d="M1 0H0v.3a.2988.2988 0 0 0 .0765.2A.2988.2988 0 0 0 0 .7V1h1V.7A.2988.2988 0 0 0 .9235.5.2988.2988 0 0 0 1 .3Z"/>',
		'hourglass-2'      => '<path d="M1 1V0H.7a.2988.2988 0 0 0-.2.0765A.2988.2988 0 0 0 .3 0H0v1h.3A.2988.2988 0 0 0 .5.9235.2988.2988 0 0 0 .7 1Z"/>',
		'hourglass-3'      => '<path d="M1 0H.7a.2986.2986 0 0 0-.2.0765A.2986.2986 0 0 0 .3 0H0v.3c0 .0768.0289.1469.0765.2A.2986.2986 0 0 0 0 .7V1h.3A.2986.2986 0 0 0 .5.9235.2986.2986 0 0 0 .7 1H1V.7A.2986.2986 0 0 0 .9235.5.2986.2986 0 0 0 1 .3V0z"/>',
		'cut-corners'      => '<path d="M.076 0 0 .076v.848L.076 1h.848L1 .924V.076L.924 0H.076z"/>',
	);

	return apply_filters( 'twentig_shapes', $shapes );
}

/**
 * Enqueues the shape to print the SVG.
 * 
 * @param string $shape The selected shape.
 */
function twentig_enqueue_shape_svg( $shape ) {
	global $tw_shapes;

	if ( ! isset( $tw_shapes ) ) {
		$tw_shapes = array();
	}

	if ( ! in_array( $shape, $tw_shapes, true ) ) {
		$tw_shapes[] = $shape;
		echo twentig_render_shape_svg( $shape );
	}
}

/**
  * Add styles and SVGs for use in the editor via the EditorStyles component.
  *
  * @see wp-includes/block-supports/duotone.php
*/
function twentig_add_shapes_svg_editor_settings( $settings ) {
	if ( ! isset( $settings['styles'] ) ) {
		$settings['styles'] = array();
	}

	$svgs   = '';
	$shapes = twentig_get_shapes();
	
	foreach ( $shapes as $shape => $path ) {
		$svgs .= twentig_render_shape_svg( $shape, 'editor' );
	}

	$settings['styles'][] = array(
		// For the editor we can add all of the presets by default.
		'assets'         => $svgs,
		// The 'svgs' type is new in 6.3 and requires the corresponding JS changes in the EditorStyles component to work.
		'__unstableType' => 'svgs',
		// These styles not generated by global styles, so this must be false or they will be stripped out in wp_get_block_editor_settings.
		'isGlobalStyles' => false,
	);

	return $settings;
}
add_filter( 'block_editor_settings_all', 'twentig_add_shapes_svg_editor_settings', 10 );

/**
 * Prints the shape's SVG.
 *
 * @param string $shape The selected shape.
 */
function twentig_render_shape_svg( $shape, $env = 'front' ) {

	$shapes = twentig_get_shapes();
	$path   = $shapes[$shape] ?? '';

	if ( $path ) {
		$style = 'position:absolute;left:-9999px;overflow:hidden;';
		if ( 'editor' === $env ) {
			$style .= 'visibility:visible;';
		}

		return '
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 0 0"
			width="0"
			height="0"
			focusable="false"
			role="none"
			style="' . esc_attr( $style ) . '"
		><defs><clipPath id="tw-shape-' . esc_attr( $shape ) . '" clipPathUnits="objectBoundingBox">' . $path . '</clipPath></defs></svg>';
	}
}

/**
 * Renders out the shape CSS for the group block.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_render_group_shape_support( $block_content, $block ) {

	if ( ! wp_is_block_theme() ) {
		return $block_content;
	}

	if ( ! empty( $block['attrs'] ) ) {
		if ( isset( $block['attrs']['twTopShape'] ) ) {
			twentig_enqueue_group_shape_css( $block['attrs']['twTopShape'] );
		}
		if ( isset( $block['attrs']['twBottomShape'] ) ) {
			twentig_enqueue_group_shape_css( $block['attrs']['twBottomShape'] );
		}
	}
	return $block_content;
}
add_filter( 'render_block_core/group', 'twentig_render_group_shape_support', 10, 2 );

/**
 * Enqueues the CSS of the shape.
 * 
 *  @param string $shape The selected shape.
 */
function twentig_enqueue_group_shape_css( $shape ) {
	global $tw_group_shapes;

	$css = '';

	if ( ! isset( $tw_group_shapes ) ) {
		$tw_group_shapes = array();
		$css            .= '
		.wp-block-group[class*=tw-bottom-shape],
		.wp-block-group[class*=tw-top-shape] {
			position: relative;
		}

		[class*=tw-top-shape]::before,
		[class*=tw-bottom-shape]::after {
			content: "";
			position: absolute;
			width: 100%;
			height: var(--group-shape-height, 20px);
			left: 0;
			bottom: var(--group-shape-y, -14px);
			background-color: inherit;
			-webkit-mask: var(--group-shape) center repeat no-repeat;
			mask: var(--group-shape) center repeat no-repeat;
			z-index: 2;
			pointer-events: auto;
		}

		[class*=tw-top-shape]::before {
			-webkit-transform: rotate(180deg);
			transform: rotate(180deg);
			bottom: auto;
			top: var(--group-shape-y,-14px);
		}';
	}

	if ( ! in_array( $shape, $tw_group_shapes, true ) ) {
		$tw_group_shapes[] = $shape;
		$css              .= twentig_get_group_shape_css( $shape );
	}

	if ( $css ) {
		wp_add_inline_style( 'wp-block-group', twentig_minify_css( $css ) );
	}
}

/**
 * Returns the CSS for a shape.
 * 
 *  @param string $shape The selected shape.
 */
function twentig_get_group_shape_css( $shape ) {

	$shapes = array(
		'organic'   => array(
			'url' => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 768 20'%3e%3cpath d='M768 0H0v12c25.5-.6 50 .6 75.5 1.4 19.2.7 25.4 2.2 37.5 3.5 12.7 1.4 25.4 2.2 38.1 2.8 12.3.7 24.6 0 37 0s25-1 37.4-1.4c24.9-.6 49.8-1.8 74.5-4.9 24.8-3 59-6.6 84-6.6 12.6 0 17.4 0 30 .9 12.8 1 24.5 1 37.3 2 11 1 13.6 1.1 19.4 1.5 6 .3 10.1.3 16.2.7 12.6 1 25.2.9 37.9 1.4 25 1 37.3-1.3 62.4.9 14 1.2 45.7 4.3 59.8 4.4 13.2 0 24.4-1 37.6-1 14.6-.3 26.4-.4 41-2.2 14.1-1.7 28.1-3 42.4-3.4z'/%3e%3c/svg%3e",
		),
		'grunge'    => array(
			'url'    => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 160 20'%3e%3cpath d='M160 0H0v17.8a15.3 15.3 0 015 2s9.1-1 11.8-.8c3.5.2 11.1-1.1 11.1-1.1s3.9.7 4.2.6c6.2-1.6 19.1 1.2 19.1 1.2l3.8-1.6c8 .8 9.5-1.3 21 .8 2.3-.6 8.2-2.1 11-2.3 2 0 3.5 1.4 5.4 1.8 1.6.3 4.1-.7 5.7-.5 3.5.4 8.1 1.2 12 0a18.6 18.6 0 0110.5-.3 24.9 24.9 0 009.3 0l7.6 2.4s6.6-2 10-1.5c7.7 1 8.2.5 10.6-.6 1.5.4 1.2 0 1.9-.1z'/%3e%3c/svg%3e",
			'offset' => '-4px',
		),
		'wave'      => array(
			'url' => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 102 20'%3e%3cpath d='M102 20c-13.7 0-20.6-3.8-27.3-7.5C68.6 9.2 62.8 6 51 6s-17.6 3.2-23.7 6.5C20.6 16.2 13.7 20 0 20V0h102z'/%3e%3c/svg%3e",
		),
		'triangle'  => array(
			'url' => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 20'%3e%3cpath d='M48 6L24 20 0 6V0h48v6z'/%3e%3c/svg%3e",
		),
		'arc'       => array(
			'url'    => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 20'%3e%3ccircle cx='24' cy='-14' r='34'/%3e%3c/svg%3e",
			'offset' => '-10px',
		),
		'rectangle' => array(
			'url'    => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 20'%3e%3cpath d='M0 0v14h8v6h16v-6h8V0H0z'/%3e%3c/svg%3e",
			'offset' => '-6px',
		),
		'ornament'  => array(
			'url'    => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 160 20'%3e%3cpath d='M160 20c-4.2-4.5-13.6-7-19.3-7-14.7 0-28.3 7-41.5 7-7.6 0-14.6-2-19.2-7-4.6 5-11.6 7-19.2 7-13.2 0-26.8-7-41.5-7-5.7 0-15.1 2.5-19.3 7V0h160v20z'/%3e%3c/svg%3e",
			'offset' => '-7px',
		),
		'halftone'  => array(
			'url'    => "data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 5 20'%3e%3ccircle cx='2.5' cy='4.5' r='2.5'/%3e%3ccircle cx='2.5' cy='-.19' r='2.81'/%3e%3ccircle cx='2.5' cy='14.38' r='1.38'/%3e%3ccircle cx='2.5' cy='19.25' r='.75'/%3e%3ccircle cx='2.5' cy='9.5' r='2'/%3e%3c/svg%3e",
			'offset' => '-19px',
		),
	);
	
	$path = $shapes[ $shape ] ?? '';

	$css = '';
	
	if ( $path && isset( $path['url'] ) ) {
		$url = $path['url'];
		$css = '
		.tw-bottom-shape-' . $shape . '::after,
		.tw-top-shape-' . $shape . '::before {
			--group-shape:url("' . $url . '");';

		if ( isset( $path['offset'] ) ) {
			$css .= '--group-shape-y:' . $path['offset'] . ';';
		}
		$css .= '}';
	}
	return $css;
}
