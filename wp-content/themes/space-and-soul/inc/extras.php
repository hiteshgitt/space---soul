<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
function space_and_soul_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'space_and_soul_pingback_header' );

/**
 * Add custom classes to the body
 */
function space_and_soul_body_classes( $classes ) {
    // Add class for Elementor
    if ( did_action( 'elementor/loaded' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
        $classes[] = 'elementor-preview';
    }
    
    // Add class for no sidebar
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
    
    return $classes;
}
add_filter( 'body_class', 'space_and_soul_body_classes' );

/**
 * Add custom classes to posts
 */
function space_and_soul_post_classes( $classes ) {
    // Add reading time class
    $classes[] = 'has-reading-time';
    
    return $classes;
}
add_filter( 'post_class', 'space_and_soul_post_classes' );

/**
 * Customize the login page
 */
function space_and_soul_login_styles() {
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo esc_url( SPACE_AND_SOUL_THEME_URL . '/assets/images/logo.png' ); ?>);
            height: 65px;
            width: 320px;
            background-size: 320px 65px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'space_and_soul_login_styles' );

/**
 * Change login logo URL
 */
function space_and_soul_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'space_and_soul_login_logo_url' );

/**
 * Change login logo title
 */
function space_and_soul_login_logo_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'space_and_soul_login_logo_title' );

/**
 * Add custom admin footer text
 */
function space_and_soul_admin_footer_text() {
    echo 'Thank you for creating with <a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>.';
}
add_filter( 'admin_footer_text', 'space_and_soul_admin_footer_text' );

/**
 * Add customizer link to admin bar
 */
function space_and_soul_admin_bar_menu( $wp_admin_bar ) {
    if ( ! is_admin() ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'customize',
            'title' => __( 'Customize', 'space-and-soul' ),
            'href'  => admin_url( 'customize.php' ),
        ) );
    }
}
add_action( 'admin_bar_menu', 'space_and_soul_admin_bar_menu', 50 );

/**
 * Add reading time to post meta
 */
function space_and_soul_add_reading_time() {
    if ( is_single() ) {
        echo '<span class="reading-time">' . space_and_soul_reading_time() . '</span>';
    }
}
add_action( 'space_and_soul_post_meta', 'space_and_soul_add_reading_time' );

/**
 * Add social sharing buttons
 */
function space_and_soul_social_sharing() {
    if ( is_single() ) {
        $url = get_permalink();
        $title = get_the_title();
        ?>
        <div class="social-sharing">
            <h4><?php esc_html_e( 'Share this post:', 'space-and-soul' ); ?></h4>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( $url ); ?>" target="_blank" rel="noopener">
                <?php esc_html_e( 'Facebook', 'space-and-soul' ); ?>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( $url ); ?>&text=<?php echo urlencode( $title ); ?>" target="_blank" rel="noopener">
                <?php esc_html_e( 'Twitter', 'space-and-soul' ); ?>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode( $url ); ?>" target="_blank" rel="noopener">
                <?php esc_html_e( 'LinkedIn', 'space-and-soul' ); ?>
            </a>
        </div>
        <?php
    }
}
add_action( 'space_and_soul_after_content', 'space_and_soul_social_sharing' );

/**
 * Add breadcrumbs
 */
function space_and_soul_breadcrumbs() {
    if ( ! is_home() && ! is_front_page() ) {
        ?>
        <nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'space-and-soul' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'space-and-soul' ); ?></a>
            <?php
            if ( is_category() || is_single() ) {
                echo ' / ';
                the_category( ' / ' );
                if ( is_single() ) {
                    echo ' / ';
                    the_title();
                }
            } elseif ( is_page() ) {
                echo ' / ';
                the_title();
            }
            ?>
        </nav>
        <?php
    }
}
add_action( 'space_and_soul_before_content', 'space_and_soul_breadcrumbs' );

/**
 * Add back to top button
 */
function space_and_soul_back_to_top() {
    ?>
    <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'space-and-soul' ); ?>">
        <span class="screen-reader-text"><?php esc_html_e( 'Back to top', 'space-and-soul' ); ?></span>
        ↑
    </button>
    <?php
}
add_action( 'wp_footer', 'space_and_soul_back_to_top' );
