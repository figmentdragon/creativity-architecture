<?php
/**
 * The Left sidebar containing the main widget area.
 *
 * @package THEMENAME
 */

if ( ! is_active_sidebar( 'THEMENAME-sidebar-left' ) ) {
    return;
}
?>

<?php if( THEMENAME_get_sidebar_layout() == "left_sidebar" ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'THEMENAME-sidebar-left' ); ?>
    </div><!-- #secondary -->
<?php endif; 