<?php
$post_id = (!empty($atts['id'])) ? intval($atts['id']) : get_the_ID();
$like_count = get_post_meta($post_id, 'av_like_count', true);
$dislike_count = get_post_meta($post_id, 'av_dislike_count', true);

$av_settings = get_option('av_settings');

if (empty($av_settings['basic_settings']['status']) && empty($shortcode)) {
    // if article vote is disabled from backend
    return;
}
$already_liked = 0;
$already_liked_type = 'na';
$href = 'javascript:void(0)';

/**
 * Cookie Restriction
 *
 */
if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE['av_' . $post_id])) {
    $already_liked = 1;
    $already_liked_type = ($_COOKIE['av_' . $post_id] != 1) ? $_COOKIE['av_' . $post_id] : 'na';
}

/**
 * IP Restriction
 */
if ($av_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
    $liked_ips = get_post_meta($post_id, 'av_ips', true);
    $liked_ips_info = get_post_meta($post_id, 'av_ips_info', true);
    $user_ip = $this->get_user_IP();
    if (empty($liked_ips)) {
        $liked_ips = array();
    }
    if (in_array($user_ip, $liked_ips)) {
        $already_liked = 1;
    }
    if ((in_array($user_ip, $liked_ips))) {
        $already_liked = 1;
        if (isset($liked_ips_info[md5($user_ip)])) {
            $already_liked_type = $liked_ips_info[md5($user_ip)];
        } else {
            $already_liked_type = 'na';
        }
    }
}


/**
 * Filters like count
 *
 * @param type int $like_count
 * @param type int $post_id
 *
 */
$like_count = apply_filters('av_like_count', $like_count, $post_id);

/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $post_id
 *
 */
$dislike_count = apply_filters('av_dislike_count', $dislike_count, $post_id);

$like_title = __('YES', AV_TD);
$dislike_title =  __('NO', AV_TD);

//$this->print_array( $av_settings );
?>
<div class="av-like-dislike-wrap flex">
    <?php
        // add like - dislike template
        echo '<div class="voteTitle">'.esc_html($av_settings['basic_settings']['title_text']).'</div>';
        include(AV_PATH . 'inc/views/frontend/like.php');
        include(AV_PATH . 'inc/views/frontend/dislike.php');
    ?>
</div>