<?php
// File Security Check
if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?><?php
/**
 * Index Template
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

	$settings = array(
				'homepage_enable_content' => 'true', 
				'homepage_enable_featured_products' => 'true', 
				'homepage_enable_features' => 'true', 
				'homepage_enable_testimonials' => 'true',
				'homepage_enable_blog_posts' => 'true',
				'homepage_enable_columns' => 'true',				
				'homepage_features_title' => '', 
				'homepage_testimonials_title' => '', 
				'homepage_number_of_features' => 1, 
				'homepage_number_of_testimonials' => 4
				);
					
	$settings = woo_get_dynamic_values( $settings );

?>

    <div id="content" class="home-widgets">

    	<?php woo_main_before(); ?>
		
    	<?php 

    		
				if ( 'true' == $settings['homepage_enable_features'] ) {
					do_action( 'woothemes_features', array( 'title' => $settings['homepage_features_title'], 'limit' => $settings['homepage_number_of_features'], 'before' => '<div class="widget widget_woothemes_features home-section"><div class="col-full">', 'after' => '</div><!--/.col-full--></div><!--/.widget widget_woothemes_features-->', 'size' => 300 ) );
				}

			//	if ( is_woocommerce_activated() && 'true' == $settings['homepage_enable_featured_products'] ) {
			//		get_template_part( 'includes/featured-products' );
			//	}

				if ( 'true' == $settings['homepage_enable_testimonials'] ) {
					do_action( 'woothemes_testimonials', array( 'title' => $settings['homepage_testimonials_title'], 'limit' => $settings['homepage_number_of_testimonials'], 'before' => '<div class="widget widget_woothemes_testimonials home-section"><div class="col-full"><a class="button view-all" href="' . get_post_type_archive_link( 'testimonial' ) . '" title="' . esc_attr__( 'Click here to view our testimonials', 'woothemes' ) . '">' . __( 'View All' , 'woothemes' ) . '</a>', 'after' => '</div><!--/.col-full--></div><!--/.widget widget_woothemes_testimonials-->' ) );
				}

	    		if ( 'true' == $settings['homepage_enable_blog_posts'] ) {
					get_template_part( 'includes/blog-posts' );
				}

	    		if ( 'true' == $settings['homepage_enable_columns'] ) {
					get_template_part( 'includes/homepage-columns' );
				}				

    	

    	?>
    	<div class="col-full">
		<?php include('includes/home-blog-list.php'); ?>
    	</div>
    	<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>