<div class="av-settings-section" data-settings-ref="info" style="display:none">
    <h3><?php esc_html_e('Activate', AV_TD); ?>
    </h3>
    <p><?php esc_html_e('This can be used to enable or disable Article vote plugin on the frontend.', AV_TD); ?>
    </p>

    <div class="av-separator"></div>
    <h3><?php esc_html_e('Post Types', AV_TD); ?>
    </h3>
    <p><?php esc_html_e('You can choose the post type for which you want to enable the buttons.', AV_TD); ?>
    </p>

    <div class="av-separator"></div>
    <h3><?php esc_html_e('Title text', AV_TD); ?>
    </h3>
    <p><?php esc_html_e('You can modify the `Was this article helpful?` text.', AV_TD); ?>
    </p>

    <div class="av-separator"></div>
    <h3><?php esc_html_e('Article Vote Position', AV_TD); ?>
    </h3>
    <p><?php esc_html_e('This can be used to control whether Artcile vote should be shown.', AV_TD); ?>
    </p>

    <div class="av-separator"></div>

    <h3><?php esc_html_e('Article Vote Restriction', AV_TD); ?>
    </h3>
    <p><?php esc_html_e('This can be used to prevent liking or disliking same posts from same liker or disliker through Cookie or IP or no restriction.', AV_TD); ?>
    </p>

    <div class="av-separator"></div>

    <h3><?php esc_html_e('Shortcode', 'article-vote'); ?>
    </h3>
    <p><input type="text" onfocus="this.select();" value="[article_vote id=post_id]" /></p>

    <h3><?php esc_html_e('Custom Function', 'article-vote'); ?>
    </h3>
    <p>
    <pre>&lt;?php echo do_shortcode('[article_vote id=post_id]');?&gt;</pre>
    <span class="description">
        <?php esc_html_e('Please replace post_id with the id of the post for which you want to get the like and dislike.', 'article-vote'); ?></span>
    </p>

   
</div>