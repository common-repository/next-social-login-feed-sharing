<?php namespace themeDevSocial\Apps\Providers;if(!defined('ABSPATH'))die('Forbidden');use \themeDevSocial\Apps\Settings as Settings;class Instagram extends Settings{private $api_data='';private $api_key='';private $api_secret='';private $access_token='';private $user_id='themedev2019';protected $apiBaseUrl='https://api.instagram.com/v1/';protected $authorizeUrl='https://api.instagram.com/oauth/authorize/';protected $accessTokenUrl='https://api.instagram.com/oauth/access_token';protected $apiDocumentation='https://www.instagram.com/developer/authentication/';protected $profileUrlTemplate='https://www.instagram.com/%s';private $scope=[];private $callback='';public function __construct($load=true){if($load){$this->api_data=parent::__get_api_data('instagram');$this->api_key=isset($this->api_data['id'])?$this->api_data['id']:'';$this->api_secret=isset($this->api_data['secret'])?$this->api_data['secret']:'';$this->callback=get_site_url().'/wp-json/next-social-login/provider/instagram';}}public function api_authorise(){$config=['enabled'=>true,'callback'=>$this->callback,'keys'=>['id'=>$this->api_key,'secret'=>$this->api_secret],];$adapter=new \themeDevSocialNext\Providers\Instagram($config);return $adapter;}}