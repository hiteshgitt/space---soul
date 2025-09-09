<?php
/**
 * Custom template tags for this theme
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Fallback menu for primary navigation
 */
function space_and_soul_fallback_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'space-and-soul' ) . '</a></li>';
    
    // Add pages to menu
    $pages = get_pages( array( 'sort_column' => 'menu_order' ) );
    foreach ( $pages as $page ) {
        echo '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( $page->post_title ) . '</a></li>';
    }
    
    echo '</ul>';
}

/**
 * Display post meta information
 */
function space_and_soul_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Posted on %s', 'post date', 'space-and-soul' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    $byline = sprintf(
        esc_html_x( 'by %s', 'post author', 'space-and-soul' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}

/**
 * Display post categories
 */
function space_and_soul_entry_categories() {
    if ( 'post' === get_post_type() ) {
        $categories_list = get_the_category_list( esc_html__( ', ', 'space-and-soul' ) );
        if ( $categories_list ) {
            printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'space-and-soul' ) . '</span>', $categories_list );
        }
    }
}

/**
 * Display post tags
 */
function space_and_soul_entry_tags() {
    if ( 'post' === get_post_type() ) {
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'space-and-soul' ) );
        if ( $tags_list ) {
            printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'space-and-soul' ) . '</span>', $tags_list );
        }
    }
}

/**
 * Display post thumbnail with lazy loading
 */
function space_and_soul_post_thumbnail( $size = 'post-thumbnail' ) {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
        ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( $size ); ?>
        </div>
        <?php
    else :
        ?>
        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
        </a>
        <?php
    endif;
}

/**
 * Custom search form
 */
function space_and_soul_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div>
        <label class="screen-reader-text" for="s">' . __( 'Search for:', 'space-and-soul' ) . '</label>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search...', 'space-and-soul' ) . '" />
        <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search', 'space-and-soul' ) . '" />
    </div>
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'space_and_soul_search_form' );

/**
 * Get the first category of a post
 */
function space_and_soul_get_first_category() {
    $categories = get_the_category();
    if ( ! empty( $categories ) ) {
        return $categories[0]->name;
    }
    return '';
}

/**
 * Get reading time for a post
 */
function space_and_soul_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // Average reading speed: 200 words per minute
    
    return sprintf( _n( '%d minute read', '%d minutes read', $reading_time, 'space-and-soul' ), $reading_time );
}
