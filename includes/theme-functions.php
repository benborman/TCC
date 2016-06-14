<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Exclude categories from displaying on the "Blog" page template.
- Exclude categories from displaying on the homepage.
- Register WP Menus
- Breadcrumb display
- Page navigation
- Post Meta
- Subscribe & Connect
- Comment Form Fields
- Comment Form Settings
- Archive Description
- WooPagination markup
- Google maps (for contact template)
- Featured Slider: Post Type
- Featured Slider: Hook Into Content
- Featured Slider: Get Slides
- Is IE
- Check if WooCommerce is activated
- Get Menu Name
- Add Lightbox to Galleries

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the "Blog" page template.
/*-----------------------------------------------------------------------------------*/

// Exclude categories on the "Blog" page template.
add_filter( 'woo_blog_template_query_args', 'woo_exclude_categories_blogtemplate' );

function woo_exclude_categories_blogtemplate ( $args ) {

	if ( ! function_exists( 'woo_prepare_category_ids_from_option' ) ) { return $args; }

	$excluded_cats = array();

	// Process the category data and convert all categories to IDs.
	$excluded_cats = woo_prepare_category_ids_from_option( 'woo_exclude_cats_blog' );

	// Homepage logic.
	if ( count( $excluded_cats ) > 0 ) {

		// Setup the categories as a string, because "category__not_in" doesn't seem to work
		// when using query_posts().

		foreach ( $excluded_cats as $k => $v ) { $excluded_cats[$k] = '-' . $v; }
		$cats = join( ',', $excluded_cats );

		$args['cat'] = $cats;
	}

	return $args;

} // End woo_exclude_categories_blogtemplate()

/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the homepage.
/*-----------------------------------------------------------------------------------*/

// Exclude categories on the homepage.
add_filter( 'pre_get_posts', 'woo_exclude_categories_homepage' );

function woo_exclude_categories_homepage ( $query ) {

	if ( ! function_exists( 'woo_prepare_category_ids_from_option' ) ) { return $query; }

	$excluded_cats = array();

	// Process the category data and convert all categories to IDs.
	$excluded_cats = woo_prepare_category_ids_from_option( 'woo_exclude_cats_home' );

	// Homepage logic.
	if ( is_home() && ( count( $excluded_cats ) > 0 ) ) {
		$query->set( 'category__not_in', $excluded_cats );
	}

	$query->parse_query();

	return $query;

} // End woo_exclude_categories_homepage()

/*-----------------------------------------------------------------------------------*/
/* Register WP Menus */
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
	register_nav_menus( array( 'primary-menu' => __( 'Primary Menu', 'woothemes' ) ) );
	register_nav_menus( array( 'top-menu' => __( 'Top Menu', 'woothemes' ) ) );
	register_nav_menus( array( 'footer-menu' => __( 'Footer Menu', 'woothemes' ) ) );	
}

/*-----------------------------------------------------------------------------------*/
/* Breadcrumb display */
/*-----------------------------------------------------------------------------------*/

add_action('woo_main_before','woo_display_breadcrumbs',10);
if (!function_exists( 'woo_display_breadcrumbs')) {
	function woo_display_breadcrumbs() {
		global $woo_options;
		if ( isset( $woo_options['woo_breadcrumbs_show'] ) && $woo_options['woo_breadcrumbs_show'] == 'true' ) {
		echo '<section id="breadcrumbs"><div class="col-full">';
			woo_breadcrumbs();
		echo '</div></section><!--/#breadcrumbs -->';
		}
	} // End woo_display_breadcrumbs()
} // End IF Statement


/*-----------------------------------------------------------------------------------*/
/* Page navigation */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'woo_pagenav')) {
	function woo_pagenav() {

		global $woo_options;

		// If the user has set the option to use simple paging links, display those. By default, display the pagination.
		if ( array_key_exists( 'woo_pagination_type', $woo_options ) && $woo_options[ 'woo_pagination_type' ] == 'simple' ) {
			if ( get_next_posts_link() || get_previous_posts_link() ) {
		?>
            <nav class="nav-entries fix">
                <?php next_posts_link( '<span class="nav-prev fl">'. __( '<span class="meta-nav">&larr;</span> Older posts', 'woothemes' ) . '</span>' ); ?>
                <?php previous_posts_link( '<span class="nav-next fr">'. __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'woothemes' ) . '</span>' ); ?>
            </nav>
		<?php
			}
		} else {
			woo_pagination();

		} // End IF Statement

	} // End woo_pagenav()
} // End IF Statement


/*-----------------------------------------------------------------------------------*/
/* Post Meta */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'woo_post_meta')) {
	function woo_post_meta( ) {
?>
<aside class="post-meta">
	<ul>
		<li class="post-date">
			<span><?php the_time( get_option( 'date_format' ) ); ?></span>
		</li>
		<li class="post-author">
			<span class="small">/</span>
			<?php the_author_posts_link(); ?>
		</li>
		<li class="post-category">
			<span class="small">/</span>
			<?php the_category( ', ') ?>
		</li>
		<li class="post-comments">
			<span class="small">/</span>
			<?php comments_popup_link( __( 'Leave a comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?>
		</li>		
		<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '/ <li class="edit">', '</li>' ); ?>
	</ul>
</aside>
<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/* Subscribe / Connect */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'woo_subscribe_connect')) {
	function woo_subscribe_connect($widget = 'false', $title = '', $form = '', $social = '', $contact_template = 'false') {

		//Setup default variables, overriding them if the "Theme Options" have been saved.
		$settings = array(
						'connect' => 'false',
						'connect_title' => __('Subscribe' , 'woothemes'),
						'connect_related' => 'true',
						'connect_content' => __( 'Subscribe to our e-mail newsletter to receive updates.', 'woothemes' ),
						'connect_newsletter_id' => '',
						'connect_mailchimp_list_url' => '',
						'feed_url' => '',
						'connect_rss' => '',
						'connect_twitter' => '',
						'connect_facebook' => '',
						'connect_youtube' => '',
						'connect_flickr' => '',
						'connect_linkedin' => '',
						'connect_delicious' => '',
						'connect_rss' => '',
						'connect_googleplus' => '',
						'connect_dribbble' => '',
						'connect_instagram' => '',
						'connect_vimeo' => '',
						'connect_pinterest' => ''
						);
		$settings = woo_get_dynamic_values( $settings );

		// Setup title
		if ( $widget != 'true' )
			$title = $settings[ 'connect_title' ];

		// Setup related post (not in widget)
		$related_posts = '';
		if ( $settings[ 'connect_related' ] == "true" AND $widget != "true" )
			$related_posts = do_shortcode( '[related_posts limit="5"]' );

?>
	<?php if ( $settings[ 'connect' ] == "true" OR $widget == 'true' ) : ?>
	<aside id="connect" class="fix">
		<h3><?php if ( $title ) echo apply_filters( 'widget_title', $title ); else _e('Subscribe','woothemes'); ?></h3>

		<div>
			<?php if ($settings[ 'connect_content' ] != '' AND $contact_template == 'false') echo '<p>' . stripslashes($settings[ 'connect_content' ]) . '</p>'; ?>

			<?php if ( $settings[ 'connect_newsletter_id' ] != "" AND $form != 'on' ) : ?>
			<form class="newsletter-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $settings[ 'connect_newsletter_id' ]; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520' );return true">
				<input class="email" type="text" name="email" value="<?php esc_attr_e( 'E-mail', 'woothemes' ); ?>" onfocus="if (this.value == '<?php _e( 'E-mail', 'woothemes' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'E-mail', 'woothemes' ); ?>';}" />
				<input type="hidden" value="<?php echo $settings[ 'connect_newsletter_id' ]; ?>" name="uri"/>
				<input type="hidden" value="<?php bloginfo( 'name' ); ?>" name="title"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input class="submit" type="submit" name="submit" value="<?php _e( 'Submit', 'woothemes' ); ?>" />
			</form>
			<?php endif; ?>

			<?php if ( $settings['connect_mailchimp_list_url'] != "" AND $form != 'on' AND $settings['connect_newsletter_id'] == "" ) : ?>
			<!-- Begin MailChimp Signup Form -->
			<div id="mc_embed_signup">
				<form class="newsletter-form<?php if ( $related_posts == '' ) echo ' fl'; ?>" action="<?php echo $settings['connect_mailchimp_list_url']; ?>" method="post" target="popupwindow" onsubmit="window.open('<?php echo $settings['connect_mailchimp_list_url']; ?>', 'popupwindow', 'scrollbars=yes,width=650,height=520');return true">
					<input type="text" name="EMAIL" class="required email" value="<?php _e('E-mail','woothemes'); ?>"  id="mce-EMAIL" onfocus="if (this.value == '<?php _e('E-mail','woothemes'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('E-mail','woothemes'); ?>';}">
					<input type="submit" value="<?php _e('Submit', 'woothemes'); ?>" name="subscribe" id="mc-embedded-subscribe" class="btn submit button">
				</form>
			</div>
			<!--End mc_embed_signup-->
			<?php endif; ?>

			<?php if ( $social != 'on' ) : ?>
			<div class="social">
		   		<?php if ( $settings['connect_rss' ] == "true" ) { ?>
		   		<a target="_blank" href="<?php if ( $settings['feed_url'] ) { echo esc_url( $settings['feed_url'] ); } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="subscribe" title="RSS"></a>

		   		<?php } if ( $settings['connect_twitter' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_twitter'] ); ?>" class="twitter" title="Twitter"></a>

		   		<?php } if ( $settings['connect_facebook' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_facebook'] ); ?>" class="facebook" title="Facebook"></a>

		   		<?php } if ( $settings['connect_youtube' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_youtube'] ); ?>" class="youtube" title="YouTube"></a>

		   		<?php } if ( $settings['connect_flickr' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_flickr'] ); ?>" class="flickr" title="Flickr"></a>

		   		<?php } if ( $settings['connect_linkedin' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_linkedin'] ); ?>" class="linkedin" title="LinkedIn"></a>

		   		<?php } if ( $settings['connect_delicious' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_delicious'] ); ?>" class="delicious" title="Delicious"></a>

		   		<?php } if ( $settings['connect_googleplus' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_googleplus'] ); ?>" class="googleplus" title="Google+"></a>

				<?php } if ( $settings['connect_dribbble' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_dribbble'] ); ?>" class="dribbble" title="Dribbble"></a>

				<?php } if ( $settings['connect_instagram' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_instagram'] ); ?>" class="instagram" title="Instagram"></a>

				<?php } if ( $settings['connect_vimeo' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_vimeo'] ); ?>" class="vimeo" title="Vimeo"></a>

				<?php } if ( $settings['connect_pinterest' ] != "" ) { ?>
		   		<a target="_blank" href="<?php echo esc_url( $settings['connect_pinterest'] ); ?>" class="pinterest" title="Pinterest"></a>

				<?php } ?>
			</div>
			<?php endif; ?>

		</div>

	</aside>

	<?php if ( $settings['connect_related' ] == "true" AND $related_posts != '' ) : ?>
	<div id="related-posts">
	    <h4><?php _e( 'Related Posts:', 'woothemes' ); ?></h4>
	    <?php echo $related_posts; ?>
	</div><!-- col-right -->
	<?php wp_reset_query(); endif; ?>

	<?php endif; ?>
<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Comment Form Fields */
/*-----------------------------------------------------------------------------------*/

	add_filter( 'comment_form_default_fields', 'woo_comment_form_fields' );

	if ( ! function_exists( 'woo_comment_form_fields' ) ) {
		function woo_comment_form_fields ( $fields ) {

			$commenter = wp_get_current_commenter();

			$required_text = ' <span class="required">(' . __( 'Required', 'woothemes' ) . ')</span>';

			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$fields =  array(
				'author' => '<p class="comment-form-author">' .
							'<input id="author" class="txt" name="author" type="text" onFocus="clearText(this)" onBlur="clearText(this)" value="' . ( $commenter['comment_author'] ? esc_attr( $commenter['comment_author'] ) : __( 'Name', 'woothemes' ) ) . '" size="30"' . $aria_req . ' />' .
							'</p>',
				'email'  => '<p class="comment-form-email">' .
				            '<input id="email" class="txt" name="email" type="text" onFocus="clearText(this)" onBlur="clearText(this)" value="' . ( $commenter['comment_author_email'] ? esc_attr( $commenter['comment_author_email'] ) : __( 'Mail (will not be published)', 'woothemes' ) ) . '" size="30"' . $aria_req . ' />' .
				            '</p>',
				'url'    => '<p class="comment-form-url">' .
				            '<input id="url" class="txt" name="url" type="text" onFocus="clearText(this)" onBlur="clearText(this)" value="' . ( $commenter['comment_author_url'] ? esc_attr( $commenter['comment_author_url'] ) : __( 'Website', 'woothemes' ) ) . '" size="30" />' .
				            '</p>',
			);

			return $fields;

		} // End woo_comment_form_fields()
	}

/*-----------------------------------------------------------------------------------*/
/* Comment Form Settings */
/*-----------------------------------------------------------------------------------*/

	add_filter( 'comment_form_defaults', 'woo_comment_form_settings' );

	if ( ! function_exists( 'woo_comment_form_settings' ) ) {
		function woo_comment_form_settings ( $settings ) {

			$settings['comment_notes_before'] = '';
			$settings['comment_notes_after'] = '';
			$settings['label_submit'] = __( 'Submit Comment', 'woothemes' );
			$settings['cancel_reply_link'] = __( 'Click here to cancel reply.', 'woothemes' );

			return $settings;

		} // End woo_comment_form_settings()
	}

	/*-----------------------------------------------------------------------------------*/
	/* Misc back compat */
	/*-----------------------------------------------------------------------------------*/

	// array_fill_keys doesn't exist in PHP < 5.2
	// Can remove this after PHP <  5.2 support is dropped
	if ( !function_exists( 'array_fill_keys' ) ) {
		function array_fill_keys( $keys, $value ) {
			return array_combine( $keys, array_fill( 0, count( $keys ), $value ) );
		}
	}

/*-----------------------------------------------------------------------------------*/
/**
 * woo_archive_description()
 *
 * Display a description, if available, for the archive being viewed (category, tag, other taxonomy).
 *
 * @since V1.0.0
 * @uses do_atomic(), get_queried_object(), term_description()
 * @echo string
 * @filter woo_archive_description
 */

if ( ! function_exists( 'woo_archive_description' ) ) {
	function woo_archive_description ( $echo = true ) {
		do_action( 'woo_archive_description' );

		// Archive Description, if one is available.
		$term_obj = get_queried_object();
		$description = term_description( $term_obj->term_id, $term_obj->taxonomy );

		if ( $description != '' ) {
			// Allow child themes/plugins to filter here ( 1: text in DIV and paragraph, 2: term object )
			$description = apply_filters( 'woo_archive_description', '<div class="archive-description">' . $description . '</div><!--/.archive-description-->', $term_obj );
		}

		if ( $echo != true ) { return $description; }

		echo $description;
	} // End woo_archive_description()
}

/*-----------------------------------------------------------------------------------*/
/* WooPagination Markup */
/*-----------------------------------------------------------------------------------*/

add_filter( 'woo_pagination_args', 'woo_pagination_html5_markup', 2 );

function woo_pagination_html5_markup ( $args ) {
	$args['before'] = '<nav class="pagination woo-pagination">';
	$args['after'] = '</nav>';

	return $args;
} // End woo_pagination_html5_markup()


/*-----------------------------------------------------------------------------------*/
/* Google Maps */
/*-----------------------------------------------------------------------------------*/

function woo_maps_contact_output($args){

	$key = get_option('woo_maps_apikey');

	// No More API Key needed

	if ( !is_array($args) )
		parse_str( $args, $args );

	extract($args);
	$mode = '';
	$streetview = 'off';
	$map_height = get_option('woo_maps_single_height');
	$featured_w = get_option('woo_home_featured_w');
	$featured_h = get_option('woo_home_featured_h');
	$zoom = get_option('woo_maps_default_mapzoom');
	$type = get_option('woo_maps_default_maptype');
	$marker_title = get_option('woo_contact_title');
	if ( $zoom == '' ) { $zoom = 6; }
	$lang = get_option('woo_maps_directions_locale');
	$locale = '';
	if(!empty($lang)){
		$locale = ',locale :"'.$lang.'"';
	}
	$extra_params = ',{travelMode:G_TRAVEL_MODE_WALKING,avoidHighways:true '.$locale.'}';

	if(empty($map_height)) { $map_height = 250;}

	if(is_home() && !empty($featured_h) && !empty($featured_w)){
	?>
    <div id="single_map_canvas" style="width:<?php echo $featured_w; ?>px; height: <?php echo $featured_h; ?>px"></div>
    <?php } else { ?>
    <div id="single_map_canvas" style="width:100%; height: <?php echo $map_height; ?>px"></div>
    <?php } ?>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			function initialize() {


			<?php if($streetview == 'on'){ ?>


			<?php } else { ?>

			  	<?php switch ($type) {
			  			case 'G_NORMAL_MAP':
			  				$type = 'ROADMAP';
			  				break;
			  			case 'G_SATELLITE_MAP':
			  				$type = 'SATELLITE';
			  				break;
			  			case 'G_HYBRID_MAP':
			  				$type = 'HYBRID';
			  				break;
			  			case 'G_PHYSICAL_MAP':
			  				$type = 'TERRAIN';
			  				break;
			  			default:
			  				$type = 'ROADMAP';
			  				break;
			  	} ?>

			  	var myLatlng = new google.maps.LatLng(<?php echo $geocoords; ?>);
				var myOptions = {
				  zoom: <?php echo $zoom; ?>,
				  center: myLatlng,
				  mapTypeId: google.maps.MapTypeId.<?php echo $type; ?>
				};
				<?php if(get_option('woo_maps_scroll') == 'true'){ ?>
			  	myOptions.scrollwheel = false;
			  	<?php } ?>
			  	var map = new google.maps.Map(document.getElementById("single_map_canvas"),  myOptions);

				<?php if($mode == 'directions'){ ?>
			  	directionsPanel = document.getElementById("featured-route");
 				directions = new GDirections(map, directionsPanel);
  				directions.load("from: <?php echo $from; ?> to: <?php echo $to; ?>" <?php if($walking == 'on'){ echo $extra_params;} ?>);
			  	<?php
			 	} else { ?>

			  		var point = new google.maps.LatLng(<?php echo $geocoords; ?>);
	  				var root = "<?php echo esc_url( get_template_directory_uri() ); ?>";
	  				var callout = '<?php echo preg_replace("/[\n\r]/","<br/>",get_option('woo_maps_callout_text')); ?>';
	  				var the_link = '<?php echo get_permalink(get_the_id()); ?>';
	  				<?php $title = str_replace(array('&#8220;','&#8221;'),'"', $marker_title); ?>
	  				<?php $title = str_replace('&#8211;','-',$title); ?>
	  				<?php $title = str_replace('&#8217;',"`",$title); ?>
	  				<?php $title = str_replace('&#038;','&',$title); ?>
	  				var the_title = '<?php echo html_entity_decode($title) ?>';

	  			<?php
			 	if(is_page()){
			 		$custom = get_option('woo_cat_custom_marker_pages');
					if(!empty($custom)){
						$color = $custom;
					}
					else {
						$color = get_option('woo_cat_colors_pages');
						if (empty($color)) {
							$color = 'red';
						}
					}
			 	?>
			 		var color = '<?php echo $color; ?>';
			 		createMarker(map,point,root,the_link,the_title,color,callout);
			 	<?php } else { ?>
			 		var color = '<?php echo get_option('woo_cat_colors_pages'); ?>';
	  				createMarker(map,point,root,the_link,the_title,color,callout);
				<?php
				}
					if(isset($_POST['woo_maps_directions_search'])){ ?>

					directionsPanel = document.getElementById("featured-route");
 					directions = new GDirections(map, directionsPanel);
  					directions.load("from: <?php echo htmlspecialchars($_POST['woo_maps_directions_search']); ?> to: <?php echo $address; ?>" <?php if($walking == 'on'){ echo $extra_params;} ?>);



					directionsDisplay = new google.maps.DirectionsRenderer();
					directionsDisplay.setMap(map);
    				directionsDisplay.setPanel(document.getElementById("featured-route"));

					<?php if($walking == 'on'){ ?>
					var travelmodesetting = google.maps.DirectionsTravelMode.WALKING;
					<?php } else { ?>
					var travelmodesetting = google.maps.DirectionsTravelMode.DRIVING;
					<?php } ?>
					var start = '<?php echo htmlspecialchars($_POST['woo_maps_directions_search']); ?>';
					var end = '<?php echo $address; ?>';
					var request = {
       					origin:start,
        				destination:end,
        				travelMode: travelmodesetting
    				};
    				directionsService.route(request, function(response, status) {
      					if (status == google.maps.DirectionsStatus.OK) {
        					directionsDisplay.setDirections(response);
      					}
      				});

  					<?php } ?>
				<?php } ?>
			<?php } ?>


			  }
			  function handleNoFlash(errorCode) {
				  if (errorCode == FLASH_UNAVAILABLE) {
					alert("Error: Flash doesn't appear to be supported by your browser");
					return;
				  }
				 }



		initialize();

		});
	jQuery(window).load(function(){

		var newHeight = jQuery('#featured-content').height();
		newHeight = newHeight - 5;
		if(newHeight > 300){
			jQuery('#single_map_canvas').height(newHeight);
		}

	});

	</script>

<?php
}

/*-----------------------------------------------------------------------------------*/
/* Featured Slider: Post Type */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_featured_slider_post_type' ) ) {
function woo_featured_slider_post_type () {
	$labels = array(
		'name' => _x( 'Slides', 'post type general name', 'woothemes' ),
		'singular_name' => _x( 'Slide', 'post type singular name', 'woothemes' ),
		'add_new' => _x( 'Add New', 'slide', 'woothemes' ),
		'add_new_item' => __( 'Add New Slide', 'woothemes' ),
		'edit_item' => __( 'Edit Slide', 'woothemes' ),
		'new_item' => __( 'New Slide', 'woothemes' ),
		'view_item' => __( 'View Slide', 'woothemes' ),
		'search_items' => __( 'Search Slides', 'woothemes' ),
		'not_found' =>  __( 'No slides found', 'woothemes' ),
		'not_found_in_trash' => __( 'No slides found in Trash', 'woothemes' ),
		'parent_item_colon' => __( 'Parent slide:', 'woothemes' )
	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'taxonomies' => array( 'slide-page' ),
		'menu_icon' => esc_url( get_template_directory_uri() . '/includes/images/slides.png' ),
		'menu_position' => 5,
		'supports' => array('title','editor','thumbnail', /*'author','thumbnail','excerpt','comments'*/)
	);

	register_post_type( 'slide', $args );

	// "Slide Pages" Custom Taxonomy
	$labels = array(
		'name' => _x( 'Slide Groups', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Slide Groups', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Slide Groups', 'woothemes' ),
		'all_items' => __( 'All Slide Groups', 'woothemes' ),
		'parent_item' => __( 'Parent Slide Group', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Slide Group:', 'woothemes' ),
		'edit_item' => __( 'Edit Slide Group', 'woothemes' ),
		'update_item' => __( 'Update Slide Group', 'woothemes' ),
		'add_new_item' => __( 'Add New Slide Group', 'woothemes' ),
		'new_item_name' => __( 'New Slide Group Name', 'woothemes' ),
		'menu_name' => __( 'Slide Groups', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'slide-page' )
	);

	register_taxonomy( 'slide-page', array( 'slide' ), $args );
} // End woo_featured_slider_post_type()
}

add_action( 'init', 'woo_featured_slider_post_type' );

/*-----------------------------------------------------------------------------------*/
/* Featured Slider: Get Slides */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_featured_slider_get_slides' ) ) {
function woo_featured_slider_get_slides ( $args ) {
	$defaults = array( 'limit' => '5', 'order' => 'DESC', 'term' => '0' );
	$args = wp_parse_args( (array)$args, $defaults );
	$query_args = array( 'post_type' => 'slide' );
	if ( in_array( strtoupper( $args['order'] ), array( 'ASC', 'DESC' ) ) ) {
		$query_args['order'] = strtoupper( $args['order'] );
	}
	if ( 0 < intval( $args['limit'] ) ) {
		$query_args['numberposts'] = intval( $args['limit'] );
	}
	if ( 0 < intval( $args['term'] ) ) {
		$query_args['tax_query'] = array(
										array( 'taxonomy' => 'slide-page', 'field' => 'id', 'terms' => intval( $args['term']) )
									);
	}

	$slides = false;

	$query = get_posts( $query_args );

	if ( ! is_wp_error( $query ) && ( 0 < count( $query ) ) ) {
		$slides = $query;
	}

	return $slides;
} // End woo_featured_slider_get_slides()
}

/*-----------------------------------------------------------------------------------*/
/* Is IE */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'is_ie' ) ) {
	function is_ie ( $version = '6.0' ) {
		$supported_versions = array( '6.0', '7.0', '8.0', '9.0' );
		$agent = substr( $_SERVER['HTTP_USER_AGENT'], 25, 4 );
		$current_version = substr( $_SERVER['HTTP_USER_AGENT'], 30, 3 );
		$response = false;
		if ( in_array( $version, $supported_versions ) && 'MSIE' == $agent && ( $version == $current_version ) ) {
			$response = true;
		}

		return $response;
	} // End is_ie()
}

/*-----------------------------------------------------------------------------------*/
/* Display social icons via "Subscribe & Connect" */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'woo_display_social_icons' ) ) {
function woo_display_social_icons () {
	$html = '';
	$name = get_bloginfo( 'name' );
	$social_icons = array(
						'rss' => __( 'Subscribe to our RSS feed', 'woothemes' ),
						'twitter' => sprintf( __( 'Follow %s on Twitter', 'woothemes' ), $name ),
						'facebook' => sprintf( __( 'Like %s on Facebook', 'woothemes' ), $name ),
						'youtube' => sprintf( __( 'Watch %s on YouTube', 'woothemes' ), $name ),
						'flickr' => sprintf( __( 'Follow %s on Flickr', 'woothemes' ), $name ),
						'linkedin' => sprintf( __( 'Connect with %s on LinkedIn', 'woothemes' ), $name ),
						'delicious' => sprintf( __( 'Follow %s on Delicious', 'woothemes' ), $name ),
						'googleplus' => sprintf( __( 'Friend %s on Google+', 'woothemes' ), $name )
						);

	$social_icons = (array)apply_filters( 'woo_contact_social_icons', $social_icons );

	$settings_keys = array();
	foreach ( array_keys( $social_icons ) as $k => $v ) {
		$settings_keys['connect_' . $v] = '';
	}

	$settings = woo_get_dynamic_values( $settings_keys );

	if ( 'true' == $settings['connect_rss'] ) {
		$settings['connect_rss'] = get_feed_link();
	} else {
		$settings['connect_rss'] = '';
	}

	$html .= '<div id="connect">' . "\n";
	$html .= '<div class="social">' . "\n";
	foreach ( $social_icons as $k => $v ) {
		$class = $k;
		if ( 'rss' == $k ) { $class = 'subscribe'; }
		if ( '' != $settings['connect_' . $k] ) {
			$html .= '<a href="' . esc_url( $settings['connect_' . $k] ) . '" title="' . esc_attr( $v ) . '" class="' . $class . '"><span>' . $v . '</span></a>' . "\n";
		}
	}
	$html .= '</div>' . "\n";
	$html .= '</div>' . "\n";

	echo $html;
} // End woo_display_social_icons()
}

/*-----------------------------------------------------------------------------------*/
/* Check if WooCommerce is activated */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}


/*-----------------------------------------------------------------------------------*/
/* Get Menu Name */
/*-----------------------------------------------------------------------------------*/

function woo_get_menu_name($location){
    if(!has_nav_menu($location)) return false;
    $menus = get_nav_menu_locations();
    $menu_title = wp_get_nav_menu_object($menus[$location])->name;
    return $menu_title;
}

/*-----------------------------------------------------------------------------------*/
/* Add Lightbox to Galleries */
/*-----------------------------------------------------------------------------------*/

add_filter('wp_get_attachment_link', 'woo_add_gallery_rel');

if ( ! function_exists( 'woo_add_gallery_rel' ) ) {
	function woo_add_gallery_rel( $link ) {

		global $post;

		//Setup default variables, overriding them if the "Theme Options" have been saved.
		$settings = array( 'enable_lightbox' => 'false' );
		$settings = woo_get_dynamic_values( $settings );

		if ( $settings['enable_lightbox'] == 'true' ) {
			return str_replace('<a href', '<a rel="lightbox[gallery-' . $post->ID . ']" href', $link);
		} else {
			return $link;
		}

	}
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Ads */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_ad');
function woo_add_ad() 
{
  $labels = array(
    'name' => _x('Ads', 'post type general name', 'woothemes'),
    'singular_name' => _x('Ad', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Ad', 'woothemes'),
    'edit_item' => __('Edit Ad', 'woothemes'),
    'new_item' => __('New Ad', 'woothemes'),
    'view_item' => __('View Ad', 'woothemes'),
    'search_items' => __('Search Ads', 'woothemes'),
    'not_found' =>  __('No Ads found', 'woothemes'),
    'not_found_in_trash' => __('No Ads found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'ad'), 
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail', )
  ); 
  
  register_post_type('ads',$args);
  
$labels = array(
		'name' => _x( 'Advertiser', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Advertisers', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Advertiser', 'woothemes' ),
		'all_items' => __( 'All Advertiser', 'woothemes' ),
		'parent_item' => __( 'Parent Advertiser', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Advertiser:', 'woothemes' ),
		'edit_item' => __( 'Edit Advertiser', 'woothemes' ),
		'update_item' => __( 'Update Advertiser', 'woothemes' ),
		'add_new_item' => __( 'Add New Advertiser', 'woothemes' ),
		'new_item_name' => __( 'New Advertiser', 'woothemes' ),
		'menu_name' => __( 'Advertisers', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'ads/advertiser' )
		
	);
	
	
	register_taxonomy( 'advertiser', array( 'ads' ), $args );
	
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Banner Ads */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_banner_ad');
function woo_add_banner_ad() 
{
  $labels = array(
    'name' => _x('Banner Ads', 'post type general name', 'woothemes'),
    'singular_name' => _x('Banner Ad', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Banner Ad', 'woothemes'),
    'edit_item' => __('Edit Banner Ad', 'woothemes'),
    'new_item' => __('New Banner Ad', 'woothemes'),
    'view_item' => __('View Banner Ad', 'woothemes'),
    'search_items' => __('Search Banner Ads', 'woothemes'),
    'not_found' =>  __('No Ads Banner found', 'woothemes'),
    'not_found_in_trash' => __('No Banner Ads found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'banner-ad'), 
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail', )
  ); 
  
  register_post_type('banner-ads',$args);
  

	
}



/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Reviews */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_review');
function woo_add_review() 
{
  $labels = array(
    'name' => _x('Reviews', 'post type general name', 'woothemes'),
    'singular_name' => _x('Review', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Review', 'woothemes'),
    'edit_item' => __('Edit Review', 'woothemes'),
    'new_item' => __('New Review', 'woothemes'),
    'view_item' => __('View Review', 'woothemes'),
    'search_items' => __('Search Reviews', 'woothemes'),
    'not_found' =>  __('No Reviews found', 'woothemes'),
    'not_found_in_trash' => __('No reviews found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'review'), 
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'taxonomies' => array('post_tag'),
    'supports' => array('title','editor','thumbnail','excerpt','comments','author')
  ); 
  
  register_post_type('reviews',$args);
  
  
}

$labels = array(
		'name' => _x( 'Review Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Review Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Review Types', 'woothemes' ),
		'all_items' => __( 'All Review Types', 'woothemes' ),
		'parent_item' => __( 'Parent Review Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Review Type:', 'woothemes' ),
		'edit_item' => __( 'Edit review Type', 'woothemes' ),
		'update_item' => __( 'Update Review Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Review Type', 'woothemes' ),
		'new_item_name' => __( 'New Review Type Name', 'woothemes' ),
		'menu_name' => __( 'Review Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'reviews/category' )
		
	);
	
	
	register_taxonomy( 'review-type', array( 'reviews' ), $args );
	
add_action( 'init', 'create_types_nonhierarchical_taxonomy', 0 );

function create_types_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Gear Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Gear Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Gear Types' ),
    'popular_items' => __( 'Popular Gear Types' ),
    'all_items' => __( 'All Gear Types' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Gear Type' ), 
    'update_item' => __( 'Update Gear Type' ),
    'add_new_item' => __( 'Add New Gear Type' ),
    'new_item_name' => __( 'New Gear Type Name' ),
    'separate_items_with_commas' => __( 'Separate Gear Types with commas' ),
    'add_or_remove_items' => __( 'Add or remove Gear Types' ),
    'choose_from_most_used' => __( 'Choose from the most used Gear Types' ),
    'menu_name' => __( 'Gear Types' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('gear-types','reviews',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'reviews/gear' ),
  ));
}


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Songs */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_song');
function woo_add_song() 
{
  $labels = array(
    'name' => _x('Songs', 'post type general name', 'woothemes'),
    'singular_name' => _x('Song', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Song', 'woothemes'),
    'edit_item' => __('Edit Song', 'woothemes'),
    'new_item' => __('New Song', 'woothemes'),
    'view_item' => __('View Song', 'woothemes'),
    'search_items' => __('Search Songs', 'woothemes'),
    'not_found' =>  __('No Songs found', 'woothemes'),
    'not_found_in_trash' => __('No Songs found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'song'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'taxonomies' => array('post_tag'),
    'supports' => array('title','editor','thumbnail','excerpt','comments'/*,'author'*/)
  ); 
  
  register_post_type('songs',$args);
}

$labels = array(
		'name' => _x( 'Song Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Song Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Song Types', 'woothemes' ),
		'all_items' => __( 'All Song Types', 'woothemes' ),
		'parent_item' => __( 'Parent Song Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Song Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Song Type', 'woothemes' ),
		'update_item' => __( 'Update Song Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Song Type', 'woothemes' ),
		'new_item_name' => __( 'New Song Type Name', 'woothemes' ),
		'menu_name' => __( 'Song Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'songs' )
		
	);
	
	
	register_taxonomy( 'song-type', array( 'songs' ), $args );

//hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_topics_nonhierarchical_taxonomy', 0 );

function create_topics_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Topics', 'taxonomy general name' ),
    'singular_name' => _x( 'Topic', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Topics' ),
    'popular_items' => __( 'Popular Topics' ),
    'all_items' => __( 'All Topics' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Topic' ), 
    'update_item' => __( 'Update Topic' ),
    'add_new_item' => __( 'Add New Topic' ),
    'new_item_name' => __( 'New Topic Name' ),
    'separate_items_with_commas' => __( 'Separate topics with commas' ),
    'add_or_remove_items' => __( 'Add or remove topics' ),
    'choose_from_most_used' => __( 'Choose from the most used topics' ),
    'menu_name' => __( 'Topics' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('topics','songs',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'topic' ),
  ));
}

//hook into the init action and call create_info_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_info_nonhierarchical_taxonomy', 0 );

function create_info_nonhierarchical_taxonomy() {

// Labels part for the GUI

  $labels = array(
    'name' => _x( 'Song Info', 'taxonomy general name' ),
    'singular_name' => _x( 'Info', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Info' ),
    'popular_items' => __( 'Popular Info' ),
    'all_items' => __( 'All Info' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Info' ), 
    'update_item' => __( 'Update Info' ),
    'add_new_item' => __( 'Add New Info' ),
    'new_item_name' => __( 'New Info Name' ),
    'separate_items_with_commas' => __( 'Separate Info with commas' ),
    'add_or_remove_items' => __( 'Add or remove Info' ),
    'choose_from_most_used' => __( 'Choose from the most used Info' ),
    'menu_name' => __( 'Info' ),
  ); 

// Now register the non-hierarchical taxonomy like tag

  register_taxonomy('info','songs',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'info' ),
  ));
}





/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Campaigns */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_campaign');
function woo_add_campaign() 
{
  $labels = array(
    'name' => _x('Campaigns', 'post type general name', 'woothemes'),
    'singular_name' => _x('Campaign', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Campaign', 'woothemes'),
    'edit_item' => __('Edit Campaign', 'woothemes'),
    'new_item' => __('New Campaign', 'woothemes'),
    'view_item' => __('View Campaign', 'woothemes'),
    'search_items' => __('Search Campaign', 'woothemes'),
    'not_found' =>  __('No Campaigns found', 'woothemes'),
    'not_found_in_trash' => __('No Campaigns found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'campaigns'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt'/*,'comments','author'*/)
  ); 
  
  register_post_type('campaign',$args);
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Connect Groups */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_connect');
function woo_add_connect() 
{
  $labels = array(
    'name' => _x('Connect Groups', 'post type general name', 'woothemes'),
    'singular_name' => _x('Connect Group', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Connect Group', 'woothemes'),
    'edit_item' => __('Edit Connect Group', 'woothemes'),
    'new_item' => __('New Connect Group', 'woothemes'),
    'view_item' => __('View Connect Group', 'woothemes'),
    'search_items' => __('Search Connect Group', 'woothemes'),
    'not_found' =>  __('No Connect Groups found', 'woothemes'),
    'not_found_in_trash' => __('No Connect Groups found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'connect'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt'/*,'comments','author'*/)
  ); 
  
  register_post_type('connect',$args);
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Missions */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_mission');
function woo_add_mission() 
{
  $labels = array(
    'name' => _x('Missions', 'post type general name', 'woothemes'),
    'singular_name' => _x('Mission', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Mission', 'woothemes'),
    'edit_item' => __('Edit Mission', 'woothemes'),
    'new_item' => __('New Mission', 'woothemes'),
    'view_item' => __('View Mission', 'woothemes'),
    'search_items' => __('Search Missions', 'woothemes'),
    'not_found' =>  __('No Missions found', 'woothemes'),
    'not_found_in_trash' => __('No Missions found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'missions'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/globe.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt','comments'/*,'author'*/)
  ); 
  
  register_post_type('missions',$args);
}

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Podcast */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_podcast');
function woo_add_podcast() 
{
  $labels = array(
    'name' => _x('Podcasts', 'post type general name', 'woothemes'),
    'singular_name' => _x('Podcast', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Podcast', 'woothemes'),
    'edit_item' => __('Edit Podcast', 'woothemes'),
    'new_item' => __('New Podcast', 'woothemes'),
    'view_item' => __('View Podcast', 'woothemes'),
    'search_items' => __('Search Podcast', 'woothemes'),
    'not_found' =>  __('No Podcasts found', 'woothemes'),
    'not_found_in_trash' => __('No Podcasts found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'podcast'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/podcast.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','author','excerpt','comments')
  ); 
  
  register_post_type('podcast',$args);
}
$labels = array(
		'name' => _x( 'Podcast Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Podcast Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Podcast Types', 'woothemes' ),
		'all_items' => __( 'All Podcast Types', 'woothemes' ),
		'parent_item' => __( 'Parent Podcast Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Podcast Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Podcast Type', 'woothemes' ),
		'update_item' => __( 'Update Podcast Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Podcast Type', 'woothemes' ),
		'new_item_name' => __( 'New Podcast Type Name', 'woothemes' ),
		'menu_name' => __( 'Podcast Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
	);
	
	register_taxonomy( 'podcast-type', array( 'podcast' ), $args );

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Tutorial */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_tutorial');
function woo_add_tutorial() 
{
  $labels = array(
    'name' => _x('Tutorials', 'post type general name', 'woothemes'),
    'singular_name' => _x('Tutorial', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Tutorial Post', 'woothemes'),
    'edit_item' => __('Edit Tutorial Post', 'woothemes'),
    'new_item' => __('New Tutorial', 'woothemes'),
    'view_item' => __('View Tutorial', 'woothemes'),
    'search_items' => __('Search Tutorials', 'woothemes'),
    'not_found' =>  __('No Tutorials found', 'woothemes'),
    'not_found_in_trash' => __('No Tutorials found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'tutorial'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/tutorial.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','author','excerpt','comments'),
    'taxonomies' => array('post_tag')
  ); 
  
  register_post_type('tutorial',$args);
}
  	$labels = array(
		'name' => _x( 'Tutorial Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Tutorial Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Tutorial Types', 'woothemes' ),
		'all_items' => __( 'All Tutorial Types', 'woothemes' ),
		'parent_item' => __( 'Parent Tutorial Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Tutorial Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Tutorial Type', 'woothemes' ),
		'update_item' => __( 'Update Tutorial Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Tutorial Type', 'woothemes' ),
		'new_item_name' => __( 'New Tutorial Type Name', 'woothemes' ),
		'menu_name' => __( 'Tutorial Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'training' )
		
	);
	
	
	register_taxonomy( 'tutorial-type', array( 'tutorial' ), $args );
	
	
/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Partner */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_partner');
function woo_add_partner() 
{
  $labels = array(
    'name' => _x('Partners', 'post type general name', 'woothemes'),
    'singular_name' => _x('Partner', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Partner', 'woothemes'),
    'edit_item' => __('Edit Partner', 'woothemes'),
    'new_item' => __('New Partner', 'woothemes'),
    'view_item' => __('View Partner', 'woothemes'),
    'search_items' => __('Search Partners', 'woothemes'),
    'not_found' =>  __('No Partners found', 'woothemes'),
    'not_found_in_trash' => __('No Partners found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'partner'),
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_icon' => get_template_directory_uri() . '/includes/images/partner.png',
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail'),
   
  ); 
  
  register_post_type('partner',$args);
}
  	$labels = array(
		'name' => _x( 'Partner Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Partner Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Partner Types', 'woothemes' ),
		'all_items' => __( 'All Partner Types', 'woothemes' ),
		'parent_item' => __( 'Parent Partner Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent Partner Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Partner Type', 'woothemes' ),
		'update_item' => __( 'Update Partner Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Partner Type', 'woothemes' ),
		'new_item_name' => __( 'New Partner Type Name', 'woothemes' ),
		'menu_name' => __( 'Partner Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'partner' )
		
	);
	
	
	register_taxonomy( 'partner-type', array( 'partner' ), $args );



/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - TimeLine Preset */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_tlpreset');
function woo_add_tlpreset() 
{
  $labels = array(
    'name' => _x('Timeline Presets', 'post type general name', 'woothemes'),
    'singular_name' => _x('Timeline Preset', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Preset', 'woothemes'),
    'edit_item' => __('Edit Preset', 'woothemes'),
    'new_item' => __('New Preset', 'woothemes'),
    'view_item' => __('View Preset', 'woothemes'),
    'search_items' => __('Search Presets', 'woothemes'),
    'not_found' =>  __('No Presets found', 'woothemes'),
    'not_found_in_trash' => __('No Presets found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/timeline-presets'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/timeline.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('tlpreset',$args);
  
  	$labels = array(
		'name' => _x( 'Preset Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'tlpresettype', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Preset Types', 'woothemes' ),
		'all_items' => __( 'All Preset Types', 'woothemes' ),
		'parent_item' => __( 'Parent Preset Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent tlpreset Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Preset Type', 'woothemes' ),
		'update_item' => __( 'Update Preset Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Preset Type', 'woothemes' ),
		'new_item_name' => __( 'New Preset Type Name', 'woothemes' ),
		'menu_name' => __( 'Preset Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/timeline-presets' )
	);

	register_taxonomy( 'tlpresettype', array( 'tlpreset' ), $args );
} // End woo_featured_tlpresetr_post_type()



/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - BigSky Preset */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_bigskypreset');
function woo_add_bigskypreset() 
{
  $labels = array(
    'name' => _x('BigSky Presets', 'post type general name', 'woothemes'),
    'singular_name' => _x('BigSky Preset', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Preset', 'woothemes'),
    'edit_item' => __('Edit Preset', 'woothemes'),
    'new_item' => __('New Preset', 'woothemes'),
    'view_item' => __('View Preset', 'woothemes'),
    'search_items' => __('Search Presets', 'woothemes'),
    'not_found' =>  __('No Presets found', 'woothemes'),
    'not_found_in_trash' => __('No Presets found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/bigsky-presets'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/timeline.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('bigskypreset',$args);
  
  	$labels = array(
		'name' => _x( 'Preset Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Preset Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Preset Types', 'woothemes' ),
		'all_items' => __( 'All Preset Types', 'woothemes' ),
		'parent_item' => __( 'Parent Preset Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent bigskypreset Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Preset Type', 'woothemes' ),
		'update_item' => __( 'Update Preset Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Preset Type', 'woothemes' ),
		'new_item_name' => __( 'New Preset Type Name', 'woothemes' ),
		'menu_name' => __( 'Preset Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/bigsky-presets' )
	);

	register_taxonomy( 'bigskypreset-page', array( 'bigskypreset' ), $args );
} // End woo_featured_bigskypreset_post_type()




/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - TimeFactor Preset */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_tfpreset');
function woo_add_tfpreset() 
{
  $labels = array(
    'name' => _x('TimeFactor Presets', 'post type general name', 'woothemes'),
    'singular_name' => _x('TimeFactor Preset', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Preset', 'woothemes'),
    'edit_item' => __('Edit Preset', 'woothemes'),
    'new_item' => __('New Preset', 'woothemes'),
    'view_item' => __('View Preset', 'woothemes'),
    'search_items' => __('Search Presets', 'woothemes'),
    'not_found' =>  __('No Presets found', 'woothemes'),
    'not_found_in_trash' => __('No Presets found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/timefactor-presets'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/timeline.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('tfpreset',$args);
  
  	$labels = array(
		'name' => _x( 'Preset Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Preset Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Preset Types', 'woothemes' ),
		'all_items' => __( 'All Preset Types', 'woothemes' ),
		'parent_item' => __( 'Parent Preset Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent tfpreset Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Preset Type', 'woothemes' ),
		'update_item' => __( 'Update Preset Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Preset Type', 'woothemes' ),
		'new_item_name' => __( 'New Preset Type Name', 'woothemes' ),
		'menu_name' => __( 'Preset Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/timefactor-presets' )
	);

	register_taxonomy( 'tfpreset-page', array( 'tfpreset' ), $args );
} // End woo_featured_tfpreset_post_type()

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Space Preset */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_spacepreset');
function woo_add_spacepreset() 
{
  $labels = array(
    'name' => _x('Space Presets', 'post type general name', 'woothemes'),
    'singular_name' => _x('Space Preset', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Preset', 'woothemes'),
    'edit_item' => __('Edit Preset', 'woothemes'),
    'new_item' => __('New Preset', 'woothemes'),
    'view_item' => __('View Preset', 'woothemes'),
    'search_items' => __('Search Presets', 'woothemes'),
    'not_found' =>  __('No Presets found', 'woothemes'),
    'not_found_in_trash' => __('No Presets found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/space-presets'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/timeline.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('spacepreset',$args);
  
  	$labels = array(
		'name' => _x( 'Preset Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Preset Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Preset Types', 'woothemes' ),
		'all_items' => __( 'All Preset Types', 'woothemes' ),
		'parent_item' => __( 'Parent Preset Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent spacepreset Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Preset Type', 'woothemes' ),
		'update_item' => __( 'Update Preset Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Preset Type', 'woothemes' ),
		'new_item_name' => __( 'New Preset Type Name', 'woothemes' ),
		'menu_name' => __( 'Preset Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/space-presets' )
	);

	register_taxonomy( 'spacepreset-page', array( 'spacepreset' ), $args );
} // End woo_featured_spacepreset_post_type()

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - POD HD Preset */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_podpreset');
function woo_add_podpreset() 
{
  $labels = array(
    'name' => _x('POD Presets', 'post type general name', 'woothemes'),
    'singular_name' => _x('POD Preset', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Preset', 'woothemes'),
    'edit_item' => __('Edit Preset', 'woothemes'),
    'new_item' => __('New Preset', 'woothemes'),
    'view_item' => __('View Preset', 'woothemes'),
    'search_items' => __('Search Presets', 'woothemes'),
    'not_found' =>  __('No Presets found', 'woothemes'),
    'not_found_in_trash' => __('No Presets found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/pod-presets'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/timeline.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('podpreset',$args);
  
  	$labels = array(
		'name' => _x( 'Preset Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'Preset Types', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Preset Types', 'woothemes' ),
		'all_items' => __( 'All Preset Types', 'woothemes' ),
		'parent_item' => __( 'Parent Preset Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent podpreset Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Preset Type', 'woothemes' ),
		'update_item' => __( 'Update Preset Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Preset Type', 'woothemes' ),
		'new_item_name' => __( 'New Preset Type Name', 'woothemes' ),
		'menu_name' => __( 'Preset Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/pod-presets' )
	);

	register_taxonomy( 'podpreset-type', array( 'podpreset' ), $args );
} // End woo_featured_podpreset_post_type()


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type - Mainstage Patch */
/*-----------------------------------------------------------------------------------*/

add_action('init', 'woo_add_mspatch');
function woo_add_mspatch() 
{
  $labels = array(
    'name' => _x('Mainstage Patches', 'post type general name', 'woothemes'),
    'singular_name' => _x('Mainstage Patch', 'post type singular name', 'woothemes'),
    'add_new' => _x('Add New', 'infobox', 'woothemes'),
    'add_new_item' => __('Add New Patch', 'woothemes'),
    'edit_item' => __('Edit Patch', 'woothemes'),
    'new_item' => __('New Patch', 'woothemes'),
    'view_item' => __('View Patch', 'woothemes'),
    'search_items' => __('Search patches', 'woothemes'),
    'not_found' =>  __('No patches found', 'woothemes'),
    'not_found_in_trash' => __('No patches found in Trash', 'woothemes'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'resources/mainstage-patches'),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_icon' => get_template_directory_uri() . '/includes/images/mainstage.png',
    'menu_position' => null,
    'supports' => array('title','thumbnail',/*'author','thumbnail','excerpt','comments'*/)
  ); 
  
  register_post_type('mspatch',$args);
  
  	$labels = array(
		'name' => _x( 'Patch Types', 'taxonomy general name', 'woothemes' ),
		'singular_name' => _x( 'mspatchtype', 'taxonomy singular name', 'woothemes' ),
		'search_items' =>  __( 'Search Patch Types', 'woothemes' ),
		'all_items' => __( 'All Patch Types', 'woothemes' ),
		'parent_item' => __( 'Parent Patch Type', 'woothemes' ),
		'parent_item_colon' => __( 'Parent mspatch Type:', 'woothemes' ),
		'edit_item' => __( 'Edit Patch Type', 'woothemes' ),
		'update_item' => __( 'Update Patch Type', 'woothemes' ),
		'add_new_item' => __( 'Add New Patch Type', 'woothemes' ),
		'new_item_name' => __( 'New Patch Type Name', 'woothemes' ),
		'menu_name' => __( 'Patch Types', 'woothemes' )
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'resources/mainstage-patches' )
	);

	register_taxonomy( 'mspatchtype', array( 'mspatch' ), $args );
} 



/*-----------------------------------------------------------------------------------*/
/* END */
/*-----------------------------------------------------------------------------------*/
?>