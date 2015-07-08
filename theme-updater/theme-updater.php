<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Theme Updater
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://hexagone.io', // Site where EDD is hosted
		'item_name'      => 'Toivo',              // Name of theme
		'theme_slug'     => 'toivo',              // Theme slug
		'version'        => TOIVO_VERSION,        // The current version of this theme
		'author'         => 'Sami Keijonen',      // The author of this theme
		'download_id'    => '',                   // Optional, used for generating a license renewal link
		'renew_url'      => ''                    // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'toivo' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'toivo' ),
		'license-key'               => __( 'License Key', 'toivo' ),
		'license-action'            => __( 'License Action', 'toivo' ),
		'deactivate-license'        => __( 'Deactivate License', 'toivo' ),
		'activate-license'          => __( 'Activate License', 'toivo' ),
		'status-unknown'            => __( 'License status is unknown.', 'toivo' ),
		'renew'                     => __( 'Renew?', 'toivo' ),
		'unlimited'                 => __( 'unlimited', 'toivo' ),
		'license-key-is-active'     => __( 'License key is active.', 'toivo' ),
		'expires%s'                 => __( 'Expires %s.', 'toivo' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'toivo' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'toivo' ),
		'license-key-expired'       => __( 'License key has expired.', 'toivo' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'toivo' ),
		'license-is-inactive'       => __( 'License is inactive.', 'toivo' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'toivo' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'toivo' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'toivo' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'toivo' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'toivo' )
	)

);