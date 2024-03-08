<?php
defined('ABSPATH') or die('Do not play with me!!');
wp_nonce_field('av_metabox_nonce', 'av_metabox_nonce_field');
?>
<div class="av-field-wrap">
    <label><?php esc_html_e('Like Count', 'article-vote'); ?></label>
    <div class="av-field">
        <input type="text" name="av_like_count" value="<?php echo esc_attr($like_count); ?>"/>
    </div>
</div>
<div class="av-field-wrap">
    <label><?php esc_html_e('Dislike Count', 'article-vote'); ?></label>
    <div class="av-field">
        <input type="text" name="av_dislike_count" value="<?php echo esc_attr($dislike_count); ?>"/>
    </div>
</div>