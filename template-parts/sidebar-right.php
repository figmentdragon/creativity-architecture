<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package THEMENAME
 */

if ( ! is_active_sidebar( 'THEMENAME-sidebar-right' ) ) {
    return;
}
?>
<?php
	$woo_page = THEMENAME_is_realy_woocommerce_page();
?>
<?php if( THEMENAME_get_sidebar_layout() == "right_sidebar" || $woo_page ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'THEMENAME-sidebar-right' ); ?>
    </div><!-- #secondary -->
<?php endif; 