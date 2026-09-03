<?php
/**
 * The main template file
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="wp-block-group terminal-main" role="main">
	<div class="wp-block-group alignwide terminal-section">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-panel' ); ?> style="padding: 32px; margin-bottom: 24px;">
					<header class="entry-header">
						<?php the_title( '<h2 class="section-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="color:var(--pt-text); text-decoration:none;">', '</a></h2>' ); ?>
					</header>
					<div class="entry-content content-text" style="margin-top: 16px;">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_navigation(); ?>
		<?php else : ?>
			<div class="terminal-empty-state">
				<p class="terminal-label">// 404 NOT FOUND</p>
				<h1 class="terminal-display">No posts found<span>_</span></h1>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_sidebar();
get_footer();
