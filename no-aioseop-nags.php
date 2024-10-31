<?php
/*
Plugin Name:NO admin premium NAGS - please
Description: A simple plugin, that stops the abusive admin area premium nags / the spam from AISEO and YOAST. Plus: add your custom Admin CSS
Author: Eilert Behrends
Author URI: https://kontur.us
Version: 3.4
Text Domain: no-aioseop-nags
Domain Path: /languages/
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/


// Exit If Accessed Directly
if ( ! defined( 'ABSPATH' ) ) exit;


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { exit; }

/*------------------------------------------*/
/*			Plugin Setup Functions			*/
/*------------------------------------------*/

// Add Admin Sub Menu: Appearance > Admin CSS MU
function no_aioseop_nags_add_menu_links() {
	if ( is_multisite() ) {
		if ( get_current_blog_id() == SITE_ID_CURRENT_SITE ) {
			 global $page_hook_suffix;
$page_hook_suffix = add_theme_page ( __('<b>NO premium NAGS</b>','no-aioseop-nags'), __('<span class="dashicons-superhero dashicons"  style="color: rgb(176, 120, 184);"></span> <b>NO premiuem NAGS</b>','no-aioseop-nags'), 'manage_options', 'no-aioseop-nags','no_aioseop_nags_admin_interface_render'  ); 
		}
	}
	else {
         global $page_hook_suffix;
        
		$page_hook_suffix = add_theme_page ( __('<b>NO premium NAGS</b>','no-aioseop-nags'), __('<span class="dashicons-superhero dashicons"   style="color: rgb(176, 120, 184);"></span> <b>NO premium NAGS</b>','no-aioseop-nags'), 'manage_options', 'no-aioseop-nags','no_aioseop_nags_admin_interface_render'  );
	}
}
add_action( 'admin_menu', 'no_aioseop_nags_add_menu_links' );




// Print Direct Link To Options Page In Plugins List
function no_aioseop_nags_settings_link( $links ) {
	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=no-aioseop-nags' ) . '">' . __( '>> Settings', 'no-aioseop-nags' ) . '</a>',
            'Support' => '<a href="https://wordpress.org/support/plugin/no-aioseop-nags/">' . __( '<b>Support</b>', 'no-aioseop-nags' ) . '</a>',
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'no_aioseop_nags_settings_link' );


// Add Links to Plugins list
function no_aioseop_nags_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'no-aioseop-nags.php' ) !== false ) {
		$new_links = array(
				'donate' => '<a href="https://www.paypal.com/paypalme/werbekontur/3EUR" target="_blank">' . __( 'Donate?', 'no-aioseop-nags' ) . '</a>',
				'hireme' 	=> '<a href="https://wordpress.org/support/plugin/no-aioseop-nags/reviews/?rate=5#new-post" target="_blank">' . __( 'Rate this Plugin', 'no-aioseop-nags' ) . '</a>',
				);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'no_aioseop_nags_plugin_row_meta', 10, 2 ); 


// Load Text Domain
function no_aioseop_nags_load_plugin_textdomain() {
    load_plugin_textdomain( 'no-aioseop-nags', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    $strong ='<strong>';
}
add_action( 'plugins_loaded', 'no_aioseop_nags_load_plugin_textdomain' );


// Register Settings
function no_aioseop_nags_register_settings() {
	   
// 1.
        register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_custom_css', 'no_aioseop_nags_admin_css', 'no_aioseop_nags_clean_css_with_csstidy' );
 
// 2.   CHECK: BLOCK AIOSEO = no_aioseop_nags_custom_css-checkbox
    	register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_custom_css-checkbox' ,  array(
        'type' => 'string',   
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
// 3.   INPUT: CUSTOM CSS = no_aioseop_nags_your_custom_css
        register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_your_custom_css' ,  array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => NULL,
    ) );
// 4.    CHECK: USE CUSTOM ADMIN CSS      = no_aioseop_nags_your_custom-checkbox
      	 register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_your_custom-checkbox' ,  array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
// 5.    CHECK: HIDE AIOSEO Adminbar menu = no_aioseop_nags_menu-checkbox
       	 register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_menu-checkbox' ,  array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
// 6.    CHECK: BLOCK YOAST no_aioseop_nags_yoast    
        register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_yoast' ,  array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
 
 // 7.   CHECK: BLOCK ALL NOTIFICATIONS  
         register_setting( 'no_aioseop_nags_settings_group', 'no_aioseop_nags_all_messages' ,  array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    
    
}
add_action( 'admin_init', 'no_aioseop_nags_register_settings' );



/*------------------------------------------*/
/*			Defaults		*/
/*------------------------------------------*/



// We set our default values here
if ( !function_exists( 'no_aioseop_nags_default_values' ) ) {
function no_aioseop_nags_default_values(){



    if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
    {
     add_action( 'admin_init', 'check_for_aioseo_plugin' );

//  Form settings defaults
     
      // enable the blocking
     add_option( 'no_aioseop_nags_custom_css-checkbox' , '1' );

     // enable custom css
     add_option( 'no_aioseop_nags_your_custom-checkbox' , '1' );

     // do not disable the AIOSEO menu by default  
     add_option( 'no_aioseop_nags_menu-checkbox' , '0' );
     add_option( 'no_aioseop_nags_all_messages' , '0' );

     
    }
    
       else { // Form settings defaults
        
        // enable the blocking
        add_option( 'no_aioseop_nags_custom_css-checkbox' , '0' );
        
        // enable custom css
        add_option( 'no_aioseop_nags_your_custom-checkbox' , '1' );
        
        // do not disable the menu by default  
        add_option( 'no_aioseop_nags_menu-checkbox' , '0' );}
    

    
    
}
add_action( 'no_aioseop_nags_default_options', 'no_aioseop_nags_default_values' );
}


// YOAST defaults


// We set our default values here
if ( !function_exists( 'no_yoast_nags_default_values' ) ) {
function no_yoast_nags_default_values(){


  
// avoid plugin_active errors for AIOSEO

 

    
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) )  { 
      
      // enable yoast  
       add_option( 'no_aioseop_nags_yoast' , '1' );
        }    
    
     else {      // enable yoast  
        add_option( 'no_aioseop_nags_yoast' , '0' );}
    
  

 
    
    
}
add_action( 'no_yoast_nags_default_options', 'no_yoast_nags_default_values' );
}


/**
*  Activate
*
*
* @since    1.0.0
*/
if ( !function_exists( 'no_aioseop_nags_activation' ) ) {
function no_aioseop_nags_activation(){
    do_action( 'no_aioseop_nags_default_options' );
    do_action( 'no_yoast_nags_default_options' );
}
register_activation_hook( __FILE__, 'no_aioseop_nags_activation' );

}

/**
 * Add plugin version to database
 *
 * @since 		1.0
 * @constant 	no_aioseop_nags_VERSION_NUM		the version number of the current version
 * @refer		https://codex.wordpress.org/Creating_Tables_with_Plugins#Adding_an_Upgrade_Function
 */
if (!defined('no_aioseop_nags_VERSION_NUM'))
    define('no_aioseop_nags_VERSION_NUM', '3.1');
// update_option('abl_no_aioseop_nags_version', no_aioseop_nags_VERSION_NUM);	// Disabled to set default values 

define( 'no_aioseop_nags__MINIMUM_WP_VERSION', '5.5' );
define( 'no_aioseop_nags___MINIMUM_PHP_VERSION', '7.0' );



/**
 * Check if the version of WordPress in use on the site is supported.
 */
if ( version_compare( $GLOBALS['wp_version'], no_aioseop_nags__MINIMUM_WP_VERSION, '<' ) ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			sprintf(
				/* translators: Placeholders are numbers, versions of WordPress in use on the site, and required by WordPress. */
				esc_html__( 'Your version of WordPress (%1$s) is lower than the version required by No aioseo -nags (%2$s). Please update your WordPress.', 'no_aioseop_nags' ),
				$GLOBALS['wp_version'],
				no_aioseop_nags__MINIMUM_WP_VERSION
			)
		);
	}

	/**
	 * Outputs for an admin notice about running kontur Admin Style on outdated WordPress.
	 *
	 * @since 1.0.0
	 */
	function kontur_admin_style_admin_unsupported_wp_notice() { ?>
<div class="notice notice-error is-dismissible">
    <p><?php esc_html_e( 'No aioseo -nags  requires a more recent version of WordPress and has been paused.', 'kontur-admin-style' ); ?><br><strong><?php esc_html_e( 'Please update your WordPress to continue using No aioseo -nags.', 'no_aioseop_nags' ); ?></strong></p>
</div>
<?php
	}

	add_action( 'admin_notices', 'kontur_admin_style_admin_unsupported_wp_notice' );
	return;
}


/**
 * Set default values for CSS 
 *
 * @since	1.0
 */
if ( is_multisite() ) {
	$installed_ver = get_blog_option( SITE_ID_CURRENT_SITE, 'abl_no_aioseop_nags_version' );
}
else {
	$installed_ver = get_option( 'abl_no_aioseop_nags_version' );
};

if ($installed_ver == '' ) {
	if ( is_multisite() ) {
		$no_aioseop_nags_custom_css_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_custom_css-checkbox' );
        $no_aioseop_nags_yoast_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_yoast' );
	}
	else {
		$no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
        $no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
	}
	
	// All CSS loaded by default
	
   
	
	if ( is_multisite() ) {
		update_blog_option(SITE_ID_CURRENT_SITE, 'no_aioseop_nags_custom_css-checkbox', $no_aioseop_nags_custom_css_option);
		update_blog_option(SITE_ID_CURRENT_SITE, 'abl_no_aioseop_nags_version', no_aioseop_nags_VERSION_NUM);
	}
	else {
		update_option('no_aioseop_nags_custom_css-checkbox', $no_aioseop_nags_custom_css_option);
		update_option('abl_no_aioseop_nags_version', no_aioseop_nags_VERSION_NUM);
	}
};


/*--------------------------------------*/
/*			Admin Options Page			*/
/*--------------------------------------*/


/*
* Disable Dashboard Spam
*/
 $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
if ( 1 == $no_aioseop_nags_custom_css_option )   { 
function aioseo_disable_dashboard_widget( $enabled ) {
   return false;
}
    function aioseo_filter_metabox_priority( $priority) {
   return 'low';
}

add_filter( 'aioseo_show_seo_news', 'aioseo_disable_dashboard_widget' );



add_filter( 'aioseo_post_metabox_priority', 'aioseo_filter_metabox_priority' );

}


/*Disable Editor SPAM */

add_action( 'admin_head', 'no_aioseop_nags_no_editor_spam' );

function no_aioseop_nags_no_editor_spam(){
  

	echo '<style type="text/css">

	.edit-post-fullscreen-mode-close.components-button {
	display: flex;
	align-items: center;
	align-self: stretch;
	border: none;
	background:red; border-color:#6d6e6f!important;
	color: #fff;
	box-shadow:none;
	border-radius: 0;
	height: 61px;
	width: 60px;
	position: relative;
	margin-bottom: -1px;
	}

.edit-post-fullscreen-mode-close.components-button svg{
display: none;
}
#aioseo-post-settings-metabox > div > div.aioseo-app.aioseo-post-settings > div.aioseo-tabs.internal > div.tabs-scroller > div > div > div:nth-child(4){
	display: none;
}

#aioseo-post-settings-sidebar-vue > div > div > div > a:nth-child(4),
#aioseo-post-settings-sidebar-vue > div > div > div > a:nth-child(3),
#aioseo-post-settings-sidebar-vue > div > div > div > a:nth-child(5)
{
	display: none;
}



}
    

	</style>';

}





/*
* Disable the AIOSEO Admin Menu
*/


 $no_aioseop_nags_menu_checkbox_option = get_option( 'no_aioseop_nags_menu-checkbox', '1' );
if (  1 == $no_aioseop_nags_menu_checkbox_option  ) { 

  add_filter( 'aioseo_show_in_admin_bar', 'aioseo_disable_admin_bar' );

function aioseo_disable_admin_bar( $enabled ) {
   return false;
}
}

  
/*
* Load the AIOSEO blocking CSS
*/


// Add AIOSEO Sub Menu


function get_support_css() {
   $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
  // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    
    if ( ! function_exists( 'is_plugin_active' ) ) {
  if ( is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') ) { 
      if ( 1 != $no_aioseop_nags_custom_css_option ) { 

  
 wp_register_style('get_support_css', plugins_url('/includes/no-aioseop-nags-info-style_v34.css',__FILE__));
        wp_enqueue_style( 'get_support_css');
	
}

// remove support css
else {
    
    
    add_action( 'wp_enqueue_scripts', 'remove_get_support_css_stylesheet', 20 );
    function remove_get_support_css_stylesheet() {
    wp_deregister_style( 'get_support_css' );
    wp_dequeue_style( 'get_support_css', 11);}

}    

   }  
 } 
} 

 add_action('wp_enqueue_scripts', 'get_support_css'); 
 add_action('admin_enqueue_scripts', 'get_support_css'); 








// AIOSEO Blocking enabled, but Menu is active

if ( 1 == $no_aioseop_nags_custom_css_option ) { 
       function get_support_link_1($wp_admin_bar) 
 {
 
        $nonags_disable_menu =  __('Disable this menu?', 'no-aioseop-nags');
        $nonags_disable_menu_hint =  __('Click to disable', 'no-aioseop-nags');
         $args = array(
        'id' => 'kontur_us-spam-stop',
        'title' =>  $nonags_disable_menu, 
        'href' => admin_url( 'admin.php?page=no-aioseop-nags' ), 
        'parent' => 'aioseo-main', 
        'meta' => array(
        'class' => 'n1', 
         'title' => $nonags_disable_menu_hint ,
      )
   );
   $wp_admin_bar->add_node($args);
           function add_get_support_link_01_stylesheet() {
        wp_register_style('get_support_link_01', plugins_url('/includes/no-aioseop-nags-info-style_active_v34.css',__FILE__));
        wp_enqueue_style( 'get_support_link_01');
    }
            add_action( 'wp_enqueue_scripts', 'add_get_support_link_01_stylesheet', 20 );
}

add_action('admin_bar_menu', 'get_support_link_1', 2000); 
    
    }

else {
    
    
    add_action( 'wp_enqueue_scripts', 'remove_get_support_link_01_stylesheet', 20 );
    function remove_get_support_link_01_stylesheet() {
    wp_deregister_style( 'get_support_link_01' );
    wp_dequeue_style( 'get_support_link_01', 11);}

}


// AIOSEO is spaming
  
    

if ( 1 != $no_aioseop_nags_custom_css_option ) { 
       function get_support_link_23($wp_admin_bar) 
 { // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') ) { 
        $nonags_disable_menu_spam =  __('Click here to STOP - <br>the Upgrade-SPAM', 'no-aioseop-nags');
         $args = array(
        'id' => 'kontur_us-spam-stop',
        'title' =>   $nonags_disable_menu_spam, 
        'href' => admin_url( 'admin.php?page=no-aioseop-nags' ),
        'parent' => 'aioseo-main', 
        'meta' => array(
        'class' => 'no-admin-bar-nagging', 
         'title' =>  $nonags_disable_menu_spam ,
      )
   );
   $wp_admin_bar->add_node($args);
        wp_register_style('get_support_link_23', plugins_url('/includes/no-aioseop-nags-info-style_v34.css',__FILE__));
        wp_enqueue_style( 'get_support_link_23');
    
}
  }  

add_action('admin_bar_menu', 'get_support_link_23', 2000); 
    
    }

else {
    
    
    add_action( 'wp_enqueue_scripts', 'remove_get_support_link_23_stylesheet', 20 );
    function remove_get_support_link_23_stylesheet() {
    wp_deregister_style( 'get_support_link_23' );
    wp_dequeue_style( 'get_support_link_23', 11);}

}

// ADDING REMINDER FOR USERS TO ACTIVATE 


// Add AIOSEO Sub Menu


function no_aioseop_nags_add_menu_links_plug() {
   $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
    
  // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
  if ( is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') ) { 
      if ( 1 != $no_aioseop_nags_custom_css_option ) { 

  
           add_submenu_page(
          'aioseo',          // parent slug
          'No AIOSEO Nags',               // page title
          '<hr><b style="color: rgb(176, 120, 184); line-height:1.2; font-weight: 900;">' . __('Disable ', 'no-aioseop-nags') . '<br> '. __('the Pro-Upgrade Nags', 'no-aioseop-nags') . ' &#62; &#62; </b> <hr> ',               // menu title
          'manage_options',              // capability
          'no-aioseop-nags',
        'no_aioseop_nags_add_menu_links_plug' 
    );
	
}


   }  

} 

add_action( 'admin_menu', 'no_aioseop_nags_add_menu_links_plug', 2000 );


// Add YOAST Sub Menu


function no_aioseop_yoast_nags_add_menu_links_plug() {
     $no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
     // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
        if ( is_plugin_active( 'wordpress-seo/wp-seo.php') ) { 
            if ( 1 != $no_aioseop_nags_yoast_option ) { 

  
           add_submenu_page(
          'wpseo_dashboard',          // parent slug
          'No AIOSEO Nags',               // page title
          '<hr><b style="color: rgb(176, 120, 184); line-height:1.2; font-weight: 900;">' . __('Disable ', 'no-aioseop-nags') . '<br> '. __('the Pro-Upgrade Nags', 'no-aioseop-nags') . ' &#62; &#62;</b><hr> ',               // menu title
          'manage_options',              // capability
          'no-aioseop-nags',
        'no_aioseop_yoast_nags_add_menu_links_plug' 
    );
	
}


   }  


} 

add_action( 'admin_menu', 'no_aioseop_yoast_nags_add_menu_links_plug', 2000 );



// ACTIVATE AIOSEO SPAM BLOCKING

 $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
if ( 1 == $no_aioseop_nags_custom_css_option )   { 
function no_aioseop_nags_block_the_spam () {
    
          wp_register_style('no_aioseop_nags_block_the_spam', plugins_url('/includes/no_aioseop_nags_block_the_spam_v34.css',__FILE__));
        wp_enqueue_style( 'no_aioseop_nags_block_the_spam');
    
}
    
// custom js
add_action('admin_enqueue_scripts', 'kontur_no_nags_admin_js');
 
function kontur_no_nags_admin_js() {
  
 

    wp_enqueue_script('kontur_no_nags_admin_js', plugins_url('includes/no-nags-admin-options.js',__FILE__ ));
}
    

add_action('admin_enqueue_scripts', 'no_aioseop_nags_block_the_spam'); 

}

// ACTIVATE AIOSEO SPAM BLOCKING
 $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
if( $no_aioseop_nags_custom_css_option != '1' ) { 
function no_aioseop_nags_release_the_spam () {
    if( wp_script_is( 'no_aioseop_nags_block_the_spam', 'registered' ) ) {
     wp_dequeue_style( 'no_aioseop_nags_block_the_spam' );
    wp_deregister_style( 'no_aioseop_nags_block_the_spam' );
    wp_dequeue_style( 'no_aioseop_nags_block_the_spam', 11);
    
}add_action('admin_enqueue_scripts', 'no_aioseop_nags_release_the_spam'); 
}



}


// ACTIVATE YOAST SPAM BLOCKING 

 $no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
if ( 1 == $no_aioseop_nags_yoast_option )   { 
function no_nags_yoast_block_the_spam () {
    
          wp_register_style('no_nags_yoast_block_the_spam', plugins_url('/includes/no_nags_yoast_block_the_spam_v34.css',__FILE__));
        wp_enqueue_style( 'no_nags_yoast_block_the_spam');
    
}

add_action('admin_enqueue_scripts', 'no_nags_yoast_block_the_spam'); 

}

// DEACTIVATE YOAST SPAM BLOCKING 

 $no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
if( $no_aioseop_nags_yoast_option != '1' ) { 
function no_nags_yoast_release_the_spam () {
    if( wp_script_is( 'no_nags_yoast_block_the_spam', 'registered' ) ) {
          wp_dequeue_style( 'no_nags_yoast_block_the_spam' );
    wp_deregister_style( 'no_nags_yoast_block_the_spam' );
        wp_dequeue_style( 'no_nags_yoast_block_the_spam', 11);
    
}add_action('admin_enqueue_scripts', 'no_nags_yoast_release_the_spam'); 
}

}

// Admin Option GET THE LOOK

function my_no_nags_enqueue($hook) {
    global $page_hook_suffix;
    if( $hook != $page_hook_suffix )
        return;        
    wp_register_style('options_page_style', plugins_url('/includes/no_aioseop_nags_kontur-admin-options-style_v34.css',__FILE__));
    wp_enqueue_style('options_page_style');
         $custom_css = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
        $header_js  = wp_enqueue_code_editor( array( 'type' => 'application/javascript' ) );
        $footer_js  = wp_enqueue_code_editor( array( 'type' => 'application/javascript' ) );

        wp_add_inline_script(
            'code-editor',
            sprintf(
                'jQuery( function() {
                    wp.codeEditor.initialize( jQuery( "#no_aioseop_nags_your_custom_css" ), %1$s );
                });',
                wp_json_encode( $custom_css ),
                wp_json_encode( $header_js ),
                wp_json_encode( $footer_js )
            )
        );
    
}
add_action( 'admin_enqueue_scripts', 'my_no_nags_enqueue' );


// Admin Interface: Appearance 
function no_aioseop_nags_admin_interface_render () {

	if ( is_multisite() ) {
		$no_aioseop_nags_custom_css_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_custom_css-checkbox' );
        $no_aioseop_nags_your_custom_css_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_your_custom-checkbox' );
        $no_aioseop_nags_menu_checkbox_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_menu-checkbox' );
        $no_aioseop_nags_yoast_option = get_blog_option( get_current_blog_id(), 'no_aioseop_nags_yoast' );
        
        
	}
	else {
		$no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
        $no_aioseop_nags_your_custom_css_option = get_option( 'no_aioseop_nags_your_custom-checkbox' );
        $no_aioseop_nags_menu_checkbox_option = get_option( 'no_aioseop_nags_menu-checkbox' );
        $no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
	}
	
	
?>
<div class="wrap" id="knontur-no-nags" style="background:white; padding:15px;">

    <div class="wrap">
        <div style="width:60px; height:64px; vertical-align:top; display:inline-block;"><a href="https://kontur.us"><svg version="1.1" id="Ebene_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                    <style type="text/css">
                        .st0 {
                            fill: #FFFFFF;
                            stroke: #636363;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-miterlimit: 10;
                        }
                    </style>
                    <g id="mb-stern_x5F_10">
                    </g>
                    <g>
                        <path class="st0" d="M60.4,26.5h-4.2l-8.7-15.4c-0.5-0.9-1.8-1.6-2.8-1.6h-1.2l-2.7,8.4c0.8,0.3,1.5,0.8,1.9,1.5l6,10.7
		c0.5,0.9,0.5,2.4,0,3.3L42.4,44c-0.5,0.9-1.8,1.6-2.9,1.6l-7.8-0.1L29,53.7l15.1,0.1c1,0,2.3-0.7,2.9-1.6l8.7-14.7h4.6
		c1,0,1.9-0.9,1.9-1.9v-7.2C62.3,27.4,61.4,26.5,60.4,26.5z"></path>
                    </g>
                    <g>
                        <path class="st0" d="M24.4,43.8l-6.1-10.7c-0.5-0.9-0.5-2.4,0-3.3l6.3-10.6c0.5-0.9,1.8-1.6,2.9-1.6l6.4,0.1l2.7-8.2L22.8,9.3
		c-1,0-2.3,0.7-2.9,1.6l-9.2,15.6H3.8c-1,0-1.9,0.9-1.9,1.9v7.2c0,1,0.9,1.9,1.9,1.9h7.6l8.2,14.4c0.5,0.8,1.6,1.6,2.6,1.7l2.9-9.1
		C24.8,44.4,24.6,44.1,24.4,43.8z"></path>
                    </g>
                </svg></a></div>

        <img class="no-aioseo-picture" style="float: right; max-width:calc( 100% - 80px ); display:inline-block;" src="<?php echo plugin_dir_url( __FILE__ ).'includes/images/no-PREMIUM-nags.png'; ?>" alt="<?php esc_html_e('Stop the abusive "All in One SEO" Admin Area messages','no-aioseop-nags') ?>">
    </div>
    <hr style="clear:both;">
    <h1>
        <?php 
// Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
        <?php esc_html_e('Stop the abusive "All in One SEO" Admin Area messages','no-aioseop-nags') ?>
        <?php else: ?>
        <?php esc_html_e('Settings','no-aioseop-nags') ?>
        <?php endif ?>
    </h1>
    <hr>




    <form method="post" action="options.php" enctype="multipart/form-data">
        <div class="welcome-panel kontur-text-center" style="margin-top: 5px; padding:20px">





            <?php 
        
        
            $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
        if ( 1 != $no_aioseop_nags_custom_css_option ): ?>
            <?php 
    
    // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
            <h2><?php esc_html_e('Block the premium ads?','no-aioseop-nags') ?></h2><br><input type="checkbox" name="no_aioseop_nags_custom_css-checkbox" id="no_aioseop_nags_custom_css-checkbox" value="1" <?php if ( $no_aioseop_nags_custom_css_option )  { checked( '1', $no_aioseop_nags_custom_css_option ); } ?>>
            <label for="no_aioseop_nags_custom_css-checkbox" style="font-size:16px;"><?php esc_html_e('<- Check to block the nagging', 'no-aioseop-nags') ?></label>
            <?php else: ?>

            <?php endif ?>
            <?php else: ?>
            <?php 
    
    // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
            <br><input type="checkbox" name="no_aioseop_nags_custom_css-checkbox" id="no_aioseop_nags_custom_css-checkbox" value="1" <?php if ( $no_aioseop_nags_custom_css_option )  { checked( '1', $no_aioseop_nags_custom_css_option ); } ?>>
            <label for="no_aioseop_nags_custom_css" style="font-size:16px;"><?php esc_html_e('We are blocking the nagging ', 'no-aioseop-nags') ?></label>
            <?php else: ?>
            <br><input type="checkbox" name="no_aioseop_nags_custom_css-checkbox" id="no_aioseop_nags_custom_css-checkbox" value="1" <?php if ( $no_aioseop_nags_custom_css_option )  { checked( '1', $no_aioseop_nags_custom_css_option ); } ?>>
            <label for="no_aioseop_nags_custom_css" style="font-size:16px; color:rgb(159, 39, 39);font-weight:800;"><?php esc_html_e('<- Please uncheck this.', 'no-aioseop-nags') ?>
                <span style="font-size:16px;font-style: italic; color:#424242"><?php esc_html_e('You are not using All in one SEO. ', 'no-aioseop-nags') ?></span></label>
            <?php endif ?>
            <?php endif ?>



            <?php if ( 1 != $no_aioseop_nags_menu_checkbox_option ): ?>
            <?php 
    
    // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>

            <hr>
            <h2><?php esc_html_e('Disable SEO menu in WP-Admin Bar?','no-aioseop-nags') ?></h2>
            <br><input type="checkbox" name="no_aioseop_nags_menu-checkbox" id="no_aioseop_nags_menu-checkbox" value="1" <?php if ( $no_aioseop_nags_menu_checkbox_option )  { checked( '1', $no_aioseop_nags_menu_checkbox_option ); } ?>>
            <label for="no_aioseop_nags_menu-checkbox" style="font-size:16px;"><?php esc_html_e('<- Check to disable AIOSEO in the WP-Adminbar', 'no-aioseop-nags') ?></label>
            <?php else: ?>

            <?php endif ?>
            <?php else: ?>
            <?php 
    // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
            <hr>
            <br><input type="checkbox" name="no_aioseop_nags_menu-checkbox" id="no_aioseop_nags_menu-checkbox" value="1" <?php if ( $no_aioseop_nags_menu_checkbox_option )  { checked( '1', $no_aioseop_nags_menu_checkbox_option ); } ?>>
            <label for="no_aioseop_nags_menu-checkbox" style="font-size:16px;"><?php esc_html_e('The SEO admin bar menu is disabled ', 'no-aioseop-nags') ?></label>
            <?php else: ?>
            <hr>
            <br><input type="checkbox" name="no_aioseop_nags_menu-checkbox" id="no_aioseop_nags_menu-checkbox" value="1" <?php if ( $no_aioseop_nags_menu_checkbox_option )  { checked( '1', $no_aioseop_nags_menu_checkbox_option ); } ?>><label for="no_aioseop_nags_custom_css" style="font-size:16px; color:rgb(159, 39, 39);font-weight:800;"><?php esc_html_e('<- Please uncheck this.', 'no-aioseop-nags') ?>
                <span style="font-size:16px;font-style: italic; color:#424242"><?php esc_html_e('You are not using All in one SEO. ', 'no-aioseop-nags') ?></span></label>
            <?php endif ?>
            <?php endif ?>




            <?php 
        // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
 if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>


            <?php if ( 1 == $no_aioseop_nags_yoast_option ): ?>
            <hr>
            <h2><?php esc_html_e('YOAST settings','no-aioseop-nags') ?></h2>

            <br><input type="checkbox" name="no_aioseop_nags_yoast" id="no_aioseop_nags_yoast" value="1" <?php if ( $no_aioseop_nags_yoast_option )  { checked( '1', $no_aioseop_nags_yoast_option ); } ?>>
            <?php if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>
            <label for="no_aioseop_nags_custom_css-checkbox" style="font-size:16px;"><?php esc_html_e('We are blocking the nagging ', 'no-aioseop-nags') ?></label>
            <?php else: ?>
            <label for="no_aioseop_nags_custom_css-checkbox" style="font-size:16px; color:#b6a8b6;"><?php esc_html_e('<- NO NEED for this. ', 'no-aioseop-nags') ?> <?php esc_html_e('You are not using YOAST SEO. ', 'no-aioseop-nags') ?></label>
            <?php endif ?>


            <?php else: ?>
            <hr>
            <h2><?php esc_html_e('No YOAST premium nags?','no-aioseop-nags') ?></h2>
            <br><input type="checkbox" name="no_aioseop_nags_yoast" id="no_aioseop_nags_yoast" value="1" <?php if ( $no_aioseop_nags_yoast_option )  { checked( '1', $no_aioseop_nags_yoast_option ); } ?>>
            <?php if ( 1 != $no_aioseop_nags_yoast_option ): ?>
            <?php if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>
            <label for="no_aioseop_nags_custom_css-checkbox" style="font-size:16px;"><?php esc_html_e('<- Check to block the nagging', 'no-aioseop-nags') ?></label>
            <?php else: ?>
            <label for="no_aioseop_nags_yoast" style="font-size:16px; color:#b6a8b6;"><?php esc_html_e('<- NO NEED for this. ', 'no-aioseop-nags') ?> <?php esc_html_e('You are not using YOAST3 SEO. ', 'no-aioseop-nags') ?></label>
            <?php endif ?>
            <?php else: ?>
            <?php if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>
            <label for="no_aioseop_nags_yoast" style="font-size:16px;"><?php esc_html_e('We are blocking the nagging ', 'no-aioseop-nags') ?></label>
            <?php else: ?><label for="no_aioseop_nags_yoast" style="font-size:16px; color:rgb(159, 39, 39);font-weight:800;"><?php esc_html_e('<- Please uncheck this.', 'no-aioseop-nags') ?>
                <span style="font-size:16px;font-style: italic; color:#424242"><?php esc_html_e('You are not using YOAST SEO. ', 'no-aioseop-nags') ?></span></label>
            <?php endif ?>
            <?php endif ?>
            <?php endif ?>

            <?php else: ?>


            <?php if ( 1 == $no_aioseop_nags_yoast_option ): ?>
            <hr><br><input type="checkbox" name="no_aioseop_nags_yoast" id="no_aioseop_nags_yoast" value="1" <?php if ( $no_aioseop_nags_yoast_option )  { checked( '1', $no_aioseop_nags_yoast_option ); } ?>>
            <label for="no_aioseop_nags_yoast" style="font-size:16px; color:rgb(159, 39, 39);font-weight:800;"><?php esc_html_e('<- Please uncheck this.', 'no-aioseop-nags') ?>
                <span style="font-size:16px;font-style: italic; color:#424242"><?php esc_html_e('You are not using YOAST SEO. ', 'no-aioseop-nags') ?></span></label>

            <?php endif ?>

            <?php endif ?>



            <hr>

            <h2><?php esc_html_e('Load custom CSS?','no-aioseop-nags') ?></h2>
            <br><input type="checkbox" name="no_aioseop_nags_your_custom-checkbox" id="no_aioseop_nags_your_custom-checkbox" value="1" <?php if ( $no_aioseop_nags_your_custom_css_option )  { checked( '1', $no_aioseop_nags_your_custom_css_option ); } ?>>
            <?php if ( 1 != $no_aioseop_nags_your_custom_css_option ): ?> <label for="no_aioseop_nags_your_custom-checkbox" style="font-size:16px;"><?php esc_html_e('<- Check to use your custom css', 'no-aioseop-nags') ?></label>
            <?php else: ?>

            <label for="no_aioseop_nags_your_custom-checkbox" style="font-size:16px;">
                <?php esc_html_e('Custom css is enabled. ', 'no-aioseop-nags') ?></label>
            <br>
            <?php 
            // since Version 3.1 by @alexclassroom 
            printf(__('Click %1$shere%2$s to add your CSS', 'no-aioseop-nags'),'<a href="#no-nags-admin-css">','</a>') ?>

            <?php endif ?>
            <hr>
            <div>
                <?php submit_button( __( 'Save Settings', 'no-aioseop-nags' ), 'primary button-hero', 'submit', false ); ?>
            </div>

        </div>



        <?php 
    
    // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>
        <div class="wrap" style="margin-top: 5px; padding:25px; background:white">
            <hr>
            <p style="font-size:14px"><?php esc_html_e('This simple Plugin, was originally made for the "All in One SEO" - Plugin.','no-aioseop-nags') ?><br>
                <?php esc_html_e(' But now -since Version 2.7., we are as well supporting desperate YOAST Seo users in their search of a cleaner admin area','no-aioseop-nags') ?><br>
                <?php esc_html_e('@YOAST: We all know, that there is a premium version, but still think it is enough to mention it once and NOT cluttering the while backend with advertising! ','no-aioseop-nags') ?><br>
                <?php esc_html_e('So this plugin will clean things a little for us.  ','no-aioseop-nags') ?></p>
            <hr>

        </div>
        <?php endif ?>

        <?php 
        
        // Added due to error
   include_once ABSPATH . 'wp-admin/includes/plugin.php'; 
        if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
        <div class="wrap" style="margin-top: 5px; padding:25px">
            <hr>
            <p style="font-size:14px"><?php esc_html_e('This simple Plugin, will clean most of the abusive admin Spam from the "All in One SEO" - Plugin.','no-aioseop-nags') ?><br>
                <?php esc_html_e(' It is a great plugin, and we love it. BUT it is enough to mention it once that there are premium versions. ','no-aioseop-nags') ?><br>
                <?php esc_html_e('And there IS NO REASON to block functions, like e.g. the editing of Category Descriptions. ','no-aioseop-nags') ?><br>
                <?php esc_html_e('So this will clean things a little for us.  ','no-aioseop-nags') ?></p>
            <hr>

        </div>
        <?php endif ?>


        <div class="welcome-panel" id="no-nags-admin-css" style="<?php if ( 1 != $no_aioseop_nags_your_custom_css_option ): ?>display:none;<?php else: ?> display:block;<?php endif ?>">
            <?php settings_fields( 'no_aioseop_nags_settings_group' ); ?>
            <h2 class="lotus-kontur"><span class="dashicons dashicons-heart"></span> <span class="dashicons dashicons-superhero"></span><?php esc_html_e('Want to clean more?', 'no-aioseop-nags') ?> </h2>
            <p><?php esc_html_e('Add your CSS here', 'no-aioseop-nags') ?><br>
                <small> <?php esc_html_e('Be aware, that THIS could cause damage to your wp-admin area', 'no-aioseop-nags') ?></small>
            </p>
            <textarea rows="10" class="large-text code" style="" class="" id="no_aioseop_nags_your_custom_css" name="no_aioseop_nags_your_custom_css" placeholder="<?php esc_html_e('Only use save CSS here, and only use it, if you know, what you are doing:', 'no-aioseop-nags') ?>"><?php echo esc_attr( get_option('no_aioseop_nags_your_custom_css') ); ?></textarea>
            <br>
            <h3><?php esc_html_e('Examples:','no-aioseop-nags') ?></h3>
            <ul>
                <li>
                    <strong><?php esc_html_e('Stop all dismissible banners:','no-aioseop-nags') ?></strong><br>
                    <em>.is-dismissible{display:none!important;}</em>
                </li>
                <hr>
                <li>
                    <strong><?php esc_html_e('Stop jetpack from annoying you with upgrade-ads:','no-aioseop-nags') ?></strong><br>
                    <em>.jitm-banner.jitm-card.is-upgrade-premium {display:none!important;}</em>
                </li>
            </ul>

            <?php submit_button( __( 'Save Settings', 'no-aioseop-nags' ), 'primary', 'submit', true ); ?>
        </div>
    </form>

    <hr>

    <div class="postbox-container" style="margin-top: 5px; padding:25px">
        <p style="font-size:11px">
            <?php if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) : ?>
            <?php esc_html_e('Note: This Plugin does only load CSS to block premium advertising.  ','no-aioseop-nags') ?> <br>
            <strong><?php esc_html_e('And it does not interfer with the functions of your "YOAST SEO - Plugin"  ','no-aioseop-nags') ?></strong>
            <?php endif ?>

            <?php if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) : ?>
            <br> <?php esc_html_e('Note: This Plugin does only load CSS to block and unloads a pop-up script.  ','no-aioseop-nags') ?> <br>
            <strong><?php esc_html_e('And it does not interfer with the functions of your "All in One SEO - Plugin"  ','no-aioseop-nags') ?></strong>

            <?php endif ?>
        </p>
    </div>
</div>


<?php
}



/*----------------------------------*/
/*			Load CSS Styles			*/
/*----------------------------------*/

 
             
// Load Admin CSS Submited Via Admin
function no_aioseop_nags_load_admin_css_from_admin() { 
	
	if ( is_multisite() ) {
		$no_aioseop_nags_your_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'no_aioseop_nags_your_custom_css' );
        $no_aioseop_nags_you_wanted_custom_css = get_blog_option( SITE_ID_CURRENT_SITE, 'no_aioseop_nags_your_custom-checkbox' );
        
	}
	else {
		$no_aioseop_nags_your_custom_css_option = get_option( 'no_aioseop_nags_your_custom_css' );
        $no_aioseop_nags_you_wanted_custom_css =  get_option( 'no_aioseop_nags_your_custom-checkbox' );
	}
	
	// Check if Load CSS is checked
	if ( !((isset($no_aioseop_nags_your_custom_css_option)) && (boolval($no_aioseop_nags_your_custom_css_option))) ) {
		return;
        
	}
	
	$no_aioseop_nags_admin_css_content = isset( $no_aioseop_nags_your_custom_css_option ) && ! empty( $no_aioseop_nags_your_custom_css_option ) ? $no_aioseop_nags_your_custom_css_option : '' ; 
	
	$no_aioseop_nags_admin_css_content = wp_kses( $no_aioseop_nags_admin_css_content, array( '\'', '\"' ) );
	$no_aioseop_nags_admin_css_content = str_replace( '&gt;', '>', $no_aioseop_nags_admin_css_content );	
	
	// Minify
	if ( (isset($no_aioseop_nags_your_custom_css_option['minfy_css'])) && (boolval($no_aioseop_nags_your_custom_css_option['minfy_css'])) ) {
		$no_aioseop_nags_admin_css_content = no_aioseop_nags_csstidy_helper($no_aioseop_nags_admin_css_content, true);
	} ?>
<style type="text/css">
    <?php if (0==$no_aioseop_nags_you_wanted_custom_css): ?><?php else: ?><?php echo $no_aioseop_nags_admin_css_content;
    ?><?php endif ?>
</style><?php 
}
add_filter( 'admin_enqueue_scripts' , 'no_aioseop_nags_load_admin_css_from_admin' );

          
 
// Load Admin CSS From /wp-content/themes/custom_admin.css For Backward Compatibility With Version 1.0
if ( file_exists ( get_theme_root() . '/custom_admin.css' )) {
	function no_aioseop_nags_load_custom_admin_css() {
		wp_enqueue_style('no_aioseop_nags_custom_css', get_theme_root_uri() . '/custom_admin.css');
	}
	add_action( 'admin_enqueue_scripts', 'no_aioseop_nags_load_custom_admin_css' );
   
}

 $no_aioseop_nags_custom_css_option = get_option( 'no_aioseop_nags_custom_css-checkbox' );
if ( 1 == $no_aioseop_nags_custom_css_option) { 

function kontur_no_nags_frontend_style() {
 
      if ( is_user_logged_in() ) 
    {
        wp_register_style('no_nags_frontend_style', plugins_url('/includes/no_aioseop_nags_block_the_spam_v34.css',__FILE__));
   
         wp_enqueue_style( 'no_nags_frontend_style'); // code
    }
        
        
    }

add_action( 'wp_enqueue_scripts', 'kontur_no_nags_frontend_style' );
};



/* Load YOAST Spam Blocker CSS to frontend
 * @since    2.7.0
 */
$no_aioseop_nags_yoast_option = get_option( 'no_aioseop_nags_yoast' );
if ( 1 == $no_aioseop_nags_yoast_option ) { 

function kontur_no_nags_yoast_frontend_style() {
 
      if ( is_user_logged_in() ) 
    {
        wp_register_style('no_nags_yoast_frontend_style', plugins_url('/includes/no_nags_yoast_block_the_spam_v34.css',__FILE__));
   
         wp_enqueue_style( 'no_nags_yoast_frontend_style'); // code
    }
        
        
    }

add_action( 'wp_enqueue_scripts', 'kontur_no_nags_yoast_frontend_style' );
};






/**
	 * Set defaults
	 *
	 *
	 * @since    1.0.0
	 */
function kontur_no_aioseo_nags_activation(){
    do_action( 'no_aioseop_nags_default_options' );
    do_action( 'no_yoast_nags_default_options' );
}
register_activation_hook( __FILE__, 'kontur_no_aioseo_nags_activation' );




function prefix_deprecated_hook_admin_notice() {
    if ( has_filter( 'prefix_filter' ) ) { 
        // Check if it's been dismissed...
        if ( ! get_option('dismissed-prefix_deprecated', FALSE ) ) { 
            // Added the class "notice-my-class" so jQuery pick it up and pass via AJAX,
            // and added "data-notice" attribute in order to track multiple / different notices
            // multiple dismissible notice states ?>
<div class="updated notice notice-my-class is-dismissible" data-notice="prefix_deprecated">
    <p>
        <?php esc_html_e('Notice', 'no-aioseop-nags'); ?></p>
</div>
<?php }
    }
}

add_action( 'admin_notices', 'prefix_deprecated_hook_admin_notice' );
/**
 * Get the boolean value of a variable
 *
 * @param 	mixed 	The scalar value being converted to a boolean.
 * @return 	boolean The boolean value of var.
 * @refer	https://millionclues.com/wordpress-tips/solved-fatal-error-call-to-undefined-function-boolval/
 */
if( !function_exists('boolval')) {
  
  function boolval($var){
    return !! $var;
  }
}