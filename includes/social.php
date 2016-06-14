<p class="alignleft share">Share it:</p> <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
<?php //$shortlink= wp_get_shortlink(); ?> 

<div class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out this post - <?php the_title(); ?>" data-via="churchcollectiv" data-url="<?php the_permalink(); ?>">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
<div class="clear"></div>

<p class="alignright comment"><a href="<?php the_permalink(); ?>/#comments"><?php comments_number( 'Leave a Comment', 'One Comment', '% Comments' ); ?></a></p>

