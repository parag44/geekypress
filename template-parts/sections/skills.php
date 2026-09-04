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
		array( 'icon' => 'code',         'title' => 'WordPress Core & Themes' ),
		array( 'icon' => 'file-code',    'title' => 'HTML, CSS, JavaScript, PHP' ),
		array( 'icon' => 'bug',          'title' => 'Debugging & Troubleshooting' ),
		array( 'icon' => 'layout',       'title' => 'Elementor & Page Builders' ),
		array( 'icon' => 'terminal',     'title' => 'Browser Dev Tools' ),
		array( 'icon' => 'server',       'title' => 'cPanel, FTP, DNS, Hosting' ),
		array( 'icon' => 'webhook',      'title' => 'REST API & AJAX' ),
		array( 'icon' => 'life-buoy',    'title' => 'Conflict Resolution' ),
		array( 'icon' => 'shield-check', 'title' => 'Security & Performance' ),
		array( 'icon' => 'check-circle', 'title' => 'Ticketing Systems' ),
		array( 'icon' => 'git-branch',   'title' => 'Version Control (Git)' ),
		array( 'icon' => 'book-open',    'title' => 'Bug Replication & Docs' ),
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
					<?php
					$skill_icon = ! empty( $skill['icon'] ) ? $skill['icon'] : 'check-circle';
					echo geekypress_get_icon( $skill_icon, 'skill-icon', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
					<span><?php echo esc_html( isset( $skill['title'] ) ? $skill['title'] : '' ); ?></span>
				</p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
