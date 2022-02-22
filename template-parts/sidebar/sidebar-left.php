<?php
/**
 * The Left sidebar containing the main widget area.
 *
 * @package MYTHEME
 */

if ( ! is_active_sidebar( 'MYTHEME-sidebar-left' ) ) {
    return;
}
?>

<?php if( MYTHEME_get_sidebar_layout() == "left_sidebar" ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'MYTHEME-sidebar-left' ); ?>
    </div><!-- #secondary -->
<?php endif; 