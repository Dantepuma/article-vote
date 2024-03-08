<div class="av-like-wrap  av-common-wrap <?php echo ($already_liked_type == 'like') ? 'av-undo-like-trigger av-voted-trigger' : ''; ?>">
    <a href="<?php echo esc_attr($href); ?>" 
        class="av-like-trigger av-like-dislike-trigger flex <?php echo ($already_liked == 1) ? 'av-prevent' : ''; ?>" 
        title="<?php echo esc_attr($like_title); ?>" 
        data-post-id="<?php echo intval($post_id); ?>" 
        data-trigger-type="like" 
        data-restriction="<?php echo esc_attr($av_settings['basic_settings']['like_dislike_resistriction']); ?>" 
        data-already-liked="<?php echo esc_attr($already_liked); ?>">
        <?php
        $template = $av_settings['design_settings']['template'];
       
        ?>
        <img src="<?php echo AV_IMG_DIR . '/smile.svg'; ?>" class="av-smile"/>
        <?php
        /**
         * Fires when template is being loaded
         *
         * @param array $av_settings
         *
         */
        do_action('av_like_template', $av_settings);
        ?>
        <!-- <div><?php echo $like_count; echo $already_liked; echo $total_count; ?></div> -->
        <?php
        if($already_liked) {
            $total_count = $like_count + $dislike_count; 
            $percentage = ($like_count / $total_count) * 100;
            echo "<div class='ml-2'>".round($percentage , 0)."%</div>";
        } else{
            echo "<span id='like_percentage' class='av-like-count-wrap av-count-wrap ml-2'>".$like_title."</span>";

        }
        ?>
       


    </a>
</div>