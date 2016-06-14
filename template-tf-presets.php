<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: TimeFactor Presets
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
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
    
    	<div class="page col-full">
    
    		<?php woo_main_before(); ?>
    		
			
        	   
        	<?php
        		if ( have_posts() ) { $count = 0;
        			while ( have_posts() ) { the_post(); $count++;
        	?>                                                             
        	        <article <?php post_class(); ?>>
						
						<header>
							<h1><?php the_title(); ?></h1>
						</header>
						<div class="social-single-list"><?php include('includes/social.php');?></div>
        	            
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
        	    <section id="main" class="fullwidth">
					 <div class="table-search">Search: <input id="filter" type="text" /></div>
        			<table  data-filter="#filter" class="footable">
        			<thead> 
						<tr>
							<th>Name</th>
							<th>Song</th>
							<th>Artist</th>
							<th>Author</th>
							<th>Description</th>
							<?php if ( current_user_can('edit_post') ) {
								echo '<th>Edit</th>';
								} ?>
							<!-- <th>Type</th> -->
						</tr>
        			</thead>
        			<tbody>
					<?php $loop = new WP_Query( array('post_type' => 'tfpreset','posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
					<?php if($loop->have_posts()) : ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                
				<tr>
					<td><a href="<?php echo get_post_meta ($post->ID, "tfpreset", true); ?>"><?php the_title(); ?></a></td>
					<td><?php echo get_post_meta($post->ID, "song", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "artist", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "author", true); ?></td>
					 <?php $edit= get_edit_post_link( $id, $context ); ?> 
					<td><?php echo get_post_meta($post->ID, "description", true); ?></td>
					<?php if ( current_user_can('edit_post') ) {
								echo "<td><a href=\"$edit\" target=\"_blank\">Edit</a></td>";
								} ?>
					<!-- <td><?php echo get_the_term_list( $post->ID, 'tfpreset-page', '', '', '' );  ?></td> -->
				</tr>
                
				
						
				
				<?php endwhile; ?>
			<?php endif; ?>
			</tbody>
	<?php wp_reset_query(); ?>
	</table>	
			</section><!-- /#main -->
			
			<?php woo_main_after(); ?>
			

		</div><!-- /.col-full -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>