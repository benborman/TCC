<?php
if ( ! defined( 'ABSPATH' ) ) exit;


 global $woo_options;
 get_header();
 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

	$settings = array(
					'thumb_w' => 150,
					'thumb_h' => 150,
					'thumb_align' => 'alignleft'
					);

	$settings = woo_get_dynamic_values( $settings );
?>
    <!-- #content Starts -->
    <div id="content" class="col-full">

        <?php woo_main_before(); ?>

        <section id="main" class="col-left blog-posts widget home-section fix">
			<h1>Reviews: <?php echo $term->name; ?></h1>
		<?php woo_loop_before(); ?>

        <?php
        	if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

        	$query_args = array(
        							'post_type' => 'reviews', 
        							'gear-types' => $term->name,
        							'posts_per_page' => '-1'
        						);


        	$query_args = apply_filters( 'woo_blog_template_query_args', $query_args ); // Do not remove. Used to exclude categories from displaying here.

        	remove_filter( 'pre_get_posts', 'woo_exclude_categories_homepage' );

        	query_posts( $query_args );

        	if ( have_posts() ) {
        		$count = 0;
        		while ( have_posts() ) { the_post(); $count++;

					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content-reviews', get_post_format() );

        		} // End WHILE Loop

        	} else {
        ?>
            <article <?php post_class(); ?>>
                <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
            </article><!-- /.post -->
        <?php } // End IF Statement ?>

        <?php woo_loop_after(); ?>

        <?php woo_pagenav(); ?>
		<?php wp_reset_query(); ?>

        </section><!-- /#main -->

        <?php woo_main_after(); ?>

		<?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>