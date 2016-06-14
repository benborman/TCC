<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*---------------------------------------------------------------------------------*/
/* Team widget */
/*---------------------------------------------------------------------------------*/
class Woo_team extends WP_Widget {
	var $settings = array( 'title', 'post_count', 'avatar', 'name' );

	function Woo_team() {
		$widget_ops = array( 'description' => 'This Team widget displays a list of members in your blog.' );
		parent::WP_Widget( false, __( 'Woo - Team', 'woothemes' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = $this->woo_enforce_defaults( $instance );
		extract( $instance, EXTR_SKIP );

		echo $before_widget;
		if ( '' != $title )
			echo $before_title . apply_filters('widget_title', $title, $instance, $this->id_base) . $after_title;
		echo $after_title;

		// Get user role
		if ( 'all' == $user_role ) {
			$role = '';
		} else {
			$role = $user_role;
		}
		
		if ('adminstrator' == $user_role ){
			$role = 'tcc_editor';
		}
		
		
		

		// Turn comma list into array
		
		if ( ( isset( $user_ids ) )  && ( '' != $user_ids ) )
			$include = explode(',', $user_ids);
		else {
			$include = array();
		}

		// Get the users
		$authors = $this->woo_get_users( $users_per_page = 100, $paged = 1, $role, $order_by, $order, $usersearch = '' , $meta_query = array(), $include );
	
		echo '<ul>';	
		foreach($authors as $key => $author) {
			$count = $this->woo_get_user_post_count( $author->ID );
			echo '<li><a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '">';
			if ( isset( $instance['avatar'] ) && ( 1 == $instance['avatar'] ) ) { echo get_avatar( $author->user_email, 50 ); }
			if ( isset( $instance['name'] ) && ( 1 == $instance['name'] ) ) { echo '<span class="name">' . $author->display_name . '</span>'; }
			if ( isset( $instance['church'] ) && ( 1 == $instance['church'] ) ) { echo '<span class="church">' . $author->church . '</span>'; }
			if ( isset( $instance['location'] ) && ( 1 == $instance['location'] ) ) { echo '<span class="location">' . $author->location . '</span>'; }
			if ( isset( $instance['post_count'] ) && ( 1 == $instance['post_count'] ) ) { echo '<span class="post-count">' . sprintf( _n('%d post', '%d posts', $count, 'woothemes' ), $count ) . ' </span>'; }
			echo '</a></li>';
		}
		echo '</ul>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {	
			
		$instance = $old_instance;

		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['name'] = (bool) esc_attr( $new_instance['name'] );
		$instance['church'] = (bool) esc_attr( $new_instance['church'] );
		$instance['location'] = (bool) esc_attr( $new_instance['location'] );
		$instance['avatar'] = (bool) esc_attr( $new_instance['avatar'] );
		$instance['post_count'] = (bool) esc_attr( $new_instance['post_count'] );
		$instance['order_by'] = esc_attr( $new_instance['order_by'] );
		$instance['order'] = esc_attr( $new_instance['order'] );
		$instance['user_role'] = esc_attr( $new_instance['user_role'] );				
		$instance['user_ids'] = esc_attr( $new_instance['user_ids'] );				

		return $instance;

	}

	function woo_enforce_defaults( $instance ) {
		$defaults = $this->woo_get_settings();
		$instance = wp_parse_args( $instance, $defaults );

		return $instance;
	}

	/**
	 * Provides an array of the settings with the setting name as the key and the default value as the value
	 * This cannot be called get_settings() or it will override WP_Widget::get_settings()
	 */
	function woo_get_settings() {
		// Set the default to a blank string
		$settings = array_fill_keys( $this->settings, '' );
		// Now set the more specific defaults
		$settings['title'] = __('Our Team', 'woothemes');
		$settings['post_count'] = 1;
		$settings['avatar'] = 1;
		$settings['name'] = 1;
		$settings['church'] = 1;
		$settings['location'] = 1;
		$settings['order_by'] = 'login';
		$settings['order'] = 'ASC';
		$settings['user_role'] = 'all';				
		$settings['user_ids'] = '';				

		return $settings;
	}

	function form( $instance ) {
		$instance = $this->woo_enforce_defaults( $instance );
?>

			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"  />
			</p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('avatar'); ?>" class="checkbox" <?php checked( $instance['avatar'], 1 ); ?> /> 
				<label for="<?php echo $this->get_field_name('avatar'); ?>"><?php _e('Display Avatar?', 'woothemes'); ?></label>
			</p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('name'); ?>" class="checkbox" <?php checked( $instance['name'], 1 ); ?> /> 
				<label for="<?php echo $this->get_field_name('name'); ?>"><?php _e('Display Name?', 'woothemes'); ?></label>
			</p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('church'); ?>" class="checkbox" <?php checked( $instance['church'], 1 ); ?> /> 
				<label for="<?php echo $this->get_field_name('church'); ?>"><?php _e('Display Church?', 'woothemes'); ?></label>
			</p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('location'); ?>" class="checkbox" <?php checked( $instance['location'], 1 ); ?> /> 
				<label for="<?php echo $this->get_field_name('location'); ?>"><?php _e('Display Location?', 'woothemes'); ?></label>
			</p>
			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('post_count'); ?>" class="checkbox" <?php checked( $instance['post_count'], 1 ); ?> /> 
				<label for="<?php echo $this->get_field_name('post_count'); ?>"><?php _e('Display Post Count?', 'woothemes'); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_name('user_role'); ?>"><?php _e('User Role', 'woothemes'); ?></label><br />
				<select id="<?php echo $this->get_field_id('user_role'); ?>" name="<?php echo $this->get_field_name('user_role'); ?>">
				<?php 

					$roles = $this->woo_get_roles();

					echo '<option value="all">All</option>';

					foreach ( $roles as $id => $name ) {
						echo '<option value="' . $id . '"';
						if ( $instance['user_role'] == $id ) echo ' selected="selected"';
						echo '>';
						echo $name;
						echo '</option>';
					}
				?>
				</select>
			</p>			

			<p>
				<label for="<?php echo $this->get_field_name('order_by'); ?>"><?php _e('Order by', 'woothemes'); ?></label><br />
				<select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
				<?php 

					$order_by = array( 'id' => 'ID', 'display_name' => __('Display Name', 'woothemes'), 'login' => __('Login', 'woothemes'), 'post_count' => __('Post Count', 'woothemes') );

					foreach ( $order_by as $id => $name ) {
						echo '<option value="' . $id . '"';
						if ( $instance['order_by'] == $id ) echo ' selected="selected"';
						echo '>';
						echo $name;
						echo '</option>';
					}
				?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_name('order'); ?>"><?php _e('Order', 'woothemes'); ?></label><br />
				<select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<?php 

					$order = array( 'ASC' => __('Ascending', 'woothemes'), 'DESC' => __('Descending', 'woothemes') );

					foreach ( $order as $id => $name ) {
						echo '<option value="' . $id . '"';
						if ( $instance['order'] == $id ) echo ' selected="selected"';
						echo '>';
						echo $name;
						echo '</option>';
					}
				?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_name('user_ids'); ?>"><?php _e('Filter by user ID (comma separated)', 'woothemes'); ?></label><br />
		    	<input type="text" name="<?php echo $this->get_field_name('user_ids') ?>" id="<?php echo $this->get_field_id('user_ids') ?>" value="<?php echo $instance['user_ids'] ?>" size="20"> </p>
		    </p>

		<?php
	}

	function woo_get_user_post_count($id) {
	    global $wpdb;
	    $count = $wpdb->get_var("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND post_author = '$id' AND post_status = 'publish' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author");
	    return $count;
	}

	// Get users of the site
	function woo_get_users($users_per_page = 10, $paged = 1, $role = '', $orderby = 'login', $order = 'ASC', $usersearch = '' , $meta_query = array(), $include = array() ) {

		global $blog_id;
			
		$args = array(
				'number' => $users_per_page,
				'offset' => ( $paged-1 ) * $users_per_page,
				'role' => $role,
				'search' => $usersearch,
				'fields' => 'all_with_meta',
				'blog_id' => $blog_id,
				'orderby' => $orderby,
				'order' => $order,
				'meta_query' => $meta_query,
			);

		if ( !empty( $include ) )
			$args['include'] = $include;

		// Query the user IDs for this page
		$wp_user_search = new WP_User_Query( $args );

		$user_results = $wp_user_search->get_results();
		// $wp_user_search->get_total()
		
		return $user_results;
		
	} // End Function

	// Get Available Roles
	function woo_get_roles() {
		global $wp_roles;
		$roles = $wp_roles->get_names();
		return $roles;
	}

}

register_widget( 'woo_team' );
