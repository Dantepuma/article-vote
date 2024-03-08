<div class="av-dislike-wrap  av-common-wrap <?php echo ($already_liked_type == 'dislike') ? 'av-undo-dislike-trigger av-voted-trigger' : ''; ?>">
    <a href="<?php echo esc_attr($href); ?>" 
        class="av-dislike-trigger av-like-dislike-trigger flex <?php echo ($already_liked == 1) ? 'av-prevent' : ''; ?>" 
        title="<?php echo esc_attr($dislike_title); ?>" 
        data-post-id="<?php echo intval($post_id); ?>" 
        data-trigger-type="dislike" 
        data-restriction="<?php echo esc_attr($av_settings['basic_settings']['like_dislike_resistriction']); ?>" 
        data-already-liked="<?php echo esc_attr($already_liked); ?>">
        <img src="<?php echo AV_IMG_DIR . '/neutral.svg'; ?>" class="av-dislike"/>
        <?php
        /**
         * Load the template
         *
         * @param array $av_settings
         *
         */
        do_action('av_dislike_template', $av_settings);
        ?>
        <?php
        if($already_liked) {
            $total_count = $like_count + $dislike_count; 
            $percentage = ($dislike_count / $total_count) * 100;
            echo "<div class='ml-2'>".round($percentage , 0)."%</div>";
        } else{
            echo "<span id='dislike_percentage' class='av-like-count-wrap av-count-wrap ml-2'>NO</span>";
        }
        ?>
    </a>
</div>