<?php /* TEMPLATE PART: Footer */ ?>

<footer id="site-info">
    <section class="social-media">
      scrolling social media updates
    </section>
    <secion class="contact">
      <address class="email" id="email"><a href="">contact @email </address>
      <small class="copyright" id="copyright">Works by <?php get_author_name( $auth_id = 'true', 'display' ); ?>are <?php echo architecture_copyright(); ?></small>
    </section>
</footer><!-- #colophon .site-footer -->

<?php wp_footer(); ?>
</body>
</html>
