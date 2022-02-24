<?php
/**
 * Add inline styles to the head area
 * @package THEMENAME
*/
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 // Dynamic styles
function THEMENAME_inline_styles($THEMENAME_customizer_css) {
	

// BEGIN CUSTOM CSS	

// site identity group
	$THEMENAME_sitetitle_colour = esc_attr(get_theme_mod( 'THEMENAME_sitetitle_colour', '#262626' ) );	
	$THEMENAME_tagline_colour = esc_attr(get_theme_mod( 'THEMENAME_tagline_colour', '#444' ) );
	$THEMENAME_customizer_css .="#site-title a,#site-title a:visited,#site-title a:hover { color: $THEMENAME_sitetitle_colour;	}
		#site-description { color: $THEMENAME_tagline_colour;	}	";
	
// Colours
$THEMENAME_line_colour = esc_attr(get_theme_mod( 'THEMENAME_line_colour', '#dedede' ) );
$THEMENAME_image_border = esc_attr(get_theme_mod( 'THEMENAME_image_border', '#d8d2c5' ) );
$THEMENAME_image_hborder = esc_attr(get_theme_mod( 'THEMENAME_image_hborder', '#c3b496' ) );

$THEMENAME_splash_button = esc_attr(get_theme_mod( 'THEMENAME_splash_button', '#262626' ) );
$THEMENAME_splash_button_text = esc_attr(get_theme_mod( 'THEMENAME_splash_button_text', '#fff' ) );
$THEMENAME_splash_hbutton = esc_attr(get_theme_mod( 'THEMENAME_splash_hbutton', '#c3b496' ) );
$THEMENAME_splash_hbutton_text = esc_attr(get_theme_mod( 'THEMENAME_splash_hbutton_text', '#fff' ) );

$THEMENAME_first_colour = esc_attr(get_theme_mod( 'THEMENAME_first_colour', '#c7b897' ) );
$THEMENAME_second_colour = esc_attr(get_theme_mod( 'THEMENAME_third_colour', '#262626' ) );
$THEMENAME_third_colour = esc_attr(get_theme_mod( 'THEMENAME_fourth_colour', '#9a9a9a' ) );

$THEMENAME_menu_link_colour = esc_attr(get_theme_mod( 'THEMENAME_menu_link_colour', '#161616' ) );
$THEMENAME_menu_hover_link_colour = esc_attr(get_theme_mod( 'THEMENAME_menu_hover_link_colour', '#ceb654' ) );
$THEMENAME_submenu_bg = esc_attr(get_theme_mod( 'THEMENAME_submenu_bg', '#fff' ) );
$THEMENAME_submenu_border = esc_attr(get_theme_mod( 'THEMENAME_submenu_border', '#ececec' ) );
$THEMENAME_submenu_link_colour = esc_attr(get_theme_mod( 'THEMENAME_submenu_link_colour', '#161616' ) );
$THEMENAME_submenu_link_hover_colour = esc_attr(get_theme_mod( 'THEMENAME_submenu_link_hover_colour', '#ceb654' ) );
$THEMENAME_customizer_css .="

.hentry .post-thumbnail a img,
.page .post-thumbnail img,
.single .post-thumbnail img,
#author-info .avatar,
#related-posts .wp-post-image,
#attachment-wrapper img,
.THEMENAME-thumbnail img,
#banner-sidebar img,
.rp-social-icons-list a,
.rp-social-icons-list a:visited,
#comments .comment .avatar {border-color: $THEMENAME_image_border;}


.rp-social-icons-list a:hover {background-color: $THEMENAME_image_border;}
.rp-social-icons-list li .icon {fill: $THEMENAME_image_border;}

.hentry .post-thumbnail a img:hover,
#related-posts .wp-post-image:hover {border-color: $THEMENAME_image_border;}

#splash-menu .splash-button a,
#splash-menu .splash-button a:visited {background-color: $THEMENAME_splash_button; color: $THEMENAME_splash_button_text; }
#splash-menu .splash-button a:hover {background-color: $THEMENAME_splash_hbutton; color: $THEMENAME_splash_hbutton_text; }

#site-branding:after,
hr.page-title-line,
#respond input[type=\"text\"],
#respond textarea,
span.page-wrap,
.widget-title,
.tagcloud a,
#author-info,
input[type=\"text\"],
input[type=\"password\"],
input[type=\"date\"],
input[type=\"datetime\"],
input[type=\"datetime-local\"],
input[type=\"month\"],
input[type=\"week\"],
input[type=\"email\"],
input[type=\"number\"],
input[type=\"search\"],
input[type=\"tel\"],
input[type=\"time\"],
input[type=\"url\"],
input[type=\"color\"],
textarea,
select {border-color: $THEMENAME_line_colour;}

.entry-title:after,
.THEMENAME-author-name:after,
#blog-sidebar li:after {background-color: $THEMENAME_line_colour;} 

::-moz-selection {background-color: $THEMENAME_first_colour;} 
::selection {background-color: $THEMENAME_first_colour;}

#breadcrumbs-wrapper,
#top-bar {border-color: $THEMENAME_first_colour;}
.has-accent-color {color: $THEMENAME_first_colour;}
table thead,
.has-accent-background-color,
#top-search {background-color: $THEMENAME_first_colour;}
#top-bar .icon:hover {fill: $THEMENAME_first_colour;}

#site-title a,
#site-title a:visited,
#site-title a:hover,
#post-categories a, 
#post-categories a:visited, 
#post-tags a,
#post-tags a:visited,
.attachment .gallery-post-caption,
h1, h2, h3, h4, h5, h6,
a:hover,
.image figcaption,
figcaption,
.image figcaption,
.has-dark-grey-color,
#comments a,
.main-navigation-toggle {color: $THEMENAME_second_colour;}

#top-bar,
.has-dark-grey-background-color,
.button,
.button:visited,
button,
button:visited,
input[type=\"submit\"],
input[type=\"submit\"]:visited,
input[type=\"reset\"],
input[type=\"reset\"]:visited,
.attachment-button a,
.attachment-button a:visited,
#infinite-handle span {background-color: $THEMENAME_second_colour;}

.main-navigation-toggle .icon,
#footer-social-icons .social-icons-menu li a .icon {fill: $THEMENAME_second_colour;}

.post-details,
.post-details a, 
.post-details a:visited,
.related-post-date,
#page-intro,
.has-grey-color {color: $THEMENAME_third_colour;}

.has-grey-background-color {-background-color: $THEMENAME_third_colour;}


	
.main-navigation-menu a,
    .main-navigation-menu a:visited { color: $THEMENAME_menu_link_colour;}
	.main-navigation-menu > .menu-item-has-children a .sub-menu-icon .icon { fill: $THEMENAME_menu_link_colour;}


.main-navigation-menu ul a,
    .main-navigation-menu ul a:visited { color: $THEMENAME_submenu_link_colour;}
	
@media (min-width: 768px){
.main-navigation-menu ul a:focus,
    .main-navigation-menu ul a:hover { color: $THEMENAME_submenu_link_hover_colour;}
}	
.main-navigation-menu a:focus,
    .main-navigation-menu a:hover,
	.main-navigation-menu ul a:hover,
    .main-navigation-menu ul a:active,
    .main-navigation-menu .sub-menu li.current-menu-item > a  { color: $THEMENAME_menu_hover_link_colour;}

.main-navigation-menu ul,
.main-navigation-menu  { background: $THEMENAME_submenu_bg;}
.main-navigation-menu ul { border-color: $THEMENAME_submenu_border;}

@media (min-width: 768px){
.main-navigation-menu {background: transparent;}
}
";


// Dropcap
	$THEMENAME_dropcap_colour = esc_attr(get_theme_mod( 'THEMENAME_dropcap_colour', '#444' ) );			
	$THEMENAME_customizer_css .="p.has-drop-cap:not(:focus):first-letter { color: $THEMENAME_dropcap_colour;	} ";
		
		
// END CUSTOM CSS - Output all the styles
wp_add_inline_style( 'THEMENAME-stylesheet', $THEMENAME_customizer_css );
	
}
add_action( 'wp_enqueue_scripts', 'THEMENAME_inline_styles' );
