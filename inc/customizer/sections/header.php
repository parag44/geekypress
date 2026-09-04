<?php
/**
 * Customizer: Header & Navigation
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_header',
	array(
		'title'    => __( 'Header & Navigation', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 10,
	)
);

// Brand Badge
$wp_customize->add_setting(
	'geekypress_header_badge',
	array(
		'default'           => '>_',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_header_badge',
	array(
		'label'       => __( 'Brand Badge Text', 'geekypress' ),
		'description' => __( 'The terminal badge mark on the left (e.g. >_)', 'geekypress' ),
		'section'     => 'geekypress_header',
		'type'        => 'text',
	)
);

// Brand Title
$wp_customize->add_setting(
	'geekypress_header_title',
	array(
		'default'           => 'Alex Morgan',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_header_title',
	array(
		'label'       => __( 'Brand Name / Title', 'geekypress' ),
		'section'     => 'geekypress_header',
		'type'        => 'text',
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'geekypress_header_cta_text',
	array(
		'default'           => "Let's Talk </>",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_header_cta_text',
	array(
		'label'       => __( 'CTA Button Text', 'geekypress' ),
		'section'     => 'geekypress_header',
		'type'        => 'text',
	)
);

// CTA Button URL
$wp_customize->add_setting(
	'geekypress_header_cta_url',
	array(
		'default'           => '#contact',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'geekypress_header_cta_url',
	array(
		'label'       => __( 'CTA Button Link URL', 'geekypress' ),
		'section'     => 'geekypress_header',
		'type'        => 'text',
	)
);

// Show CTA Button
$wp_customize->add_setting(
	'geekypress_header_cta_show',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_header_cta_show',
	array(
		'label'       => __( 'Display CTA Button', 'geekypress' ),
		'section'     => 'geekypress_header',
		'type'        => 'checkbox',
	)
);
