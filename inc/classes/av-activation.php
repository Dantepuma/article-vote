<?php

defined( 'ABSPATH' ) or die( 'Do not play with me!!' );
if ( !class_exists( 'AV_Activation' ) ) {

	class AV_Activation extends AV_Library {

		/**
		 * Register activation
		 */
		function __construct() {
			register_activation_hook( AV_PATH . 'article-vote.php', array( $this, 'activation_tasks' ) );
		}
		
		/**
		 * Save settings data on the DB
		 */
		function activation_tasks() {
			$default_settings = $this->get_default_settings();
			if(!get_option('av_settings')){
				update_option('av_settings',$default_settings);
			}
		}


	}

	new AV_Activation();
}