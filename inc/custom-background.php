<?php
/**
 * Custom background feature
 *
 * @package Toivo
 */

/**
 * Adds support for the WordPress 'custom-background' theme feature.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toivo_custom_background_setup() {

	add_theme_support( 'custom-background',
		apply_filters( 'toivo_custom_background_args',
			array(
				'default-color'    => 'fafafa',
				'default-image'    => '',
				'wp-head-callback' => 'toivo_custom_background_callback'
			) 
		)
	);
}
add_action( 'after_setup_theme', 'toivo_custom_background_setup', 15 );

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.  This also fixes WordPress 
 * not correctly handling the theme's default background color.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 * @link http://core.trac.wordpress.org/ticket/21510
 
 * @author  Justin Tadlock, justintadlock.com
 * @link    http://themehybrid.com/themes/stargazer
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toivo_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) ) {
		return;
	}

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

	?>
	<style type="text/css" id="custom-background-css">body.custom-background { <?php echo trim( $style ); ?> }</style>
	<?php

	/* Add custom-background body class if we get this far. */
	add_filter( 'body_class', 'toivo_add_custom_background_class' );
}

/**
 * Add custom-background body class before it's saved.
 *
 * @since  1.0.0
 * @return array
 */
function toivo_add_custom_background_class( $classes ) {

	if( !get_theme_mod( 'background_color' ) ) {
		$classes[] = 'custom-background';
	}
	return $classes;
}