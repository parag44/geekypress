<?php
/**
 * Customizer: Interests & Curiosities Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_interests_section',
	array(
		'title'    => __( 'Interests & Curiosities', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 70,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_interests_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_interests_enabled',
	array(
		'label'   => __( 'Enable Interests Section', 'geekypress' ),
		'section' => 'geekypress_interests_section',
		'type'    => 'checkbox',
	)
);

// Label
$wp_customize->add_setting(
	'geekypress_interests_label',
	array(
		'default'           => '// BEYOND THE TICKET QUEUE',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_interests_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_interests_section',
		'type'    => 'text',
	)
);

// Title
$wp_customize->add_setting(
	'geekypress_interests_title',
	array(
		'default'           => 'Interests & Curiosities',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_interests_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_interests_section',
		'type'    => 'text',
	)
);

// Interests Repeater
$default_interests = wp_json_encode(
	array(
		array(
			'icon'        => 'globe',
			'title'       => 'WordPress & Open Source',
			'description' => 'Learning, contributing, and sharing practical knowledge with the community.',
		),
		array(
			'icon'        => 'wrench',
			'title'       => 'Support Systems',
			'description' => 'Improving tools, documentation, recovery paths, and reliable workflows.',
		),
		array(
			'icon'        => 'sparkles',
			'title'       => 'Thoughtful AI Products',
			'description' => 'Exploring useful AI products with privacy and human control in focus.',
		),
		array(
			'icon'        => 'compass',
			'title'       => 'Travel & Technology',
			'description' => 'Exploring new places and capturing stories through technology.',
		),
	)
);

$wp_customize->add_setting(
	'geekypress_interests_items',
	array(
		'default'           => $default_interests,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_repeater',
	)
);
$wp_customize->add_control(
	new GeekyPress_Repeater_Control(
		$wp_customize,
		'geekypress_interests_items',
		array(
			'label'             => __( 'Interests List', 'geekypress' ),
			'description'       => __( 'Interactive icon badges with title and description', 'geekypress' ),
			'section'           => 'geekypress_interests_section',
			'item_label_key'    => 'title',
			'item_subtitle_key' => 'icon',
			'add_item_label'    => __( 'Add Interest', 'geekypress' ),
			'fields'            => array(
				array( 'key' => 'icon',        'label' => __( 'Select Icon', 'geekypress' ), 'type' => 'icon', 'default' => 'globe' ),
				array( 'key' => 'title',       'label' => __( 'Interest Title', 'geekypress' ), 'type' => 'text', 'default' => 'Topic Title' ),
				array( 'key' => 'description', 'label' => __( 'Description', 'geekypress' ),    'type' => 'textarea', 'default' => 'Brief reflection or curiosity description.' ),
			),
		)
	)
);
