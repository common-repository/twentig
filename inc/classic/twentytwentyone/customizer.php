<?php
/**
 * Customizer
 *
 * @package twentig
 */

/**
 * Register custom control types.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentig_twentyone_register_control_types( $wp_customize ) {
	$tools_path = TWENTIG_PATH . 'inc/classic/theme-tools/';
	require $tools_path . 'class-twentig-customize-checkbox-multiple-control.php';
	require $tools_path . 'class-twentig-customize-select-optgroup-control.php';
	require $tools_path . 'class-twentig-customize-dropdown-pages-private-control.php';
	require $tools_path . 'class-twentig-customize-dropdown-reusable-blocks-control.php';
	require $tools_path . 'class-twentig-customize-font-presets-control.php';
	require $tools_path . 'class-twentig-customize-title-control.php';
	require $tools_path . 'class-twentig-customize-range-control.php';
	require $tools_path . 'class-twentig-customize-starter-control.php';
	require $tools_path . 'class-twentig-customize-more-section.php';
	$wp_customize->register_section_type( 'Twentig_Customize_Range_Control' );
	$wp_customize->register_section_type( 'Twentig_Customize_Title_Control' );
	$wp_customize->register_section_type( 'Twentig_Customize_More_Section' );
}
add_action( 'customize_register', 'twentig_twentyone_register_control_types' );

/**
 * Add new Customizer parameters.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentig_twentyone_customize_register( $wp_customize ) {

	/*
	 * Site Identity
	 */
	$wp_customize->add_setting(
		'twentig_custom_logo_alt',
		array(
			'theme_supports' => array( 'custom-logo' ),
		)
	);

	$custom_logo_args = get_theme_support( 'custom-logo' );
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'twentig_custom_logo_alt',
			array(
				'label'         => esc_html__( 'Alternate Logo', 'twentig' ),
				'description'   => esc_html__( 'White version of the logo for transparent header and footer with dark background.', 'twentig' ),
				'section'       => 'title_tagline',
				'priority'      => 9,
				'height'        => isset( $custom_logo_args[0]['height'] ) ? $custom_logo_args[0]['height'] : null,
				'width'         => isset( $custom_logo_args[0]['width'] ) ? $custom_logo_args[0]['width'] : null,
				'flex_height'   => isset( $custom_logo_args[0]['flex-height'] ) ? $custom_logo_args[0]['flex-height'] : null,
				'flex_width'    => isset( $custom_logo_args[0]['flex-width'] ) ? $custom_logo_args[0]['flex-width'] : null,
				'button_labels' => array(
					'select'       => esc_html__( 'Select logo' ),
					'change'       => esc_html__( 'Change logo' ),
					'remove'       => esc_html__( 'Remove' ),
					'default'      => esc_html__( 'Default' ),
					'placeholder'  => esc_html__( 'No logo selected' ),
					'frame_title'  => esc_html__( 'Select logo' ),
					'frame_button' => esc_html__( 'Choose logo' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_hide_tagline',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_hide_tagline',
		array(
			'label'    => esc_html__( 'Hide Tagline', 'twentig' ),
			'type'     => 'checkbox',
			'section'  => 'title_tagline',
			'priority' => 10,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'twentig_hide_tagline',
		array(
			'selector'            => '.site-description',
			'render_callback'     => 'twentig_twentyone_partial_tagline',
			'container_inclusive' => true,
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_width',
			array(
				'label'       => esc_html__( 'Logo Width (px)', 'twentig' ),
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => 20,
					'max'  => 300,
					'step' => 10,
				),
				'priority'    => 11,
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_width_mobile',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_width_mobile',
			array(
				'label'       => esc_html__( 'Logo Width on Mobile (px)', 'twentig' ),
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => 20,
					'max'  => 300,
					'step' => 10,
				),
				'priority'    => 12,
			)
		)
	);

	/*
	 * Colors
	 */

	// Get the palette from theme-supports.
	$palette        = get_theme_support( 'editor-color-palette' );
	$palette_colors = array();
	if ( isset( $palette[0] ) && is_array( $palette[0] ) ) {
		foreach ( $palette[0] as $palette_color ) {
			$palette_colors[] = $palette_color['color'];
		}
	}

	$wp_customize->add_setting(
		'twentig_inner_background_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new Twenty_Twenty_One_Customize_Color_Control(
			$wp_customize,
			'twentig_inner_background_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Inner Background Color', 'twentig' ),
				'palette' => $palette_colors,
			)
		)
	);

	$colors = array(
		array(
			'label' => __( 'Body', 'twentig' ),
			'id'    => 'body',
		),
		array( 'twentig_primary_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_content_link_color', __( 'Content Link Color', 'twentig' ) ),
		array(
			'label' => __( 'Buttons', 'twentig' ),
			'id'    => 'buttons',
		),
		array( 'twentig_button_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_button_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_button_hover_background_color', __( 'Hover Background Color', 'twentig' ) ),
		array(
			'label' => __( 'Header', 'twentig' ),
			'id'    => 'header',
		),
		array( 'twentig_header_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_branding_color', __( 'Site Title Color', 'twentig' ) ),
		array( 'twentig_header_link_color', __( 'Link Color', 'twentig' ) ),
		array( 'twentig_header_link_hover_color', __( 'Link Hover/Active Color', 'twentig' ) ),
		array(
			'label' => __( 'Footer', 'twentig' ),
			'id'    => 'footer',
		),
		array( 'twentig_footer_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_footer_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_footer_link_color', __( 'Link Color', 'twentig' ) ),
		array(
			'label' => __( 'Footer Widgets', 'twentig' ),
			'id'    => 'widgets',
		),
		array( 'twentig_widgets_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_widgets_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_widgets_link_color', __( 'Link Color', 'twentig' ) ),
	);

	foreach ( $colors as $color ) {
		if ( isset( $color['label'] ) ) {
			$wp_customize->add_control(
				new Twentig_Customize_Title_Control(
					$wp_customize,
					'twentig_colors_title_' . sanitize_title( $color['id'] ),
					array(
						'label'    => esc_html__( $color['label'] ),
						'section'  => 'colors',
						'settings' => array(),
					)
				)
			);
		} else {
			$wp_customize->add_setting(
				$color[0],
				array(
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new Twenty_Twenty_One_Customize_Color_Control(
					$wp_customize,
					$color[0],
					array(
						'section' => 'colors',
						'label'   => $color[1],
						'palette' => $palette_colors,
					)
				)
			);
		}
	}

	$wp_customize->get_setting( 'twentig_primary_color' )->transport           = 'postMessage';
	$wp_customize->get_setting( 'twentig_content_link_color' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'twentig_branding_color' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'twentig_header_link_color' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'twentig_header_link_hover_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'twentig_footer_text_color' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'twentig_footer_link_color' )->transport       = 'postMessage';
	$wp_customize->get_setting( 'twentig_widgets_text_color' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'twentig_widgets_link_color' )->transport      = 'postMessage';

	$wp_customize->get_control( 'twentig_colors_title_body' )->priority = -1;

	$wp_customize->add_setting(
		'twentig_subtle_background_color',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/*
	 * Twentig Options Panel
	 */

	$wp_customize->add_panel(
		'twentig_twentytwentyone_panel',
		array(
			'title'    => esc_html__( 'Twentig Options', 'twentig' ),
			'priority' => 150,
		)
	);

	/**
	 * Site Layout
	 */

	$wp_customize->add_section(
		'twentig_layout_section',
		array(
			'title'    => esc_html__( 'Site Layout', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'twentig_site_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_site_width',
			array(
				'label'       => esc_html__( 'Site Max-Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 1200,
					'max'  => 2000,
					'step' => 20,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_default_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 610,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_default_width',
			array(
				'label'       => esc_html__( 'Text Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 600,
					'max'  => 1000,
					'step' => 10,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_wide_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 1240,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_wide_width',
			array(
				'label'       => esc_html__( 'Wide Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 1000,
					'max'  => 1400,
					'step' => 10,
				),
			)
		)
	);

	/*
	 * Fonts
	 */

	$wp_customize->add_section(
		'twentig_fonts_section',
		array(
			'title'    => esc_html__( 'Fonts', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Font_Presets_Control(
			$wp_customize,
			'twentig_font_presets',
			array(
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_body',
			array(
				'label'    => esc_html__( 'Body', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_body_font',
			array(
				'label'   => esc_html__( 'Body Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => esc_html__( 'System UI Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'body', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'body', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font_size',
		array(
			'default'           => 20,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_body_font_size',
			array(
				'label'       => esc_html__( 'Body Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 16,
					'max'  => 22,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_line_height',
		array(
			'default'           => 1.7,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_body_line_height',
			array(
				'label'       => esc_html__( 'Body Line Height', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 2,
					'step' => 0.1,
				),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_headings',
			array(
				'label'    => esc_html__( 'Headings', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_heading_font',
			array(
				'label'   => esc_html__( 'Headings Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => esc_html__( 'System Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'heading', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'heading', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_heading_font_weight',
		array(
			'label'   => esc_html__( 'Headings Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_letter_spacing',
		array(
			'default'           => 0,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_heading_letter_spacing',
			array(
				'label'       => esc_html__( 'Headings Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.05,
					'max'  => 0.05,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_h1_font_size',
		array(
			'default'           => 96,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_h1_font_size',
			array(
				'label'       => esc_html__( 'Page Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 56,
					'max'  => 96,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_tertiary_font',
			array(
				'label'    => esc_html__( 'Secondary Elements', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_secondary_elements_font',
		array(
			'default'           => 'body',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_secondary_elements_font',
		array(
			'label'       => esc_html__( 'Secondary Elements Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'select',
			'choices'     => array(
				'body'    => esc_html__( 'Body Font', 'twentig' ),
				'heading' => esc_html__( 'Headings Font', 'twentig' ),
			),
			'description' => esc_html__( 'Applies to meta, footer, buttons, captions, inputs…', 'twentig' ),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_logo',
			array(
				'label'    => esc_html__( 'Site Title', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_logo_font',
			array(
				'label'   => esc_html__( 'Site Title Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => esc_html__( 'Headings Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'heading', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'heading', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_font_weight',
		array(
			'label'   => esc_html__( 'Site Title Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_size',
		array(
			'transport'         => 'postMessage',
			'default'           => 24,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_font_size',
			array(
				'label'       => esc_html__( 'Site Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 80,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_size_mobile',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_font_size_mobile',
			array(
				'label'       => esc_html__( 'Site Title Font Size on Mobile (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 80,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_letter_spacing',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_letter_spacing',
			array(
				'label'       => esc_html__( 'Site Title Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.1,
					'max'  => 0.1,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_text_transform',
		array(
			'default'           => 'uppercase',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_text_transform',
		array(
			'label'   => esc_html__( 'Site Title Text Transform', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'none'       => esc_html_x( 'None', 'text transform', 'twentig' ),
				'uppercase'  => esc_html__( 'Uppercase', 'twentig' ),
				'lowercase'  => esc_html__( 'Lowercase', 'twentig' ),
				'capitalize' => esc_html__( 'Capitalize', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_menu',
			array(
				'label'    => esc_html__( 'Primary Menu', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font',
		array(
			'default'           => 'body',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_font',
		array(
			'label'   => esc_html__( 'Menu Font', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'body'    => esc_html__( 'Body Font', 'twentig' ),
				'heading' => esc_html__( 'Headings Font', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_font_weight',
		array(
			'label'   => esc_html__( 'Menu Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font_size',
		array(
			'transport'         => 'postMessage',
			'default'           => 20,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_menu_font_size',
			array(
				'label'       => esc_html__( 'Menu Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 14,
					'max'  => 22,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_letter_spacing',
		array(
			'default'           => 0,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_menu_letter_spacing',
			array(
				'label'       => esc_html__( 'Menu Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.1,
					'max'  => 0.1,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_text_transform',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_text_transform',
		array(
			'label'   => esc_html__( 'Menu Text Transform', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html_x( 'None', 'text transform', 'twentig' ),
				'uppercase'  => esc_html__( 'Uppercase', 'twentig' ),
				'lowercase'  => esc_html__( 'Lowercase', 'twentig' ),
				'capitalize' => esc_html__( 'Capitalize', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_hosting',
			array(
				'label'    => esc_html__( 'Font Hosting', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_local_fonts',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_local_fonts',
		array(
			'label'   => esc_html__( 'Host Google Fonts locally', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'checkbox',
		)
	);

	/*
	 * Header
	 */

	$wp_customize->add_section(
		'twentig_header_section',
		array(
			'title'    => esc_html__( 'Header', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_header',
			array(
				'label'    => esc_html__( 'Layout', 'twentig' ),
				'section'  => 'twentig_header_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_header_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_layout',
		array(
			'label'   => esc_html__( 'Header Layout', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''              => esc_html__( 'Default', 'twentig' ),
				'inline-left'   => is_rtl() ? esc_html__( 'Menu on Right', 'twentig' ) : esc_html__( 'Menu on Left', 'twentig' ),
				'inline-center' => esc_html__( 'Centered Menu', 'twentig' ),
				'stack-left'    => is_rtl() ? esc_html_x( 'Stack on Right', 'layout', 'twentig' ) : esc_html_x( 'Stack on Left', 'layout', 'twentig' ),
				'stack-center'  => esc_html_x( 'Centered Stack', 'layout', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_width',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_width',
		array(
			'label'   => esc_html__( 'Header Width', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html_x( 'Wide', 'width', 'twentig' ),
				'full' => esc_html_x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_padding',
		array(
			'transport'         => 'postMessage',
			'default'           => 'large',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_padding',
		array(
			'label'   => esc_html__( 'Header Padding', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => esc_html_x( 'Small', 'width', 'twentig' ),
				'medium' => esc_html_x( 'Medium', 'width', 'twentig' ),
				'large'  => esc_html_x( 'Large', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_sticky',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_sticky',
		array(
			'label'   => esc_html__( 'Sticky Header', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_decoration',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_decoration',
		array(
			'label'   => esc_html__( 'Header Decoration', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => esc_html_x( 'None', 'decoration', 'twentig' ),
				'border' => esc_html__( 'Border', 'twentig' ),
				'shadow' => esc_html__( 'Shadow', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_breakpoint',
		array(
			'default'           => 'mobile',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_breakpoint',
		array(
			'label'   => esc_html__( 'Header Breakpoint', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				'mobile'           => esc_html__( 'Mobile', 'twentig' ),
				'tablet'           => esc_html__( 'Portrait Tablet', 'twentig' ),
				'tablet-landscape' => esc_html__( 'Landscape Tablet', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_menu',
			array(
				'label'       => esc_html__( 'Menu', 'twentig' ),
				'section'     => 'twentig_header_section',
				'description' => sprintf(
					/* translators: link to fonts panel */
					__( 'Visit the <a href="%s">Fonts panel</a> to set the menu font.', 'twentig' ),
					"javascript:wp.customize.control( 'twentig_menu_font' ).focus();"
				),
				'settings'    => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_spacing',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_spacing',
		array(
			'label'   => esc_html__( 'Menu Item Spacing', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => esc_html_x( 'Small', 'spacing', 'twentig' ),
				'medium' => esc_html_x( 'Medium', 'spacing', 'twentig' ),
				'large'  => esc_html_x( 'Large', 'spacing', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_hover',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_hover',
		array(
			'label'   => esc_html__( 'Menu Link Hover/Active Style', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => esc_html__( 'Default', 'twentig' ),
				'border' => esc_html__( 'Border', 'twentig' ),
				'none'   => esc_html__( 'None', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_other_elements',
			array(
				'label'    => esc_html__( 'Additional Elements', 'twentig' ),
				'section'  => 'twentig_header_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_header_social_icons',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_social_icons',
		array(
			'label'   => esc_html__( 'Convert menu social links into social icons', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_button',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_button',
		array(
			'label'   => esc_html__( 'Convert last menu item into a button', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_search',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_search',
		array(
			'label'   => esc_html__( 'Display a search bar', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'twentig_header_nav',
		array(
			'selector'            => '.primary-menu-container',
			'settings'            => array(
				'twentig_header_social_icons',
				'twentig_header_button',
				'twentig_header_search',
			),
			'render_callback'     => 'twentig_twentyone_partial_header_nav',
			'container_inclusive' => true,
		)
	);

	/*
	 * Footer
	 */

	$wp_customize->add_section(
		'twentig_footer_section',
		array(
			'title'    => esc_html__( 'Footer', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 15,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_layout',
			array(
				'label'    => esc_html__( 'Footer', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_layout',
		array(
			'label'   => esc_html__( 'Footer Layout', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''       => esc_html__( 'Default', 'twentig' ),
				'inline' => esc_html__( 'Inline', 'twentig' ),
				'stack'  => esc_html_x( 'Stack', 'layout', 'twentig' ),
				'custom' => esc_html__( 'Blocks', 'twentig' ),
				'hidden' => esc_html__( 'Hidden', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_content',
		array(
			'default'           => 0,
			'sanitize_callback' => 'twentig_sanitize_block_id',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Dropdown_Reusable_Blocks_Control(
			$wp_customize,
			'twentig_footer_content',
			array(
				'label'       => esc_html__( 'Footer Content', 'twentig' ),
				'section'     => 'twentig_footer_section',
				'description' => sprintf(
					/* translators: %s: URL to the Reusable Blocks admin page. */
					__( 'Create the footer with <a href="%s" target="_blank" class="external-link">Reusable Blocks</a>.', 'twentig' ),
					esc_url_raw( admin_url( 'edit.php?post_type=wp_block' ) )
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_width',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_width',
		array(
			'label'   => esc_html__( 'Footer Width', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html_x( 'Wide', 'width', 'twentig' ),
				'full' => esc_html_x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_credit',
		array(
			'label'   => esc_html__( 'Credit', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''       => esc_html__( 'Default', 'twentig' ),
				'custom' => esc_html_x( 'Custom', 'footer credit', 'twentig' ),
				'none'   => esc_html_x( 'None', 'footer credit', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit_text',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_credit_text',
		array(
			'label'       => esc_html__( 'Custom Credit', 'twentig' ),
			'section'     => 'twentig_footer_section',
			'type'        => 'text',
			'description' => wp_kses_post( __( 'To automatically display the current year, insert <code>[Y]</code>', 'twentig' ) ),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_copyright',
		array(
			'selector'            => '.powered-by',
			'settings'            => array(
				'twentig_footer_credit',
				'twentig_footer_credit_text',
			),
			'render_callback'     => 'twentig_twentyone_get_footer_credits',
			'container_inclusive' => true,
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_branding',
		array(
			'transport'         => 'postMessage',
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_branding',
		array(
			'label'   => esc_html__( 'Display site title/logo', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'twentig_footer_branding',
		array(
			'selector'            => '.site-name',
			'render_callback'     => 'twentig_twentyone_partial_footer_branding',
			'container_inclusive' => true,
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_social_icons',
		array(
			'transport'         => 'postMessage',
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_social_icons',
		array(
			'label'   => esc_html__( 'Convert menu social links into social icons', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'twentig_footer_social_icons',
		array(
			'selector'            => '.footer-navigation',
			'render_callback'     => 'twentig_twentyone_partial_footer_nav',
			'container_inclusive' => true,
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_link_style',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_link_style',
		array(
			'label'   => esc_html__( 'Footer Link Style', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''        => esc_html_x( 'Underline', 'style', 'twentig' ),
				'minimal' => esc_html_x( 'Underline on hover', 'style', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_styles',
			array(
				'label'    => esc_html__( 'Footer Widgets', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_widgets_columns',
		array(
			'transport'         => 'postMessage',
			'default'           => '3',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_widgets_columns',
		array(
			'label'   => esc_html__( 'Columns', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_widgets_width',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_widgets_width',
		array(
			'label'   => esc_html__( 'Footer Widgets Width', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html_x( 'Wide', 'width', 'twentig' ),
				'full' => esc_html_x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	/*
	 * Page
	 */

	$wp_customize->add_section(
		'twentig_page_section',
		array(
			'title'    => esc_html_x( 'Page', 'Customizer Section Title', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_standard',
			array(
				'label'    => esc_html__( 'Standard Pages', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_hero_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_hero_layout',
		array(
			'label'   => esc_html__( 'Featured Image Layout', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''             => esc_html__( 'Default', 'twentig' ),
				'narrow-image' => esc_html_x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => esc_html__( 'Full Width', 'twentig' ),
				'no-image'     => esc_html__( 'No Image', 'twentig' ),
				'cover'        => esc_html__( 'Cover', 'twentig' ),
				'cover-full'   => esc_html__( 'Fullscreen Cover', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_image_placement',
		array(
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_image_placement',
		array(
			'label'   => esc_html__( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				'above' => esc_html__( 'Above', 'twentig' ),
				'below' => esc_html__( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_width',
		array(
			'label'   => esc_html__( 'Page Title Width', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => esc_html__( 'Text Width', 'twentig' ),
				'wide'       => esc_html_x( 'Wide', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_text_align',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_text_align',
		array(
			'label'   => esc_html__( 'Page Title Text Alignment', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? esc_html__( 'Right', 'twentig' ) : esc_html__( 'Left', 'twentig' ),
				'center' => esc_html__( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_border',
		array(
			'transport'         => 'postMessage',
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_border',
		array(
			'section' => 'twentig_page_section',
			'label'   => esc_html__( 'Display a separator between the title and the content', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_search',
			array(
				'label'    => esc_html__( 'Search Page', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_search_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_search_layout',
		array(
			'label'   => esc_html__( 'Search Results Layout', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''            => esc_html__( 'Default', 'twentig' ),
				'blog-layout' => esc_html__( 'Blog', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_404',
			array(
				'label'    => esc_html__( '404 Page', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_404',
		array(
			'default'           => '0',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Dropdown_Pages_Private_Control(
			$wp_customize,
			'twentig_page_404',
			array(
				'label'       => esc_html__( 'Custom 404 Page', 'twentig' ),
				'section'     => 'twentig_page_section',
				'description' => esc_html__( 'To set a 404 page, you’ll first need to create a private page (to prevent search engines from indexing this page).', 'twentig' ),
			)
		)
	);

	/*
	 * Blog
	 */

	$wp_customize->add_section(
		'twentig_blog_section',
		array(
			'title'    => esc_html__( 'Blog', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 25,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_blog_section_posts_title',
			array(
				'label'    => esc_html__( 'Posts Page', 'twentig' ),
				'section'  => 'twentig_blog_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_show_title',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_show_title',
		array(
			'label'   => esc_html__( 'Display page title on posts page', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_layout',
		array(
			'default'           => 'stack',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_layout',
		array(
			'label'   => esc_html__( 'Blog Layout', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'stack' => esc_html_x( 'Stack', 'layout', 'twentig' ),
				'grid'  => esc_html__( 'Grid', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_sidebar',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_sidebar',
		array(
			'label'       => esc_html__( 'Display sidebar', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to widgets panel */
				__( 'Create the sidebar in the <a href="%s">Widgets panel</a>.', 'twentig' ),
				"javascript:wp.customize.panel( 'widgets' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_style',
		array(
			'default'           => 'separator',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_style',
		array(
			'label'   => esc_html__( 'Blog Style', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'minimal'     => esc_html__( 'Minimal', 'twentig' ),
				'separator'   => esc_html__( 'Separator', 'twentig' ),
				'card-shadow' => esc_html__( 'Card with shadow', 'twentig' ),
				'card-border' => esc_html__( 'Card with border', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_columns',
		array(
			'transport'         => 'postMessage',
			'default'           => '3',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_columns',
		array(
			'label'   => esc_html__( 'Columns', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image',
		array(
			'section' => 'twentig_blog_section',
			'label'   => esc_html__( 'Display featured image', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_placement',
		array(
			'transport'         => 'postMessage',
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_placement',
		array(
			'label'   => esc_html__( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'above' => esc_html__( 'Above', 'twentig' ),
				'below' => esc_html__( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_width',
		array(
			'label'   => esc_html__( 'Featured Image Width', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => esc_html__( 'Text Width', 'twentig' ),
				'wide'       => esc_html__( 'Wide', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_ratio',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_ratio',
		array(
			'label'   => esc_html__( 'Featured Image Aspect Ratio', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html_x( 'Original', 'image aspect ratio', 'twentig' ),
				'20-9' => '20:9',
				'16-9' => '16:9',
				'3-2'  => '3:2',
				'4-3'  => '4:3',
				'1-1'  => esc_html__( 'Square', 'twentig' ),
				'3-4'  => '3:4',
				'2-3'  => '2:3',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_title_size',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_title_size',
		array(
			'label'   => esc_html__( 'Posts Title Font Size', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''            => esc_html__( 'Default', 'twentig' ),
				'medium'      => esc_html__( 'Medium', 'twentig' ),
				'h4'          => 'H4',
				'h3'          => 'H3',
				'extra-large' => esc_html__( 'Extra Large', 'twentig' ),
				'h2'          => 'H2',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_content',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_content',
		array(
			'label'       => esc_html__( 'Display post content', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to theme options panel */
				__( 'Set the post content in the <a href="%s">Excerpt Settings panel</a>.', 'twentig' ),
				"javascript:wp.customize.section( 'excerpt_settings' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_excerpt_length',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_excerpt_length',
		array(
			'label'       => esc_html__( 'Excerpt Length (words)', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 10,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_excerpt_more',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_excerpt_more',
		array(
			'label'   => esc_html__( 'Display “Continue reading”', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_text_align',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_text_align',
		array(
			'label'   => esc_html__( 'Text Alignment', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? esc_html__( 'Right', 'twentig' ) : esc_html__( 'Left', 'twentig' ),
				'center' => esc_html__( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_meta',
		array(
			'default'           => array(
				'date',
				'categories',
				'tags',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_blog_meta',
			array(
				'label'   => esc_html__( 'Post Meta', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => esc_html__( 'Date', 'twentig' ),
					'author'     => esc_html__( 'Author', 'twentig' ),
					'categories' => esc_html__( 'Categories', 'twentig' ),
					'tags'       => esc_html__( 'Tags', 'twentig' ),
					'comments'   => esc_html_x( 'Comment', 'noun', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_meta_label',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_meta_label',
		array(
			'section' => 'twentig_blog_section',
			'label'   => esc_html__( 'Display meta label', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_pagination',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_pagination',
		array(
			'label'   => esc_html__( 'Pagination Style', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''        => esc_html__( 'Default', 'twentig' ),
				'minimal' => esc_html__( 'Minimal', 'twentig' ),
				'center'  => esc_html__( 'Minimal Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_blog_section_single_title',
			array(
				'label'    => esc_html__( 'Single Post', 'twentig' ),
				'section'  => 'twentig_blog_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_sidebar',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_sidebar',
		array(
			'label'       => esc_html__( 'Display sidebar', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to widgets panel */
				__( 'Create the sidebar in the <a href="%s">Widgets panel</a>.', 'twentig' ),
				"javascript:wp.customize.panel( 'widgets' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_hero_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_hero_layout',
		array(
			'label'   => esc_html__( 'Featured Image Layout', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''             => esc_html__( 'Default', 'twentig' ),
				'narrow-image' => esc_html_x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => esc_html__( 'Full Width', 'twentig' ),
				'no-image'     => esc_html__( 'No Image', 'twentig' ),
				'cover'        => esc_html__( 'Cover', 'twentig' ),
				'cover-full'   => esc_html__( 'Fullscreen Cover', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_image_placement',
		array(
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_image_placement',
		array(
			'label'   => esc_html__( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'above' => esc_html__( 'Above', 'twentig' ),
				'below' => esc_html__( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_width',
		array(
			'label'   => esc_html__( 'Post Title Width', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => esc_html__( 'Text Width', 'twentig' ),
				'wide'       => esc_html_x( 'Wide', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_text_align',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_text_align',
		array(
			'label'   => esc_html__( 'Post Title Text Alignment', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? esc_html__( 'Right', 'twentig' ) : esc_html__( 'Left', 'twentig' ),
				'center' => esc_html__( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_h1_font_size',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_post_h1_font_size',
			array(
				'label'       => esc_html__( 'Post Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_blog_section',
				'input_attrs' => array(
					'min'  => 56,
					'max'  => 96,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_excerpt',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_excerpt',
		array(
			'label'   => esc_html__( 'Display manual excerpt below the title', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_border',
		array(
			'transport'         => 'postMessage',
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_border',
		array(
			'section' => 'twentig_blog_section',
			'label'   => esc_html__( 'Display a separator between the title and the content', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_post_top_meta',
		array(
			'default'           => array(),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_post_top_meta',
			array(
				'label'   => esc_html__( 'Post Meta below Title', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => esc_html__( 'Date', 'twentig' ),
					'author'     => esc_html__( 'Author', 'twentig' ),
					'categories' => esc_html__( 'Categories', 'twentig' ),
					'tags'       => esc_html__( 'Tags', 'twentig' ),
					'comments'   => esc_html_x( 'Comment', 'noun', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_bottom_meta',
		array(
			'default'           => array(
				'date',
				'author',
				'categories',
				'tags',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_post_bottom_meta',
			array(
				'label'   => esc_html__( 'Post Meta below Content', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => esc_html__( 'Date', 'twentig' ),
					'author'     => esc_html__( 'Author', 'twentig' ),
					'categories' => esc_html__( 'Categories', 'twentig' ),
					'tags'       => esc_html__( 'Tags', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_navigation',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_navigation',
		array(
			'label'   => esc_html__( 'Navigation', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html__( 'Default', 'twentig' ),
				'none' => esc_html_x( 'None', 'navigation', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_comments',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_comments',
		array(
			'section' => 'twentig_blog_section',
			'label'   => esc_html__( 'Display comments section', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	/*
	 * Custom Post Types.
	 */

	$wp_customize->add_section(
		'twentig_cpt_section',
		array(
			'title'           => esc_html__( 'Custom Post Types', 'twentig' ),
			'panel'           => 'twentig_twentytwentyone_panel',
			'active_callback' => static function() {
				return ! empty( twentig_twentyone_get_cpt() );
			},
			'priority'        => 30,
		)
	);

	$wp_customize->add_setting(
		'twentig_cpt_archive_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cpt_archive_layout',
		array(
			'label'   => esc_html__( 'Archive Layout', 'twentig' ),
			'section' => 'twentig_cpt_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html__( 'Default', 'twentig' ),
				'blog' => esc_html__( 'Blog', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_cpt_single_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cpt_single_layout',
		array(
			'label'   => esc_html__( 'Single Post Layout', 'twentig' ),
			'section' => 'twentig_cpt_section',
			'type'    => 'select',
			'choices' => array(
				''     => esc_html__( 'Default', 'twentig' ),
				'post' => esc_html__( 'Post', 'twentig' ),
				'page' => esc_html__( 'Page', 'twentig' ),
			),
		)
	);

	/*
	 * Additional Settings
	 */

	$wp_customize->add_section(
		'twentig_additional_section',
		array(
			'title'    => esc_html__( 'Additional Styling', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'twentig_links_style',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_links_style',
		array(
			'label'       => esc_html__( 'Links Style', 'twentig' ),
			'section'     => 'twentig_additional_section',
			'type'        => 'select',
			'choices'     => array(
				''        => esc_html_x( 'Default', 'style', 'twentig' ),
				'minimal' => esc_html_x( 'Minimal', 'style', 'twentig' ),
			),
			'description' => esc_html__( 'The minimal style removes the background focus style and the post titles underline.', 'twentig' ),
		)
	);

	$wp_customize->add_setting(
		'twentig_border_thickness',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_border_thickness',
		array(
			'label'       => esc_html__( 'Border Thickness', 'twentig' ),
			'description' => esc_html__( 'Applies to buttons, separators, inputs, and elements with border.', 'twentig' ),
			'section'     => 'twentig_additional_section',
			'type'        => 'select',
			'choices'     => array(
				'thin' => esc_html_x( 'Thin', 'border thickness', 'twentig' ),
				''     => esc_html_x( 'Thick', 'border thickness', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_shape',
		array(
			'transport'         => 'postMessage',
			'default'           => 'square',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_shape',
		array(
			'label'   => esc_html__( 'Button Shape', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				'square'  => esc_html_x( 'Square', 'button shape', 'twentig' ),
				'rounded' => esc_html_x( 'Rounded', 'button shape', 'twentig' ),
				'pill'    => esc_html_x( 'Pill', 'button shape', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_size',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_size',
		array(
			'label'   => esc_html__( 'Button Size', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => esc_html__( 'Small', 'twentig' ),
				'medium' => esc_html__( 'Medium', 'twentig' ),
				''       => esc_html__( 'Large', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_text_transform',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_text_transform',
		array(
			'label'   => esc_html__( 'Button Text Transform', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				''          => esc_html_x( 'None', 'text transform', 'twentig' ),
				'uppercase' => esc_html__( 'Uppercase', 'twentig' ),
			),
		)
	);

	/*
	 * Performance Settings
	 */

	$wp_customize->add_section(
		'twentig_performance_section',
		array(
			'title'    => esc_html__( 'Performance', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'twentig_theme_minify_css',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_theme_minify_css',
		array(
			'section'         => 'twentig_performance_section',
			'label'           => esc_html__( 'Minify the theme stylesheet to reduce its load time.', 'twentig' ),
			'type'            => 'checkbox',
			'active_callback' => static function() {
				return ! is_rtl();
			},
		)
	);

	$wp_customize->add_setting(
		'twentig_page_contact',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_page_contact',
		array(
			'section'         => 'twentig_performance_section',
			'label'           => 'Contact Form 7',
			'type'            => 'dropdown-pages',
			'description'     => esc_html__( 'Only loads the Contact Form 7 scripts on the selected page.', 'twentig' ),
			'active_callback' => static function() {
				return class_exists( 'WPCF7_ContactForm' );
			},
		)
	);

	$wp_customize->add_section(
		new Twentig_Customize_More_Section(
			$wp_customize,
			'twentig_more',
			array(
				'title'       => esc_html__( 'Get more for free', 'twentig' ),
				'panel'       => 'twentig_twentytwentyone_panel',
				'button_text' => esc_html__( 'Subscribe', 'twentig' ),
				'button_url'  => 'https://twentig.com/newsletter?utm_source=wp-dash&utm_medium=customizer&utm_campaign=newsletter',
				'priority'    => 50,
			)
		)
	);

	$starter_description  = '<p>' . esc_html__( 'When loading a starter website, you can preview it in the Customizer. No changes appear on your live site until you click "Publish".', 'twentig' );
	$starter_description .= '<p>' . esc_html__( 'When clicking "Publish", your existing posts and pages are preserved, and depending on the selected Import Type:', 'twentig' ) . '</p>';
	$starter_description .= '<ul>';
	$starter_description .= '<li>' . esc_html__( 'Your current Customizer settings are replaced.', 'twentig' ) . '</li>';
	$starter_description .= '<li>' . esc_html__( 'Your current menus and widgets are replaced.', 'twentig' ) . '</li>';
	$starter_description .= '<li>' . esc_html__( 'New posts and pages are created.', 'twentig' ) . '</li>';
	$starter_description .= '</ul>';

	$wp_customize->add_section(
		'twentig_starter_websites',
		array(
			'title'              => esc_html__( 'Twentig Starter Websites', 'twentig' ),
			'description'        => $starter_description,
			'description_hidden' => true,
			'priority'           => 151,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Starter_Control(
			$wp_customize,
			'twentig_starter_content',
			array(
				'section'  => 'twentig_starter_websites',
				'settings' => array(),
			)
		)
	);
}
add_action( 'customize_register', 'twentig_twentyone_customize_register', 11 );

/**
 * Enqueue scripts for customizer preview.
 */
function twentig_twentyone_customize_preview_init() {
	wp_enqueue_script( 'twentig-twentyone-customize-preview', TWENTIG_ASSETS_URI . '/js/classic/twentytwentyone-customize-preview.js', array( 'customize-preview' ), TWENTIG_VERSION, true );
}
add_action( 'customize_preview_init', 'twentig_twentyone_customize_preview_init', 11 );

/**
 * Enqueue scripts for customizer controls.
 */
function twentig_twentyone_customize_controls_enqueue_scripts() {

	wp_register_script( 'selectWoo', TWENTIG_ASSETS_URI . '/js/classic/selectWoo.min.js', array( 'jquery' ), '1.0.8', true );

	wp_enqueue_script(
		'twentig-twentyone-customize-controls',
		TWENTIG_ASSETS_URI . '/js/classic/twentytwentyone-customize-controls.js',
		array( 'selectWoo' ),
		TWENTIG_VERSION,
		true
	);

	wp_localize_script(
		'twentig-twentyone-customize-controls',
		'twentigCustomizerSettings',
		array(
			'fonts'        => twentig_get_fonts_data(),
			'fontVariants' => twentig_twentyone_get_font_styles(),
			'fontPresets'  => twentig_twentyone_get_font_presets(),
			'themeVersion' => wp_get_theme()->get( 'Version' ),
		)
	);
	wp_enqueue_script(
		'twentig-starters',
		TWENTIG_ASSETS_URI . '/js/classic/twentig-starters.js',
		array(),
		TWENTIG_VERSION,
		true
	);

	wp_enqueue_style(
		'selectWoo',
		TWENTIG_ASSETS_URI . '/css/selectWoo.min.css',
		array(),
		'1.0.8'
	);

	wp_enqueue_style(
		'twentig-customize-controls',
		TWENTIG_ASSETS_URI . '/css/customize-controls.css',
		array(),
		TWENTIG_VERSION
	);
}
add_action( 'customize_controls_enqueue_scripts', 'twentig_twentyone_customize_controls_enqueue_scripts', 11 );


/**
 * Outputs an Underscore template that generates dynamically the CSS for instant display in the Customizer preview.
 */
function twentig_twentyone_customizer_live_css_template() {
	?>
	<script type="text/html" id="tmpl-twentig-customizer-live-style">

		<# 
		var body_font              = data.twentig_body_font ? data.twentig_body_font : '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';
		var body_font_size         = data.twentig_body_font_size;
		var body_line_height       = data.twentig_body_line_height;	
		var heading_font           = data.twentig_heading_font ? data.twentig_heading_font : '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';	
		var heading_font_weight    = data.twentig_heading_font_weight;
		var heading_letter_spacing = data.twentig_heading_letter_spacing ? data.twentig_heading_letter_spacing : '0';
		var tertiary_font          = data.twentig_secondary_elements_font;
		var tertiary_font          = 'body' === tertiary_font ? 'var(--font-base)' : 'var(--font-headings)';
		var menu_font              = data.twentig_menu_font;
		var menu_font_weight       = data.twentig_menu_font_weight;
		var menu_font_size         = data.twentig_menu_font_size;
		var menu_letter_spacing    = data.twentig_menu_letter_spacing ? data.twentig_menu_letter_spacing : '0';
		var menu_text_transform    = data.twentig_menu_text_transform ? data.twentig_menu_text_transform : 'none';
		var logo_font              = data.twentig_logo_font;
		var logo_font_weight       = data.twentig_logo_font_weight;
		var logo_font_size         = data.twentig_logo_font_size;
		var logo_mobile_font_size  = data.twentig_logo_font_size_mobile;
		var logo_transform         = data.twentig_logo_text_transform;
		var logo_letter_spacing    = data.twentig_logo_letter_spacing;
		var subtle_color           = data.twentig_subtle_background_color;
		var wide_width             = data.twentig_wide_width;
		var default_width          = data.twentig_default_width;
		var h1_font_size           = data.twentig_h1_font_size;
		var post_h1_font_size      = data.twentig_post_h1_font_size;
		var header_decoration      = data.twentig_header_decoration;
		var footer_link_style      = data.twentig_footer_link_style;
		var widgets_columns        = data.twentig_footer_widgets_columns;
		var border_size            = 'thin' === data.twentig_border_thickness ? '1px' : '3px';
		var button_shape           = data.twentig_button_shape;
		var button_size            = data.twentig_button_size;
		var button_text_transform  = data.twentig_button_text_transform;

		var primary_color           = data.twentig_primary_color;
		var content_link_color      = data.twentig_content_link_color;
		var branding_color          = data.twentig_branding_color;
		var header_link_color       = data.twentig_header_link_color;
		var header_link_hover_color = data.twentig_header_link_hover_color;
		var footer_text_color       = data.twentig_footer_text_color;
		var footer_link_color       = data.twentig_footer_link_color;
		var widgets_text_color      = data.twentig_widgets_text_color;
		var widgets_link_color      = data.twentig_widgets_link_color;

		var archive_img_ratio = data.twentig_blog_image_ratio;
		var ratios = {
			'20-9' : '45%',
			'16-9' : '56.25%',
			'3-2'  : '66.66667%',
			'4-3'  : '75%',
			'1-1'  : '100%',
			'3-4'  : '133.33333%',
			'2-3'  : '150%'
		};

		var archive_heading_size = data.twentig_blog_title_size;
		var heading_sizes = {
			'h2'          : 'var(--heading--font-size-h2)',
			'h3'          : 'var(--heading--font-size-h3)',
			'h4'          : 'var(--heading--font-size-h4)',
			'extra-large' : 'var(--global--font-size-xl)',
			'medium'      : 'min(calc(1.125 * var(--global--font-size-base)), 23px)',
		};
		#>

		:root{

			/* Colors */
			<# if ( primary_color ) { #>
				--global--color-primary: {{ primary_color }};
				--global--color-secondary : {{ primary_color }};
			<# } #>

			<# if ( content_link_color ) { #>
				--content--color--link: {{ content_link_color }};
			<# } #>

			<# if ( branding_color ) { #>
				--branding--color-text: {{ branding_color }};
			<# } #>

			<# if ( header_link_color ) { #>
				--header--color-text: {{ header_link_color }};
			<# } #>

			<# if ( header_link_hover_color ) { #>
				--header--color-link-hover: {{ header_link_hover_color }};
			<# } #>

			<# if ( footer_text_color ) { #>
				--footer--color-text: {{ footer_text_color }};
				--footer--color-link: {{ footer_text_color }};
				--footer--color-link-hover: {{ footer_text_color }};
			<# } #>

			<# if ( footer_link_color ) { #>
				--footer--color-link: {{ footer_link_color }};
				--footer--color-link-hover: {{ footer_link_color }};
			<# } #>

			<# if ( widgets_text_color ) { #>
				--widgets--color-text: {{ widgets_text_color }};
			<# } #>

			<# if ( widgets_link_color ) { #>
				--widgets--color-link: {{ widgets_link_color }};
			<# } #>

			/* Fonts */

			--font-base: {{ body_font }};

			<# if ( body_font_size ) { #>
				--global--font-size-base: {{ parseInt( body_font_size ) / 16 }}rem;
			<# } #>
			<# if ( body_line_height ) { #>
				--global--line-height-body: {{ body_line_height }};
			<# } #>

			--font-headings: {{ heading_font }};

			<# if ( heading_font_weight ) { #>
				--heading--font-weight: {{ heading_font_weight }};
				--heading--font-weight-page-title: {{ heading_font_weight }};
				--widget--font-weight-title: {{ heading_font_weight }};
			<# } #>
			<# if ( heading_letter_spacing ) { #>
				--global--letter-spacing: {{ heading_letter_spacing }}em;
				--heading--letter-spacing-h5: {{ heading_letter_spacing }}em;
				--heading--letter-spacing-h6: {{ heading_letter_spacing }}em;
			<# } #>

			--global--font-tertiary: {{ tertiary_font }};

			<# if ( h1_font_size ) { #>
				--global--font-size-xxl: {{ parseInt( h1_font_size ) / 16 }}rem;
			<# } #>

			<# if ( wide_width ) { #>
				--max--alignwide-width: {{ wide_width }}px;
			<# } #>
			<# if ( default_width ) { #>
				--max--aligndefault-width: {{ default_width }}px;
			<# } #>

			<# if ( 'heading' === menu_font )  { #>
				--primary-nav--font-family: var(--font-headings);
			<# } else { #>
				--primary-nav--font-family: var(--font-base);
			<# } #>

			<# if ( menu_font_weight ) { #>
				--primary-nav--font-weight: {{ menu_font_weight }};
			<# } #>

			<# if ( menu_font_size ) { #>
				--primary-nav--font-size: {{ parseInt( menu_font_size ) / 16 }}rem;
			<# } #>

			<# if ( menu_letter_spacing ) { #>
				--primary-nav--letter-spacing: {{ menu_letter_spacing }}em;
			<# } #>

			<# if ( logo_font_size ) { #>
				--branding--title--font-size: {{ logo_font_size }}px;
				--branding--title--font-size-mobile: {{ logo_font_size }}px;
			<# } #>	

			<# if ( logo_mobile_font_size ) { #>
				--branding--title--font-size-mobile: {{ logo_mobile_font_size }}px;
			<# } #>

			/* Other */

			--button--border-width: {{ border_size }};
			--form--border-width: {{ border_size }};

			<# if ( 'rounded' === button_shape ) { #>
				--button--border-radius: 6px;
			<# } else if ( 'pill' === button_shape ) { #>
				--button--border-radius: 50px;
			<# } else { #>
				--button--border-radius: 0;
			<# } #>

			<# if ( 'small' === button_size ) { #>
				--button--padding-vertical: 8px;
				--button--padding-horizontal: 16px;
				--button--font-size: var(--global--font-size-sm);
			<# } else if ( 'medium' === button_size ) { #>
				--button--padding-vertical: 12px;
				--button--padding-horizontal: 24px;
				--button--font-size: var(--global--font-size-sm);
			<# } else { #>
				--button--padding-vertical: 15px;
				--button--padding-horizontal: 30px;
				--button--font-size: var(--global--font-size-base);
			<# } #>

			<# if ( 'uppercase' === button_text_transform ) { #>
				--button--font-size: var(--global--font-size-xs);
			<# } #>

			<# if ( archive_heading_size && heading_sizes[ archive_heading_size ] ) { #>
				--archive-heading-size: {{ heading_sizes[ archive_heading_size ] }};
			<# } #>

			<# if ( archive_img_ratio && ratios[ archive_img_ratio ] ) { #>
				--archive-img-ratio: {{ ratios[ archive_img_ratio ] }};
			<# } #>

		}

		<# if ( 'rounded' === button_shape || 'pill' === button_shape ) { #>
			.search-form .search-submit, .wp-block-search .wp-block-search__button { border-radius: 0; }
		<# } #>

		.primary-navigation, .menu-button-container .button {
			text-transform: {{ menu_text_transform }};
		}

		.site-footer > .site-info,
		.single .site-main > article > .entry-footer,
		.page-header,
		.pagination,
		.comments-pagination,
		.wp-block-image.is-style-twentytwentyone-border img,
		.wp-block-image.is-style-twentytwentyone-image-frame img,
		.wp-block-latest-posts.is-style-twentytwentyone-latest-posts-borders li,
		.wp-block-media-text.is-style-twentytwentyone-border,
		.wp-block-group.is-style-twentytwentyone-border {
			border-width: {{ border_size }};
		}

		input[type="submit"],
		.wp-block-button__link,
		.wp-block-file__button,
		.wp-block-search__button,
		.primary-navigation .menu-button a {
			<# if ( 'uppercase' === button_text_transform ) { #>
				text-transform: uppercase; letter-spacing: 0.05em;
			<# } else { #>
				text-transform: none; letter-spacing: normal;
			<# } #>
		}

		<# if ( 'shadow' === header_decoration ) { #>
			.site-header { box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.16); border-bottom: 0; }
		<# } else if ( 'border' === header_decoration ) { #>
			.site-header { border-bottom: var(--form--border-width) solid var(--global--color-border); box-shadow: none; }
		<# } else { #>
			.site-header { box-shadow: none; border-bottom: 0; }
		<# } #>

		@media ( min-width: 822px ) { 
			.single-post h1.entry-title{
				<# if ( post_h1_font_size ) { #>
					font-size: {{ parseInt( post_h1_font_size ) / 16 }}rem;
				<# } else { #>
					font-size: {{ parseInt( h1_font_size ) / 16 }}rem;
				<# } #>
			}
		}

		.site-header .site-title, .site-footer > .site-info .site-name {
			<# if ( logo_font ) { #>
				font-family: {{ logo_font }};
			<# } #>	
			<# if ( logo_font_weight ) { #>
				font-weight: {{ logo_font_weight }};
			<# } #>			
			<# if ( logo_letter_spacing ) { #>
				letter-spacing: {{ logo_letter_spacing }}em;
			<# } #>
			<# if ( logo_transform ) { #>
				text-transform: {{ logo_transform }};
			<# } #>	
		}		

		<# if ( subtle_color ) { #>
			:root .has-subtle-background-color, :root .has-subtle-background-background-color { background-color: {{ subtle_color }}; }
			:root .has-subtle-color { color: {{ subtle_color }}; }
		<# } #>	

		<# if ( 'minimal' === footer_link_style ) { #>
			.site-footer a, .widget-area a {
				text-decoration: none;
			}
			.site-footer a:hover, .widget-area a:hover {
				text-decoration: underline;
			}
			.footer-navigation-wrapper li a:hover {
				text-decoration-style: solid;
			}
		<# } else { #>
			.site-footer a, .widget-area a {
				text-decoration: underline;
			}
			.site-footer a:hover, .widget-area a:hover, .footer-navigation-wrapper li a:hover {
				text-decoration-style: dotted;
			}
		<# } #>

		<# if ( '4' === widgets_columns ) { #>
			@media (min-width: 1024px) {
				.widget-area { column-gap: 40px; grid-template-columns: repeat(4, minmax(0, 1fr)); }
			}
		<# } else if ( '2' === widgets_columns ) { #>
			@media (min-width: 822px) {			
				.widget-area { grid-template-columns: repeat(2, minmax(0, 1fr)); }			
			}
		<# } else if ( '1' === widgets_columns ) { #>
			.widget-area { grid-template-columns: repeat(1, minmax(0, 1fr)); }			
		<# } else { #>
			@media (min-width: 652px) {
				.widget-area { grid-template-columns: repeat(2, 1fr); }
			}
			@media (min-width: 1024px) {
				.widget-area { grid-template-columns: repeat(3, 1fr); }
			}			
		<# } #>

		<# if ( body_font_size && body_font_size > 20 ) { #>
			@media(max-width:651px) {
				:root { --global--font-size-base: 1.25rem; }
			}
		<# } #>

	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'twentig_twentyone_customizer_live_css_template' );

/**
 * Register widget area.
 */
function twentig_twentyone_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'twentig' ),
			'id'            => 'sidebar-blog',
			'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'twentig' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'twentig_twentyone_widgets_init' );

/**
 * Render the footer navigation for the selective refresh partial.
 */
function twentig_twentyone_partial_footer_nav() {
	if ( ! get_theme_mod( 'twentig_footer_social_icons', true ) ) {
		remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_nav_menu_social_icons', 10, 4 );
	}
	remove_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_add_sub_menu_toggle', 10, 4 );
	twentig_twentyone_get_footer_menu();
}

/**
 * Render the footer logo for the selective refresh partial.
 */
function twentig_twentyone_partial_footer_branding() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		add_filter( 'theme_mod_custom_logo', 'twentig_twentyone_footer_logo' );
	}
	twentig_twentyone_get_footer_branding();
}

/**
 * Render the header navigation for the selective refresh partial.
 */
function twentig_twentyone_partial_header_nav() {
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'menu_class'      => 'menu-wrapper',
			'container_class' => 'primary-menu-container',
			'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
			'fallback_cb'     => false,
		)
	);
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function twentig_twentyone_partial_tagline() {
	$description = get_bloginfo( 'description', 'display' );
	if ( $description && true === get_theme_mod( 'display_title_and_tagline', true ) ) :
		?>
		<p class="site-description">
			<?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</p>
		<?php
	endif;
}

/**
 * Return starter websites list.
 */
function twentig_twentyone_get_starter_websites() {

	$starters = array(
		array(
			'id'         => 'default',
			'title'      => __( 'Default' ),
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/twentytwentyone.jpg',
		),
		array(
			'id'         => 'brooklyn',
			'title'      => 'Brooklyn',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/brooklyn.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/brooklyn.json',
		),
		array(
			'id'         => 'dakar',
			'title'      => 'Dakar',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/dakar.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/dakar.json',
		),
		array(
			'id'         => 'kingston',
			'title'      => 'Kingston',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/kingston.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/kingston.json',
		),
		array(
			'id'         => 'kyoto',
			'title'      => 'Kyoto',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/kyoto.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/kyoto.json',
		),
		array(
			'id'         => 'lutece',
			'title'      => 'Lutece',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/lutece.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/lutece.json',
		),
		array(
			'id'         => 'orlando',
			'title'      => 'Orlando',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/orlando.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/orlando.json',
		),
		array(
			'id'         => 'oslo',
			'title'      => 'Oslo',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/oslo.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/oslo.json',
		),
		array(
			'id'         => 'santiago',
			'title'      => 'Santiago',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/santiago.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/santiago.json',
		),
		array(
			'id'         => 'thane',
			'title'      => 'Thane',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/thane.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/thane.json',
		),
		array(
			'id'         => 'valencia',
			'title'      => 'Valencia',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/valencia.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/valencia.json',
		),
	);

	return $starters;
}
add_filter( 'twentig_starter_websites', 'twentig_twentyone_get_starter_websites' );

/**
 * Generates the color CSS variables.
 */
function twentig_twentyone_generate_color_variables() {
	$colors = array(
		array( 'twentig_primary_color', '--global--color-primary' ),
		array( 'twentig_primary_color', '--global--color-secondary' ),
		array( 'twentig_content_link_color', '--content--color--link' ),
		array( 'twentig_header_background_color', '--header--color-background' ),
		array( 'twentig_branding_color', '--branding--color-text' ),
		array( 'twentig_header_link_color', '--header--color-text' ),
		array( 'twentig_header_link_hover_color', '--header--color-link-hover' ),
		array( 'twentig_footer_background_color', '--footer--color-background' ),
		array( 'twentig_footer_text_color', '--footer--color-text' ),
		array( 'twentig_footer_text_color', '--footer--color-link' ),
		array( 'twentig_footer_text_color', '--footer--color-link-hover' ),
		array( 'twentig_footer_link_color', '--footer--color-link' ),
		array( 'twentig_footer_link_color', '--footer--color-link-hover' ),
		array( 'twentig_widgets_background_color', '--widgets--color-background' ),
		array( 'twentig_widgets_text_color', '--widgets--color-text' ),
		array( 'twentig_widgets_link_color', '--widgets--color-link' ),
	);

	$colors = apply_filters( 'twentig_twentyone_color_variables', $colors );

	$theme_css = '';

	foreach ( $colors as $color ) {
		$custom_color = get_theme_mod( "$color[0]" );
		if ( $custom_color ) {
			$theme_css .= "$color[1]" . ':' . $custom_color . ';';
		}
	}

	return $theme_css;
}

/**
 * Detects the site theme color according to the body background color.
 */
function twentig_twentyone_is_light_theme() {
	$background_color = get_theme_mod( 'background_color', 'D1E4DD' );
	if ( 127 < Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex( $background_color ) ) {
		return true;
	}
	return false;
}
