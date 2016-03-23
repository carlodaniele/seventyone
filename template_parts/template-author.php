<?php
/**
 * @package WordPress
 * @subpackage SeventyOne
 * @since SeventyOne 1.0
 */
 ?>
			<aside class="author-box">
				<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
				<h4><?php echo __('About', 'seventyone' ) . get_the_author_meta( 'display_name' ); ?></h4>
				<p>
					<?php the_author_meta( 'description' ); ?><br />
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php echo __('View all posts by', 'seventyone' ) . get_the_author() . ' (' . get_the_author_posts() .')'; ?>
					</a>
				</p>
			</aside>
