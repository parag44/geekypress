<?php
/**
 * GeekyPress: Blog & Articles Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_enabled = get_theme_mod( 'geekypress_blog_enabled', true );
if ( ! $blog_enabled ) {
	return;
}

$label          = get_theme_mod( 'geekypress_blog_label', '// LATEST_WRITING' );
$title          = get_theme_mod( 'geekypress_blog_title', 'Blog & Articles' );
$posts_per_page = absint( get_theme_mod( 'geekypress_blog_count', 3 ) );
if ( $posts_per_page < 1 ) {
	$posts_per_page = 3;
}
$view_all_text  = get_theme_mod( 'geekypress_blog_view_all_text', 'View All Articles ↗' );
$view_all_url   = get_theme_mod( 'geekypress_blog_view_all_url', '' );

if ( empty( $view_all_url ) ) {
	$posts_page_id = get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		$view_all_url = get_permalink( $posts_page_id );
	}
}

$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $posts_per_page,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
	)
);
?>

<section id="blog" class="wp-block-group alignwide terminal-section terminal-blog">
	<div class="terminal-section-header terminal-blog-header">
		<div>
			<?php if ( ! empty( $label ) ) : ?>
				<p class="terminal-label geekypress-preview-blog-label"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="section-title geekypress-preview-blog-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $view_all_text ) && ! empty( $view_all_url ) ) : ?>
			<a href="<?php echo esc_url( $view_all_url ); ?>" class="terminal-blog-view-all">
				<span class="geekypress-preview-blog-view-all"><?php echo esc_html( $view_all_text ); ?></span>
			</a>
		<?php endif; ?>
	</div>

	<div class="terminal-blog-grid">
		<?php
		if ( $blog_query->have_posts() ) :
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post();
				$post_id      = get_the_ID();
				$reading_time = geekypress_get_reading_time( $post_id );
				$cats         = get_the_category();
				$primary_cat  = ! empty( $cats ) ? $cats[0]->name : '';
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-blog-card terminal-panel' ); ?>>

					<!-- Thumbnail Frame -->
					<div class="terminal-blog-thumb">
						<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'terminal-blog-img' ) ); ?>
							<?php else : ?>
								<div class="terminal-blog-thumb-placeholder">
									<div class="terminal-thumb-dots" aria-hidden="true"><i></i><i></i><i></i></div>
									<div class="terminal-thumb-icon">
										<?php echo geekypress_get_icon( 'file-code', '', 36 ); ?>
									</div>
									<span class="terminal-thumb-label">&gt;_ post.md</span>
								</div>
							<?php endif; ?>
						</a>
						<?php if ( ! empty( $primary_cat ) ) : ?>
							<span class="terminal-blog-badge">#<?php echo esc_html( $primary_cat ); ?></span>
						<?php endif; ?>
					</div>

					<div class="terminal-blog-body">
						<!-- Metadata HUD -->
						<div class="terminal-blog-meta">
							<span class="terminal-blog-date">
								<?php echo geekypress_get_icon( 'calendar', '', 13 ); ?>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?></time>
							</span>
							<span class="terminal-blog-meta-sep">&bull;</span>
							<span class="terminal-blog-reading-time">
								<?php echo geekypress_get_icon( 'clock', '', 13 ); ?>
								<span><?php echo esc_html( $reading_time ); ?></span>
							</span>
						</div>

						<!-- Post Title -->
						<h3 class="terminal-blog-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>

						<!-- Post Excerpt -->
						<div class="terminal-blog-excerpt content-text">
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '...' ) ); ?></p>
						</div>

						<!-- Read More Action Button -->
						<div class="terminal-blog-footer">
							<a href="<?php the_permalink(); ?>" class="terminal-blog-btn">
								<span>&gt;_ <?php esc_html_e( 'read_article', 'geekypress' ); ?></span>
								<?php echo geekypress_get_icon( 'arrow-right', '', 14 ); ?>
							</a>
						</div>
					</div>

				</article>
				<?php
			endwhile;
			wp_reset_postdata();
		else :
			// Fallback placeholder demo articles if no posts exist yet
			$placeholders = array(
				array(
					'title'    => 'Zero-Downtime Deployment Pipelines for High-Traffic Stacks',
					'category' => 'DevOps',
					'date'     => '2026-08-15',
					'read'     => '5 min read',
					'excerpt'  => 'An architectural walkthrough of blue-green releases, automated rollbacks, and schema migrations with zero user interruption.',
				),
				array(
					'title'    => 'Mastering Modern Fluid Typography and Container Queries in CSS',
					'category' => 'Frontend',
					'date'     => '2026-07-28',
					'read'     => '4 min read',
					'excerpt'  => 'Techniques for building resilient component layouts that adapt fluidly to viewport changes without fragile breakpoint queries.',
				),
				array(
					'title'    => 'Building Resilient Microservices with Asynchronous Message Queues',
					'category' => 'Backend',
					'date'     => '2026-06-10',
					'read'     => '6 min read',
					'excerpt'  => 'Designing decoupled message streams using event-driven architectures to handle sudden traffic surges smoothly.',
				),
			);

			$render_count = min( $posts_per_page, count( $placeholders ) );
			for ( $i = 0; $i < $render_count; $i++ ) :
				$p = $placeholders[ $i ];
				?>
				<article class="terminal-blog-card terminal-panel">
					<div class="terminal-blog-thumb">
						<a href="#blog">
							<div class="terminal-blog-thumb-placeholder">
								<div class="terminal-thumb-dots" aria-hidden="true"><i></i><i></i><i></i></div>
								<div class="terminal-thumb-icon">
									<?php echo geekypress_get_icon( 'file-code', '', 36 ); ?>
								</div>
								<span class="terminal-thumb-label">&gt;_ article_0<?php echo ( $i + 1 ); ?>.md</span>
							</div>
						</a>
						<span class="terminal-blog-badge">#<?php echo esc_html( $p['category'] ); ?></span>
					</div>

					<div class="terminal-blog-body">
						<div class="terminal-blog-meta">
							<span class="terminal-blog-date">
								<?php echo geekypress_get_icon( 'calendar', '', 13 ); ?>
								<span><?php echo esc_html( $p['date'] ); ?></span>
							</span>
							<span class="terminal-blog-meta-sep">&bull;</span>
							<span class="terminal-blog-reading-time">
								<?php echo geekypress_get_icon( 'clock', '', 13 ); ?>
								<span><?php echo esc_html( $p['read'] ); ?></span>
							</span>
						</div>

						<h3 class="terminal-blog-title">
							<a href="#blog"><?php echo esc_html( $p['title'] ); ?></a>
						</h3>

						<div class="terminal-blog-excerpt content-text">
							<p><?php echo esc_html( $p['excerpt'] ); ?></p>
						</div>

						<div class="terminal-blog-footer">
							<a href="#blog" class="terminal-blog-btn">
								<span>&gt;_ <?php esc_html_e( 'read_article', 'geekypress' ); ?></span>
								<?php echo geekypress_get_icon( 'arrow-right', '', 14 ); ?>
							</a>
						</div>
					</div>
				</article>
			<?php endfor; ?>
		<?php endif; ?>
	</div>
</section>
