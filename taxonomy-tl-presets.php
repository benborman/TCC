<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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
					 
        			<table  data-filter="#filter" class="footable">
        			<thead> 
						<tr>
							<th>Name</th>
							<th>Song</th>
							<th>Artist</th>
							<th>Author</th>
							<th>Description</th>
							
						</tr>
        			</thead>
        			<tbody>
					<?php if(have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
                
				<tr>
					<td><a href="<?php echo get_post_meta ($post->ID, "tlpreset", true); ?>"><?php the_title(); ?></a></td>
					<td><?php echo get_post_meta($post->ID, "song", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "artist", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "author", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "description", true); ?></td>
					
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
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>