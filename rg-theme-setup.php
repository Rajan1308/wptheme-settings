<?php

/**
 * Plugin Name: Theme Setting
 * Plugin URI:  Plugin URL Link
 * Author:      Rajan Gupta
 * Author URI:  Plugin Author Link
 * Description: Securities and Theme Setting
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: rg-theme-setting
*/


if( ! defined( 'ABSPATH' ) ) exit;

if( is_admin() ): 
  require_once( dirname( __FILE__ ) . '/admin/functions.php' ); 
endif;


function nexadev_replace_wordpress_howdy( $wp_admin_bar ) {
	$my_account 	= $wp_admin_bar->get_node( 'my-account' );
	$newtext 		= str_replace( 'Howdy,', 'Hi,', $my_account->title );
	$wp_admin_bar->add_node([
		'id' 		=> 'my-account',
		'title' 	=> $newtext
	]);
}
add_filter( 'admin_bar_menu', 'nexadev_replace_wordpress_howdy', 25 );



function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
	}
	add_filter('upload_mimes', 'add_file_types_to_uploads');


  
function acf_setting_function() {
    if( function_exists('acf_add_options_page') ) {
      // arc General Settings
      $general_settings   = array(
                                  'page_title' 	=> __( 'Theme Settings', 'placesst' ),
                                  'menu_title'	=> __( 'Theme Settings', 'placesst' ),
                                  'menu_slug' 	=> 'general-settings',
                                  'capability'	=> 'edit_posts',
                                  'redirect'      => false,
                                  'icon_url'      => 'dashicons-admin-settings'
                              );
      acf_add_options_page( $general_settings );
    }
  }
add_action('init', 'acf_setting_function');

/*
 * Remove wp logo from admin bar
 */
function placesst_remove_wp_logo() {
	global $wp_admin_bar;

	if( class_exists('acf') ) {
			$wp_help  = get_field( 'arc_options_admin_wp_help', 'option' );
			if( empty( $wp_help ) ) {
					$wp_admin_bar->remove_menu('wp-logo');
			}
	}
}
add_action( 'wp_before_admin_bar_render', 'placesst_remove_wp_logo' );
/*
* Custom login logo
*/
function placesst_custom_login_logo() {
	if( class_exists('acf') ) {
			$wp_login_logo      = get_field( 'arc_options_admin_login_logo', 'option' );
			$wp_login_w         = get_field( 'arc_options_admin_width', 'option' );
			$wp_login_h         = get_field( 'arc_options_admin_height', 'option' );
			$wp_login_bg        = get_field( 'arc_options_admin_bg', 'option' );
			$wp_login_btn_c     = get_field( 'arc_options_admin_buton_color', 'option' );
			$wp_login_btn_c_h   = get_field( 'arc_options_admin_buton_color_hover', 'option' );
			if( !empty( $wp_login_logo ) ) {
?>
			<style type="text/css">
					.login h1 a {
							background-image: url('<?php echo $wp_login_logo; ?>') !important;
							background-size: <?php echo $wp_login_w.'px'; ?> auto !important;
							height: <?php echo $wp_login_h.'px'; ?> !important;
							width: <?php echo $wp_login_w.'px'; ?> !important;
					}
			</style>
<?php
			}
			if( !empty( $wp_login_bg ) ){
?>
			<style type="text/css">
					body.login{ background: #133759 url("<?php echo $wp_login_bg; ?>") no-repeat center; background-size: cover;}
					body.login form {background: rgba(0, 0, 0, 0.2);padding: 40px;}
          .login form {margin-top: 20px; margin-left: 0;padding: 26px 24px 34px;font-weight: 400;overflow: hidden;background: #fff;border: 1px solid #c3c4c7;box-shadow: 0 1px 3px rgb(0 0 0 / 4%);}
          body.login #login form p {margin-bottom: 15px;}
          body.login #login {width: 460px;}
          .login #nav a, .login #backtoblog a {color:#fff !important;margin: 24px 0 0 0; font-weight:500}
          .login label {font-size: 15px;line-height: 1.5;display: inline-block;margin-bottom: 3px;color: #fff;font-weight:500}
          .login a.privacy-policy-link{color:#000; font-weight:500}
          body.login div#login form#loginform input[type=password], .login input[type=text]{padding:12px 16px !important}
                body.login div#login form#loginform input#wp-submit {background-color: <?php echo $wp_login_btn_c; ?> !important;}
                body.login div#login form#loginform input#wp-submit:hover {background-color: <?php echo $wp_login_btn_c_h; ?> !important;}
			</style>
<?php
			}
	}
}
add_action( 'login_enqueue_scripts', 'placesst_custom_login_logo' );
/*
* Change custom login page url
*/
function placesst_loginpage_custom_link() {
	$site_url = esc_url( home_url( '/' ) );
	return $site_url;
}
add_filter( 'login_headerurl', 'placesst_loginpage_custom_link' );
/*
* Change title on logo
*/
function placesst_change_title_on_logo() {
	$site_title = get_bloginfo( 'name' );
	return $site_title;
}
add_filter( 'login_headertext', 'placesst_change_title_on_logo' );
/*
* Change admin your favicon
*/
function placesst_admin_favicon() {
	if( class_exists('acf') ) {
			$favicon_url        = get_field( 'arc_options_admin_favicon', 'option' );
			if( !empty( $favicon_url ) ){
					echo '<link rel="icon" type="image/x-icon" href="' . $favicon_url . '" />';
			}
	}
}
add_action('login_head', 'placesst_admin_favicon');
add_action('admin_head', 'placesst_admin_favicon');
add_action('wp_head', 'placesst_admin_favicon'); 

function ad_login_footer() { $ref = wp_get_referer(); if ($ref) : ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
				jQuery("p#backtoblog a").attr("href", 'https://www.digitalnexa.com/');
				jQuery("p#backtoblog a").empty();
		});
	</script>
	<?php endif; }
	add_action('login_footer', 'ad_login_footer');
	
	function origo_custom_admin_footer() {
		_e( '<span id="footer-thankyou">Designed & developed by <a href="https://www.digitalnexa.com/" style="color:#f47c30">Digital Nexa</a>', 'digitalnexa' );
	}
	add_filter( 'admin_footer_text', 'origo_custom_admin_footer' );

	function add_class_to_href( $classes, $item ) {
    if ( in_array('current_page_item', $item->classes) ) {
        $classes['class'] = 'nav-link active';
    }
    return $classes;
}
add_filter( 'nav_menu_link_attributes', 'add_class_to_href', 10, 2 );

// CPT
add_filter ('redirect_canonical', function($redirect_url){
	if(is_404()) {
		return false;
	}
	return $redirect_url;	
});
	
function defer_parsing_of_js($url) {
  if (is_admin()) return $url; 
  if (false === strpos($url, '.js')) return $url;
  if (strpos($url, 'jquery.js')) return $url;
  return str_replace(' src', ' defer src', $url);
}

//add_filter('script_loader_tag', 'defer_parsing_of_js', 10);

function globalvalley_disable_gutenberg($is_enabled, $post_type) {
	if ($post_type === 'testimonial') return false; 
	if ($post_type === 'post') return false; 
	if ($post_type === 'postauthor') return false; 
	if ($post_type === 'page') return false; 
	
	return $is_enabled;
}
add_filter('use_block_editor_for_post_type', 'globalvalley_disable_gutenberg', 10, 2);


add_filter('gutenberg_can_edit_post', '__return_false', 5);
add_filter('use_block_editor_for_post', '__return_false', 5);
