<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Featured Slider Template
 *
 * Here we setup all HTML pertaining to the featured slider.
 *
 * @package WooFramework
 * @subpackage Template
 */

/* Retrieve the settings and setup query arguments. */
$settings = array(
				'featured_entries' => '3',
				'featured_order' => 'DESC',
				'featured_slide_group' => '0',
				'featured_videotitle' => 'true',
				'featured_nextprev' => 'true',
				'featured_pagination' => 'true'
				);

$settings = woo_get_dynamic_values( $settings );

$query_args = array(
				'limit' => $settings['featured_entries'],
				'order' => $settings['featured_order'],
				'term' => $settings['featured_slide_group']
				);

/* Retrieve the slides, based on the query arguments. */
$slides = woo_featured_slider_get_slides( $query_args );

/* Media settings */
$media_settings = array( 'width' => '320', 'height' => '240' );

if ( 'true' != $settings['featured_videotitle'] ) {
	$media_settings['width'] = '640';
	$media_settings['height'] = '420';
}

/* Begin HTML output. */
if ( false != $slides ) {
	$count = 0;

	$container_css_class = 'flexslider';

	if ( 'true' == $settings['featured_videotitle'] ) {
		$container_css_class .= ' default-width-slide';
	} else {
		$container_css_class .= ' full-width-slide';
	}

	$image_small = '';
	$controls = '';

?>

<div id="header-right">

	<div id="featured-slider" class="flexslider <?php echo esc_attr( $container_css_class ); ?>">
		<ul class="slides">
	<?php
		foreach ( $slides as $k => $post ) {
			setup_postdata( $post );
			$count++;

			$url = get_post_meta( get_the_ID(), 'url', true );
			$layout = get_post_meta( get_the_ID(), '_layout', true );
			$title = get_the_title();

			// clear variables
			$image = '';
			$image_small = '';

			if ( $url != '' ) {
				$title = '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '">' . $title . '</a>';
			}

			$css_class = 'slide-number-' . esc_attr( $count );

			$slide_media = '';
			$embed = woo_embed( 'width=' . intval( $media_settings['width'] ) . '&height=' . intval( $media_settings['height'] ) . '&class=slide-video' );
			if ( '' != $embed ) {
				$css_class .= ' has-video';
				$slide_media = $embed;
			} else {
				$image = woo_image( 'width=745&height=273&noheight=true&class=slide-image&link=img&return=true' );
				$image_small = woo_image( 'width=45&height=45&noheight=true&class=&link=img&return=true' );			
				if ( '' != $image ) {
					$css_class .= ' has-image no-video';
					$slide_media = $image;
				} else {
					$css_class .= ' no-image';
				}
			}
			if ( $layout )  {
				$css_class .= ' ' . $layout;
			}

			// Manual Controls
			if ( 'true' == $settings['featured_pagination'] ) {
				$controls .= '<li class="slide-control"><a class="' . esc_attr( $css_class ) . '" data-slidepag="' . ($count-1) . '" href="#">' . $image_small . '</a></li>';
			}
	?>
			<li class="slide <?php echo esc_attr( $css_class ); ?>">
				<?php
					if ( '' != $slide_media ) {
						echo "<div class=\"slide-media\"><a href=\"$url\">$slide_media</div><!--/.slide-media-->" . "\n";
					}
				?>
				<?php if ( '' == $embed || ( '' != $embed && 'true' == $settings['featured_videotitle'] ) ) { ?>
				<div class="slide-content">
					</a>
				</div><!--/.slide-content-->
				<?php } ?>
			</li>
	<?php } wp_reset_postdata(); ?>
		</ul>
	</div><!--/#featured-slider-->
	<div id="slider-pagination">
		<ul>
			<?php if ( 'true' == $settings['featured_nextprev'] ) { ?><li><a class="prev" data-slidepag="prev" href="#"><?php _e('Previous', 'woothemes'); ?></a></li><?php } ?>
			<?php if ( '' != $controls ) { echo $controls; } ?>
			<?php if ( 'true' == $settings['featured_nextprev'] ) { ?><li><a class="next" data-slidepag="next" href="#"><?php _e('Next', 'woothemes'); ?></a></li><?php } ?>
		</ul>
	</div><!--/#slider-pagination-->

</div><!--/#header-right-->

<?php
} else {
	echo do_shortcode( '[box type="info"]' . __( 'Please add some slides in the WordPress admin to show in the Featured Slider.', 'woothemes' ) . '[/box]' );
}
?>