<?php
/**
 * The sidebar containing the main widget area
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area terminal-sidebar" role="complementary" style="margin-top: 32px;">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
