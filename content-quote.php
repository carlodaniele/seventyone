<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */
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

			<?php if ( is_search() ) : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>

			<div class="entry">
				<blockquote>
					<?php the_content(); ?>
				</blockquote>
			</div>

			<footer class="postmetadata">
				<?php the_tags(__('Tags: ','seventyone'), ', ', '<br />'); ?>
				<?php _e('Posted in','seventyone'); ?> <?php the_category(', ') ?> | 
				<?php comments_popup_link(__('No Comments &#187;','seventyone'), __('1 Comment &#187;','seventyone'), __('% Comments &#187;','seventyone')); ?>
			</footer>
			<?php endif; ?>
		</article>