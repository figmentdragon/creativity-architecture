<!-- sidebar -->
<aside class="sidebar" role="complementary">

			<h1><?php the_title(); ?></h1>

	<div class="sidebar-widget">
		<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'widget-area-1' ) ) ?>
	</div>

	<div class="sidebar-widget">
		<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'widget-area-2' ) ) ?>
	</div>

	<?php get_template_part( 'searchform' ); ?>

</aside>
<!-- /sidebar -->
