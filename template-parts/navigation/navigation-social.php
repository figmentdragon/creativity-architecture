<?php

/**
 * Social Menu Template
 *
 * @package MYTHEME
 */

if ( has_nav_menu( 'social-menu' ) ) :  ?>
	<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'MYTHEME' ); ?>">
		<?php
			wp_nav_menu( array(
				'theme_location'  => 'social-menu',
				'menu_class'      => 'social-links-menu',
				'container'       => 'div',
				'container_class' => 'menu-social-container',
				'depth'           => 1,
				'link_before'     => '<span class="screen-reader-text">',
				'link_after'      => '</span>' . MYTHEME_get_svg( array( 'icon' => 'chain' ) ),
			) );
		?>
	</nav><!-- .social-navigation -->
<?php endif; ?>
