<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
 get_header(); ?>
 	<div id="main-content" class="main-content">
 		<div id="content" class="content-area" role="main">

 	<?php if( is_tag() ){ ?>
 		<div id="archive-heading"><?php single_tag_title('Currently browsing '); ?></div>
 	<?php } elseif ( is_category() ) { ?>
 		<div id="archive-heading"><?php single_cat_title('Currently browsing '); ?></div>
 	<?php } ?>


	<?php 
	if (have_posts()) : 
		// Start the Loop.
		while (have_posts()) : the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
					if ( is_single() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
					endif;
					?>

					<?php posted_on(); ?>
					<?php edit_post_link( __( 'Edit', 'seventyone' ), '<span class="edit-link">', '</span>' ); ?>				
				</header>

				<div class="entry-summary">
				<?php if ( has_post_format( 'quote' ) ) : ?>
					<blockquote><?php the_content(); ?></blockquote>
				<?php else: ?>
					<?php the_excerpt(); ?>
				<?php endif; ?>
				</div>

				<footer class="entry-meta">
					<?php the_tags(__('Tags: ','seventyone'), ', ', '<br />'); ?>
					<?php _e('Posted in','seventyone'); ?> <?php the_category(', ') ?> | 
					<?php
					if ( comments_open() ) :
					  comments_popup_link(__('No Comments &#187;','seventyone'), __('1 Comment &#187;','seventyone'), __('% Comments &#187;','seventyone'));
					endif;
					?>
				</footer>

			</article>

		<?php endwhile; ?>

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