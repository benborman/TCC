<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Resources Component
 *
 * Display X resources as parent pages.
 *
 * @author Ben
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */
$settings = array(
				'homepage_number_of_posts' => 8, 
				'homepage_posts_category' => '', 
				'homepage_posts_thumb_w' => 252, 
				'homepage_posts_thumb_h' => 152, 
				'homepage_posts_thumb_align' => 'aligncenter',
				'homepage_posts_layout' => 'layout-full',
				'homepage_posts_title' => __('Latest Blog Posts', 'woothemes'),
				'homepage_posts_page_id' => ''
				);
					
$settings = woo_get_dynamic_values( $settings );

if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

$query_args = array(
						'post_type' => 'post', 
						'posts_per_page' => intval( $settings['homepage_number_of_posts'] ), 
						'paged' => $paged
					);

if ( 0 < intval( $settings['homepage_posts_category'] ) ) {
	$query_args['cat'] = intval( $settings['homepage_posts_category'] );
}
?>

<section class="blog-posts widget home-section fix <?php echo esc_attr( $settings['homepage_posts_layout'] ); ?>">
	<div class="col-full">
<?php woo_loop_before(); ?>

<?php
	
	$query = new WP_Query( $query_args );
	
	if ( $query->have_posts() ) {

	?>

	<header>
		<?php if ( isset( $settings['homepage_posts_page_id'] ) && '' != $settings['homepage_posts_page_id'] ) { ?><a href="<?php echo esc_url( get_page_link( $settings['homepage_posts_page_id'] ) ); ?>" title="<?php esc_attr_e( 'Click here to view our latest posts', 'woothemes' ); ?>" class="button view-all"><?php _e( 'Visit Blog', 'woothemes' ); ?></a><?php } ?>
		<?php if ( isset( $settings['homepage_posts_title'] ) && '' != $settings['homepage_posts_title'] ) { ?><h1><?php echo $settings['homepage_posts_title']; ?></h1><?php } ?>
	</header>

	<ul class="home-list">

	<?php
		$count = 0;
		
		while ( $query->have_posts() ) { $query->the_post(); $count++; ?>

		<li>

			<article <?php post_class(); ?>>

		    <?php
	    		woo_image( 'width=' . $settings['homepage_posts_thumb_w'] . '&height=' . $settings['homepage_posts_thumb_h'] . '&class=thumbnail' );
		    ?>

		    <div class="article-content">

				<header>
					<aside class="post-meta">
						<ul>
							<li class="post-date">
								<span><?php the_time( get_option( 'date_format' ) ); ?></span>
							</li>
							<li class="post-comments">
								<span class="small">/</span>
								<?php comments_popup_link( __( 'Leave a comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?>
							</li>		
						</ul>
					</aside>			
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><h1><?php the_title(); ?></h1></a>
				</header>

				<section class="entry">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php the_excerpt(); ?>
					</a>
				</section>

		    </div><!-- /.article-content -->

			</article>

		</li><!-- /.post -->

		<?php
			
		} // End WHILE Loop
		
		?>

	</ul>

	<?php

	} else {
?>
    <article <?php post_class(); ?>>
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
    </article><!-- /.post -->
<?php } // End IF Statement ?> 

<?php woo_loop_after(); ?> 

<?php woo_pagenav(); ?>
<?php wp_reset_query(); ?>
	</div><!--/.col-full-->
	<?php
		if ( $settings['homepage_posts_layout'] != 'layout-full' )  {
			get_sidebar();
		}
	?>
	<div class="fix"></div>
</section>