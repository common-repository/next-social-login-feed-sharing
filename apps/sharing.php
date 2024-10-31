<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevSocial\Apps\Settings as Settings;

class Sharing extends Settings{
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
	
	public $body_position = '';
	
	public $body_position_type = 'fixed';
	
	public $content_position = '';
	
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
		
		$this->getGeneral = get_option( parent::$sharing_general_key );
		
		$this->getProvider = get_option( parent::$sharing_provider_key );
		
		$this->getDisplay = get_option( parent::$sharing_display_key );
		
		add_action( 'wp_head', [ $this, '__next_tag_added_in_head' ], 5 );
		
		if($load){
			add_shortcode( 'next-social-sharing', [ $this, 'next_sharing_shortcode'] );
			
			add_action( 'add_meta_boxes', [ $this, 'next_meta_box_for_sharing' ] );
			
			add_action( 'save_post', array( $this, 'next_meta_box_for_sharing_data' ), 1, 2  );
			
			add_filter( 'the_content', [$this, '__action_hook_content'] );
			
			//add_action('wp_body_open', [ $this, '__the_body_content_body' ] );
			add_action('wp_footer', [ $this, '__the_body_content_body' ] );
			
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
     * Public method : next_meta_box_for_sharing
     * Method Description: Sharing option for page
     * @since 1.0.0
     * @access public
     */
	 public function next_meta_box_for_sharing(){
		if(!isset($this->getGeneral['general']['sharing']['ebable'])){
			return '';
		}
		
		add_meta_box(
			'__next_social_sharing_meta_featured',
			esc_html__('Next Share Options', 'themedev-social-services'),
			[$this, 'next_social_sharing_options_page'],
			'',
			'side',
			'low'
		);
	 }
	 /**
     * Public method : next_social_sharing_options_page
     * Method Description: Sharing Option Data Template
     * @since 1.0.0
     * @access public
     */
	 public function next_social_sharing_options_page(){
		global $post;
		
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		$options = get_post_meta( $post_id, '__next_social_sharing_page_options', true);
		
		$position = Settings::$sharing_content_position;
		
		include( NEXT_SOCIAL_FEED_PLUGIN_PATH.'views/admin/sharing/custom_options.php' );

	}
	 /**
     * Public method : next_meta_box_for_sharing_data
     * Method Description: Sharing Option Data
     * @since 1.0.0
     * @access public
     */
	public function next_meta_box_for_sharing_data($post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// check post id
		if( !empty($post_id) AND is_object($post) ){
			if( isset( $_POST['themedev_sharing'] ) ){
				update_post_meta( $post_id, '__next_social_sharing_page_options', Settings::sanitize($_POST['themedev_sharing']) );
			}
		}

	}
	 /**
     * Public method : next_sharing_shortcode
     * Method Description: Sharing Shortcode
     * @since 1.0.0
     * @access public
     */
	public function next_sharing_shortcode( $atts , $content = null ){
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$atts = shortcode_atts(
								[
										'provider' => '',
										'btn-style' => $setting_style,
										'class' => '',
										'position' => 'after_content',
									], $atts, 'next-social-sharing' 
							);

		if(isset($atts['provider']) && strlen($atts['provider']) > 5){
			$this->allow_pro = explode(',', $atts['provider']);
		}else{
			$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		}
		
		$this->class_name = isset($atts['class']) ? $atts['class'] : '';
		
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		$this->content_position = isset($atts['position']) ? 'next-'. $atts['position'] : 'next-after_content';
		
		if(isset($atts['btn-text']) && strlen($atts['btn-text']) > 5){
			$btn = explode(',', $atts['btn-text']);
			$this->but_content = array_map(function($b, $a){
				$array[$a] = $b;
				return $array;
			},$btn , $this->allow_pro);
		}else{
			$this->but_content = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		}
		
		return $this->next_sharing_shortcode_action();
	}
	/**
     * Public method : next_sharing_shortcode_action
     * Method Description: Sharing Shortcode Action
     * @since 1.0.0
     * @access public
     */
	public function next_sharing_shortcode_action() {
									
		$icon_style = isset($this->getGeneral['general']['icon_style']) ? $this->getGeneral['general']['icon_style'] : 'line';
        $line_icon = ($icon_style == 'line')	? '-line' : '';
		
		
		$provider = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		
		$getAPiServices = get_option( parent::$sharing_pro_services_key, []);
		
		if(!isset($this->getGeneral['general']['sharing']['ebable'])){
			return '';
		}
		
		global $currentUrl, $title,$author, $details, $source, $media, $app_id;
		
		global $post;
		
		$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if(is_object($post) && isset($post->ID)){
			$currentUrl = get_permalink();
		}
		
		$postId = isset($post->ID) ? $post->ID : 0;
		
		$this->share_counter($currentUrl, $postId);
		
		$current_id = get_current_user_id();
		$user = get_userdata( $current_id );
		$author = 'themeDev';
		if(is_object($user)){
			$author = isset($user->data->user_nicename) ? $user->data->user_nicename : '';
		}
		$details = '';
		if(isset($post->post_excerpt) AND strlen($post->post_excerpt) > 2){
			$details = $post->post_excerpt;
		}
		$title = get_the_title();
		
		$source = get_bloginfo();
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), 'full' );
		
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$customLogo = isset($image[0]) ? $image[0] : '';
		
		$media = isset($thumbnail_src[0]) ? $thumbnail_src[0] : $customLogo;
		$app_id = '369152773812083';
		
		ob_start();
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/public/sharing/btn-html.php');
		$nextButton = ob_get_contents();
		ob_end_clean();
		
		return $nextButton;
		
	}
	
	public function share_counter( $post_url = '', $id_post = 0 , $load = false){
		$provider = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		if(empty($post_url) || $id_post == 0){
			return '';
		}
		
		$transient   = get_transient( '__next_share_data__'.$id_post );
		$transient_time   = get_transient( 'timeout___next_share_data__'.$id_post );
		
		$prev_data	 = get_post_meta( $id_post, '__next_share_data_post', true ) ? get_post_meta( $id_post, '__next_share_data_post', true ) : [];
		
		if($transient_time > time() ){
			//return '';
		}
		
		$return = []; $next_transient = [];
		foreach( $provider AS $k=>$v):
			if( isset($v['enable']) ){
				if( isset($transient[$k]) && $transient[$k] >= 0 && !$load ){
					$result = $transient[$k];
				}else if( isset( $prev_data[$k] ) && ( isset($transient[$k]) && $transient[$k] == 0) && $prev_data[$k] >= 0  && !$load ){
					$result = $before;
				}else{
					$result = $this->_get_social_share_counter($k, $post_url);
					$pre_data = isset($prev_data[$k]) ? $prev_data[$k] : 0;
					$result = ($result == 0) ? $pre_data : $result;
				}
				$return[$k] = $result;
				$next_transient[$k] = $result;
			}
		endforeach;
		update_post_meta( $id_post, '__next_share_data_post', $return );
		set_transient( '__next_share_data__'.$id_post, $next_transient , parent::$cache*60*60 );
	}
	/**
     * Public method : next_sharing_hook_action
     * Method Description: Login Action Hook
     * @since 1.0.0
     * @access private
     */
	private function next_sharing_hook_action(){
		$line_icon = '-line';
		$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		$body_position = isset($this->getGeneral['general']['body_position']) ? $this->getGeneral['general']['body_position'] : 'left_content';
		$type_position = isset($this->getGeneral['general']['type_position']) ? $this->getGeneral['general']['type_position'] : 'fixed';
		$content_position = isset($this->getGeneral['general']['content_position']) ? $this->getGeneral['general']['content_position'] : 'unset_position';
		
		$this->content_position = 'next-'.$body_position.' next-'.$type_position;
		
		/*
		$default_hook = get_option(parent::$hook_key);
		$action = isset($this->getGlobal['global']) ? $this->getGlobal['global'] : [];
		
		if(is_array($default_hook) && sizeof($default_hook) > 0){
			foreach($default_hook as $k=>$v){
				if( isset($action[$k]['enable']) && $action[$k]['enable'] == 'Yes'){
					$hook = isset($action[$k]['services']) ? $action[$k]['services'] : current($v);
					add_filter( $hook, [$this, '__action_hook'] );
				}
			}
		}*/
		
		
	}
	
	public function __the_body_content_body( ){
		$body_position = isset($this->getGeneral['general']['body_position']) ? $this->getGeneral['general']['body_position'] : 'left_content';
		$type_position = isset($this->getGeneral['general']['type_position']) ? $this->getGeneral['general']['type_position'] : 'fixed';
		
		$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		$this->content_position = 'next-'.$body_position.' next-'.$type_position;
		
		if( in_array($body_position, ['left_content', 'right_content', 'top_content', 'bottom_content', 'center_content']) ){
			echo $this->next_sharing_shortcode_action();
		}
		
	}
	/**
     * Public method : __action_hook
     * Method Description: Login Action Hook
     * @since 1.0.0
     * @access public
     */
	public function __action_hook_content( $content ){
		if( is_admin() ){
            return '';
        }
        if( is_front_page() || is_home() || !is_single()){
            return $content;
        }
		
		$content_position = isset($this->getGeneral['general']['content_position']) ? $this->getGeneral['general']['content_position'] : 'unset_position';
		
		
		global $post;
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		$options = get_post_meta( $post_id, '__next_social_sharing_page_options', true);
		
		if( isset($options['share_meta']) ){
			$enable = isset( $options['share_meta']['enable'] ) ? $options['share_meta']['enable'] : 'enable';
			if($enable == 'disable'){
				return $content; 
			}
			$content_position_data = isset( $options['share_meta']['content_position'] ) ? $options['share_meta']['content_position'] : $content_position;
			$content_position = (strlen($content_position_data) > 4) ? $content_position_data : $content_position;
		}
		
		$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		
		$this->content_position = 'next-'.$content_position;
		
		if(in_array($content_position, ['after_content', 'before_content']) ){
			$getContent = $this->next_sharing_shortcode_action();
			if($content_position == 'after_content'){
				return $content.$getContent;
			}else if($content_position == 'before_content'){
				return $getContent.$content;
			}
		}
		return $content;
	}
	
	public function __next_tag_added_in_head(){
		global $post;
		 //if( get_post_type( $post ) === self::post_type() && is_single() ){ 
			if( !is_singular()){
				return;
			}
			$current_id = get_current_user_id();
			$user = get_userdata( $current_id );
			$userName = 'themeDev';
			if(is_object($user)){
				$userName = isset($user->data->user_nicename) ? $user->data->user_nicename : '';
			}
			$descrpition = '';
			if(strlen($post->post_excerpt) > 2){
				$descrpition = $post->post_excerpt;
			}
			$meta = '';
			$meta .= '<meta property="fb:admins" content="'.$userName.'"/>';
			$meta .= '<meta property="og:title" content="' . get_the_title() . '"/>';
			$meta .= '<meta property="og:type" content="article"/>';
			$meta .= '<meta property="og:description" content="' . $descrpition . '"/>';
			$meta .= '<meta property="og:url" content="' . get_permalink() . '"/>';
			$meta .= '<meta property="og:site_name" content="'.get_bloginfo().'"/>';
			
			$postId = isset($post->ID) ? $post->ID : 0;
			
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $postId ), 'full' );
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			$customLogo = isset($image[0]) ? $image[0] : '';
			
			$meta .= '<meta property="og:image" content="' . esc_attr( isset($thumbnail_src[0]) ? $thumbnail_src[0] : $customLogo ) . '"/>';
			
			echo $meta;
		 //}
	}
	
	private function _get_social_share_counter($type = '', $parmal = ''){
		if($type == 'facebook'){
			$get_transient_time   = get_transient( 'timeout__next_social_access_token' );		
			if( $get_transient_time < time() ){
				$access_tok = parent::_get_social_services('social_token');
				if(isset($access_tok['data'])){
					set_transient( '_next_social_access_token', $access_tok['data'] , parent::$cache*60*60 );
				}
			}
			$tokenData   = get_transient( '_next_social_access_token' );
			$token = isset($tokenData['facebook_token']) ? $tokenData['facebook_token'] : '';
			$url = 'https://graph.facebook.com/v2.2/?id='.$parmal.'&fields=engagement&access_token='.$token;
			
		}else if($type == 'pinterest'){
			$url = 'https://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='. $parmal;	
		}else if($type == 'stumbleupon'){
			$url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='. $parmal;	
		}else{
			return 0;
		}
		
		$response = wp_remote_post( $url, [
			'method' => 'GET',
			'timeout' => 45,
			'headers' => [
						'Content-Type' => 'application/json; charset=utf-8'
					],
			]
		);
		
		if ( is_wp_error( $response ) ) {
		   $error_message = $response->get_error_message();
			return 0;
		} else {
			$bodyResponse = json_decode($response['body'], true);
			if($type == 'pinterest'){
				preg_match_all('!\d+!', $response['body'], $matches);
				return isset($matches[0]) ? end($matches[0]) : 0; 
			}else if($type == 'facebook'){
				return isset($bodyResponse['engagement']['share_count']) ? $bodyResponse['engagement']['share_count'] : 0;
			}else if($type == 'stumbleupon'){
				return isset($bodyResponse['result']['views']) ? $bodyResponse['result']['views'] : 0;
			}else{
				return 0;
			}
		}
	}
	
}