<?php
 /**
 * Next Authentication PHP Script
 * Method Description: Here is 13 social provider for authentication.
 * @develop: themeDev 
 * @company URL: themedev.net 
 * @since 1.0.0
 * @access public
 */
if(!function_exists('themedev_next_autoload_class')){
	function themedev_next_autoload_class( $load_class ){
		if ( 0 !== strpos( $load_class, 'themeDevSocialNext' ) ) {
            return;
        }
        $file_name = strtolower(
								preg_replace(
									[ '/\bthemeDevSocialNext\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
									[ '', '$1-$2', '-', DIRECTORY_SEPARATOR],
									$load_class
								)
							);
       
		$file = __DIR__ .'/'. $file_name . '.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
        }
	}
}

spl_autoload_register( 'themedev_next_autoload_class' );


