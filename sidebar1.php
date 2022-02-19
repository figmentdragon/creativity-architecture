<?php
/**
* The Sidebar containing the main widget areas.
*
* @package MYTHEME
* @since MYTHEME 1.0
*/
?>
<header class="site-header">
  <hgroup class="nameplate">
    <h1 class="site-title">
      <?php bloginfo( 'name', 'display' ); ?>
    </h1>
    <nav class="nav">
    <?php wp_nav_menu( 'primary-menu',
      array(
        'theme_location'  => 'main-menu',
        'container_class' => 'menu',
        'menu_class'      => 'menu_items',
        'fallback_cb'     => false,
      ) ); ?>
    
      <?php if ( function_exists( 'catchwebtools_social_icons' ) ) catchwebtools_social_icons( 'social-menu',
          array(
            'theme_location'  => 'social',
            'container'       => 'div',
            'container_id'    => 'menu-social',
            'container_class' => 'menu',
            'menu_id'         => 'menu-social-items',
            'menu_class'      => 'menu-items',
            'depth'           => 1,
            'link_before'     => '<span class="screen-reader-text">',
            'link_after'      => '</span>',
            'fallback_cb'     => '',
          )
        );
        ?>
      </nav>
  </hgroup>
</header>
