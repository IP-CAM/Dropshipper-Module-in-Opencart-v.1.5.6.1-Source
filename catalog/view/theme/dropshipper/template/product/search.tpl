<?php echo $header; ?>
<div id="content">
<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    	<li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>  
  <h1><?php echo $heading_title; ?></h1>
  
  <div class="content criteria">
  <strong><?php echo $text_critea; ?></strong>
    <p><?php echo $entry_search; ?>
       <?php if ($search) { ?>
      <input id="search" type="text" name="search" value="<?php echo $search; ?>" />
      <?php } else { ?>
      <input id="search" type="text" name="search" value="<?php echo $search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?>
      <select name="category_id">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
       <?php if ($sub_category) { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_sub_category; ?></label>
    </p>
   <?php if ($description) { ?>
    <input type="checkbox" name="description" value="1" id="description" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="description" value="1" id="description" />
    <?php } ?>
    <label for="description"><?php echo $entry_description; ?></label>
      <div class="buttons">
    <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="button" />
  </div>
  </div>
<div class="cat_items search_list">	
  <p class="heading"><?php echo $text_search; ?></p>
  <?php if ($products) { ?>
  <div class="product-filter">
    <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
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
          </p>
          <?php } ?>
         <div class="description"><?php echo $product['description']; ?></div>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
          <div class="wishlist"> or <a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a> </div>
          <div class="compare">&raquo; <a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div> 
            <?php if ($product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/dropshipper/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
          <?php } ?>
         
    </li>         
<?php endforeach; ?>
</ul>
     
  <div class="clear"></div>
 <div class="pagination"><?php echo $pagination; ?></div>
	  <?php } ?>
       
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
$('#content input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	
	var filter_name = $('#content input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_category_id = $('#content select[name=\'filter_category_id\']').attr('value');
	
	if (filter_category_id > 0) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');
	
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&filter_description=true';
	}

	location = url;
});
</script>
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
