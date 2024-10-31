<?php namespace themeDevSocial\Apps\Counters;if(!defined('ABSPATH'))die('Forbidden');use \themeDevSocial\Apps\Settings as Settings;use \themeDevSocialNext\Providers\Abst\Util as Util;use \themeDevSocialNext\Providers\Abst\Curl as Curl;class Instagram extends Settings{private $api_data='';private $api_key='';private $api_secret='';private $access_token='';private $user_id='d_desks';protected $apiBaseUrl='https://api.instagram.com/v1/';protected $authorizeUrl='https://api.instagram.com/oauth/authorize/';protected $accessTokenUrl='https://api.instagram.com/oauth/access_token';protected $profileUrlTemplate='https://www.instagram.com/%s';private $callback='';private $token='';private $token_data='';private $curl;public function __construct($load=true){if($load){$this->api_data=parent::__get_api_data_counter('instagram');$this->api_key=isset($this->api_data['id'])?$this->api_data['id']:'';$this->api_secret=isset($this->api_data['secret'])?$this->api_data['secret']:'';$this->user_id=isset($this->api_data['user_id'])?$this->api_data['user_id']:$this->user_id;$this->token_data=isset($this->api_data['token'])?$this->api_data['token']:$this->token;$this->callback=get_site_url().'/wp-admin/admin.php?page=next-social-counter&tab=providers&type=instagram';$this->curl=new Curl();}}public function __get_accesstoken(){if(strlen(trim($this->token_data))>5){$this->token=trim($this->token_data);return $this->token;}$tokenData=get_transient('_next_social_access_token');$dataToken=isset($tokenData['instagram_token'])?$tokenData['instagram_token']:'';$get_transient_time=get_transient('timeout__next_social_access_token');if($get_transient_time<time()||empty(trim($dataToken))){$access_tok=parent::_get_social_services('social_token');if(isset($access_tok['data'])){set_transient('_next_social_access_token',$access_tok['data'],parent::$cache*60*60);}}$tokenData=get_transient('_next_social_access_token');$this->token=isset($tokenData['instagram_token'])?$tokenData['instagram_token']:'';return $this->token;}public function __get_follower_data(){if(strlen(trim($this->token_data))<5){return $this->__like_counter();}if(strlen($this->token)>5){$header=['Authorization'=>sprintf('Bearer %s',$this->token),'Content-Type'=>'application/json',];$body=[];try{$explodeUs=explode('.',$this->token);$id=current($explodeUs);$url=$this->apiBaseUrl.'users/'.$id.'?access_token='.$this->token;$reoponse=$this->curl->request($url,'GET',$body,$header);$reoponse=@json_decode($reoponse,true);if(isset($reoponse['data']['counts']['followed_by'])){return (int) $reoponse['data']['counts']['followed_by'];}return 0;}catch(Exception $e){return $this->__like_counter();}}return $this->__like_counter();}private function __like_counter(){try{$counter='';$url='http://instagram.com/'.$this->user_id.'#';$get_request=wp_remote_get($url,array('timeout'=>20));$the_request=wp_remote_retrieve_body($get_request);$pattern="/followed_by\":[ ]*{\"count\":(.*?)}/";if(is_string($the_request)&&preg_match($pattern,$the_request,$matches)){$counter=intval($matches[1]);}return (int) $counter;}catch(Exception $e){return 0;}}public function __api_authorise(){$params=['response_type'=>'code','client_id'=>$this->api_key,'scope'=>'basic','redirect_uri'=>$this->callback,];$url=$this->authorizeUrl.'?'.http_build_query($params);Util::redirect($url);}public function __get_accesstoken_generate($get_code=''){$credentials=$this->api_key.':'.$this->api_secret;$toSend=base64_encode($credentials);$header=['Authorization'=>'Basic '.$toSend,'Content-Type'=>'application/x-www-form-urlencoded;charset=UTF-8'];$body=['grant_type'=>'authorization_code','code'=>$get_code,'client_id'=>$this->api_key,'client_secret'=>$this->api_secret,'redirect_uri'=>$this->callback];$reoponse=$this->curl->request($this->accessTokenUrl,'POST',$body,$header);$reoponse=@json_decode($reoponse,true);if(isset($reoponse['access_token'])){return $reoponse['access_token'];}return $this->token_data;}}