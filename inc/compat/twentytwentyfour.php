<?php
/**
 * Functionalities for Twenty Twenty-Four.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooks into the data provided by the theme to change settings.
 */
function twentig_twentyfour_filter_theme_json( $theme_json ) {

	$new_data = array(
		'version'  => 2,
		'settings' => array(
			'typography' => array(
				'fluid' => array(
					'minFontSize' => '18px'
				)
			),
		),
	);
	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'twentig_twentyfour_filter_theme_json' );

/**
 * Adds support for Twentig website templates.
 */
function twentig_twentyfour_theme_support() {

	$template_path = TWENTIG_PATH . 'dist/templates/';
	$template_uri  = TWENTIG_URI . 'dist/templates/';

	$website_templates = array(
		array(
			'title'      => __( 'Business', 'twentig' ),
			'screenshot' => esc_url( $template_uri . 'tt4-default.webp' ),
			'file'       => $template_path . 'tt4-default.xml',
			'url'        => 'https://demo.twentig.com/tt4-default/',
			'options'    => array(
				'front_page'     => 'Home',
				'blog_page'      => 'Blog',
				'posts_per_page' => 12,
				'spacing'        => true,
			),
		),
		array(
			'title'      => __( 'Blog', 'twentig' ),
			'screenshot' => esc_url( $template_uri . 'tt4-blog.webp' ),
			'file'       => $template_path . 'tt4-blog.xml',
			'url'        => 'https://demo.twentig.com/tt4-blog/',
			'options'    => array(
				'front_page'     => 'posts',
				'posts_per_page' => 10,
				'spacing'        => true,
			),
		),
		array(
			'title'      => __( 'Personal', 'twentig' ),
			'screenshot' => esc_url( $template_uri . 'tt4-personal.png' ),
			'file'       => $template_path . 'tt4-personal.xml',
			'url'        => 'https://demo.twentig.com/tt4-personal/',
			'options'    => array(
				'front_page'     => 'Home',
				'blog_page'      => 'Blog',
				'posts_per_page' => 10,
				'spacing'        => true,
			),
		),
		array(
			'title'      => __( 'Portfolio', 'twentig' ),
			'screenshot' => esc_url( $template_uri . 'tt4-portfolio.png' ),
			'file'       => $template_path . 'tt4-portfolio.xml',
			'url'        => 'https://demo.twentig.com/tt4-portfolio/',
			'options'    => array(
				'front_page'     => 'Work',
				'blog_page'      => 'Blog',
				'posts_per_page' => 10,
				'spacing'        => true,
				'portfolio'      => true,
			),
		),
	);
	add_theme_support( 'twentig-starter-website-templates', $website_templates );
}
add_action( 'after_setup_theme', 'twentig_twentyfour_theme_support' );
