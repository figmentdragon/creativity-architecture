<?php
/**
 * The template for displaying social media icons
 *
 * @package MYTHEME
 */

?>
<?php if ( get_theme_mod( 'MYTHEME_facebooklink' ) || get_theme_mod( 'MYTHEME_twitterlink' ) || get_theme_mod( 'MYTHEME_pinterestlink' ) || get_theme_mod( 'MYTHEME_instagramlink' ) || get_theme_mod( 'MYTHEME_linkedinlink' ) || get_theme_mod( 'MYTHEME_youtubelink' ) || get_theme_mod( 'MYTHEME_vimeo' ) || get_theme_mod( 'MYTHEME_tumblrlink' ) || get_theme_mod( 'MYTHEME_flickrlink' ) ) : ?>
	<div class="social-icons position-absolute">
		<ul class="list-unstyled d-table mb-2">

		<?php endif; ?>
		<?php if ( get_theme_mod( 'MYTHEME_facebooklink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_facebooklink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_twitterlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_twitterlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-twitter"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_pinterestlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_pinterestlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_instagramlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_instagramlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-instagram"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_linkedinlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_linkedinlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_youtubelink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_youtubelink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-youtube"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_vimeo' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_vimeo' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-vimeo-v"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_tumblrlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_tumblrlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-tumblr"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'MYTHEME_flickrlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'MYTHEME_flickrlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-flickr"></i></a></li>
		<?php endif; ?>
		
		<?php if ( get_theme_mod( 'MYTHEME_facebooklink' ) || get_theme_mod( 'MYTHEME_twitterlink' ) || get_theme_mod( 'MYTHEME_pinterestlink' ) || get_theme_mod( 'MYTHEME_instagramlink' ) || get_theme_mod( 'MYTHEME_linkedinlink' ) || get_theme_mod( 'MYTHEME_youtubelink' ) || get_theme_mod( 'MYTHEME_vimeo' ) || get_theme_mod( 'MYTHEME_tumblrlink' ) || get_theme_mod( 'MYTHEME_flickrlink' ) ) : ?>
	</ul>
</div>
<?php endif; ?>
