<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 *
 * Display related posts based on tags.
 *

 */

					
$settings = woo_get_dynamic_values( $settings );

if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }


$tags = get_taxonomy('gear-types');
if ($tags) {  
    $tag_ids = array();  
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id; }

$query_args = array(
						
						'post_type' => array( 'reviews' ),
						//'tag__in' => $tag_ids,
						'post__not_in' => array($post->ID),  
						'posts_per_page' => 3, 
						'orderby' => rand,
						'paged' => $paged
						
					);

if ( 0 < intval( $settings['homepage_posts_category'] ) ) {
	$query_args['cat'] = intval( $settings['homepage_posts_category'] );
}
?>
<h1>Related Posts</h1>

 <div id="content" class="page-widgets">
<section class="blog-posts widget home-section fix">
	
<?php woo_loop_before(); ?>

<?php
	
	$query = new WP_Query( $query_args );
	
	if ( $query->have_posts() ) {

	?>


	

	<ul class="home-list related">

	<?php
		$count = 0;
		
		while ( $query->have_posts() ) { $query->the_post(); $count++; ?>

		<li>

			<article <?php post_class('post'); ?>>

		   <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(array(250,250));?></a>

		    <div class="article-content">

				<header>
							
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><h1><?php the_title(); ?></h1></a>
				</header>

				<section class="entry">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php //the_excerpt(); ?>
					</a>
					
				</section>
				<?php include('social-home.php');?>
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

<?php //woo_pagenav(); ?>
<?php wp_reset_query(); ?>
	
	
	<div class="fix"></div>
</section>
</div>