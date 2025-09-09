/**
 * Customizer JavaScript
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Site title and description
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header text color
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': to
                });
            }
        });
    });

    // Primary color
    wp.customize('space_and_soul_primary_color', function(value) {
        value.bind(function(to) {
            $(':root').css('--primary-color', to);
            $('.main-navigation a:hover').css('color', to);
        });
    });

    // Secondary color
    wp.customize('space_and_soul_secondary_color', function(value) {
        value.bind(function(to) {
            $(':root').css('--secondary-color', to);
            $('.site-title a').css('color', to);
            $('.site-footer').css('background-color', to);
        });
    });

    // Font family
    wp.customize('space_and_soul_font_family', function(value) {
        value.bind(function(to) {
            $(':root').css('--font-family', to);
            $('body').css('font-family', to);
        });
    });

    // Font size
    wp.customize('space_and_soul_font_size', function(value) {
        value.bind(function(to) {
            $(':root').css('--font-size', to + 'px');
            $('body').css('font-size', to + 'px');
        });
    });

    // Container width
    wp.customize('space_and_soul_container_width', function(value) {
        value.bind(function(to) {
            $(':root').css('--container-width', to + 'px');
            $('.container').css('max-width', to + 'px');
        });
    });

    // Sidebar position
    wp.customize('space_and_soul_sidebar_position', function(value) {
        value.bind(function(to) {
            $('body').removeClass('sidebar-left sidebar-right no-sidebar');
            $('body').addClass('sidebar-' + to);
        });
    });

})(jQuery);
