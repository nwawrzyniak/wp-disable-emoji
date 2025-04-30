<?php
/**
 * Plugin Name: WP Disable Emoji
 * Plugin URI: https://nwawsoft.com/wordpress/wp-disable-emoji/
 * Description: A minimal WordPress plugin that prevents WordPress from including the wp-emoji-release.min.js script which loads emoji from s.w.org without consent.
 * Version: 1.0.0
 * Author: nwawrzyniak
 * Author URI: https://nwawsoft.com
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disable the emoji functionality in WordPress
 */
function disable_emoji() {
    // Remove the emoji script from wp_head
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    
    // Remove the emoji styles
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove emoji from TinyMCE
    add_filter('tiny_mce_plugins', 'disable_emoji_tinymce');
    
    // Remove DNS prefetch for emoji
    remove_action('wp_head', 'wp_resource_hints', 2, 1);
    
    // Remove the emoji from the RSS feed
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    
    // Remove emoji from emails
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'disable_emoji');

/**
 * Filter function to remove the emoji plugin from TinyMCE
 * 
 * @param array $plugins TinyMCE plugins
 * @return array Filtered TinyMCE plugins
 */
function disable_emoji_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return $plugins;
}
