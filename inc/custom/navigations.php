<?php 

/********************************************/
## Primary and other navigation register
/********************************************/
if ( ! function_exists ( 'THEMENAME_register_primary_menu' ) ) {
add_action( 'after_setup_theme', 'THEMENAME_register_primary_menu' );

function THEMENAME_register_primary_menu() {
 
  register_nav_menu( 'primary', __( 'Primary Menu', 'THEMENAME' ) );
  
}
}
?>