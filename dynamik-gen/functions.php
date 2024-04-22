<?php
/**
 * Requires (pulls in) the initializing functions of Dynamik
 * which are found in the /lib/init.php file.
 *
 * @package Dynamik
 */
 
/**
 * Include Genesis theme files
 */
require_once( get_template_directory() . '/lib/init.php' );

/**
 * Include Dynamik theme files
 */
require_once( get_stylesheet_directory() . '/lib/init.php' );
function my_enqueue($hook) {
    wp_enqueue_script('my_custom_script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-browser/0.1.0/jquery.browser.js');
}

add_action('admin_enqueue_scripts', 'my_enqueue');

add_filter( 'wpseo_robots', 'my_robots_func' );
function my_robots_func( $robotsstr ) {
	if ( is_paged() ) {
		return 'noindex,nofollow';		
	}
	return $robotsstr;
}