<?php
/**
 * The default Sidebar. It will appear on all Projects
 *
 * @package WordPress
 * @subpackage Charitas
 * @since Charitas 1.1.1
 */
?>
<?php if ( is_active_sidebar( 'project-1' ) ) : ?>
	<div id="secondary" class="grid_4 widget-area" role="complementary">
		<?php if ( ! dynamic_sidebar( 'project-1' ) ) : ?>
		<?php endif; // end sidebar widget area ?>
	</div>
<?php endif; ?>