<?php
/**
 * Customizer: Footer Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_footer_section',
	array(
		'title'    => __( 'Footer & Back to Top', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 100,
	)
);

// Copyright Text
$wp_customize->add_setting(
	'geekypress_footer_copyright',
	array(
		'default'           => '© ' . gmdate( 'Y' ) . ' Alex Morgan. All rights reserved.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	'geekypress_footer_copyright',
	array(
		'label'   => __( 'Copyright Text', 'geekypress' ),
		'section' => 'geekypress_footer_section',
		'type'    => 'text',
	)
);

// Built With Text
$wp_customize->add_setting(
	'geekypress_footer_credit',
	array(
		'default'           => 'Built with WordPress.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	'geekypress_footer_credit',
	array(
		'label'   => __( 'Platform Credit Text', 'geekypress' ),
		'section' => 'geekypress_footer_section',
		'type'    => 'text',
	)
);

// Back to Top Button
$wp_customize->add_setting(
	'geekypress_back_to_top',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_back_to_top',
	array(
		'label'   => __( 'Show "Back to Top" Arrow', 'geekypress' ),
		'section' => 'geekypress_footer_section',
		'type'    => 'checkbox',
	)
);
