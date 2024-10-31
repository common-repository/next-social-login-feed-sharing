<?php
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Plugin Name: Next Social
 * Description: Next Social for Social Login, Social Counter and Feed Sharing. Providers - Facebook, Google, Twitter, Linkedin, GitHub, BitBucket, Dribble, Wordpress, Instagram, Envato, Pinterest, Mailchimp, Yandex.
 * Plugin URI: http://products.themedev.net/next-social/
 * Author: ThemeDev
 * Version: 5.0.3
 * Author URI: http://themedev.net/
 *
 * Text Domain: themedev-social-services
 *
 * @package NextSocial 
 * @category Free
 * Domain Path: /languages/
 * License: GPL2+
 */
/**
 * Defining static values as global constants
 * @since 1.0.1
 */
define( 'NEXT_SOCIAL_FEED_VERSION', '5.0.3' );
define( 'NEXT_SOCIAL_FEED_PREVIOUS_STABLE_VERSION', '5.0.2' );

define( 'NEXT_SOCIAL_FEED_KEY', 'themedev-social-services' );

define( 'NEXT_SOCIAL_FEED_DOMAIN', 'themedev-social-services' );

define( 'NEXT_SOCIAL_FEED_FILE_', __FILE__ );
define( "NEXT_SOCIAL_FEED_PLUGIN_PATH", plugin_dir_path( NEXT_SOCIAL_FEED_FILE_ ) );
define( 'NEXT_SOCIAL_FEED_PLUGIN_URL', plugin_dir_url( NEXT_SOCIAL_FEED_FILE_ ) );

// initiate actions
add_action( 'plugins_loaded', 'themedev_social_load_plugin_textdomain' );
/**
 * Load eBay Search textdomain.
 * @since 1.0.0
 * @return void
 */
function themedev_social_load_plugin_textdomain() {
	load_plugin_textdomain( 'themedev-social-services', false, basename( dirname( __FILE__ ) ) . '/languages'  );

	// add action page hook
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'themedev_social_action_links' );

	// document button
	add_filter( 'plugin_row_meta', 'themedev_social_plugin_row_meta', 10, 2 );

	/**
	 * Load Next Review Loader main page.
	 * @since 1.0.0
	 * @return plugin output
	 */
	do_action( 'nextsocial/loaded' );

	require_once(NEXT_SOCIAL_FEED_PLUGIN_PATH.'init.php');
	new \themeDevSocial\Init();
}


// added custom link
function themedev_social_action_links($links){
	$links[] = '<a href="' . admin_url( 'admin.php?page=next-social-login' ).'"> '. __('Settings', 'themedev-social-services').'</a>';
	return $links;
}



function themedev_social_plugin_row_meta(  $links, $file ){
	if ( strpos( $file, basename( __FILE__ ) ) ) {
		$new_links = array(
			'demo' => '<a href="http://products.themedev.net/next-social/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
			'doc' => '<a href="http://support.themedev.net/docs-category/next-social/" target="_blank"><span class="dashicons dashicons-media-document"></span>User Guideline</a>',
			'support' => '<a href="http://support.themedev.net/support-tickets/" target="_blank"><span class="dashicons dashicons-editor-help"></span>Support</a>',
			'pro' => '<a href="http://products.themedev.net/next-social/pricing/" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>'
		);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}


