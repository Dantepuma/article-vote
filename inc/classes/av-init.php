<?php

if(!class_exists('AV_Init')){
	class AV_Init{
		function __construct(){
			add_action('init',array($this,'av_init'));
		}
		
		function av_init(){
			load_plugin_textdomain( 'article-vote', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
			/**
			 * Fires the initial load
			 */
			do_action('av_init');
		}
	}
	
	new AV_Init();
}