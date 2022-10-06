<?php
/**
 * jed functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package jed
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jed_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on jed, use a find and replace
		* to change 'jed' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'jed', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );



    add_theme_support( 'align-wide' );


    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'jed' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'jed_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'jed_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jed_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jed_content_width', 640 );
}
add_action( 'after_setup_theme', 'jed_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jed_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'jed' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'jed' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'jed_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jed_scripts() {
	wp_enqueue_style( 'jed-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'jed-style', 'rtl', 'replace' );

	wp_enqueue_script( 'jed-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jed_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}




add_image_size( 'student', 200, 300, true);


add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});









//

/**
 * Add custom taxonomies & post types
 *
 */



function add_custom_taxonomies(): void
{
    // Add new "Locations" taxonomy to Posts
    register_taxonomy('staff', 'jed-staff', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Terms', 'taxonomy general name' ),
            'singular_name' => _x( 'term', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search terms' ),
            'all_items' => __( 'All terms' ),
            'parent_item' => __( 'Parent term' ),
            'parent_item_colon' => __( 'Parent term:' ),
            'edit_item' => __( 'Edit term' ),
            'update_item' => __( 'Update term' ),
            'add_new_item' => __( 'Add New term' ),
            'new_item_name' => __( 'New term Name' ),
            'menu_name' => __( 'Terms' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'terms', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));


    // Add new "Locations" taxonomy to Posts
    register_taxonomy('student', 'jed-student', array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Field', 'taxonomy general name' ),
            'singular_name' => _x( 'field', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search fields' ),
            'all_items' => __( 'All fields' ),
            'parent_item' => __( 'Parent field' ),
            'parent_item_colon' => __( 'Parent field:' ),
            'edit_item' => __( 'Edit fields' ),
            'update_item' => __( 'Update field' ),
            'add_new_item' => __( 'Add New field' ),
            'new_item_name' => __( 'New field Name' ),
            'menu_name' => __( 'Fields' ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'fields', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));


}
add_action( 'init', 'add_custom_taxonomies', 0 );

function add_custom_post_types(): void
{

    // Register staff
    $labels = array(
        'name' => _x('Staffs', 'post type general name'),
        'singular_name' => _x('Staff', 'post type singular name'),
        'menu_name' => _x('Staffs', 'admin menu'),
        'name_admin_bar' => _x('Staff', 'add new on admin bar'),
        'add_new' => _x('Add New', 'staff'),
        'add_new_item' => __('Add New Staff'),
        'new_item' => __('New Staff'),
        'edit_item' => __('Edit Staff'),
        'view_item' => __('View Staff'),
        'all_items' => __('All Staffs'),
        'search_items' => __('Search Staffs'),
        'parent_item_colon' => __('Parent Staffs:'),
        'not_found' => __('No staff found.'),
        'not_found_in_trash' => __('No staff found in Trash.'),
        'archives' => __('Staff Archives'),
        'insert_into_item' => __('Insert into staff'),
        'uploaded_to_this_item' => __('Uploaded to this staff'),
        'filter_item_list' => __('Filter staff list'),
        'items_list_navigation' => __('Staffs list navigation'),
        'items_list' => __('Staffs list'),
        'featured_image' => __('Staff featured image'),
        'set_featured_image' => __('Set staff featured image'),
        'remove_featured_image' => __('Remove staff featured image'),
        'use_featured_image' => __('Use as featured image'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'staff'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title',),
    );

    register_post_type('jed-staff', $args);

//    Register Student


    $labels = array(
        'name' => _x('Students', 'post type general name'),
        'singular_name' => _x('student', 'post type singular name'),
        'menu_name' => _x('Students', 'admin menu'),
        'name_admin_bar' => _x('student', 'add new on admin bar'),
        'add_new' => _x('Add New', 'student'),
        'add_new_item' => __('Add New student'),
        'new_item' => __('New student'),
        'edit_item' => __('Edit student'),
        'view_item' => __('View student'),
        'all_items' => __('All Students'),
        'search_items' => __('Search Students'),
        'parent_item_colon' => __('Parent Students:'),
        'not_found' => __('No student found.'),
        'not_found_in_trash' => __('No student found in Trash.'),
        'archives' => __('student Archives'),
        'insert_into_item' => __('Insert into student'),
        'uploaded_to_this_item' => __('Uploaded to this student'),
        'filter_item_list' => __('Filter student list'),
        'items_list_navigation' => __('Students list navigation'),
        'items_list' => __('Students list'),
        'featured_image' => __('student featured image'),
        'set_featured_image' => __('Set student featured image'),
        'remove_featured_image' => __('Remove student featured image'),
        'use_featured_image' => __('Use as featured image'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'student'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-carrot',
        'supports' => array('title', 'editor', 'thumbnail'),
        'template_lock' => 'all',
        'template' => array(array('core/paragraph'), array('core/button')),
    );

    register_post_type('jed-student', $args);




}
add_action( 'init', 'add_custom_post_types', 0 );
