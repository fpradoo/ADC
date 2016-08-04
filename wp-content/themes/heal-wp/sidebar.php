<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package heal-wp
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="blog-sidebar" class="col-md-4 blog-sidebar">

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

</aside><!-- /#blog-sidebar -->	
