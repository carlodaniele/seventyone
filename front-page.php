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
	?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
				</header>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

			</article>
	<?php endwhile; ?>

	<?php 
	else :
		// If no content, include the "No posts found" template.
		// from Twenty Fourteen
		get_template_part( 'content', 'none' );
	endif; 


	$latest_blog_posts = new WP_Query( array( 'posts_per_page' => 3 ) );

	if ( $latest_blog_posts->have_posts() ) : 
		while ( $latest_blog_posts->have_posts() ) : $latest_blog_posts->the_post();
	?>
	  	<div class="column3">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
				</header>

				<div class="entry-summary">
					<?php
						if ( has_post_thumbnail() ){
							?>
							<div class="post-thumbnail"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
							<?php
						}
					?>
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->

			</article>
	  	</div>
	<?php
		endwhile; 
	endif;
	wp_reset_query();

	?>
		</div><!-- #content -->
	</div><!-- #main-content -->


<?php get_footer(); ?>