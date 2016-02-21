<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
?>
 <aside id="sidebar">

    <?php if ( is_active_sidebar( 'sidebar-primary' ) ) : ?>
    <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-primary' ); ?>
    </div><!-- #primary-sidebar -->
    <?php endif; ?>

</aside>