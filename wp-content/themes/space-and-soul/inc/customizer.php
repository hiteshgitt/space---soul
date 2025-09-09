<?php
/**
 * Customizer additions
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer
 */
function space_and_soul_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'space_and_soul_customize_partial_blogname',
        ) );
        $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'space_and_soul_customize_partial_blogdescription',
        ) );
    }

    // Add Theme Options Panel
    $wp_customize->add_panel( 'space_and_soul_theme_options', array(
        'title'    => esc_html__( 'Theme Options', 'space-and-soul' ),
        'priority' => 130,
    ) );

    // Add Layout Section
    $wp_customize->add_section( 'space_and_soul_layout', array(
        'title'    => esc_html__( 'Layout', 'space-and-soul' ),
        'panel'    => 'space_and_soul_theme_options',
        'priority' => 10,
    ) );

    // Add Color Scheme Section
    $wp_customize->add_section( 'space_and_soul_colors', array(
        'title'    => esc_html__( 'Colors', 'space-and-soul' ),
        'panel'    => 'space_and_soul_theme_options',
        'priority' => 20,
    ) );

    // Add Typography Section
    $wp_customize->add_section( 'space_and_soul_typography', array(
        'title'    => esc_html__( 'Typography', 'space-and-soul' ),
        'panel'    => 'space_and_soul_theme_options',
        'priority' => 30,
    ) );

    // Add Performance Section
    $wp_customize->add_section( 'space_and_soul_performance', array(
        'title'    => esc_html__( 'Performance', 'space-and-soul' ),
        'panel'    => 'space_and_soul_theme_options',
        'priority' => 40,
    ) );

    // Add SEO Section
    $wp_customize->add_section( 'space_and_soul_seo', array(
        'title'    => esc_html__( 'SEO', 'space-and-soul' ),
        'panel'    => 'space_and_soul_theme_options',
        'priority' => 50,
    ) );

    // Layout Settings
    $wp_customize->add_setting( 'space_and_soul_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'space_and_soul_container_width', array(
        'label'   => esc_html__( 'Container Width (px)', 'space-and-soul' ),
        'section' => 'space_and_soul_layout',
        'type'    => 'number',
    ) );

    $wp_customize->add_setting( 'space_and_soul_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'space_and_soul_sanitize_sidebar_position',
    ) );

    $wp_customize->add_control( 'space_and_soul_sidebar_position', array(
        'label'   => esc_html__( 'Sidebar Position', 'space-and-soul' ),
        'section' => 'space_and_soul_layout',
        'type'    => 'select',
        'choices' => array(
            'left'  => esc_html__( 'Left', 'space-and-soul' ),
            'right' => esc_html__( 'Right', 'space-and-soul' ),
            'none'  => esc_html__( 'None', 'space-and-soul' ),
        ),
    ) );

    // Color Settings
    $wp_customize->add_setting( 'space_and_soul_background_color', array(
        'default'           => '#010101',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'space_and_soul_background_color', array(
        'label'   => esc_html__( 'Background Color', 'space-and-soul' ),
        'section' => 'space_and_soul_colors',
    ) ) );

    $wp_customize->add_setting( 'space_and_soul_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'space_and_soul_text_color', array(
        'label'   => esc_html__( 'Text Color', 'space-and-soul' ),
        'section' => 'space_and_soul_colors',
    ) ) );

    $wp_customize->add_setting( 'space_and_soul_accent_color', array(
        'default'           => '#e06100',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'space_and_soul_accent_color', array(
        'label'   => esc_html__( 'Accent Color', 'space-and-soul' ),
        'section' => 'space_and_soul_colors',
    ) ) );

    $wp_customize->add_setting( 'space_and_soul_button_border_color', array(
        'default'           => '#e06100',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'space_and_soul_button_border_color', array(
        'label'   => esc_html__( 'Button Border Color', 'space-and-soul' ),
        'section' => 'space_and_soul_colors',
    ) ) );

    // Typography Settings
    $wp_customize->add_setting( 'space_and_soul_primary_font', array(
        'default'           => 'Syne',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'space_and_soul_primary_font', array(
        'label'   => esc_html__( 'Primary Font (Syne)', 'space-and-soul' ),
        'section' => 'space_and_soul_typography',
        'type'    => 'text',
        'description' => esc_html__( 'Primary font for headings and main text', 'space-and-soul' ),
    ) );

    $wp_customize->add_setting( 'space_and_soul_secondary_font', array(
        'default'           => 'Times New Roman',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'space_and_soul_secondary_font', array(
        'label'   => esc_html__( 'Secondary Font (Times New Roman)', 'space-and-soul' ),
        'section' => 'space_and_soul_typography',
        'type'    => 'text',
        'description' => esc_html__( 'Secondary font for special content', 'space-and-soul' ),
    ) );

    $wp_customize->add_setting( 'space_and_soul_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'space_and_soul_font_size', array(
        'label'   => esc_html__( 'Font Size (px)', 'space-and-soul' ),
        'section' => 'space_and_soul_typography',
        'type'    => 'number',
    ) );

    // Performance Settings
    $wp_customize->add_setting( 'space_and_soul_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'space_and_soul_lazy_loading', array(
        'label'   => esc_html__( 'Enable Lazy Loading', 'space-and-soul' ),
        'section' => 'space_and_soul_performance',
        'type'    => 'checkbox',
    ) );

    $wp_customize->add_setting( 'space_and_soul_minify_html', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'space_and_soul_minify_html', array(
        'label'   => esc_html__( 'Minify HTML', 'space-and-soul' ),
        'section' => 'space_and_soul_performance',
        'type'    => 'checkbox',
    ) );

    // SEO Settings
    $wp_customize->add_setting( 'space_and_soul_meta_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'space_and_soul_meta_description', array(
        'label'   => esc_html__( 'Default Meta Description', 'space-and-soul' ),
        'section' => 'space_and_soul_seo',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'space_and_soul_google_analytics', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'space_and_soul_google_analytics', array(
        'label'   => esc_html__( 'Google Analytics ID', 'space-and-soul' ),
        'section' => 'space_and_soul_seo',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'space_and_soul_customize_register' );

/**
 * Render the site title for the selective refresh partial
 */
function space_and_soul_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial
 */
function space_and_soul_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function space_and_soul_customize_preview_js() {
    wp_enqueue_script( 'space-and-soul-customizer', SPACE_AND_SOUL_THEME_URL . '/assets/js/customizer.js', array( 'customize-preview' ), SPACE_AND_SOUL_VERSION, true );
}
add_action( 'customize_preview_init', 'space_and_soul_customize_preview_js' );

/**
 * Sanitize sidebar position
 */
function space_and_soul_sanitize_sidebar_position( $input ) {
    $valid = array( 'left', 'right', 'none' );
    return in_array( $input, $valid ) ? $input : 'right';
}

/**
 * Output customizer CSS
 */
function space_and_soul_customizer_css() {
    $background_color = get_theme_mod( 'space_and_soul_background_color', '#010101' );
    $text_color = get_theme_mod( 'space_and_soul_text_color', '#ffffff' );
    $accent_color = get_theme_mod( 'space_and_soul_accent_color', '#e06100' );
    $button_border_color = get_theme_mod( 'space_and_soul_button_border_color', '#e06100' );
    $primary_font = get_theme_mod( 'space_and_soul_primary_font', 'Syne' );
    $secondary_font = get_theme_mod( 'space_and_soul_secondary_font', 'Times New Roman' );
    $font_size = get_theme_mod( 'space_and_soul_font_size', '16' );
    $container_width = get_theme_mod( 'space_and_soul_container_width', '1200' );
    
    ?>
    <style type="text/css">
        :root {
            --bg-primary: <?php echo esc_attr( $background_color ); ?>;
            --text-primary: <?php echo esc_attr( $text_color ); ?>;
            --accent-color: <?php echo esc_attr( $accent_color ); ?>;
            --button-border: <?php echo esc_attr( $button_border_color ); ?>;
            --font-primary: '<?php echo esc_attr( $primary_font ); ?>', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            --font-secondary: '<?php echo esc_attr( $secondary_font ); ?>', Times, serif;
            --font-size: <?php echo esc_attr( $font_size ); ?>px;
            --container-width: <?php echo esc_attr( $container_width ); ?>px;
        }
        
        body {
            font-family: var(--font-primary);
            font-size: var(--font-size);
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
        
        .container {
            max-width: var(--container-width);
        }
        
        .site-header {
            background: var(--bg-primary);
        }
        
        .site-title a {
            color: var(--text-primary);
        }
        
        .main-navigation a:hover {
            color: var(--accent-color);
        }
        
        .site-footer {
            background: var(--color-pure-black);
        }
        
        .banner-button {
            color: var(--text-primary);
            border-bottom-color: var(--button-border);
        }
        
        .banner-button:hover {
            color: var(--accent-color);
            border-bottom-color: var(--accent-color);
        }
    </style>
    <?php
}
add_action( 'wp_head', 'space_and_soul_customizer_css' );

/**
 * Add Google Analytics
 */
function space_and_soul_google_analytics() {
    $ga_id = get_theme_mod( 'space_and_soul_google_analytics' );
    if ( $ga_id ) {
        ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr( $ga_id ); ?>');
        </script>
        <?php
    }
}
add_action( 'wp_head', 'space_and_soul_google_analytics' );
