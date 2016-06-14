<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $woo_options;

/*-----------------------------------------------------------------------------------*/
/* This theme supports WooCommerce, woo! */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'woocommerce' );


/*-----------------------------------------------------------------------------------*/
/* Styles */
/*-----------------------------------------------------------------------------------*/

// Disable WooCommerce styles
if ( version_compare( WOOCOMMERCE_VERSION, '2.1' ) >= 0 ) {
    // WooCommerce 2.1 or above is active
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
    // WooCommerce less than 2.1 is active
    define( 'WOOCOMMERCE_USE_CSS', false );
}

// Load WooCommerce stylsheet
if ( ! is_admin() ) { add_action( 'wp_enqueue_scripts', 'woo_wc_css', 20 ); }

if ( ! function_exists( 'woo_wc_css' ) ) {
	function woo_wc_css () {
		wp_register_style( 'woocommerce', esc_url( get_template_directory_uri() . '/css/woocommerce.css' ) );
		wp_enqueue_style( 'woocommerce' );
	} // End woo_wc_css()
}


/*-----------------------------------------------------------------------------------*/
/* Products */
/*-----------------------------------------------------------------------------------*/

// Number of columns on product archives
add_filter( 'loop_shop_columns', 'woo_wc_loop_columns' );
if ( ! function_exists( 'woo_wc_loop_columns' ) ) {
	function woo_wc_loop_columns() {
		global $woo_options;
		if ( ! isset( $woo_options['woocommerce_product_columns'] ) ) {
			$cols = 3;
		} else {
			$cols = $woo_options['woocommerce_product_columns'] + 2;
		}
		return $cols;
	} // End woo_wc_loop_columns()
}

// Number of products per page
add_filter( 'loop_shop_per_page', 'woo_wc_products_per_page' );

if ( ! function_exists( 'woo_wc_products_per_page' ) ) {
	function woo_wc_products_per_page() {
		global $woo_options;
		if ( isset( $woo_options['woocommerce_products_per_page'] ) ) {
			return $woo_options['woocommerce_products_per_page'];
		}
	} // End woo_wc_products_per_page()
}

// Remove WooCommerce objects based on settings
add_action( 'wp_head', 'woo_wc_feature_check' );
if ( ! function_exists( 'woo_wc_feature_check' ) ) {
	function woo_wc_feature_check() {
		global $woo_options;
		if ( isset( $woo_options['woocommerce_product_tabs'] ) && 'false' == $woo_options['woocommerce_product_tabs'] ) {
			add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
		}
		if ( isset( $woo_options['woocommerce_archives_star_rating'] ) && 'false' == $woo_options['woocommerce_archives_star_rating'] ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		}
		if ( isset( $woo_options['woocommerce_related_products'] ) &&  'false' == $woo_options['woocommerce_related_products'] ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woo_wc_output_related_products', 20);
		}
		if ( isset( $woo_options['woocommerce_archives_add_to_cart'] ) &&  'false' == $woo_options['woocommerce_archives_add_to_cart'] ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}
		if ( isset( $woo_options['woocommerce_archives_thumbnail'] ) &&  'false' == $woo_options['woocommerce_archives_thumbnail'] ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		}
	} // End woo_wc_feature_check()
}

// Remove product tabs
function woo_remove_product_tabs( $tabs ) {
    $tabs = array();
    return $tabs;
}

// Replace the default upsell function with our own which displays the correct number of rows
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woo_wc_upsell_display', 15 );
if (!function_exists('woo_wc_upsell_display')) {
	function woo_wc_upsell_display() {
	    global $woo_options;
	    woocommerce_upsell_display( 999, ( $woo_options['woocommerce_product_columns'] + 2 ) );
	}
}

// Replace the default related products function with our own which displays the correct number or rows
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'woo_wc_output_related_products', 20 );
if (!function_exists('woo_wc_output_related_products')) {
	function woo_wc_output_related_products() {
		global $woo_options;
		$products_max = $woo_options['woocommerce_related_products_maximum'] + 2;

		$columns = $woo_options['woocommerce_product_columns'] + 2;

		if ( is_single() && ( $woo_options['woocommerce_related_products_maximum'] < $woo_options['woocommerce_product_columns'] ) ) {
			$columns = $woo_options['woocommerce_related_products_maximum'] + 2;
		}

	    woocommerce_related_products( $products_max, $columns );
	}
}

// Custom place holder
add_filter( 'woocommerce_placeholder_img_src', 'woo_wc_placeholder_img_src' );

if ( ! function_exists( 'woo_wc_placeholder_img_src' ) ) {
	function woo_wc_placeholder_img_src( $src ) {
		global $woo_options;
		if ( isset( $woo_options['woo_placeholder_url'] ) && '' != $woo_options['woo_placeholder_url'] ) {
			$src = $woo_options['woo_placeholder_url'];
		}
		else {
			$src = get_template_directory_uri() . '/images/wc-placeholder.gif';
		}
		return esc_url( $src );
	} // End woo_wc_placeholder_img_src()
}


/*-----------------------------------------------------------------------------------*/
/* Layout */
/*-----------------------------------------------------------------------------------*/

// Adjust markup on all woocommerce pages
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'woo_wc_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'woo_wc_after_content', 20 );

if ( ! function_exists( 'woo_wc_before_content' ) ) {
	function woo_wc_before_content() {
		global $woo_options;
		if ( ! isset( $woo_options['woocommerce_product_columns'] ) ) {
			$columns = 'woocommerce-columns-3';
		} else {
			$columns = 'woocommerce-columns-' . ( $woo_options['woocommerce_product_columns'] + 2 );
		}

		if ( is_single() &&  ( $woo_options['woocommerce_related_products_maximum'] < $woo_options['woocommerce_product_columns'] ) ) {
			$columns = 'woocommerce-columns-' . ( $woo_options['woocommerce_related_products_maximum'] + 2 );
		}

		?>
		<!-- #content Starts -->
		<?php woo_content_before(); ?>
	    <div id="content" class="col-full <?php echo esc_attr( $columns ); ?>">

	        <!-- #main Starts -->
	        <?php woo_main_before(); ?>
	        <div id="main" class="col-left">

	    <?php
	} // End woo_wc_before_content()
}


if ( ! function_exists( 'woo_wc_after_content' ) ) {
	function woo_wc_after_content() {
		?>

			</div><!-- /#main -->
	        <?php woo_main_after(); ?>

	    </div><!-- /#content -->
		<?php woo_content_after(); ?>
	    <?php
	} // End woo_wc_after_content()
}

// Add a class to the body if full width shop archives are specified
add_filter( 'body_class','woo_wc_layout_body_class', 10 );		// Add layout to body_class output
if ( ! function_exists( 'woo_wc_layout_body_class' ) ) {
	function woo_wc_layout_body_class( $wc_classes ) {
		global $woo_options;

		$layout = '';

		// Add layout-full class to product archives if necessary
		if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'true' == $woo_options['woocommerce_archives_fullwidth'] && ( is_shop() || is_product_category() ) ) {
			$layout = 'layout-full';
		}
		// Add layout-full class to single product pages if necessary
		if ( $woo_options[ 'woocommerce_products_fullwidth' ] == "true" && ( is_product() ) ) {
			$layout = 'layout-full';
		}

		// Add classes to body_class() output
		$wc_classes[] = $layout;
		return $wc_classes;
	} // End woocommerce_layout_body_class()
}

/*-----------------------------------------------------------------------------------*/
/* Breadcrumb */
/*-----------------------------------------------------------------------------------*/

// Remove WC breadcrumb (we're using the WooFramework breadcrumb (hooked into woo_main_before))
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );


/*-----------------------------------------------------------------------------------*/
/* Sidebar */
/*-----------------------------------------------------------------------------------*/

// Remove WC sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Add the WC sidebar in the right place and remove it from shop archives if specified
add_action( 'woo_main_after', 'woo_wc_get_sidebar', 10 );

if ( ! function_exists( 'woo_wc_get_sidebar' ) ) {
	function woo_wc_get_sidebar() {
		global $woo_options;

		// Display the sidebar if full width option is disabled on archives
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'false' == $woo_options['woocommerce_archives_fullwidth'] ) {
				get_sidebar('shop');
			}
		}
		if ( is_product() ) {
			if ( $woo_options[ 'woocommerce_products_fullwidth' ] == 'false' ) {
				get_sidebar('shop');
			}
		}

	} // End woo_wc_get_sidebar()
}


/*-----------------------------------------------------------------------------------*/
/* Pagination / Search */
/*-----------------------------------------------------------------------------------*/

// Remove pagination (we're using the WooFramework default pagination)
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'woo_wc_pagination', 10 );

if ( ! function_exists( 'woo_wc_pagination' ) ) {
function woo_wc_pagination() {
	if ( is_search() && is_post_type_archive() ) {
		add_filter( 'woo_pagination_args', 'woo_wc_add_search_fragment', 10 );
		add_filter( 'woo_pagination_args_defaults', 'woo_wc_pagination_defaults', 10 );
	}
	woo_pagination();
} // End woo_wc_pagination()
}

if ( ! function_exists( 'woo_wc_add_search_fragment' ) ) {
function woo_wc_add_search_fragment ( $settings ) {
	$settings['add_fragment'] = '&post_type=product';
	return $settings;
} // End woo_wc_add_search_fragment()
}

if ( ! function_exists( 'woo_wc_pagination_defaults' ) ) {
function woo_wc_pagination_defaults ( $settings ) {
	$settings['use_search_permastruct'] = false;
	return $settings;
} // End woo_wc_pagination_defaults()
}

/*-----------------------------------------------------------------------------------*/
/* Cart Fragments */
/*-----------------------------------------------------------------------------------*/

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'add_to_cart_fragments', 'woo_wc_header_add_to_cart_fragment' );

if ( ! function_exists( 'woo_wc_header_add_to_cart_fragment' ) ) {
	function woo_wc_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		woo_wc_cart_link();

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	} // End woo_wc_header_add_to_cart_fragment()
}

if ( ! function_exists( 'woo_wc_cart_link' ) ) {
	function woo_wc_cart_link() {
		global $woocommerce;
		?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><span class="count"><?php echo sprintf( _n('<span>%d</span> item', '<span>%d</span> items', $woocommerce->cart->cart_contents_count, 'woothemes' ), $woocommerce->cart->cart_contents_count );?></span></a>
		<?php
	}
}