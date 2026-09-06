<?php
/**
 * Customizer: Call to Action Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'geekypress_cta_section',
	array(
		'title'    => __( 'Call to Action / Let\'s talk WordPress', 'geekypress' ),
		'panel'    => 'geekypress_theme_panel',
		'priority' => 90,
	)
);

// Section Enabled
$wp_customize->add_setting(
	'geekypress_cta_enabled',
	array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'geekypress_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'geekypress_cta_enabled',
	array(
		'label'   => __( 'Enable CTA Section', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'checkbox',
	)
);

// Label
$wp_customize->add_setting(
	'geekypress_cta_label',
	array(
		'default'           => '// START A CONVERSATION',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_label',
	array(
		'label'   => __( 'Section Label', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Headline Prefix
$wp_customize->add_setting(
	'geekypress_cta_title_prefix',
	array(
		'default'           => "Let's talk",
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_prefix',
	array(
		'label'   => __( 'Headline Prefix', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Highlighted Word
$wp_customize->add_setting(
	'geekypress_cta_title_highlight',
	array(
		'default'           => 'WordPress',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_highlight',
	array(
		'label'   => __( 'Highlighted Keyword (in Green)', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Headline Suffix
$wp_customize->add_setting(
	'geekypress_cta_title_suffix',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_title_suffix',
	array(
		'label'   => __( 'Headline Suffix', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Description
$wp_customize->add_setting(
	'geekypress_cta_description',
	array(
		'default'           => 'Whether you have an upcoming project, need technical consultation, or just want to connect, send a terminal dispatch below.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_textarea_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_description',
	array(
		'label'       => __( 'Description / Form Prompt', 'geekypress' ),
		'description' => __( 'Appears directly above the interactive contact form.', 'geekypress' ),
		'section'     => 'geekypress_cta_section',
		'type'        => 'textarea',
	)
);

// Target Email Address for Submissions
$wp_customize->add_setting(
	'geekypress_cta_recipient_email',
	array(
		'default'           => 'hello@example.com',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_email',
	)
);
$wp_customize->add_control(
	'geekypress_cta_recipient_email',
	array(
		'label'       => __( 'Recipient Email Address', 'geekypress' ),
		'description' => __( 'Where terminal form dispatches will be directed.', 'geekypress' ),
		'section'     => 'geekypress_cta_section',
		'type'        => 'email',
	)
);

// Name Field Placeholder
$wp_customize->add_setting(
	'geekypress_cta_name_placeholder',
	array(
		'default'           => 'Your Name or Developer Handle',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_name_placeholder',
	array(
		'label'   => __( 'Name Field Placeholder', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Email Field Placeholder
$wp_customize->add_setting(
	'geekypress_cta_email_placeholder',
	array(
		'default'           => 'your.email@example.com',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_email_placeholder',
	array(
		'label'   => __( 'Email Field Placeholder', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Message Field Placeholder
$wp_customize->add_setting(
	'geekypress_cta_msg_placeholder',
	array(
		'default'           => 'Brief description of your project or idea...',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_msg_placeholder',
	array(
		'label'   => __( 'Message Field Placeholder', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Submit Button Text
$wp_customize->add_setting(
	'geekypress_cta_btn_text',
	array(
		'default'           => '>_ Send Message',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_btn_text',
	array(
		'label'   => __( 'Submit Button Text', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

// Success Feedback Message
$wp_customize->add_setting(
	'geekypress_cta_success_msg',
	array(
		'default'           => '[OK] Opening your email client to dispatch...',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	'geekypress_cta_success_msg',
	array(
		'label'   => __( 'Success Notification Text', 'geekypress' ),
		'section' => 'geekypress_cta_section',
		'type'    => 'text',
	)
);

