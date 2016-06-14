<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: POD HD Presets
 *
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
   <script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });   </script> 
    <div id="content" class="page">
    
    	<div class="col-full">
    
    		<?php woo_main_before(); ?>
    		
			
        	   
        	<?php
        		if ( have_posts() ) { $count = 0;
        			while ( have_posts() ) { the_post(); $count++;
        	?>                                                             
        	        <article <?php post_class(); ?>>
						
						<header>
							<h1><?php the_title(); ?></h1>
						</header>
        	            <?php include('includes/social.php'); ?>
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
        	    <section id="main" class="col-left">
					 <div class="table-search">Search: <input id="filter" type="text" /></div>
        			<table  data-filter="#filter" class="footable">
        			<thead> 
						<tr>
							<th>Name</th>
							<th>Author</th>
							<th>Description</th>
							<th>Device</th>
							<!-- <th>Type</th> -->
						</tr>
        			</thead>
        			<tbody>
					<?php $loop = new WP_Query( array('post_type' => 'podpreset','posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
					<?php if($loop->have_posts()) : ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                
				<tr>
					<td><a href="<?php echo get_post_meta ($post->ID, "podpreset", true); ?>"><?php the_title(); ?></a></td>
					<td><?php echo get_post_meta($post->ID, "author", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "description", true); ?></td>
					<td>
					
					<?php $taxonomy = strip_tags( get_the_term_list($post->ID, 'podpreset-type') ); echo $taxonomy; ?>					
					
					</td>
					
				</tr>
                
				
						
				
				<?php endwhile; ?>
			<?php endif; ?>
			</tbody>
	<?php wp_reset_query(); ?>
	</table>	
			</section><!-- /#main -->
			
			<?php woo_main_after(); ?>
			<?php get_sidebar(); ?>

		</div><!-- /.col-full -->
		
	</span>

    </div><!-- /#content -->
		
<?php get_footer(); ?>