<?php /* TEMPLATE PART: Header */ ?>
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

		<script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>
		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

	</head>

<body <?php body_class(); ?> id="<?php the_ID(); ?>">
	<header class="site-header">
		<section id="masthead">
			<div class="nameplate">
				<sup class="the">the</sup>
			<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?>
			</a>
			<sub class="site-description">
				<?php bloginfo( 'description' ); ?>
			</sub>
		</section>
				<nav class="main-navigation" id="architecture">
			<?php wp_nav_menu( array(
				'theme_location' => 'architecture_custom_menu',
				'container_class' => 'custom-menu-class' ) ); ?>
				  <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				  <li class="widget_search alignright" id="s">
					<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
					  <input type="search" class="form-control form-control-dark"   placeholder="Search..." aria-label="Search">
					</form>
				  </li>
			  </nav>
	</header>
