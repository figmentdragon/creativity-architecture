<!-- footer -->
	<div id="wrapper-footer">
		 <footer id="site-info" class="site-footer" role="contentinfo">
			     <!-- copyright -->
			   <small class="copyright">
				    <?php echo copyright(); ?>
              <?php bloginfo( 'name' ); ?>  &
            <address>
              <?php the_author_meta( $auth_id = true ); ?>
            </address>
			   </small>
				<!-- /copyright -->
    </footer>
			<!-- /footer -->
	</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
