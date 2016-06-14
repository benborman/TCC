<?php
/*
Template Name: Styleguide
*/
?>

<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
       
    <div id="content" class="page col-full">
    
    	<?php woo_main_before(); ?>
    	
		<section id="main"> 			

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>                                                           
            <article <?php post_class(); ?>>
				
				<header>
			    	<h1><?php the_title(); ?></h1>
				</header>
				
                <section class="entry">
                	
                    <h1>This is an H1 heading</h1>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h2>This is an H2 heading</h2>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h3>This is an H3 heading</h3>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h4>This is an H4 heading</h4>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h5>This is an H5 heading</h5>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h6>This is an H6 heading</h6>
                   	
                   	<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
                   	
                   	<h2>List styling</h2>
                   	
                   	<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
                   	
                   	<ul>
                   		<li>Nunc sollicitudin.</li>
                   		<li>Nisl faucibus vestibulum cursus.</li>
                   		<li>Mi nibh gravida erat. Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</li>
                   		<li>Ultrices luctus nunc quam ac neque.</li>
                   		<li><a href="#" title="#">Cras convallis volutpat tellus.</a></li>
                   		<li>At laoreet erat facilisis sed.</li>
                   		<li>Phasellus sed fringilla magna.
                   			<ul>
                   				<li>Nisl faucibus vestibulum cursus.
                   					<ul>
                   						<li>Ultrices luctus nunc quam ac neque.</li>
                   						<li><a href="#" title="#">Cras convallis volutpat tellus.</a></li>
                   						<li>At laoreet erat facilisis sed.</li>
                   					</ul>
                   				</li>
                   				<li>Mi nibh gravida erat. Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</li>
                   				<li>Ultrices luctus nunc quam ac neque.</li>
                   			</ul>
                   		</li>
                   		<li>Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat. Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque.</li>
                   		<li>Nulla elit nulla, egestas nec luctus ac.</li>
                   		<li>Rutrum nec ligula. Integer bibendum.</li>
                   	</ul>
                   	
                   	<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
                   	
                   	<ol>
                   		<li>Nunc sollicitudin.</li>
                   		<li>Nisl faucibus vestibolum cursus.</li>
                   		<li>Mi nibh gravida erat. Nunc sollicitudin, nisl faucibus vestibolum cursus, mi nibh gravida erat, oltrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</li>
                   		<li>Ultrices luctus nunc quam ac neque.</li>
                   		<li><a href="#" title="#">Cras convallis volutpat tellus.</a></li>
                   		<li>At laoreet erat facilisis sed.</li>
                   		<li>Phasellus sed fringilla magna.
                   			<ol>
                   				<li>Nisl faucibus vestibolum cursus.
                   					<ol>
                   						<li>oltrices luctus nunc quam ac neque.</li>
                   						<li><a href="#" title="#">Cras convallis volutpat tellus.</a></li>
                   						<li>At laoreet erat facilisis sed.</li>
                   					</ol>
                   				</li>
                   				<li>Mi nibh gravida erat. Nunc sollicitudin, nisl faucibus vestibolum cursus, mi nibh gravida erat, oltrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</li>
                   				<li>oltrices luctus nunc quam ac neque.</li>
                   			</ol>
                   		</li>
                   		<li>Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat. Nunc sollicitudin, nisl faucibus vestibolum cursus, mi nibh gravida erat, oltrices luctus nunc quam ac neque.</li>
                   		<li>Nolla elit nolla, egestas nec luctus ac.</li>
                   		<li>Rutrum nec ligola. Integer bibendum.</li>
                   	</ol>
                   	
                   	<h2>Blockquote</h2>
                   	
                   	<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
                   	
                   	<blockquote><p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p></blockquote>

					<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
                        
                   	<h2>Buttons</h2>
                   	<a class="button small">Default button small</a><br/><br/>
                   	<a class="button">Default button</a><br/><br/>
                   	<a class="button large">Default button large</a><br/><br/>
                   	
                   	<h2>Forms</h2>
                   	
                   	<form>
                   	    
                   	    <p>
                   	    	<label>Name</label>
                   	    	<input type="text" />
                   	    </p>
                   	    <p>
                   	    	<label>Email</label>
                   	    	<input type="email" />
                   	    </p>
                   	    <p>
                   	    	<label>Password</label>
                   	    	<input type="password" />
                   	    </p>
                   	    <p>
                   	    	<label>Checkbox</label>
                   	    	<input type="checkbox" />
                   	    	<input type="checkbox" />
                   	    	<input type="checkbox" />
                   	    </p>
                   	    <p>
                   	    	<label>Radio Button</label>
                   	    	<input type="radio" />
                   	    	<input type="radio" />
                   	    	<input type="radio" />
                   	    </p>
                   	    <p>
                   	    	<label>Select</label>
                   	    	<select>
                   	    		<option>Uno</option>
                   	    		<option>Dos</option>
                   	    	</select>
                   	    </p>
                   	    <p>
                   	    	<label>Textarea</label>
                   	    	<textarea></textarea>
                   	    </p>
                   	    <p class="form-button">
                   	    	<input type="submit" value="Submit" />
                   	    	<input type="button" value="Button" />
                   	    </p>
                   	
                   	</form>
                   	
                   	<h2>Tables</h2>
                   	
                   	<table>
                   	
                   		<thead>
                   			<tr>
                   				<th>Header</th>
                   				<th>Header</th>
                   			</tr>
                   		</thead>
                   			
                   		<tbody>
                   			<tr>
                   				<td>Body</td>
                   				<td>Body</td>
                   			</tr>
                   			<tr>
                   				<td>Body</td>
                   				<td>Body</td>
                   			</tr>
                   			<tr>
                   				<td>Body</td>
                   				<td>Body</td>
                   			</tr>
                   			<tr>
                   				<td>Body</td>
                   				<td>Body</td>
                   			</tr>
                   		</tbody>
                   		
                   		<tfoot>
                   			<tr>
                   				<td>Footer</td>
                   				<td>Footer</td>
                   			</tr>
                   		</tfoot>
                   		
                   	</table>
                   	
                   	<h2>Shortcode Buttons</h2>
                   	
                   	<div>
                   		<?php
                   		echo do_shortcode('[button]Button[/button]');
                   		echo do_shortcode('[button color="red"]Button[/button]');
						echo do_shortcode('[button color="orange"]Button[/button]');
						echo do_shortcode('[button color="green"]Button[/button]');
						echo do_shortcode('[button color="aqua"]Button[/button]');
						echo do_shortcode('[button color="teal"]Button[/button]');
						echo do_shortcode('[button color="purple"]Button[/button]');
						echo do_shortcode('[button color="pink"]Button[/button]');
						echo do_shortcode('[button color="silver"]Button[/button]');
						echo do_shortcode('[button size="small"]Button[/button]');
						echo do_shortcode('[button]Button[/button]');
						echo do_shortcode('[button size="large"]Button[/button]');
						echo do_shortcode('[button size="xl"]Button[/button]');
						echo do_shortcode('[button style="alert" color="silver"]Button[/button]');
						echo do_shortcode('[button style="tick" color="silver"]Button[/button]');
						echo do_shortcode('[button style="info" color="silver"]Button[/button]');
						echo do_shortcode('[button style="note"  color="silver"]Button[/button]');
						echo do_shortcode('[button style="download"  color="silver"]Button[/button]'); 
						?>
					</div>
					
					<h2>Shortcode banners</h2>
						
					<div>
						<?php
						echo do_shortcode('[box]This is an normal box[/box]');
						echo do_shortcode('[box type="info"]This is a info box[/box]');
						echo do_shortcode('[box type="tick" style="rounded" border="full"]is is a tick box[/box]');
						echo do_shortcode('[box type="note"]This is a note box[/box]');
						echo do_shortcode('[box type="download"]This is an download box[/box]');
						echo do_shortcode('[box type="alert"]This is an alert box[/box]');
						?>
						             	
                   	</div>
                   	
                   	<h2>Shortcode Columns</h2>
                   	
                   	<div class="threecol-one">Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</div>
                   	<div class="threecol-one">Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</div>
                   	<div class="threecol-one last">Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</div>
                   	
                   	<h2>Shortcode Tabber - Default</h2>
                   	
                   	<div id="tabs-44" class="shortcode-tabs default ui-tabs ui-widget ui-widget-content ui-corner-all">
                   		<h4 class="tab_header"><span>Default Tabber</span></h4>
                   		<ul class="tab_titles has_title ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
							<li class="nav-tab ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-44-tab-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-44-tab-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Tab 1</a></li>
							<li class="nav-tab ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-44-tab-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="#tabs-44-tab-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Tab 2</a></li>
						</ul>
 						<div class="tab tab-tab-1 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-44-tab-1" aria-labelledby="ui-id-1" role="tabpanel" style="display: block;" aria-expanded="true" aria-hidden="false">
							<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
							<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
							<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab-->
						<div class="tab tab-tab-2 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-44-tab-2" aria-labelledby="ui-id-2" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
							<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
							<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab--> 
						<div class="fix"></div><!--/.fix-->
					</div>
					
					<h2>Shortcode Tabber - Boxed</h2>
					
					<div id="tabs-21" class="shortcode-tabs boxed ui-tabs ui-widget ui-widget-content ui-corner-all">
						<h4 class="tab_header"><span>Boxed Tabber</span></h4>
						<ul class="tab_titles has_title ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
							<li class="nav-tab ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="tabs-21-tab-1" aria-labelledby="ui-id-3" aria-selected="true"><a href="#tabs-21-tab-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Tab 1</a></li>
							<li class="nav-tab ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="-1" aria-controls="tabs-21-tab-2" aria-labelledby="ui-id-4" aria-selected="false"><a href="#tabs-21-tab-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">Tab 2</a></li>
						</ul>
 						<div class="tab tab-tab-1 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-21-tab-1" aria-labelledby="ui-id-3" role="tabpanel" style="display: none;" aria-expanded="true" aria-hidden="false">
							<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
							<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
								<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab-->
						<div class="tab tab-tab-2 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-21-tab-2" aria-labelledby="ui-id-4" role="tabpanel" style="display: block;" aria-expanded="false" aria-hidden="true">
							<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
							<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab--> 
						<div class="fix"></div><!--/.fix-->
					</div>
					
					<h2>Shortcode Tabber - Vertical</h2>
					
					<div id="tabs-44" class="shortcode-tabs vertical ui-tabs ui-widget ui-widget-content ui-corner-all">
						<h4 class="tab_header"><span>Vertical Tabber</span></h4>
						<ul class="tab_titles has_title ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
							<li class="nav-tab ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-44-tab-1" aria-labelledby="ui-id-5" aria-selected="true"><a href="#tabs-44-tab-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">Tab 1</a></li>
							<li class="nav-tab ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-44-tab-2" aria-labelledby="ui-id-6" aria-selected="false"><a href="#tabs-44-tab-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6">Tab 2</a></li>
						</ul>
						<div class="tab tab-tab-1 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-44-tab-1" aria-labelledby="ui-id-5" role="tabpanel" style="display: block;" aria-expanded="true" aria-hidden="false">
							<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
							<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
							<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab-->
						<div class="tab tab-tab-2 ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-44-tab-2" aria-labelledby="ui-id-6" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
							<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
						</div><!--/.tab--> 
						<div class="fix"></div><!--/.fix-->
					</div>
                   	
                   	
                   	<h2>Shortcode Dividers</h2>
                   	
                   	<p>Nunc sollicitudin, nisl faucibus vestibulum cursus, mi nibh gravida erat, ultrices luctus nunc quam ac neque. Cras convallis volutpat tellus, at laoreet erat facilisis sed. Phasellus sed fringilla magna. Cras rhoncus feugiat orci ac interdum. Aliquam erat volutpat.</p>
<div class="woo-sc-divider"></div>
<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>
<div class="woo-sc-hr"></div>
<p>Proin in ipsum non libero feugiat gravida. Donec quam nibh, rutrum a bibendum sit amet, ultrices id neque. Aliquam nibh urna, viverra et malesuada quis, condimentum sed eros. Vestibulum varius porttitor lacinia. Nulla vitae lacinia elit. Vestibulum lobortis tortor non tortor dapibus tempor. Fusce in arcu neque. Nam quis enim tortor. Mauris pretium ultrices lectus, eget vulputate elit sagittis nec.</p>
<div class="woo-sc-divider flat"></div>
<p>Nulla elit nulla, egestas nec luctus ac, rutrum nec ligula. Integer bibendum, nunc et sagittis fringilla, neque quam tincidunt urna, quis hendrerit urna nulla id nisi. Vestibulum volutpat fermentum pellentesque. Ut eget quam risus. Praesent pellentesque rutrum rhoncus. Morbi semper sollicitudin imperdiet. Cras vehicula, nibh sed tincidunt hendrerit, turpis quam pharetra urna, id pretium dui neque vitae justo.</p>

				<h2>WC Notifications</h2>			
				
					<div class="woocommerce_message"><a href="#" class="button">button</a> Vel ut quas utroque placerat, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</div>
					<div class="woocommerce_info">Vel ut quas utroque <a href="#">placerat</a>, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</div>
					<div class="woocommerce_error">Vel ut quas utroque placerat, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</div>
					
					<p class="woocommerce_message"><a href="#" class="button">button</a> Vel ut quas utroque placerat, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</p>
					<p class="woocommerce_info">Vel ut quas utroque <a href="#">placerat</a>, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</p>
					<p class="woocommerce_error">Vel ut quas utroque placerat, kasd utinam epicuri at est, hendrerit argumentum dissentias ei nec.</p>
					
					<ul class="woocommerce_message">
					   <li>Something</li>
					   <li>Something</li>
					   <li>Something</li>
					</ul>
					
					<ul class="woocommerce_info">
					   <li>Something</li>
					   <li>Something</li>
					   <li>Something</li>
					</ul>
					
					<ul class="woocommerce_error">
					   <li>Something</li>
					   <li>Something</li>
					   <li>Something</li>
					</ul>
                	
               	</section><!-- /.entry -->

				<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>
                
            </article><!-- /.post -->
            
            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'page', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
            </article><!-- /.post -->
        <?php } // End IF Statement ?>  
        
		</section><!-- /#main -->
		
		<?php woo_main_after(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>