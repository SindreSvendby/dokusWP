<?php
/**
 * Lets start with a General CSS Inclusion
 * We will use admin_head hook to enqueue our CSS file
 * This will print the CSS to all the admin pages
 */

/**
 * First the enqueue function
 */
function itg_admin_css_all_page() {
    /**
     * Register the style handle
     */
    wp_register_style($handle = 'itg-admin-css-all', $src = plugins_url('/pages/templates/dokus.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');

    /**
     * Now enqueue it
     */
    wp_enqueue_style('itg-admin-css-all');
}

/**
 * Finally hook the itg_admin_css_all_page to admin_print_styles
 * As it is done during the init of the admin page, so the enqueue gets executed.
 * This can also be attached to the admin_init, or admin_menu hook
 */
add_action('admin_print_styles', 'itg_admin_css_all_page');