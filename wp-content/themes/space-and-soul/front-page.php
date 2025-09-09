<?php
/**
 * The template for displaying the front page
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Banner Section -->
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

    <!-- Second Section with Parallax Images and Animated Text -->
    <section class="about-section">
        <div class="about-container">
            <!-- Left Side - Parallax Images -->
            <div class="about-images">
                <div class="image-wrapper">
                    <div class="main-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/abstract-portrait-with-light-effects-scaled.webp" alt="Abstract Portrait" class="parallax-image">
                    </div>
                    <div class="texture-overlay">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/mask_template03.svg" alt="Texture Mask" class="texture-image">
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Animated Text -->
            <div class="about-content">
                <div class="content-wrapper">
                    <h2 class="about-title">
                        <span class="text-fill" data-text="Lorem">Lorem</span>
                        <span class="text-fill" data-text="Ipsum">Ipsum</span>
                    </h2>
                    <h2 class="about-description">
                        <div class="scroll-text" data-text="It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</div>
                    </h2>
                    <div class="about-actions">
                        <button class="scramble-button" data-text="Learn More">Learn More</button>
                        <button class="scramble-button" data-text="Get Started">Get Started</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Third Section - Services with Sticky Images -->
    <section class="services-section">
        <div class="services-container">
            <!-- Left Side - Services List -->
            <div class="services-content">
                <div class="services-wrapper">
                    <h2 class="services-title">
                        <span class="text-fill" data-text="Our">Our</span>
                        <span class="text-fill" data-text="Services">Services</span>
                    </h2>
                    
                    <div class="services-list">
                        <div class="service-item" data-image="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-webdesign.webp">
                            <h3 class="service-title">Web Design</h3>
                            <p class="service-description">Creating stunning, responsive websites that captivate your audience and drive engagement. We focus on user experience and modern design principles.</p>
                            <div class="service-image-mobile">
                                <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-webdesign.webp" alt="Web Design" class="service-image-mobile-img">
                            </div>
                        </div>
                        
                        <div class="service-item" data-image="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-branding.webp">
                            <h3 class="service-title">Branding</h3>
                            <p class="service-description">Building strong brand identities that resonate with your target market. From logo design to complete brand guidelines and strategy.</p>
                            <div class="service-image-mobile">
                                <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-branding.webp" alt="Branding" class="service-image-mobile-img">
                            </div>
                        </div>
                        
                        <div class="service-item" data-image="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-advertising.webp">
                            <h3 class="service-title">Advertising</h3>
                            <p class="service-description">Strategic advertising campaigns that deliver results. We create compelling ads across all platforms to maximize your reach and ROI.</p>
                            <div class="service-image-mobile">
                                <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-advertising.webp" alt="Advertising" class="service-image-mobile-img">
                            </div>
                        </div>
                        
                        <div class="service-item" data-image="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-visibility.webp">
                            <h3 class="service-title">Visibility</h3>
                            <p class="service-description">Enhancing your online presence through SEO, social media, and digital marketing strategies that put your business in front of the right audience.</p>
                            <div class="service-image-mobile">
                                <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-visibility.webp" alt="Visibility" class="service-image-mobile-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Sticky Image Container -->
            <div class="services-images-wrapper">
                <div class="services-images">
                    <div class="image-container">
                        <div class="image-wrapper">
                            <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-webdesign.webp" alt="Web Design" class="service-image active">
                            <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-branding.webp" alt="Branding" class="service-image">
                            <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-advertising.webp" alt="Advertising" class="service-image">
                            <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/services-visibility.webp" alt="Visibility" class="service-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fourth Section - Projects Cards -->
    <section class="projects-section">
        <div class="projects-sticky-wrapper">
            <div class="projects-header">
                <h2 class="projects-title">Our Projects</h2>
                <p class="projects-description">Discover our latest creative work and innovative solutions that bring ideas to life.</p>
            </div>
            <div class="projects-container">
                <div class="projects-grid">
                <div class="project-card" data-delay="0">
                    <div class="project-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/projekte-bg-rapid.webp" alt="Rapid Project">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Rapid</h3>
                        <div class="project-tab">Web Design</div>
                    </div>
                </div>
                
                <div class="project-card" data-delay="200">
                    <div class="project-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/projekte-bg-landgraf.webp" alt="Landgraf Project">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Landgraf</h3>
                        <div class="project-tab">Branding</div>
                    </div>
                </div>
                
                <div class="project-card" data-delay="400">
                    <div class="project-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/projekte-bg-ev-rent.webp" alt="EV Rent Project">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">EV Rent</h3>
                        <div class="project-tab">Digital Marketing</div>
                    </div>
                </div>
                
                <div class="project-card" data-delay="600">
                    <div class="project-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/projekte-bg-erdlei.webp" alt="Erdlei Project">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Erdlei</h3>
                        <div class="project-tab">E-commerce</div>
                    </div>
                </div>
                
                <div class="project-card" data-delay="800">
                    <div class="project-image">
                        <img src="http://localhost/spaceandsouldesign2/wp-content/uploads/2025/09/projekte-bg-ruffbau.webp" alt="Ruffbau Project">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Ruffbau</h3>
                        <div class="project-tab">Construction</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <!-- <div class="container">
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
    </div> -->
</main>

<?php
get_footer();
