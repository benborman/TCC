<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Parent Page
 *
 * This template is for looping through the child pages of A Parent Page in a grid layout
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
       
    <div id="content" class="page">
    
    	<div class="col-full">
    
    		<?php woo_main_before(); ?>
    		
			<section id="main" class="fullwidth">
        	   
        	<?php
        		if ( have_posts() ) { $count = 0;
        			while ( have_posts() ) { the_post(); $count++;
        	?>                                                             
        	        <article <?php post_class(); ?>>
						
						<header>
							<h1><?php the_title(); ?></h1>
						</header>
        	            
        	            <section class="entry">
	    	            	<?php the_content(); ?>
	    	           	</section><!-- /.entry -->
			
						<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
			
        	        </article><!-- /.post -->
        	                                            
				<?php
						} // End WHILE Loop
					} else {
				?>
					<article <?php post_class(); ?>>
        	        	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
        	        </article><!-- /.post -->
        	    <?php } ?>  
        	    
        	    
        	    
        	    <div class="fullwidth">
        	    
        	    <?php $this_page_id=$wp_query->post->ID; ?>
				<?php query_posts(array('showposts' => 20, 'post_parent' => $this_page_id, 'post_type' => 'page', 'order' => 'ASC')); while (have_posts()) { the_post(); ?>

					<div class="subpage">
					 	
					 	<a href="<?php the_permalink(); ?>"><?php woo_image( 'width=250&height=250&class=thumbnail' ); ?></a>
					 	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</div>

        <?php } ?>
        	<div class="fix"></div>
			</section><!-- /#main -->
			
			<?php woo_main_after(); ?>
		
		</div><!-- /.col-full -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>