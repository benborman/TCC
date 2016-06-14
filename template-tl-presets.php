<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Timeline Presets
 */

 global $woo_options;
 get_header();


?>
    <!-- #content Starts -->
    	
    	<div id="feature" class="featurehead timeline-feature" data-stellar-background-ratio="-0.2" >
	    	<div class="feature-dark">
			
	    		<div class="feature-content"><h1><?php the_title(); ?></h1></div>
			
		
			</div>
    	</div>
    <div id="content" class="col-full">

        <?php woo_main_before(); ?>
		<?php woo_loop_before(); ?>
        	<?php
        		if ( have_posts() ) { $count = 0;
        			while ( have_posts() ) { the_post(); $count++;
        	?>                                                             
        	        <article <?php post_class(); ?>>
						<div class="social-single-list"><?php include('includes/social.php');?></div>
        	            <section class="entry">
	    	            	<?php the_content(); ?>
	    	           	</section><!-- /.entry -->
	    	           	<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
	    	           	<section class="pedal-icons">
	    	           	
	    	           		<div id="browse">
		    	           		<h2>Browse & Download</h2>
		    	           		<p>Check out our vast collection of settings - many specific to worship songs, and some great general use presets, and of course ambient guitar settings!</p>
		    	           	</div>
		    	           	
		    	           	<div id="sync">
			    	           	<h2>Sync To Your Device</h2>
			    	           	<p>To use these presets, make sure your Timeline <a href="http://www.strymon.net/support/faqs/timeline-firmware-revision-release-notes/" target="_blank">firmware is up to date</a>. Sync to your device via a <a href="http://www.amazon.com/M-Audio-Midisport-Uno-MIDI-Interface/dp/B00007JRBM/ref=sr_1_1?ie=UTF8&qid=1400463163&sr=8-1&keywords=m-audio+midisport+uno" target="_blank">Midi to USB cable</a> and <a href="http://www.strymon.net/support/timeline/" target="_blank">Strymon Librarian software</a> for Mac or PC.  </p>
		    	           	</div>
		    	           
		    	           	<div id="create">
			    	           	<h2>Create & Upload</h2>
			    	           	<p>This resource wouldn't exist without your help! If you've got some presets you'd like to share, please send them in!</p>
			    	           	<p><a href="https://thechurchcollective.wufoo.com/forms/z17v2wht0pzz03m/" onclick="window.open(this.href,  null, 'height=785, width=680, toolbar=0, location=0, status=1, scrollbars=1, resizable=1'); return false">Upload Single Preset</a> | <a href="https://thechurchcollective.wufoo.com/forms/mub87m01p07i7u/" onclick="window.open(this.href,  null, 'height=460, width=680, toolbar=0, location=0, status=1, scrollbars=1, resizable=1'); return false">Upload Bulk Presets</a></p>
		    	           	</div>
		    	           	<div id="support">
			    	           	<h2>Support The Collective</h2>
			    	           	<p>If you've found this resource helpful, please consider making a small donation to support The Church Collective! </p>
			    	           	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ANMDW8QBGWZK2">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


		    	           	</div>
	    	           	</section>
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
					 <div><span class="star"></span> = Official Artist Presets</div>
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
						
						</tr>
        			</thead>
        			<tbody>
        			
					<?php $loop = new WP_Query( array('post_type' => 'tlpreset','posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
					<?php if($loop->have_posts()) : ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php $terms = get_the_terms( $post->ID, 'tlpresettype' ); ?>
					<tr class="<?php foreach( $terms as $term ) echo '' . $term->slug; ?>">				                
				
					
					<td class="tdthirty star"><a href="<?php echo get_post_meta ($post->ID, "tlpreset", true); ?>"><?php the_title(); ?></a></td>
					<td><?php echo get_post_meta($post->ID, "song", true); ?></td>
					<td><?php echo get_post_meta($post->ID, "artist", true); ?></td>
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
	
	<?php comments_template(); ?>
        <?php woo_main_after(); ?>

        	    </section>

    </div><!-- /#content -->

<?php get_footer(); ?>