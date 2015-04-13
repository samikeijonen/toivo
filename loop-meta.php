<?php
/**
 * Loop meta content for displaying title and description in the header.
 *
 * @package Toivo
 */
?>

<div class="loop-meta" <?php hybrid_attr( 'loop-meta' ); ?>>

	<?php
		if ( is_home() && !is_front_page() ) :
			$toivo_archive_title = get_post_field( 'post_title', get_queried_object_id() );
			$toivo_loop_desc     = get_post_field( 'post_content', get_queried_object_id(), 'raw' );
		elseif( is_search() ) :
			/* Translators: %s is the search query. The HTML entities are opening and closing curly quotes. */
			$toivo_archive_title = sprintf( __( 'Search results for &#8220;%s&#8221;', 'toivo' ), get_search_query() );
			$toivo_loop_desc     = sprintf( __( 'You are browsing the search results for &#8220;%s&#8221;', 'toivo' ), get_search_query() );;
		elseif( is_author() ) :
			$toivo_archive_title = get_the_archive_title();
			$toivo_loop_desc     = get_the_author_meta( 'description', get_query_var( 'author' ) );
		elseif( is_post_type_archive( 'jetpack-testimonial' ) ) :
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
			$toivo_archive_title = $jetpack_options['page-title'] ? esc_html( $jetpack_options['page-title'] ) : esc_html__( 'Testimonials', 'toivo' );
			$toivo_loop_desc     = convert_chars( convert_smilies( wptexturize( stripslashes( wp_filter_post_kses( addslashes( $jetpack_options['page-content'] ) ) ) ) ) );
		elseif( is_post_type_archive( 'jetpack-portfolio' ) ) :
			$toivo_archive_title = get_theme_mod( 'portfolio_title' ) ? esc_html( get_theme_mod( 'portfolio_title' ) ) : esc_html__( 'Portfolio', 'toivo' );
			$toivo_loop_desc     = get_theme_mod( 'portfolio_description' ) ? esc_html( get_theme_mod( 'portfolio_description' ) ) : esc_html__( 'Check out our latest work', 'toivo' );
		else :
			$toivo_archive_title = get_the_archive_title();
			$toivo_loop_desc     = get_the_archive_description();		
		endif;
	?>

	<h1 class="site-title loop-title" <?php hybrid_attr( 'loop-title' ); ?>><?php echo $toivo_archive_title; ?></h1>

	<?php if ( $toivo_loop_desc ) : ?>

		<div class="site-description loop-description" <?php hybrid_attr( 'loop-description' ); ?>>
			<?php echo $toivo_loop_desc; ?>
		</div><!-- .loop-description -->
		
	<?php endif; // End paged check. ?>

</div><!-- .loop-meta -->