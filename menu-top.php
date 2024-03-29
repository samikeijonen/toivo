<?php
/**
 * Top menu.
 *
 * @package Toivo
 */
?>

<?php if ( has_nav_menu( 'top' ) ) : // Check if there's a menu assigned to the 'top' location. ?>
	
	<nav id="menu-top" class="menu top-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'toivo' ); ?>" <?php hybrid_attr( 'menu', 'top' ); ?>>
		<h2 class="screen-reader-text"><?php esc_attr_e( 'Top Menu', 'toivo' ); ?></h2>
		
		<?php wp_nav_menu(
			array(
				'theme_location' => 'top',
				'menu_id'        => 'menu-top-items',
				'depth'          => 1,
				'menu_class'     => 'menu-items menu-top-items',
				'fallback_cb'    => ''
			)
		); ?>
	</nav><!-- #menu-top -->

<?php endif; // End check for menu. ?>