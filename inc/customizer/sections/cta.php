<?php
/**
 * Customizer: Call to Action Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_cta_section',
	array(
		'title'    => __( 'Call to Action (CTA)', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 90,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_cta_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_cta_enabled',
	array(
		'label'   => __( 'Enable CTA Section', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'checkbox',
	)
);

// Label
$wp_customize->add_setting(
	'geekypress_cta_label',
	array(
		'default'           => '// START A CONVERSATION',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Headline Prefix
$wp_customize->add_setting(
	'geekypress_cta_title_prefix',
	array(
		'default'           => 'Ready to build something',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_prefix',
	array(
		'label'   => __( 'Headline Prefix', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Highlighted Word
$wp_customize->add_setting(
	'geekypress_cta_title_highlight',
	array(
		'default'           => 'extraordinary',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_highlight',
	array(
		'label'   => __( 'Highlighted Keyword (in Green)', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Headline Suffix
$wp_customize->add_setting(
	'geekypress_cta_title_suffix',
	array(
		'default'           => 'together?',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_suffix',
	array(
		'label'   => __( 'Headline Suffix', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Description
$wp_customize->add_setting(
	'geekypress_cta_description',
	array(
		'default'           => 'Whether you have an upcoming project, need technical consultation, or just want to connect, my inbox is open.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_description',
	array(
		'label'   => __( 'Description', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'textarea',
	)
);

// Button Text
$wp_customize->add_setting(
	'geekypress_cta_btn_text',
	array(
		'default'           => '>_ Send an Email',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_btn_text',
	array(
		'label'   => __( 'Button Text', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Button URL
$wp_customize->add_setting(
	'geekypress_cta_btn_url',
	array(
		'default'           => 'mailto:hello@example.com',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'geekypress_cta_btn_url',
	array(
		'label'   => __( 'Button URL (or mailto:)', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);
