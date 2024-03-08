<?php

defined('ABSPATH') or die('Do not play with me!!');

if (!class_exists('AV_Admin')) {

    class AV_Admin extends AV_Library {

        function __construct() {
            parent::__construct();
            add_action('admin_menu', array($this, 'av_admin_menu'));

            /**
             * Add settings link
             */
            add_filter('plugin_action_links_' . AV_BASENAME, array($this, 'add_setting_link'));

            /**
             * save action
             */
            add_action('wp_ajax_av_settings_save_action', array($this, 'save_settings'));

            /**
             * restore action
             */
            add_action('wp_ajax_av_settings_restore_action', array($this, 'restore_settings'));

            /**
             * Count Info Meta Box
             */
            add_action('add_meta_boxes', array($this, 'render_count_info_metabox'));

            /**
             * Save article vote meta box
             */
            add_action('save_post', array($this, 'save_av_metabox'));
        }

        function av_admin_menu() {
            add_options_page(__('Article Vote', 'article-vote'), __('Article Vote', 'article-vote'), 'manage_options', 'article-vote', array($this, 'av_settings'));
        }

        function av_settings() {
            include(AV_PATH . 'inc/views/backend/settings.php');
        }

        function save_settings() {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'av-backend-ajax-nonce') && current_user_can('manage_options')) {
                $_POST = stripslashes_deep($_POST);
                parse_str($_POST['settings_data'], $settings_data);
                $settings_data = $this->sanitize_array($settings_data);
                $av_settings = $settings_data['av_settings'];
                /**
                 * Fires before storing the settings array into database
                 *
                 * @param type array $settings_data - before sanitization
                 * @param type array $av_settings - after sanitization
                 *
                 */
                do_action('av_before_save_settings', $settings_data, $av_settings);

                /**
                 * Filters the settings stored in the database
                 * @param type array $av_settings
                 */
                update_option('av_settings', apply_filters('av_settings', $av_settings));
                die(__('Settings saved!', AV_TD));
            } else {
                die('Do not play with me!!');
            }
        }


        function restore_settings() {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'av-backend-ajax-nonce') && current_user_can('manage_options')) {
                $default_settings = $this->get_default_settings();
                update_option('av_settings', $default_settings);
                die(__('Settings restored! Redirect...', AV_TD));
            } else {
                die('Do not play with me!!');
            }
        }

        /**
         * Adds settings link
         */
        function add_setting_link($links) {
            $settings_link = array(
                '<a href="' . admin_url('options-general.php?page=article-vote') . '">' . __('Settings', AV_TD) . '</a>',
            );
            return array_merge($links, $settings_link);
        }

        function render_count_info_metabox() {
            $av_settings = $this->av_settings;
            $post_types = (!empty($av_settings['basic_settings']['post_types'])) ? $av_settings['basic_settings']['post_types'] : array();
            if (!empty($post_types)) {
                add_meta_box('av-count-info', esc_html__('Article Vote', 'article-vote'), array($this, 'render_count_info_html'), $post_types, 'normal');
            }
        }

        function render_count_info_html($post) {
            $post_id = $post->ID;
            $like_count = get_post_meta($post_id, 'av_like_count', true);
            $dislike_count = get_post_meta($post_id, 'av_dislike_count', true);
            include(AV_PATH . '/inc/views/backend/av-metabox.php');
        }

        function save_av_metabox($post_id) {
            $nonce_name = isset($_POST['av_metabox_nonce_field']) ? $_POST['av_metabox_nonce_field'] : '';
            $nonce_action = 'av_metabox_nonce';

            // Check if nonce is valid.
            if (!wp_verify_nonce($nonce_name, $nonce_action)) {
                return;
            }

            
            if (isset($_POST['av_like_count'], $_POST['av_dislike_count'])) {
                $av_like_count = sanitize_text_field($_POST['av_like_count']);
                $av_dislike_count = sanitize_text_field($_POST['av_dislike_count']);
                update_post_meta($post_id, 'av_like_count', $av_like_count);
                update_post_meta($post_id, 'av_dislike_count', $av_dislike_count);
            } else {
                return;
            }
        }
    }

    new AV_Admin();
}
