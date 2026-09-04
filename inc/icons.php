<?php
/**
 * GeekyPress SVG Icon System
 *
 * Lightweight, accessible, zero-dependency inline SVG icon library
 * based on Lucide Icons (ISC License). Replaces frontend Dashicons.
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalizes an icon slug, mapping legacy Dashicons to modern Lucide equivalents.
 *
 * @param string $icon_name Raw icon name or dashicon class.
 * @return string Normalized icon slug.
 */
function geekypress_normalize_icon( $icon_name ) {
	$icon_name = trim( (string) $icon_name );

	// Legacy Dashicons to Lucide mapping dictionary
	$legacy_map = array(
		'dashicons-admin-tools'          => 'wrench',
		'dashicons-admin-site'           => 'globe',
		'dashicons-admin-site-alt3'      => 'server',
		'dashicons-wordpress'            => 'code',
		'dashicons-wordpress-alt'        => 'globe',
		'dashicons-editor-code'          => 'file-code',
		'dashicons-desktop'              => 'monitor',
		'dashicons-laptop'               => 'laptop',
		'dashicons-smartphone'           => 'smartphone',
		'dashicons-tablet'               => 'tablet',
		'dashicons-database'             => 'database',
		'dashicons-rest-api'             => 'webhook',
		'dashicons-cloud'                => 'cloud',
		'dashicons-networking'           => 'network',
		'dashicons-shield'               => 'shield-check',
		'dashicons-shield-alt'           => 'shield',
		'dashicons-lock'                 => 'lock',
		'dashicons-unlock'               => 'unlock',
		'dashicons-portfolio'            => 'briefcase',
		'dashicons-clock'                => 'clock',
		'dashicons-calendar'             => 'calendar',
		'dashicons-performance'          => 'zap',
		'dashicons-chart-bar'            => 'bar-chart-3',
		'dashicons-chart-line'           => 'trending-up',
		'dashicons-analytics'            => 'activity',
		'dashicons-visibility'           => 'eye',
		'dashicons-groups'               => 'users',
		'dashicons-buddicons-community'  => 'users',
		'dashicons-sos'                  => 'life-buoy',
		'dashicons-tickets-alt'          => 'ticket',
		'dashicons-randomize'            => 'git-branch',
		'dashicons-flag'                 => 'book-open',
		'dashicons-star-filled'          => 'star',
		'dashicons-heart'                => 'heart',
		'dashicons-yes'                  => 'check-circle',
		'dashicons-yes-alt'              => 'check',
		'dashicons-marker'               => 'map-pin',
		'dashicons-location'             => 'compass',
		'dashicons-email'                => 'mail',
		'dashicons-email-alt'            => 'mail',
		'dashicons-share'                => 'share-2',
		'dashicons-external'             => 'external-link',
		'dashicons-media-code'           => 'code-xml',
		'dashicons-media-document'       => 'file-text',
		'dashicons-format-aside'         => 'file-text',
		'dashicons-format-status'        => 'activity',
		'dashicons-layout'               => 'layout',
		'dashicons-welcome-widgets-menus'=> 'layout-grid',
		'dashicons-category'             => 'layers',
		'dashicons-tag'                  => 'tag',
		'dashicons-superhero'            => 'rocket',
		'dashicons-superhero-alt'        => 'zap',
		'dashicons-awards'               => 'award',
		'dashicons-lightbulb'            => 'sparkles',
		'dashicons-coffee'               => 'coffee',
		'dashicons-beer'                 => 'coffee',
		'dashicons-art'                  => 'palette',
		'dashicons-camera'               => 'camera',
		'dashicons-twitter'              => 'twitter',
		'dashicons-facebook'             => 'facebook',
		'dashicons-facebook-alt'         => 'facebook',
		'dashicons-youtube'              => 'youtube',
		'dashicons-instagram'            => 'instagram',
		'dashicons-rss'                  => 'rss',
		// Common social aliases & mono badges
		'gh'                             => 'github',
		'github'                         => 'github',
		'in'                             => 'linkedin',
		'linkedin'                       => 'linkedin',
		'twitter'                        => 'twitter',
		'x'                              => 'x',
		'@'                              => 'mail',
		'email'                          => 'mail',
	);

	if ( isset( $legacy_map[ $icon_name ] ) ) {
		return $legacy_map[ $icon_name ];
	}

	// Remove dashicons- prefix if any unmapped remains
	if ( strpos( $icon_name, 'dashicons-' ) === 0 ) {
		$cleaned = substr( $icon_name, 10 );
		if ( isset( $legacy_map[ $icon_name ] ) ) {
			return $legacy_map[ $icon_name ];
		}
		$icon_name = $cleaned;
	}

	return sanitize_key( $icon_name );
}

/**
 * Returns raw inner SVG markup for a given icon slug.
 *
 * @param string $name Normalized icon slug.
 * @return string Inner SVG paths and elements.
 */
function geekypress_get_icon_paths( $name ) {
	$icons = array(
		'terminal' => '<polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line>',
		'code' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline>',
		'code-xml' => '<polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline><line x1="14" y1="4" x2="10" y2="20"></line>',
		'file-code' => '<path d="M10 12.5 8 15l2 2.5"></path><path d="m14 12.5 2 2.5-2 2.5"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>',
		'file-text' => '<path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path>',
		'braces' => '<path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5a2 2 0 0 0 2 2h1"></path><path d="M16 21h1a2 2 0 0 0 2-2v-5a2 2 0 0 1 2-2 2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1"></path>',
		'binary' => '<rect x="14" y="14" width="4" height="6" rx="2"></rect><rect x="6" y="4" width="4" height="6" rx="2"></rect><path d="M6 20h4"></path><path d="M14 10h4"></path><path d="M6 14h2v6"></path><path d="M14 4h2v6"></path>',
		'cpu' => '<rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="9" y="9" width="6" height="6"></rect><path d="M15 2v2"></path><path d="M15 20v2"></path><path d="M2 15h2"></path><path d="M2 9h2"></path><path d="M20 15h2"></path><path d="M20 9h2"></path><path d="M9 2v2"></path><path d="M9 20v2"></path>',
		'database' => '<ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5V19A9 3 0 0 0 21 19V5"></path><path d="M3 12A9 3 0 0 0 21 12"></path>',
		'server' => '<rect width="20" height="8" x="2" y="2" rx="2" ry="2"></rect><rect width="20" height="8" x="2" y="14" rx="2" ry="2"></rect><line x1="6" x2="6.01" y1="6" y2="6"></line><line x1="6" x2="6.01" y1="18" y2="18"></line>',
		'hard-drive' => '<line x1="22" x2="2" y1="12" y2="12"></line><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" x2="6.01" y1="16" y2="16"></line><line x1="10" x2="10.01" y1="16" y2="16"></line>',
		'globe' => '<circle cx="12" cy="12" r="10"></circle><line x1="2" x2="22" y1="12" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
		'network' => '<rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path>',
		'webhook' => '<path d="M18 16.98h-5.99c-1.1 0-1.95.94-2.48 1.9A4 4 0 0 1 2 17c.01-.61.16-1.2.42-1.74L8 4.99"></path><path d="m14 13 4 4 4-4"></path><path d="M18 17V3"></path>',
		'git-branch' => '<line x1="6" x2="6" y1="3" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path>',
		'git-commit' => '<circle cx="12" cy="12" r="3"></circle><line x1="3" x2="9" y1="12" y2="12"></line><line x1="15" x2="21" y1="12" y2="12"></line>',
		'git-pull-request' => '<circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" x2="6" y1="9" y2="21"></line>',
		'git-fork' => '<circle cx="12" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><circle cx="18" cy="6" r="3"></circle><path d="M18 9v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V9"></path><path d="M12 12v3"></path>',
		'folder-git-2' => '<path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"></path><circle cx="13" cy="12" r="2"></circle><path d="M18 19c-2.8 0-5-2.2-5-5v8"></path><circle cx="20" cy="19" r="2"></circle>',
		'workflow' => '<rect width="8" height="8" x="3" y="3" rx="2"></rect><path d="M7 11v4a2 2 0 0 0 2 2h4"></path><rect width="8" height="8" x="13" y="13" rx="2"></rect>',
		'cloud' => '<path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path>',
		'cloud-lightning' => '<path d="M6 16.326A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 .5 8.973"></path><path d="m13 12-3 5h4l-3 5"></path>',
		'rocket' => '<path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>',
		'package' => '<path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path>',
		'boxes' => '<path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"></path><path d="m7 16.5-4.74-2.85"></path><path d="m7 16.5 5-3"></path><path d="M7 16.5v5.17"></path><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"></path><path d="m17 16.5-5-3"></path><path d="m17 16.5 4.74-2.85"></path><path d="M17 16.5v5.17"></path><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"></path><path d="M12 8 7.26 5.15"></path><path d="m12 8 4.74-2.85"></path><path d="M12 13.5V8"></path>',
		'layers' => '<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline>',
		'layout' => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><line x1="3" x2="21" y1="9" y2="9"></line><line x1="9" x2="9" y1="21" y2="9"></line>',
		'layout-grid' => '<rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect>',
		'panels-top-left' => '<rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M9 21V9"></path>',
		'component' => '<path d="M5.5 8.5 9 12l-3.5 3.5L2 12l3.5-3.5Z"></path><path d="m12 2 3.5 3.5L12 9 8.5 5.5 12 2Z"></path><path d="M18.5 8.5 22 12l-3.5 3.5L15 12l3.5-3.5Z"></path><path d="m12 15 3.5 3.5L12 22l-3.5-3.5L12 15Z"></path>',
		'bug' => '<rect width="8" height="14" x="8" y="6" rx="4"></rect><path d="m19 7-3 2"></path><path d="m5 7 3 2"></path><path d="m19 19-3-2"></path><path d="m5 19 3-2"></path><path d="M20 13h-4"></path><path d="M4 13h4"></path><path d="m10 4 1 2"></path><path d="m14 4-1 2"></path>',
		'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>',
		'shield-check' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path>',
		'shield-alert' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path>',
		'lock' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>',
		'unlock' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path>',
		'key' => '<path d="m21 2-2 2m-1.5 1.5L14 9"></path><path d="m15.5 7.5 3 3L22 7l-3-3"></path><circle cx="7.5" cy="15.5" r="5.5"></circle>',
		'wrench' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>',
		'life-buoy' => '<circle cx="12" cy="12" r="10"></circle><path d="m4.93 4.93 4.24 4.24"></path><path d="m14.83 9.17 4.24-4.24"></path><path d="m14.83 14.83 4.24 4.24"></path><path d="m9.17 14.83-4.24 4.24"></path><circle cx="12" cy="12" r="4"></circle>',
		'zap' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
		'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>',
		'trending-up' => '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline>',
		'bar-chart' => '<line x1="12" x2="12" y1="20" y2="10"></line><line x1="18" x2="18" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="16"></line>',
		'bar-chart-2' => '<line x1="18" x2="18" y1="20" y2="10"></line><line x1="12" x2="12" y1="20" y2="4"></line><line x1="6" x2="6" y1="20" y2="14"></line>',
		'bar-chart-3' => '<path d="M3 3v18h18"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path>',
		'clock' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
		'calendar' => '<rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line>',
		'briefcase' => '<rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>',
		'ticket' => '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path>',
		'book-open' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>',
		'check-circle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
		'check' => '<polyline points="20 6 9 17 4 12"></polyline>',
		'alert-triangle' => '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" x2="12" y1="9" y2="13"></line><line x1="12" x2="12.01" y1="17" y2="17"></line>',
		'monitor' => '<rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line>',
		'laptop' => '<path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"></path>',
		'smartphone' => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><line x1="12" x2="12.01" y1="18" y2="18"></line>',
		'tablet' => '<rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><line x1="12" x2="12.01" y1="18" y2="18"></line>',
		'compass' => '<circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>',
		'map-pin' => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle>',
		'sparkles' => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path><path d="M5 3v4"></path><path d="M19 17v4"></path><path d="M3 5h4"></path><path d="M17 19h4"></path>',
		'bot' => '<path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path>',
		'brain' => '<path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-5.04Z"></path><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-5.04Z"></path>',
		'headphones' => '<path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"></path>',
		'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle>',
		'coffee' => '<path d="M17 8h1a4 4 0 1 1 0 8h-1"></path><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path><line x1="6" x2="6" y1="2" y2="4"></line><line x1="10" x2="10" y1="2" y2="4"></line><line x1="14" x2="14" y1="2" y2="4"></line>',
		'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
		'heart' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>',
		'mail' => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>',
		'share-2' => '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>',
		'external-link' => '<path d="M15 3h6v6"></path><path d="M10 14 21 3"></path><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>',
		'search' => '<circle cx="11" cy="11" r="8"></circle><line x1="21" x2="16.65" y1="21" y2="16.65"></line>',
		'eye' => '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>',
		'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
		'tag' => '<path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path><path d="M7 7h.01"></path>',
		'award' => '<circle cx="12" cy="8" r="6"></circle><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>',
		'palette' => '<circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C22 6.5 17.5 2 12 2Z"></path>',
		'github' => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path>',
		'linkedin' => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle>',
		'twitter' => '<path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>',
		'x' => '<path d="m4 4 10.3 12.3L4 20h2.3l8.8-7 4.9 7H20l-10.7-12.7L19.3 4H17l-8.4 6.7L4.7 4z"></path>',
		'gitlab' => '<path d="m22 13.29-3.33-10a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18l-2.26 6.67H8.32L6.06 3.26a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18L2 13.29a.74.74 0 0 0 .27.83L12 21l9.69-6.88a.71.71 0 0 0 .31-.83Z"></path>',
		'codepen' => '<polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"></polygon><line x1="12" x2="12" y1="22" y2="15.5"></line><polyline points="22 8.5 12 15.5 2 8.5"></polyline><polyline points="2 15.5 12 8.5 22 15.5"></polyline><line x1="12" x2="12" y1="2" y2="8.5"></line>',
		'dribbble' => '<circle cx="12" cy="12" r="10"></circle><path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path><path d="M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"></path><path d="M8.56 2.75c4.37 6 6 9.42 8 17.72"></path>',
		'youtube' => '<path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"></path><polygon points="10 15 15 12 10 9 10 15"></polygon>',
		'instagram' => '<rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>',
		'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
		'twitch' => '<path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path>',
		'slack' => '<rect width="3" height="8" x="13" y="2" rx="1.5"></rect><path d="M19 8.5V10h-1.5A1.5 1.5 0 1 1 19 8.5"></path><rect width="3" height="8" x="8" y="14" rx="1.5"></rect><path d="M5 15.5V14h1.5A1.5 1.5 0 1 1 5 15.5"></path><rect width="8" height="3" x="14" y="13" rx="1.5"></rect><path d="M15.5 19H14v-1.5a1.5 1.5 0 1 1 1.5 1.5"></path><rect width="8" height="3" x="2" y="8" rx="1.5"></rect><path d="M8.5 5H10V3.5A1.5 1.5 0 1 1 8.5 5"></path>',
		'discord' => '<path d="M18 6h0a14.5 14.5 0 0 0-4-1.5c-.2.4-.4.9-.5 1.4a13.3 13.3 0 0 0-3 0c-.1-.5-.3-1-.5-1.4A14.5 14.5 0 0 0 6 6c-2.5 4-3 8-3 12 1.5 1.1 3 1.8 4.6 2 .4-.5.7-1 1-1.6-.6-.2-1.1-.5-1.6-.9.1-.1.3-.2.4-.3 3.1 1.5 6.5 1.5 9.6 0 .1.1.3.2.4.3-.5.4-1 .7-1.6.9.3.6.6 1.1 1 1.6 1.6-.2 3.1-.9 4.6-2 0-4-.5-8-3-12Z"></path><circle cx="9.5" cy="12" r="1.5"></circle><circle cx="14.5" cy="12" r="1.5"></circle>',
		'rss' => '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>',
		'send' => '<path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path>',
		'message-square' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>',
		'sun' => '<circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path>',
		'moon' => '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>',
		'arrow-left' => '<path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path>',
		'arrow-right' => '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
		'share-2' => '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>',
		'copy' => '<rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>',
		'check' => '<path d="M20 6 9 17l-5-5"></path>',
		'user' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['terminal'];
}

/**
 * Renders an inline SVG icon.
 *
 * @param string $name Raw or normalized icon slug.
 * @param string $class Optional extra CSS classes.
 * @param int    $size Width and height in pixels (default: 20).
 * @param array  $attrs Optional additional HTML attributes.
 * @return string Safe inline SVG HTML.
 */
function geekypress_get_icon( $name, $class = '', $size = 20, $attrs = array() ) {
	$normalized = geekypress_normalize_icon( $name );
	$paths      = geekypress_get_icon_paths( $normalized );
	$size       = absint( $size );
	if ( $size <= 0 ) {
		$size = 20;
	}

	$classes = array( 'gp-icon', 'gp-icon-' . sanitize_html_class( $normalized ) );
	if ( ! empty( $class ) ) {
		$classes[] = sanitize_html_class( $class );
	}

	$class_attr = esc_attr( implode( ' ', array_filter( $classes ) ) );

	$svg = sprintf(
		'<svg class="%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
		$class_attr,
		$size,
		$size,
		$paths
	);

	return $svg;
}

/**
 * Returns a catalog of available icons for the Customizer icon picker.
 *
 * @return array<int, array{slug:string,label:string,svg:string}>
 */
function geekypress_get_icon_catalog() {
	$list = array(
		array( 'slug' => 'terminal',        'label' => 'Terminal / Console' ),
		array( 'slug' => 'code',            'label' => 'Code / Tags' ),
		array( 'slug' => 'code-xml',        'label' => 'Code XML / Syntax' ),
		array( 'slug' => 'file-code',       'label' => 'Source Code File' ),
		array( 'slug' => 'file-text',       'label' => 'Document / Text' ),
		array( 'slug' => 'braces',          'label' => 'Curly Braces' ),
		array( 'slug' => 'binary',          'label' => 'Binary Code' ),
		array( 'slug' => 'cpu',             'label' => 'CPU / Hardware' ),
		array( 'slug' => 'database',        'label' => 'Database / SQL' ),
		array( 'slug' => 'server',          'label' => 'Server / Backend' ),
		array( 'slug' => 'hard-drive',      'label' => 'Hard Drive / Disk' ),
		array( 'slug' => 'globe',           'label' => 'Globe / Web / WordPress' ),
		array( 'slug' => 'network',         'label' => 'Network / Topology' ),
		array( 'slug' => 'webhook',         'label' => 'Webhook / API' ),
		array( 'slug' => 'git-branch',      'label' => 'Git Branch' ),
		array( 'slug' => 'git-commit',      'label' => 'Git Commit' ),
		array( 'slug' => 'git-pull-request', 'label' => 'Git Pull Request' ),
		array( 'slug' => 'git-fork',        'label' => 'Git Fork' ),
		array( 'slug' => 'folder-git-2',    'label' => 'Git Repository Folder' ),
		array( 'slug' => 'workflow',        'label' => 'Workflow / CI-CD' ),
		array( 'slug' => 'cloud',           'label' => 'Cloud Service' ),
		array( 'slug' => 'cloud-lightning', 'label' => 'Cloud Function / Lambda' ),
		array( 'slug' => 'rocket',          'label' => 'Rocket / Deploy' ),
		array( 'slug' => 'package',         'label' => 'Package / NPM / Composer' ),
		array( 'slug' => 'boxes',           'label' => 'Containers / Microservices' ),
		array( 'slug' => 'layers',          'label' => 'Layers / Full-Stack' ),
		array( 'slug' => 'layout',          'label' => 'Layout / Architecture' ),
		array( 'slug' => 'layout-grid',     'label' => 'Grid Layout / Components' ),
		array( 'slug' => 'panels-top-left', 'label' => 'Dashboard UI' ),
		array( 'slug' => 'component',       'label' => 'Design System Component' ),
		array( 'slug' => 'bug',             'label' => 'Bug / Debugging' ),
		array( 'slug' => 'shield',          'label' => 'Shield' ),
		array( 'slug' => 'shield-check',    'label' => 'Security Hardened' ),
		array( 'slug' => 'shield-alert',    'label' => 'Security Alert' ),
		array( 'slug' => 'lock',            'label' => 'Lock / SSL' ),
		array( 'slug' => 'unlock',          'label' => 'Unlock / Open Access' ),
		array( 'slug' => 'key',             'label' => 'Key / Auth Token' ),
		array( 'slug' => 'wrench',          'label' => 'Tools / Diagnostics' ),
		array( 'slug' => 'life-buoy',       'label' => 'Support / Recovery' ),
		array( 'slug' => 'zap',             'label' => 'Speed / Performance' ),
		array( 'slug' => 'activity',        'label' => 'Activity / Monitoring' ),
		array( 'slug' => 'trending-up',     'label' => 'Growth / Metrics' ),
		array( 'slug' => 'bar-chart-3',     'label' => 'Analytics / Dashboard' ),
		array( 'slug' => 'clock',           'label' => 'Clock / Experience' ),
		array( 'slug' => 'calendar',        'label' => 'Calendar / Schedule' ),
		array( 'slug' => 'briefcase',       'label' => 'Briefcase / Projects' ),
		array( 'slug' => 'ticket',          'label' => 'Ticket / Issues' ),
		array( 'slug' => 'book-open',       'label' => 'Documentation / Specs' ),
		array( 'slug' => 'check-circle',    'label' => 'Check Circle / Resolved' ),
		array( 'slug' => 'check',           'label' => 'Checkmark' ),
		array( 'slug' => 'alert-triangle',  'label' => 'Warning / Alert' ),
		array( 'slug' => 'monitor',         'label' => 'Monitor / Desktop' ),
		array( 'slug' => 'laptop',          'label' => 'Laptop / Workstation' ),
		array( 'slug' => 'smartphone',      'label' => 'Smartphone / Mobile' ),
		array( 'slug' => 'tablet',          'label' => 'Tablet' ),
		array( 'slug' => 'compass',         'label' => 'Compass / Navigation' ),
		array( 'slug' => 'map-pin',         'label' => 'Map Pin / Location' ),
		array( 'slug' => 'sparkles',        'label' => 'AI / Innovation' ),
		array( 'slug' => 'bot',             'label' => 'Bot / Automation' ),
		array( 'slug' => 'brain',           'label' => 'Brain / Neural Network' ),
		array( 'slug' => 'headphones',      'label' => 'Audio / Support' ),
		array( 'slug' => 'camera',          'label' => 'Camera / Media' ),
		array( 'slug' => 'coffee',          'label' => 'Coffee / Lifestyle' ),
		array( 'slug' => 'star',            'label' => 'Star / Featured' ),
		array( 'slug' => 'heart',           'label' => 'Heart / Open Source' ),
		array( 'slug' => 'mail',            'label' => 'Mail / Email' ),
		array( 'slug' => 'share-2',         'label' => 'Share' ),
		array( 'slug' => 'external-link',   'label' => 'External Link' ),
		array( 'slug' => 'search',          'label' => 'Search / Query' ),
		array( 'slug' => 'eye',             'label' => 'View / Preview' ),
		array( 'slug' => 'users',           'label' => 'Users / Team' ),
		array( 'slug' => 'tag',             'label' => 'Tag / Category' ),
		array( 'slug' => 'award',           'label' => 'Award / Achievement' ),
		array( 'slug' => 'palette',         'label' => 'Palette / Theming' ),
		array( 'slug' => 'github',          'label' => 'GitHub' ),
		array( 'slug' => 'linkedin',        'label' => 'LinkedIn' ),
		array( 'slug' => 'twitter',         'label' => 'Twitter' ),
		array( 'slug' => 'x',               'label' => 'X (Twitter)' ),
		array( 'slug' => 'gitlab',          'label' => 'GitLab' ),
		array( 'slug' => 'codepen',         'label' => 'CodePen' ),
		array( 'slug' => 'dribbble',        'label' => 'Dribbble' ),
		array( 'slug' => 'youtube',         'label' => 'YouTube' ),
		array( 'slug' => 'instagram',       'label' => 'Instagram' ),
		array( 'slug' => 'facebook',        'label' => 'Facebook' ),
		array( 'slug' => 'twitch',          'label' => 'Twitch' ),
		array( 'slug' => 'slack',           'label' => 'Slack' ),
		array( 'slug' => 'discord',         'label' => 'Discord' ),
		array( 'slug' => 'rss',             'label' => 'RSS Feed' ),
		array( 'slug' => 'send',            'label' => 'Telegram / Send' ),
		array( 'slug' => 'message-square',  'label' => 'Chat / Forum' ),
		array( 'slug' => 'sun',             'label' => 'Sun / Light Mode' ),
		array( 'slug' => 'moon',            'label' => 'Moon / Dark Mode' ),
	);

	foreach ( $list as &$item ) {
		$item['svg'] = geekypress_get_icon( $item['slug'], '', 20 );
	}
	unset( $item );

	return $list;
}
