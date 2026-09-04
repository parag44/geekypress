<?php
/**
 * Customizer: Blog & Articles Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_blog_section',
	array(
		'title'    => __( 'Blog & Articles', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 75,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_blog_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_blog_enabled',
	array(
		'label'   => __( 'Enable Blog & Articles Section', 'geekypress' ),
		'section' => 'geekypress_blog_section',
		'type'    => 'checkbox',
	)
);

// Section Label
$wp_customize->add_setting(
	'geekypress_blog_label',
	array(
		'default'           => '// LATEST_WRITING',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_blog_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_blog_section',
		'type'    => 'text',
	)
);

// Section Title
$wp_customize->add_setting(
	'geekypress_blog_title',
	array(
		'default'           => 'Blog & Articles',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_blog_title',
	array(
		'label'   => __( 'Section Title', 'geekypress' ),
		'section' => 'geekypress_blog_section',
		'type'    => 'text',
	)
);

// Number of Posts
$wp_customize->add_setting(
	'geekypress_blog_count',
	array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'geekypress_blog_count',
	array(
		'label'       => __( 'Number of Posts to Show', 'geekypress' ),
		'description' => __( 'Choose how many articles are displayed on the front page (1-12).', 'geekypress' ),
		'section'     => 'geekypress_blog_section',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 12,
			'step' => 1,
		),
	)
);

// View All Link Text
$wp_customize->add_setting(
	'geekypress_blog_view_all_text',
	array(
		'default'           => 'View All Articles ↗',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_blog_view_all_text',
	array(
		'label'   => __( 'View All Link Text', 'geekypress' ),
		'section' => 'geekypress_blog_section',
		'type'    => 'text',
	)
);

// View All Link URL
$wp_customize->add_setting(
	'geekypress_blog_view_all_url',
	array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'geekypress_blog_view_all_url',
	array(
		'label'       => __( 'View All Link URL (optional)', 'geekypress' ),
		'description' => __( 'Leave empty to automatically link to your configured Posts page or archive.', 'geekypress' ),
		'section'     => 'geekypress_blog_section',
		'type'        => 'url',
	)
);

// Single Post Container Max Width
$wp_customize->add_setting(
	'geekypress_single_post_width',
	array(
		'default'           => 860,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	'geekypress_single_post_width',
	array(
		'label'       => __( 'Single Post Container Width (px)', 'geekypress' ),
		'description' => __( 'Customize the maximum reading width for single blog posts (default: 860px). Range: 680px - 1200px.', 'geekypress' ),
		'section'     => 'geekypress_blog_section',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 680,
			'max'  => 1200,
			'step' => 10,
		),
	)
);

