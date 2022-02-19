<?php /* Template Name: Author */ ?>
<?php get_header(); ?>

	<main role="main" aria-label="Content">
		<!-- section -->
		<section>

		<?php if ( have_posts() ): the_post(); ?>

			<h2><?php esc_html_e( 'Author Archives for ', 'MYTHEME' ); echo get_the_author(); ?></h2>

		<?php if ( get_the_author_meta( 'description' ) ) : ?>

		<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>

			<h2><?php esc_html_e( 'About ', 'MYTHEME' ); echo get_the_author(); ?></h2>

			<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>

		<?php endif; ?>

		<?php rewind_posts(); while ( have_posts() ) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- post thumbnail -->
				<?php if ( has_post_thumbnail() ) : // Check if Thumbnail exists. ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( array( 120, 120 ) ); // Declare pixel size you need inside the array. ?>
					</a>
				<?php endif; ?>
				<!-- /post thumbnail -->

				<!-- post title -->
				<h2>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</h2>
				<!-- /Post title -->

				<!-- post details -->
				<span class="date">
					<time datetime="<?php the_time( 'Y-m-d' ); ?> <?php the_time( 'H:i' ); ?>">
						<?php the_date(); ?> <?php the_time(); ?>
					</time>
				</span>
				<span class="author"><?php esc_html_e( 'Published by', 'MYTHEME' ); ?> <?php the_author_posts_link(); ?></span>
				<span class="comments"><?php comments_popup_link( __( 'Leave your thoughts', 'MYTHEME' ), __( '1 Comment', 'MYTHEME' ), __( '% Comments', 'MYTHEME' ) ); ?></span>
				<!-- /post details -->

				<?php MYTHEME_wp__excerpt( 'MYTHEME_wp__index' ); // Build your custom callback length in functions.php. ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else : ?>

			<!-- article -->
			<article>

				<h2><?php esc_html_e( 'Sorry, nothing to display.', 'MYTHEME' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

			<?php get_template_part( 'pagination' ); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
