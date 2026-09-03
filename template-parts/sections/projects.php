<?php
/**
 * GeekyPress: Projects & Products Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projects_enabled = get_theme_mod( 'geekypress_projects_enabled', true );
if ( ! $projects_enabled ) {
	return;
}

$label = get_theme_mod( 'geekypress_projects_label', '// SELECTED_WORK' );
$title = get_theme_mod( 'geekypress_projects_title', 'Projects & Products' );

$projects = geekypress_get_repeater_data(
	'geekypress_projects_items',
	array(
		array(
			'icon'        => 'dashicons-rest-api',
			'type'        => 'CLI & OPEN SOURCE',
			'title'       => 'FastDeploy Engine',
			'description' => 'A zero-downtime deployment engine for WordPress and PHP web stacks with automated rollbacks, database synchronization, and staging pipelines.',
			'tags'        => 'PHP, Bash, Docker, WP-CLI',
			'link_text'   => 'View on GitHub ↗',
			'link_url'    => 'https://github.com/',
		),
		array(
			'icon'        => 'dashicons-chart-line',
			'type'        => 'FULL-STACK DASHBOARD',
			'title'       => 'CloudMetrics Suite',
			'description' => 'Real-time developer analytics and server monitoring portal with interactive dashboards, anomaly detection, and instant incident alerts.',
			'tags'        => 'React, TypeScript, GraphQL, Node.js',
			'link_text'   => 'Live Demo ↗',
			'link_url'    => '#',
		),
		array(
			'icon'        => 'dashicons-shield',
			'type'        => 'WordPress Plugin',
			'title'       => 'SecureSync REST API',
			'description' => 'A hardened synchronization bridge connecting WordPress sites to modern headless frontends, cloud storage, and automated webhooks.',
			'tags'        => 'WordPress, REST API, Security, OAuth',
			'link_text'   => 'Documentation ↗',
			'link_url'    => '#',
		),
		array(
			'icon'        => 'dashicons-layout',
			'type'        => 'UI DESIGN SYSTEM',
			'title'       => 'TerminalKit UI',
			'description' => 'An accessible, lightweight developer-themed component library with native terminal styling, code blocks, and adaptive themes.',
			'tags'        => 'CSS, React, Accessible UI, Web',
			'link_text'   => 'Explore Kit ↗',
			'link_url'    => '#',
		),
	)
);
?>

<div id="projects" class="wp-block-group alignwide terminal-section">
	<?php if ( ! empty( $label ) ) : ?>
		<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<h2 class="wp-block-heading section-title"><span aria-hidden="true">&gt;</span> <?php echo esc_html( $title ); ?><i aria-hidden="true">_</i></h2>

	<?php if ( ! empty( $projects ) && is_array( $projects ) ) : ?>
		<div class="wp-block-group terminal-card-grid">
			<?php foreach ( $projects as $proj ) : ?>
				<?php
				$icon = ! empty( $proj['icon'] ) ? $proj['icon'] : '';
				if ( empty( $icon ) && ! empty( $proj['badge'] ) ) {
					$icon = 'dashicons-portfolio';
				}
				if ( empty( $icon ) ) {
					$icon = 'dashicons-rest-api';
				}
				$type = ! empty( $proj['type'] ) ? $proj['type'] : '';
				$tags = ! empty( $proj['tags'] ) ? array_map( 'trim', explode( ',', $proj['tags'] ) ) : array();
				?>
				<div class="wp-block-group terminal-card">
					<span class="terminal-card-badge" aria-hidden="true">
						<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
					</span>

					<?php if ( ! empty( $type ) ) : ?>
						<p class="terminal-card-type"><?php echo esc_html( $type ); ?></p>
					<?php endif; ?>

					<h3 class="wp-block-heading card-title"><?php echo esc_html( isset( $proj['title'] ) ? $proj['title'] : '' ); ?></h3>

					<?php if ( ! empty( $proj['description'] ) ) : ?>
						<p class="content-text"><?php echo esc_html( $proj['description'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $tags ) ) : ?>
						<p class="terminal-tags">
							<?php foreach ( $tags as $tag ) : ?>
								<span><?php echo esc_html( $tag ); ?></span>
							<?php endforeach; ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $proj['link_url'] ) ) : ?>
						<p class="project-link">
							<a href="<?php echo esc_url( $proj['link_url'] ); ?>" target="_blank" rel="noreferrer noopener">
								<?php echo esc_html( ! empty( $proj['link_text'] ) ? $proj['link_text'] : 'View project →' ); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
