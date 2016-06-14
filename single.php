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
		<?php if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('<p id="breadcrumbs">','</p>');
} ?>

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
			<article <?php post_class(); ?>>

				
                <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>

                <header>

                	<?php woo_post_meta(); ?>
					<?php $posttype = get_post_type( $post ) ?>
			<!-- <p class="category-name"><?php if(($posttype == post)){ the_category(' ');} ?><?php if(($posttype == podcast)){ echo "<a href=\"/podcast\" >Podcast</a>"; } ?><?php if(($posttype == tutorial)){ echo get_the_term_list( $post->ID, 'tutorial-type', '', ', ', '' );  } ?>: </p> -->
	                <h1><?php the_title(); ?></h1>
					<!--<div class="social-single"><?php include('includes/social.php');?></div>-->
					<div class="clear"></div>
                </header>
				
                <section class="entry fix">
                <?php echo woo_embed( 'width=844' ); ?>
                	<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
				</section>

				<?php //the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
				<div class="social-single"><?php include('includes/social.php');?></div>
            </article><!-- .post -->

				<?php if ( isset( $woo_options['woo_post_author'] ) && $woo_options['woo_post_author'] == 'true' ) { ?>
				<aside id="post-author" class="fix">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), '100' ); ?></div>
					<div class="profile-content">
						<h3 class="title"><?php the_author_meta('display_name',$author); ?></h3>
						<p class="bio"><?php the_author_meta( 'description' ); ?><?php $website = get_the_author_meta('user_url'); if(!empty($website)){echo " <a target=\"_blank\" href=\"$website\">$website</a>";} ?></p>
						<div class="profile-link">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'woothemes' ), get_the_author() ); ?>
							</a>
						</div><!-- #profile-link	-->
					</div><!-- .post-entries -->
					<?php //$website = get_the_author_meta('user_url'); if(!empty($website)){echo "<a class=\"button\" target=\"_blank\" href=\"$website\">Website</a>";} ?>
					<?php $facebookURL = get_the_author_meta('facebook'); if(!empty($facebookURL)){echo "<a class=\"fb\" target=\"_blank\" href=\"http://www.facebook.com/$facebookURL\"></a>";} ?>
					<?php $twitterHandle = get_the_author_meta('twitter'); if(!empty($twitterHandle)){echo "<a class=\"twitter\" target=\"_blank\" href=\"http://www.twitter.com/$twitterHandle\"></a>";} ?>
					<?php $igHandle = get_the_author_meta('instagram'); if(!empty($igHandle)){echo "<a class=\"ig\" target=\"_blank\" href=\"http://www.instagram.com/$twitterHandle\"></a>";} ?>
				</aside><!-- .post-author-box -->
				<?php } ?>
				
				 <?php include("includes/related-posts.php"); ?>

				<?php //woo_subscribe_connect(); ?>

	       <!-- <nav id="post-entries" class="fix">
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