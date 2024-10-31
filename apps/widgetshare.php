<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevSocial\Apps\Settings as Settings;
use \themeDevSocial\Apps\Sharing as Sharing;

class Widgetshare extends \WP_Widget {
    private $login, $login_style;
	public function __construct() {
		add_action( 'widgets_init', [ $this, 'next_share_register_widgets'] );
		$this->login = new Sharing(false);
		$getProvider = get_option( Settings::$sharing_provider_key );
		
		$this->login_style = Settings::$share_style;
		
		$this->login->allow_pro = isset($getProvider['provider']) ? array_keys($getProvider['provider']) : [];
		$this->login->but_content = isset($getProvider['provider']) ? $getProvider['provider'] : [];
		
		$getDisplay = get_option( Settings::$sharing_display_key );
		$this->login->btn_style = isset($getDisplay['display']['button']) ? $getDisplay['display']['button'] : 'button6';
		
		//$this->login->content_position = 'next-content-left';
		
		parent::__construct(
			'next-social-share', 
			__('Next Social Share', 'themedev-social-services'), 
			array( 'description' => __( 'Next Social Share for 20+ free Social Media.', 'themedev-social-services' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		
		extract( $args );
		
		$title 		= isset($instance['title']) ? $instance['title'] : '';
		$style 		= isset($instance['style']) ? $instance['style'] : '';
		$providers 	= isset($instance['providers']) ? $instance['providers'] : [];
		$custom_class 	= isset($instance['custom_class']) ? $instance['custom_class'] : '';
		$box_only 		= isset($instance['box_only']) ? $instance['box_only'] : false;
		
		$this->login->content_position = 'next-widget_position'; 
		
		if(!empty($style)){
			$this->login->btn_style = $style;
		}
		if(!empty($custom_class)){
			$this->login->class_name = $custom_class;
		}
		if( is_array($providers) && isset($providers[0]) && strlen($providers[0]) > 1){
			$this->login->allow_pro = $providers;
		}
		
		if( !$box_only ){
			echo $before_widget . $before_title . $title . $after_title;
		}

		echo $this->login->next_sharing_shortcode_action();

		if( !$box_only ){
			echo $after_widget;
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['providers'] 	= $new_instance['providers'] ;
		$instance['style'] 		= $new_instance['style'] ;
		$instance['title'] 		= $new_instance['title'] ;
		$instance['box_only'] 	= $new_instance['box_only'] ;
		$instance['custom_class'] 	= $new_instance['custom_class'] ;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Share with' , 'themedev-social-services' )  , 'style' => '' , 'box_only' => false, 'providers' => '', 'custom_class' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$select_provider = is_array($instance['providers']) && sizeof($instance['providers']) > 0 ? $instance['providers'] : [];
		//print_r($instance['style']);
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/public/sharing/widget-html.php');
	}
	function next_share_register_widgets() {
		register_widget( 'themeDevSocial\Apps\Widgetshare' );
	}
}





