<?php
/**
 * The header for GeekyPress
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$geekypress_theme_mode = get_theme_mod( 'geekypress_theme_mode', 'dark' );
?><!doctype html>
<html <?php language_attributes(); ?> data-theme-mode="<?php echo esc_attr( $geekypress_theme_mode ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="wp-site-blocks">

<header class="wp-block-group alignfull terminal-site-header">
	<div class="wp-block-group alignwide terminal-nav-shell">

		<?php
		$badge_text = get_theme_mod( 'geekypress_header_badge', '>_' );
		$brand_name = get_theme_mod( 'geekypress_header_title', 'Alex Morgan' );
		?>
		<a class="terminal-brand" href="#home" aria-label="<?php echo esc_attr( $brand_name . ' home' ); ?>">
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
						<li class="wp-block-navigation-item"><a href="#home">&gt;_ home</a></li>
						<li class="wp-block-navigation-item"><a href="#about">about</a></li>
						<li class="wp-block-navigation-item"><a href="#skills">skills</a></li>
						<li class="wp-block-navigation-item"><a href="#experience">experience</a></li>
						<li class="wp-block-navigation-item"><a href="#projects">projects</a></li>
						<li class="wp-block-navigation-item"><a href="#contact">contact</a></li>
					</ul>
					<?php
				}
				?>
			</nav>
		</div>

		<?php
		$cta_show = get_theme_mod( 'geekypress_header_cta_show', true );
		$cta_text = get_theme_mod( 'geekypress_header_cta_text', "Let's Talk </>" );
		$cta_url  = get_theme_mod( 'geekypress_header_cta_url', '#contact' );
		if ( $cta_show && ! empty( $cta_text ) ) :
			?>
			<div class="wp-block-buttons terminal-header-cta">
				<div class="wp-block-button is-style-outline">
					<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_text ); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

	</div>
</header>
