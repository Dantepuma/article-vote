<?php

if (!class_exists('AV_Library')) {

    class AV_Library {

        var $av_settings;

        function __construct() {
            $this->av_settings = get_option('av_settings');
        }

        // function print_array($array) {
        //     echo "<pre>";
        //     print_r($array);
        //     echo "</pre>";
        // }

        /**
         * Returns default settings array
         * @return array
         */
        function get_default_settings() {
            $default_settings = array();
            $default_settings['basic_settings']['status'] = 0;
            $default_settings['basic_settings']['like_dislike_position'] = 'after';
            $default_settings['basic_settings']['title_text'] = 'Was this article helpful?';
            $default_settings['basic_settings']['like_dislike_resistriction'] = 'cookie';
            /**
             * Set default settings
             *
             * @param type array $default_settings
             *
             */
            return apply_filters('av_default_settings', $default_settings);
        }

        /**
         * Get the visitor IP
         *
         * @return string $ip
         *
         */
        function get_user_IP() {
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);

            // If ip in wrong format set up 'localhost' 
            if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
                $ip = '127.0.0.1';
            }
            return $ip;
        }

        /**
         * Sanitizes Multi Dimensional Array
         * @param array $array
         * @param array $sanitize_rule
         * @return array
         */
        function sanitize_array($array = array(), $sanitize_rule = array()) {
            if (!is_array($array) || count($array) == 0) {
                return array();
            }

            foreach ($array as $k => $v) {
                if (!is_array($v)) {

                    $default_sanitize_rule = (is_numeric($k)) ? 'html' : 'text';
                    $sanitize_type = isset($sanitize_rule[$k]) ? $sanitize_rule[$k] : $default_sanitize_rule;
                    $array[$k] = $this->sanitize_value($v, $sanitize_type);
                }
                if (is_array($v)) {
                    $array[$k] = $this->sanitize_array($v, $sanitize_rule);
                }
            }

            return $array;
        }

        /**
         * Sanitizes Value
         *
         * @param type $value
         * @param type $sanitize_type
         * @return string
         *
         */
        function sanitize_value($value = '', $sanitize_type = 'text') {
            switch ($sanitize_type) {
                case 'html':
                    return $this->sanitize_html($value);
                    break;
                default:
                    return sanitize_text_field($value);
                    break;
            }
        }

        /**
         * Sanitizes the content by bypassing allowed html
         *
         * @param string $text
         * @return string
         *
         */
        function sanitize_html($text) {
            $allowed_html = wp_kses_allowed_html('post');
            return wp_kses($text, $allowed_html);
        }


        /**
         * Get current page URL
         */
        function get_current_page_url() {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $url .= $_SERVER['REQUEST_URI'];

            return $url;
        }
    }
}
