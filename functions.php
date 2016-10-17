<?php
/**
 * Demos Importer test functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Demos_Importer_test
 */

if ( ! function_exists( 'demos_importer_test_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function demos_importer_test_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Demos Importer test, use a find and replace
	 * to change 'demos-importer-test' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'demos-importer-test', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'demos-importer-test' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'demos_importer_test_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'demos_importer_test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function demos_importer_test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'demos_importer_test_content_width', 640 );
}
add_action( 'after_setup_theme', 'demos_importer_test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function demos_importer_test_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'demos-importer-test' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'demos-importer-test' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'demos_importer_test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function demos_importer_test_scripts() {
	wp_enqueue_style( 'demos-importer-test-style', get_stylesheet_uri() );

	wp_enqueue_script( 'demos-importer-test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'demos-importer-test-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'demos_importer_test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * one Click demo import plugin testing.
 */

function ocdi_plugin_page_setup( $default_settings ) {
    $default_settings['parent_slug'] = 'themes.php';
    $default_settings['page_title']  = esc_html__( 'Test Demo Import' , 'pt-ocdi' );
    $default_settings['menu_title']  = esc_html__( 'Test Demo Import' , 'pt-ocdi' );
    $default_settings['capability']  = 'import';
    $default_settings['menu_slug']   = 'pt-one-click-demo-import';

    return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );

function ocdi_plugin_intro_text( $default_text ) {
    $default_text .= '<div class="ocdi__intro-text">This is a custom text added to this plugin intro text.
    <a href="">Divi 100</a>
    <a href="">CakeWP</a>
    </div>';



    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );

function ocdi_import_files() {
    return array(
        array(
            'import_file_name'             => 'Demo Import 1',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'ocdi/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'ocdi/widgets.json',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'ocdi/customizer.dat',
            'import_preview_image_url'     => 'http://www.your_domain.com/ocdi/preview_import_image1.jpg',
            'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
        ),
        array(
            'import_file_name'             => 'Demo Import 2',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'ocdi/demo-content2.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'ocdi/widgets2.json',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'ocdi/customizer2.dat',
            'import_preview_image_url'     => 'http://www.your_domain.com/ocdi/preview_import_image2.jpg',
            'import_notice'                => __( 'A special note for this import.', 'your-textdomain' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


/**
 * DEMO IMPORTER TESTING.
 */

include_once( 'inc/bootstrapguru-importer.php' );

function my_menu_item(){
	add_menu_page(
		'My Import Demo',
		'My Import Demo',
		'manage_options',
		'my_import_demo',
		'my_demo_function',
		null, 99);
}
add_action("admin_menu", "my_menu_item");

function my_demo_function(){
	echo '<a class="bootstrapguru_import" href="">Import Test</a>
    <div class="import_message"></div>';
}

