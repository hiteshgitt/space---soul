<?php
/**
 * Performance optimization functions
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Lazy load images
 */
function space_and_soul_lazy_load_images( $content ) {
    if ( is_admin() || is_feed() || is_preview() ) {
        return $content;
    }
    
    // Add loading="lazy" to images
    $content = preg_replace( '/<img(.*?)src=/', '<img$1loading="lazy" src=', $content );
    
    return $content;
}
add_filter( 'the_content', 'space_and_soul_lazy_load_images' );

/**
 * Defer JavaScript loading
 */
function space_and_soul_defer_scripts( $tag, $handle, $src ) {
    // List of scripts to defer
    $defer_scripts = array( 'space-and-soul-main' );
    
    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( '<script ', '<script defer ', $tag );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'space_and_soul_defer_scripts', 10, 3 );

/**
 * Remove query strings from static resources
 */
function space_and_soul_remove_query_strings( $src ) {
    $output = preg_split( "/(&ver|\?ver)/", $src );
    return $output[0];
}
add_filter( 'script_loader_src', 'space_and_soul_remove_query_strings', 15, 1 );
add_filter( 'style_loader_src', 'space_and_soul_remove_query_strings', 15, 1 );

/**
 * Optimize database queries
 */
function space_and_soul_optimize_queries() {
    // Remove unnecessary queries
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'space_and_soul_optimize_queries' );

/**
 * Disable XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove unnecessary WordPress features
 */
function space_and_soul_remove_unnecessary_features() {
    // Remove emoji scripts
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
    // Remove block library CSS
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' );
    
    // Remove global styles
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'space_and_soul_remove_unnecessary_features', 100 );

/**
 * Optimize images
 */
function space_and_soul_optimize_images( $metadata, $attachment_id ) {
    // Add WebP support
    if ( isset( $metadata['file'] ) ) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
        $file_info = pathinfo( $file_path );
        
        if ( in_array( strtolower( $file_info['extension'] ), array( 'jpg', 'jpeg', 'png' ) ) ) {
            // Generate WebP version
            space_and_soul_generate_webp( $file_path );
        }
    }
    
    return $metadata;
}
add_filter( 'wp_generate_attachment_metadata', 'space_and_soul_optimize_images', 10, 2 );

/**
 * Generate WebP images
 */
function space_and_soul_generate_webp( $file_path ) {
    if ( ! function_exists( 'imagewebp' ) ) {
        return false;
    }
    
    $file_info = pathinfo( $file_path );
    $webp_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';
    
    if ( file_exists( $webp_path ) ) {
        return true;
    }
    
    $image = null;
    $extension = strtolower( $file_info['extension'] );
    
    switch ( $extension ) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg( $file_path );
            break;
        case 'png':
            $image = imagecreatefrompng( $file_path );
            break;
    }
    
    if ( $image ) {
        $result = imagewebp( $image, $webp_path, 80 );
        imagedestroy( $image );
        return $result;
    }
    
    return false;
}

/**
 * Add preload hints for critical resources
 */
function space_and_soul_preload_critical_resources() {
    ?>
    <link rel="preload" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" as="style">
    <link rel="preload" href="<?php echo esc_url( SPACE_AND_SOUL_THEME_URL . '/assets/js/main.js' ); ?>" as="script">
    <?php
}
add_action( 'wp_head', 'space_and_soul_preload_critical_resources', 1 );

/**
 * Minify HTML output
 */
function space_and_soul_minify_html( $buffer ) {
    if ( is_admin() || is_feed() || is_preview() ) {
        return $buffer;
    }
    
    // Remove HTML comments
    $buffer = preg_replace( '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $buffer );
    
    // Remove extra whitespace
    $buffer = preg_replace( '/\s+/', ' ', $buffer );
    $buffer = preg_replace( '/>\s+</', '><', $buffer );
    
    return $buffer;
}

/**
 * Start output buffering for HTML minification
 */
function space_and_soul_start_minify() {
    if ( ! is_admin() && ! is_feed() && ! is_preview() ) {
        ob_start( 'space_and_soul_minify_html' );
    }
}
add_action( 'template_redirect', 'space_and_soul_start_minify' );

/**
 * Add critical CSS inline
 */
function space_and_soul_critical_css() {
    ?>
    <style>
        /* Critical CSS for above-the-fold content */
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,Cantarell,sans-serif;line-height:1.6;color:#333;margin:0;padding:0}
        .site-header{background:transparent !important;border-bottom:none;position:fixed;top:0;left:0;right:0;z-index:1000;transition:all 0.3s ease;width:100%}
        .container{max-width:1200px;margin:0 auto;padding:0 20px}
        .header-content{display:flex;justify-content:space-between;align-items:center;padding:1rem 2rem;max-width:100%;width:100%}
        .site-title{margin:0;font-size:1.5rem;font-weight:700;color:#ffffff;text-shadow:2px 2px 4px rgba(0,0,0,0.5)}
        .site-title a{text-decoration:none;color:#ffffff;transition:all 0.3s ease;text-shadow:2px 2px 4px rgba(0,0,0,0.5)}
    </style>
    <?php
}
add_action( 'wp_head', 'space_and_soul_critical_css', 1 );
