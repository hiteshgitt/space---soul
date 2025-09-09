<?php
/**
 * Elementor integration
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if Elementor is active
 */
function space_and_soul_is_elementor_active() {
    return did_action( 'elementor/loaded' );
}

/**
 * Add Elementor support
 */
function space_and_soul_elementor_support() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor' );
        add_theme_support( 'elementor-pro' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_support' );

/**
 * Register Elementor locations
 */
function space_and_soul_register_elementor_locations( $elementor_theme_manager ) {
    if ( space_and_soul_is_elementor_active() ) {
        $elementor_theme_manager->register_location(
            'header',
            [
                'hook' => 'space_and_soul_header',
                'remove_hooks' => ['space_and_soul_header'],
            ]
        );
        
        $elementor_theme_manager->register_location(
            'footer',
            [
                'hook' => 'space_and_soul_footer',
                'remove_hooks' => ['space_and_soul_footer'],
            ]
        );
    }
}
add_action( 'elementor/theme/register_locations', 'space_and_soul_register_elementor_locations' );

/**
 * Add Elementor hooks
 */
function space_and_soul_elementor_hooks() {
    if ( space_and_soul_is_elementor_active() ) {
        add_action( 'space_and_soul_header', 'space_and_soul_render_elementor_header' );
        add_action( 'space_and_soul_footer', 'space_and_soul_render_elementor_footer' );
    }
}
add_action( 'init', 'space_and_soul_elementor_hooks' );

/**
 * Render Elementor header
 */
function space_and_soul_render_elementor_header() {
    if ( space_and_soul_is_elementor_active() ) {
        $header_template = get_option( 'space_and_soul_header_template' );
        if ( $header_template ) {
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_template );
        }
    }
}

/**
 * Render Elementor footer
 */
function space_and_soul_render_elementor_footer() {
    if ( space_and_soul_is_elementor_active() ) {
        $footer_template = get_option( 'space_and_soul_footer_template' );
        if ( $footer_template ) {
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_template );
        }
    }
}

/**
 * Add Elementor widgets
 */
function space_and_soul_add_elementor_widgets( $widgets_manager ) {
    if ( space_and_soul_is_elementor_active() ) {
        // Include custom widget files
        require_once SPACE_AND_SOUL_THEME_DIR . '/inc/elementor-widgets/space-and-soul-posts-widget.php';
        require_once SPACE_AND_SOUL_THEME_DIR . '/inc/elementor-widgets/space-and-soul-testimonial-widget.php';
        
        // Register widgets
        $widgets_manager->register( new \Space_And_Soul_Posts_Widget() );
        $widgets_manager->register( new \Space_And_Soul_Testimonial_Widget() );
    }
}
add_action( 'elementor/widgets/widgets_registered', 'space_and_soul_add_elementor_widgets' );

/**
 * Add Elementor categories
 */
function space_and_soul_add_elementor_categories( $elements_manager ) {
    if ( space_and_soul_is_elementor_active() ) {
        $elements_manager->add_category(
            'space-and-soul',
            [
                'title' => esc_html__( 'Space and Soul', 'space-and-soul' ),
                'icon' => 'fa fa-star',
            ]
        );
    }
}
add_action( 'elementor/elements/categories_registered', 'space_and_soul_add_elementor_categories' );

/**
 * Add Elementor controls
 */
function space_and_soul_add_elementor_controls( $controls_manager ) {
    if ( space_and_soul_is_elementor_active() ) {
        // Add custom controls here if needed
    }
}
add_action( 'elementor/controls/controls_registered', 'space_and_soul_add_elementor_controls' );

/**
 * Add Elementor templates
 */
function space_and_soul_add_elementor_templates() {
    if ( space_and_soul_is_elementor_active() ) {
        // Add custom templates here
    }
}
add_action( 'elementor/init', 'space_and_soul_add_elementor_templates' );

/**
 * Customize Elementor settings
 */
function space_and_soul_elementor_settings() {
    if ( space_and_soul_is_elementor_active() ) {
        // Disable Elementor's default colors and fonts
        add_action( 'elementor/frontend/after_enqueue_styles', function() {
            wp_dequeue_style( 'elementor-frontend' );
            wp_enqueue_style( 'elementor-frontend' );
        });
    }
}
add_action( 'elementor/init', 'space_and_soul_elementor_settings' );

/**
 * Add Elementor support for custom post types
 */
function space_and_soul_elementor_cpt_support() {
    if ( space_and_soul_is_elementor_active() ) {
        $cpt_support = get_theme_support( 'post-thumbnails' );
        $post_types = get_post_types_by_support( 'elementor' );
        
        if ( $post_types ) {
            add_theme_support( 'post-thumbnails', $post_types );
        }
    }
}
add_action( 'init', 'space_and_soul_elementor_cpt_support' );

/**
 * Add Elementor theme builder support
 */
function space_and_soul_elementor_theme_builder() {
    if ( space_and_soul_is_elementor_active() && class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
        add_theme_support( 'elementor-theme-builder' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_theme_builder' );

/**
 * Add Elementor popup support
 */
function space_and_soul_elementor_popup_support() {
    if ( space_and_soul_is_elementor_active() && class_exists( '\ElementorPro\Modules\Popup\Module' ) ) {
        add_theme_support( 'elementor-popup' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_popup_support' );

/**
 * Add Elementor motion effects support
 */
function space_and_soul_elementor_motion_effects() {
    if ( space_and_soul_is_elementor_active() && class_exists( '\ElementorPro\Modules\MotionEffects\Module' ) ) {
        add_theme_support( 'elementor-motion-effects' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_motion_effects' );

/**
 * Add Elementor custom CSS support
 */
function space_and_soul_elementor_custom_css() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor-custom-css' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_custom_css' );

/**
 * Add Elementor responsive support
 */
function space_and_soul_elementor_responsive() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor-responsive' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_responsive' );

/**
 * Add Elementor performance optimizations
 */
function space_and_soul_elementor_performance() {
    if ( space_and_soul_is_elementor_active() ) {
        // Disable Elementor's default fonts
        add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
        
        // Disable Elementor's default icons
        add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
        
        // Disable Elementor's default animations
        add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
    }
}
add_action( 'init', 'space_and_soul_elementor_performance' );

/**
 * Add Elementor custom fields support
 */
function space_and_soul_elementor_custom_fields() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor-custom-fields' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_custom_fields' );

/**
 * Add Elementor dynamic content support
 */
function space_and_soul_elementor_dynamic_content() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor-dynamic-content' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_dynamic_content' );

/**
 * Add Elementor template library support
 */
function space_and_soul_elementor_template_library() {
    if ( space_and_soul_is_elementor_active() ) {
        add_theme_support( 'elementor-template-library' );
    }
}
add_action( 'after_setup_theme', 'space_and_soul_elementor_template_library' );
