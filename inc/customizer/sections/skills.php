<?php
/**
 * Customizer: Skills & Expertise Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_skills_section',
	array(
		'title'    => __( 'Skills & Expertise', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 50,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_skills_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_skills_enabled',
	array(
		'label'   => __( 'Enable Skills Section', 'geekypress' ),
		'section' => 'geekypress_skills_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_skills_label',
	array(
		'default'           => '// WHAT I DO BEST',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_skills_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_skills_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_skills_title',
	array(
		'default'           => 'Skills & Expertise',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_skills_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_skills_section',
		'type'    => 'text',
	)
);

// Skills Repeater
$default_skills = wp_json_encode(
	array(
		array( 'icon' => 'dashicons-wordpress',        'title' => 'WordPress Core & Themes' ),
		array( 'icon' => 'dashicons-editor-code',      'title' => 'HTML, CSS, JavaScript, PHP' ),
		array( 'icon' => 'dashicons-admin-tools',      'title' => 'Debugging & Troubleshooting' ),
		array( 'icon' => 'dashicons-layout',           'title' => 'Elementor & Page Builders' ),
		array( 'icon' => 'dashicons-desktop',          'title' => 'Browser Dev Tools' ),
		array( 'icon' => 'dashicons-admin-site-alt3',  'title' => 'cPanel, FTP, DNS, Hosting' ),
		array( 'icon' => 'dashicons-rest-api',         'title' => 'REST API & AJAX' ),
		array( 'icon' => 'dashicons-sos',              'title' => 'Conflict Resolution' ),
		array( 'icon' => 'dashicons-shield',           'title' => 'Security & Performance' ),
		array( 'icon' => 'dashicons-tickets-alt',      'title' => 'Ticketing Systems' ),
		array( 'icon' => 'dashicons-randomize',        'title' => 'Version Control (Git)' ),
		array( 'icon' => 'dashicons-flag',             'title' => 'Bug Replication & Docs' ),
	)
);

$wp_customize->add_setting(
	'geekypress_skills_items',
	array(
		'default'           => $default_skills,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_skills_items',
		array(
			'label'             => __( 'Skills List', 'geekypress' ),
			'description'       => __( 'Skill badges displayed in a 4-column terminal grid', 'geekypress' ),
			'section'           => 'geekypress_skills_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'icon',
			'add_item_label'    => __( 'Add Skill', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'title', 'label' => __( 'Skill Name', 'geekypress' ),  'type' => 'text', 'default' => 'Skill Name' ),
				array( 'key' => 'icon',  'label' => __( 'Select Icon', 'geekypress' ), 'type' => 'icon', 'default' => 'dashicons-yes' ),
			),
		)
	)
);
