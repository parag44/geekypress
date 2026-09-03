<?php
/**
 * Customizer: About Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_about_section',
	array(
		'title'    => __( 'About Me', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 30,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_about_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_about_enabled',
	array(
		'label'   => __( 'Enable About Section', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'checkbox',
	)
);

// Label
$wp_customize->add_setting(
	'geekypress_about_label',
	array(
		'default'           => '// ABOUT_ME',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'text',
	)
);

// Heading
$wp_customize->add_setting(
	'geekypress_about_heading',
	array(
		'default'           => "Engineering clean code\nand scalable systems.",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_heading',
	array(
		'label'       => __( 'Section Heading', 'geekypress' ),
		'description' => __( 'Use newlines for breaks', 'geekypress' ),
		'section'     => 'geekypress_about_section',
		'type'        => 'textarea',
	)
);

// Paragraph 1
$wp_customize->add_setting(
	'geekypress_about_p1',
	array(
		'default'           => "Hi, I'm Alex Morgan — a full-stack engineer and open source contributor passionate about crafting resilient web applications and developer tools.",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_p1',
	array(
		'label'   => __( 'Biography Paragraph 1', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'textarea',
	)
);

// Paragraph 2
$wp_customize->add_setting(
	'geekypress_about_p2',
	array(
		'default'           => "I specialize in TypeScript, modern PHP, WordPress architecture, and cloud infrastructure, building systems that scale smoothly under pressure.",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_p2',
	array(
		'label'   => __( 'Biography Paragraph 2', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'textarea',
	)
);

// Paragraph 3
$wp_customize->add_setting(
	'geekypress_about_p3',
	array(
		'default'           => "I believe in writing maintainable code, automating repetitive workflows, and designing intuitive developer experiences.",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_p3',
	array(
		'label'   => __( 'Biography Paragraph 3', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'textarea',
	)
);

// Signature
$wp_customize->add_setting(
	'geekypress_about_signature',
	array(
		'default'           => '— Alex Morgan',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_about_signature',
	array(
		'label'   => __( 'Signature', 'geekypress' ),
		'section' => 'geekypress_about_section',
		'type'    => 'text',
	)
);

// Stat Grid Repeater
$default_stats = wp_json_encode(
	array(
		array( 'icon' => 'dashicons-clock',       'title' => '10+ Years',   'description' => 'Engineering experience' ),
		array( 'icon' => 'dashicons-portfolio',   'title' => '50+ Projects', 'description' => 'Delivered worldwide' ),
		array( 'icon' => 'dashicons-shield',      'title' => '99.9% Uptime', 'description' => 'Reliability track record' ),
		array( 'icon' => 'dashicons-networking',  'title' => '100% Remote',  'description' => 'Async collaboration' ),
	)
);

$wp_customize->add_setting(
	'geekypress_about_stats',
	array(
		'default'           => $default_stats,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_about_stats',
		array(
			'label'             => __( 'Stat / Feature Highlights', 'geekypress' ),
			'description'       => __( 'The 2x2 highlight grid on the right with Dashicons', 'geekypress' ),
			'section'           => 'geekypress_about_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'description',
			'add_item_label'    => __( 'Add Highlight Box', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'title',       'label' => __( 'Title', 'geekypress' ),                'type' => 'text', 'default' => 'Feature' ),
				array( 'key' => 'description', 'label' => __( 'Description / Subtitle', 'geekypress' ), 'type' => 'text', 'default' => 'Description' ),
				array( 'key' => 'icon',        'label' => __( 'Select Icon', 'geekypress' ),          'type' => 'icon', 'default' => 'dashicons-admin-tools' ),
			),
		)
	)
);
