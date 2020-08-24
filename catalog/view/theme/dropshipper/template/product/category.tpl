<?php echo $header; ?>
<div id="content">
<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    	<li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        
    <?php } ?>
</ul>
<div id="notification"></div>
<?php echo $column_left; ?>
 <div class="cat_items">
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($thumb || $description): ?>
  <div class="category-info">
		<?php if ($thumb) { ?>
            <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
            <?php if ($description) { ?>
                 <?php echo $description; ?>
            <?php } ?>
        <?php } ?>    
  </div>
  <?php endif; ?>
  <?php if ($categories) { ?>
  <div class="category-list">
  <h2 class="refine"><?php echo $text_refine; ?></h2>
    <?php if (count($categories) <= 5) { ?>
    <ul>
      <?php foreach ($categories as $category) { ?>
      <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div class="product-filter">
    <div class="display"><?php echo $text_display; ?> <a onclick="display('grid');"><?php echo $text_grid; ?></a> <?php echo $text_list; ?></div>
    <div class="limit"><?php echo $text_limit; ?>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort"><?php echo $text_sort; ?>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="clear"></div>
  </div>
  
<ul class="product-list">
<?php $oddEven = array('odd', 'even'); ?>
<?php $i=0; foreach ($products as $product) : $i++ ?>
    <li <?php if($i%3==0 && $i!=0){echo 'class="last"'; } ?>>
    	
		  <?php if ($product['thumb']): ?>
                <div class="image"><a href="<?php echo $product['href']; ?>" class="image"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
          <?php endif; ?>
          <h2 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
          <?php if ($product['price']) { ?>
          <p class="price">
            <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
            <?php } else { ?>
            <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
            <?php } ?>
             <?php if ($product['tax']) { ?>
             	<br />
       			 <span class="price-tax" style="color:#E7840F;font-size:11px;"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        	<?php } ?>
          </p>
          <?php } ?>
         <div class="description"><?php echo $product['description']; ?></div>
        <div class="cart"> <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
          <div class="wishlist"> or <a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a> </div>
          <div class="compare">&raquo; <a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div> 
            <?php if ($product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/dropshipper/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
          <?php } ?>
         
    </li>         
<?php endforeach; ?>
</ul>
     
  <div class="clear"></div>

	  <?php } ?>
         <div class="pagination"><?php echo $pagination; ?></div>
      <?php if (!$categories && !$products) { ?>
          <div class="content"><?php echo $text_empty; ?></div>
          <div class="buttons">
                <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
          </div>
      <?php } ?>
      
  
      </div>
     <div class="clear"></div>

</div>
  <div class="clear"></div>
  <?php echo $footer; ?>
</div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > li').each(function(index, element) {
			html = '<div class="list_items">';
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			html += '<div class="right">';
			html += '  <h2 class="name">' + $(element).find('.name').html() + '</h2>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			var price = $(element).find('.price').html();
			if (price != null) {
				html += '<p class="price">' + price  + '</p>';
			}
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
			
			html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
			html += '</div>';
			html += '<div class="clear"></div>';
			html += '</div>';
					

			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');
		
		$.cookie('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > li').each(function(index, element) {
			html = '<div class="item">';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<h2 class="name">' + $(element).find('.name').html() + '</h2>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<p class="price">' + price  + '</p>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
						
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');
		
		$.cookie('display', 'grid');
	}
}

view = $.cookie('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 
