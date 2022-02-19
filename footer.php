<?php
	/*-----------------------------------------------------------------------------------*/
	/* This template will be called by all other template files to finish
	/* rendering the page and display the footer area/content
	/*-----------------------------------------------------------------------------------*/
?>

</main><!-- / end page container, begun in the header -->
	<footer>
			<p>
			&copy; <?php echo esc_html( date_i18n( __( 'Y', 'MYTHEME' ) ) ); ?> by <?php bloginfo( 'name' ); ?>. <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'MYTHEME' ) ); ?>">
		</p>
	</footer><!-- #colophon .site-footer -->
<?php wp_footer(); ?>
</body>
</html>
