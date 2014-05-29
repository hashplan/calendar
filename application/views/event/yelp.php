<div class="row">
	<div class="col-md-8">
		<h4><a href="<?php echo $business['url'] ?>"><?php echo html_escape($business['name']) ?></a></h4>
	</div>
	<div class="col-md-4">
		<img src="http://s3-media3.ak.yelpcdn.com/assets/2/www/img/65526d1a519b/developers/Powered_By_Yelp_Red.png" alt="Powered by Yelp" class="powered-by-yelp pull-right"/>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="rating"><img src="<?php echo $business['rating_img_url_large'] ?>"/></div>
		<div class="reviews-count"><?php echo html_escape($business['review_count']) ?> reviews</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 categories">
		<ul>
			<?php if (!empty($business['categories'])) {
				foreach ($business['categories'] as $category) { ?>
					<li><a href="/<?php echo html_escape($category[1]) ?>"><?php echo html_escape($category[0]) ?></a></li>
				<?php }
			} ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12 image">
		<?php if (!empty($business['image_url'])) { ?>
			<img src="<?php echo $business['image_url'] ?>"/>
		<?php } else { ?>
			<img src="<?php echo base_url('assets/img/icons/no-image-100.png') ?>"/>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12 snippet">
		<?php if (!empty($business['snippet_image_url'])) { ?>
			<img src="<?php echo $business['snippet_image_url'] ?>"/>
		<?php } else { ?>
			<img src="<?php echo base_url('assets/img/icons/no-image-100.png') ?>"/>
		<?php }
		if (!empty($business['snippet_text'])) { ?>
			<p><?php echo html_escape($business['snippet_text']) ?></p>
		<?php } ?>
	</div>
</div>