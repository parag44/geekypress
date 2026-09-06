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

	$rendered = array();

	if ( ! empty( $sections ) ) {
		$count = count( $sections );

		for ( $i = 0; $i < $count; $i++ ) {
			$sec = $sections[ $i ];
			if ( empty( $sec['slug'] ) || empty( $sec['enabled'] ) ) {
				continue;
			}

			$slug = sanitize_key( $sec['slug'] );

			if ( in_array( $slug, $rendered, true ) ) {
				continue;
			}

			// Check individual section enable theme mod
			$is_mod_enabled = get_theme_mod( 'geekypress_' . $slug . '_enabled', true );
			if ( ! $is_mod_enabled ) {
				continue;
			}

			// Merge Contact & Socials and Let's talk WordPress (CTA) into a single two-column row
			if ( 'contact' === $slug || 'cta' === $slug ) {
				$other_slug    = ( 'contact' === $slug ) ? 'cta' : 'contact';
				$other_enabled = false;

				// Check if the other section is also present and enabled
				foreach ( $sections as $check_sec ) {
					if ( isset( $check_sec['slug'] ) && $check_sec['slug'] === $other_slug && ! empty( $check_sec['enabled'] ) ) {
						if ( get_theme_mod( 'geekypress_' . $other_slug . '_enabled', true ) && ! in_array( $other_slug, $rendered, true ) ) {
							$other_enabled = true;
						}
						break;
					}
				}

				if ( $other_enabled ) {
					?>
					<div class="wp-block-columns alignwide terminal-section terminal-bottom terminal-contact-cta-row">
						<div class="wp-block-column terminal-bottom-col">
							<?php get_template_part( 'template-parts/sections/contact' ); ?>
						</div>
						<div class="wp-block-column terminal-bottom-col">
							<?php get_template_part( 'template-parts/sections/cta' ); ?>
						</div>
					</div>
					<?php
					$rendered[] = 'contact';
					$rendered[] = 'cta';
					continue;
				} else {
					?>
					<div class="wp-block-columns alignwide terminal-section terminal-bottom terminal-contact-cta-row">
						<div class="wp-block-column terminal-bottom-col" style="flex: 1 1 100%;">
							<?php get_template_part( 'template-parts/sections/' . $slug ); ?>
						</div>
					</div>
					<?php
					$rendered[] = $slug;
					continue;
				}
			}

			// Standard section render
			get_template_part( 'template-parts/sections/' . $slug );
			$rendered[] = $slug;
		}
	}
	?>

</main>

<?php
get_footer();
