<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
            <!-- Hero Banner Section for Blog -->
            <section class="hero-banner">
                <div class="banner-background">
                    <img src="<?php echo esc_url( 'http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/cropped-image-young-lady-designer-play-games-by-phone-scaled.webp' ); ?>" alt="<?php esc_attr_e( 'Design Innovation', 'space-and-soul' ); ?>" class="banner-image">
                </div>
                <div class="banner-overlay"></div>
                
                <!-- Interactive Blocks Grid -->
                <div class="interactive-blocks" id="blocksGrid"></div>
                
                <div class="container">
                    <div class="banner-content">
                        <h1 class="banner-title"><?php esc_html_e( 'The Wellknowns ', 'space-and-soul' ); ?><span class="stroke-text"><?php esc_html_e( 'Design First', 'space-and-soul' ); ?></span></h1>
                        <p class="banner-subtitle"><?php esc_html_e( 'Join us for innovation', 'space-and-soul' ); ?></p>
                        <a href="#contact" class="banner-button"><?php esc_html_e( 'Get Started', 'space-and-soul' ); ?></a>
                    </div>
                </div>
            </section>

    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div class="posts-container">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php
                            if ( is_singular() ) :
                                the_title( '<h1 class="entry-title">', '</h1>' );
                            else :
                                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                            endif;
                            ?>
                            
                            <?php if ( 'post' === get_post_type() ) : ?>
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
                            <?php endif; ?>
                        </header>

                        <div class="entry-content">
                            <?php
                            if ( is_singular() ) {
                                the_content();
                                
                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'space-and-soul' ),
                                    'after'  => '</div>',
                                ) );
                            } else {
                                the_excerpt();
                            }
                            ?>
                        </div>

                        <?php if ( ! is_singular() ) : ?>
                            <footer class="entry-footer">
                                <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
                                    <?php esc_html_e( 'Read More', 'space-and-soul' ); ?>
                                </a>
                            </footer>
                        <?php endif; ?>
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
                    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                        <p><?php
                            printf(
                                wp_kses(
                                    __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'space-and-soul' ),
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                        ),
                                    )
                                ),
                                esc_url( admin_url( 'post-new.php' ) )
                            );
                        ?></p>
                    <?php else : ?>
                        <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'space-and-soul' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
