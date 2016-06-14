<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Identity Support
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
	<div id="feature" class="page featurehead id">
		<section class="full-width col-full" >
	    	<div class="id-logo">&nbsp;</div>
		</section>
		
	</div>
	
		<section class="full-width col-full entry fix" >
			
	    		<?php the_content(); ?>
	    
		<section id="main" class="fullwidth">			
			<div class="support">
			<h1>Support Chris Jackson</h1>
			
			
			<div class="tabcontainer">
  <ul class="tabs">
    <li><a href="#tab1">Credit Card</a></li>
    <li><a href="#tab2">PayPal</a></li>
  </ul>
  <div class="tab_content">
    <div id="tab1">
    
<div class="stripedonate">		            
<?php echo do_shortcode('[stripe description="Chris Jackson NZ Support"]
[stripe_amount label="Donation Amount:" default="20"]
[/stripe]'); ?>
</div>
<!--<div class="stripebadge"></div>-->

    </div>
    <div id="tab2">
	    <p>Prefer to use PayPal? No problem. Click the donate button and enter your donation on the PayPal site! </p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9MKNEJMNNH7KQ">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

    </div>

  </div>
</div>
			

			</div>
		</section>
		</section>
		

		<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>