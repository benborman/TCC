<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Identity
  *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
<?php woo_main_before(); ?>
	<div id="feature" class="page featurehead id " data-stellar-background-ratio="-0.2">
		<section class="full-width col-full" >
	    	<div class="id-logo">&nbsp;</div>
		</section>
		
	</div>
	
		<section class="full-width col-full entry" >
			
	    		<?php the_content(); ?>
	    		
		
		</section>
		

		<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>