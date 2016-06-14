<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Content Component
 *
 * Display content from a specified page.
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
$settings = array(
				'homepage_page_id' => '', 
				'homepage_posts_thumb_w' => 580,
				'homepage_posts_thumb_h' => 334,
				'homepage_posts_thumb_align' => 'alignleft'
				);
					
$settings = woo_get_dynamic_values( $settings );

if ( 0 < intval( $settings['homepage_page_id'] ) ) {

$query = new WP_Query( 'page_id=' . intval( $settings['homepage_page_id'] ) );
?>

<section class="widget page-content component home-section <?php echo esc_attr( $settings['homepage_posts_layout'] ); ?>">

	<div class="col-full">

<?php woo_loop_before(); ?>

<?php
	if ( $query->have_posts() ) {
		$count = 0;
		while ( $query->have_posts() ) { $query->the_post(); $count++;
?>
<?php echo woo_embed( 'width=580' ); ?>
<?php if ( ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['homepage_posts_thumb_w'] . '&height=' . $settings['homepage_posts_thumb_h'] . '&class=thumbnail ' . $settings['homepage_posts_thumb_align'] ); } ?>

<header>


<h1><?php the_title(); ?></h1>

</header>

<section class="entry fix">
	
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
	
</section>
				
<?php the_tags( '<p class="tags">'.__( 'Tags: ', 'woothemes' ), ', ', '</p>' ); ?>
<?php
		} // End WHILE Loop
	
	} else {
?>
    <article <?php post_class(); ?>>
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
    </article><!-- /.post -->
<?php } ?> 

<?php woo_loop_after(); ?> 
	
	</div><!-- /.col-full -->

</section>
<?php } // End the main check ?>