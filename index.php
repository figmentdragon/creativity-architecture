<?php /* Template Name: Index */
get_header(); ?>

<?php get_sidebar( 'header' ); ?>

<div id="wrapper">
	<main class="main" role="main" aria-label="Content">
		<h4 class="page-title"><?php the_title(); ?></h2>
			<div id="contentwrapper" class="content">
				<!-- section -->
					<section>
						<?php if ( is_front_page() && is_home() ) {
							get_template_part( 'template-parts/loop/loop' );
							} elseif ( is_front_page() ) {
								get_page_template( 'front-page' );
							} elseif ( is_home() ) {
								get_page_template( 'home' );
							} else {
								get_page_template( 'search' );
							} ?>

						<?php get_template_part( 'pagination' ); ?>
					</section>
					<!-- /section -->
			</main>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
