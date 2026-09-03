<?php
/**
 * The front page template file for GeekyPress
 *
 * Renders the terminal portfolio sections in configurable order.
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="wp-block-group terminal-main" role="main">

	<?php
	$sections = geekypress_get_section_order();

	$rendered_bottom_row = false;

	if ( ! empty( $sections ) ) {
		$count = count( $sections );

		for ( $i = 0; $i < $count; $i++ ) {
			$sec = $sections[ $i ];
			if ( empty( $sec['slug'] ) || empty( $sec['enabled'] ) ) {
				continue;
			}

			$slug = sanitize_key( $sec['slug'] );

			// Check individual section enable theme mod
			$is_mod_enabled = get_theme_mod( 'geekypress_' . $slug . '_enabled', true );
			if ( ! $is_mod_enabled ) {
				continue;
			}

			// Special handling for Interests and Contact to wrap them in .terminal-bottom two-column grid if adjacent
			if ( 'interests' === $slug || 'contact' === $slug ) {
				// If both interests and contact are present and consecutive, render inside two-column row
				$next_sec = ( $i + 1 < $count ) ? $sections[ $i + 1 ] : null;

				if ( 'interests' === $slug && $next_sec && 'contact' === $next_sec['slug'] && ! empty( $next_sec['enabled'] ) && get_theme_mod( 'geekypress_contact_enabled', true ) ) {
					?>
					<div class="wp-block-columns alignwide terminal-section terminal-bottom">
						<div class="wp-block-column">
							<?php get_template_part( 'template-parts/sections/interests' ); ?>
						</div>
						<div class="wp-block-column">
							<?php get_template_part( 'template-parts/sections/contact' ); ?>
						</div>
					</div>
					<?php
					$i++; // skip next since rendered
					continue;
				} elseif ( 'contact' === $slug && $next_sec && 'interests' === $next_sec['slug'] && ! empty( $next_sec['enabled'] ) && get_theme_mod( 'geekypress_interests_enabled', true ) ) {
					?>
					<div class="wp-block-columns alignwide terminal-section terminal-bottom">
						<div class="wp-block-column">
							<?php get_template_part( 'template-parts/sections/contact' ); ?>
						</div>
						<div class="wp-block-column">
							<?php get_template_part( 'template-parts/sections/interests' ); ?>
						</div>
					</div>
					<?php
					$i++; // skip next since rendered
					continue;
				} else {
					// Standalone column wrapper
					?>
					<div class="wp-block-columns alignwide terminal-section terminal-bottom">
						<div class="wp-block-column" style="flex: 1 1 100%;">
							<?php get_template_part( 'template-parts/sections/' . $slug ); ?>
						</div>
					</div>
					<?php
					continue;
				}
			}

			// Standard section render
			get_template_part( 'template-parts/sections/' . $slug );
		}
	}
	?>

</main>

<?php
get_footer();
