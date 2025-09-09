<?php
/**
 * The template for displaying archive pages
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="page-header">
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="posts-container">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php
                            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                            ?>
                            
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </span>
                                <span class="byline">
                                    <?php esc_html_e( 'by', 'space-and-soul' ); ?>
                                    <span class="author vcard">
                                        <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                            <?php echo esc_html( get_the_author() ); ?>
                                        </a>
                                    </span>
                                </span>
                            </div>
                        </header>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'space-and-soul-thumbnail' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="entry-footer">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
                                <?php esc_html_e( 'Read More', 'space-and-soul' ); ?>
                            </a>
                        </footer>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination( array(
                'prev_text' => esc_html__( 'Previous', 'space-and-soul' ),
                'next_text' => esc_html__( 'Next', 'space-and-soul' ),
            ) );
            ?>

        <?php else : ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( 'Nothing here', 'space-and-soul' ); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'space-and-soul' ); ?></p>
                    <?php get_search_form(); ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
