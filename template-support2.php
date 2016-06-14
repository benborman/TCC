<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Support 2
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
	<div id="feature" class="page featurehead teal">
		<section class="full-width col-full" >
	    		<?php the_content(); ?>
    	</section>
		
	</div>


    <div id="content" class="page col-full">
		<section id="main" class="fullwidth">			
			<div class="donate donate-left">
			<h1>One-Time Donation</h1>
			
			
			<div class="tabcontainer">
  <ul class="tabs">
   
    <li><a href="#tab2">PayPal</a></li>
  </ul>
  <div class="tab_content">

    <div id="tab2">
	    <p>Click the donate button and enter your donation on the PayPal site! </p>
     <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="HMWK4CZAJ4T8L">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
    </div>

  </div>
</div>
			

			</div>
			
			
			<div class="donate donate-right">
			<h1>Monthly Donation</h1>
			<div class="donate_content">
			<p>Setting up a monthly donation is easy! <br />
			Click the button below to create an account and set your monthly amount. You can make changes to your gift at any time.</p>
			<a class="button-orange" href="/shop/donations/monthly-donation/">Donate</a>
			</div>
			</div>
			<div class="clear"></div>
		</section><!-- /#main -->
		<!--<section>
		<div id="content" class="home-widgets">

		<!--	<div class="widget_woothemes_testimonials"><div class="col-full">
			<h1>Testimonials</h1>
			<?php //do_action( 'woothemes_testimonials', array( 'limit' => 10, 'size' => 200, 'per_row' => 3 ) ); ?>
			</div>
			</div>
		</div> 
			
		</section> -->
		

		<?php woo_main_after(); ?>
	<div class="comodo"></div>

    </div><!-- /#content -->

<?php get_footer(); ?>