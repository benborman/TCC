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

 	$settings = array(
					'thumb_w' => 844,
					'thumb_h' => 352,
					'thumb_align' => 'alignleft'
					);

	$settings = woo_get_dynamic_values( $settings );

?>

	<article <?php post_class('post'); ?>>
		<?php 

if (class_exists('MultiPostThumbnails')) : 

MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');

endif;

 ?>

		<?php

			if ( ( post_type_exists('feature') && is_post_type_archive('feature') ) || ( post_type_exists('testimonial') && is_post_type_archive('testimonial') ) ) {
		 		$settings = array( 'thumb_w' => 300, 'thumb_h' => 300, 'thumb_align' => 'alignleft' );
	 		}

		?>


	     <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(235,235), array( 'class' => 'woo-image thumbnail alignleft' )); ?></a>

		<header>
			<?php woo_post_meta(); ?>	
			<?php $posttype = get_post_type( $post ) ?>
			<p class="category-name"><?php if(($posttype == post)){ the_category(' ');} ?><?php if(($posttype == podcast)){ echo "<a href=\"/podcast\" >Podcast</a>"; } ?><?php if(($posttype == tutorial)){ echo get_the_term_list( $post->ID, 'tutorial-type', '', ', ', '' );  } ?>: </p>		
			<h1 class="list-link"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		</header>

		<section class="entry">

		<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'content' ) { the_content( __( 'Continue Reading &rarr;', 'woothemes' ) ); } else { the_excerpt(); } ?>		
		<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'excerpt' ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Continue Reading &rarr;', 'woothemes' ); ?>"><?php _e( 'Continue Reading &rarr;', 'woothemes' ); ?></a>
		<?php } ?>
		
		</section>



	</article><!-- /.post -->
	