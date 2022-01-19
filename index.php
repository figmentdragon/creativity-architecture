<?php /* Template Name : Page */ ?>

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
		<link href="style.css" rel="stylesheet" type="text/css">
<script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>
		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

	</head>

<body <?php body_class(); ?> id="<?php the_ID(); ?>">

	<main>

		<header class="site-header">
			<section class="nameplate">
				<h4 class="site-desecription">
					<?php bloginfo( 'name' ); ?>
				</h4>	
				<h1 class="site-title">
					<?php bloginfo( 'name' ); ?>
				</h1>
				<nav class="navbar" id="architecture">
					<?php wp_nav_menu( array(
					'theme_location' => 'architecture-menu',
					'container_class' => 'custom-menu-class',
				 	'menu_class' 	 => 'navbar', ) ); ?>
				</nav>
			</section>
		</header>

     <article>
		<div class="primary">

		</div>
    </article>

	<footer class="site-footer">
		<div id ="site-information">
			<address class="email"><a href="#">contact @email</a></address>
			<small class="copyright">Works by <?php get_author_name( $auth_id = 'true', 'display' ); ?>are <?php echo architecture_copyright(); ?></small>
		</div>
    </footer><!-- #colophon .site-footer -->

	</main>
 </body>
 </html>
