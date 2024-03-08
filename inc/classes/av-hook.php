<?php

if (!class_exists('AV_Hooks')) {
    class AV_Hooks extends AV_Library
    {
        public function __construct()
        {
            parent::__construct();
            // add automaticaly to the content 
            add_filter('the_content', array($this, 'posts_like_dislike'), 200); 
            add_action('av_like_dislike_output', array($this, 'generate_like_dislike_html'), 10, 3);
            // generate shortcode as well (just in case)
            add_shortcode('article_vote', array($this, 'render_av_shortcode'));
        }

        public function posts_like_dislike($content)
        {
            include(AV_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function render_av_shortcode($atts)
        {
            $content = '';
            $shortcode = true;
            include(AV_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function generate_like_dislike_html($content, $shortcode, $atts)
        {
            include(AV_PATH . '/inc/views/frontend/like-dislike-html.php');
        }

        
    }

    new AV_Hooks();
}
