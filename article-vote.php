<?php

defined('ABSPATH') or die('Do not play with me');

/*
  Plugin Name: Article Vote
  Description: Article vote descirption
  Version:     1.0
  Author:      David Kiss
  Author URI:  https://www.davidkiss.xyz
  Text Domain: article-vote
*/


if (!class_exists('Posts_like_dislike')) {
    class Posts_like_dislike {
        public function __construct() {
            $this->define_constants();
            $this->includes();
        }

        /**
         * Include necessary files
         */
        public function includes() {
            require_once AV_PATH . 'inc/classes/av-library.php';
            require_once AV_PATH . 'inc/classes/av-activation.php';
            require_once AV_PATH . 'inc/classes/av-init.php';
            require_once AV_PATH . 'inc/classes/av-admin.php';
            require_once AV_PATH . 'inc/classes/av-enqueue.php';
            require_once AV_PATH . 'inc/classes/av-hook.php';
            require_once AV_PATH . 'inc/classes/av-ajax.php';
        }

        /**
         * Define constants
         */
        public function define_constants() {
            defined('AV_PATH') or define('AV_PATH', plugin_dir_path(__FILE__));
            defined('AV_IMG_DIR') or define('AV_IMG_DIR', plugin_dir_url(__FILE__) . 'images');
            defined('AV_CSS_DIR') or define('AV_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
            defined('AV_JS_DIR') or define('AV_JS_DIR', plugin_dir_url(__FILE__) . 'js');
            defined('AV_VERSION') or define('AV_VERSION', '1.0');
            defined('AV_TD') or define('AV_TD', 'article-vote');
            defined('AV_BASENAME') or define('AV_BASENAME', plugin_basename(__FILE__));
        }
    }

    $av_object = new Posts_like_dislike();
}
