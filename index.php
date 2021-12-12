<?php /* Template Page: Front Page */?>

<?php	/*-----------------------------------------------------------------------------------*/
	/* This template will be called by all other template files to begin
	/* rendering the page and display the header/nav
	/*-----------------------------------------------------------------------------------*/ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="MobileOptimized" content="320" />
  <title>
  	<?php bloginfo('name'); // show the blog name, from settings ?> |
  	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>the CREATIVITY ARCHITECT
  </title>

  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <?php wp_head(); ?>

  </head>

  <body class="page">

        <header class="site-header">
          <p id="author-name">
            <?php get_the_author_meta('display_name'); ?>
          </p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
        </p>
        <p id="site-description">
          <?php bloginfo( 'description' ); ?>
        </p>

      <div class="clear"></div>
          <nav class="main-navigation" id="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
			             <li class="nav-item" role="presentation">
			                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">ABOUT</button>
			              </li>
			              <li class="nav-item" role="presentation">
				                <button class="nav-link" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog" type="button" role="tab" aria-controls="blog" aria-selected="false">BLUEPRINTS</button>
				              </li>
				              <li class="nav-item" role="presentation">
						             <button class="nav-link" id="coaching-tab" data-bs-oggle="tab" data-bs-target="#coaching" type="button" role="tab" aria-controls="coaching" aria-selected="false">COACHING</button>
						            </li>
						              <li class="nav-item" role="presentation">
						                <button class="nav-link" id="writing-svcs-tab" data-bs-toggle="tab" data-bs-target="#writing-svcs" type="button" role="tab" aria-controls="writing-svcs" aria-selected="false">WRITING SVCS</button>
						              </li>
						              <li class="nav-item" role="presentation">
						                <button class="nav-link" id="portfolio-tab" data-bs-toggle="tab" data-bs-target="#portfolio" type="button" role="tab" aria-controls="portfolio" aria-selected="false">PORTFOLIO</button>
						              </li>
						              <li class="nav-item" role="presentation">
						                <button class="nav-link" id="pentapolis-tab" data-bs-toggle="tab" data-bs-target="#pentapolis" type="button" role="tab" aria-controls="pentapolis" aria-selected="false">PENTAPOLIS</button>
						              </li>
						              <li class="widget_search alignright">
						                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
						                  <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
						                </form>
						              </li>
						            </ul>
          </nav><!-- .site-navigation .main-navigation -->
        </header>

      <div class="logo">

      </div>
      <section class="masthead">
        <p id="page-title">
          <?php the_ID();?>SECTION ID
        </p>
      </section>
      <main class="main card">
				<div class="container">
    			<section id="about">

        		<?php if ( have_posts() ) :
        // Do we have any posts/pages in the database that match our query?
        ?>

          <?php while ( have_posts() ) : the_post();
          // If we have a page to show, start a loop that will display it
          ?>

            <article class="primary">

              <?php if (!is_front_page()) : // Only if this page is NOT being used as a home page, display the title ?>
                <h1 class='title'>
                  <?php the_title(); // Display the page title ?>
                </h1>
              <?php endif; ?>

              <section class="the-content">
                <?php the_content();
                // This call the main content of the page, the stuff in the main text box while composing.
                // This will wrap everything in paragraph tags
                ?>

                <?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
              </section><!-- the-content -->

            </article>

          <?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

        <?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

          <article class="post error">
            <h1 class="404">Nothing has been posted like that yet</h1>
          </article>

        <?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>
        </div><!-- #content .site-content -->

      </section>

			<footer class="site-information card-footer fixed-bottom">
				<section class="social-media">
					social media
				</section>
				<section class="contact">
					<address class="email text-right" id="email">
						cjmtermini@thecreativityarchitect.com
					</address>
					<small class="copyright alignright" id="copyright">
						copyright
					</small>
				</section>

			</footer>
      </main>



    </div>
  </body>
</html>
