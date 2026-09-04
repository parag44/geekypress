<?php
/**
 * The header for GeekyPress
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>
		(function() {
			try {
				var stored = localStorage.getItem('geekypress_theme');
				var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
				var theme = stored ? stored : (prefersDark ? 'dark' : 'light');
				document.documentElement.setAttribute('data-theme-mode', theme);
			} catch (e) {}
		})();
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="wp-site-blocks">

<header class="wp-block-group alignfull terminal-site-header">
	<div class="wp-block-group alignwide terminal-nav-shell">

		<?php
		$badge_text  = get_theme_mod( 'geekypress_header_badge', '>_' );
		$brand_name  = get_theme_mod( 'geekypress_header_title', 'Alex Morgan' );
		$home_url    = esc_url( home_url( '/' ) );
		$is_front    = is_front_page();
		$hash_prefix = $is_front ? '' : $home_url;
		?>
		<a class="terminal-brand" href="<?php echo $home_url; ?>" aria-label="<?php echo esc_attr( $brand_name . ' home' ); ?>">
			<span><?php echo esc_html( $badge_text ); ?></span>
			<strong><?php echo esc_html( $brand_name ); ?></strong>
		</a>

		<div class="terminal-navigation-wrapper">
			<button type="button" class="terminal-mobile-toggle" aria-label="<?php esc_attr_e( 'Open Navigation Menu', 'geekypress' ); ?>" aria-expanded="false" aria-controls="terminal-site-nav">
				<span class="terminal-hamburger-icon" aria-hidden="true">
					<i></i><i></i><i></i>
				</span>
			</button>

			<div class="terminal-nav-backdrop" aria-hidden="true"></div>

			<nav id="terminal-site-nav" class="terminal-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'geekypress' ); ?>">
				<div class="terminal-mobile-nav-header">
					<span class="terminal-mobile-brand"><?php echo esc_html( $badge_text . ' ' . $brand_name ); ?></span>
					<button type="button" class="terminal-mobile-close" aria-label="<?php esc_attr_e( 'Close Navigation Menu', 'geekypress' ); ?>">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'wp-block-navigation__container',
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<ul class="wp-block-navigation__container">
						<li class="wp-block-navigation-item"><a href="<?php echo $home_url; ?>">&gt;_ home</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#about">about</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#skills">skills</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#experience">experience</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#projects">projects</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#blog">articles</a></li>
						<li class="wp-block-navigation-item"><a href="<?php echo $hash_prefix; ?>#contact">contact</a></li>
					</ul>
					<?php
				}
				?>
			</nav>
		</div>

		<div class="terminal-header-actions">
			<button type="button" id="terminal-theme-toggle" class="terminal-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle color theme', 'geekypress' ); ?>" title="<?php esc_attr_e( 'Toggle color theme', 'geekypress' ); ?>">
				<span class="gp-theme-icon-sun" aria-hidden="true"><?php echo geekypress_get_icon( 'sun', '', 18 ); ?></span>
				<span class="gp-theme-icon-moon" aria-hidden="true"><?php echo geekypress_get_icon( 'moon', '', 18 ); ?></span>
			</button>

			<?php
			$cta_show = get_theme_mod( 'geekypress_header_cta_show', true );
			$cta_text = get_theme_mod( 'geekypress_header_cta_text', "Let's Talk </>" );
			$cta_url  = get_theme_mod( 'geekypress_header_cta_url', '#contact' );
			if ( ! $is_front && ! empty( $cta_url ) && 0 === strpos( $cta_url, '#' ) ) {
				$cta_url = $home_url . $cta_url;
			}
			if ( $cta_show && ! empty( $cta_text ) ) :
				?>
				<div class="terminal-header-cta">
					<a class="terminal-header-cta-btn wp-element-button" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_text ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

	</div>
</header>
