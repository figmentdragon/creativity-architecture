<?php /* Template Page : Index */?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>
<?php architecture_the_html_classes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	  <meta name="HandheldFriendly" content="True" />
	  <meta name="MobileOptimized" content="320" />

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

	</head>

<body <?php body_class(); ?>>

	</div>
	<header class="site-header absolute-header">
		<div class="logo">LOGO</div>
		<section class="masthead absolute-masthead pageplate" id="page-title">
				<div class="vertical">
						<?php the_title(); ?>SECTION ID
				</div>
		</section>
		<section class="nameplate">
      <sup id="author-name"><?php get_the_author_meta( 'display_name' ) ?></sup>
      <p id="site-title">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
      </p>
      <sub id="site-description"><?php bloginfo( 'description' ) ?></sub>
		</section>
		<nav>

		</nav>
	</header>

    <div class="bg-front-page">
      <main class="main container">
MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN
  </main>
  <footer class="site-footer fixed-footer">
  	<div class="site-info container">
  		<section class="social-media">
  			scroll of updates
  		</section>
  		<section class="contact">
  			<address class="email" id="email">The Creativty Architect</address>
  			<small class="copyright" id="copyright">
  				Works are<?php echo architecture_copyright(); ?>
  				by <a href="http://thecreativityarchitect.com/#contact" rel="designer">CJMT</a>
  			</small>
  		</section>
  	</div><!-- .site-info -->
  </footer><!-- #colophon .site-footer -->
  </main>
  <?php wp_footer(); ?>


  </body>
  </html>
