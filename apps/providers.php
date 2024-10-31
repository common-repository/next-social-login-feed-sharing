<?php
namespace themeDevSocial\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

include( NEXT_SOCIAL_FEED_PLUGIN_PATH .'apps/providers/lib/next/next-autoload.php');

use \themeDevSocial\Apps\Settings as Settings;
use \themeDevSocialNext\Providers\Abst\Util as Util;

class Providers extends Settings{
	
	 private $provider;
	 
	 // general option
	 private $getGeneral;
	 
	 // get global
	 private $getGlobal;
	 
	 // get provider
	 private $getProvider;
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
	 */
	public function __construct($load = true){
		if($load){
			// load api
			add_action('init', [ $this, 'next_rest_api']);
			
			// load usr  login
			$this->getGeneral = get_option( parent::$general_key );
			
			$this->getGlobal = get_option( parent::$global_key );
			
			$this->getProvider = get_option( parent::$provider_key );
		}
	}
	/**
     * Method: next_rest_api
     * Method Description: Connect Rest Api
     * @since 1.0.0
     * @access public
	 */
	public function next_rest_api(){
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'next-social-login', '/provider/(?P<data>\w+)/',
			array(
				'methods' => 'GET',
				'callback' => [ $this, 'next_rest_api_callback'],
			  ) 
		  );
		} );
	}
	/**
     * Method: next_rest_api_callback
     * Method Description: Callback Rest Api
     * @since 1.0.0
     * @access public
	 */
	public function next_rest_api_callback( \WP_REST_Request $request ){		
		
		$user_check = apply_filters( 'determine_current_user', false );
		if($user_check){
			Util::redirect( home_url() );
		}
		
		$param = (string) isset($request['data']) ? $request['data'] : '';
		if(empty($param)){
			return __('Please select providers.', 'themedev-social-services');
		}
		$provide =  ucfirst($param);
		
		$checkProvider = get_option('__next_social_provider_services');
		if(!is_array($checkProvider)){
			return __('Please setup providers.', 'themedev-social-services');
		}
		
		if(in_array($param, array_keys($checkProvider))){
			$this->get_provider($param);
			
			$providerData = isset($this->getProvider['provider'][$param]) ? $this->getProvider['provider'][$param] : [];
			
			if(!isset($providerData['enable'])){
				return __('Please enable '.$param.' services.', 'themedev-social-services');
			}
			
			if( ! is_object($this->provider) ){	
				return __('Sorry invalid object.', 'themedev-social-services');
			}

			try{
				$adapter = $this->provider->api_authorise();
				$adapter->nx_authorise();
				if($adapter->is_connected()):
					$tokens = $adapter->getAccessToken();
					$getProfile = $adapter->getUserProfile();
					//var_dump($getProfile);
					if(is_object($getProfile) && isset($getProfile->identifier) > 0){
						$identifier = isset($getProfile->identifier) ? $getProfile->identifier : time();
						$displayName = isset($getProfile->displayName) ? $getProfile->displayName : '';
						$firstName = isset($getProfile->firstName) ? $getProfile->firstName : '';
						$lastName = isset($getProfile->lastName) ? $getProfile->lastName : '';
						$description = isset($getProfile->description) ? $getProfile->description : '';
						$emailVerified = isset($getProfile->emailVerified) ? $getProfile->emailVerified : false;
						$email = isset($getProfile->email) ? $getProfile->email : $identifier;
						
						if(empty(trim($email))){
							return __('Email could\'t found. Please give permission in app settings.', 'themedev-social-services');
						}
						
						
						$redirectEnable = isset($this->getGlobal['global']['custom']['enable']) ? 'Yes' : 'No' ;
						$redirectPage = isset($this->getGlobal['global']['custom']['page']) ? $this->getGlobal['global']['custom']['page'] : home_url();
						if($redirectPage == 'custom-page'){
							$redirectPage = isset($this->getGlobal['global']['custom']['url']) ? $this->getGlobal['global']['custom']['url'] : home_url();
						}else if($redirectPage == 'current-page'){
							$redirectPage = get_option('__next_social_current_redirect_page', home_url());
						}
						if($redirectEnable == 'No'){
							$redirectPage = home_url();
						}
						// check email address
						if( email_exists($email) ){
							$userId = email_exists($email);
							wp_set_password( $identifier , $userId);
							
							$user = get_user_by( 'email', $email );
							$login = [];
							$login['user_login'] = isset($user->user_login) ? $user->user_login : '';
							$login['user_password'] = $identifier;
							$login['remember'] = true;
							
							if($this->user_login($login)){
								Util::redirect($redirectPage);
							}
							
						}else{
							$role = isset($this->getGeneral['general']['user']['role']) ? $this->getGeneral['general']['user']['role'] : 'subscriber';
							
							$userdata = [];
							$userdata['user_nicename'] = strlen($firstName) > 0 ? $firstName : $displayName;
							$userdata['display_name'] = strlen($displayName) > 0 ? $displayName : $firstName. ' ' .$lastName;
							$userdata['first_name'] = $firstName;
							$userdata['last_name'] = $lastName;
							$userdata['description'] = $description;
							$userdata['user_email'] = $email;
							$userdata['role'] = $role;
							$userdata['user_login'] = current(explode('@', $email));
							$userdata['user_pass'] = $identifier;
							if( strlen($userdata['user_login']) < 3){
								$userdata['user_login'] = $identifier;
							}
							
							$login = [];
							$login['user_login'] = $userdata['user_login'];
							$login['user_password'] = $identifier;
							$login['remember'] = true;
							
							$user_status = (int) $this->user_register($userdata);
							if($user_status > 0){
								update_user_meta($user_status, '_next_social_identifier', $identifier);
								update_user_meta($user_status, '_next_social_email', $email);
								update_user_meta($user_status, '_next_social_login_user', $userdata['user_login']);
								
								if($this->user_login($login)){
									
									Util::redirect($redirectPage);
								}
								
							}else{
								if($this->user_login($login)){
									Util::redirect($redirectPage);
								}
							}
						}
						
						return __('Sorry! system error.', 'themedev-social-services');
					}
				endif;
					
			}catch(\Exception $e){
				echo __('Oops, callback error! ' . $e->getMessage(), 'themedev-social-services');
			}
			
			return '';
		}
		return __('Invalid Authentication', 'themedev-social-services');
	}	
	/**
     * Method: get_provider
     * Method Description: Get Provider
     * @since 1.0.0
     * @access private
	 */
	
	private function get_provider($param){
		if(!file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/providers/'.$param.'.php' )){
			return '';
		}
		if($param == 'facebook'){
			$this->provider = new \themeDevSocial\Apps\Providers\Facebook(true);	
		}else if($param == 'github'){
			$this->provider = new \themeDevSocial\Apps\Providers\Github(true);
		}else if($param == 'twitter'){
			$this->provider = new \themeDevSocial\Apps\Providers\Twitter(true);
		}else if($param == 'wordpress'){
			$this->provider = new \themeDevSocial\Apps\Providers\Wordpress(true);
		}else if($param == 'linkedin'){
			$this->provider = new \themeDevSocial\Apps\Providers\Linkedin(true);
		}else if($param == 'instagram'){
			$this->provider = new \themeDevSocial\Apps\Providers\Instagram(true);
		}else if($param == 'dribbble'){
			$this->provider = new \themeDevSocial\Apps\Providers\Dribbble(true);
		}else if($param == 'google'){
			$this->provider = new \themeDevSocial\Apps\Providers\Google(true);
		}else if($param == 'bitbucket'){
			$this->provider = new \themeDevSocial\Apps\Providers\Bitbucket(true);
		}else if($param == 'yandex'){
			$this->provider = new \themeDevSocial\Apps\Providers\Yandex(true);
		}else if($param == 'vkontakte'){
			$this->provider = new \themeDevSocial\Apps\Providers\Vkontakte(true);
		}else if($param == 'reddit'){
			$this->provider = new \themeDevSocial\Apps\Providers\Reddit(true);
		}else if($param == 'envato'){
			$this->provider = new \themeDevSocial\Apps\Providers\Envato(true);
		}else if($param == 'pinterest'){
			$this->provider = new \themeDevSocial\Apps\Providers\Pinterest(true);
		}else if($param == 'mailchimp'){
			$this->provider = new \themeDevSocial\Apps\Providers\Mailchimp(true);
		}
		return $this->provider;
	}
	
	/**
     * Method: user_register
     * Method Description: User Register
     * @since 1.0.0
     * @access private
	 */
	 
	 private function user_register( $data ){
		$userId = wp_insert_user( $data ) ;
		if ( is_wp_error( $userId ) ) {
			$userId = 0;
		}
		return $userId;
	 }
	 
	 /**
     * Method: user_login
     * Method Description: User Login
     * @since 1.0.0
     * @access private
	 */
	 
	 public function user_login( $data ){
		return wp_signon($data);
	 }
}