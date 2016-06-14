<?php 
$settings = array(
				'header_intro_message_heading' => '',
				'header_intro_message_content' => '',
				'header_intro_message_button_label' => '',
				'header_intro_message_button_url' => ''
			);
					
$settings = woo_get_dynamic_values( $settings );
?>

<div id="header-right">

	<section id="intro-message">
		<div class="col-full">
			<div class="left-section">
				<h2><?php echo esc_attr( $settings['header_intro_message_heading'] ); ?></h2>
				<p><?php echo wpautop( esc_attr( $settings['header_intro_message_content'] ) ); ?></p>
			</div>
			<div class="right-section">
				<a class="button" href="<?php echo $settings['header_intro_message_button_url']; ?>"><?php echo esc_attr( $settings['header_intro_message_button_label'] ); ?></a>
			</div>
		</div>
	</section><!--/#intro-message-->

</div><!--/#header-right-->
