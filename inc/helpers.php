<?php
/**
 * GeekyPress Helpers & Sanitization Callbacks
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize checkboxes.
 *
 * @param mixed $checked
 * @return bool
 */
function geekypress_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === (bool) $checked ) || '1' === $checked || 1 === $checked );
}

/**
 * Sanitize repeater JSON data.
 *
 * @param mixed $input
 * @return string JSON encoded string.
 */
function geekypress_sanitize_repeater( $input ) {
	if ( empty( $input ) ) {
		return '[]';
	}
	if ( is_array( $input ) ) {
		return wp_json_encode( $input );
	}
	$decoded = json_decode( $input, true );
	if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded ) ) {
		return wp_json_encode( $decoded );
	}
	return '[]';
}

/**
 * Get section defaults for ordering.
 *
 * @return array
 */
function geekypress_get_section_defaults() {
	return array(
		array( 'slug' => 'hero',       'label' => __( 'Hero & Terminal', 'geekypress' ),       'enabled' => true ),
		array( 'slug' => 'about',      'label' => __( 'About Me', 'geekypress' ),             'enabled' => true ),
		array( 'slug' => 'skills',     'label' => __( 'Skills & Expertise', 'geekypress' ),    'enabled' => true ),
		array( 'slug' => 'experience', 'label' => __( 'Work Experience', 'geekypress' ),       'enabled' => true ),
		array( 'slug' => 'projects',   'label' => __( 'Projects & Products', 'geekypress' ),   'enabled' => true ),
		array( 'slug' => 'interests',  'label' => __( 'Interests & Curiosities', 'geekypress' ), 'enabled' => true ),
		array( 'slug' => 'contact',    'label' => __( 'Contact & Socials', 'geekypress' ),     'enabled' => true ),
		array( 'slug' => 'cta',        'label' => __( 'Call to Action', 'geekypress' ),        'enabled' => true ),
	);
}

/**
 * Parse and retrieve configured section order.
 *
 * @return array
 */
function geekypress_get_section_order() {
	$defaults = geekypress_get_section_defaults();
	$raw      = get_theme_mod( 'geekypress_section_order', '' );

	if ( empty( $raw ) ) {
		return $defaults;
	}

	if ( is_array( $raw ) ) {
		$decoded = $raw;
	} else {
		$decoded = json_decode( $raw, true );
	}

	if ( ! is_array( $decoded ) || empty( $decoded ) ) {
		return $defaults;
	}

	$valid_slugs = array_column( $defaults, 'slug' );
	$defaults_by_slug = array_column( $defaults, null, 'slug' );
	$parsed = array();

	foreach ( $decoded as $item ) {
		if ( ! is_array( $item ) || empty( $item['slug'] ) ) {
			continue;
		}
		$slug = sanitize_key( $item['slug'] );
		if ( ! in_array( $slug, $valid_slugs, true ) ) {
			continue;
		}
		$parsed[] = array(
			'slug'    => $slug,
			'label'   => isset( $defaults_by_slug[ $slug ]['label'] ) ? $defaults_by_slug[ $slug ]['label'] : ucfirst( $slug ),
			'enabled' => isset( $item['enabled'] ) ? (bool) $item['enabled'] : true,
		);
		unset( $defaults_by_slug[ $slug ] );
	}

	// Append any missing defaults
	foreach ( $defaults_by_slug as $rem ) {
		$parsed[] = $rem;
	}

	return $parsed;
}

/**
 * Helper to decode repeater theme mod with fallback.
 *
 * @param string $mod_name
 * @param array $fallback
 * @return array
 */
function geekypress_get_repeater_data( $mod_name, $fallback = array() ) {
	$raw = get_theme_mod( $mod_name, $fallback );
	if ( is_array( $raw ) ) {
		return $raw;
	}
	if ( is_string( $raw ) && ! empty( $raw ) ) {
		$decoded = json_decode( $raw, true );
		if ( is_array( $decoded ) ) {
			return $decoded;
		}
	}
	return $fallback;
}

/**
 * Returns available font definitions with Google Fonts and local fallbacks.
 *
 * @return array
 */
function geekypress_get_font_definitions() {
	return array(
		'fira-code' => array(
			'name'         => 'Fira Code (Developer & Ligatures)',
			'family'       => '"Fira Code", "Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => 'Fira Code:wght@400;500;600;700',
			'is_mono'      => true,
		),
		'jetbrains-mono' => array(
			'name'         => 'JetBrains Mono (Modern IDE Font)',
			'family'       => '"JetBrains Mono", "Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => 'JetBrains Mono:wght@400;500;600;700',
			'is_mono'      => true,
		),
		'space-mono' => array(
			'name'         => 'Space Mono (Cyberpunk / Terminal)',
			'family'       => '"Space Mono", "Geist Mono", monospace',
			'google_name'  => 'Space Mono:ital,wght@0,400;0,700;1,400',
			'is_mono'      => true,
		),
		'source-code-pro' => array(
			'name'         => 'Source Code Pro (Adobe Terminal)',
			'family'       => '"Source Code Pro", "Geist Mono", monospace',
			'google_name'  => 'Source Code Pro:wght@400;600;700',
			'is_mono'      => true,
		),
		'inconsolata' => array(
			'name'         => 'Inconsolata (Classic Hacker Monospace)',
			'family'       => '"Inconsolata", "Geist Mono", monospace',
			'google_name'  => 'Inconsolata:wght@400;600;700',
			'is_mono'      => true,
		),
		'share-tech-mono' => array(
			'name'         => 'Share Tech Mono (Sci-Fi Console)',
			'family'       => '"Share Tech Mono", "Geist Mono", monospace',
			'google_name'  => 'Share Tech Mono',
			'is_mono'      => true,
		),
		'vt323' => array(
			'name'         => 'VT323 (Retro 80s CRT Terminal)',
			'family'       => '"VT323", monospace',
			'google_name'  => 'VT323',
			'is_mono'      => true,
		),
		'roboto-mono' => array(
			'name'         => 'Roboto Mono (Google Monospace)',
			'family'       => '"Roboto Mono", monospace',
			'google_name'  => 'Roboto Mono:wght@400;500;700',
			'is_mono'      => true,
		),
		'geist-mono' => array(
			'name'         => 'Geist Mono (Local Variable Font)',
			'family'       => '"Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'inter' => array(
			'name'         => 'Inter (Modern Tech Sans)',
			'family'       => '"Inter", "Geist Sans", system-ui, -apple-system, sans-serif',
			'google_name'  => 'Inter:wght@400;500;600;700',
			'is_mono'      => false,
		),
		'space-grotesk' => array(
			'name'         => 'Space Grotesk (Tech Geometric)',
			'family'       => '"Space Grotesk", "Geist Sans", sans-serif',
			'google_name'  => 'Space Grotesk:wght@400;500;600;700',
			'is_mono'      => false,
		),
		'plus-jakarta-sans' => array(
			'name'         => 'Plus Jakarta Sans (Developer Portfolio)',
			'family'       => '"Plus Jakarta Sans", "Geist Sans", sans-serif',
			'google_name'  => 'Plus Jakarta Sans:wght@400;500;600;700',
			'is_mono'      => false,
		),
		'outfit' => array(
			'name'         => 'Outfit (Clean Futuristic)',
			'family'       => '"Outfit", "Geist Sans", sans-serif',
			'google_name'  => 'Outfit:wght@400;500;600;700',
			'is_mono'      => false,
		),
		'geist-sans' => array(
			'name'         => 'Geist Sans (Local Variable Font)',
			'family'       => '"Geist Sans", system-ui, -apple-system, sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
		'system' => array(
			'name'         => 'System Default (OS Native)',
			'family'       => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
	);
}

/**
 * Sanitize font choice against registered fonts.
 *
 * @param string $input
 * @return string
 */
function geekypress_sanitize_font_choice( $input ) {
	$valid = geekypress_get_font_definitions();
	return isset( $valid[ $input ] ) ? $input : 'fira-code';
}

/**
 * Sanitize color mode setting (dark, light, auto).
 *
 * @param string $input
 * @return string
 */
function geekypress_sanitize_color_mode( $input ) {
	$valid = array( 'dark', 'light', 'auto' );
	return in_array( $input, $valid, true ) ? $input : 'dark';
}

