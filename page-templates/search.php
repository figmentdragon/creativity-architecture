<?php /* Template Name: Search */ ?>
<?php get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section>

			<h2><?php echo sprintf( __( '%s Search Results for ', 'MYTHEME' ), $wp_query->found_posts ); echo get_search_query(); ?></h2>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
