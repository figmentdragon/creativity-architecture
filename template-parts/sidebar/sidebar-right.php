<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package MYTHEME
 */

if ( ! is_active_sidebar( 'MYTHEME-sidebar-right' ) ) {
    return;
}
?>
<?php
	$woo_page = MYTHEME_is_realy_woocommerce_page();
?>
<?php if( MYTHEME_get_sidebar_layout() == "right_sidebar" || $woo_page ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'MYTHEME-sidebar-right' ); ?>
    </div><!-- #secondary -->
<?php endif; 