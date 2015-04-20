<?php
/**
 * Output Callout text in header.
 *
 * @package Toivo
 */
 
/* Get post meta for Callouts in singular pages. */
$toivo_callout_text        = get_post_meta( get_the_ID(), '_toivo_callout_text', true );
$toivo_callout_url         = get_post_meta( get_the_ID(), '_toivo_callout_url', true );
$toivo_callout_description = get_post_meta( get_the_ID(), '_toivo_callout_description', true );

?>


<div class="loop-meta callout-meta" <?php hybrid_attr( 'loop-meta' ); ?>>

	<?php
		if( toivo_check_callout_output() ) :
		
			if( !empty( $toivo_callout_url ) ) :
				$toivo_callout_text = '<a href="' . esc_url( $toivo_callout_url ) . '">' . esc_attr( $toivo_callout_text ) . '</a>';
			else :
				$toivo_callout_text = esc_attr( $toivo_callout_text );
			endif;
			
			$toivo_callout_desc = !empty( $toivo_callout_description ) ? esc_attr( $toivo_callout_description ) : '';
		endif;
	?>

	<div class="site-title loop-title callout-title" <?php hybrid_attr( 'loop-title' ); ?>><?php echo $toivo_callout_text; ?></div>

	<?php if ( $toivo_callout_desc ) : ?>

		<div class="site-description loop-description callout-description" <?php hybrid_attr( 'loop-description' ); ?>>
			<?php echo $toivo_callout_desc; ?>
		</div><!-- .loop-description -->
		
	<?php endif; // End paged check. ?>

</div><!-- .loop-meta -->