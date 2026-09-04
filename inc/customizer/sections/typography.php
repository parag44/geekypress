<?php
/**
 * Customizer: Typography & Geek Fonts
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_typography_section',
	array(
		'title'       => __( 'Typography & Geek Fonts', 'geekypress' ),
		'description' => __( 'Customize developer & monospace fonts for code snippets, terminal window, headings, and body content with live Google Fonts support.', 'geekypress' ),
		'panel'       => 'geekypress_theme_panel',
		'priority'    => 16,
	)
);

$font_defs = geekypress_get_font_definitions();

// Monospace / Code font choices
$mono_choices = array();
foreach ( $font_defs as $slug => $data ) {
	if ( ! empty( $data['is_mono'] ) ) {
		$mono_choices[ $slug ] = $data['name'];
	}
}

// Body font choices
$body_choices = array();
foreach ( $font_defs as $slug => $data ) {
	$body_choices[ $slug ] = $data['name'];
}

// Code & Terminal Monospace Font
$wp_customize->add_setting(
	'geekypress_font_mono',
	array(
		'default'           => 'fira-code',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'geekypress_sanitize_font_choice',
	)
);
$wp_customize->add_control(
	'geekypress_font_mono',
	array(
		'label'       => __( 'Terminal & Code Font', 'geekypress' ),
		'description' => __( 'Used for terminal commands, JSON output, titles, buttons, tags, and code blocks.', 'geekypress' ),
		'section'     => 'geekypress_typography_section',
		'type'        => 'select',
		'choices'     => $mono_choices,
	)
);

// Body Font
$wp_customize->add_setting(
	'geekypress_font_body',
	array(
		'default'           => 'fira-code',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'geekypress_sanitize_font_choice',
	)
);
$wp_customize->add_control(
	'geekypress_font_body',
	array(
		'label'       => __( 'Body & Content Font', 'geekypress' ),
		'description' => __( 'Used for descriptive paragraphs, bio text, and documentation.', 'geekypress' ),
		'section'     => 'geekypress_typography_section',
		'type'        => 'select',
		'choices'     => $body_choices,
	)
);

// Enable Programming Ligatures
$wp_customize->add_setting(
	'geekypress_font_ligatures',
	array(
		'default'           => true,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_font_ligatures',
	array(
		'label'       => __( 'Enable Programming Ligatures', 'geekypress' ),
		'description' => __( 'Renders multi-character code ligatures like =>, !=, ===, </>, and -> into continuous glyphs.', 'geekypress' ),
		'section'     => 'geekypress_typography_section',
		'type'        => 'checkbox',
	)
);
