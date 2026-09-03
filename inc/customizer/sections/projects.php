<?php
/**
 * Customizer: Projects & Products Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_projects_section',
	array(
		'title'    => __( 'Projects & Products', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 40,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_projects_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_projects_enabled',
	array(
		'label'   => __( 'Enable Projects Section', 'geekypress' ),
		'section' => 'geekypress_projects_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_projects_label',
	array(
		'default'           => '// SELECTED_WORK',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_projects_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_projects_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_projects_title',
	array(
		'default'           => 'Projects & Products',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_projects_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_projects_section',
		'type'    => 'text',
	)
);

// Projects Repeater
$default_projects = wp_json_encode(
	array(
		array(
			'icon'        => 'dashicons-rest-api',
			'type'        => 'CLI & OPEN SOURCE',
			'title'       => 'FastDeploy Engine',
			'description' => 'A zero-downtime deployment engine for WordPress and PHP web stacks with automated rollbacks, database synchronization, and staging pipelines.',
			'tags'        => 'PHP, Bash, Docker, WP-CLI',
			'link_text'   => 'View on GitHub ↗',
			'link_url'    => 'https://github.com/',
		),
		array(
			'icon'        => 'dashicons-chart-line',
			'type'        => 'FULL-STACK DASHBOARD',
			'title'       => 'CloudMetrics Suite',
			'description' => 'Real-time developer analytics and server monitoring portal with interactive dashboards, anomaly detection, and instant incident alerts.',
			'tags'        => 'React, TypeScript, GraphQL, Node.js',
			'link_text'   => 'Live Demo ↗',
			'link_url'    => '#',
		),
		array(
			'icon'        => 'dashicons-shield',
			'type'        => 'WordPress Plugin',
			'title'       => 'SecureSync REST API',
			'description' => 'A hardened synchronization bridge connecting WordPress sites to modern headless frontends, cloud storage, and automated webhooks.',
			'tags'        => 'WordPress, REST API, Security, OAuth',
			'link_text'   => 'Documentation ↗',
			'link_url'    => '#',
		),
		array(
			'icon'        => 'dashicons-layout',
			'type'        => 'UI DESIGN SYSTEM',
			'title'       => 'TerminalKit UI',
			'description' => 'An accessible, lightweight developer-themed component library with native terminal styling, code blocks, and adaptive themes.',
			'tags'        => 'CSS, React, Accessible UI, Web',
			'link_text'   => 'Explore Kit ↗',
			'link_url'    => '#',
		),
	)
);

$wp_customize->add_setting(
	'geekypress_projects_items',
	array(
		'default'           => $default_projects,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_projects_items',
		array(
			'label'             => __( 'Project Cards', 'geekypress' ),
			'description'       => __( 'Add, reorder, duplicate or delete portfolio projects', 'geekypress' ),
			'section'           => 'geekypress_projects_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'type',
			'add_item_label'    => __( 'Add Project Card', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'icon',        'label' => __( 'Select Icon', 'geekypress' ),               'type' => 'icon',     'default' => 'dashicons-rest-api' ),
				array( 'key' => 'type',        'label' => __( 'Category / Type (e.g. WordPress Plugin)', 'geekypress' ), 'type' => 'text',     'default' => 'PROJECT' ),
				array( 'key' => 'title',       'label' => __( 'Project Title', 'geekypress' ),             'type' => 'text',     'default' => 'Project Name' ),
				array( 'key' => 'description', 'label' => __( 'Description', 'geekypress' ),               'type' => 'textarea', 'default' => 'Project description goes here.' ),
				array( 'key' => 'tags',        'label' => __( 'Tags (comma-separated)', 'geekypress' ),    'type' => 'text',     'default' => 'WordPress, PHP' ),
				array( 'key' => 'link_text',   'label' => __( 'Link Text (Optional)', 'geekypress' ),      'type' => 'text',     'default' => 'View project →' ),
				array( 'key' => 'link_url',    'label' => __( 'Link URL (Optional)', 'geekypress' ),       'type' => 'url',      'default' => '' ),
			),
		)
	)
);
