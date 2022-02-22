<?php
/**
 * The template for displaying the Events
 *MYTHEME_events_bg_image
 * @package MYTHEME
 */


if ( ! function_exists( 'MYTHEME_events_display' ) ) :
	/**
	* Add Events
	*
	* @uses action hook MYTHEME_before_content.
	*
	* @since 1.0
	*/
	function MYTHEME_events_display() {
		$enable = get_theme_mod( 'MYTHEME_events_option', 'disabled' );
		$background_image = get_theme_mod( 'MYTHEME_events_bg_image' ); 

		if ( MYTHEME_check_section( $enable ) ) {
			$content_select = get_theme_mod( 'MYTHEME_events_type', 'category' );
			if( 'ect-event' == $content_select ) {
				$MYTHEME_title    = get_option( 'ect_event_title', esc_html__( 'Events', 'MYTHEME' ) );
				$MYTHEME_subtitle = get_option( 'ect_event_content' );
			} else {
				$MYTHEME_title    = get_theme_mod( 'MYTHEME_events_title' );
				$MYTHEME_subtitle = get_theme_mod( 'MYTHEME_events_subtitle' );
			}

			$classes[] = $content_select;

			if ( ! $MYTHEME_title && ! $MYTHEME_subtitle ) {
				$classes[] = 'no-section-heading';
			}

			if( $background_image ) {
				$classes[] = 'has-background-image';
			}

			$classes[] = 'single-layout';



			$output ='
				<div id="events-section" class="events-section section ' . esc_attr( implode( ' ', $classes ) ) . '">
					<div class="wrapper">';
						if ( $MYTHEME_title || $MYTHEME_subtitle ) {
							$output .='<div class="section-heading-wrapper">';

							if ( $MYTHEME_title ) {
								$output .='<div class="section-title-wrapper"><h2 class="section-title">' . wp_kses_post( $MYTHEME_title ) . '</h2></div>';
							}
							
							if( $MYTHEME_subtitle ) {
								$output .='<div class="section-description"><p>' . wp_kses_post( $MYTHEME_subtitle ) . '</p></div>';
							}

							$output .='</div><!-- .section-heading-wrap -->';
						}

						$output .='
						<div class="section-content-wrapper">';

							if ( 'post' === $content_select || 'page' === $content_select || 'category' === $content_select || 'ect-event' === $content_select ) {
								$output .= MYTHEME_post_page_category_events();
							} elseif ( 'custom' === $content_select ) {
								$output .= MYTHEME_custom_events();
							}


						$output .='</div><!-- .section-content-wrap -->';

			$target    = get_theme_mod( 'MYTHEME_events_target' ) ? '_blank': '_self';
			$link      = get_theme_mod( 'MYTHEME_events_link' );
			$more_text = get_theme_mod( 'MYTHEME_events_text');

			if ( $more_text ) {
				$output .= '
				<p class="view-more">
					<a class="button" target="' . $target . '" href="' . esc_url( $link ) . '">' . esc_html( $more_text ) . '</a>
				</p>';
			}
					$output .='</div><!-- .wrapper -->
				</div><!-- #events-section -->';

			echo $output;
		}
	}
endif;

if ( ! function_exists( 'MYTHEME_post_page_category_events' ) ) :
	/**
	 * Display Page/Post/Category Events
	 *
	 * @since 1.0
	 */
	function MYTHEME_post_page_category_events() {
		global $post;

		$quantity   = get_theme_mod( 'MYTHEME_events_number', 4 );
		$no_of_post = 0; // for number of posts
		$post_list  = array();// list of valid post/page ids
		$MYTHEME_type = get_theme_mod( 'MYTHEME_events_type', 'category' );
		$output     = '';

		$args = array(
			'post_type'           => 'any',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
		if ( 'post' == $MYTHEME_type || 'page' == $MYTHEME_type || 'ect-event' == $MYTHEME_type ) {
			for( $i = 1; $i <= $quantity; $i++ ){
				$post_id = '';

				if ( 'post' == $MYTHEME_type ) {
					$post_id = get_theme_mod( 'MYTHEME_events_post_' . $i );
				} elseif ( 'page' == $MYTHEME_type ) {
					$post_id = get_theme_mod( 'MYTHEME_events_page_' . $i ) ;
				} elseif ( 'ect-event' === $MYTHEME_type ) {
					$post_id = get_theme_mod( 'MYTHEME_events_cpt_' . $i );
				}

				if ( $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;
			$args['orderby'] = 'post__in';
		} elseif ( 'category' == $MYTHEME_type ) {
			$no_of_post = $quantity;

			if ( get_theme_mod( 'MYTHEME_events_select_category' ) ) {
				$args['category__in'] = (array) get_theme_mod( 'MYTHEME_events_select_category' );
			}

			$args['post_type'] = 'post';
		}

		if ( 0 == $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$output .= '
			<article id="event-post-' . esc_attr( $loop->current_post + 1 ) . '" class="event-list-item post hentry post">
			<div class="hentry-inner">';

			$output .= '<div class="entry-container">';

			if ( get_theme_mod( 'MYTHEME_events_display_date', 1 ) ) {
				$event_date_day        = get_the_date( 'j' );
				$event_date_month      = get_the_date( 'F' );
				$event_date_year       = get_the_date( 'Y' );
				$event_date_day_meta   = get_post_meta( $post->ID, 'MYTHEME-event-date-day', true );
				$event_date_month_meta = get_post_meta( $post->ID, 'MYTHEME-event-date-month', true );
				$event_date_year_meta  = get_post_meta( $post->ID, 'MYTHEME-event-date-year', true );

				if ( '' !== $event_date_day_meta ) {
					$event_date_day = $event_date_day_meta;
				}

				if ( '' !== $event_date_month_meta ) {
					$event_date_month = $event_date_month_meta;
					$event_date_month = date( 'F', mktime(0, 0, 0, absint( $event_date_month ), 10 ) );
				}

				if ( '' !== $event_date_year_meta ) {
					$event_date_year = $event_date_year_meta;
				}

				if( 'ect-event' == $MYTHEME_type ) {
					$ect_event_date = get_post_meta( get_the_ID(), 'ect_event_date', true );
					$date_string      = strtotime( $ect_event_date );
					$event_date_month = gmdate( 'M', $date_string );
					$event_date_day   = gmdate( 'd', $date_string );
					$event_date_year   = gmdate( 'Y', $date_string );
				}

				$output .= '<div class="entry-meta"><span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><time class="entry-date">
						<span class="date-week-day">' . esc_html( $event_date_day ) . '</span>
						<sep>/</sep>
						<div class="date-month-year">
							<span class="date-month">' . esc_html( $event_date_month ) . '</span>
							<span class="date-year">' . esc_html( $event_date_year ) . '</span>
						</div>
					</time></a></span></div>';
			}


			$output .= '<div class="event-list-description">';

			$output .= '<div class="event-title-wrap">';

			$output .= '<div class="entry-header">';

			if ( get_theme_mod( 'MYTHEME_events_enable_title', 1 ) ) {
				$output .= '
					<h2 class="entry-title">
						' . the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a>', false ) . '
					</h2>';
			}

			$output .= '</div>';

			$location_text = get_theme_mod( 'MYTHEME_events_location_text_' . absint( $loop->current_post + 1 ) ); 
			$time_text 	   = get_theme_mod( 'MYTHEME_events_time_' . absint( $loop->current_post + 1 ) );
 	
 			if( $location_text ) {
 				$output .= '<div class="location">
 								' . MYTHEME_get_svg( array( 'icon' => 'location', 'fallback' => true, ) ) . '
 								' . esc_html( $location_text ) . ' 	
 							</div>';
 			}
			
 			if( $time_text ) {
				$output .= '<div class="time">
								' . MYTHEME_get_svg( array( 'icon' => 'clock-o', 'fallback' => true, ) ) . '
								' . esc_html( $time_text ) . ' 	
							</div>';
			}			

			$output .= '</div><!-- .event-title -->';

			$more_text    = get_theme_mod( 'MYTHEME_events_individual_text_' . absint( $loop->current_post + 1 )  );
			
			if ( $more_text ) {
				$output .= '<div class="event-button"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="button ghost-button"><span>' . esc_html( $more_text ) . '</span></a></div>';
			}

			$output .= '</div><!-- .event-list-description -->';

			$output .= '
					</div><!-- .entry-container -->
				</div>
			</article><!-- .event-post-' . esc_attr( $loop->current_post + 1 ) . ' -->';
		} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // MYTHEME_post_page_category_events


if ( ! function_exists( 'MYTHEME_custom_events' ) ) :
	/**
	 * Display Custom Events
	 *
	 * @since 1.0
	 */
	function MYTHEME_custom_events() {
		$quantity = get_theme_mod( 'MYTHEME_events_number', 4 );
		$output   = '';

		for ( $i = 1; $i <= $quantity; $i++ ) {
			$target = get_theme_mod( 'MYTHEME_events_target_' . $i ) ? '_blank' : '_self';
			$more_text= get_theme_mod( 'MYTHEME_events_individual_text_' . $i );
			$link = get_theme_mod( 'MYTHEME_events_link_' . $i, '#' );

			//support qTranslate plugin
			if ( function_exists( 'qtrans_convertURL' ) ) {
				$link = qtrans_convertURL( $link );
			}

			$MYTHEME_title   = get_theme_mod( 'MYTHEME_events_title_' . $i );

			if ( class_exists( 'Polylang' ) ) {
				$MYTHEME_title = pll__( $MYTHEME_title );
			}

			$date_day = get_theme_mod( 'MYTHEME_events_date_day_' . $i );

			$date_month = get_theme_mod( 'MYTHEME_events_date_month_' . $i );

			$date_year = get_theme_mod( 'MYTHEME_events_date_year_' . $i, '2019' );

			if ( $date_month  ) {
				$date_month = date( 'F', mktime(0, 0, 0, $date_month, 10 ) );
			}

			$image = get_theme_mod( 'MYTHEME_events_image_' . $i );

			$output .= '
				<article id="event-post-' . esc_html( $i ) . '" class="event-list-item post hentry image">
					<div class="hentry-inner">';

					$output .=	'<div class="entry-container">';

					if ( $date_day || $date_month || $date_year ) {
						$output .= '<div class="entry-meta"><span class="posted-on"><a target="' . $target . '" href="' . esc_url( $link ) . '" rel="bookmark">
							<time class="entry-date">
								<span class="date-week-day">' . esc_html( $date_day ) . '</span>
								<sep>/</sep>
								<div class="date-month-year">
									<span class="date-month">' . esc_html( $date_month ) . '</span>
									<span class="date-year">' . esc_html( $date_year ) . '</span>
								</div>
							</time>
						</a></span></div>';
					}

					if ( $MYTHEME_title || $more_text ) {
						$output .= '<div class="event-list-description">';
						$output .= '<div class="event-title-wrap">';
					}

					if ( $MYTHEME_title ) {
						$output .= '
								<div class="event-title">
									<h2 class="entry-title">
										' . wp_kses_post( $MYTHEME_title ) . '
									</h2>
								</div>';
					}

					$location_text = get_theme_mod( 'MYTHEME_events_location_text_' . $i ); 
					$time_text 	   = get_theme_mod( 'MYTHEME_events_time_' . $i );

		 			if( $location_text ) {
		 				$output .= '<div class="location">
		 								' . MYTHEME_get_svg( array( 'icon' => 'location', 'fallback' => true, ) ) . '
		 								' . esc_html( $location_text ) . ' 	
		 							</div>';
		 			}
					
		 			if( $time_text ) {
						$output .= '<div class="time">
										' . MYTHEME_get_svg( array( 'icon' => 'clock-o', 'fallback' => true, ) ) . '
										' . esc_html( $time_text ) . ' 	
									</div>';
					}

					if ( $MYTHEME_title ) {

						$output .= '</div><!-- .event-list-description -->';
					}


					if( $more_text ) {
						$output .= '<div class="event-button"><a href="' . esc_url( $link ) . '" rel="bookmark" class="button ghost-button"><span>' . esc_html( $more_text ) . '</span></a></div>';
					}

					$output .= '
					</div><!-- .entry-container -->
					</div>
				</article><!-- .event-post-' . esc_attr( $i ) . ' -->';
		}
		return $output;
	}
endif; //MYTHEME_custom_events
