<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'space-and-soul' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'space-and-soul' ); ?></p>

                <?php get_search_form(); ?>

                <div class="error-404-widgets">
                    <div class="widget">
                        <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'space-and-soul' ); ?></h2>
                        <ul>
                            <?php
                            wp_list_categories( array(
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'show_count' => 1,
                                'title_li'   => '',
                                'number'     => 10,
                            ) );
                            ?>
                        </ul>
                    </div>

                    <div class="widget">
                        <h2 class="widget-title"><?php esc_html_e( 'Archives', 'space-and-soul' ); ?></h2>
                        <ul>
                            <?php
                            wp_get_archives( array(
                                'type'  => 'monthly',
                                'limit' => 12,
                            ) );
                            ?>
                        </ul>
                    </div>

                    <div class="widget">
                        <h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'space-and-soul' ); ?></h2>
                        <ul>
                            <?php
                            wp_get_archives( array(
                                'type'  => 'postbypost',
                                'limit' => 5,
                            ) );
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
