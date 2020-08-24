<div class="featured">
    <p class="heading"><?php echo $heading_title; ?></p> 
    <ul class="btns">
        <li class="prev"><a id="prev" href="javascript:void(0);">Prev</a></li>
    	<li class="next"><a id="next" href="javascript:void(0);">Next</a></li>
    </ul>    
    <ul class="items">
        <?php foreach ($products as $product): ?>
            <li>
                <?php if ($product['thumb']): ?>
                    <div class="img">
                        <a href="<?php echo $product['href']; ?>" title="<?php echo $product["name"] ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                       
                    </div>
                <?php endif; ?>
                     <h2><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
                <?php if ($product['price']): ?>
                    <p class="price">
                      <?php if (!$product['special']): ?>
                          <?php echo $product['price']; ?>
                      <?php else: ?>
                          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                      <?php endif; ?>
                    </p>
                     <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
                <?php endif; ?>      
            </li>
        <?php endforeach; ?>
    </ul>    
</div>
<div class="clear"></div>
<script type="text/javascript">
	$('.items').cycle({ 
		fx:     'fade', 
		speed:  'fast', 
		timeout: 0, 
		next:   '#next', 
		prev:   '#prev' 
	});
</script>