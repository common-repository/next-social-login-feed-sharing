<?php
namespace themeDevSocialNext\Providers\Abst;

Abstract class Abstractnext{
	
	protected $api_key = ''; 
	
	protected $api_secret = ''; 
	
	protected $apiBaseUrl = '';

    protected $authorizeUrl = '';

    protected $accessTokenUrl = '';

    protected $apiDocumentation = '';

    protected $profileUrlTemplate = '';
	
	protected $scope = [];
	
	protected $callback = '';
	
	protected $fields = '';
	
	public function nx_authorise(){
		return false;
	}
	
	protected function authorise_api(){
		return false;
	}
	
	protected function get_api_data(){
		return false;
	}
	
	public function is_connected(){
		return false;
	}
	public function getUserProfile(){
		return false;
	}
	
	public function getAccessToken(){
		return false;
	}
	
	public function getAccessCode(){
		return false;
	}
	
	public function getUser($access_token = ''){
		return false;
	}
}