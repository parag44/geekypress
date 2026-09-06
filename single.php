<?php
/**
 * The template for displaying all single posts
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- Reading Progress Indicator -->
<div id="gp-reading-progress" class="gp-reading-progress" aria-hidden="true"></div>

<main id="primary" class="site-main terminal-main terminal-single-post-main" role="main">
	<div class="wp-block-group alignwide terminal-section terminal-single-container">

		<?php
		while ( have_posts() ) :
			the_post();
			$post_id          = get_the_ID();
			$reading_time     = geekypress_get_reading_time( $post_id );
			$comment_count    = get_comments_number();
			$categories_list  = get_the_category_list( ' ' );
			$tags_list        = get_the_tag_list( '', ' ' );
			$author_id        = get_the_author_meta( 'ID' );
			$author_bio       = get_the_author_meta( 'description' );
			$author_name      = get_the_author();
			$post_permalink   = get_permalink();
			$post_title_raw   = get_the_title();
			?>

			<!-- Breadcrumb / Command Line Navigation -->
			<nav class="terminal-post-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'geekypress' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="terminal-breadcrumb-link">
					<?php echo geekypress_get_icon( 'arrow-left', '', 14 ); ?>
					<span>$ cd .. / <?php esc_html_e( 'home', 'geekypress' ); ?></span>
				</a>
				<?php
				$blog_page_id = get_option( 'page_for_posts' );
				if ( $blog_page_id ) :
					?>
					<span class="terminal-breadcrumb-sep">/</span>
					<a href="<?php echo esc_url( get_permalink( $blog_page_id ) ); ?>" class="terminal-breadcrumb-link">
						<span><?php echo esc_html( get_the_title( $blog_page_id ) ); ?></span>
					</a>
				<?php endif; ?>
				<span class="terminal-breadcrumb-sep">/</span>
				<span class="terminal-breadcrumb-current"><?php echo esc_html( wp_trim_words( $post_title_raw, 6, '...' ) ); ?></span>
			</nav>

			<!-- Main Article Window Panel -->
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-post-article terminal-panel' ); ?>>

				<!-- Terminal Window Titlebar -->
				<div class="terminal-window-bar terminal-post-window-bar">
					<div class="terminal-window-dots" aria-hidden="true">
						<i></i><i></i><i></i>
					</div>
					<div class="terminal-window-file">
						<span>~/posts/<?php echo esc_html( $post->post_name ? $post->post_name . '.md' : 'article.md' ); ?></span>
					</div>
					<div class="terminal-post-status-badge" aria-hidden="true">
						<span><?php esc_html_e( 'STATUS: 200 OK', 'geekypress' ); ?></span>
					</div>
				</div>

				<!-- Article Header & Meta HUD -->
				<header class="terminal-post-header">

					<div class="terminal-post-meta-hud">
						<span class="terminal-meta-item terminal-meta-date" title="<?php esc_attr_e( 'Publish Date', 'geekypress' ); ?>">
							<?php echo geekypress_get_icon( 'calendar', '', 14 ); ?>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?></time>
						</span>

						<span class="terminal-meta-sep">&bull;</span>

						<span class="terminal-meta-item terminal-meta-time" title="<?php esc_attr_e( 'Estimated Reading Time', 'geekypress' ); ?>">
							<?php echo geekypress_get_icon( 'clock', '', 14 ); ?>
							<span><?php echo esc_html( $reading_time ); ?></span>
						</span>

						<?php if ( comments_open() || $comment_count > 0 ) : ?>
							<span class="terminal-meta-sep">&bull;</span>
							<a href="#comments" class="terminal-meta-item terminal-meta-comments" title="<?php esc_attr_e( 'Comments', 'geekypress' ); ?>">
								<?php echo geekypress_get_icon( 'message-square', '', 14 ); ?>
								<span>
									<?php
									printf(
										/* translators: %s: number of comments */
										esc_html( _n( '%s comment', '%s comments', $comment_count, 'geekypress' ) ),
										number_format_i18n( $comment_count ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									);
									?>
								</span>
							</a>
						<?php endif; ?>
					</div>

					<?php if ( $categories_list ) : ?>
						<div class="terminal-post-categories" aria-label="<?php esc_attr_e( 'Categories', 'geekypress' ); ?>">
							<?php echo $categories_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php endif; ?>

					<?php the_title( '<h1 class="terminal-post-title terminal-display">', '<span class="terminal-title-cursor" aria-hidden="true">_</span></h1>' ); ?>

					<div class="terminal-post-author-byline">
						<div class="terminal-author-avatar">
							<?php echo get_avatar( $author_id, 42, '', '', array( 'class' => 'terminal-avatar-img' ) ); ?>
						</div>
						<div class="terminal-author-details">
							<span class="terminal-author-prefix"><?php esc_html_e( 'Authored by', 'geekypress' ); ?></span>
							<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="terminal-author-name">
								<?php echo esc_html( $author_name ); ?>
							</a>
							<?php if ( get_the_modified_time( 'U' ) > ( get_the_time( 'U' ) + 86400 ) ) : ?>
								<span class="terminal-author-modified">
									// <?php esc_html_e( 'revised', 'geekypress' ); ?> <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'Y-m-d' ) ); ?></time>
								</span>
							<?php endif; ?>
						</div>
					</div>

				</header>

				<!-- Featured Image Frame -->
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="terminal-post-media">
						<?php the_post_thumbnail( 'large', array( 'class' => 'terminal-featured-image' ) ); ?>
						<?php if ( get_the_post_thumbnail_caption() ) : ?>
							<figcaption class="terminal-post-media-caption">
								<span>// <?php echo esc_html( get_the_post_thumbnail_caption() ); ?></span>
							</figcaption>
						<?php endif; ?>
					</figure>
				<?php endif; ?>

				<!-- Main Longform Body -->
				<div class="terminal-post-content entry-content content-text">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before'      => '<div class="terminal-page-links"><span class="terminal-page-links-title">' . esc_html__( 'Pages:', 'geekypress' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span class="terminal-page-number">',
							'link_after'  => '</span>',
						)
					);
					?>
				</div>

				<!-- Article Footer: Tags & Share Actions -->
				<footer class="terminal-post-footer">

					<?php if ( $tags_list ) : ?>
						<div class="terminal-post-tags-container">
							<span class="terminal-tags-label"><?php echo geekypress_get_icon( 'tag', '', 14 ); ?> <?php esc_html_e( 'tags:', 'geekypress' ); ?></span>
							<div class="terminal-post-tags-list">
								<?php echo $tags_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="terminal-post-share-bar">
						<span class="terminal-share-label"><?php echo geekypress_get_icon( 'share-2', '', 14 ); ?> <?php esc_html_e( 'share_article:', 'geekypress' ); ?></span>
						<div class="terminal-share-actions">
							<!-- One-Click Copy Article URL -->
							<button type="button" class="terminal-share-btn gp-copy-link-btn" data-url="<?php echo esc_url( $post_permalink ); ?>" aria-label="<?php esc_attr_e( 'Copy link to article', 'geekypress' ); ?>" title="<?php esc_attr_e( 'Copy Link', 'geekypress' ); ?>">
								<?php echo geekypress_get_icon( 'copy', 'gp-copy-icon', 14 ); ?>
								<?php echo geekypress_get_icon( 'check', 'gp-check-icon', 14 ); ?>
								<span class="gp-copy-text"><?php esc_html_e( 'Copy Link', 'geekypress' ); ?></span>
							</button>

							<!-- Twitter / X -->
							<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . rawurlencode( $post_title_raw ) . '&url=' . rawurlencode( $post_permalink ) ); ?>" target="_blank" rel="noopener noreferrer" class="terminal-share-btn" aria-label="<?php esc_attr_e( 'Share on X / Twitter', 'geekypress' ); ?>">
								<?php echo geekypress_get_icon( 'x', '', 14 ); ?>
								<span><?php esc_html_e( 'Tweet', 'geekypress' ); ?></span>
							</a>

							<!-- LinkedIn -->
							<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $post_permalink ) ); ?>" target="_blank" rel="noopener noreferrer" class="terminal-share-btn" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'geekypress' ); ?>">
								<?php echo geekypress_get_icon( 'linkedin', '', 14 ); ?>
								<span><?php esc_html_e( 'Share', 'geekypress' ); ?></span>
							</a>
						</div>
					</div>

				</footer>

			</article>

			<!-- Author Profile Terminal Card -->
			<section class="terminal-author-box terminal-panel" aria-label="<?php esc_attr_e( 'About the Author', 'geekypress' ); ?>">
				<div class="terminal-author-box-inner">
					<div class="terminal-author-avatar-large">
						<?php echo get_avatar( $author_id, 72, '', '', array( 'class' => 'terminal-avatar-img' ) ); ?>
					</div>
					<div class="terminal-author-bio-content">
						<p class="terminal-label">// <?php esc_html_e( 'AUTHOR_PROFILE', 'geekypress' ); ?></p>
						<h3 class="terminal-author-box-name"><?php echo esc_html( $author_name ); ?></h3>
						<?php if ( ! empty( $author_bio ) ) : ?>
							<div class="terminal-author-bio-text content-text">
								<p><?php echo esc_html( $author_bio ); ?></p>
							</div>
						<?php endif; ?>
						<div class="terminal-author-links">
							<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="terminal-author-all-posts">
								<span>&gt;_ <?php esc_html_e( 'browse_all_posts', 'geekypress' ); ?></span>
								<?php echo geekypress_get_icon( 'arrow-right', '', 13 ); ?>
							</a>
						</div>
					</div>
				</div>
			</section>

			<!-- Adjacent Posts Navigation (Dual Terminal Panels) -->
			<?php
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			if ( $prev_post || $next_post ) :
				?>
				<nav class="terminal-adjacent-navigation" aria-label="<?php esc_attr_e( 'Posts', 'geekypress' ); ?>">
					<div class="terminal-nav-col terminal-nav-prev">
						<?php if ( $prev_post ) : ?>
							<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="terminal-adjacent-link terminal-panel">
								<span class="terminal-adjacent-cmd">
									<?php echo geekypress_get_icon( 'arrow-left', '', 14 ); ?>
									<span>$ cd .. / <?php esc_html_e( 'previous_entry', 'geekypress' ); ?></span>
								</span>
								<strong class="terminal-adjacent-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></strong>
							</a>
						<?php else : ?>
							<div class="terminal-adjacent-link terminal-adjacent-empty terminal-panel">
								<span class="terminal-adjacent-cmd">// <?php esc_html_e( 'start_of_log', 'geekypress' ); ?></span>
								<span class="terminal-adjacent-empty-text"><?php esc_html_e( 'No earlier posts', 'geekypress' ); ?></span>
							</div>
						<?php endif; ?>
					</div>

					<div class="terminal-nav-col terminal-nav-next">
						<?php if ( $next_post ) : ?>
							<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="terminal-adjacent-link terminal-panel">
								<span class="terminal-adjacent-cmd">
									<span>$ cd .. / <?php esc_html_e( 'next_entry', 'geekypress' ); ?></span>
									<?php echo geekypress_get_icon( 'arrow-right', '', 14 ); ?>
								</span>
								<strong class="terminal-adjacent-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></strong>
							</a>
						<?php else : ?>
							<div class="terminal-adjacent-link terminal-adjacent-empty terminal-panel">
								<span class="terminal-adjacent-cmd">// <?php esc_html_e( 'end_of_log', 'geekypress' ); ?></span>
								<span class="terminal-adjacent-empty-text"><?php esc_html_e( 'No newer posts', 'geekypress' ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</nav>
			<?php endif; ?>

			<!-- Comments Section -->
			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
