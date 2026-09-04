<?php
/**
 * The searchform template for GeekyPress
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="search-form terminal-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="geekypress-search-field">
		<?php esc_html_e( 'Search for:', 'geekypress' ); ?>
	</label>
	<div class="terminal-search-input-wrap">
		<span class="terminal-search-prompt" aria-hidden="true">&gt;_</span>
		<input
			type="search"
			id="geekypress-search-field"
			class="search-field terminal-search-input"
			placeholder="<?php echo esc_attr_x( 'search_query...', 'placeholder', 'geekypress' ); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
		/>
		<button type="submit" class="search-submit terminal-search-submit-btn" aria-label="<?php esc_attr_e( 'Submit search', 'geekypress' ); ?>">
			<?php echo geekypress_get_icon( 'search', '', 14 ); ?>
			<span><?php esc_html_e( 'Search', 'geekypress' ); ?></span>
		</button>
	</div>
</form>
