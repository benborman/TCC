<?php 
/* 
Template Name: Podcast RSS
*/
$numposts = 1000; // number of posts in feed
$posts = query_posts('post_type=podcast&showposts='.$numposts.''); 

header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	<?php do_action('rss2_ns'); ?>
>
<channel>
	<title>The Church Collective Worship Leader Podcast</title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>

	<language>en</language>
	<itunes:summary>A podcast about worship leading with updates about our worship training around the world.  We talk through the weekly practice of creating a worship service and a vibrant worship ministry.</itunes:summary>
	<itunes:author>The Church Collective</itunes:author>
	<itunes:image href="http://thechurchcollective.com/wp-content/uploads/2015/05/podcast-logo.jpg" />
	<itunes:category text="Religion &amp; Spirituality" />
	<itunes:keywords>worship, worship leader, worship leading, guitar, guitar training, worship training, church, the church collective, worship service, missions, tech training, bible, jesus, christian, community, worship planning, praise and worship, praise, musician, church musician, church music, hillsong, hillsong united, elevation worship, worth dying for, mission field, worship gear, guitar pedals</itunes:keywords>
	<itunes:explicit>no</itunes:explicit>
	<itunes:owner>
		<itunes:name>The Church Collective</itunes:name>
		<itunes:email>ryan@thechurchcollective.com</itunes:email>
	</itunes:owner>

	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php while( have_posts()) : the_post(); ?>

	<item>
		<title><?php the_title_rss(); ?></title>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<dc:creator>The Church Collective</dc:creator>
<?php the_category_rss(); ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
<?php if (get_option('rss_use_excerpt')) : ?>

		<description><?php echo get_post_meta($post->ID, "description", true); ?></description>
		<itunes:summary><?php echo get_post_meta($post->ID, "description", true); ?></itunes:summary>
<?php else : ?>

		<description><?php echo get_post_meta($post->ID, "description", true); ?></description>
		<itunes:summary><?php echo get_post_meta($post->ID, "description", true); ?></itunes:summary>
	<?php if ( strlen( $post->post_content ) > 0 ) : ?>

		<enclosure url="<?php echo get_post_meta($post->ID, "audio", true); ?>" type="audio/x-m4a" />
	<?php else : ?>

		<enclosure url="<?php echo get_post_meta($post->ID, "audio", true); ?>" type="audio/x-m4a" />

	<?php endif; ?>
<?php endif; ?>

		<wfw:commentRss><?php echo get_post_comments_feed_link(); ?></wfw:commentRss>
		<slash:comments><?php echo get_comments_number(); ?></slash:comments>
<?php rss_enclosure(); ?>
<?php do_action('rss2_item'); ?>

	</item>
	<?php endwhile; ?>

</channel>
</rss>