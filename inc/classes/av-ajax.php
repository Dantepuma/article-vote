<?php

if (!class_exists('AV_Ajax')) {

    class AV_Ajax extends AV_Library {

        function __construct() {
            add_action('wp_ajax_av_post_ajax_action', array($this, 'like_dislike_action'));
        }

        function like_dislike_action() {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'av-ajax-nonce')) {
                $post_id = sanitize_text_field($_POST['post_id']);
                /**
                 * Action av_before_ajax_process
                 *
                 * @param type int $post_id
                 *
                 */
                do_action('av_before_ajax_process', $post_id);
                $av_settings = get_option('av_settings');

                /**
                 * Cookie Restriction Validation
                 *
                 */
                if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE['av_' . $post_id])) {
                    $response_array = array('success' => true, 'message' => 'Invalid action');
                    echo json_encode($response_array);
                    die();
                }

                /**
                 * IP Restriction Validation
                 */
                if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
                    $liked_ips = get_post_meta($post_id, 'av_ips', true);
                    $user_ip = $this->get_user_IP();
                    if (empty($liked_ips)) {
                        $liked_ips = array();
                    }
                    if (in_array($user_ip, $liked_ips)) {
                        $response_array = array('success' => true, 'message' => 'Invalid action');
                        echo json_encode($response_array);
                        die();
                    }
                }

                
                $type = sanitize_text_field($_POST['type']);

                if ($type == 'like' ) {
                    $like_count = get_post_meta($post_id, 'av_like_count', true);
                    if (empty($like_count)) {
                        $like_count = 0;
                    }
                    $like_count = $like_count + 1;
                    $check = update_post_meta($post_id, 'av_like_count', $like_count);

                    $dislike_count = get_post_meta($post_id, 'av_dislike_count', true);
                    if (empty($dislike_count)) {
                        $dislike_count = 0;
                    }
                    $total_count = $like_count + $dislike_count; 

                    if ($check) {

                        $response_array = array('success' => true, 'like_count' => $like_count, 'dislike_count' => $dislike_count, 'total_count' => $total_count );
                    } else {
                        $response_array = array('success' => false, 'like_count' => $like_count,'dislike_count' => $dislike_count, 'total_count' => $total_count);
                    }
                } else {
                    $dislike_count = get_post_meta($post_id, 'av_dislike_count', true);
                    if (empty($dislike_count)) {
                        $dislike_count = 0;
                    }
                    $dislike_count = $dislike_count + 1;
                    
                    $like_count = get_post_meta($post_id, 'av_like_count', true);
                    if (empty($like_count)) {
                        $like_count = 0;
                    }

                    $total_count = $like_count + $dislike_count; 

                    $check = update_post_meta($post_id, 'av_dislike_count', $dislike_count);
                    if ($check) {
                        $response_array = array('success' => true, 'like_count' => $like_count, 'dislike_count' => $dislike_count, 'total_count' => $total_count );
                    } else {
                        $response_array = array('success' => false, 'like_count' => $like_count,'dislike_count' => $dislike_count, 'total_count' => $total_count);
                    }
                }
                if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'cookie') {
                    setcookie('av_' . $post_id, $type, time() + 365 * 24 * 60 * 60, '/');
                }
                /**
                 * check the ip of the user
                 *
                 */
                if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
                    $liked_ips = get_post_meta($post_id, 'av_ips', true);
                    $liked_ips = (empty($liked_ips)) ? array() : $liked_ips;

                    $liked_ips_info = get_comment_meta($post_id, 'av_ips_info', true);
                    $liked_ips_info = (empty($liked_ips_info)) ? array() : $liked_ips_info;
                    if (!in_array($user_ip, $liked_ips)) {
                        $liked_ips[] = $user_ip;
                        $liked_ips_info[md5($user_ip)] = $type;
                    }
                    update_post_meta($post_id, 'av_ips', $liked_ips);
                    update_post_meta($post_id, 'av_ips_info', $liked_ips_info);
                }

                /**
                 * Action av_after_ajax_process
                 *
                 * @param type int $post_id
                 *
                 */
                do_action('av_after_ajax_process', $post_id);
                echo json_encode($response_array);

                //$this->print_array( $response_array );
                die();
            } else {
                die('Do not play with me!');
            }
        }

    }

    new AV_Ajax();
}
