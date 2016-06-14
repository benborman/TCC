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

				<?php echo woo_embed( 'width=844' ); ?>
                <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>

                <header>

                	<?php //woo_post_meta(); ?>

	                <h1>Connect Group: <?php the_title(); ?></h1>

                </header>

                <section class="entry fix">
                	<?php the_post_thumbnail(); ?>
                	<br />
                	<br />
                	<?php the_content(); ?>
                	
                	<!--Hosted By: <?php echo get_post_meta($post->ID, "host", true); ?><br /> -->
                	<br />
					<!-- WP Curve NM #107665 start
                		<iframe height="463" allowTransparency="true" frameborder="0" scrolling="no" style="width:100%;border:none"  src="https://thechurchcollective.wufoo.com/embed/z25r7zr130cyse/"><a href="https://thechurchcollective.wufoo.com/forms/z25r7zr130cyse/">Fill out my Wufoo form!</a></iframe>
					WP Curve NM #107665 end -->
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
				</section>

				<?php the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>

            </article><!-- .post -->

				

			
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