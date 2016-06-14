<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The default template for displaying content
 */

	global $woo_options;

/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */


?>


	<article class="review-thumbnail">
	<div class="product-column">

	<?php woo_image( 'width=250&height=250&class=thumbnail' ); ?>
	      
 <div class="article-content">
				<?php $posttype = get_post_type() ?>
				<header>
					<!--<aside class="post-meta">
						<ul>
							<li class="post-date">
								<span><?php the_time( get_option( 'date_format' ) ); ?></span>
							</li>
							<li class="post-comments">
								<span class="small">/</span>
								<?php comments_popup_link( __( 'Leave a comment', 'woothemes' ), __( '1 Comment', 'woothemes' ), __( '% Comments', 'woothemes' ) ); ?>
							</li>		
						</ul>
					</aside>	-->
					<?php //the_excerpt(); ?>
					<p class="category-name"><?php //echo get_the_term_list( $post->ID, 'tutorial-type', '', ', ', '' );  } ?> </p>		
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><h1 class="home-link"><?php the_title(); ?></h1></a>
				</header>
					       <!--   <div class="product-score">	<?php 
           
                	$option1 = get_post_meta($post->ID, "option_1_grade", true); 
                	$option2 = get_post_meta($post->ID, "option_2_grade", true);
                	$option3 = get_post_meta($post->ID, "option_3_grade", true);
                	$option4 = get_post_meta($post->ID, "option_4_grade", true);
                	$option5 = get_post_meta($post->ID, "option_5_grade", true);
					
					
					$a = array($option1, $option2, $option3, $option4, $option5);
					array_filter($a, function($x) { return !empty($x); });
						array_filter($a);
						$count =  count(array_filter($a));

                	$criteria = $count * 10;

                	$rawscore = get_post_meta($post->ID, "option_overall_score", true); $finalscore = $rawscore/$criteria; 
                	
                	$roundscore = round($finalscore, 1, PHP_ROUND_HALF_DOWN);  
                	echo $roundscore; ?></div> -->	
					

				<section class="entry">
				
					
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php //the_excerpt(); ?>
					</a>
					<!--<?php include('social-home.php');?>-->
				</section>

		    </div><!-- /.article-content -->
	</div>

	</article><!-- /.post -->

	
	
	
	
	
	
	
	
	
	
	