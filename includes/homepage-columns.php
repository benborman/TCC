<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Homepage Columns
 *
 * Homepage Widgets
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

	if ( woo_active_sidebar( 'homepage-columns-left' ) ||
		 woo_active_sidebar( 'homepage-columns-center' ) ||
		 woo_active_sidebar( 'homepage-columns-right' ) ) {

	?>

		<section id="homepage-columns" class="home-section">

			<div class="col-full">

				<?php if ( woo_active_sidebar( 'homepage-columns-left' ) ) { ?>
				<div class="block double">
					<?php woo_sidebar( 'homepage-columns-left' ); ?>
				</div><!-- /.block -->
				<?php } ?>

				<?php if ( woo_active_sidebar( 'homepage-columns-center' ) ) { ?>
				<div class="block">
					<?php woo_sidebar( 'homepage-columns-center' ); ?>
				</div><!-- /.block -->
				<?php } ?>

				<?php if ( woo_active_sidebar( 'homepage-columns-right' ) ) { ?>
				<div class="block last">
					<?php woo_sidebar( 'homepage-columns-right' ); ?>
				</div><!-- /.block -->			
				<?php } ?>

			</div><!-- /.col-full -->		

		</section><!-- /#homepage-columns -->

	<?php

	}

?>