<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */

// from twenty fourteen
 ?>

<header class="page-header">
	<h1 class="page-title"><?php _e( 'Nothing Found', 'seventyone' ); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( __( 'Publish your first post <a href="%1$s">here</a>.', 'seventyone' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p><?php _e( 'Nothing found. Please try again.', 'seventyone' ); ?></p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<p><?php _e( 'Nothing found.', 'seventyone' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</div><!-- .page-content -->
