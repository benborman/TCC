
			<nav id="navigation"  role="navigation">

				<section class="menus">
				<div class="col-full">
				<?php woo_header_inside(); ?>
					
					<a href="<?php echo home_url(); ?>" class="nav-home"><span><?php _e( 'Home', 'woothemes' ); ?></span></a>

			        <?php
						if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
							echo '<h3>' . woo_get_menu_name('primary-menu') . '</h3>';
							wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) );
						} else {
					?>
				        <ul id="main-nav" class="nav">
							<?php if ( is_page() ) $highlight = 'page_item'; else $highlight = 'page_item current_page_item'; ?>
							<li class="<?php echo $highlight; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'woothemes' ); ?></a></li>
							<?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
						</ul><!-- /#nav -->
					<?php } ?>

					<?php if ( is_woocommerce_activated() && isset( $woo_options['woocommerce_header_cart_link'] ) && 'true' == $woo_options['woocommerce_header_cart_link'] ) { ?>
			        	<h3><?php _e( 'Shopping Cart', 'woothemes' ); ?></h3>
			        	<ul class="nav cart">
			        		<li <?php if ( is_cart() ) { echo 'class="current-menu-item"'; } ?>>
			        		<?php
			        			global $woocommerce;
								woo_wc_cart_link();
							?>
			        		</li>
			       		</ul>
			        <?php } ?>

					<?php
						if ( 'true' == $woo_options['woo_header_contact'] ) {
					?>
						<div id="header-contact">
							<h3><?php _e( 'Call Us!', 'woothemes'); ?></h3>
							<ul class="nav">
								<?php if ( '' != $woo_options['woo_contact_number'] ) { ?>
								<li class="phone">
									<a href="tel:<?php $tel = preg_replace('/\D+/', '', $woo_options['woo_contact_number']); echo $tel; ?>"><?php echo esc_html( $woo_options['woo_contact_number'] ); ?></a>
									<span><?php echo esc_html( $woo_options['woo_contact_number'] ); ?></span>
								</li>
								<?php } ?>
							</ul>
						</div>
					<?php
						}
					?>
					</div>
		    	</section><!--/.menus-->

		        <a href="#top" class="nav-close"><span><?php _e('Return to Content', 'woothemes' ); ?></span></a>

			</nav><!-- /#navigation -->
