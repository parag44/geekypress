<?php
/**
 * Customizer: Colors & Styling
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_design_section',
	array(
		'title'    => __( 'Colors & Theme Style', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 15,
	)
);

// Color Scheme Mode (Dark / Light / Auto)
$wp_customize->add_setting(
	'geekypress_theme_mode',
	array(
		'default'           => 'dark',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'geekypress_sanitize_color_mode',
	)
);
$wp_customize->add_control(
	'geekypress_theme_mode',
	array(
		'label'       => __( 'Color Mode', 'geekypress' ),
		'description' => __( 'Select your theme appearance mode. "Auto" will automatically match the visitor\'s operating system preference (light/dark).', 'geekypress' ),
		'section'     => 'geekypress_design_section',
		'type'        => 'radio',
		'choices'     => array(
			'dark'  => __( 'Dark (Classic Terminal)', 'geekypress' ),
			'light' => __( 'Light (Clean Minimal)', 'geekypress' ),
			'auto'  => __( 'Auto (Match OS / System Preference)', 'geekypress' ),
		),
	)
);

// Terminal Accent Green
$wp_customize->add_setting(
	'geekypress_color_green',
	array(
		'default'           => '#39ff88',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_green',
		array(
			'label'       => __( 'Terminal Accent Green', 'geekypress' ),
			'description' => __( 'Primary glow color for prompts, borders, and buttons', 'geekypress' ),
			'section'     => 'geekypress_design_section',
		)
	)
);

// Cyan Highlight
$wp_customize->add_setting(
	'geekypress_color_cyan',
	array(
		'default'           => '#49d9ff',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_cyan',
		array(
			'label'       => __( 'Secondary Cyan Color', 'geekypress' ),
			'description' => __( 'Secondary highlight & link hover color', 'geekypress' ),
			'section'     => 'geekypress_design_section',
		)
	)
);

// Background Color
$wp_customize->add_setting(
	'geekypress_color_bg',
	array(
		'default'           => '#050d14',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_bg',
		array(
			'label'   => __( 'Dark Background Color', 'geekypress' ),
			'section' => 'geekypress_design_section',
		)
	)
);

// Surface Color
$wp_customize->add_setting(
	'geekypress_color_surface',
	array(
		'default'           => '#07141d',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_surface',
		array(
			'label'   => __( 'Card / Surface Background', 'geekypress' ),
			'section' => 'geekypress_design_section',
		)
	)
);

// Text Color
$wp_customize->add_setting(
	'geekypress_color_text',
	array(
		'default'           => '#eef5f1',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_text',
		array(
			'label'   => __( 'Headings & Text Color', 'geekypress' ),
			'section' => 'geekypress_design_section',
		)
	)
);

// Muted Text Color
$wp_customize->add_setting(
	'geekypress_color_muted',
	array(
		'default'           => '#9aabb3',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_muted',
		array(
			'label'   => __( 'Body / Muted Text Color', 'geekypress' ),
			'section' => 'geekypress_design_section',
		)
	)
);

// Link Color
$wp_customize->add_setting(
	'geekypress_color_link',
	array(
		'default'           => '#39ff88',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_link',
		array(
			'label'       => __( 'Link Color', 'geekypress' ),
			'description' => __( 'Color for anchor links, including Projects "View on GitHub / Live Demo" links', 'geekypress' ),
			'section'     => 'geekypress_design_section',
		)
	)
);

// Link Hover Color
$wp_customize->add_setting(
	'geekypress_color_link_hover',
	array(
		'default'           => '#49d9ff',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'geekypress_color_link_hover',
		array(
			'label'       => __( 'Link Hover Color', 'geekypress' ),
			'description' => __( 'Color when hovering over links and project URLs', 'geekypress' ),
			'section'     => 'geekypress_design_section',
		)
	)
);

// Custom CSS Setting
$wp_customize->add_setting(
	'geekypress_custom_css',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_strip_all_tags',
	)
);
$wp_customize->add_control(
	'geekypress_custom_css',
	array(
		'label'       => __( 'Additional Custom CSS', 'geekypress' ),
		'description' => __( 'Appended live to the document head', 'geekypress' ),
		'section'     => 'geekypress_design_section',
		'type'        => 'textarea',
	)
);
