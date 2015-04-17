<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #main and all content after
 *
 * @package Toivo
 */
?>

					</main><!-- #main -->
				</div><!-- #primary -->

			<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>
			
			</div><!-- .wrap-inside -->
		</div><!-- .wrap -->
	</div><!-- #content -->
	
	<?php get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>
	
	<?php if( !get_theme_mod( 'hide_footer' ) ) : // Hide footer. ?>
	
		<footer id="colophon" class="site-footer" role="contentinfo" <?php hybrid_attr( 'footer' ); ?>>
		
			<div class="site-info">
			
				<?php
					if( get_theme_mod( 'footer_text' ) ) :
						echo get_theme_mod( 'footer_text' );
					else :
				?>
				
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'toivo' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'toivo' ), 'WordPress' ); ?></a>
				<span class="sep"><?php echo _x( '&middot;', 'Separator in site info.', 'toivo' ); ?></span>
				<?php printf( __( 'Theme %1$s by %2$s', 'toivo' ), 'Toivo', '<a href="https://foxland.fi" rel="designer">Foxnet</a>' ); ?>
			
			<?php endif; // End check for footer text. ?>
			
			</div><!-- .site-info -->
		
		</footer><!-- #colophon -->
		
	<?php endif; // End check for footer. ?>
	
	<?php do_action( 'toivo_after_footer' ); // Hook after footer. ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
