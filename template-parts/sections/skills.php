<?php
/**
 * GeekyPress: Skills & Expertise Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$skills_enabled = get_theme_mod( 'geekypress_skills_enabled', true );
if ( ! $skills_enabled ) {
	return;
}

$label = get_theme_mod( 'geekypress_skills_label', '// WHAT I DO BEST' );
$title = get_theme_mod( 'geekypress_skills_title', 'Skills & Expertise' );

$skills = geekypress_get_repeater_data(
	'geekypress_skills_items',
	array(
		array( 'icon' => 'dashicons-wordpress',        'title' => 'WordPress Core & Themes' ),
		array( 'icon' => 'dashicons-editor-code',      'title' => 'HTML, CSS, JavaScript, PHP' ),
		array( 'icon' => 'dashicons-admin-tools',      'title' => 'Debugging & Troubleshooting' ),
		array( 'icon' => 'dashicons-layout',           'title' => 'Elementor & Page Builders' ),
		array( 'icon' => 'dashicons-desktop',          'title' => 'Browser Dev Tools' ),
		array( 'icon' => 'dashicons-admin-site-alt3',  'title' => 'cPanel, FTP, DNS, Hosting' ),
		array( 'icon' => 'dashicons-rest-api',         'title' => 'REST API & AJAX' ),
		array( 'icon' => 'dashicons-sos',              'title' => 'Conflict Resolution' ),
		array( 'icon' => 'dashicons-shield',           'title' => 'Security & Performance' ),
		array( 'icon' => 'dashicons-tickets-alt',      'title' => 'Ticketing Systems' ),
		array( 'icon' => 'dashicons-randomize',        'title' => 'Version Control (Git)' ),
		array( 'icon' => 'dashicons-flag',             'title' => 'Bug Replication & Docs' ),
	)
);
?>

<div id="skills" class="wp-block-group alignwide terminal-section">
	<?php if ( ! empty( $label ) ) : ?>
		<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<h2 class="wp-block-heading section-title"><span aria-hidden="true">&gt;</span> <?php echo esc_html( $title ); ?><i aria-hidden="true">_</i></h2>

	<?php if ( ! empty( $skills ) && is_array( $skills ) ) : ?>
		<div class="wp-block-group terminal-skill-grid">
			<?php foreach ( $skills as $skill ) : ?>
				<p>
					<span class="dashicons <?php echo esc_attr( ! empty( $skill['icon'] ) ? $skill['icon'] : 'dashicons-yes' ); ?>" aria-hidden="true"></span>
					<span><?php echo esc_html( isset( $skill['title'] ) ? $skill['title'] : '' ); ?></span>
				</p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
