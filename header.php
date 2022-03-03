<?php
	/*-----------------------------------------------------------------------------------*/
	/* This template will be called by all other template files to begin
	/* rendering the page and display the header/nav
	/*-----------------------------------------------------------------------------------*/
?>
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

	<?php
    $custom_logo_id = get_theme_mod( 'custom_logo' );
	   $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

     if ( has_custom_logo() ) {
       echo '<img width="500" height="500" class="logo logo-img" src="' . esc_url( $logo[0] ) . '" alt="' . bloginfo( 'name' ) . '">';
     } else {
       echo '<h1>' . get_bloginfo('name') . '</h1>';
     } ?>
