<div class="box">
    <p class="heading box-heading">Brands</p>
    <div class="clear"></div>
    <div id="carousel<?php echo $module; ?>">
          <ul class="jcarousel-skin-opencart">
				<?php foreach ($banners as $banner) { ?>
                	<li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></li>
                <?php } ?>
          </ul>
    </div>
</div>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?> ul').jcarousel({
	vertical: false,
	visible: <?php echo $limit; ?>,
	scroll: <?php echo $scroll; ?>,
	wrap: 'circular',
	buttonPrevHTML: '<a class="c-prev carouselBtn"></a>',
	buttonNextHTML: '<a class="c-next carouselBtn"></a>'
});
//--></script>