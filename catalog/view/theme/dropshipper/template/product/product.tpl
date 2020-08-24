<?php echo $header; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    	<li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div id="notification"></div>
 <?php $productInfo = $this->model_catalog_product->getProduct($product_id);  ?>
  <div class="product-info">
    <?php if ($thumb || $images) { ?>
    <div class="pWrapper">
    <div class="left">
      <?php if ($thumb) { ?>
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
      <?php } ?>
      <?php if ($images) { ?>
      <ul class="image-additional">
			<?php foreach ($images as $image) { ?>
            <li><a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
      </ul>
      <?php } ?>
      <div class="clear"></div>
    </div>
    <?php } ?>
    
    <div class="right">      
          <div class="productDetails">
				<?php if ($manufacturer) { ?>
				<span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
				<?php } ?>
          <h1><?php echo $heading_title; ?></h1>
             <ul class="pInfo">
             <?php if($productInfo["sku"]): ?>
                <li><span><?php echo $this->language->get('text_sku'); ?></span> <?php echo $productInfo["sku"]; ?></li>
             <?php endif; ?> 
               <li><span><?php echo $this->language->get('text_revs'); ?></span>
                 	<?php if ($review_status) { ?>
                    		<img src="catalog/view/theme/dropshipper/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />
							<a class="reviews" href="javscript:void(0);" ><?php echo $reviews; ?></a>
                	 <?php } ?>
                </li>
                <li><span class="stock"><?php echo $text_stock; ?></span> <?php echo $stock; ?><div class="clear"></div></li>
                <li><span><?php echo $text_price; ?></span> 
                	 <?php if ($price) { ?>
                          <p class="price">
							  <?php if (!$special) { ?>
                                    <?php echo $price; ?>
                              <?php } else { ?>
                                    <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
                              <?php } ?>
                             <?php if ($tax) { ?>
                                <span class="price-tax" style="color:#E7840F;"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
                             <?php } ?>
                             <?php if ($points) { ?>
                                    <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span>
                             <?php } ?>
                         </p>
              <?php } ?>
              <div class="clear"></div>
                </li>
             </ul>
             <div class="clear"></div>
		<?php if ($discounts) { //Discounts ?>
           <div class="discount">
           		<p class="heading"><span><?php echo $this->language->get('text_bulk'); ?></span></p>
                <ul>
                      <?php foreach ($discounts as $discount): ?>
                            <li><?php echo $this->language->get('text_buy') . sprintf($text_discount, "<span>".$discount['quantity']."</span>", $this->language->get('text_for'). "<span class=\"dPrice\">" . $discount['price'] . "</span>") . $this->language->get('text_each'); ?></li>
                      <?php endforeach; ?>
                </ul>
            </div>
        <?php } ?>
              
                
              <?php if($options): ?>
              	<div class="hasOptions">
              	    <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
        
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
        
          <b><?php echo $option['name']; ?>:  <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
         
          <b><?php echo $option['name']; ?>: <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
            <table class="option-image">
              <?php foreach ($option['option_value'] as $option_value) { ?>
              <tr>
                <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label></td>
              </tr>
              <?php } ?>
            </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php echo $option['name']; ?>:<?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php echo $option['name']; ?>:<?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php echo $option['name']; ?>:<?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <a id="button-option-<?php echo $option['product_option_id']; ?>" class="button"><span><?php echo $button_upload; ?></span></a>
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
         
          <b><?php echo $option['name']; ?>: <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php echo $option['name']; ?>:<?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php echo $option['name']; ?>:<?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?></b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
              	<div class="addTo">
                <div class="qty">
                	<div class="qtyInput">
					   <label><?php echo $text_qty; ?></label>
                       <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                       <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                   </div>
                   <div class="cart">
                        <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
                   </div> 
                </div> 
                
                <?php if ($minimum > 1) { ?>
                	 <div class="minimum"><?php echo $text_minimum; ?></div>
                <?php } ?>
                <div class="clear"></div>
              </div>
              </div>
			   <?php else: ?>
              		<div class="addTo">
                <div class="qty">
                	<div class="qtyInput">
					   <label><?php echo $text_qty; ?></label>
                       <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                       <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                   </div>
                   <div class="cart">
                        <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
                   </div> 
                </div>
                   	
                <?php if ($minimum > 1) { ?>
                	 <div class="minimum"><?php echo $text_minimum; ?></div>
                <?php } ?>
                <div class="clear"></div>
             
              </div>
               <?php endif; ?>

              <ul class="share"><!-- AddThis Button BEGIN -->
              		 <li>&raquo; <a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a></li>
                   	 <li>&raquo; <a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></li>
                  <li><div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div></li>
                  <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
              </ul>
                
          </div> 
          </div>
          <div class="clear"></div>
          </div>
            
          
          <ul class="productTabs">
                <li class="productDetails active"><a href="javascript:void(0);"><?php echo $tab_description; ?></a></li>
                <?php if ($attribute_groups) { ?>
                    <li class="attribute"><a href="javascript:void(0);"><?php echo $tab_attribute; ?></a></li>
                <?php } ?>
                <?php if ($products) { ?>
                    <li class="related"><a href="javascript:void(0);"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a></li>
                <?php } ?>
                <?php if ($review_status) { ?>
                    <li class="reviews" name="rev"><a href="javascript:void(0);"><?php echo $tab_review; ?></a></li>
                <?php } ?>
 		</ul>
        <div class="clear"></div>
          <div class="productWrapper">
                  <div class="productDetails tabWrapper"><?php echo $description; ?></div>
                   <?php if ($products) { ?>
  <div class="related tabWrapper">
  <p class="heading"><strong><?php echo $tab_related; ?></strong></p>
    <ul class="box-related">
      <?php foreach ($products as $product) { ?>
      <li>
			<?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
            <?php } ?>
            <h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
            <?php if ($product['price']) { ?>
            <p class="price">
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
              <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
              <?php } ?>
            </p>
            <?php } ?>
            <div class="cart">
            	<input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
            </div>
            <div class="clear"></div>
        </li>
      <?php } ?>
    </ul>
  <div class="clear"></div>
  </div>
<?php } ?>
             <?php if ($attribute_groups) { ?>
<div class="attribute tabWrapper">
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
</div>
<?php } ?>
               
               
               <?php if ($review_status) { ?>
  <div class="reviews tabWrapper reviewTab">
    <div id="review"></div>
        <p id="review-title" class="heading"><strong><?php echo $text_write; ?></strong></p>
        <div class="name">
			<label><?php echo $entry_name; ?></label>
        	<input type="text" name="name" value="" />
        </div>
        <div class="reviewArea">
        	<label><?php echo $entry_review; ?></label>
        	<textarea name="text" cols="40" rows="8"></textarea>
        </div>
        <p class="note"><?php echo $text_note; ?></p>
       	
        <div class="rate">
        <label><?php echo $entry_rating; ?></label>
	   	<?php echo $entry_bad; ?>
            <input type="radio" name="rating" value="1" />        
            <input type="radio" name="rating" value="2" />      
            <input type="radio" name="rating" value="3" />       
            <input type="radio" name="rating" value="4" />       
            <input type="radio" name="rating" value="5" />
        <?php echo $entry_good; ?>
        </div>
        <div class="captcha">
        	<label><?php echo $entry_captcha; ?></label>
        	<input type="text" name="captcha" value="" />   
            <img src="index.php?route=product/product/captcha" alt="" id="captcha" />
            <div class="clear"></div>
        </div>   
    <div class="buttons">
      <a id="button-review" class="button"><span><?php echo $button_continue; ?></span></a>
    </div>
    </div>
<?php } ?>

		   </div>

        	
	<div class="clear"></div>
</div>




  <?php echo $column_right; ?>
  <div class="clear"></div>
    </div>
  		
  <?php echo $footer; ?>
  </div>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.5
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
	},
	onComplete: function(file, json) {
		$('.error').remove();
		
		if (json.success) {
			alert(json.success);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json.file);
		}
		
		if (json.error) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json.error + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');
		
	$('#review').load(this.href);
	
	$('#review').slideDown('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review-title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
