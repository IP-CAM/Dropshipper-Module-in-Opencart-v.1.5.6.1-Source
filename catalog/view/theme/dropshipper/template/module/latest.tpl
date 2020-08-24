<div class="latest">
  <p class="heading"><?php echo $heading_title; ?></p>
  <?php $oddEven = array('odd', 'even'); ?>
  <ul class="items">
      <?php $i=0; foreach ($products as $product) { $i++?>
      <li <?php if($i%3==0 && $i!=0){echo 'class="last"'; } ?>>
        <?php if ($product['thumb']): ?>
       		 <a class="image" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" width="120" height="120" /></a>
        <?php endif; ?>
        <h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
        <?php if ($product['price']): ?>
        <p class="price">
          <?php if (!$product['special']): ?>
          		<?php echo $product['price']; ?>
          <?php else: ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php endif; ?>
        </p>
        <?php endif; ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>        
      </li>
      <?php } ?>	
</ul>
<div class="clear"></div>
</div>
