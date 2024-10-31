<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
class Settings{
	
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
     */
	const POST_TYPE = 'themedev-social-services';
	
	// general option kry
	public static $general_key = '__next_social_general_data';
	public static $sharing_general_key = '__next_social_general_sharing_data';
	public static $counter_general_key = '__next_social_general_counter_data';
	// global key
	public static $global_key = '__next_social_global_data';
	
	// provider key
	public static $provider_key = '__next_social_provider_data';
	public static $sharing_provider_key = '__next_social_provider_sharing_data';
	public static $counter_provider_key = '__next_social_provider_counter_data';
	
	// provider key
	public static $display_key = '__next_social_display_data';
	public static $sharing_display_key = '__next_social_display_sharing_data';
	public static $counter_display_key = '__next_social_display_counter_data';
	
	
	public static $pro_services_key = '__next_social_provider_services';
	public static $sharing_pro_services_key = '__next_social_provider_services_sharing';
	public static $counter_pro_services_key = '__next_social_provider_services_counter';
	public static $hook_key = '__next_social_hook_services';
	
	public static $cache = 24;
	
	// login style
	public static $login_style = [ 'button1' => ['text' => 'Icon, Label with round', 'url' => ''], 'button2' => ['text' => 'Only Icon with round', 'url' => ''], 'button3' => ['text' => 'Only Label with round', 'url' => ''], 'button4' => ['text' => 'Round Icon with Label', 'url' => ''], 'button5' => ['text' => 'Round Icon', 'url' => ''],  'button6' => ['text' => 'Square Icon with hover effect', 'url' => ''],  'button7' => ['text' => 'Square Icon with Label', 'url' => ''], 'button8' => ['text' => 'Square only Label', 'url' => ''],  'button9' => ['text' => 'Square Full width scale', 'url' => ''], 'button10' => ['text' => 'Icon with hover tooltip', 'url' => ''], 'button11' => ['text' => 'Label with arrow', 'url' => ''],];
	
	
	// share style
	public static $share_style = [ 'button1' => ['text' => 'Icon with Label', 'url' => ''], 'button2' => ['text' => 'Only Icon with round', 'url' => ''], 'button3' => ['text' => 'Only Label', 'url' => ''], 'button4' => ['text' => 'Round Icon with Label', 'url' => ''], 'button5' => ['text' => 'Round Icon', 'url' => ''],  'button6' => ['text' => 'Square Icon', 'url' => ''],  'button7' => ['text' => 'Square Icon with Label', 'url' => ''], 'button8' => ['text' => 'Only Icon with rotate', 'url' => ''], 'button9' => ['text' => 'Hover icons with pop-up title', 'url' => ''], 'button10' => ['text' => 'Icon, Label with Counter ', 'url' => ''], 'button11' => ['text' => 'Social buttons with Icon Fonts ', 'url' => ''], 'button12' => ['text' => 'Icon Share ', 'url' => ''], 'button13' => ['text' => 'Icon with counter ', 'url' => ''], 'button14' => ['text' => 'Icon with counter 2', 'url' => ''], 'button15' => ['text' => 'Icon with counter 3', 'url' => ''], 'button16' => ['text' => 'Icon with counter 4', 'url' => '']];
	
	// share style
	public static $counter_style = [ 'button1' => ['text' => 'Icon, Label with round', 'url' => ''], 'button2' => ['text' => 'Icon with Label', 'url' => ''], 'button3' => ['text' => 'Full Box with no-space', 'url' => ''], 'button4' => ['text' => 'Hover Black', 'url' => ''], 'button4-1' => ['text' => 'Hover Black', 'url' => ''], 'button4-2' => ['text' => 'Hover Black', 'url' => ''], 'button5' => ['text' => 'Full width Box', 'url' => ''], 'button6' => ['text' => 'Circle Style', 'url' => ''], 'button7' => ['text' => 'Colored Square', 'url' => ''], 'button8' => ['text' => 'Hover Scale', 'url' => ''], 'button9' => ['text' => 'Square Canvas', 'url' => ''], 'button10' => ['text' => 'Square Canvas 1', 'url' => ''], 'button11' => ['text' => 'Square Canvas 2', 'url' => ''], 'button12' => ['text' => 'Square Canvas 3', 'url' => ''], 'button13' => ['text' => 'Square Canvas 4', 'url' => ''], 'button14' => ['text' => 'Square Canvas 5', 'url' => ''], 'button15' => ['text' => 'Square Canvas 6', 'url' => '']];
	
	public static $sharing_body_position = ['left_content' => 'Left in Body', 'right_content' => 'Right in Body', 'top_content' => 'Top in Body', 'bottom_content' => 'Bottom in Body', 'center_content' => 'Center in Body', 'unset_position' => ' No Position'];
	public static $sharing_content_position = ['before_content' => 'Before Content', 'after_content' => 'After Content', 'unset_position' => ' No Position'];
	public static $counter_content_position = ['before_content' => 'Before Content', 'after_content' => 'After Content', 'unset_position' => ' No Position'];
	
	public static function init($load = true){
		if($load){
			add_action('admin_menu', [ __CLASS__ , 'themeDev_social_admin_menu' ]);
			
			// Load script file for settings page
			add_action( 'admin_enqueue_scripts', [__CLASS__ , 'themedev_social_script_loader_admin' ] );
			
			add_action( 'wp_enqueue_scripts', [__CLASS__ , 'themedev_social_script_loader_public' ] );
			
			add_action( 'login_enqueue_scripts', [__CLASS__ , 'themedev_social_script_loader_public' ] );
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
     * Public method : themeDev_add_custom_post
     * Method Description: Create custom post type
     * @since 1.0.0
     * @access public
     */
	public static function themeDev_social_admin_menu(){
		add_menu_page(
            esc_html__( 'Next Social', 'themedev-social-services' ),
            esc_html__( 'Next Social', 'themedev-social-services' ),
            'manage_options',
            'next-social-login',
            '',
            'dashicons-networking',
            6
        );
		 add_submenu_page( 'next-social-login', esc_html__( 'Next Login', 'themedev-social-services' ), esc_html__( 'Next Login', 'themedev-next-elementor' ), 'manage_options', 'next-social-login', [ __CLASS__, 'themedev_next_serv_settings_login'], 8);
		 add_submenu_page( 'next-social-login', esc_html__( 'Next Sharing', 'themedev-social-services' ), esc_html__( 'Next Sharing', 'themedev-next-elementor' ), 'manage_options', 'next-social-sharing', [ __CLASS__ ,'themedev_next_serv_settings_sharing'], 9);
		 add_submenu_page( 'next-social-login', esc_html__( 'Next Counter', 'themedev-social-services' ), esc_html__( 'Next Counter', 'themedev-next-elementor' ), 'manage_options', 'next-social-counter', [ __CLASS__ ,'themedev_next_serv_settings_social_counter'], 10);
		 add_submenu_page( 'next-social-login', esc_html__( 'Support', 'themedev-social-services' ), esc_html__( 'Support', 'themedev-next-elementor' ), 'manage_options', 'next-social-serv-support', [ __CLASS__ ,'themedev_next_serv_settings_supports'], 11);
	}
	/**
	 * Method Name: themedev_next_serv_settings_login
	 * Description: Next Settings - login
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_serv_settings_login(){
		$message_status = 'No';
		$message_text = '';
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
			
		if($active_tab == 'general'){
			// general options
			if(isset($_POST['themedev-social-general'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				if(update_option( self::$general_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'themedev-social-services');
				}
			}
		}
		//  get general data
		$getGeneral = get_option( self::$general_key, '');
		
		if($active_tab == 'global'){
			// global options
			
			if(isset($_POST['themedev-social-global'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				if(update_option( self::$global_key , $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'themedev-social-services');
				}
				
				$get_transient_time   = get_transient( 'timeout___next_login_global_services' );
						
				if( $get_transient_time < time() ){
					$serGlobal = self::_get_social_services();
					if(isset($serGlobal['data'])){
						update_option( self::$hook_key, $serGlobal['data']);
						set_transient( '__next_login_global_services', $serGlobal['data'] , self::$cache*60*60 );
					}
				}
			}
			$servicesGlobal = get_option(self::$hook_key, '');
			if(empty($servicesGlobal)){	
				$serGlobal = self::_get_social_services();
				$servicesGlobal = isset($serGlobal['data']) ? $serGlobal['data'] : [];
			}
			
		}
		//  get general data
		$getGlobal = get_option( self::$global_key, []);
		
		if($active_tab == 'providers'){
			if(isset($_POST['themedev-social-providers'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				$loginsorting = isset($_POST['loginsorting']) ? self::sanitize($_POST['loginsorting']) : [];
				update_option( '__next_social_sotring_login_provider' , $loginsorting);
				
				if(update_option( self::$provider_key , $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save provider data.', 'themedev-social-services');
				}
				
				// global options
				$get_transient_time   = get_transient( 'timeout___next_login_provider_services' );
						
				if( $get_transient_time < time() ){
					$provider = self::_get_social_services('provider');
					if(isset($provider['data'])){
						update_option( self::$pro_services_key, $provider['data']);
						set_transient( '__next_login_provider_services', $provider['data'] , self::$cache*60*60 );
					}
				}
				
			}
			
			$provider = get_option(self::$pro_services_key, '');
			if(empty($provider)){	
				$providerS = self::_get_social_services('provider');
				$provider = isset($providerS['data']) ? $providerS['data'] : [];
			}
			
			$getProviderSorting = get_option( '__next_social_sotring_login_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) > 0){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}
			
		}
		
		$getProvider = get_option( self::$provider_key, [] );
		
		
		if($active_tab == 'display'){
			
			$buttonstyle = self::$login_style;
			
			if(isset($_POST['themedev-social-display'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				if(update_option( self::$display_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save display data.', 'themedev-social-services');
				}
			}
			
		}
		
		$getDisplay = get_option(self::$display_key);
		
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/admin/settings.php');
	}
	
	/**
	 * Method Name: themedev_next_serv_settings_sharing
	 * Description: Next Settings - sharing
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_serv_settings_sharing(){
		$message_status = 'No';
		$message_text = '';
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
		
		if($active_tab == 'general'){
			// general options
			if(isset($_POST['themedev-social-general'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				if(update_option( self::$sharing_general_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'themedev-social-services');
				}
			}
		}
		//  get general data
		$getGeneral = get_option( self::$sharing_general_key, '');	
		
		// get sharing provider
		if($active_tab == 'providers'){
			if(isset($_POST['themedev-social-providers'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				$sharingsorting = isset($_POST['sharingsorting']) ? self::sanitize($_POST['sharingsorting']) : [];
				update_option( '__next_social_sotring_sharing_provider' , $sharingsorting);
				
				if(update_option( self::$sharing_provider_key , $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save provider data.', 'themedev-social-services');
				}
				
				$get_transient_time   = get_transient( 'timeout___next_sharing_provider_services' );
						
				if( $get_transient_time < time() ){
					// global options
					$provider = self::_get_social_services('sharing');
					if(isset($provider['data'])){
						update_option( self::$sharing_pro_services_key, $provider['data']);
						set_transient( '__next_sharing_provider_services', $provider['data'] , self::$cache*60*60 );
					}
				}
			}
			
			$provider = get_option(self::$sharing_pro_services_key, '');
			if(empty($provider)){	
				$providerS = self::_get_social_services('sharing');
				$provider = isset($providerS['data']) ? $providerS['data'] : [];
				
			}
			$getProvider = get_option( self::$sharing_provider_key, [] );
			$getProviderSorting = get_option( '__next_social_sotring_sharing_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) >= sizeof($provider) ){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}

			
			
		}
		
		
		// display sharing
		if($active_tab == 'display'){
			
			$buttonstyle = self::$share_style;
			
			if(isset($_POST['themedev-social-display'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				if(update_option( self::$sharing_display_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save display data.', 'themedev-social-services');
				}
			}
			
		}
		
		$getDisplay = get_option(self::$sharing_display_key);
		
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/admin/sharing/settings.php');		
	}
	/**
	 * Method Name: themedev_next_serv_settings_social_counter
	 * Description: Next Settings - Social counter
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_serv_settings_social_counter(){
		$message_status = 'No';
		$message_text = '';
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
		
		if($active_tab == 'general'){
			// general options
			if(isset($_POST['themedev-social-general'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				if(update_option( self::$counter_general_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'themedev-social-services');
				}
			}
		}
		//  get general data
		$getGeneral = get_option( self::$counter_general_key, '');	
		
		// get sharing provider
		if($active_tab == 'providers'){
			// get access token
			$get_type = isset($_GET['type']) ? self::sanitize($_GET['type']) : '';
			$get_code = isset($_GET['code']) ? self::sanitize($_GET['code']) : '';
			if( strlen(trim($get_code)) > 6 ){
				$getProviderAll = get_option( self::$counter_provider_key, [] );
				$app_id = isset($getProviderAll['provider'][$get_type]['id']) ? $getProviderAll['provider'][$get_type]['id'] : '';
				$app_secret = isset($getProviderAll['provider'][$get_type]['secret']) ? $getProviderAll['provider'][$get_type]['secret'] : '';;
				
				$redirect_page =  admin_url().'admin.php?page=next-social-counter&tab=providers&type='.$get_type ;
				$counter = new \themeDevSocial\Apps\Counter(false);
				
				if( in_array($get_type, ['instagram', 'facebook', 'dribbble', 'envato', 'github']) ){
					$counter->get_provider($get_type);
					if( is_object($counter->provider) ){						
						$access_token = $counter->provider->__get_accesstoken_generate($get_code);
						$getProviderAll['provider'][$get_type]['token'] = $access_token;
						update_option( self::$counter_provider_key , $getProviderAll);
					}					
				}
			}

			//end access token
			if(isset($_POST['themedev-social-providers'])){
				
				if( isset($_POST['next_cache']) && $_POST['next_cache'] == 'Yes'){
					$counter = new \themeDevSocial\Apps\Counter(false);
					$counter->share_counter(true);
				}
				
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				$countersorting = isset($_POST['countersorting']) ? self::sanitize($_POST['countersorting']) : [];
				update_option( '__next_social_sotring_counter_provider' , $countersorting);
				
				if(update_option( self::$counter_provider_key , $options)){
					
					$message_status = 'yes';
					$message_text = __('Successfully save provider data.', 'themedev-social-services');
					
				}
				
				$get_transient_time   = get_transient( 'timeout___next_counter_provider_services' );
						
				if( $get_transient_time < time() ){
					// global options
					$provider = self::_get_social_services('counter');
					if(isset($provider['data'])){
						update_option( self::$counter_pro_services_key, $provider['data']);
						set_transient( '__next_counter_provider_services', $provider['data'] , self::$cache*60*60 );
					}
				}
			}
			
			$provider = get_option(self::$counter_pro_services_key, '');
			if(empty($provider)){	
				$providerS = self::_get_social_services('counter');
				$provider = isset($providerS['data']) ? $providerS['data'] : [];
				
			}
			$getProvider = get_option( self::$counter_provider_key, [] );
			$getProviderSorting = get_option( '__next_social_sotring_counter_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) >= sizeof($provider) ){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}
			if(empty($getProvider)){
				$getProvider['provider'] = $provider;
			}
		}
		
		
		// display sharing
		if($active_tab == 'display'){
			
			$buttonstyle = self::$counter_style;
			
			if(isset($_POST['themedev-social-display'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				if(update_option( self::$counter_display_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save display data.', 'themedev-social-services');
				}
			}
			
		}
		
		$getDisplay = get_option(self::$counter_display_key);
			
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/admin/counter/settings.php');	
	}
	
	/**
	 * Method Name: themedev_next_serv_settings_supports
	 * Description: Next Support Page
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_serv_settings_supports(){
		include ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'/views/admin/supports.php');
	}
	/**
     * Public method : sanitize
     * Method Description: Sanitize for Review
     * @since 1.0.0
     * @access public
     */
	public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
	}
	
	/**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public static function themedev_social_script_loader_public(){
        wp_register_script( 'themedev_social_settings_script', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/public/script/public-script.js', array( 'jquery' ), NEXT_SOCIAL_FEED_VERSION, false);
        wp_enqueue_script( 'themedev_social_settings_script' );
		
		wp_register_style( 'themedev_social_settings_css_public', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/public/css/public-style.css', false, NEXT_SOCIAL_FEED_VERSION);
        wp_enqueue_style( 'themedev_social_settings_css_public' );
		
		wp_register_style( 'themedev_social_icon_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/css/next-icon.css', false, NEXT_SOCIAL_FEED_VERSION);
        wp_enqueue_style( 'themedev_social_icon_admin' );
     }
	 
	 /**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public static function themedev_social_script_loader_admin(){
        wp_register_script( 'themedev_social_settings_script_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/scripts/admin-settings.js', array( 'jquery' ), NEXT_SOCIAL_FEED_VERSION, false);
        wp_enqueue_script( 'themedev_social_settings_script_admin' );
		
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		wp_register_script( 'themedev_social_settings_modal_script_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/scripts/modal-js/modal-popup.js', array( 'jquery' ), NEXT_SOCIAL_FEED_VERSION, false);
        wp_enqueue_script( 'themedev_social_settings_modal_script_admin' );
		
		wp_register_style( 'themedev_social_settings_css_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/css/admin-style.css', false, NEXT_SOCIAL_FEED_VERSION);
        wp_enqueue_style( 'themedev_social_settings_css_admin' );
		
		wp_register_style( 'themedev_social_settings_modalcss_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/css/modal-css/modal-popup.css', false, NEXT_SOCIAL_FEED_VERSION);
        wp_enqueue_style( 'themedev_social_settings_modalcss_admin' );
		
		wp_register_style( 'themedev_social_icon_admin', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/css/next-icon.css', false, NEXT_SOCIAL_FEED_VERSION);
		wp_enqueue_style( 'themedev_social_icon_admin' );
		
		wp_register_style( 'themedev_ads', NEXT_SOCIAL_FEED_PLUGIN_URL. 'assets/admin/css/ads.css', false, NEXT_SOCIAL_FEED_VERSION);
		wp_enqueue_style( 'themedev_ads' );

     }
	
	
	// get addons services 
	public static function _get_social_services($type = ''){
		if($type == 'provider'){
			$url = 'http://themedev.net/wp-json/themedev-api/get-social-provider/12';	
		}else if($type == 'sharing'){
			$url = 'http://themedev.net/wp-json/themedev-api/get-social-sharing/12';	
		}else if($type == 'counter'){
			$url = 'http://themedev.net/wp-json/themedev-api/get-social-counter/12';	
		}else if($type == 'social_token'){
			$url = 'http://themedev.net/wp-json/themedev-api/get-social-token/12';	
		}else{	
			$url = 'http://themedev.net/wp-json/themedev-api/get-social-services/12';	
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
			return $error_message;
		} else {
			$bodyResponse = json_decode($response['body'], true);
			return $bodyResponse;
		}
	}
	
	public static function __get_api_data($type = ''){
		$getProvider = get_option( self::$provider_key );	
		$providerData = isset($getProvider['provider'][$type]) ? $getProvider['provider'][$type] : [];
		return $providerData;
	}
	
	public static function __get_api_data_counter($type = ''){
		$getProvider = get_option( self::$counter_provider_key );	
		$providerData = isset($getProvider['provider'][$type]) ? $getProvider['provider'][$type] : self::__get_api_data($type);
		return $providerData;
	}

	public static function unit_converter($unit) {
		$convert_reaction = 0;
		$reaction_suffix = '';
		$unit = (int) $unit;
		if ($unit >= 0 && $unit < 10000) {
			$convert_reaction = number_format($unit);
		}else if ($unit >= 10000 && $unit < 1000000) {
			$convert_reaction = round(floor($unit / 1000), 1);
			$reaction_suffix = 'K';
		}else if ($unit >= 1000000 && $unit < 100000000) {
			$convert_reaction = round(($unit / 1000000), 1);
			$reaction_suffix = 'M';
		}else if ($unit >= 100000000 && $unit < 1000000000) {
			$convert_reaction = round(floor($unit / 100000000), 1);
			$reaction_suffix = 'B';
		}else if($unit >= 1000000000){
			$convert_reaction = round(floor($unit / 1000000000), 1);
			$reaction_suffix = 'T';
		}

		return $convert_reaction.''.$reaction_suffix;
	}
	
	
}

Settings::init(true);