<?php
/**
 * GeekyPress Theme setup and functions.
 *
 * Classic / Hybrid WordPress Theme with Customizer API & Custom Repeater Controls.
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once when GeekyPress is activated.
 *
 * Sets the front page to use the theme's front-page.php template so the
 * portfolio is visible immediately on any fresh WordPress installation without
 * the user needing to configure Reading Settings manually.
 */
function geekypress_on_activation() {
	if ( 'posts' === get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', 0 );
	}
}
add_action( 'after_switch_theme', 'geekypress_on_activation' );

/**
 * Ensures the theme front page UI renders on the root URL by default,
 * even on fresh installations where Settings > Reading has not been saved yet.
 *
 * @param string $template Current template file path.
 * @return string Filtered template file path.
 */
function geekypress_front_page_template( $template ) {
	// If visiting front page or the root home page without custom page-on-front set
	if ( is_front_page() || ( is_home() && ! get_option( 'page_for_posts' ) ) ) {
		$front_page = locate_template( array( 'front-page.php' ) );
		if ( ! empty( $front_page ) ) {
			return $front_page;
		}
	}
	return $template;
}
add_filter( 'template_include', 'geekypress_front_page_template', 99 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
function geekypress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'geekypress_content_width', 840 );
}
add_action( 'after_setup_theme', 'geekypress_content_width', 0 );

/**
 * Registers theme supports, menus, and editor styles.
 */
function geekypress_setup() {
	// Translations
	load_theme_textdomain( 'geekypress', get_template_directory() . '/languages' );

	// Automatic feed links
	add_theme_support( 'automatic-feed-links' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );

	// HTML5 markup support
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );

	// Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Align wide support for blocks
	add_theme_support( 'align-wide' );

	// Core block default styling
	add_theme_support( 'wp-block-styles' );

	// Selective Refresh in Customizer
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Custom Logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 40,
			'width'       => 160,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Register Primary Navigation Menu
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Navigation', 'geekypress' ),
		)
	);
}
add_action( 'after_setup_theme', 'geekypress_setup' );

/**
 * Remove the Site Editor admin menu entry.
 * GeekyPress is a classic/hybrid PHP theme — content is managed via the
 * Customizer, not the block Site Editor.
 */
function geekypress_remove_site_editor_menu() {
	remove_menu_page( 'site-editor.php' );
	remove_submenu_page( 'themes.php', 'site-editor.php' );
}
add_action( 'admin_menu', 'geekypress_remove_site_editor_menu', 999 );

/**
 * Remove "Edit with Site Editor" row action from the theme list table.
 */
function geekypress_block_editor_filter( $settings ) {
	$settings['__experimentalFeatures']['appearanceTools'] = false;
	return $settings;
}

/**
 * Preconnect to Google Fonts domains.
 */
function geekypress_google_fonts_preconnect() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'geekypress_google_fonts_preconnect', 2 );

/**
 * Returns Google Fonts enqueue URL for current theme mods.
 *
 * @return string|false
 */
function geekypress_get_google_fonts_url() {
	$font_mono_key = get_theme_mod( 'geekypress_font_mono', 'fira-code' );
	$font_body_key = get_theme_mod( 'geekypress_font_body', 'fira-code' );

	$font_defs = geekypress_get_font_definitions();
	$families  = array();

	if ( ! empty( $font_defs[ $font_mono_key ]['google_name'] ) ) {
		$families[] = $font_defs[ $font_mono_key ]['google_name'];
	}
	if ( ! empty( $font_defs[ $font_body_key ]['google_name'] ) && ! in_array( $font_defs[ $font_body_key ]['google_name'], $families, true ) ) {
		$families[] = $font_defs[ $font_body_key ]['google_name'];
	}

	if ( empty( $families ) ) {
		return false;
	}

	return 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_map( 'rawurlencode', $families ) ) . '&display=swap';
}

/**
 * Loads front-end scripts and stylesheets.
 */
function geekypress_enqueue_assets() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	// Google Fonts
	$fonts_url = geekypress_get_google_fonts_url();
	if ( $fonts_url ) {
		wp_enqueue_style( 'geekypress-google-fonts', esc_url( $fonts_url ), array(), null );
	}

	// Dashicons for frontend skill & stat icons
	wp_enqueue_style( 'dashicons' );

	// Main theme styles
	wp_enqueue_style(
		'geekypress-style',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array( 'dashicons' ),
		$version
	);

	// Dynamic CSS variables from customizer
	$custom_css = geekypress_get_dynamic_css();
	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'geekypress-style', $custom_css );
	}

	// Navigation scrollspy script
	wp_enqueue_script(
		'geekypress-navigation',
		get_theme_file_uri( 'assets/js/navigation.js' ),
		array(),
		$version,
		true
	);

	// Threaded comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'geekypress_enqueue_assets' );

/**
 * Builds dynamic CSS variables from theme mods.
 *
 * @return string
 */
function geekypress_get_dynamic_css() {
	$green   = get_theme_mod( 'geekypress_color_green', '#39ff88' );
	$cyan    = get_theme_mod( 'geekypress_color_cyan', '#49d9ff' );
	$bg      = get_theme_mod( 'geekypress_color_bg', '#050d14' );
	$surface = get_theme_mod( 'geekypress_color_surface', '#07141d' );
	$text    = get_theme_mod( 'geekypress_color_text', '#eef5f1' );
	$muted      = get_theme_mod( 'geekypress_color_muted', '#9aabb3' );
	$link       = get_theme_mod( 'geekypress_color_link', '#39ff88' );
	$link_hover = get_theme_mod( 'geekypress_color_link_hover', '#49d9ff' );

	$font_mono_key = get_theme_mod( 'geekypress_font_mono', 'fira-code' );
	$font_body_key = get_theme_mod( 'geekypress_font_body', 'fira-code' );
	$ligatures     = get_theme_mod( 'geekypress_font_ligatures', true );

	$font_defs = geekypress_get_font_definitions();
	$mono_def  = isset( $font_defs[ $font_mono_key ]['family'] ) ? $font_defs[ $font_mono_key ]['family'] : '"Fira Code", monospace';
	$body_def  = isset( $font_defs[ $font_body_key ]['family'] ) ? $font_defs[ $font_body_key ]['family'] : '"Fira Code", monospace';

	$user_css = get_theme_mod( 'geekypress_custom_css', '' );

	$css = ":root {\n";
	if ( $green !== '#39ff88' )        $css .= "\t--pt-green: {$green};\n";
	if ( $cyan !== '#49d9ff' )         $css .= "\t--pt-cyan: {$cyan};\n";
	if ( $bg !== '#050d14' )           $css .= "\t--pt-bg: {$bg};\n";
	if ( $surface !== '#07141d' )      $css .= "\t--pt-surface: {$surface};\n";
	if ( $text !== '#eef5f1' )         $css .= "\t--pt-text: {$text};\n";
	if ( $muted !== '#9aabb3' )        $css .= "\t--pt-muted: {$muted};\n";
	if ( $link !== '#39ff88' )         $css .= "\t--pt-link: {$link};\n";
	if ( $link_hover !== '#49d9ff' )   $css .= "\t--pt-link-hover: {$link_hover};\n";

	$css .= "\t--font-mono: {$mono_def};\n";
	$css .= "\t--font-sans: {$body_def};\n";

	if ( $ligatures ) {
		$css .= "\tfont-variant-ligatures: normal;\n";
		$css .= "\tfont-feature-settings: 'calt' 1, 'liga' 1;\n";
	}

	$css .= "}\n";

	if ( ! empty( $user_css ) ) {
		$css .= "\n" . wp_strip_all_tags( $user_css ) . "\n";
	}

	return $css;
}

/**
 * Registers widget area for classic sidebars.
 */
function geekypress_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'geekypress' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'geekypress' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s terminal-panel" style="padding: 24px; margin-bottom: 24px;">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title section-title" style="font-size: var(--heading-sm); margin-bottom: 16px;">// ',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'geekypress_widgets_init' );

/**
 * Adds a default homepage description when an SEO plugin is not active.
 */
function geekypress_home_meta_description() {
	if ( is_admin() || ! ( is_front_page() || is_home() ) ) {
		return;
	}

	printf(
		'<meta name="description" content="%s">' . "\n",
		esc_attr( __( 'A modern, developer-focused portfolio theme featuring interactive terminal aesthetics, customizable showcase sections, and Google Fonts.', 'geekypress' ) )
	);
}
add_action( 'wp_head', 'geekypress_home_meta_description', 2 );

/**
 * Returns the saved loader settings with safe defaults.
 *
 * @return array{enabled:int,duration:int}
 */
function geekypress_get_loader_settings() {
	$defaults = array(
		'enabled'  => 0,
		'duration' => 3,
	);
	$settings = get_option( 'geekypress_terminal_loader_settings', array() );
	$settings = wp_parse_args( is_array( $settings ) ? $settings : array(), $defaults );

	return array(
		'enabled'  => empty( $settings['enabled'] ) ? 0 : 1,
		'duration' => min( 10, max( 1, absint( $settings['duration'] ) ) ),
	);
}

/**
 * Whether the loader should be rendered for this request.
 */
function geekypress_loader_is_enabled() {
	if ( is_admin() || is_customize_preview() ) {
		return false;
	}

	$settings = geekypress_get_loader_settings();
	return ! empty( $settings['enabled'] );
}

/**
 * Loads the small loader controller only when the feature is enabled.
 */
function geekypress_enqueue_loader_script() {
	if ( ! geekypress_loader_is_enabled() ) {
		return;
	}

	$theme = wp_get_theme();
	wp_enqueue_script(
		'geekypress-terminal-loader',
		get_theme_file_uri( 'assets/js/loader.js' ),
		array(),
		$theme->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'geekypress_enqueue_loader_script' );

/**
 * Preloads the loader heading font to prevent a fallback-font flash.
 *
 * @param array<int, array<string, string>> $preload_resources Resources to preload.
 * @return array<int, array<string, string>>
 */
function geekypress_preload_loader_font( $preload_resources ) {
	if ( ! geekypress_loader_is_enabled() ) {
		return $preload_resources;
	}

	$preload_resources[] = array(
		'href'        => get_theme_file_uri( 'assets/fonts/GeistMono-Variable.woff2' ),
		'as'          => 'font',
		'type'        => 'font/woff2',
		'crossorigin' => 'anonymous',
	);

	return $preload_resources;
}
add_filter( 'wp_preload_resources', 'geekypress_preload_loader_font' );

/**
 * Adds a state class used to prevent scrolling while the loader is visible.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function geekypress_loader_body_class( $classes ) {
	if ( geekypress_loader_is_enabled() ) {
		$classes[] = 'pt-loader-active';
	}
	return $classes;
}
add_filter( 'body_class', 'geekypress_loader_body_class' );

/**
 * Renders the accessible loader immediately after the opening body tag.
 */
function geekypress_render_loader() {
	if ( ! geekypress_loader_is_enabled() ) {
		return;
	}

	$settings = geekypress_get_loader_settings();
	$seconds  = (int) $settings['duration'];
	$duration = $seconds * 1000;
	?>
	<div id="pt-site-loader" class="pt-site-loader" role="status" aria-live="polite" aria-label="<?php esc_attr_e( 'Loading portfolio', 'geekypress' ); ?>" data-duration="<?php echo esc_attr( $duration ); ?>" style="--pt-loader-duration: <?php echo esc_attr( $duration ); ?>ms;">
		<div class="pt-loader-ambient" aria-hidden="true"><span>const developer = &quot;Alex Morgan&quot;;</span><span>git checkout portfolio</span><span>&lt;Developer mode=&quot;always-on&quot; /&gt;</span></div>
		<div class="pt-loader-shell">
			<div class="pt-loader-identity"><span><strong>&gt;_</strong> / developer portfolio</span><span class="pt-loader-online">system online</span></div>
			<div class="pt-loader-terminal">
				<div class="pt-loader-bar" aria-hidden="true"><span class="pt-loader-dots"><i></i><i></i><i></i></span><span>dev@portfolio: ~/boot</span><span></span></div>
				<div class="pt-loader-body">
					<p class="pt-loader-command"><span>dev@portfolio</span>:<b>~</b>$ npm run start <i>--production</i></p>
					<h2><?php esc_html_e( 'Hello, I’m', 'geekypress' ); ?> <mark>Alex<em aria-hidden="true"></em></mark></h2>
					<p class="pt-loader-copy content-text"><?php esc_html_e( 'Booting the portfolio. Good code takes a moment to compile.', 'geekypress' ); ?></p>
					<div class="pt-loader-logs" aria-hidden="true"><p><span>[ OK ]</span> Resolving components</p><p><span>[ OK ]</span> Loading developer profile</p><p><span>[ OK ]</span> Warming up portfolio</p><p><span>[ → ]</span> Rendering interface</p></div>
					<div class="pt-loader-progress" aria-hidden="true"><span></span></div>
					<p class="pt-loader-eta"><?php
					/* translators: %d: number of seconds until portfolio is ready. */
					echo esc_html( sprintf( _n( 'portfolio ready in %d second', 'portfolio ready in %d seconds', $seconds, 'geekypress' ), $seconds ) );
					?></p>
				</div>
			</div>
			<p class="pt-loader-note"><?php esc_html_e( 'Built with caffeine, curiosity & clean commits.', 'geekypress' ); ?></p>
		</div>
	</div>
	<noscript><style>#pt-site-loader{display:none!important}body.pt-loader-active{overflow:auto!important}</style></noscript>
	<?php
}
add_action( 'wp_body_open', 'geekypress_render_loader', 1 );

// Include Customizer and Helpers
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/customizer.php';
