<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
					'thumb_single' => 'false',
					'single_w' => 844,
					'single_h' => 352,
					'thumb_single_align' => 'aligncenter'
					);

	$settings = woo_get_dynamic_values( $settings );
?>

    <div id="content" class="col-full">

    	<?php woo_main_before(); ?>

		<section id="main" class="col-left">

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
			<article <?php post_class('post'); ?>>

                <header>

                	<?php woo_post_meta(); ?>
                	<?php   // Get terms for post
 $terms = get_the_terms( $post->ID , 'review-type' );
 // Loop over each item since it's an array
 if ( $terms != null ){
 foreach( $terms as $term ) {
 // Print the name method from $term which is an OBJECT
 $slug = $term->slug;
 $taxonomy = $term->name ;
 // Get rid of the other data stored in the object, since it's not needed
 unset($term);
} } ?>


	                <h1><?php the_title(); ?></h1>
					<div class="social-single"><?php include('includes/social.php');?></div>
                </header>
                  <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>
					<?php echo woo_embed( 'width=844' ); ?>
                <section class="entry fix">
                	<?php the_content(); ?>
                	
                	<?php 
           
                	$option1 = get_post_meta($post->ID, "option_1_grade", true); 
                	$option2 = get_post_meta($post->ID, "option_2_grade", true);
                	$option3 = get_post_meta($post->ID, "option_3_grade", true);
                	$option4 = get_post_meta($post->ID, "option_4_grade", true);
                	$option5 = get_post_meta($post->ID, "option_5_grade", true);
					
					
					$a = array($option1, $option2, $option3, $option4, $option5);
					array_filter($a, function($x) { return !empty($x); });
						array_filter($a);
						$count =  count(array_filter($a));

                	$criteria = $count * 10;

                	$rawscore = get_post_meta($post->ID, "option_overall_score", true); $finalscore = $rawscore / $criteria; echo $finalscore; 
                	?>
                	

                	
                	
                					<?php
				
$product_terms = wp_get_object_terms( $post->ID,  'types' );
if ( ! empty( $product_terms ) ) {
	if ( ! is_wp_error( $product_terms ) ) {
		echo '<ul>';
			foreach( $product_terms as $term ) {
				echo '<li><a href="' . get_term_link( $term->slug, 'types' ) . '">' . $term->name . '</a></li>'; 
			}
		echo '</ul>';
	}
}

				
				
				?>
			                	
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
				</section>
				<div class="social-single"><?php include('includes/social.php');?></div>
				<?php //the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
				<?php do_shortcode( "[P_REVIEW post_id=3989 visual='yes']" ); ?>
            </article><!-- .post -->

				<?php if ( isset( $woo_options['woo_post_author'] ) && $woo_options['woo_post_author'] == 'true' ) { ?>
				<aside id="post-author" class="fix">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), '100' ); ?></div>
					<div class="profile-content">
						<h3 class="title"><?php printf( esc_attr__( 'About %s', 'woothemes' ), get_the_author() ); ?></h3>
						<?php the_author_meta( 'description' ); ?>
						<div class="profile-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'woothemes' ), get_the_author() ); ?>
							</a>
						</div><!-- #profile-link	-->
					</div><!-- .post-entries -->
				</aside><!-- .post-author-box -->
				<?php } ?>

				<?php //woo_subscribe_connect(); ?>
				
				 <?php include("includes/related-posts.php"); ?>

	        <nav id="post-entries" class="fix">
	            <div class="nav-prev fl"><?php previous_post_link( '%link', '%title' ); ?></div>
	            <div class="nav-next fr"><?php next_post_link( '%link', '%title' ); ?></div>
	        </nav><!-- #post-entries -->
	        
	        
	       
	       
            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'post', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</article><!-- .post -->
       	<?php } ?>

		</section><!-- #main -->

		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>