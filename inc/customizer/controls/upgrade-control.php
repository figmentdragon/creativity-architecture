<?php
/**
 * Upgrade Control for the Customizer
 * @package MYTHEME
*
 * Control type.
 * For Upsell content in the customizer
 */
 
// Displays the upgrade teasers in thhe Pro Version / More Features section.
if ( class_exists( 'WP_Customize_Control' ) ) {
	
	class MYTHEME_Customize_Static_Text_Control extends WP_Customize_Control {
		// Render Control
		public function render_content() {
	?>

    <div class="upgrade-pro-version">		

    <p class="rp-pro-heading"><?php esc_html_e('MYTHEME Pro - Save $10', 'MYTHEME') ?></p>
    <p class="rp-discount"><?php esc_html_e('Save $10 (Limited Time Offer!) if you purchase the Pro version with this discount code on checkout:', 'MYTHEME') ?>
        <span class="rp-discount-code"><?php esc_html_e('MYTHEME10', 'MYTHEME') ?></span></p>
    <p class="rp-pro-title"><?php esc_html_e('Pro Features:', 'MYTHEME') ?></p>

		
			<ul class="rp-pro-list">
				<li><?php esc_html_e('&bull; 5 Blog Styles', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; 10 Dynamic Sidebar Positions', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Add Multiple Splash Page Images', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; 3 Full Post Layouts', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; 5 Menu Locations', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Thumbnail Creation for the Blogs', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Recent Posts Widget w/thumbnails', 'MYTHEME')?></li>				
				<li><?php esc_html_e('&bull; An About Me Widget', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; A Social Links Widget', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Customize the Read More Button Text', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Custom Styled Archive Titles', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Custom Styled WordPress Login Page', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Add a Custom Blog Title with Introduction', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; We Made the Customizer Look Better', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Show or Hide the Featured Post Label', 'MYTHEME')?></li>
				<li><?php esc_html_e('&bull; Premium Support', 'MYTHEME')?></li>
			</ul>

    <p><a class="rp-get-pro button" href="<?php echo esc_url('https://www.roughpixels.com/blogging-themes/MYTHEME/'); ?>" target="_blank"><?php esc_html_e( 'Go Pro Now', 'MYTHEME' ); ?></a></p>			

    </div>

    <?php
		}
	}
}
