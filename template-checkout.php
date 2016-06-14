<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Checkout
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
 *
 * @package WooFramework
 * @subpackage Template
 */
	//get_header();
 include('header-basic.php'); 
	global $woo_options;
?>

    <div id="content" class="page col-center">

    	<?php woo_main_before(); ?>

		<section id="main" class="fullwidth">
			<article <?php post_class(); ?>>

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
	                	<div class="comodo right"></div>
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
			</article>
		</section><!-- /#main -->

		<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php  include('footer-basic.php');  ?>