 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
var map;


var MY_MAPTYPE_ID = 'custom_style';

function initialize() {

  var featureOpts = [
    {
      stylers: [
        { hue: '#2096a0' },
		{saturation: '0'},
		{lightness: '90'},
        { visibility: 'simplified' },
        { gamma: .4 },
        { weight: .5 }
      ]
    },
    {
      elementType: 'labels',
      stylers: [
        { visibility: 'off' }
      ]
    },
    {
      featureType: 'water',
      stylers: [
        { color: '#c4cecf' }
      ]
    }
  ];

  var mapOptions = {
 
    zoom: 2,
    scrollwheel: false,
    draggable: true,
    scaleControl: false,
    center: new google.maps.LatLng(0,0),
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID],
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
      position: google.maps.ControlPosition.BOTTOM_CENTER
    },
    mapTypeId: MY_MAPTYPE_ID
  };
  
map = new google.maps.Map(document.getElementById('map-campaigns'),
      mapOptions);

var styledMapOptions = {
    name: 'Campaigns'
    
  };
  
 var image ={
	 url: '<?php bloginfo(url); ?>/wp-content/themes/memorable/images/tcc-map-marker.png'
 } 
var markers = [

<?php if(have_posts()) : ?>
			<?php query_posts('post_type="campaign&posts_per_page=-1"'); 
				while(have_posts()) : the_post() ?>
					
						  ['<?php the_title(); ?>', <?php $coords = get_post_meta($post->ID, "coords", true); echo $coords;?>, 4],
				<?php endwhile; ?>
			<?php endif; ?>
	<?php wp_reset_query(); ?>
  ];  
  
  
  var infoWindowContent = [
  
  <?php if(have_posts()) : ?>
			<?php query_posts('post_type="campaign"&posts_per_page=-1'); 
				while(have_posts()) : the_post() ?>
        ['<div class="info_content">' +
        '<h3><?php the_title(); ?></h3>' +
        '<p><?php $blurb = get_post_meta($post->ID, "blurb", true); echo $blurb;?></p>' +
        '<p><a class="button" href="<?php the_permalink(); ?>/">More Info</a></p>' + '</div>'],
 				<?php endwhile; ?>
			<?php endif; ?>
			
	<?php wp_reset_query(); ?>
    ];
  

  
  // Display multiple markers on a map
 var infoWindow = new google.maps.InfoWindow(), marker, i;
 
	for (i = 0; i < markers.length; i++) {
	marker = new google.maps.Marker({
	position: new google.maps.LatLng(markers[i][1], markers[i][2]),
	map: map,
	title: markers[i][0],
	icon: image
		});
	

	
	
 
google.maps.event.addListener(marker, 'click', (function(marker, i) {
return function() {
infoWindow.setContent(infoWindowContent[i][0]);
infoWindow.open(map, marker);
}
})(marker, i));
}
  

var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}


google.maps.event.addDomListener(window, 'load', initialize);

    </script>