<?php 

/********************************************/
## Primary and other navigation register
/********************************************/
if ( ! function_exists ( 'MYTHEME_register_primary_menu' ) ) {
add_action( 'after_setup_theme', 'MYTHEME_register_primary_menu' );

function MYTHEME_register_primary_menu() {
 
  register_nav_menu( 'primary', __( 'Primary Menu', 'MYTHEME' ) );
  
}
}
?>