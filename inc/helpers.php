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
 * Recursively validates and sanitizes all fields within repeater arrays
 * (e.g. text fields, URLs, icons, descriptions, and boolean flags).
 *
 * @param mixed $input
 * @return string JSON encoded string.
 */
function geekypress_sanitize_repeater( $input ) {
	if ( empty( $input ) ) {
		return '[]';
	}
	$decoded = is_array( $input ) ? $input : json_decode( $input, true );
	if ( ! is_array( $decoded ) || json_last_error() !== JSON_ERROR_NONE ) {
		return '[]';
	}

	$sanitized = array();
	foreach ( $decoded as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$clean_item = array();
		foreach ( $item as $key => $value ) {
			$clean_key = sanitize_key( $key );
			if ( is_bool( $value ) || '1' === $value || '0' === $value ) {
				$clean_item[ $clean_key ] = (bool) $value;
			} elseif ( 'icon' === $clean_key ) {
				$clean_item[ $clean_key ] = sanitize_key( $value );
			} elseif ( strpos( $clean_key, 'url' ) !== false || strpos( $clean_key, 'link' ) !== false ) {
				$clean_item[ $clean_key ] = esc_url_raw( (string) $value );
			} elseif ( 'percent' === $clean_key || 'percentage' === $clean_key ) {
				$clean_item[ $clean_key ] = min( 100, max( 0, absint( $value ) ) );
			} elseif ( 'description' === $clean_key || 'desc' === $clean_key ) {
				$clean_item[ $clean_key ] = sanitize_textarea_field( (string) $value );
			} else {
				$clean_item[ $clean_key ] = sanitize_text_field( (string) $value );
			}
		}
		if ( ! empty( $clean_item ) ) {
			$sanitized[] = $clean_item;
		}
	}

	return wp_json_encode( $sanitized );
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
		array( 'slug' => 'stats',      'label' => __( 'Stats & Metrics', 'geekypress' ),       'enabled' => true ),
		array( 'slug' => 'blog',       'label' => __( 'Blog & Articles', 'geekypress' ),       'enabled' => true ),
		array( 'slug' => 'contact',    'label' => __( 'Contact & Socials', 'geekypress' ),     'enabled' => true ),
		array( 'slug' => 'cta',        'label' => __( "Call to Action (Let's talk WordPress)", 'geekypress' ), 'enabled' => true ),
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

	$valid_slugs      = array_column( $defaults, 'slug' );
	$defaults_by_slug = array_column( $defaults, null, 'slug' );
	$parsed           = array();

	foreach ( $decoded as $item ) {
		if ( ! is_array( $item ) || empty( $item['slug'] ) ) {
			continue;
		}
		$slug = sanitize_key( $item['slug'] );
		// Backwards compatibility: map legacy 'interests' to 'stats'
		if ( 'interests' === $slug ) {
			$slug = 'stats';
		}
		if ( ! in_array( $slug, $valid_slugs, true ) ) {
			continue;
		}
		if ( isset( $defaults_by_slug[ $slug ] ) ) {
			$parsed[] = array(
				'slug'    => $slug,
				'label'   => isset( $defaults_by_slug[ $slug ]['label'] ) ? $defaults_by_slug[ $slug ]['label'] : ucfirst( $slug ),
				'enabled' => isset( $item['enabled'] ) ? (bool) $item['enabled'] : true,
			);
			unset( $defaults_by_slug[ $slug ] );
		}
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
		'geist-mono' => array(
			'name'         => 'Geist Mono (Bundled Variable Font)',
			'family'       => '"Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'fira-code' => array(
			'name'         => 'Fira Code (Developer & Ligatures)',
			'family'       => '"Fira Code", "Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'jetbrains-mono' => array(
			'name'         => 'JetBrains Mono (Modern IDE Font)',
			'family'       => '"JetBrains Mono", "Geist Mono", "SFMono-Regular", Consolas, monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'space-mono' => array(
			'name'         => 'Space Mono (Cyberpunk / Terminal)',
			'family'       => '"Space Mono", "Geist Mono", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'source-code-pro' => array(
			'name'         => 'Source Code Pro (Adobe Terminal)',
			'family'       => '"Source Code Pro", "Geist Mono", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'inconsolata' => array(
			'name'         => 'Inconsolata (Classic Hacker Monospace)',
			'family'       => '"Inconsolata", "Geist Mono", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'share-tech-mono' => array(
			'name'         => 'Share Tech Mono (Sci-Fi Console)',
			'family'       => '"Share Tech Mono", "Geist Mono", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'vt323' => array(
			'name'         => 'VT323 (Retro 80s CRT Terminal)',
			'family'       => '"VT323", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'roboto-mono' => array(
			'name'         => 'Roboto Mono (Monospace)',
			'family'       => '"Roboto Mono", monospace',
			'google_name'  => null,
			'is_mono'      => true,
		),
		'geist-sans' => array(
			'name'         => 'Geist Sans (Bundled Variable Font)',
			'family'       => '"Geist Sans", system-ui, -apple-system, sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
		'inter' => array(
			'name'         => 'Inter (Modern Tech Sans)',
			'family'       => '"Inter", "Geist Sans", system-ui, -apple-system, sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
		'space-grotesk' => array(
			'name'         => 'Space Grotesk (Tech Geometric)',
			'family'       => '"Space Grotesk", "Geist Sans", sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
		'plus-jakarta-sans' => array(
			'name'         => 'Plus Jakarta Sans (Developer Portfolio)',
			'family'       => '"Plus Jakarta Sans", "Geist Sans", sans-serif',
			'google_name'  => null,
			'is_mono'      => false,
		),
		'outfit' => array(
			'name'         => 'Outfit (Clean Futuristic)',
			'family'       => '"Outfit", "Geist Sans", sans-serif',
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

/**
 * Calculates estimated reading time for a given post.
 *
 * @param int|WP_Post|null $post Optional post ID or object.
 * @return string Formatted reading time (e.g., "3 min read").
 */
function geekypress_get_reading_time( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return esc_html__( '1 min read', 'geekypress' );
	}

	$words   = str_word_count( wp_strip_all_tags( $post->post_content ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );

	return sprintf(
		/* translators: %d: number of minutes */
		_n( '%d min read', '%d min read', $minutes, 'geekypress' ),
		$minutes
	);
}


