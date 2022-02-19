<?php
/**
 * The template for displaying search forms in MYTHEME
 *
 * @package MYTHEME
 * @since MYTHEME 1.0
 */
?>
    <form class="search" method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>" role="search">
        <label for="s" class="assistive-text"><?php _e( 'Search', 'MYTHEME' ); ?></label>
        <input type="text search" class="field search-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" aria-label="Search site for:" placeholder="<?php esc_html_e( 'To search, type and hit enter.', 'MYTHEME' ); ?>" />
		<button class="search-submit" type="submit"><?php esc_html_e( 'Search', 'MYTHEME' ); ?></button>
    </form>
