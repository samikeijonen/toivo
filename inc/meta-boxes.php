<?php
/**
 * Add metabox for Callout info on singular page header section.
 *
 * @package Toivo
 */

/**
 * Add custom meta box for 'page' post type.
 *
 * @since 1.0.3
 * @return void
 */

function toivo_create_meta_boxes() {
	
	/* When to show metaboxes. */
	$toivo_when_to_show_metaboxes = apply_filters( 'toivo_when_to_show_callout_metaboxes', array( 'page', 'post', 'jetpack-portfolio', 'jetpack-testimonial' ) );
	
	/* Load metaboxes. */
	foreach ( $toivo_when_to_show_metaboxes as $toivo_when_to_show_metabox ) {
		add_meta_box( 'toivo_metabox', esc_html__( 'Header Callout text', 'toivo' ), 'toivo_meta_box_display', $toivo_when_to_show_metabox, 'normal', 'high' );
	}
	
}
add_action( 'add_meta_boxes', 'toivo_create_meta_boxes' );

/**
 * Displays the extra meta box.
 *
 * @since  1.0.3
 * @access public
 * @param  object  $post
 * @param  array   $metabox
 * @return void
 */
function toivo_meta_box_display( $post, $metabox ) {

	wp_nonce_field( basename( __FILE__ ), 'toivo-metabox-nonce' ); ?>
	
	</p>
		<?php _e( 'Replace header text with Callout text and description in singular views. Callout text field is required, others are optional.', 'toivo' ); ?>
	</p>
	
	<p>
		<label for="toivo-callout-text"><?php _e( 'Callout text (required)', 'toivo' ); ?></label>
		<br />
		<input type="text" name="toivo-callout-text" id="toivo-callout-text" value="<?php echo esc_attr( get_post_meta( $post->ID, '_toivo_callout_text', true ) ); ?>" size="30" style="width: 99%;" />
	</p>
	
	<p>
		<label for="toivo-callout-url"><?php _e( 'Callout URL', 'toivo' ); ?></label>
		<br />
		<input type="text" name="toivo-callout-url" id="toivo-callout-url" value="<?php echo esc_attr( get_post_meta( $post->ID, '_toivo_callout_url', true ) ); ?>" size="30" style="width: 99%;" />
	</p>
	
	<p>
		<label for="toivo-callout-description"><?php _e( 'Callout description', 'toivo' ); ?></label>
		<br />
		<input type="text" name="toivo-callout-description" id="toivo-callout-description" value="<?php echo esc_attr( get_post_meta( $post->ID, '_toivo_callout_description', true ) ); ?>" size="30" style="width: 99%;" />
	</p>
	

	<?php
	
}

/**
 * Saves the metadata for the portfolio item info meta box.
 *
 * @since  1.0.3
 * @access public
 * @param  int     $post_id
 * @param  object  $post
 * @return void
 */
function toivo_save_meta_boxes( $post_id, $post ) {

	/* Check nonce. */
	if ( !isset( $_POST['toivo-metabox-nonce'] ) || !wp_verify_nonce( $_POST['toivo-metabox-nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	
	/* Check autosave, ajax or bulk edit. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
		return;
	}

	$meta = array(
		'_toivo_callout_text'        => sanitize_text_field( $_POST['toivo-callout-text'] ),
		'_toivo_callout_url'         => esc_url( $_POST['toivo-callout-url'] ),
		'_toivo_callout_description' => sanitize_text_field( $_POST['toivo-callout-description'] )
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If there is no new meta value but an old value exists, delete it. */
		if ( current_user_can( 'edit_post', $post_id ) && '' == $new_meta_value && $meta_value ) {
			delete_post_meta( $post_id, $meta_key, $meta_value );
		}

		/* If a new meta value was added and there was no previous value, add it. */
		elseif ( current_user_can( 'edit_post', $post_id ) && $new_meta_value && '' == $meta_value ) {
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
		}
		/* If the new meta value does not match the old value, update it. */
		elseif ( current_user_can( 'edit_post', $post_id ) && $new_meta_value && $new_meta_value != $meta_value ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value );
		}
		
	}
	
}
add_action( 'save_post', 'toivo_save_meta_boxes', 10, 2 );
