<?php
/**
 * Plugin Name: ACF Dynamic Tag for Elementor
 * Description: Adds a dynamic tag in Elementor to fetch ACF fields. Includes shortcode support for Elementor Free.
 * Version: 1.1
 * Author: Abdullah6687
 * Author URI: https://abdullah6687.com
 *
 * Instructions:
 * - For Elementor Free users: Use shortcode [acf_field field="your_field_name"]
 * - For Elementor Pro users: Use the "ACF Field" option from the dynamic tag icon in any widget.
 * - You must have ACF (Advanced Custom Fields) plugin installed and active.
 *
 * Notes:
 * - Works with text, number, and select fields.
 * - For arrays (like checkboxes), the values are joined with commas.
 * - For global fields, use: [acf_field field="field_name" post_id="option"]
 *
 * Developed by Abdullah6687 for personal use and sharing.
 */

if (!defined('ABSPATH')) exit;

// Register the dynamic tag
add_action('elementor/dynamic_tags/register_tags', function($dynamic_tags) {
    require_once __DIR__ . '/class-acf-dynamic-tag.php';
    $dynamic_tags->register_tag('ACF_Dynamic_Tag');
});

// Load only if Elementor is active
add_action('plugins_loaded', function() {
    if (!did_action('elementor/loaded')) {
        return;
    }
});

// ACF shortcode for Elementor Free users
function acf_field_shortcode($atts) {
    $atts = shortcode_atts([
        'field' => '',
        'post_id' => null
    ], $atts);

    if (!function_exists('get_field')) {
        return '[ACF not active]';
    }

    $value = get_field($atts['field'], $atts['post_id']);

    if (is_array($value)) {
        return implode(', ', $value);
    }

    return $value;
}
add_shortcode('acf_field', 'acf_field_shortcode');
