<div class="specials">
<script type="text/javascript" src="catalog/view/theme/dropshipper/js/countdown.js"></script>
  <p class="heading"><?php echo $heading_title; ?></p>
    <ul class="specialItems">    
      <?php $i=-1; foreach ($products as $product) { $i++ ?>
      <li <?php if($i%2==0 && $i!=0){echo 'class="last"'; } ?>>
        <?php if ($product['thumb']) { ?>
        	<a class="image" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
        <?php } ?>
        <h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        
        </h3>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          		<?php echo $product['price']; ?>
          <?php } else { ?>
          	<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>         
                  </p>

        <div class="specialPercent">
			<?php 
				  //Get Currency Symbol				  
				  $symLeft = $this->currency->getSymbolLeft();
				  $symRight = $this->currency->getSymbolRight();
				  
				  if($symLeft != NULL){
					$currCode = $this->currency->getSymbolLeft();
				  }else{
					$currCode = $this->currency->getSymbolRight();
				  }
			
				  //Get the percentage discount
                  $normal =  strip_tags(str_replace($currCode,'', $product['price']));
				  	$normalP = strip_tags(str_replace(',','', $normal));
                  $special = strip_tags(str_replace($currCode,'', $product['special']));
				  	$specialP = strip_tags(str_replace(',','', $special));
                  $percent = ($normalP-$specialP)/$normalP*100;
                  echo round($percent) . $this->language->get('text_off');		 
            ?>               
          </div>
		<?php //Get Special Date Function from product.php
			$date = $this->model_catalog_product->getSpecialStartDate(); 
			$endDate = str_replace('-',' ',$date[$i]["date_end"]);
			$ymd = explode(" ", $endDate);
        ?>
        <div class="countdown<?php echo $i ?> timer"></div>
        <script type="text/javascript">
            $(function () {
                $('.countdown<?php echo $i ?>').countdown({ until: new Date(<?php echo $ymd[0] ?>,<?php echo $ymd[1] ?>-1 , <?php echo $ymd[2] ?>),compact: true,description: ' <?php echo $this->language->get('text_left'); ?>'});
            });
        </script>
        <?php } ?>

		<?php } ?>
        
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </li>
      <?php } ?>
    </ul>
    <div class="clear"></div>
</div>
