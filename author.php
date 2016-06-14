<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>

    <div id="content" class="col-full">

    	<?php woo_main_before(); ?>

		<section id="main" class="col-left">
		<?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    query_posts( array(
            'post_type' => array('post','tutorial','podcast'),
            'author' => $author,
            'posts_per_page' => -1 )
        );
 
?>
		<?php if (have_posts()) : $count = 0; ?>

            <header class="archive-header">            	
				<aside id="post-author" class="fix">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID',$author ), '100' ); ?></div>
					<div class="profile-content">
					
						<h3 class="title"><?php the_author_meta('display_name',$author); ?></h3>
							<p class="bio"><?php the_author_meta( 'description'); ?><?php $website = get_the_author_meta('user_url'); if(!empty($website)){echo " <a target=\"_blank\" href=\"$website\">$website</a>";} ?></p>
						
					</div><!-- .post-entries -->
					<?php //$website = get_the_author_meta('user_url'); if(!empty($website)){echo "<a class=\"button\" target=\"_blank\" href=\"$website\">Website</a>";} ?>
					<?php $facebookURL = get_the_author_meta('facebook'); if(!empty($facebookURL)){echo "<a class=\"fb\" target=\"_blank\" href=\"http://www.facebook.com/$facebookURL\"></a>";} ?>
					<?php $twitterHandle = get_the_author_meta('twitter'); if(!empty($twitterHandle)){echo "<a class=\"twitter\" target=\"_blank\" href=\"http://www.twitter.com/$twitterHandle\"></a>";} ?>
					<?php $igHandle = get_the_author_meta('instagram'); if(!empty($igHandle)){echo "<a class=\"ig\" target=\"_blank\" href=\"http://www.instagram.com/$igHandle\"></a>";} ?>
				</aside><!-- .post-author-box -->
			<h1>All Posts by <?php the_author_meta('display_name',$author); ?></h1>
            </header>
			


        <?php
        	// Display the description for this archive, if it's available.
        	woo_archive_description();
        ?>

	        <div class="fix"></div>

        	<?php woo_loop_before(); ?>

			<?php /* Start the Loop */ ?>
			
			<?php while ( have_posts() ) : the_post(); $count++; ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>
			

			<?php endwhile; ?>

	        <?php else: ?>
 <header class="archive-header">            	
				<aside id="post-author" class="fix">
					<div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID',$author ), '100' ); ?></div>
					<div class="profile-content">
						<h3 class="title"><?php the_author_meta('display_name',$author); ?></h3>
						<?php the_author_meta( 'description',$author); ?>
						
					</div><!-- .post-entries -->
					<?php //$twitterHandle = get_the_author_meta('twitter'); if(!empty($twitterHandle)){echo "<a class=\"twitter\" target=\"_blank\" href=\"http://www.twitter.com/$twitterHandle\"></a>";} ?>
				</aside><!-- .post-author-box -->
			
            </header>

	        <?php endif; ?>

	        <?php woo_loop_after(); ?>

			<?php woo_pagenav(); ?>

		</section><!-- /#main -->

		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>