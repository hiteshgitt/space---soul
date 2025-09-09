<?php
/**
 * The template for displaying the footer
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-columns">
                    <!-- Column 1: Logo -->
                    <div class="footer-column footer-logo">
                        <h3 class="footer-logo-text">klmnko.</h3>
                    </div>
                    
                    <!-- Column 2: Address -->
                    <div class="footer-column footer-address">
                        <h4 class="footer-heading">Address</h4>
                        <div class="footer-address-content">
                            <p>Based in 54295, Trier</p>
                            <p>Germany</p>
                        </div>
                    </div>
                    
                    <!-- Column 3: Phone & Email -->
                    <div class="footer-column footer-contact">
                        <h4 class="footer-heading">Contact Info</h4>
                        <div class="footer-contact-content">
                            <p>+49 123 456 7890</p>
                            <p>info@klmnko.com</p>
                        </div>
                    </div>
                    
                    <!-- Column 4: Contact Button -->
                    <div class="footer-column footer-cta">
                        <h4 class="footer-heading">Get In Touch</h4>
                        <div class="footer-cta-content">
                            <a href="#" class="footer-contact-btn">Contact Us</a>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p class="footer-copyright">
                        <?php
                        printf(
                            esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'space-and-soul' ),
                            date( 'Y' ),
                            get_bloginfo( 'name' )
                        );
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
