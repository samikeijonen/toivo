<?php
/**
 * Theme Customizer
 *
 * @package Toivo
 */

/**
 * Add the Customizer functionality.
 *
 * @since 1.0.0
 */
function toivo_customize_register( $wp_customize ) {

	/* === Theme panel === */

	/* Add the theme panel. */
	$wp_customize->add_panel(
		'theme',
		array(
			'title'      => esc_html__( 'Theme Settings', 'toivo' ),
			'priority'   => 10
		)
	);
	
	/* == Layout section == */
	
	/* Add the layout section. */
	$wp_customize->add_section(
		'toivo-layout',
		array(
			'title'    => esc_html__( 'Layouts', 'toivo' ),
			'priority' => 10,
			'panel'    => 'theme'
		)
	);

	/* Add the layout setting. */
	$wp_customize->add_setting(
		'theme_layout',
		array(
			'default'           => '1c',
			'sanitize_callback' => 'toivo_sanitize_layout'
		)
	);
	
	$layout_choices = array( 
		'1c'   => __( '1 Column', 'toivo' ),
		'2c-l' => __( '2 Columns: Content / Sidebar', 'toivo' ),
		'2c-r' => __( '2 Columns: Sidebar / Content', 'toivo' )
	);
	
	/* Add the layout control. */
	$wp_customize->add_control(
		'theme_layout',
		array(
			'label'    => esc_html__( 'Global Layout', 'toivo' ),
			'section'  => 'toivo-layout',
			'priority' => 10,
			'type'     => 'radio',
			'choices'  => $layout_choices
		)
	);
	
	/* == Navigation section == */
	
	/* Add the navigation section. */
	$wp_customize->add_section(
		'toivo-navigation',
		array(
			'title'    => esc_html__( 'Navigation settings', 'toivo' ),
			'priority' => 15,
			'panel'    => 'theme'
		)
	);
	
	$wp_customize->add_setting(
		'disable_dropdown',
		array(
			'default'           => '',
			'sanitize_callback' => 'toivo_sanitize_checkbox'
		)
	);
	
	/* Add hide testimonial control. */
	$wp_customize->add_control(
		'disable_dropdown',
		array(
			'label'       => esc_html__( 'Disable multi-level menu', 'toivo' ),
			'description' => esc_html__( 'Check this if you want to disable multi-level dropdown in Primary menu.', 'toivo' ),
			'section'     => 'toivo-navigation',
			'priority'    => 15,
			'type'        => 'checkbox'
		)
	);
	
	/* == Front page section == */
	
	/* Add the front-page section. */
	$wp_customize->add_section(
		'front-page',
		array(
			'title'       => esc_html__( 'Front Page Settings', 'toivo' ),
			'description' => esc_html__( 'The first Callout is for top callout section and the second one is for bottom Callout section.', 'toivo' ),
			'priority'    => 20,
			'panel'       => 'theme'
		)
	);
	
	/* == Callout == */
	
	/* Add the callout title setting twice, top and bottom. */
	
	$k = 0;
	
	while ( $k < 2 ) {
		
		/* Text for placement in settings. */
		if ( 0 == $k ) {
			$placement = 'top';
		} else {
			$placement = 'bottom';
		}
		
		/* Text for placement in the Customizer. */
		if ( 0 == $k ) {
			$placement_text = _x( 'Top', 'position of callout text', 'toivo' );
		} else {
			$placement_text = _x( 'Bottom', 'position of callout text', 'toivo' );
		}
	
		$wp_customize->add_setting(
			'callout_title_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
	
		/* Add the callout title control. */
		$wp_customize->add_control(
			'callout_title_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout title', 'toivo' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 20 + $k*100,
				'type'     => 'text'
			)
		);
	
		/* Add the callout text setting. */
		$wp_customize->add_setting(
			'callout_text_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_textarea'
			)
		);
	
		/* Add the callout text control. */
		$wp_customize->add_control(
			'callout_text_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout text', 'toivo' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 30 + $k*100,
				'type'     => 'textarea'
			)
		);
	
		/* Add the callout link setting. */
		$wp_customize->add_setting(
			'callout_url_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
 	
		/* Add the callout link control. */
		$wp_customize->add_control(
			'callout_url_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout URL', 'toivo' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 50 + $k*100,
				'type'     => 'url'
			)
		);
 	
		/* Add the callout url text setting. */
		$wp_customize->add_setting(
			'callout_url_text_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
 	
		/* Add the callout url text control. */
		$wp_customize->add_control(
			'callout_url_text_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout URL text', 'toivo' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 60 + $k*100,
				'type'     => 'text'
			)
		);
	
		$k++; // Add +1 before loop ends.
	
	} // End while loop.
	
	/* Add hide and order testimonial setting. */
	if( class_exists( 'Jetpack' ) && current_theme_supports( 'jetpack-testimonial' ) ) {
		
		$wp_customize->add_setting(
			'hide_testimonials',
			array(
				'default'           => '',
				'sanitize_callback' => 'toivo_sanitize_checkbox'
			)
		);
	
		/* Add hide testimonial control. */
		$wp_customize->add_control(
			'hide_testimonials',
			array(
				'label'       => esc_html__( 'Hide testimonials', 'toivo' ),
				'description' => esc_html__( 'Check this if you want to hide testimonials from the Front Page Template.', 'toivo' ),
				'section'     => 'front-page',
				'priority'    => 70,
				'type'        => 'checkbox'
			)
		);
		
		$wp_customize->add_setting(
			'order_testimonials',
			array(
				'default'           => '',
				'sanitize_callback' => 'toivo_sanitize_checkbox'
			)
		);
	
		/* Add order testimonial control. */
		$wp_customize->add_control(
			'order_testimonials',
			array(
				'label'       => esc_html__( 'Testimonials after featured area', 'toivo' ),
				'description' => esc_html__( 'Check this if you want to move testimonials after Featured area in the Front Page Template.', 'toivo' ),
				'section'     => 'front-page',
				'priority'    => 75,
				'type'        => 'checkbox'
			)
		);
		
	} // End check for testimonials.
	
	/* Add the featured setting where we can select do we use child pages, blog posts or portfolios in front page template. */
	$wp_customize->add_setting(
		'front_page_featured',
		array(
			'default'           => 'child-pages',
			'sanitize_callback' => 'toivo_sanitize_featured'
		)
	);
	
	$front_page_featured_choices = array( 
		'child-pages' => esc_html__( 'Child Pages', 'toivo' ),
		'blog-posts'  => esc_html__( 'Blog Posts', 'toivo' ),
		'portfolios'  => esc_html__( 'Portfolios', 'toivo' )
	);
	
	/* Add the featured control. */
	$wp_customize->add_control(
		'front_page_featured',
		array(
			'label'       => esc_html__( 'Featured Content', 'toivo' ),
			'description' => esc_html__( 'Select do you want to feature Child Pages, Blog Posts or Portfolios in Front Page.', 'toivo' ),
			'section'     => 'front-page',
			'priority'    => 80,
			'type'        => 'radio',
			'choices'     => $front_page_featured_choices
		)
	);
	
	/* Add the setting for Callout image. */
	$wp_customize->add_setting(
		'callout_image',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw'
		) );
	
	/* Add the Callout image link control. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
			'callout_image',
				array(
					'label'       => esc_html__( 'Callout Image', 'toivo' ),
					'description' => esc_html__( 'Add Callout Image which can be map or product image for example. Recommended width is 1920px.', 'toivo' ),
					'section'     => 'front-page',
					'priority'    => 170,
				)
		)
	);
	
	/* Add the callout image alt setting. */
	$wp_customize->add_setting(
		'callout_image_alt',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	
	/* Add the callout image alt control. */
	$wp_customize->add_control(
		'callout_image_alt',
		array(
			'label'    => esc_html__( 'Callout image alt text', 'toivo' ),
			'section'  => 'front-page',
			'priority' => 180,
			'type'     => 'text'
		)
	);
	
	/* Add the Callout image link setting. */
	$wp_customize->add_setting(
		'callout_image_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 	
	/* Add the Callout image link control. */
	$wp_customize->add_control(
		'callout_image_url',
		array(
			'label'    => esc_html__( 'Callout image URL', 'toivo' ),
			'section'  => 'front-page',
			'priority' => 190,
			'type'     => 'url'
		)
	);
	
	/* == Background section == */
	
	/* Add the background section. */
	$wp_customize->add_section(
		'background',
		array(
			'title'    => esc_html__( 'Background Settings', 'toivo' ),
			'priority' => 30,
			'panel'    => 'theme'
		)
	);

	/* Add custom header background color setting. */
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default'           => apply_filters( 'toivo_default_bg_color', '#3b5667' ),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/* Add custom header background color control. */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'header_background_color',
		array(
			'label'       => esc_html__( 'Header Background Color', 'toivo' ),
			'section'     => 'background',
			'priority'    => 40,
		)
	) );
	
	/* Add custom header background color opacity setting. */
	$wp_customize->add_setting(
		'header_background_color_opacity',
		array(
			'default'           => absint( apply_filters( 'toivo_default_bg_opacity', 70 ) ),
			'sanitize_callback' => 'absint',
		)
	);
	
	$wp_customize->add_control(
		'header_background_color_opacity',
			array(
				'type'        => 'range',
				'priority'    => 50,
				'section'     => 'background',
				'label'       => esc_html__( 'Header Color Opacity.', 'toivo' ),
				'description' => esc_html__( 'Set Header Color opacity.', 'toivo' ),
				'input_attrs' =>
					array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1
					),
			)
		);
		
	/* Add the setting for subsidiary sidebar background image. */
	if ( is_active_sidebar( 'subsidiary' ) ) {
		
		$wp_customize->add_setting(
			'subsidiary_sidebar_bg',
			array(
				'default' => '',
				'sanitize_callback' => 'esc_url_raw'
			) );
	
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
			$wp_customize,
				'subsidiary_sidebar_bg',
					array(
						'label'    => esc_html__( 'Subsidiary sidebar background', 'toivo' ),
						'section'  => 'background',
						'priority' => 60,
				)
			)
		);
		
	/* Add subsidiary sidebar background color setting. */
	$wp_customize->add_setting(
		'subsidiary_sidebar_bg_color',
		array(
			'default'           => apply_filters( 'toivo_default_sidebar_bg_color', '#ffffff' ),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/* Add subsidiary sidebar background color control. */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'subsidiary_sidebar_bg_color',
		array(
			'label'       => esc_html__( 'Subsidiary Sidebar Background Color', 'toivo' ),
			'section'     => 'background',
			'priority'    => 70,
		)
	) );
	
	/* Add subsidiary sidebar background color opacity setting. */
	$wp_customize->add_setting(
		'subsidiary_sidebar_bg_color_opacity',
		array(
			'default'           => absint( apply_filters( 'toivo_default_subsidiary_sidebar_bg_opacity', 95 ) ),
			'sanitize_callback' => 'absint',
		)
	);
	
	$wp_customize->add_control(
		'subsidiary_sidebar_bg_color_opacity',
			array(
				'type'        => 'range',
				'priority'    => 80,
				'section'     => 'background',
				'label'       => esc_html__( 'Subsidiary Sidebar Background Color Opacity.', 'toivo' ),
				'description' => esc_html__( 'Set Subsidiary Sidebar Background Color Opacity.', 'toivo' ),
				'input_attrs' =>
					array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1
					),
			)
		);
	
	}
	
	/* == Portfolio section == */
	
	if( post_type_exists( 'jetpack-portfolio' ) ) {
	
		/* Add the portfolio section. */
		$wp_customize->add_section(
			'portfolio',
			array(
				'title'    => esc_html__( 'Portfolio Settings', 'toivo' ),
				'priority' => 40,
				'panel'    => 'theme'
			)
		);
	
		/* Add the portfolio title setting. */
		$wp_customize->add_setting(
			'portfolio_title',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
	
		/* Add the portfolio title control. */
		$wp_customize->add_control(
			'portfolio_title',
			array(
				'label'    => esc_html__( 'Portfolio Page Title', 'toivo' ),
				'section'  => 'portfolio',
				'priority' => 10,
				'type'     => 'text'
			)
		);
	
		/* Add the portfolio description setting. */
		$wp_customize->add_setting(
			'portfolio_description',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_textarea'
			)
		);
	
		/* Add the portfolio description control. */
		$wp_customize->add_control(
			'portfolio_description',
			array(
				'label'    => esc_html__( 'Portfolio Page Description', 'toivo' ),
				'section'  => 'portfolio',
				'priority' => 20,
				'type'     => 'textarea'
			)
		);
	
	}
	
	/* == Footer section == */
	
	/* Add the footer section. */
	$wp_customize->add_section(
		'footer',
		array(
			'title'    => esc_html__( 'Footer Settings', 'toivo' ),
			'priority' => 50,
			'panel'    => 'theme'
		)
	);
	
	/* Add hide footer setting. */
	$wp_customize->add_setting(
		'hide_footer',
		array(
			'default'           => '',
			'sanitize_callback' => 'toivo_sanitize_checkbox'
		)
	);
	
	/* Add hide footer control. */
	$wp_customize->add_control(
		'hide_footer',
		array(
			'label'       => esc_html__( 'Hide Footer', 'toivo' ),
			'description' => esc_html__( 'Check this if you want to hide Footer content.', 'toivo' ),
			'section'     => 'footer',
			'priority'    => 10,
			'type'        => 'checkbox'
		)
	);
	
	/* Add the footer text setting. */
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'toivo_sanitize_textarea'
		)
	);
	
	/* Add the footer text control. */
	$wp_customize->add_control(
		'footer_text',
		array(
			'label'       => esc_html__( 'Footer text', 'toivo' ),
			'description' => esc_html__( 'Enter Footer text which replaces default text.', 'toivo' ),
			'section'     => 'footer',
			'priority'    => 20,
			'type'        => 'textarea'
		)
	);
	
}
add_action( 'customize_register', 'toivo_customize_register' );

/**
 * Enqueues front-end CSS for backgrounds.
 *
 * @since 1.0.0
 * @see   wp_add_inline_style()
 */
function toivo_color_backgrounds_css() {
	
	/* Get header colors. */
	$header_bg_color = get_theme_mod( 'header_background_color', apply_filters( 'toivo_default_bg_color', '#3b5667' ) );
	$header_bg_color_opacity = absint( get_theme_mod( 'header_background_color_opacity', absint( apply_filters( 'toivo_default_bg_opacity', 70 ) ) ) );
	$header_bg_color_opacity = $header_bg_color_opacity / 100;
	
	/* Get subsidiary sidebar colors. */
	$subsidiary_sidebar_bg_color = get_theme_mod( 'subsidiary_sidebar_bg_color', apply_filters( 'toivo_default_sidebar_bg_color', '#ffffff' ) );
	$subsidiary_sidebar_bg_color_opacity = absint( get_theme_mod( 'subsidiary_sidebar_bg_color_opacity', absint( apply_filters( 'toivo_default_subsidiary_sidebar_bg_opacity', 95 ) ) ) );
	$subsidiary_sidebar_bg_color_opacity = $subsidiary_sidebar_bg_color_opacity / 100;

	/* Convert hex color to rgba. */
	$header_bg_color_rgb = toivo_hex2rgb( $header_bg_color );
	$subsidiary_sidebar_bg_color_rgb = toivo_hex2rgb( $subsidiary_sidebar_bg_color );
	
	/* Subsidiary sidebar image. */
	$subsidiary_sidebar_bg = esc_url( get_theme_mod( 'subsidiary_sidebar_bg' ) );
	
	/* When to show subsidiary sidebar image. */
	$min_width = absint( apply_filters( 'toivo_subsidiary_sidebar_bg_show', 1 ) );
	
	/* Background arguments. */
	$background_arguments = esc_attr( apply_filters( 'toivo_subsidiary_sidebar_bg_arguments', 'no-repeat 50% 50%' ) );
	
	/* Header bg styles. */	
	if ( '#3b5667' !== $header_bg_color || 70 !== $header_bg_color_opacity ) {
			
		$bg_color_css = "
			.site-header,
			.custom-header-image .site-header > .wrap::before {
				background-color: rgba( {$header_bg_color_rgb['red'] }, {$header_bg_color_rgb['green']}, {$header_bg_color_rgb['blue']}, {$header_bg_color_opacity});
			}";
				
	}
	
	/* Subsidiary bg styles. */	
	if ( is_active_sidebar( 'subsidiary' ) && ! empty( $subsidiary_sidebar_bg ) ) {

		$bg_color_css .= "
		@media screen and (min-width: {$min_width}px) {
				
			.sidebar-subsidiary {
					background: url({$subsidiary_sidebar_bg}) {$background_arguments}; background-size: cover;
				}
					
		}
		
		.sidebar-subsidiary,
		.sidebar-subsidiary > .wrap::before {
			background-color: rgba( {$subsidiary_sidebar_bg_color_rgb['red'] }, {$subsidiary_sidebar_bg_color_rgb['green']}, {$subsidiary_sidebar_bg_color_rgb['blue']}, {$subsidiary_sidebar_bg_color_opacity});
		}";	
			
	}
		
	wp_add_inline_style( 'toivo-style', $bg_color_css );
}
add_action( 'wp_enqueue_scripts', 'toivo_color_backgrounds_css' );

/**
 * Sanitize the Global layout value.
 *
 * @since 1.0.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (1c|2c-l|2c-r).
 */
function toivo_sanitize_layout( $layout ) {

	if ( ! in_array( $layout, array( '1c', '2c-l', '2c-r' ) ) ) {
		$layout = '2c-l';
	}

	return $layout;
	
}

/**
 * Sanitize the Featured Content value.
 *
 * @since 1.0.0
 *
 * @param  string $featured content type.
 * @return string Filtered featured content type (child-pages|blog-posts|portfolios).
 */
function toivo_sanitize_featured( $featured ) {

	if ( ! in_array( $featured, array( 'child-pages', 'blog-posts', 'portfolios' ) ) ) {
		$featured = 'child-pages';
	}

	return $featured;
	
}

/**
 * Sanitize the checkbox value.
 *
 * @since 1.0.0
 *
 * @param  string $input checkbox.
 * @return string (1 or null).
 */
function toivo_sanitize_checkbox( $input ) {

	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}

}

/**
 * Sanitizes the footer content on the customize screen. Users with the 'unfiltered_html' cap can post 
 * anything. For other users, wp_filter_post_kses() is ran over the setting.
 *
 * @since 1.0.1
 */
function toivo_sanitize_textarea( $setting, $object ) {
	
	/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( 'footer_text' == $object->id && !current_user_can( 'unfiltered_html' ) ) {
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	}
	/* Return the sanitized setting. */
	return $setting;
	
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function toivo_customize_register_pm( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
}
add_action( 'customize_register', 'toivo_customize_register_pm' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function toivo_customize_preview_js() {
	wp_enqueue_script( 'toivo-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), TOIVO_VERSION, true );
}
add_action( 'customize_preview_init', 'toivo_customize_preview_js' );

/**
* Callout text and link in front page template.
*
* @since  1.0.0
*/
function toivo_callout_output( $placement ) {
	
	/* Set default placement of the callout. */
	if( empty( $placement ) ) {
		$placement = 'top';
	}
	
	/* Start output. */
	$output = '';

	/* Output callout link and text on page templates. */
	if ( get_theme_mod( 'callout_title_' . $placement ) || get_theme_mod( 'callout_url_' . $placement ) || get_theme_mod( 'callout_url_text_' . $placement ) || get_theme_mod( 'callout_text_' . $placement ) ) {
		
		/* Start output. */
		$output .= '<div class="toivo-callout toivo-callout-' . $placement . '"><div class="entry-inner">';
		
		/* Callout title. */
		if( get_theme_mod( 'callout_title_' . $placement ) ) {
			$output .= '<div class="entry-header"><h2 class="toivo-callout-title entry-title">' . esc_attr( get_theme_mod( 'callout_title_' . $placement ) ) . '</h2></div>';
		}
		
		/* Callout text. */
		if( get_theme_mod( 'callout_text_' . $placement ) ) {
			$output .= '<div class="toivo-callout-text">' . apply_filters( 'toivo_the_content', esc_html( get_theme_mod( 'callout_text_' . $placement ) ) ) . '</div>';
		}
		
		/* Callout link. */
		if( get_theme_mod( 'callout_url_' . $placement ) && get_theme_mod( 'callout_url_text_' . $placement ) ) {
			$output .= '<div class="toivo-callout-link"><a class="toivo-button toivo-callout-link-anchor" href="' . esc_url( get_theme_mod( 'callout_url_' . $placement ) ) . '">' . esc_html( get_theme_mod( 'callout_url_text_' . $placement ) ) . '</a></div>';
		}
		
		/* End output. */
		$output .= '</div></div>';
		
	}
	
	return $output;
	
}

/**
* Echo Callout in front page template.
*
* @since  1.0.0
*/
function toivo_echo_callout( $placement ) {
	
	/* Set default placement of the callout. */
	if( empty( $placement ) ) {
		$placement = 'top';
	}

	$echo_output = toivo_callout_output( $placement );

	if( !empty( $echo_output ) ) {
		echo $echo_output;
	}

}
