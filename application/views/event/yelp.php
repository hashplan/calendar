<div class="row">
	<div class="col-md-8">
		<h4><a href="<?=$business['url'] ?>"><?=html_escape($business['name']) ?></a></h4>
	</div>
	<div class="col-md-4">
		<img src="http://s3-media3.ak.yelpcdn.com/assets/2/www/img/65526d1a519b/developers/Powered_By_Yelp_Red.png" alt="Powered by Yelp" class="powered-by-yelp pull-right"/>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="rating"><img src="<?=$business['rating_img_url_large'] ?>"/></div>
		<div class="reviews-count"><?=html_escape($business['review_count']) ?> reviews</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 categories">
		<ul>
			<?if (!empty($business['categories'])):?>
				<?foreach ($business['categories'] as $category):?>
					<li><a href="/<?=html_escape($category[1]) ?>"><?=html_escape($category[0]) ?></a></li>
				<?endforeach?>
			<?endif?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12 image">
		<?if (!empty($business['image_url'])): ?>
			<img src="<?=$business['image_url'] ?>"/>
		<?else:?>
			<img src="<?=base_url('assets/img/icons/no-image-100.png') ?>"/>
		<?endif?>
	</div>
</div>
<div class="row">
	<div class="col-md-12 snippet">
		<?if (!empty($business['snippet_image_url'])):?>
			<img src="<?=$business['snippet_image_url'] ?>"/>
		<?else:?>
			<img src="<?=base_url('assets/img/icons/no-image-100.png') ?>"/>
		<?endif?>
		<?if (!empty($business['snippet_text'])):?>
			<p><?=html_escape($business['snippet_text']) ?></p>
		<?endif?>
	</div>
</div>