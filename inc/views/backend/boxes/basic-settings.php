<div class="av-settings-section" data-settings-ref="basic">
    <div class="av-field-wrap">
        <label><?php _e('Activate', AV_TD); ?></label>
        <div class="av-field">
            <input type="checkbox" name="av_settings[basic_settings][status]" class="av-form-field" value="1" <?php echo (!empty($av_settings['basic_settings']['status'])) ? 'checked="checked"' : ''; ?>/>
            <p class="description"><?php _e('Please check to enable article vote and dislike in frontend', AV_TD); ?></p>
        </div>
    </div>
    <div class="av-field-wrap">
        <label><?php esc_html_e('Post Types', AV_TD); ?></label>
        <div class="av-field">
            <?php
            $post_types = get_post_types(array('public' => true), 'object');
            $checked_post_types = (!empty($av_settings['basic_settings']['post_types'])) ? $av_settings['basic_settings']['post_types'] : array();
            foreach ($post_types as $post_type_name => $post_type_object) {
                ?>
                <label class="av-checkbox-label"><input type="checkbox" name="av_settings[basic_settings][post_types][]" value="<?php echo esc_attr($post_type_name); ?>" <?php echo (in_array($post_type_name, $checked_post_types)) ? 'checked="checked"' : ''; ?> class="av-form-field"/><?php echo esc_attr($post_type_object->label); ?></label>
                <?php
            }
            ?>
            <p class="description"><?php esc_html_e('Please uncheck all of these if you are wiling to generate the like dislike icon through custom function.', AV_TD); ?></p>
        </div>
    </div>
    <div class="av-field-wrap">
        <label><?php _e("Title text", AV_TD); ?></label>
        <div class="av-field">
            <input type="text" name="av_settings[basic_settings][title_text]" class="av-form-field" value="<?php echo isset($av_settings['basic_settings']['title_text']) ? esc_attr($av_settings['basic_settings']['title_text']) : _e("Was this article helpful?", AV_TD); ?>" />
        </div>
    </div>
    <div class="av-field-wrap">
        <label><?php _e('Article vote Positiion', AV_TD); ?></label>
        <div class="av-field">
            <select name="av_settings[basic_settings][like_dislike_position]" class="av-form-field">
                <option value="after" <?php selected($av_settings['basic_settings']['like_dislike_position'], 'after'); ?>><?php _e('After Post', AV_TD); ?></option>
                <option value="before" <?php selected($av_settings['basic_settings']['like_dislike_position'], 'before'); ?>><?php _e('Before Post', AV_TD); ?></option>
            </select>
        </div>
    </div>
    <div class="av-field-wrap">
        <label><?php _e('Article vote Restriction', AV_TD); ?></label>
        <div class="av-field">
            <select name="av_settings[basic_settings][like_dislike_resistriction]" class="av-form-field av-toggle-trigger" data-toggle-class="av-login-link">
                <option value="cookie" <?php selected($av_settings['basic_settings']['like_dislike_resistriction'], 'cookie'); ?>><?php _e('Cookie Restriction', AV_TD); ?></option>
                <option value="ip" <?php selected($av_settings['basic_settings']['like_dislike_resistriction'], 'ip'); ?>><?php _e('IP Restriction', AV_TD); ?></option>
                <option value="no" <?php selected($av_settings['basic_settings']['like_dislike_resistriction'], 'no'); ?>><?php _e('No Restriction', AV_TD); ?></option>
            </select>
            <p class="description"><?php _e('Please choose the restriction you want to assign to likers and dislikers', AV_TD); ?></p>
        </div>
    </div>
</div>