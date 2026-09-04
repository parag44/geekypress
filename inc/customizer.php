<?php
/**
 * GeekyPress Customizer Bootstrap
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function geekypress_customize_register( $wp_customize ) {

	// Include custom controls
	require_once get_template_directory() . '/inc/customizer/controls/class-geekypress-repeater-control.php';

	// Main GeekyPress Panel
	$wp_customize->add_panel(
		'geekypress_theme_panel',
		array(
			'priority'    => 25,
			'title'       => __( 'GeekyPress Settings', 'geekypress' ),
			'description' => __( 'Customize your developer portfolio sections, terminal profile, projects, skills, and layout live.', 'geekypress' ),
		)
	);

	// Load Section configurations
	require_once get_template_directory() . '/inc/customizer/sections/header.php';
	require_once get_template_directory() . '/inc/customizer/sections/design.php';
	require_once get_template_directory() . '/inc/customizer/sections/typography.php';
	require_once get_template_directory() . '/inc/customizer/sections/hero.php';
	require_once get_template_directory() . '/inc/customizer/sections/about.php';
	require_once get_template_directory() . '/inc/customizer/sections/projects.php';
	require_once get_template_directory() . '/inc/customizer/sections/skills.php';
	require_once get_template_directory() . '/inc/customizer/sections/experience.php';
	require_once get_template_directory() . '/inc/customizer/sections/interests.php';
	require_once get_template_directory() . '/inc/customizer/sections/blog.php';
	require_once get_template_directory() . '/inc/customizer/sections/contact.php';
	require_once get_template_directory() . '/inc/customizer/sections/cta.php';
	require_once get_template_directory() . '/inc/customizer/sections/footer.php';
	require_once get_template_directory() . '/inc/customizer/sections/section-order.php';
}
add_action( 'customize_register', 'geekypress_customize_register' );

/**
 * Enqueue live preview JS in Customizer iframe.
 */
function geekypress_customize_preview_js() {
	wp_enqueue_script(
		'geekypress-customizer-preview',
		get_theme_file_uri( 'assets/js/customizer-preview.js' ),
		array( 'customize-preview', 'jquery' ),
		filemtime( get_theme_file_path( 'assets/js/customizer-preview.js' ) ),
		true
	);
}
add_action( 'customize_preview_init', 'geekypress_customize_preview_js' );

/**
 * Enqueue controls pane script to support preview-to-control deep linking.
 */
function geekypress_customize_controls_js() {
	wp_enqueue_script(
		'geekypress-customizer-controls',
		get_theme_file_uri( 'assets/js/customizer-controls.js' ),
		array( 'customize-controls', 'jquery' ),
		filemtime( get_theme_file_path( 'assets/js/customizer-controls.js' ) ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'geekypress_customize_controls_js' );

