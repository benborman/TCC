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

	

		
		<header>
			<?php //woo_post_meta(); ?>			
			<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		</header>

		<section class="entry">

		<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'content' ) { the_content( __( 'More Info &rarr;', 'woothemes' ) ); } else { the_excerpt(); } ?>
		</section>

		<footer class="post-more">
		<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'excerpt' ) { ?>
			<span class="read-more"><a class="button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'More Info &rarr;', 'woothemes' ); ?>"><?php _e( 'More Info &rarr;', 'woothemes' ); ?></a></span>
		<?php } ?>
		</footer>

	</article><!-- /.post -->