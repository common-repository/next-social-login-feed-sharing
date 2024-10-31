<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevSocial\Apps\Settings as Settings;

class Login extends Settings{
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
     */
	const POST_TYPE = 'themedev-social';
	
	// class name
	public $class_name = '';
	// button content 
	public $but_content = '';
	
	// button style
	public $btn_style = '';
	
	// get provider allow
	public $allow_pro = [];
	
	// general setting
	private $getGeneral = [];
	
	// get global_key
	private $getGlobal = [];
	
	// get provider
	private $getProvider = [];
	
	// get display
	private $getDisplay = [];
	
	
	public function __construct($load = true){
		
		$this->getGeneral = get_option( parent::$general_key );
			
		$this->getGlobal = get_option( parent::$global_key );
		
		$this->getProvider = get_option( parent::$provider_key );
		
		$this->getDisplay = get_option( parent::$display_key );
		
		if($load){
			add_shortcode( 'next-social-login', [ $this, 'next_login_shortcode'] );
			$this->next_login_hook_action();
		}
	}
	
	 /**
     * Public Static method : post_type
     * Method Description: Get custom post type
     * @since 1.0.0
     * @access public
     */
	public static function post_type(){
		return self::POST_TYPE;
	}
	/**
     * Public method : next_login_shortcode
     * Method Description: Login Shortcode
     * @since 1.0.0
     * @access public
     */
	public function next_login_shortcode( $atts , $content = null ){
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button6';
		
		$atts = shortcode_atts(
								[
										'provider' => '',
										'btn-text' => '',
										'class' => '',
										'btn-style' => $setting_style,
									], $atts, 'next-social-login' 
							);

		if(isset($atts['provider']) && strlen($atts['provider']) > 5){
			$this->allow_pro = explode(',', $atts['provider']);
		}else{
			$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		}
		
		$this->class_name = isset($atts['class']) ? $atts['class'] : '';
		
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		if(isset($atts['btn-text']) && strlen($atts['btn-text']) > 5){
			$btn = explode(',', $atts['btn-text']);
			$this->but_content = array_map(function($b, $a){
				$array[$a] = $b;
				return $array;
			},$btn , $this->allow_pro);
		}else{
			$this->but_content = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		}
		
		if(!is_admin() && !is_user_logged_in() ) {
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(isset($_GET['redirect_to'])){
				$current_url = $_GET['redirect_to'];
			}
			//update_option('__next_social_current_redirect_page', $current_url);	
		}
		return $this->next_login_shortcode_action();
	}
	/**
     * Public method : next_login_shortcode_action
     * Method Description: Login Shortcode Action
     * @since 1.0.0
     * @access public
     */
	public function next_login_shortcode_action() {
		$icon_style = isset($this->getGeneral['general']['icon_style']) ? $this->getGeneral['general']['icon_style'] : 'line';
        $line_icon = ($icon_style == 'line')	? '-line' : '';
									
		$provider = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];

		if(!isset($this->getGeneral['general']['login']['ebable'])){
			return '';
		}
		ob_start();
		if(!is_user_logged_in()){
			include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/public/login/btn-html.php');
		}else{
			include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/public/login/logout-html.php');
		}
		$nextButton = ob_get_contents();
		ob_end_clean();
		
		return $nextButton;
		
	}
	
	
	/**
     * Public method : next_login_hook_action
     * Method Description: Login Action Hook
     * @since 1.0.0
     * @access private
     */
	private function next_login_hook_action(){
		
		$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button6';
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		$default_hook = get_option(parent::$hook_key);
		$action = isset($this->getGlobal['global']) ? $this->getGlobal['global'] : [];
		
		if(is_array($default_hook) && sizeof($default_hook) > 0){
			foreach($default_hook as $k=>$v){
				if( isset($action[$k]['enable']) && $action[$k]['enable'] == 'Yes'){
					$hook = isset($action[$k]['services']) ? $action[$k]['services'] : current($v);
					add_filter( $hook, [$this, '__action_hook'] );
				}
			}
		}
	}
	
	/**
     * Public method : __action_hook
     * Method Description: Login Action Hook
     * @since 1.0.0
     * @access public
     */
	public function __action_hook(){
		echo $this->next_login_shortcode_action();
	}
}