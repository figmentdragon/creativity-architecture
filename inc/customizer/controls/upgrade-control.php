<?php
/**
 * Upgrade Control for the Customizer
 * @package THEMENAME
*
 * Control type.
 * For Upsell content in the customizer
 */
 
// Displays the upgrade teasers in thhe Pro Version / More Features section.
if ( class_exists( 'WP_Customize_Control' ) ) {
	
	class THEMENAME_Customize_Static_Text_Control extends WP_Customize_Control {
		// Render Control
		public function render_content() {
	?>

    <div class="upgrade-pro-version">		

    <p class="rp-pro-heading"><?php esc_html_e('THEMENAME - Save $10', 'THEMENAME') ?></p>
    <p class="rp-discount"><?php esc_html_e('Save $10 (Limited Time Offer!) if you purchase the Pro version with this discount code on checkout:', 'THEMENAME') ?>
        <span class="rp-discount-code"><?php esc_html_e('THEMENAME10', 'THEMENAME') ?></span></p>
    <p class="rp-pro-title"><?php esc_html_e('Pro Features:', 'THEMENAME') ?></p>

		
			<ul class="rp-pro-list">
				<li><?php esc_html_e('&bull; 5 Blog Styles', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; 10 Dynamic Sidebar Positions', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Add Multiple Splash Page Images', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; 3 Full Post Layouts', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; 5 Menu Locations', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Thumbnail Creation for the Blogs', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Recent Posts Widget w/thumbnails', 'THEMENAME')?></li>				
				<li><?php esc_html_e('&bull; An About Me Widget', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; A Social Links Widget', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Customize the Read More Button Text', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Custom Styled Archive Titles', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Custom Styled WordPress Login Page', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Add a Custom Blog Title with Introduction', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; We Made the Customizer Look Better', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Show or Hide the Featured Post Label', 'THEMENAME')?></li>
				<li><?php esc_html_e('&bull; Premium Support', 'THEMENAME')?></li>
			</ul>

    <p><a class="rp-get-pro button" href="<?php echo esc_url('https://www.roughpixels.com/blogging-themes/THEMENAME/'); ?>" target="_blank"><?php esc_html_e( 'Go Pro Now', 'THEMENAME' ); ?></a></p>			

    </div>

    <?php
		}
	}
}
