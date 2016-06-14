<?php

if ( ! defined( 'ABSPATH' ) ) exit;
/*---------------------------------------------------------------------------------*/
/* Ads widget */
/*---------------------------------------------------------------------------------*/
class Ad_Widget extends WP_Widget 
{
function __construct() {
	parent::__construct(
		'ad_widget', // Base ID
		'Ad Widget', // Name
		array('description' => __( 'For Managing and Displaying Ads'))
	   );
}
function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberOfAds'] = strip_tags($new_instance['numberOfAds']);
		$instance['advertiser'] = strip_tags($new_instance['advertiser']);
		return $instance;
}

function form($instance) {
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberOfAds = esc_attr($instance['numberOfAds']);
		$advertiser = esc_attr($instance['advertiser']);
	} else {
		$title = '';
		$numberOfAds = '';
		$advertiser = '';
	}
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', '_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('advertiser'); ?>"><?php _e('Advertiser:', '_widget'); ?></label>		
		
			<?php
			//list terms in a given taxonomy (useful as a widget for twentyten)
			$taxonomy = 'advertiser';
			$tax_terms = get_terms($taxonomy);
			?>
			<select id="<?php echo $this->get_field_id('advertiser'); ?>"  name="<?php echo $this->get_field_name('advertiser'); ?>">
				<?php
					foreach ($tax_terms as $tax_term) { ?>
					
					<option value="<?php echo $tax_term->slug ?>" <?php selected( $instance['advertiser'], $tax_term->slug) ?> > <?php echo $tax_term->name ?></option>
					
		<?php } ?>  

		</select>
		</p>	 
		<p>
		<label for="<?php echo $this->get_field_id('numberOfAds'); ?>"><?php _e('Number of Ads:', '_widget'); ?></label>		
		<select id="<?php echo $this->get_field_id('numberOfAds'); ?>"  name="<?php echo $this->get_field_name('numberOfAds'); ?>">
			<?php for($x=1;$x<=10;$x++): ?>
			<option <?php echo $x == $numberOfAds ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
			<?php endfor;?>
		</select>
		</p>		 
	<?php
	}
	
		function widget($args, $instance) { 
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$numberOfAds = $instance['numberOfAds'];
		$advertiser = $instance['advertiser'];
		echo $before_widget;
		if ( '' != $title )
		echo $before_title . apply_filters('widget_title', $title, $instance, $this->id_base);
		echo $after_title;
		?>
		<?php 
		
		query_posts(array('post_type' => 'ads' , 'orderby' => 'rand', 'advertiser' => $advertiser, 'showposts' => $numberOfAds)); 
		global $post;
        if(have_posts()) : while(have_posts()) : the_post(); ?>
        <?php
        $url = get_post_meta($post->ID, "adurl", true); 
        echo "<a target=\"_blank\" href=\"$url\"  onclick=\"trackOutboundLink('$url'); return false;\">";
		the_post_thumbnail();
		echo "</a>";
		endwhile; 
		endif; 
		wp_reset_query(); 
		

		
		echo $after_widget;
	}

 
} //end class Ad_Widget
register_widget('Ad_Widget');




	
	