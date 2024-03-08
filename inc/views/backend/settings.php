<?php
$av_settings = $this->av_settings;
?>
<div class="wrap av-wrap">
    <div class="av-header"><h3><?php _e('Article Vote', 'article-vote'); ?></h3></div>
    <div class="av-clear"></div>
    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php
        $av_tabs = array(
            'basic' => array('label' => __('Basic Settings', AV_TD)),
            'info' => array('label' => __('Info', AV_TD)),
        );
        /**
         * Filters the boxes
         * @param array $av_tabs
         */
        $av_tabs = apply_filters('av_admin_tabs', $av_tabs);
        $av_tab_counter = 0;
        foreach ($av_tabs as $av_tab => $av_tab_detail) {
            $av_tab_counter++;
            ?>
            <a href="javascript:void(0);" class="nav-tab <?php echo ($av_tab_counter == 1) ? 'nav-tab-active' : ''; ?> av-tab-trigger" data-settings-ref="<?php echo $av_tab; ?>"><?php echo $av_tab_detail['label']; ?></a>
            <?php
        }
        ?>

    </h2>
    <div class="av-settings-section-wrap">
        <form class="av-settings-form">
            <?php include(AV_PATH . 'inc/views/backend/boxes/basic-settings.php'); ?>
            <?php include(AV_PATH . 'inc/views/backend/boxes/info.php'); ?>


            <?php
            /**
             * Fires when displaying the tabs section
             * @param array $av_settings
             */
            do_action('av_admin_tab_section', $av_settings);
            ?>
            <div class="av-field-wrap av-settings-action">
                <label></label>
                <div class="av-field">
                    <input type="submit" class="av-settings-save-trigger button-primary" value="<?php _e('Save settings', AV_TD); ?>"/>
                    <input type="button" class="av-settings-restore-trigger button-secondary" value="<?php _e('Restore settings', AV_TD); ?>"/>
                </div>
            </div>
        </form>

    </div>
    <div class="av-info-wrap" style="display:none;">
        <img src="<?php echo AV_IMG_DIR . '/ajax-loader.gif'; ?>" class="av-loader"/>
        <span class="av-info"><?php _e('Please wait.', AV_TD); ?></span>
        <span class="dashicons dashicons-dismiss av-close-info"></span>
    </div>
</div>