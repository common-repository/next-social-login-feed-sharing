<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevSocial\Apps\Settings as Settings;

class Counter extends Settings{
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
	
	public $content_position = '';
	
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
	
	public $provider;

	private static $api_data = '__next_counter_provider_api_data';
	
	public function __construct($load = true){
		
		$this->getGeneral = get_option( parent::$counter_general_key );
		
		$this->getProvider = get_option( parent::$counter_provider_key );
		
		$this->getDisplay = get_option( parent::$counter_display_key );
		
		
		if($load){
			add_action('init', [$this, 'next_counter_access_key_setup']);

			add_shortcode( 'next-social-counter', [ $this, 'next_counter_shortcode'] );
			
			add_action( 'add_meta_boxes', [ $this, 'next_meta_box_for_counter' ] );
			
			add_action( 'save_post', array( $this, 'next_meta_box_for_counter_data' ), 1, 2  );
			
			add_filter( 'the_content', [$this, '__action_hook_content'] );
			
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
     * Public method : next_counter_access_key_setup
     * Method Description: Counter access key setup
     * @since 1.0.0
     * @access public
     */
	public function next_counter_access_key_setup(){
		$get_type = isset($_GET['type']) ? self::sanitize($_GET['type']) : '';
		if(strlen($get_type) > 3){
			if( isset($_POST['next_access_token']) ){
				$accesskey = isset($_POST['accesskey']) ? self::sanitize($_POST['accesskey']) : '';
				$app_id = isset($accesskey[$get_type]['id']) ? $accesskey[$get_type]['id'] : '';
				$app_secret = isset($accesskey[$get_type]['secret']) ? $accesskey[$get_type]['secret'] : '';
				
				$getProviderAll = get_option( Settings::$counter_provider_key, [] );
				$redirect_page =  admin_url().'admin.php?page=next-social-counter&tab=providers&type='.$get_type ;
				// app id
				$getProviderAll['provider'][$get_type]['id'] = $app_id;
				$getProviderAll['provider'][$get_type]['secret'] = $app_secret;
				update_option( Settings::$counter_provider_key , $getProviderAll);
				
				if($get_type == 'twitter'){
					$this->get_provider($get_type);
					if( is_object($this->provider) ){						
						$access_token = $this->provider->__get_accesstoken_generate();
						
						$getProviderAll['provider'][$get_type]['token'] = $access_token;
						update_option( Settings::$counter_provider_key , $getProviderAll);
					}
					

				}else if( in_array($get_type, ['instagram', 'facebook', 'dribbble', 'envato', 'github']) ){
					$this->get_provider($get_type);
					if( is_object($this->provider) ){						
						$this->provider->__api_authorise();
					}
				}
			}
		}
	}
	/**
     * Public method : next_meta_box_for_sharing
     * Method Description: Sharing option for page
     * @since 1.0.0
     * @access public
     */
	 public function next_meta_box_for_counter(){
		if(!isset($this->getGeneral['general']['counter']['ebable'])){
			return '';
		}
		
		add_meta_box(
			'__next_social_counter_meta_featured',
			esc_html__('Next Counter Options', 'themedev-social-services'),
			[$this, 'next_social_counter_options_page'],
			'',
			'side',
			'low'
		);
	 }
	 /**
     * Public method : next_social_counter_options_page
     * Method Description: Counter Option Data Template
     * @since 1.0.0
     * @access public
     */
	 public function next_social_counter_options_page(){
		global $post;
		
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		$options = get_post_meta( $post_id, '__next_social_counter_page_options', true);
		
		$position = Settings::$counter_content_position;
		
		include( NEXT_SOCIAL_FEED_PLUGIN_PATH.'views/admin/counter/custom_options.php' );

	}
	 /**
     * Public method : next_meta_box_for_counter_data
     * Method Description: Sharing Option Data
     * @since 1.0.0
     * @access public
     */
	public function next_meta_box_for_counter_data($post_id, $post ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// check post id
		if( !empty($post_id) AND is_object($post) ){
			if( isset( $_POST['themedev_counter'] ) ){
				update_post_meta( $post_id, '__next_social_counter_page_options', Settings::sanitize($_POST['themedev_counter']) );
			}
		}

	}
	 /**
     * Public method : next_sharing_shortcode
     * Method Description: Sharing Shortcode
     * @since 1.0.0
     * @access public
     */
	public function next_counter_shortcode( $atts , $content = null ){
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$atts = shortcode_atts(
								[
										'provider' => '',
										'class' => '',
										'btn-style' => $setting_style,
										'position' => 'after_content',
									], $atts, 'next-social-counter' 
							);

		if(isset($atts['provider']) && strlen($atts['provider']) > 5){
			$this->allow_pro = explode(',', $atts['provider']);
		}else{
			$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		}
		
		$this->class_name = isset($atts['class']) ? $atts['class'] : '';
		
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		$this->content_position = isset($atts['position']) ? 'next-'. $atts['position'] : 'next-after_content';
		
		return $this->next_counter_shortcode_action();
	}
	/**
     * Public method : next_sharing_shortcode_action
     * Method Description: Counter Shortcode Action
     * @since 1.0.0
     * @access public
     */
	public function next_counter_shortcode_action() {
									
		$icon_style = isset($this->getGeneral['general']['icon_style']) ? $this->getGeneral['general']['icon_style'] : 'line';
        $line_icon = ($icon_style == 'line')	? '-line' : '';
		
		// all providers 
		$provider = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		$getAPiServices = get_option( parent::$counter_pro_services_key, []);
		
		if(!isset($this->getGeneral['general']['counter']['ebable'])){
			return '';
		}
		$this->share_counter(false);


		$option_key 	= self::$api_data;
		$api_data	 = get_option( $option_key ) ? get_option( $option_key ) : [];
		//print_r($api_data);


		ob_start();
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/public/counter/btn-html.php');
		$nextButton = ob_get_contents();
		ob_end_clean();
		
		return $nextButton;
		
	}
	
	public function share_counter( $load = false ){
		$option_key 	= self::$api_data;
		$api_data	 = get_option( $option_key ) ? get_option( $option_key ) : [];
		
		$provider = isset($this->getProvider['provider']) ? $this->getProvider['provider'] : [];
		
		$cache = $icon_style = isset($this->getGeneral['general']['cache']) ? $this->getGeneral['general']['cache'] : 12;
	
		// counters timeout set
		$get_transient_time   = get_transient( 'timeout_'.self::$api_data );
		if( $get_transient_time > time() && false != $get_transient_time){
			//return '';
		}
		$get_transient   = get_transient( self::$api_data );

		$return = []; 
		$transient = [];
		foreach( $provider as $k=>$v):
			if( isset($v['enable']) ){
				$before = isset( $api_data[$k] ) ? $api_data[$k] : 0;
				$result = 0;
				if( isset( $get_transient[$k] ) && $get_transient[$k] >= 0 && !$load){
					$result = isset($get_transient[$k]) ? (int) $get_transient[$k] : 0;
				}else if( isset( $api_data[$k] ) && ( isset($get_transient[$k]) && $get_transient[$k] == 0) && $api_data[$k] >= 0  && !$load ){
					$result = $before;
				}else{	
					$this->get_provider($k);
					if( is_object($this->provider) ){						
						$this->provider->__get_accesstoken();
						$result = $this->provider->__get_follower_data();
					}
				}

				$return[$k] = ($result > 0) ? $result : $before;
				$transient[$k] = $result;
			}
		endforeach;
		set_transient( self::$api_data, $transient , $cache*60*60 );
		update_option( self::$api_data , $return );
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
       
		$content_position = isset($this->getGeneral['general']['content_position']) ? $this->getGeneral['general']['content_position'] : 'unset_position';
		
		global $post;
		$post_id = isset($post->ID) ? $post->ID : 0;
		$options = get_post_meta( $post_id, '__next_social_counter_page_options', true);
		
		if( isset($options['counter_meta']) ){
			$enable = isset( $options['counter_meta']['enable'] ) ? $options['counter_meta']['enable'] : 'enable';
			if($enable == 'disable'){
				return $content; 
			}
			$content_position_data = isset( $options['counter_meta']['content_position'] ) ? $options['counter_meta']['content_position'] : $content_position;
			$content_position = (strlen($content_position_data) > 4) ? $content_position_data : $content_position;
		}
		
		$this->allow_pro = isset($this->getProvider['provider']) ? array_keys($this->getProvider['provider']) : [];
		
		$setting_style = isset($this->getDisplay['display']['button']) ? $this->getDisplay['display']['button'] : 'button1';
		
		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : $setting_style;
		
		
		$this->content_position = 'next-'.$content_position;
		
		if(in_array($content_position, ['after_content', 'before_content']) ){
			$getContent = $this->next_counter_shortcode_action();
			if($content_position == 'after_content'){
				return $content.$getContent;
			}else if($content_position == 'before_content'){
				return $getContent.$content;
			}
		}
		return $content;
	}
	/**
     * Public method : next_counter_providers_data
     * Method Description: Counter provider data
     * @since 1.0.0
     * @access public
     */
	public function next_counter_providers_data(){
		return [
			'facebook' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'Page ID/Name', 'input' => 'text'], 'token' => ['type' => 'access', 'label' => 'Access Token (optional)', 'input' => 'text', 'filed' => ['id' => 'Client ID', 'secret' => 'Client Secret'] ] ],
			'twitter' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'],  'token' => ['type' => 'access', 'label' => 'Access Token (optional)', 'input' => 'text', 'filed' => ['id' => 'Consumer key', 'secret' => 'Consumer secret'] ] ],
			'instagram' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'],  'token' => ['type' => 'access', 'label' => 'Access Token(optional)', 'input' => 'text', 'filed' => ['id' => 'Client ID', 'secret' => 'Client Secret'] ] ],
			'linkedin' => [ 'type' => [ 'type' => 'normal', 'label' => 'Account Type', 'input' => 'select', 'data' => [ 'Company' => 'Company', 'Profile' => 'Profile']], 'user_id' => [ 'type' => 'normal', 'label' => 'Your ID', 'input' => 'text'], 'token' => ['type' => 'access', 'label' => 'Access Token(optional)', 'input' => 'text', 'filed' => ['id' => 'API Key', 'secret' => 'Secret Key'] ] ],
			'pinterest' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'],],
			'youtube' => [ 'type' => [ 'type' => 'normal', 'label' => 'Account Type', 'input' => 'select', 'data' => [ 'channel' => 'Channel', 'user' => 'User']], 'user_id' => [ 'type' => 'normal', 'label' => 'Username or Channel ID', 'input' => 'text'], 'token' => [ 'type' => 'normal', 'label' => 'Youtube API Key(optional)', 'input' => 'text'] ],
			'dribbble' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'],  'token' => ['type' => 'access', 'label' => 'Access Token', 'input' => 'text', 'filed' => ['id' => 'Client ID', 'secret' => 'Client Secret'] ] ],
			'mailchimp' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'List ID (Optional)', 'input' => 'text'],  'token' => [ 'type' => 'normal', 'label' => 'API Key', 'input' => 'text'] ],
			'envato' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'], 'type' => [ 'type' => 'normal', 'label' => 'Display Value', 'input' => 'select', 'data' => [ 'followers' => 'Followers', 'sales' => 'Sales']], 'token' => ['type' => 'access', 'label' => 'Access Token', 'input' => 'text', 'filed' => ['id' => 'OAuth Client ID', 'secret' => 'Token'] ] ],
			'github' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'], 'token' => ['type' => 'access', 'label' => 'Access Token', 'input' => 'text', 'filed' => ['id' => 'Client ID', 'secret' => 'Client Secret'] ] ],
			'behance' => [ 'user_id' => [ 'type' => 'normal', 'label' => 'UserName', 'input' => 'text'], 'token' => [ 'type' => 'normal', 'label' => 'API Key(optional)', 'input' => 'text'] ],
			
		];
	}
	

	/**
     * Method: get_provider
     * Method Description: Get Provider
     * @since 1.0.0
     * @access private
	 */
	
	public function get_provider($param){
		
		if(!file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/counters/'.$param.'.php' )){
			return '';
		}

		if($param == 'facebook'){
			$this->provider = new \themeDevSocial\Apps\Counters\Facebook(true);	
		}else if($param == 'github'){
			$this->provider = new \themeDevSocial\Apps\Counters\Github(true);
		}else if($param == 'twitter'){
			$this->provider = new \themeDevSocial\Apps\Counters\Twitter(true);
		}else if($param == 'behance'){
			$this->provider = new \themeDevSocial\Apps\Counters\Behance(true);
		}else if($param == 'instagram'){
			$this->provider = new \themeDevSocial\Apps\Counters\Instagram(true);
		}else if($param == 'dribbble'){
			$this->provider = new \themeDevSocial\Apps\Counters\Dribbble(true);
		}else if($param == 'youtube'){
			$this->provider = new \themeDevSocial\Apps\Counters\Youtube(true);
		}else if($param == 'bitbucket'){
			$this->provider = new \themeDevSocial\Apps\Counters\Bitbucket(true);
		}else if($param == 'comments'){
			$this->provider = new \themeDevSocial\Apps\Counters\Comments(true);
		}else if($param == 'post'){
			$this->provider = new \themeDevSocial\Apps\Counters\Post(true);
		}else if($param == 'reddit'){
			$this->provider = new \themeDevSocial\Apps\Counters\Reddit(true);
		}else if($param == 'envato'){
			$this->provider = new \themeDevSocial\Apps\Counters\Envato(true);
		}else if($param == 'pinterest'){
			$this->provider = new \themeDevSocial\Apps\Counters\Pinterest(true);
		}else if($param == 'mailchimp'){
			$this->provider = new \themeDevSocial\Apps\Counters\Mailchimp(true);
		}
		return $this->provider;
	}
}