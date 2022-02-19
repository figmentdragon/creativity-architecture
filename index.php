<?php /* Template Name: Index */

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); ?>

	<?php get_sidebar(); ?>
	<div class="wrapper-main">
		<main class="main">

				<h4 class="site-description">
					<?php bloginfo( 'description' ); ?>
				</h4>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<article>
				<?php the_post_thumbnail('large'); ?>

				<h1>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_title(); ?>
					</a>
				</h1>
				<div>
				<?php the_time('m/d/Y'); ?> |
				<?php if( comments_open() ): ?>
					<span>
					<?php comments_popup_link( __( 'Comment', 'break' ), __( '1 Comment', 'break' ), __( '% Comments', 'break' ) ); ?>
								</span>
							<?php endif; ?>

						</div><!--/post-meta -->

						<div>
							<?php the_content( 'Continue...' ); ?>

							<?php wp_link_pages(); ?>
						</div><!-- the-content -->

						<div>
							<div><?php echo get_the_category_list(); ?></div>
							<div><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
						</div><!-- Meta -->

					</article>

				<?php endwhile; ?>

				<!-- pagintation -->
				<div>
					<div><?php previous_posts_link( 'newer' ); // Display a link to  newer posts, if there are any, with the text 'newer' ?></div>
					<div><?php next_posts_link( 'older' ); // Display a link to  older posts, if there are any, with the text 'older' ?></div>
				</div><!-- pagination -->


			<?php else : ?>

				<article>
					<h1>Nothing has been posted like that yet</h1>
				</article>

			<?php endif; ?>
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->
</main>
</div>
<?php get_footer(); ?>
