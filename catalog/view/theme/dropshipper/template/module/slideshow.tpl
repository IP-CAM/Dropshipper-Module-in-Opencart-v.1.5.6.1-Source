<div class="slideshow">
<ul class="slideTab"></ul>
<ul class="slides">
<?php foreach ($banners as $banner) { ?> 
	<?php if ($banner['link']) { ?>
    		<li class="slide"><a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" /></a>
            <p class="bannerTitle"><?php echo $banner['title']; ?><a class="more" href="<?php echo $banner['link']; ?>"><?php echo $this->language->get('text_more') ?></a></p>
            </li>
    <?php } else { ?>
    		<li id="slide"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></li>
    <?php } ?>
<?php } ?>
</ul>
</div>