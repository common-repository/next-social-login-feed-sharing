<?php namespace themeDevSocial\Apps\Providers;if(!defined('ABSPATH'))die('Forbidden');use \themeDevSocial\Apps\Settings as Settings;class Linkedin extends Settings{private $api_data='';private $api_key='';private $api_secret='';private $access_token='';private $user_id='themedev2019';protected $apiBaseUrl='https://api.linkedin.com/v1/';protected $authorizeUrl='https://www.linkedin.com/oauth/v2/authorization';protected $accessTokenUrl='https://www.linkedin.com/oauth/v2/accessToken';protected $apiDocumentation='https://developer.linkedin.com/docs/oauth2';protected $profileUrlTemplate='https://www.linkedin.com/in/';private $scope=[];private $callback='';public function __construct($load=true){if($load){$this->api_data=parent::__get_api_data('linkedin');$this->api_key=isset($this->api_data['id'])?$this->api_data['id']:'';$this->api_secret=isset($this->api_data['secret'])?$this->api_data['secret']:'';$this->callback=get_site_url().'/wp-json/next-social-login/provider/linkedin';}}public function api_authorise(){$config=['enabled'=>true,'callback'=>$this->callback,'keys'=>['id'=>$this->api_key,'secret'=>$this->api_secret]];$adapter=new \themeDevSocialNext\Providers\Linkedin($config);return $adapter;}}