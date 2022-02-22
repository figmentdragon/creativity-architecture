<?php 
/************************************************/
## About me custom widget.
/************************************************/
class MYTHEME_socialicon_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct('MYTHEME_social', /* Unique widget ID */
			esc_html__('MYTHEME - Social Media URL', 'MYTHEME'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Social media URL widget.', 'MYTHEME' ), ) /* Widget description */
		);
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	public function widget( $args, $instance ) {
		
		$title = isset($instance['title']) ? esc_html($instance['title']) : '' ;
		$button_style = isset($instance['button_style']) ? esc_html($instance['button_style']) : '';
		$MYTHEME_fb_link      = isset($instance['MYTHEME_fb_url']) ? esc_url($instance['MYTHEME_fb_url']) : '';
		$MYTHEME_twitter_link = isset($instance['MYTHEME_twitter_url']) ? esc_url($instance['MYTHEME_twitter_url']) : '';
		$MYTHEME_insta_link   = isset($instance['MYTHEME_instagram_url']) ? esc_url($instance['MYTHEME_instagram_url']) : '';
		$MYTHEME_github_link   = isset($instance['MYTHEME_github_url']) ? esc_url($instance['MYTHEME_github_url']) : '';
		$MYTHEME_linked_link  = isset($instance['MYTHEME_linkedin_url']) ? esc_url($instance['MYTHEME_linkedin_url']) : '';
		$MYTHEME_ytube_link   = isset($instance['MYTHEME_youtube_url']) ? esc_url($instance['MYTHEME_youtube_url']) : '';
		$MYTHEME_pint_link    = isset($instance['MYTHEME_pinterest_url']) ? esc_url($instance['MYTHEME_pinterest_url']) : '';
		$MYTHEME_drib_link    = isset($instance['MYTHEME_dribble_url']) ? esc_url($instance['MYTHEME_dribble_url']) : '';
		
		/* This is where you run the code and display the output */
		$social_link_output ='<nav class="social-navigation '.$button_style.'"><ul>';
		
		if($MYTHEME_fb_link):
			$social_link_output .='<li><a href="'.$MYTHEME_fb_link.'"><span class="fa fa-facebook"></span></a></li>';
			
		endif;
		
		if($MYTHEME_twitter_link):
			$social_link_output .='<li><a href="'.$MYTHEME_twitter_link.'"><span class="fa fa-twitter"></span></a></li>';
			
		endif;

		if($MYTHEME_insta_link):
			$social_link_output .='<li><a href="'.$MYTHEME_insta_link.'"><span class="fa fa-instagram"></span></a></li>';
			
		endif;
		
		if($MYTHEME_github_link):
			$social_link_output .='<li><a href="'.$MYTHEME_github_link.'"><span class="fa fa-github"></span></a></li>';
			
		endif;
		
		if($MYTHEME_linked_link):
			$social_link_output .='<li><a href="'.$MYTHEME_linked_link.'"><span class="fa fa-linkedin"></span></a></li>';
			
		endif;
		
		if($MYTHEME_ytube_link):
			$social_link_output .='<li><a href="'.$MYTHEME_ytube_link.'"><span class="fa fa-youtube"></span></a></li>';
			
		endif;
		
		if($MYTHEME_pint_link):
			$social_link_output .='<li><a href="'.$MYTHEME_pint_link.'"><span class="fa fa-pinterest-p"></span></a></li>';
		endif;
		
		if($MYTHEME_drib_link):
			$social_link_output .='<li><a href="'.$MYTHEME_drib_link.'"><span class="fa fa-dribbble"></span></a></li>';
			
		endif;
		
		$social_link_output .= '</ul></nav>';
		
		
		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		
		echo $social_link_output;
		echo $args['after_widget'];
	}
	
	/****************************************/
	## Widget Backend 
	/****************************************/
	
	public function form( $instance ) {
		
		$title               = isset($instance['title']) ? esc_attr($instance['title']) : '' ;
		$button_style        = isset($instance['button_style']) ? esc_attr($instance['button_style']) : '';
		$MYTHEME_fb_link      = isset($instance['MYTHEME_fb_url']) ? esc_url($instance['MYTHEME_fb_url']) : '';
		$MYTHEME_twitter_link = isset($instance['MYTHEME_twitter_url']) ? esc_url($instance['MYTHEME_twitter_url']) : '';
		$MYTHEME_insta_link   = isset($instance['MYTHEME_instagram_url']) ? esc_url($instance['MYTHEME_instagram_url']) : '';
		$MYTHEME_github_link   = isset($instance['MYTHEME_github_url']) ? esc_url($instance['MYTHEME_github_url']) : '';
		$MYTHEME_linked_link  = isset($instance['MYTHEME_linkedin_url']) ? esc_url($instance['MYTHEME_linkedin_url']) : '';
		$MYTHEME_ytube_link   = isset($instance['MYTHEME_youtube_url']) ? esc_url($instance['MYTHEME_youtube_url']) : '';
		$MYTHEME_pint_link    = isset($instance['MYTHEME_pinterest_url']) ? esc_url($instance['MYTHEME_pinterest_url']) : '';
		$MYTHEME_drib_link    = isset($instance['MYTHEME_dribble_url']) ? esc_url($instance['MYTHEME_dribble_url']) : '';
		
	?>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'button_style' )); ?>">
			<?php esc_html_e( 'Social Button Style', 'MYTHEME' ); ?>
		</label>
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_style')); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_style')); ?>" style="width:100%;">
			<option value="<?php echo esc_attr('default-colors')?>" <?php selected( $button_style, 'default-colors' );?>><?php esc_html_e( 'Default Color', 'MYTHEME' ) ?></option>
			<option value="<?php echo esc_attr('theme-colors')?>" <?php  selected( $button_style, 'theme-colors' ); ?>><?php esc_html_e( 'Theme Color', 'MYTHEME' ) ?></option>
			<option value="<?php echo esc_attr('original-colors')?>" <?php selected( $button_style, 'original-colors' );  ?>><?php esc_html_e( 'Icon Original Color', 'MYTHEME' ) ?></option>
		</select>
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_fb_url' )); ?>"><?php esc_html_e( 'Facebook URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_fb_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_fb_url')); ?>" type="text" value="<?php echo $MYTHEME_fb_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('MYTHEME_twitter_url')); ?>"><?php esc_html_e('Twitter URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_twitter_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_twitter_url' )); ?>" type="text" value="<?php echo $MYTHEME_twitter_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('MYTHEME_instagram_url')); ?>"><?php esc_html_e( 'Instagram URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_instagram_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_instagram_url')); ?>" type="text" value="<?php echo $MYTHEME_insta_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_linkedin_url')); ?>"><?php esc_html_e( 'Linkedin URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_linkedin_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_linkedin_url')); ?>" type="text" value="<?php echo $MYTHEME_linked_link; ?>" />
	</p>
	
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_github_url' )); ?>"><?php esc_html_e( 'GitHub URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_github_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_github_url')); ?>" type="text" value="<?php echo $MYTHEME_github_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_youtube_url' )); ?>"><?php esc_html_e( 'YouTube URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_youtube_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_youtube_url' )); ?>" type="text" value="<?php echo $MYTHEME_ytube_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_pinterest_url' )); ?>"><?php esc_html_e( 'Pinterest URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_pinterest_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_pinterest_url' )); ?>" type="text" value="<?php echo $MYTHEME_pint_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'MYTHEME_dribble_url' )); ?>"><?php esc_html_e('Dribble URL', 'MYTHEME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'MYTHEME_dribble_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'MYTHEME_dribble_url')); ?>" type="text" value="<?php echo $MYTHEME_drib_link ; ?>" />
	</p>
	
	
	<?php 
	
	}
	
	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';
		
		$instance['button_style'] = ( ! empty( $new_instance['button_style'] ) ) ? esc_html( $new_instance['button_style'] ) : '';
		
		$instance['MYTHEME_fb_url'] = ( ! empty( $new_instance['MYTHEME_fb_url'] ) ) ? esc_url( $new_instance['MYTHEME_fb_url'] ) : '';
		
		$instance['MYTHEME_twitter_url'] = ( ! empty( $new_instance['MYTHEME_twitter_url'] ) ) ? esc_url( $new_instance['MYTHEME_twitter_url'] ) : '';
		
		$instance['MYTHEME_github_url'] = ( ! empty( $new_instance['MYTHEME_github_url'] ) ) ? esc_url( $new_instance['MYTHEME_github_url'] ) : '';
		
		$instance['MYTHEME_instagram_url'] = ( ! empty( $new_instance['MYTHEME_instagram_url'] ) ) ? esc_url( $new_instance['MYTHEME_instagram_url'] ) : '';
		
		$instance['MYTHEME_linkedin_url'] = ( ! empty( $new_instance['MYTHEME_linkedin_url'] ) ) ? esc_url( $new_instance['MYTHEME_linkedin_url'] ) : '';
		
		$instance['MYTHEME_youtube_url'] = ( ! empty( $new_instance['MYTHEME_youtube_url'] ) ) ? esc_url( $new_instance['MYTHEME_youtube_url'] ) : '';
		
		$instance['MYTHEME_pinterest_url'] = ( ! empty( $new_instance['MYTHEME_pinterest_url'] ) ) ? esc_url( $new_instance['MYTHEME_pinterest_url'] ) : '';
		
		$instance['MYTHEME_dribble_url'] = ( ! empty( $new_instance['MYTHEME_dribble_url'] ) ) ? esc_url( $new_instance['MYTHEME_dribble_url'] ) : '';
		
		return $instance;
	}
} /* class end */

// Register and load the widget
register_widget( 'MYTHEME_socialicon_widget' );


?>