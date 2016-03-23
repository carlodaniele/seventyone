<?php
/**
 * @package WordPress
 * @subpackage SeventyOne
 * @since SeventyOne 1.0
 */

// Theme Setup (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
function seventyone_setup() {
	load_theme_textdomain( 'seventyone', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status', 'link', 'video' ) );
	register_nav_menu( 'primary', __( 'Navigation Menu', 'seventyone' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'seventyone_setup' );

function seventyone_init(){
	
	// custom post types
	$labels = array(
		'name' => 'Events',
		'singular_name' => 'Event',
		'menu_name' => 'My Events',
		'all_items' => 'All Events',
		'add_new' => 'Add New',
		'add_new_item' => 'Add new Event',
		'edit' => 'Edit',
		'edit_item' => 'Edit Event',
		'new_item' => 'New Event',
		'view' => 'View',
		'view_item' => 'View Event',
		'search_items' => 'Search Event',
		'not_found' => 'No Events found',
		'not_found_in_trash' => 'No Events in Thrash',
		'parent' => 'Parent Event',
	);

	$supports = array( 
		'title', 
		'editor', 
		'excerpt', 
		'custom-fields', 
		'comments', 
		'revisions', 
		'thumbnail', 
		'author', 
		'page-attributes' 
	);
	
	$args = array(
		'labels' => $labels,
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'show_in_menu' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'event', 'with_front' => true ),
		'query_var' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-calendar-alt',		
		'supports' => $supports,
		'taxonomies' => array( 'event_category' )
	);

	register_post_type( 'event', $args );

	// custom taxonomies
	$labels = array(
		"name" => "Event Categories",
		"label" => "Event Categories",
		"menu_name" => "Categories",
		"all_items" => "All categories",
		"edit_item" => "Edit category",
		"view_item" => "View category",
		"update_item" => "Update category",
		"add_new_item" => "Add new category",
		"new_item_name" => "New category name",
		"parent_item" => "Parent category",
		"parent_item_colon" => "Parent category:",
		"search_items" => "Search categories",
		"popular_items" => "Popular categories",
		"separate_items_with_commas" => "Separate categories with commas",
		"add_or_remove_items" => "Add or remove categories",
		"choose_from_most_used" => "Choose from the most used categories",
		"not_found" => "No categories found",
	);

	$args = array(
		"labels" => $labels,
		"hierarchical" => false,
		"label" => "Event Categories",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'event_category', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "event_category", array( "event" ), $args );

	add_shortcode( 'seventyone_user_info', 'seventyone_user_info' );

	if ( ! isset( $content_width ) ) $content_width = 960;
}
add_action( 'init', 'seventyone_init' );


/**
 * Adds a box to the main column on the Event CPT edit screens.
 */
function seventyone_add_meta_box(){
  add_meta_box('seventyone_event_meta_box', __( 'Event details', 'seventyone' ), 'seventyone_build_meta_box', 'event', 'side' );
}

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function seventyone_build_meta_box( $post ){

	// Add a nonce field for the meta box
	wp_nonce_field( 'seventyone_save_meta_box_data', 'seventyone_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */

	$start_date = get_post_meta( $post->ID, '_seventyone_event_start_date', true );
	$end_date = get_post_meta( $post->ID, '_seventyone_event_end_date', true );
	$location = get_post_meta( $post->ID, '_seventyone_event_location', true );
	
	?>
	<div class="inside">
		<p><strong>Start</strong></p>
		<p><input type="date" id="seventyone_event_start_date" name="seventyone_event_start_date" value="<?php echo esc_attr( $start_date ); ?>" /></p>
	
		<p><strong>End</strong></p>
		<p><input type="date" id="seventyone_event_end_date" name="seventyone_event_end_date" value="<?php echo esc_attr( $end_date ); ?>" /></p>
	
		<p><strong>Location</strong></p>
		<p><input type="text" id="seventyone_event_location" name="seventyone_event_location" value="<?php echo esc_attr( $location ); ?>" /></p>
	</div>
	<?php
}
add_action('add_meta_boxes', 'seventyone_add_meta_box');





/**
 * When the post is saved, saves custom meta data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function seventyone_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['seventyone_meta_box_nonce'] ) )
		return;

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['seventyone_meta_box_nonce'], 'seventyone_save_meta_box_data' ) )
		return;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'event' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

	}
	
	// Make sure that it is set.
	if ( ! isset( $_POST['seventyone_event_start_date'] ) )
		return;

	if ( ! isset( $_POST['seventyone_event_end_date'] ) )
		return;

	if ( ! isset( $_POST['seventyone_event_location'] ) )
		return;

	// Sanitize user input.
	$start_date = sanitize_text_field( $_POST['seventyone_event_start_date'] );
	$end_date = sanitize_text_field( $_POST['seventyone_event_end_date'] );
	$location = sanitize_text_field( $_POST['seventyone_event_location'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_seventyone_event_start_date', $start_date );
	update_post_meta( $post_id, '_seventyone_event_end_date', $end_date );
	update_post_meta( $post_id, '_seventyone_event_location', $location );
}
add_action( 'save_post', 'seventyone_save_meta_box_data' );




/**
 * Filter the content when specific post type are requested
 *
 * @uses is_singular
 */
function seventyone_customize_content( $content ) { 

	if ( !is_singular( 'event' ) )
		return $content;

	$start_date = get_post_meta( get_the_ID(), '_seventyone_event_start_date', true );
	$end_date = get_post_meta( get_the_ID(), '_seventyone_event_end_date', true );
	$location = get_post_meta( get_the_ID(), '_seventyone_event_location', true );

	
	$list = "<ul>";

	if ( !empty( $start_date ) )
		$list .= "<li>" . __( 'From', 'seventyone' ) . ': ' . $start_date . "</li>";
	
	if ( !empty( $end_date ) )
		$list .= "<li>" . __( 'To', 'seventyone' ) . ': ' . $end_date . "</li>";
	
	if ( !empty( $location ) )
		$list .= "<li>" . __( 'Location', 'seventyone' ) . ': ' . $location . "</li>";
	
	$list .= "</ul>";

	return $content . $list;	
}
add_filter( 'the_content', 'seventyone_customize_content' ); 



/**
 * Enqueue Scripts & Styles (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
 */
function seventyone_scripts_styles() {

	// Load Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

}
add_action( 'wp_enqueue_scripts', 'seventyone_scripts_styles' );

// WP Title (based on twentythirteen: http://make.wordpress.org/core/tag/twentythirteen/)
function seventyone_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

// Add the site name.
	$title .= get_bloginfo( 'name' );

// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'seventyone' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'seventyone_wp_title', 10, 2 );




//OLD STUFF BELOW


// Load jQuery
if ( !function_exists( 'core_mods' ) ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', ( "http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ), false);
			wp_enqueue_script( 'jquery' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'core_mods' );
}

// Widgets
if ( function_exists('register_sidebar' )) {
	function seventyone_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar Widgets', 'seventyone' ),
			'id'            => 'sidebar-primary',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sidebar Footer', 'seventyone' ),
			'id'            => 'sidebar-footer',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'seventyone_widgets_init' );
}

// Navigation - update coming from twentythirteen
function post_navigation() {
	echo '<div class="navigation">';
	echo '	<div class="next-posts">'.get_next_posts_link('&laquo; Older Entries').'</div>';
	echo '	<div class="prev-posts">'.get_previous_posts_link('Newer Entries &raquo;').'</div>';
	echo '</div>';
}

// Posted On
function posted_on() {
	printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> by <span class="byline author vcard">%5$s</span>', '' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_author() )
	);
}

/*
 * Aggiunge variabili alle query vars
 */
function seventyone_register_query_var( $vars ) {
    $vars[] = 'citta';
    return $vars;
} 
add_filter( 'query_vars', 'seventyone_register_query_var' );

/*
 * Richiama il template specifico per il custom post type 
 */
function seventyone_url_rewrite_templates() {
    if ( get_query_var( 'citta' ) ) {
        add_filter( 'template_include', function() {
            return get_stylesheet_directory() . '/archive-citta.php';
        });
    }
}
add_action( 'template_redirect', 'seventyone_url_rewrite_templates' );

function seventyone_user_info( $atts ){

	$atts = shortcode_atts( array(
			// list of all available attributes and their defaults
			'attribute' => 'display_name'
		), $atts, 'seventyone_user_info' );

	if ( is_user_logged_in() ) { 

        // get the current user
        $cu = wp_get_current_user();
        $attribute = sanitize_html_class( $atts['attribute'] );

        return $cu->$attribute;

    }else{
        return '';
    }
}

function seventyone_build_settings_section(){
	echo 'Seventyone setting section';
}

function seventyone_settings_field() {
 	echo '<input name="seventyone_setting_field" id="seventyone_setting_field" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'seventyone_setting_field' ), false ) . ' /> Seventyone setting field';
 }

function seventyone_custom_settings(){
	add_settings_section( 
		'seventyone_settings_section', 
		'Seventyone Settings', 
		'seventyone_build_settings_section', 
		'discussion' );
	add_settings_field( 
		'seventyone_setting_field', 
		'Seventyone field', 
		'seventyone_settings_field', 
		'discussion', 
		'seventyone_settings_section' );
	register_setting( 'discussion', 'seventyone_setting_field' );
} // seventyone_custom_settings()
add_action( 'admin_init', 'seventyone_custom_settings' );

function seventyone_customize_register( $wp_customize ) {
   $wp_customize->add_setting( 'seventyone_header_color' , array(
		'default'		=> '#555555',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_section( 'seventyone_header_section' , array(
		'title'      => __( 'Header', 'seventyone' ),
		'priority'   => 30
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'        => __( 'Site Title Color', 'seventyone' ),
		'section'    => 'seventyone_header_section',
		'settings'   => 'seventyone_header_color'
	) ) );
}
add_action( 'customize_register', 'seventyone_customize_register' );
