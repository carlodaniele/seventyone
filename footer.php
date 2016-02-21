<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
?>
		<footer id="site-footer" class="site-footer" role="contentinfo">
	        <?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		    <div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
		        <?php dynamic_sidebar( 'sidebar-footer' ); ?>
		    </div><!-- #primary-sidebar -->
	    <?php endif; ?>
        <div class="site-info">
          <small>&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?></small>
        </div>
		</footer>

	</div><!-- #page -->

	<?php wp_footer(); ?>
<!-- jQuery is called via the WordPress-friendly way via functions.php -->
</body>

</html>
