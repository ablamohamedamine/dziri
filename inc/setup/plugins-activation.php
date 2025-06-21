<?php
/**
 * Register The Required Plugins.
 * 
 * @package    Dziri
 */

require_once get_template_directory() . '/inc/setup/class-tgm-plugin-activation.php';

// TGMPA Demo Import required.

function dziri_register_ocdi() {

	$plugins = array(

		// One Click Demo Import.
		array(
			'name'         => 'One Click Demo Import', 
			'slug'         => 'one-click-demo-import', 
			'required'     => false
		),
	
		// Dziri Demo.
		array(
			'name'         => 'Dziri Demo', 
			'slug'         => 'dziri-demo', 
			'required'     => false
		),
	);



	$config = array(
		'id'           => 'dziri',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'dziri' ),
			'menu_title'                      => __( 'Install Plugins', 'dziri' ),
			'installing'                      => __( 'Installing Plugin: %s', 'dziri' ),
			'updating'                        => __( 'Updating Plugin: %s', 'dziri' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'dziri' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'dziri'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'dziri'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'dziri'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'dziri'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'dziri'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'dziri'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'dziri'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'dziri'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'dziri'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'dziri' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'dziri' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'dziri' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'dziri' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'dziri' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'dziri' ),
			'dismiss'                         => __( 'Dismiss this notice', 'dziri' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'dziri' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'dziri' ),
			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	);
	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'dziri_register_ocdi' );
