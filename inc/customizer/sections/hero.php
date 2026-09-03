<?php
/**
 * Customizer: Hero Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_hero_section',
	array(
		'title'    => __( 'Hero & Terminal Profile', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 20,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_hero_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_hero_enabled',
	array(
		'label'   => __( 'Enable Hero Section', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'checkbox',
	)
);

// Label
$wp_customize->add_setting(
	'geekypress_hero_label',
	array(
		'default'           => '// Full-Stack Developer & Open Source',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_label',
	array(
		'label'   => __( 'Terminal Label / Subtitle', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Title Prefix
$wp_customize->add_setting(
	'geekypress_hero_title_prefix',
	array(
		'default'           => "Hi, I'm",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_title_prefix',
	array(
		'label'   => __( 'Hero Title Prefix', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Highlighted Name
$wp_customize->add_setting(
	'geekypress_hero_name',
	array(
		'default'           => 'Alex',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_name',
	array(
		'label'       => __( 'First Name (Highlighted)', 'geekypress' ),
		'description' => __( 'Rendered in terminal green highlight', 'geekypress' ),
		'section'     => 'geekypress_hero_section',
		'type'        => 'text',
	)
);

// Last Name / Suffix
$wp_customize->add_setting(
	'geekypress_hero_surname',
	array(
		'default'           => 'Morgan',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_surname',
	array(
		'label'   => __( 'Surname / Title Suffix', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Description
$wp_customize->add_setting(
	'geekypress_hero_description',
	array(
		'default'           => "Full-Stack Engineer & Open Source Enthusiast\ncrafting resilient web applications, developer tools, and scalable architecture.",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_description',
	array(
		'label'   => __( 'Hero Description', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'textarea',
	)
);

// Primary Button Text
$wp_customize->add_setting(
	'geekypress_hero_btn1_text',
	array(
		'default'           => '>_ Explore Projects',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_btn1_text',
	array(
		'label'   => __( 'Primary Button Text', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Primary Button URL
$wp_customize->add_setting(
	'geekypress_hero_btn1_url',
	array(
		'default'           => '#projects',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'geekypress_hero_btn1_url',
	array(
		'label'   => __( 'Primary Button URL', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Secondary Button Text
$wp_customize->add_setting(
	'geekypress_hero_btn2_text',
	array(
		'default'           => "Let's Talk </>",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_btn2_text',
	array(
		'label'   => __( 'Secondary Button Text', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Secondary Button URL
$wp_customize->add_setting(
	'geekypress_hero_btn2_url',
	array(
		'default'           => '#contact',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'geekypress_hero_btn2_url',
	array(
		'label'   => __( 'Secondary Button URL', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

// Social Links Repeater
$default_socials = wp_json_encode(
	array(
		array( 'label' => 'GH', 'title' => 'GitHub', 'url' => 'https://github.com/' ),
		array( 'label' => 'in', 'title' => 'LinkedIn', 'url' => 'https://linkedin.com/' ),
		array( 'label' => 'X',  'title' => 'Twitter/X', 'url' => 'https://x.com/' ),
		array( 'label' => '@',  'title' => 'Email', 'url' => 'mailto:hello@example.com' ),
	)
);

$wp_customize->add_setting(
	'geekypress_hero_socials',
	array(
		'default'           => $default_socials,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_hero_socials',
		array(
			'label'             => __( 'Terminal Social Links', 'geekypress' ),
			'description'       => __( 'Mono-letter badges below buttons (e.g. in, X, W, @)', 'geekypress' ),
			'section'           => 'geekypress_hero_section',
			'item_label_key'    => 'label',
			'item_subtitle_key' => 'url',
			'add_item_label'    => __( 'Add Social Link', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'label', 'label' => __( 'Badge Char / Icon (e.g. in, X, @)', 'geekypress' ), 'type' => 'text', 'default' => '@' ),
				array( 'key' => 'title', 'label' => __( 'Title / Tooltip', 'geekypress' ), 'type' => 'text', 'default' => 'Social Profile' ),
				array( 'key' => 'url',   'label' => __( 'URL (or mailto:)', 'geekypress' ), 'type' => 'url', 'default' => '#' ),
			),
		)
	)
);

// Terminal Profile Image
$wp_customize->add_setting(
	'geekypress_hero_image',
	array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'geekypress_hero_image',
		array(
			'label'       => __( 'Terminal Window Profile Photo', 'geekypress' ),
			'description' => __( 'Defaults to theme built-in photo if left empty.', 'geekypress' ),
			'section'     => 'geekypress_hero_section',
		)
	)
);

// Terminal JSON Command & Payload
$wp_customize->add_setting(
	'geekypress_hero_terminal_cmd',
	array(
		'default'           => '>_ cat developer.json',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_terminal_cmd',
	array(
		'label'   => __( 'Terminal Prompt Command', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

$default_json = "{\n  \"name\": \"Alex Morgan\",\n  \"role\": \"Full-Stack Engineer\",\n  \"stack\": [\"PHP\", \"TypeScript\", \"WordPress\", \"React\"],\n  \"location\": \"San Francisco, CA / Remote\",\n  \"available\": true\n}";
$wp_customize->add_setting(
	'geekypress_hero_terminal_json',
	array(
		'default'           => $default_json,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_terminal_json',
	array(
		'label'       => __( 'Terminal JSON Content', 'geekypress' ),
		'description' => __( 'Display code / JSON in the terminal window', 'geekypress' ),
		'section'     => 'geekypress_hero_section',
		'type'        => 'textarea',
	)
);

// Terminal Status Badge Text
$wp_customize->add_setting(
	'geekypress_hero_status_label',
	array(
		'default'           => 'Available for',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_status_label',
	array(
		'label'   => __( 'Status Tag Prefix', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);

$wp_customize->add_setting(
	'geekypress_hero_status_text',
	array(
		'default'           => 'Contract & Full-Time Roles',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_hero_status_text',
	array(
		'label'   => __( 'Status Tag Strong Text', 'geekypress' ),
		'section' => 'geekypress_hero_section',
		'type'    => 'text',
	)
);
