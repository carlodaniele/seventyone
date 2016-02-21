<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
 get_header(); ?>
 	<div id="main-content" class="main-content">
 		<div id="content" class="content-area" role="main">

	<?php 
	if (have_posts()) : 
		// Start the Loop.
		while (have_posts()) : the_post();
			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 * from Twenty Fourteen
			 */
			get_template_part( 'content', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template
			// from twentyfourteen
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile; 
	?>

		<?php post_navigation(); ?>


	<?php 
	else :
		// If no content, include the "No posts found" template.
		// from Twenty Fourteen
		get_template_part( 'content', 'none' );
	endif; 
	?>
		</div><!-- #content -->
	</div><!-- #main-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>