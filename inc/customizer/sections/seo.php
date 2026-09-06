<?php
/**
 * Customizer: SEO & Social Meta Settings
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_seo_section',
	array(
		'title'       => __( 'SEO & Social Meta', 'geekypress' ),
		'description' => __( 'Configure search engine metadata, meta description, keywords, and Open Graph / Twitter share cards.', 'geekypress' ),
		'panel'       => 'geekypress_theme_panel',
		'priority'    => 15,
	)
);

// Meta Description
$wp_customize->add_setting(
	'geekypress_seo_meta_desc',
	array(
		'default'           => 'Full-stack software engineer portfolio showcasing web applications, open source developer tools, projects, and skills.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_seo_meta_desc',
	array(
		'label'       => __( 'Meta Description (Front Page)', 'geekypress' ),
		'description' => __( 'Shown in search engine results snippets (recommended: 120-160 characters).', 'geekypress' ),
		'section'     => 'geekypress_seo_section',
		'type'        => 'textarea',
	)
);

// Meta Keywords
$wp_customize->add_setting(
	'geekypress_seo_keywords',
	array(
		'default'           => 'software engineer, developer portfolio, full-stack, wordpress, php, typescript, react, open source',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_seo_keywords',
	array(
		'label'       => __( 'Meta Keywords', 'geekypress' ),
		'description' => __( 'Comma-separated keywords describing your skill set and portfolio.', 'geekypress' ),
		'section'     => 'geekypress_seo_section',
		'type'        => 'text',
	)
);

// Robots Meta Tag
$wp_customize->add_setting(
	'geekypress_seo_robots',
	array(
		'default'           => 'index, follow',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_seo_robots',
	array(
		'label'       => __( 'Robots Directives', 'geekypress' ),
		'description' => __( 'Direct search crawler indexing behavior.', 'geekypress' ),
		'section'     => 'geekypress_seo_section',
		'type'        => 'select',
		'choices'     => array(
			'index, follow'     => __( 'index, follow (Recommended)', 'geekypress' ),
			'noindex, follow'   => __( 'noindex, follow', 'geekypress' ),
			'index, nofollow'   => __( 'index, nofollow', 'geekypress' ),
			'noindex, nofollow' => __( 'noindex, nofollow (Private)', 'geekypress' ),
		),
	)
);

// Open Graph & Twitter Cards Toggle
$wp_customize->add_setting(
	'geekypress_seo_og_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_seo_og_enabled',
	array(
		'label'       => __( 'Enable Open Graph & Twitter Cards', 'geekypress' ),
		'description' => __( 'Outputs social share tags (og:title, og:image, twitter:card, etc.) for Discord, Slack, Twitter/X, and Facebook.', 'geekypress' ),
		'section'     => 'geekypress_seo_section',
		'type'        => 'checkbox',
	)
);

// Social Share Fallback Image
$wp_customize->add_setting(
	'geekypress_seo_og_image',
	array(
		'default'           => '',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'geekypress_seo_og_image',
		array(
			'label'       => __( 'Default Social Share Image (OG Image)', 'geekypress' ),
			'description' => __( 'Recommended dimensions: 1200x630px. Used when sharing your portfolio link.', 'geekypress' ),
			'section'     => 'geekypress_seo_section',
		)
	)
);
