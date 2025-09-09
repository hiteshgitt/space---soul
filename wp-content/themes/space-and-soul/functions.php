<?php
/**
 * Space and Soul Theme Functions
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define theme constants
define( 'SPACE_AND_SOUL_VERSION', '1.0.0' );
define( 'SPACE_AND_SOUL_THEME_DIR', get_template_directory() );
define( 'SPACE_AND_SOUL_THEME_URL', get_template_directory_uri() );

/**
 * Theme setup
 */
function space_and_soul_setup() {
    // Add theme support for various features
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    
    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'space-and-soul' ),
        'footer'  => esc_html__( 'Footer Menu', 'space-and-soul' ),
    ) );
    
    // Set content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}
add_action( 'after_setup_theme', 'space_and_soul_setup' );

/**
 * Enqueue scripts and styles
 */
function space_and_soul_scripts() {
    // Google Fonts
    wp_enqueue_style( 'space-and-soul-fonts', 'https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Times+New+Roman:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null );
    
    // Main stylesheet
    wp_enqueue_style( 'space-and-soul-style', get_stylesheet_uri(), array( 'space-and-soul-fonts' ), SPACE_AND_SOUL_VERSION );
    
    // Main JavaScript
    wp_enqueue_script( 'space-and-soul-main', SPACE_AND_SOUL_THEME_URL . '/assets/js/main.js', array( 'jquery' ), SPACE_AND_SOUL_VERSION, true );
    
    // Localize script for AJAX
    wp_localize_script( 'space-and-soul-main', 'spaceAndSoul', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'space_and_soul_nonce' ),
    ) );
    
    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'space_and_soul_scripts' );

/**
 * Register widget areas
 */
function space_and_soul_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'space-and-soul' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'space-and-soul' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area', 'space-and-soul' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add footer widgets here.', 'space-and-soul' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'space_and_soul_widgets_init' );

/**
 * Custom template tags
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/extras.php';

/**
 * Customizer additions
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/customizer.php';

/**
 * Elementor integration
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/elementor.php';

/**
 * Performance optimizations
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/performance.php';

/**
 * Security enhancements
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/security.php';

/**
 * SEO enhancements
 */
require_once SPACE_AND_SOUL_THEME_DIR . '/inc/seo.php';

/**
 * Add custom image sizes
 */
function space_and_soul_image_sizes() {
    add_image_size( 'space-and-soul-featured', 800, 400, true );
    add_image_size( 'space-and-soul-thumbnail', 300, 200, true );
}
add_action( 'after_setup_theme', 'space_and_soul_image_sizes' );

/**
 * Custom excerpt length
 */
function space_and_soul_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'space_and_soul_excerpt_length', 999 );

/**
 * Custom excerpt more
 */
function space_and_soul_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'space_and_soul_excerpt_more' );


/**
 * Remove unnecessary WordPress features for performance
 */
function space_and_soul_cleanup() {
    // Remove emoji scripts
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    
    // Remove unnecessary meta tags
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'space_and_soul_cleanup' );
