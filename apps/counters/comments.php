<?php
namespace themeDevSocial\Apps\Counters;

if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

class Comments{
	
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
	 */
	
	
	/**
     * Method: __construct
     * Method Description: load services
     * @since 1.0.0
     * @access private
	 */
	public function __construct($load = true){
		if($load){
			
        }
	}

    /**
     * Method: get_access_token
     * Method Description: Get Access Token
     * @since 1.0.0
     * @access public
	 */
    
     public function __get_accesstoken(){
		return true;
     }

     /**
     * Method: __get_follower_data
     * Method Description: Get Followers Info
     * @since 1.0.0
     * @access public
	 */
    
    
	public function __get_follower_data(){
		$comments_count = wp_count_comments();
		return (int) $comments_count->approved;
	}
	
}