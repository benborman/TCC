
    <!-- #content Starts -->
    <div id="content" class="col-full">
		<h1>The Latest</h1>
        <?php woo_main_before(); ?>

        <section id="main" class="col-left">

		<?php woo_loop_before(); ?>

        <?php
        $query_args = array(
						'post_type' => array( 'post', 'tutorial', 'podcast'),
						'posts_per_page' => intval( $settings['homepage_number_of_posts'] ), 
						'paged' => $paged,
						'orderby' => 'ASC',
							
									
									);

                	

        	query_posts( $query_args );

        	if ( have_posts() ) {
        		$count = 0;
        		while ( have_posts() ) { the_post(); $count++;

					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content-home', get_post_format() );

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

			<aside id="sidebar" class="col-right">
			<?php if ( is_home() && ! dynamic_sidebar( 'homepage' ) ) {

	    		if ( 'true' == $settings['homepage_enable_content'] ) {
					get_template_part( 'includes/specific-page-content' );
				}
				}; ?>
		</aside>

    </div><!-- /#content -->