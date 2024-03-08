<?php

defined('ABSPATH') or die('Do not play with me!!');
$av_settings = $this->av_settings;
if (empty($shortcode)) {
    global $post;
    if (empty($post)) {
        return $content;
    }
    $checked_post_types = (!empty($av_settings['basic_settings']['post_types'])) ? $av_settings['basic_settings']['post_types'] : array();
    if (!in_array($post->post_type, $checked_post_types)) {
        return $content;
    }
}
/**
 * Don't implement on admin section
 */
if (is_admin() && !wp_doing_ajax()) {
    return $content;
}
ob_start();

/**
 * Fires while generating the like dislike html
 * @param type string $content
 */
$shortcode = (!empty($shortcode)) ? $shortcode : false;
$atts = (!empty($atts))?$atts:[];
do_action('av_like_dislike_output', $content, $shortcode, $atts);

$like_dislike_html = ob_get_contents();
ob_end_clean();

if ($av_settings['basic_settings']['like_dislike_position'] == 'after') {
    /**
     * setup on the post before or after
     *
     * @param string $like_dislike_html
     * @param array $av_settings
     *
     */
    $content .= apply_filters('av_like_dislike_html', $like_dislike_html, $av_settings);
} else {
    $content = apply_filters('av_like_dislike_html', $like_dislike_html, $av_settings) . $content;
}
