<?php /* Template Name : Index */?>
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

		<link href="http://fonts.cdnfonts.com/css/euphorigenic" rel="stylesheet">

		<script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>
		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

	</head>

<body <?php body_class(); ?> id="<?php the_ID(); ?>">

    <!-- ======= Header ======= -->
    <header class="site-header" id="masthead">
      <div class="vertical nameplate d-flex flex-column">
        <h1 class="site-title"><a href="/"><?php bloginfo( 'name' ); ?></a></h1>
        <h2 class="site-description"><?php bloginfo( 'description' ); ?>
      </div>

        <nav class="nav-menu navbar">
			<ul class="social-links text-center">
                <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="discord"><i class="fa-discord:before "></i></a>
                <a href="#" class="email"><i class="fas fa-at"></i></a>
            </ul>
          <ul>
            <li><a href="#hero" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>
            <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
            <li><a href="#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
            <li><a href="#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Portfolio</span></a></li>
            <li><a href="#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Services</span></a></li>
            <li><a href="#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
          </ul>
        </nav><!-- .nav-menu -->
      </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
      <div class="hero-container" data-aos="fade-in">
        <h1>Alex Smith</h1>
        <p>I'm <span class="typed" data-typed-items="Designer, Developer, Freelancer, Photographer"></span></p>
      </div>
    </section><!-- End Hero -->

    <main id="main">


    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="site-info container">
            <section class="social-media">
                <div class="icons alignleft">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="fa-discord:before"><i class="fab fa-discord"></i></a>
                    <a href="#" class="messanger"><i class="fab fa-facebook-messenger"></i></a>
                </div>
                <div class="news-scroll">
                    scroll of updates
                </div>
            </section>
            <section class="contact align-text-right">
                <address class="email" id="email">The Creativty Architect</address>
                <small class="copyright" id="copyright">
                    Works are<?php echo architecture_copyright(); ?>
                    by <a href="http://thecreativityarchitect.com/#contact" rel="designer">CJMT</a>
                </small>
            </section>
        </div><!-- .site-info -->
    </footer><!-- End  Footer -->
</main>

 <?php wp_footer(); ?>
 </body>
 </html>
