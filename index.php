<?php /* Template Name: Index */

get_header(); ?>

<div class="wrapper-header">
  <header class="site-header">
    <hgroup class="nameplate">
        <?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
        <?php get_template_part( 'template-parts/navigation/navigation', 'primary' );

        get_template_part( 'template-parts/navigation/primary', 'search' ); ?>
    </hgroup>
  </header>

</div>



<?php get_footer(); ?>
