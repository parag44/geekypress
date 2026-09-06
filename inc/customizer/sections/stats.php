<?php
/**
 * Customizer: Stats & Metrics Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_stats_section',
	array(
		'title'    => __( 'Stats & Metrics', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 70,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_stats_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_stats_enabled',
	array(
		'label'   => __( 'Enable Stats Section', 'geekypress' ),
		'section' => 'geekypress_stats_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_stats_label',
	array(
		'default'           => '// METRICS & IMPACT',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_stats_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_stats_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_stats_title',
	array(
		'default'           => 'Impact by the Numbers',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_stats_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_stats_section',
		'type'    => 'text',
	)
);

// Section Subtitle / Description
$wp_customize->add_setting(
	'geekypress_stats_desc',
	array(
		'default'           => 'Tangible engineering metrics, reliable project track records, and milestones from years of shipping code.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_stats_desc',
	array(
		'label'   => __( 'Section Subtitle / Description', 'geekypress' ),
		'section' => 'geekypress_stats_section',
		'type'    => 'textarea',
	)
);

// Stats Cards Repeater
$default_stats = wp_json_encode(
	array(
		array(
			'value'       => '50+',
			'title'       => 'Projects Completed',
			'description' => 'Web applications, open source plugins, & developer tools delivered worldwide.',
			'icon'        => 'folder-git-2',
		),
		array(
			'value'       => '5+',
			'title'       => 'Years of Experience',
			'description' => 'Specializing in full-stack architecture, performance, & resilient systems.',
			'icon'        => 'clock',
		),
		array(
			'value'       => '100%',
			'title'       => 'Client Satisfaction',
			'description' => 'Commitment to clean communication, rigorous testing, & high-standard delivery.',
			'icon'        => 'check-circle',
		),
		array(
			'value'       => '∞',
			'title'       => 'Lines of Clean Code',
			'description' => 'Built with caffeine, curiosity, maintainable architecture, & clean git commits.',
			'icon'        => 'code',
		),
	)
);

$wp_customize->add_setting(
	'geekypress_stats_items',
	array(
		'default'           => $default_stats,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_stats_items',
		array(
			'label'             => __( 'Stat Cards', 'geekypress' ),
			'description'       => __( 'Add, reorder, or customize your portfolio stat cards (values, labels, descriptions, and icons).', 'geekypress' ),
			'section'           => 'geekypress_stats_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'value',
			'add_item_label'    => __( 'Add Stat Card', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'value',       'label' => __( 'Stat Value (e.g. 50+, 100%, ∞)', 'geekypress' ), 'type' => 'text',     'default' => '10+' ),
				array( 'key' => 'title',       'label' => __( 'Stat Title', 'geekypress' ),                     'type' => 'text',     'default' => 'Metric Title' ),
				array( 'key' => 'description', 'label' => __( 'Description / Note', 'geekypress' ),            'type' => 'textarea', 'default' => 'Description of metric' ),
				array( 'key' => 'icon',        'label' => __( 'Select Developer Icon', 'geekypress' ),          'type' => 'icon',     'default' => 'activity' ),
			),
		)
	)
);
