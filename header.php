<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />

<title>
	<?php bloginfo('name'); ?> |
	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assests/scripts/js/lib/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body "<?php body_class();?>">

	<?php do_action( 'wp_body_open' ); ?>

  <?php get_sidebar(); ?>
  <div class="logo-wrapper">
  if ( is_front_page() && is_home() ) {
      <img src="http://localhost:10004/wp-content/uploads/2022/02/logo-corner.png" class="logo logo-img" height="500" width="500"></img>
  } elseif ( is_front_page() ) {
      <img src="http://localhost:10004/wp-content/uploads/2022/02/logo-corner.png" class="logo logo-img" height="500" width="500"></img>
  } elseif ( is_home() ) {
      <img src="http://localhost:10004/wp-content/uploads/2022/02/logo-corner.png" class="logo logo-img" height="500" width="500"></img>
  } else {
      <img src="http://localhost:10004/wp-content/uploads/2022/02/logo-corner.png" class="logo logo-img" height="500" width="500"></img>
  } endif; ?>
</div>
  <div class="wrapper">
