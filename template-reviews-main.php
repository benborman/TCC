<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Reviews Main
 *
 * The blog page template displays the "blog-style" template on a sub-page.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;
 get_header();

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
			<h1><?php the_title(); ?></h1>
			
							<?php
				
			$terms = get_terms( 'types' );

echo '<ul class="product-types">';

foreach ( $terms as $term ) {

    // The $term is an object, so we don't need to specify the $taxonomy.
    $term_link = get_term_link( $term );
   
    // If there was an error, continue to the next term.
    if ( is_wp_error( $term_link ) ) {
        continue;
    }

    // We successfully got a link. Print it out.
    echo '<li><a class="button2" href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
}

echo '</ul>';
echo '<div class="clear"></div>';

				
				
				?>
			
			
		<?php woo_loop_before(); ?>

        <?php
        	if ( get_query_var( 'paged') ) { $paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page') ) { $paged = get_query_var( 'page' ); } else { $paged = 1; }

        	$query_args = array(
        							'post_type' => 'reviews', 
        							//'tutorial-type' =>"$post_slug",
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