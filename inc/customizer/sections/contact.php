<?php
/**
 * Customizer: Contact & Socials Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_contact_section',
	array(
		'title'    => __( 'Contact & Socials', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 80,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_contact_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_contact_enabled',
	array(
		'label'   => __( 'Enable Contact Section', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_contact_label',
	array(
		'default'           => "// LET'S CONNECT",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_contact_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_contact_title',
	array(
		'default'           => 'Contact & Socials',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_contact_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'text',
	)
);

// Email
$wp_customize->add_setting(
	'geekypress_contact_email',
	array(
		'default'           => 'hello@example.com',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_email',
	)
);
$wp_customize->add_control(
	'geekypress_contact_email',
	array(
		'label'   => __( 'Email Address', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'email',
	)
);

// Phone
$wp_customize->add_setting(
	'geekypress_contact_phone',
	array(
		'default'           => '+1 (555) 019-2834',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_contact_phone',
	array(
		'label'   => __( 'Phone Number', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'text',
	)
);

// Location
$wp_customize->add_setting(
	'geekypress_contact_location',
	array(
		'default'           => 'San Francisco, CA / Remote',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_contact_location',
	array(
		'label'   => __( 'Location Text', 'geekypress' ),
		'section' => 'geekypress_contact_section',
		'type'    => 'text',
	)
);

// Social Nav Links Repeater
$default_contact_socials = wp_json_encode(
	array(
		array( 'label' => 'LinkedIn ↗',  'url' => 'https://linkedin.com/' ),
		array( 'label' => 'GitHub ↗',    'url' => 'https://github.com/' ),
		array( 'label' => 'X ↗',         'url' => 'https://x.com/' ),
		array( 'label' => 'WordPress ↗', 'url' => 'https://profiles.wordpress.org/' ),
	)
);

$wp_customize->add_setting(
	'geekypress_contact_links',
	array(
		'default'           => $default_contact_socials,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_contact_links',
		array(
			'label'             => __( 'Social Links', 'geekypress' ),
			'description'       => __( 'Buttons at the bottom of the contact card', 'geekypress' ),
			'section'           => 'geekypress_contact_section',
			'item_label_key'    => 'label',
			'item_subtitle_key' => 'url',
			'add_item_label'    => __( 'Add Social Link', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'label', 'label' => __( 'Link Label (e.g. LinkedIn ↗)', 'geekypress' ), 'type' => 'text', 'default' => 'Profile ↗' ),
				array( 'key' => 'url',   'label' => __( 'Link URL', 'geekypress' ), 'type' => 'url',  'default' => '#' ),
			),
		)
	)
);
