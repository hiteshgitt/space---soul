<?php
/**
 * Security enhancement functions
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Remove WordPress version from head
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Hide WordPress version from scripts and styles
 */
function space_and_soul_remove_version_scripts_styles( $src ) {
    if ( strpos( $src, 'ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'script_loader_src', 'space_and_soul_remove_version_scripts_styles', 15, 1 );
add_filter( 'style_loader_src', 'space_and_soul_remove_version_scripts_styles', 15, 1 );

/**
 * Disable file editing in WordPress admin
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Remove unnecessary header information
 */
function space_and_soul_remove_header_info() {
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
}
add_action( 'init', 'space_and_soul_remove_header_info' );

/**
 * Disable XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove REST API links from head
 */
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

/**
 * Disable REST API for non-logged in users
 */
function space_and_soul_disable_rest_api() {
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_disabled', 'REST API is disabled for non-logged in users.', array( 'status' => 403 ) );
    }
}
add_filter( 'rest_authentication_errors', 'space_and_soul_disable_rest_api' );

/**
 * Sanitize file uploads
 */
function space_and_soul_sanitize_file_uploads( $file ) {
    // Check file type
    $allowed_types = array( 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf', 'doc', 'docx', 'mp4', 'mov', 'avi', 'mp3', 'wav', 'zip' );
    $file_extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
    
    if ( ! in_array( $file_extension, $allowed_types ) ) {
        $file['error'] = 'File type not allowed.';
        return $file;
    }
    
    // Check file size (5MB limit)
    if ( $file['size'] > 5 * 1024 * 1024 ) {
        $file['error'] = 'File too large. Maximum size is 5MB.';
        return $file;
    }
    
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'space_and_soul_sanitize_file_uploads' );

/**
 * Add support for WebP and other modern file types
 */
function space_and_soul_add_mime_types( $mimes ) {
    $mimes['webp'] = 'image/webp';
    $mimes['svg'] = 'image/svg+xml';
    $mimes['mp4'] = 'video/mp4';
    $mimes['mov'] = 'video/quicktime';
    $mimes['avi'] = 'video/x-msvideo';
    $mimes['mp3'] = 'audio/mpeg';
    $mimes['wav'] = 'audio/wav';
    $mimes['zip'] = 'application/zip';
    return $mimes;
}
add_filter( 'upload_mimes', 'space_and_soul_add_mime_types' );

/**
 * Add security headers
 */
function space_and_soul_security_headers() {
    if ( ! is_admin() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'X-XSS-Protection: 1; mode=block' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
        header( 'Permissions-Policy: geolocation=(), microphone=(), camera=()' );
    }
}
add_action( 'send_headers', 'space_and_soul_security_headers' );

/**
 * Sanitize user input
 */
function space_and_soul_sanitize_input( $input ) {
    if ( is_array( $input ) ) {
        return array_map( 'space_and_soul_sanitize_input', $input );
    }
    
    return sanitize_text_field( $input );
}

/**
 * Escape output
 */
function space_and_soul_escape_output( $output ) {
    return esc_html( $output );
}

/**
 * Add nonce verification for forms
 */
function space_and_soul_add_nonce_field( $form_id = 'space_and_soul_form' ) {
    wp_nonce_field( $form_id, $form_id . '_nonce' );
}

/**
 * Verify nonce for forms
 */
function space_and_soul_verify_nonce( $form_id = 'space_and_soul_form' ) {
    return wp_verify_nonce( $_POST[ $form_id . '_nonce' ], $form_id );
}

/**
 * Limit login attempts
 */
function space_and_soul_limit_login_attempts() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient( 'login_attempts_' . $ip );
    
    if ( $attempts && $attempts >= 5 ) {
        wp_die( 'Too many login attempts. Please try again later.' );
    }
}
add_action( 'wp_login_failed', 'space_and_soul_limit_login_attempts' );

/**
 * Track failed login attempts
 */
function space_and_soul_track_failed_login( $username ) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient( 'login_attempts_' . $ip );
    
    if ( $attempts ) {
        set_transient( 'login_attempts_' . $ip, $attempts + 1, 15 * MINUTE_IN_SECONDS );
    } else {
        set_transient( 'login_attempts_' . $ip, 1, 15 * MINUTE_IN_SECONDS );
    }
}
add_action( 'wp_login_failed', 'space_and_soul_track_failed_login' );

/**
 * Hide login errors
 */
function space_and_soul_hide_login_errors() {
    return 'Invalid username or password.';
}
add_filter( 'login_errors', 'space_and_soul_hide_login_errors' );

/**
 * Change login URL
 */
function space_and_soul_change_login_url( $login_url, $redirect ) {
    return home_url( '/wp-login.php' );
}
add_filter( 'login_url', 'space_and_soul_change_login_url', 10, 2 );

/**
 * Disable directory browsing
 */
function space_and_soul_disable_directory_browsing() {
    if ( ! is_admin() ) {
        $htaccess_file = ABSPATH . '.htaccess';
        $htaccess_content = "Options -Indexes\n";
        
        if ( ! file_exists( $htaccess_file ) ) {
            file_put_contents( $htaccess_file, $htaccess_content );
        } else {
            $current_content = file_get_contents( $htaccess_file );
            if ( strpos( $current_content, 'Options -Indexes' ) === false ) {
                file_put_contents( $htaccess_file, $htaccess_content . $current_content );
            }
        }
    }
}
add_action( 'init', 'space_and_soul_disable_directory_browsing' );

/**
 * Add CAPTCHA to login form
 */
function space_and_soul_add_login_captcha() {
    ?>
    <p>
        <label for="captcha"><?php esc_html_e( 'Security Question:', 'space-and-soul' ); ?></label>
        <input type="text" name="captcha" id="captcha" class="input" value="" size="20" required />
        <span class="description"><?php esc_html_e( 'What is 2 + 2?', 'space-and-soul' ); ?></span>
    </p>
    <?php
}
add_action( 'login_form', 'space_and_soul_add_login_captcha' );

/**
 * Verify CAPTCHA on login
 */
function space_and_soul_verify_login_captcha( $user, $username, $password ) {
    if ( isset( $_POST['captcha'] ) && $_POST['captcha'] !== '4' ) {
        return new WP_Error( 'captcha_error', 'Invalid security answer.' );
    }
    return $user;
}
add_filter( 'authenticate', 'space_and_soul_verify_login_captcha', 30, 3 );

/**
 * Log security events
 */
function space_and_soul_log_security_event( $event, $details = '' ) {
    $log_entry = array(
        'timestamp' => current_time( 'mysql' ),
        'event'     => $event,
        'details'   => $details,
        'ip'        => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    );
    
    $log_file = WP_CONTENT_DIR . '/security.log';
    file_put_contents( $log_file, json_encode( $log_entry ) . "\n", FILE_APPEND | LOCK_EX );
}
