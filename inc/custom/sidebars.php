<?php 

/********************************/
## Register theme sidebars
/********************************/
if ( ! function_exists ( 'MYTHEME_widgets_init' ) ) {
add_action( 'widgets_init', 'MYTHEME_widgets_init' ); 

function MYTHEME_widgets_init() {
	
	
/************************************/
##Primary Sidebar.
/*************************************/

	register_sidebar( array(
	'name'          => __( 'Primary Sidebar', 'MYTHEME' ),
	'id'            => 'primary-sidebar',
	'description'   => __('Primary sidebar of the theme. Display on left or right side of the theme','MYTHEME'),
    'class'         => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h6 class="widget-title"><span>',
	'after_title'   => '</span></h6>' ) );
	
	


/***********************************************************/
## Footer Vertical Sidebar Columns.
/**********************************************************/

	$counter = 0;
	$number_of_widgets = 3;
	
	while ( $counter < $number_of_widgets ) : $counter++;
	
		register_sidebar( array(
			'name'          => __( 'Footer ', 'MYTHEME' ) . $counter,
			'id'            => 'footer-' . $counter,
			'description'   => __( 'Footer bottom area vertical widgets.', 'MYTHEME' ),
			'before_widget' => '<div id="%1$s" class="widget  %2$s widget-ver">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title"><span>',
			'after_title'   => '</span></h6>')
		);
	
	endwhile;
	

}
}
	
/*****************************************************************/
## category widget custom filter.
/*****************************************************************/
if ( ! function_exists ( 'MYTHEME_category_count_span_inline' ) ) {
add_filter('wp_list_categories', 'MYTHEME_category_count_span_inline');

function MYTHEME_category_count_span_inline( $output) {

	$output = str_replace('</a> (','<span>(',$output);
	$output = str_replace(')',')</span></a> ',$output);
	return $output;

}
}
/*****************************************************************/
## archive widget custom filter.
/*****************************************************************/
if ( ! function_exists ( 'MYTHEME_archive_count_inline' ) ) {
add_filter('get_archives_link', 'MYTHEME_archive_count_inline');

function MYTHEME_archive_count_inline($links) {

	$links = str_replace('</a>&nbsp;(', ' <span>(', $links);
	$links = str_replace(')', ')</span></a>', $links);
	return $links;

}
}
?>