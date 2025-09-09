<?php
/**
 * SEO enhancement functions
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add meta description
 */
function space_and_soul_meta_description() {
    if ( is_home() || is_front_page() ) {
        $description = get_bloginfo( 'description' );
    } elseif ( is_single() || is_page() ) {
        $description = get_the_excerpt();
        if ( empty( $description ) ) {
            $description = wp_trim_words( get_the_content(), 30 );
        }
    } elseif ( is_category() || is_tag() ) {
        $description = term_description();
    } elseif ( is_archive() ) {
        $description = get_the_archive_description();
    }
    
    if ( ! empty( $description ) ) {
        echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_meta_description', 1 );

/**
 * Add Open Graph meta tags
 */
function space_and_soul_og_meta_tags() {
    if ( is_single() || is_page() ) {
        $og_title = get_the_title();
        $og_description = get_the_excerpt();
        $og_url = get_permalink();
        $og_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        
        if ( empty( $og_description ) ) {
            $og_description = wp_trim_words( get_the_content(), 30 );
        }
        
        if ( empty( $og_image ) ) {
            $og_image = get_header_image();
        }
        
        echo '<meta property="og:title" content="' . esc_attr( $og_title ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( wp_strip_all_tags( $og_description ) ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( $og_url ) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
        
        if ( $og_image ) {
            echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
        }
    } elseif ( is_home() || is_front_page() ) {
        echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_og_meta_tags', 2 );

/**
 * Add Twitter Card meta tags
 */
function space_and_soul_twitter_card_meta() {
    if ( is_single() || is_page() ) {
        $twitter_title = get_the_title();
        $twitter_description = get_the_excerpt();
        $twitter_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        
        if ( empty( $twitter_description ) ) {
            $twitter_description = wp_trim_words( get_the_content(), 30 );
        }
        
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr( $twitter_title ) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr( wp_strip_all_tags( $twitter_description ) ) . '">' . "\n";
        
        if ( $twitter_image ) {
            echo '<meta name="twitter:image" content="' . esc_url( $twitter_image ) . '">' . "\n";
        }
    }
}
add_action( 'wp_head', 'space_and_soul_twitter_card_meta', 3 );

/**
 * Add structured data (JSON-LD)
 */
function space_and_soul_structured_data() {
    if ( is_single() ) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'datePublished' => get_the_date( 'c' ),
            'dateModified' => get_the_modified_date( 'c' ),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_custom_logo() ? wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) : ''
                )
            )
        );
        
        if ( has_post_thumbnail() ) {
            $schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        }
        
        echo '<script type="application/ld+json">' . json_encode( $schema ) . '</script>' . "\n";
    } elseif ( is_home() || is_front_page() ) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo( 'name' ),
            'description' => get_bloginfo( 'description' ),
            'url' => home_url( '/' ),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url( '/?s={search_term_string}' ),
                'query-input' => 'required name=search_term_string'
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode( $schema ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_structured_data', 4 );

/**
 * Add canonical URL
 */
function space_and_soul_canonical_url() {
    if ( is_singular() ) {
        echo '<link rel="canonical" href="' . esc_url( get_permalink() ) . '">' . "\n";
    } elseif ( is_home() || is_front_page() ) {
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    } elseif ( is_category() || is_tag() || is_archive() ) {
        echo '<link rel="canonical" href="' . esc_url( get_term_link( get_queried_object() ) ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_canonical_url', 5 );

/**
 * Add robots meta tag
 */
function space_and_soul_robots_meta() {
    if ( is_home() || is_front_page() ) {
        echo '<meta name="robots" content="index, follow">' . "\n";
    } elseif ( is_single() || is_page() ) {
        if ( get_post_meta( get_the_ID(), '_space_and_soul_noindex', true ) ) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        } else {
            echo '<meta name="robots" content="index, follow">' . "\n";
        }
    } elseif ( is_category() || is_tag() || is_archive() ) {
        echo '<meta name="robots" content="index, follow">' . "\n";
    } else {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_robots_meta', 6 );

/**
 * Add hreflang for multilingual support
 */
function space_and_soul_hreflang() {
    if ( function_exists( 'pll_the_languages' ) ) {
        $languages = pll_the_languages( array( 'raw' => 1 ) );
        foreach ( $languages as $lang ) {
            echo '<link rel="alternate" hreflang="' . esc_attr( $lang['slug'] ) . '" href="' . esc_url( $lang['url'] ) . '">' . "\n";
        }
    }
}
add_action( 'wp_head', 'space_and_soul_hreflang', 7 );

/**
 * Add breadcrumb structured data
 */
function space_and_soul_breadcrumb_schema() {
    if ( is_single() || is_page() ) {
        $breadcrumbs = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => home_url( '/' )
                )
            )
        );
        
        if ( is_single() ) {
            $categories = get_the_category();
            if ( $categories ) {
                $category = $categories[0];
                $breadcrumbs['itemListElement'][] = array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $category->name,
                    'item' => get_category_link( $category->term_id )
                );
            }
        }
        
        $breadcrumbs['itemListElement'][] = array(
            '@type' => 'ListItem',
            'position' => count( $breadcrumbs['itemListElement'] ) + 1,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
        
        echo '<script type="application/ld+json">' . json_encode( $breadcrumbs ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'space_and_soul_breadcrumb_schema', 8 );

/**
 * Optimize title tag
 */
function space_and_soul_optimize_title( $title ) {
    if ( is_home() || is_front_page() ) {
        $title = get_bloginfo( 'name' );
        $description = get_bloginfo( 'description' );
        if ( $description ) {
            $title .= ' - ' . $description;
        }
    } elseif ( is_single() || is_page() ) {
        $title = get_the_title() . ' - ' . get_bloginfo( 'name' );
    } elseif ( is_category() || is_tag() ) {
        $title = single_term_title( '', false ) . ' - ' . get_bloginfo( 'name' );
    }
    
    return $title;
}
add_filter( 'wp_title', 'space_and_soul_optimize_title' );

/**
 * Add meta viewport for mobile
 */
function space_and_soul_viewport_meta() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
}
add_action( 'wp_head', 'space_and_soul_viewport_meta', 0 );

/**
 * Add language attribute
 */
function space_and_soul_language_meta() {
    echo '<meta http-equiv="Content-Language" content="' . esc_attr( get_locale() ) . '">' . "\n";
}
add_action( 'wp_head', 'space_and_soul_language_meta', 1 );
