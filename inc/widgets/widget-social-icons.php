<?php 
/************************************************/
## About me custom widget.
/************************************************/
class THEMENAME_socialicon_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct('THEMENAME_social', /* Unique widget ID */
			esc_html__('THEMENAME - Social Media URL', 'THEMENAME'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Social media URL widget.', 'THEMENAME' ), ) /* Widget description */
		);
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	public function widget( $args, $instance ) {
		
		$title = isset($instance['title']) ? esc_html($instance['title']) : '' ;
		$button_style = isset($instance['button_style']) ? esc_html($instance['button_style']) : '';
		$THEMENAME_fb_link      = isset($instance['THEMENAME_fb_url']) ? esc_url($instance['THEMENAME_fb_url']) : '';
		$THEMENAME_twitter_link = isset($instance['THEMENAME_twitter_url']) ? esc_url($instance['THEMENAME_twitter_url']) : '';
		$THEMENAME_insta_link   = isset($instance['THEMENAME_instagram_url']) ? esc_url($instance['THEMENAME_instagram_url']) : '';
		$THEMENAME_github_link   = isset($instance['THEMENAME_github_url']) ? esc_url($instance['THEMENAME_github_url']) : '';
		$THEMENAME_linked_link  = isset($instance['THEMENAME_linkedin_url']) ? esc_url($instance['THEMENAME_linkedin_url']) : '';
		$THEMENAME_ytube_link   = isset($instance['THEMENAME_youtube_url']) ? esc_url($instance['THEMENAME_youtube_url']) : '';
		$THEMENAME_pint_link    = isset($instance['THEMENAME_pinterest_url']) ? esc_url($instance['THEMENAME_pinterest_url']) : '';
		$THEMENAME_drib_link    = isset($instance['THEMENAME_dribble_url']) ? esc_url($instance['THEMENAME_dribble_url']) : '';
		
		/* This is where you run the code and display the output */
		$social_link_output ='<nav class="social-navigation '.$button_style.'"><ul>';
		
		if($THEMENAME_fb_link):
			$social_link_output .='<li><a href="'.$THEMENAME_fb_link.'"><span class="fa fa-facebook"></span></a></li>';
			
		endif;
		
		if($THEMENAME_twitter_link):
			$social_link_output .='<li><a href="'.$THEMENAME_twitter_link.'"><span class="fa fa-twitter"></span></a></li>';
			
		endif;

		if($THEMENAME_insta_link):
			$social_link_output .='<li><a href="'.$THEMENAME_insta_link.'"><span class="fa fa-instagram"></span></a></li>';
			
		endif;
		
		if($THEMENAME_github_link):
			$social_link_output .='<li><a href="'.$THEMENAME_github_link.'"><span class="fa fa-github"></span></a></li>';
			
		endif;
		
		if($THEMENAME_linked_link):
			$social_link_output .='<li><a href="'.$THEMENAME_linked_link.'"><span class="fa fa-linkedin"></span></a></li>';
			
		endif;
		
		if($THEMENAME_ytube_link):
			$social_link_output .='<li><a href="'.$THEMENAME_ytube_link.'"><span class="fa fa-youtube"></span></a></li>';
			
		endif;
		
		if($THEMENAME_pint_link):
			$social_link_output .='<li><a href="'.$THEMENAME_pint_link.'"><span class="fa fa-pinterest-p"></span></a></li>';
		endif;
		
		if($THEMENAME_drib_link):
			$social_link_output .='<li><a href="'.$THEMENAME_drib_link.'"><span class="fa fa-dribbble"></span></a></li>';
			
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
		$THEMENAME_fb_link      = isset($instance['THEMENAME_fb_url']) ? esc_url($instance['THEMENAME_fb_url']) : '';
		$THEMENAME_twitter_link = isset($instance['THEMENAME_twitter_url']) ? esc_url($instance['THEMENAME_twitter_url']) : '';
		$THEMENAME_insta_link   = isset($instance['THEMENAME_instagram_url']) ? esc_url($instance['THEMENAME_instagram_url']) : '';
		$THEMENAME_github_link   = isset($instance['THEMENAME_github_url']) ? esc_url($instance['THEMENAME_github_url']) : '';
		$THEMENAME_linked_link  = isset($instance['THEMENAME_linkedin_url']) ? esc_url($instance['THEMENAME_linkedin_url']) : '';
		$THEMENAME_ytube_link   = isset($instance['THEMENAME_youtube_url']) ? esc_url($instance['THEMENAME_youtube_url']) : '';
		$THEMENAME_pint_link    = isset($instance['THEMENAME_pinterest_url']) ? esc_url($instance['THEMENAME_pinterest_url']) : '';
		$THEMENAME_drib_link    = isset($instance['THEMENAME_dribble_url']) ? esc_url($instance['THEMENAME_dribble_url']) : '';
		
	?>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'button_style' )); ?>">
			<?php esc_html_e( 'Social Button Style', 'THEMENAME' ); ?>
		</label>
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_style')); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_style')); ?>" style="width:100%;">
			<option value="<?php echo esc_attr('default-colors')?>" <?php selected( $button_style, 'default-colors' );?>><?php esc_html_e( 'Default Color', 'THEMENAME' ) ?></option>
			<option value="<?php echo esc_attr('theme-colors')?>" <?php  selected( $button_style, 'theme-colors' ); ?>><?php esc_html_e( 'Theme Color', 'THEMENAME' ) ?></option>
			<option value="<?php echo esc_attr('original-colors')?>" <?php selected( $button_style, 'original-colors' );  ?>><?php esc_html_e( 'Icon Original Color', 'THEMENAME' ) ?></option>
		</select>
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_fb_url' )); ?>"><?php esc_html_e( 'Facebook URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_fb_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_fb_url')); ?>" type="text" value="<?php echo $THEMENAME_fb_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('THEMENAME_twitter_url')); ?>"><?php esc_html_e('Twitter URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_twitter_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_twitter_url' )); ?>" type="text" value="<?php echo $THEMENAME_twitter_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('THEMENAME_instagram_url')); ?>"><?php esc_html_e( 'Instagram URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_instagram_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_instagram_url')); ?>" type="text" value="<?php echo $THEMENAME_insta_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_linkedin_url')); ?>"><?php esc_html_e( 'Linkedin URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_linkedin_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_linkedin_url')); ?>" type="text" value="<?php echo $THEMENAME_linked_link; ?>" />
	</p>
	
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_github_url' )); ?>"><?php esc_html_e( 'GitHub URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_github_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_github_url')); ?>" type="text" value="<?php echo $THEMENAME_github_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_youtube_url' )); ?>"><?php esc_html_e( 'YouTube URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_youtube_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_youtube_url' )); ?>" type="text" value="<?php echo $THEMENAME_ytube_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_pinterest_url' )); ?>"><?php esc_html_e( 'Pinterest URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_pinterest_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_pinterest_url' )); ?>" type="text" value="<?php echo $THEMENAME_pint_link; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'THEMENAME_dribble_url' )); ?>"><?php esc_html_e('Dribble URL', 'THEMENAME' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'THEMENAME_dribble_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'THEMENAME_dribble_url')); ?>" type="text" value="<?php echo $THEMENAME_drib_link ; ?>" />
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
		
		$instance['THEMENAME_fb_url'] = ( ! empty( $new_instance['THEMENAME_fb_url'] ) ) ? esc_url( $new_instance['THEMENAME_fb_url'] ) : '';
		
		$instance['THEMENAME_twitter_url'] = ( ! empty( $new_instance['THEMENAME_twitter_url'] ) ) ? esc_url( $new_instance['THEMENAME_twitter_url'] ) : '';
		
		$instance['THEMENAME_github_url'] = ( ! empty( $new_instance['THEMENAME_github_url'] ) ) ? esc_url( $new_instance['THEMENAME_github_url'] ) : '';
		
		$instance['THEMENAME_instagram_url'] = ( ! empty( $new_instance['THEMENAME_instagram_url'] ) ) ? esc_url( $new_instance['THEMENAME_instagram_url'] ) : '';
		
		$instance['THEMENAME_linkedin_url'] = ( ! empty( $new_instance['THEMENAME_linkedin_url'] ) ) ? esc_url( $new_instance['THEMENAME_linkedin_url'] ) : '';
		
		$instance['THEMENAME_youtube_url'] = ( ! empty( $new_instance['THEMENAME_youtube_url'] ) ) ? esc_url( $new_instance['THEMENAME_youtube_url'] ) : '';
		
		$instance['THEMENAME_pinterest_url'] = ( ! empty( $new_instance['THEMENAME_pinterest_url'] ) ) ? esc_url( $new_instance['THEMENAME_pinterest_url'] ) : '';
		
		$instance['THEMENAME_dribble_url'] = ( ! empty( $new_instance['THEMENAME_dribble_url'] ) ) ? esc_url( $new_instance['THEMENAME_dribble_url'] ) : '';
		
		return $instance;
	}
} /* class end */

// Register and load the widget
register_widget( 'THEMENAME_socialicon_widget' );


?>