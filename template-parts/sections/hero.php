<?php
/**
 * GeekyPress: Hero & Terminal Profile Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_enabled = get_theme_mod( 'geekypress_hero_enabled', true );
if ( ! $hero_enabled ) {
	return;
}

$label        = get_theme_mod( 'geekypress_hero_label', '// Full-Stack Developer & Open Source' );
$title_prefix = get_theme_mod( 'geekypress_hero_title_prefix', "Hi, I'm" );
$name         = get_theme_mod( 'geekypress_hero_name', 'Alex' );
$surname      = get_theme_mod( 'geekypress_hero_surname', 'Morgan' );
$desc         = get_theme_mod( 'geekypress_hero_description', "Full-Stack Engineer & Open Source Enthusiast\ncrafting resilient web applications, developer tools, and scalable architecture." );
$btn1_text    = get_theme_mod( 'geekypress_hero_btn1_text', '>_ Explore Projects' );
$btn1_url     = get_theme_mod( 'geekypress_hero_btn1_url', '#projects' );
$btn2_text    = get_theme_mod( 'geekypress_hero_btn2_text', "Let's Talk </>" );
$btn2_url     = get_theme_mod( 'geekypress_hero_btn2_url', '#contact' );

$socials = geekypress_get_repeater_data(
	'geekypress_hero_socials',
	array(
		array( 'label' => 'GH', 'title' => 'GitHub', 'url' => 'https://github.com/' ),
		array( 'label' => 'in', 'title' => 'LinkedIn', 'url' => 'https://linkedin.com/' ),
		array( 'label' => 'X',  'title' => 'Twitter/X', 'url' => 'https://x.com/' ),
		array( 'label' => '@',  'title' => 'Email', 'url' => 'mailto:hello@example.com' ),
	)
);

$custom_img    = get_theme_mod( 'geekypress_hero_image', '' );
$term_cmd      = get_theme_mod( 'geekypress_hero_terminal_cmd', '>_ cat developer.json' );
$default_json  = "{\n  \"name\": \"Alex Morgan\",\n  \"role\": \"Full-Stack Engineer\",\n  \"stack\": [\"PHP\", \"TypeScript\", \"WordPress\", \"React\"],\n  \"location\": \"San Francisco, CA / Remote\",\n  \"available\": true\n}";
$term_json     = get_theme_mod( 'geekypress_hero_terminal_json', $default_json );
$status_prefix = get_theme_mod( 'geekypress_hero_status_label', 'Available for' );
$status_text   = get_theme_mod( 'geekypress_hero_status_text', 'Contract & Full-Time Roles' );
?>

<div id="home" class="wp-block-group alignwide terminal-hero terminal-section">
	<div class="wp-block-columns alignwide are-vertically-aligned-center">

		<div class="wp-block-column is-vertically-aligned-center terminal-hero-copy">
			<?php if ( ! empty( $label ) ) : ?>
				<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>

			<h1 class="wp-block-heading terminal-display hero-title">
				<span class="hero-title-prefix"><?php echo esc_html( $title_prefix ); ?></span><br>
				<mark class="hero-title-name"><?php echo esc_html( $name ); ?></mark>
				<span class="hero-title-surname"><?php echo esc_html( $surname ); ?></span><span>_</span>
			</h1>

			<p class="content-text terminal-hero-desc"><?php echo nl2br( esc_html( $desc ) ); ?></p>

			<div class="wp-block-buttons">
				<?php if ( ! empty( $btn1_text ) ) : ?>
					<div class="wp-block-button">
						<a class="wp-block-button__link wp-element-button terminal-hero-btn1" href="<?php echo esc_url( $btn1_url ); ?>"><?php echo esc_html( $btn1_text ); ?></a>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $btn2_text ) ) : ?>
					<div class="wp-block-button is-style-outline">
						<a class="wp-block-button__link wp-element-button terminal-hero-btn2" href="<?php echo esc_url( $btn2_url ); ?>"><?php echo esc_html( $btn2_text ); ?></a>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $socials ) && is_array( $socials ) ) : ?>
				<div class="terminal-socials" aria-label="<?php esc_attr_e( 'Social profiles', 'geekypress' ); ?>">
					<span>/ Connect with me</span>
					<?php foreach ( $socials as $soc ) : ?>
						<?php if ( ! empty( $soc['url'] ) ) : ?>
							<a href="<?php echo esc_url( $soc['url'] ); ?>" title="<?php echo esc_attr( isset( $soc['title'] ) ? $soc['title'] : '' ); ?>" <?php echo strpos( $soc['url'], 'http' ) === 0 ? 'target="_blank" rel="noreferrer"' : ''; ?>><?php echo esc_html( isset( $soc['label'] ) ? $soc['label'] : '@' ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="wp-block-column is-vertically-aligned-center">
			<div class="terminal-window">
				<div class="terminal-window-bar" aria-hidden="true">
					<i></i><i></i><i></i>
				</div>
				<div class="terminal-window-body">
					<?php if ( ! empty( $custom_img ) ) : ?>
						<picture>
							<img src="<?php echo esc_url( $custom_img ); ?>" alt="<?php echo esc_attr( $name . ' ' . $surname ); ?>" decoding="async">
						</picture>
					<?php else : ?>
						<picture>
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/terminal-avatar.svg' ) ); ?>" alt="<?php echo esc_attr( $name . ' ' . $surname ); ?>" width="800" height="1000" fetchpriority="high" decoding="async">
						</picture>
					<?php endif; ?>

					<div class="terminal-json">
						<strong><?php echo esc_html( $term_cmd ); ?></strong>
						<pre><?php echo esc_html( $term_json ); ?></pre>
					</div>
				</div>
				<div class="terminal-status">
					<b>●</b> <span class="terminal-status-prefix"><?php echo esc_html( $status_prefix ); ?></span><br>
					<strong><?php echo esc_html( $status_text ); ?></strong>
				</div>
			</div>
		</div>

	</div>
</div>
