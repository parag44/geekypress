<?php
/**
 * Customizer: Work Experience Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_experience_section',
	array(
		'title'    => __( 'Work Experience', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 60,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_experience_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_experience_enabled',
	array(
		'label'   => __( 'Enable Experience Section', 'geekypress' ),
		'section' => 'geekypress_experience_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_experience_label',
	array(
		'default'           => '// EXPERIENCE',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_experience_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_experience_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_experience_title',
	array(
		'default'           => 'Work Experience',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_experience_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_experience_section',
		'type'    => 'text',
	)
);

// Timeline Items Repeater
$default_experience = wp_json_encode(
	array(
		array(
			'date'        => '2023 — Present',
			'icon'        => 'dashicons-networking',
			'title'       => 'Lead Full-Stack Engineer',
			'company'     => 'Apex Cloud Systems',
			'description' => 'Architecting scalable web applications, automating deployment pipelines, and leading engineering sprints.',
		),
		array(
			'date'        => '2020 — 2023',
			'icon'        => 'dashicons-wordpress',
			'title'       => 'Senior WordPress Engineer',
			'company'     => 'CodeCraft Digital',
			'description' => 'Engineered custom plugins and performance optimizations, achieving sub-second load times for enterprise clients.',
		),
		array(
			'date'        => '2017 — 2020',
			'icon'        => 'dashicons-editor-code',
			'title'       => 'Full-Stack Web Developer',
			'company'     => 'Pixel & Binary Labs',
			'description' => 'Developed responsive web applications, integrated payment gateways, and built internal REST APIs.',
		),
	)
);

$wp_customize->add_setting(
	'geekypress_experience_items',
	array(
		'default'           => $default_experience,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_experience_items',
		array(
			'label'             => __( 'Timeline Experience Items', 'geekypress' ),
			'description'       => __( 'Timeline milestones with date badge, milestone icon, job role, and company', 'geekypress' ),
			'section'           => 'geekypress_experience_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'company',
			'add_item_label'    => __( 'Add Experience Milestone', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'date',        'label' => __( 'Date Range (e.g. Sep 2024 — Present)', 'geekypress' ), 'type' => 'text', 'default' => '2024 — Present' ),
				array( 'key' => 'icon',        'label' => __( 'Select Icon', 'geekypress' ),                         'type' => 'icon', 'default' => 'dashicons-networking' ),
				array( 'key' => 'title',       'label' => __( 'Job Title', 'geekypress' ),                          'type' => 'text', 'default' => 'Role Title' ),
				array( 'key' => 'company',     'label' => __( 'Company Name', 'geekypress' ),                       'type' => 'text', 'default' => 'Company' ),
				array( 'key' => 'description', 'label' => __( 'Job Summary / Accomplishments', 'geekypress' ),      'type' => 'textarea', 'default' => 'Description of responsibilities and achievements.' ),
			),
		)
	)
);
