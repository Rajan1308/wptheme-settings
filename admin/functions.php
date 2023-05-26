<?php
if( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_menu', 'nexarajan_base_hide_plugins', 110 );
function nexarajan_base_hide_plugins() { 
	$user = wp_get_current_user();
	if( is_admin() && $user && ! current_user_can( 'administrator' ) ) {
		remove_menu_page( 'tools.php' ); 	// Tools
	}
	if( is_admin() && ( $user && isset( $user->user_login ) && ( 'rajan@digitalnexa.com' != $user->user_login ) && ( 'nexadev' != $user->user_login ) ) ) {
		remove_menu_page( 'plugins.php' ); 											// Plugins
		remove_menu_page( 'edit.php?post_type=acf-field-group' ); 					// Custom Fields
		remove_submenu_page( 'tools.php', 'disable_comments_tools' ); 				// Delete Comments
		remove_submenu_page( 'options-general.php', 'options-writing.php' ); 		// Writing Settings
		remove_submenu_page( 'options-general.php', 'options-reading.php' ); 		// Reading Settings
		remove_submenu_page( 'options-general.php', 'options-media.php' ); 			// Media Settings
		remove_submenu_page( 'options-general.php', 'options-permalink.php' ); 		// Permalink Settings
		remove_submenu_page( 'options-general.php', 'privacy.php' ); 				// Privacy
		remove_submenu_page( 'options-general.php', 'disable-gutenberg' ); 			// Disable Gutenberg Settings
		remove_submenu_page( 'options-general.php', 'duplicatepost' ); 				// Duplicate Post Settings
		remove_submenu_page( 'options-general.php', 'disable_comments_settings' ); 	// Disable Comments
		remove_submenu_page( 'options-general.php', 'ithemes-licensing' ); 			// iThemes Security 

		global $submenu;
		if( isset( $submenu['themes.php'] ) ) {
			foreach( $submenu['themes.php'] as $index => $menu_item ) {
				foreach( $menu_item as $value ) {
					if( strpos( $value, 'customize' ) !== false ) unset( $submenu['themes.php'][$index] );
				}
			}
		}
	}
}