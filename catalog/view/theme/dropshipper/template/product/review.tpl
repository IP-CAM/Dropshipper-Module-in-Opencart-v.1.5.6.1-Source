<?php if ($reviews) { ?>
<ul class="reviewsWrap">
<?php foreach ($reviews as $review) { ?>
    <li class="review">
		<p><?php echo $review['author']; ?> <img src="catalog/view/theme/dropshipper/image/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['reviews']; ?>" /><span><?php echo $review['date_added']; ?></span></p>    
      
      <div class="reviewContent"><?php echo $review['text']; ?></div>
    </li>
<?php } ?>
</ul>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>
