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

		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

	</head>

<body <?php body_class(); ?>>
	<div class="container">
		
	</div>
	<header class="fixed-header right-shadow right-shadow:before">
		<div class="logo">

		</div>
		<section class="masthead absolute-masthead pageplate" id="page-title">
				<div class="vertical">
						<?php the_title(); ?>
				</div>
		</section>
		<section>

		</section>
		<nav>

		</nav>
	</header>
