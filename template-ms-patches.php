<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Mainstage Patches
 */

 global $woo_options;
 get_header();


?>
    <!-- #content Starts -->
    <div id="content" class="col-full">

        <?php woo_main_before(); ?>

       
		<?php woo_loop_before(); ?>
				   
        	<?php
        		if ( have_posts() ) { $count = 0;
        			while ( have_posts() ) { the_post(); $count++;
        	?>                                                             
        	        <article <?php post_class(); ?>>
						
					
							<h1><?php the_title(); ?></h1>
					
						<div class="social-single-list"><?php include('includes/social.php');?></div>
        	            
        	            <section class="entry">
	    	            	<?php the_content(); ?>
	    	           	</section><!-- /.entry -->
	    	           	<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
	    	          
					   	<div class="clear"></div>
						
			
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
					 <div class="table-search">Search: <input id="filter" type="text" /> <em>Can't find what you're looking for? <a href="#comments">Leave a request in the comments below!</a></em></div>
					<!-- <div><span class="star"></span> = Official Artist Patches</div>-->
					         			<table  data-filter="#filter" class="footable">
        			<thead> 
						<tr>
							<th>Preview</th>
							<th>Name</th>
							<th>Type</th>
							<th>Author</th>
							<th>Description</th>
							
							<?php if ( current_user_can('edit_post') ) {
								echo '<th>Edit</th>';
								} ?>
						
						</tr>
        			</thead>
        			<tbody>
        			
					<?php $loop = new WP_Query( array('post_type' => 'mspatch','posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
					<?php if($loop->have_posts()) : ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php $terms = get_the_terms( $post->ID, 'mspatchtype' ); ?>
					<tr>				                
				
					<td>

<?php $preview = get_post_meta($post->ID, "mspreview", true); ?>
<?php echo do_shortcode( "[sc_embed_player fileurl='$preview']") ?></td>
					<td class="tdthirty star"><a href="<?php echo get_post_meta ($post->ID, "mspatch", true); ?>"><?php the_title(); ?></a></td>
					<!--<td><?php echo get_post_meta($post->ID, "song", true); ?></td>-->
					<td><?php foreach( $terms as $term ) echo '' . $term->name; ?></td>
					<td><?php echo get_post_meta($post->ID, "author", true); ?></td>
					 <?php $edit= get_edit_post_link( $id, $context ); ?> 
					<td class="tdforty"><?php echo get_post_meta($post->ID, "description", true); ?></td>
					<?php if ( current_user_can('edit_post') ) {
								echo "<td><a href=\"$edit\" target=\"_blank\">Edit</a></td>";
								} ?>
				
				</tr>
                
				
						
				
				<?php endwhile; ?>
			<?php endif; ?>
			</tbody>
			
	<?php wp_reset_query(); ?>
	</table>	
	<a id="comments"></a>
	<?php comments_template(); ?>
        <?php woo_main_after(); ?>

		

    </div><!-- /#content -->

<?php get_footer(); ?>