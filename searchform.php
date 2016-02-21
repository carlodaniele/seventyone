<?php
/**
 * @package WordPress
 * @subpackage Seventy-One-WordPress-Theme
 * @since Seventy One 1.0
 */

$args = array(
   'public'		=> true,
   '_builtin'	=> false
);

$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'

$post_types = get_post_types( $args, $output, $operator ); 


 ?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<?php
	if( count( $post_types ) > 0 ) : 
	?>
		<span class="screen-reader-text"><?php echo _x( 'Search in:', 'label' ); ?></span>
		<ul>
		<?php foreach ( $post_types as $post_type ) { ?>
			<li><input type="radio" name="post_type" value="<?php echo esc_attr( $post_type ); ?>" <?php checked( get_query_var( 'post_type' ), esc_attr( $post_type ) ); ?> /> <?php echo esc_attr( $post_type ); ?></li>
		<?php } ?>
			<li><input type="radio" name="post_type" value="any" <?php checked( get_query_var( 'post_type' ), 'any' ); ?> /> any post type</li>
		</ul>
	<?php
	endif;
	?>
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ); ?></span><br />
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ); ?>" />
	</label>

	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
</form>