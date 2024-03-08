<?php

if (!class_exists('AV_Enqueue')) {

    class AV_Enqueue {

        /**
         * Includes all the frontend and backend JS and CSS enqueues
         * 
         */
        function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets'));
            add_action('admin_enqueue_scripts', array($this, 'register_backend_assets'));
        }

        function register_frontend_assets() {
            $av_settings = get_option('av_settings');
            wp_enqueue_style('av-frontend', AV_CSS_DIR . '/av-frontend.css', array(), AV_VERSION);
            wp_enqueue_script('av-frontend', AV_JS_DIR . '/av-frontend.js', array('jquery'), AV_VERSION);
            $ajax_nonce = wp_create_nonce('av-ajax-nonce');

            $js_object = array('admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce);
            wp_localize_script('av-frontend', 'av_js_object', $js_object);
        }

        function register_backend_assets($hook) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_media();
            wp_enqueue_style('av-admin-css', AV_CSS_DIR . '/av-backend.css', array(), AV_VERSION);
            wp_enqueue_script('av-admin-js', AV_JS_DIR . '/av-backend.js', array('jquery', 'wp-color-picker'), AV_VERSION);
            $ajax_nonce = wp_create_nonce('av-backend-ajax-nonce');
            $messages = array('wait' => __('Please wait', AV_TD), 'restore_confirm' => __('Are you sure you want to restore default settings?', AV_TD));
            $js_object = array('admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce, 'messages' => $messages);
            wp_localize_script('av-admin-js', 'av_admin_js_object', $js_object);
        }
    }

    new AV_Enqueue();
}
