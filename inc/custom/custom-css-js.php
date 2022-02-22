<?php 
/******************************************************/
# custom css function .
/******************************************************/
if ( ! function_exists ( 'MYTHEME_custom_css_js' ) ) {
add_action( 'wp_head', 'MYTHEME_custom_css_js' );

function MYTHEME_custom_css_js(){
	$MYTHEME_head = '<style type="text/css">';
		/* Body typography */
		$MYTHEME_body_font_size = (int)esc_attr(get_theme_mod('MYTHEME_font_size', '14'));
		$MYTHEME_body_line_height = esc_attr(get_theme_mod('MYTHEME_line_height', '1.2'));
		$MYTHEME_body_letter_space = esc_attr(get_theme_mod('MYTHEME_letter_space', '0'));
		$MYTHEME_font_family    = get_theme_mod('MYTHEME_font_family');
		
		$MYTHEME_head .= 'html, body {';
		
		if($MYTHEME_font_family !=''):
			$MYTHEME_head .= 'font-family:'.$MYTHEME_font_family.';'; 
		endif;
		
		if($MYTHEME_body_font_size > 0):
			$MYTHEME_head .= 'font-size:'. $MYTHEME_body_font_size.'px;';
		endif;
		
		if($MYTHEME_body_line_height != ''):	
			$MYTHEME_head .= 'line-height:'. $MYTHEME_body_line_height.';';				
		endif;
		
		if($MYTHEME_body_letter_space != '' && $MYTHEME_body_letter_space > 0):	
			$MYTHEME_head .= 'letter-spacing:'. $MYTHEME_body_letter_space .'px;';				
		endif;
	
		$MYTHEME_head .= '}';
		
		/*primary color */
		$primary_color = esc_attr(get_theme_mod('MYTHEME_primary_color', '#bf9e3b'));
	
		$MYTHEME_head .= '.entry-content a:not([class]), a:active, a:focus, a:hover{color:'. $primary_color.'}';
		
		$MYTHEME_head .= '.social-navigation.theme-colors,
		.comments-area .comments-list .comment .comment-meta .comment-header .comment-reply,
		.entry .entry-header .entry-meta .entry-cat,
		.entry .entry-quote-author,
		.widget.widget_recent-post .entry-list .entry .entry-meta .entry-cat, 
		.widget.widget_popular-post .entry-list .entry .entry-meta .entry-cat, 
		.widget.widget_posts .entry-list .entry .entry-meta .entry-cat, 
		.widget.widget_posts .entry .entry-meta .entry-cat, 
		.widget.widget_MYTHEME_recent_posts .entry .entry-meta .entry-cat, 
		.widget.widget_related_posts .entry .entry-meta .entry-cat,
		.widget.widget_categories ul li a:hover,
		.widget.widget_product_categories ul li a:hover,
		.widget.widget_archive ul li a:hover,
		.widget.widget_archives ul li a:hover,
		.widget.widget_twitter .tweets-list .tweet a,
		.widget.widget_recent_comments .recentcomments span a{ color :'. $primary_color.'}'; 
		
		$MYTHEME_head .= '
		.widget.widget_categories ul li a:before,
		.widget.widget_nav_menu ul li a::before, 
		.widget.widget_pages ul li a::before, 
		.widget.widget_meta ul li a::before, 
		.widget.widget_product_categories ul li a:before,
		.widget.widget_archive ul li a:before, 
		.widget.widget_archives ul li a:before {background-color: '. $primary_color. ' }';
		
		$MYTHEME_head .= '.widget.widget_tag_cloud .tagcloud a:hover {
			color:'. $primary_color.';
			border-color:'. $primary_color.'}';
		/* page loader enbled */
		
	$MYTHEME_head .= '.pace-running .pace{background-color:#ffffff;}
	.pace-done .pace{background-color:transparent;}
	.pace {
	  -webkit-pointer-events: none;
	  pointer-events: none;

	  -webkit-user-select: none;
	  -moz-user-select: none;
	  user-select: none;

	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  z-index:9999;

	  -webkit-transform: translate3d(0, -50px, 0);
	  -ms-transform: translate3d(0, -50px, 0);
	  transform: translate3d(0, -50px, 0);

	  -webkit-transition: -webkit-transform .5s ease-out;
	  -ms-transition: -webkit-transform .5s ease-out;
	  transition: transform .5s ease-out;
	}

	.pace.pace-active {
	  -webkit-transform: translate3d(0, 0, 0);
	  -ms-transform: translate3d(0, 0, 0);
	  transform: translate3d(0, 0, 0);
	}

	.pace .pace-progress {
	  display: block;
	  position: fixed;
	  z-index: 2000;
	  top: 0;
	  right: 100%;
	  width: 100%;
	  height: 5px;
	  background:'.$primary_color.';
	  pointer-events: none;
	}
   </style>';
  	if(is_rtl()): 
	$MYTHEME_head .='<script> 
	var RTL = true;
	</script>';
	else:
	$MYTHEME_head .= '<script> 
	var RTL = false;
	</script>';
	endif; 
	
	echo $MYTHEME_head;
}	
}
?>