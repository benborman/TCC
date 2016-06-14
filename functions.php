<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// WooFramework init
require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 			// Options panel settings and custom settings
				'includes/theme-functions.php', 		// Custom theme functions
				'includes/theme-actions.php', 			// Theme actions & user defined hooks
				'includes/theme-comments.php', 			// Custom comments/pingback loop
				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 			// Initialize widgetized areas
				'includes/theme-widgets.php'			// Theme widgets
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

if ( is_woocommerce_activated() ) {
	locate_template( 'includes/theme-woocommerce.php', true );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

// Removes width & height in post thumbnails

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


// Shortcodes in Excerpt

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');

add_action('init', 'my_custom_init');
function my_custom_init() {
	add_post_type_support( 'page', 'excerpt' );
}

add_action ('init', 'change_columns');
function change_columns() {
    add_filter( 'loop_shop_columns', 'custom_loop_columns' );
    
    function custom_loop_columns() {
        return 3;
    }
}


// Custom Post types in feed

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'podcast', 'tutorial');
	return $qv;
}
add_filter('request', 'myfeed_request');

// SKIP CART

//add_filter ('add_to_cart_redirect', 'woo_redirect_to_checkout');
 
//function woo_redirect_to_checkout() {
//  global $woocommerce;
//	$checkout_url = $woocommerce->cart->get_checkout_url();
//	return $checkout_url;
//}

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );

function custom_post_author_archive($query) {
    if ($query->is_author)
        $query->set( 'post_type', array('tutorial', 'post') );
    remove_action( 'pre_get_posts', 'custom_post_author_archive' );
}
add_action('pre_get_posts', 'custom_post_author_archive');

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['facebook'] = 'Facebook Username (not URL)';
	$profile_fields['instagram'] = 'Instagram Username';
	$profile_fields['twitter'] = 'Twitter Username';
	//$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['location'] = 'City / State';
	$profile_fields['church'] = 'Church';
	
		// Remove old fields
	unset($profile_fields['aim']);
	unset($profile_fields['jabber']);
	unset($profile_fields['yim']);
	

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {

	// add the file extension to the array

	$existing_mimes['syx'] = 'mime/type';
	$existing_mimes['h5e'] = 'mime/type';
	$existing_mimes['h4e'] = 'mime/type';
	$existing_mimes['5xe'] = 'mime/type';

        // call the modified list of extensions

	return $existing_mimes;

}

add_action('phpmailer_init', 'wp_mail_to_smtp');
  
function wp_mail_to_smtp(&$phpmailer) {
    $phpmailer->Sender = 'The Church Collective <content@thechurchcollective.com>';
    $phpmailer->From = 'content@thechurchcollective.com';
    $phpmailer->FromName = 'The Church Collective';
}


function prfx_featured_meta() {
    add_meta_box( 'prfx_meta', __( 'Featured Posts', 'prfx-textdomain' ), 'prfx_meta_callback', 'post', 'normal', 'high' );
    add_meta_box( 'prfx_meta', __( 'Featured Posts', 'prfx-textdomain' ), 'prfx_meta_callback', 'tutorial', 'normal', 'high' );
    add_meta_box( 'prfx_meta', __( 'Featured Posts', 'prfx-textdomain' ), 'prfx_meta_callback', 'podcast', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'prfx_featured_meta' );
 
/**
 * Outputs the content of the meta box
 */
 
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
 
 <p>
    <span class="prfx-row-title"><?php _e( 'Check if this is a featured post: ', 'prfx-textdomain' )?></span>
    <div class="prfx-row-content">
        <label for="featured-checkbox">
            <input type="checkbox" name="featured-checkbox" id="featured-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['featured-checkbox'] ) ) checked( $prfx_stored_meta['featured-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured Item', 'prfx-textdomain' )?>
        </label>
 
    </div>
</p>   
 
    <?php
}
 
/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
    // Checks save status - overcome autosave, etc.
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
// Checks for input and saves - save checked as yes and unchecked at no
if( isset( $_POST[ 'featured-checkbox' ] ) ) {
    update_post_meta( $post_id, 'featured-checkbox', 'yes' );
} else {
    update_post_meta( $post_id, 'featured-checkbox', 'no' );
}
 
}
add_action( 'save_post', 'prfx_meta_save' );

/* WooCommerce */

add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
function custom_pre_get_posts_query( $q ) {
 
if ( ! $q->is_main_query() ) return;
if ( ! $q->is_post_type_archive() ) return;
if ( ! is_admin() && is_shop() ) {
 
$q->set( 'tax_query', array(array(
'taxonomy' => 'product_cat',
'field' => 'slug',
'terms' => array( 'donations' ), // Don't display products in the donations category on the shop page
'operator' => 'NOT IN'
)));
}
 
remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
}

//global $wp_rewrite; $wp_rewrite->flush_rules();

/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>