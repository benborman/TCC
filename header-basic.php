<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Basic Header Template 
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options, $woocommerce;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php do_action( 'add_head_attributes' ); ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php
wp_head();
woo_head();
?>


<?php // include('includes/map-header-connect.php') ?>

</head>
<body <?php body_class(); ?>>


<?php woo_top(); ?>

<div id="wrapper">
	<div id="inner-wrapper">

    <?php //woo_header_before(); ?>
    
   
	<header id="header">



			<div id="header-inside">

				<?php //woo_header_inside(); ?>

			<div id="logo-checkout"><h1><span class="hidden">The Church Collective</span></h1></div>

			</div><!-- /#header-inside -->




	</header><!-- /#header -->
	
	<?php woo_content_before(); ?>