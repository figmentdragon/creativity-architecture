<?php /* Template Name: 404 */ ?>

<?php get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section>

			<!-- article -->
			<article id="post-404">
				
				<div class="post 404">

					<h2>Oops! That page can't be found.</h2>
					<h4>It looks like nothing was found at this location.</h4>
					<p>
						<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Return home?', 'MYTHEME' ); ?></a>
					</p>
				</div>

				<h2><?php esc_html_e( 'Page not found', 'MYTHEME' ); ?></h1>
				<h4>
					<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Return home?', 'MYTHEME' ); ?></a>
				</h4>

			</article>
			<!-- /article -->

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
