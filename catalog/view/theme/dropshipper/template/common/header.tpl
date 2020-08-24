<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>"><head>
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />
	<?php if ($description) { ?>
		<meta name="description" content="<?php echo $description; ?>" />
		<?php } ?>
	<?php if ($keywords) { ?>
		<meta name="keywords" content="<?php echo $keywords; ?>" />
		<?php } ?>
	<?php if ($icon) { ?>
		<link href="<?php echo $icon; ?>" rel="icon" />
		<?php } ?>
	<?php foreach ($links as $link) { ?>
		<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
	<?php
		$page = '';
		if(isset($this->request->get['route'])){
			$page = $this->request->get['route']; 
		}
	?>
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/dropshipper/stylesheet/styles.css" />
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/dropshipper/assets/font-awesome/css/font-awesome.css" />
	<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
	<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
	<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
	<?php foreach ($scripts as $script) { ?>
		<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
	<script type="text/javascript" src="catalog/view/theme/dropshipper/js/cycle.js"></script>
	<script type="text/javascript" src="catalog/view/theme/dropshipper/js/custom.js"></script>
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v2' rel='stylesheet' type='text/css'>

	<?php echo $google_analytics; ?>
</head>
<body <?php 			
		if($page == "common/home" || $page == ''){
			echo 'class="home"';
		}elseif($page == "product/category"){
			$titleName = explode(' ',$title);
			if(isset($titleName[1]))
			$page = $titleName[1];	
			echo 'class="' . strtolower($page) . " category" . '"';		
		}elseif($page == "product/product"){
			$titleName = explode(' ',$title);
			$page = $titleName[0];	
			echo 'class="' . strtolower($page) . " product_page" . '"';		
		}elseif($page == 'checkout/cart'){
			echo 'class="shopping_cart"';
		}elseif($page == 'product/search'){
			echo 'class="' . "search" . '"';
		}elseif($page == 'product/special'){
			echo 'class="' . "special_offers" . '"';
		}elseif($page == 'information/information'){
			echo 'class="' . "information" . '"';
		}elseif($page !== "common/home"){
			$titleName = explode(' ',$title);
			$page = $titleName[0];	
			if(isset($titleName[1])){
				$page = $titleName[0] . "_" . $titleName[1];
			}
			echo 'class="' . strtolower($page) . '"';				
		}
	?>>
<div id="container">
<div class="top">
	<?php echo $cart; ?>    
	<div class="curLang">
		<?php echo $language; ?>
		<?php echo $currency; ?>
	</div>

	<div class="clear"></div>
</div>
<div id="header">
	<?php //Logo ?>
	<?php 
		$page = '';
		if(isset($this->request->get['route'])){
			$page = $this->request->get['route'];
		}
		if($page == "common/home" || $page==''):
		?>
		<?php if ($logo): ?>
			<h1 id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
			<?php else: ?>
			<h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
			<?php endif; ?>
		<?php else: ?>
		<?php if($logo): ?>
			<a id="logo" href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /><span><?php echo $name; ?></span></a>
			<?php else: ?>
			<a href="<?php echo $home; ?>"><?php echo $name; ?></a>
			<?php endif; ?>
		<?php endif; //End Logo ?>

	<?php //Default Opencart Links ?>
	<?php if (!$logged): ?>
		<p class="welcome"><?php echo $text_welcome; ?></p>
		<?php else: ?>
		<p class="welcome"><?php echo $text_logged; ?></p> 
		<?php endif; ?>

	<ul class="informations">      
		<li <?php if($page == "common/home" || $page == ''){echo 'class="active"';} ?>><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
		<?php $informations = $this->model_catalog_information->getInformations(); //Get Information Module
			foreach($informations as $information): 
			?>
			<li <?php if($title == $information["title"]){echo "class=\"active\"";}?>><a href="<?php echo $this->url->link('information/information', 'information_id=' . $information["information_id"]); ?>"><?php echo $information["title"]; ?></a></li>
			<?php endforeach; //End Information Module ?>
	</ul>     

	<div class="clear"></div> 
</div> <?php // END HEADER DIV ?>

<div class="searchBox">
	<input id="search" type="text" name="filter_test" value="<?php echo $this->language->get('search_input') ?>" />
	<span class="within">within</span>
	<div class="selectCat">
		<select name="filter_category_id">
			<?php $results = $this->model_catalog_category->getCategories(0); ?>
			<option value="0" selected="selected"><?php echo $this->language->get('search_all') ?></option>
			<?php foreach($results as $result): ?>
				<option value="<?php echo $result["category_id"]; ?>"><?php echo $result['name']; ?></option>
				<?php endforeach; ?>
		</select>
	</div>
	<div class="buttons">
		<a id="button" class="button"><?php echo $this->language->get('search_search') ?></a>
	</div>
	<div class="clear"></div>
</div><?php // END SEARCH DIV ?>



<div class="access">
	<ul class="categories">
		<li><a class="allCat" href="javascript:void(0);"><?php echo $this->language->get('search_all') ?></a>
			<?php if ($categories) { //Get Categories ?>
				<ul class="first">
					<?php foreach ($categories as $category) { ?>
						<li class="level0"><a href="<?php echo $category['href']; ?>" class="level-top"><?php echo $category['name']; ?></a>
							<?php if ($category['children']) { ?>
								<?php for ($i = 0; $i < count($category['children']);) { ?>
									<ul>
										<?php $j = $i + ceil(count($category['children']) / $category['column']);?>
										<?php for (; $i < $j; $i++) { ?>
											<?php if (isset($category['children'][$i])) { ?>
												<li <?php if($i+1==$j){echo 'class="last"';} ?>><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
												<?php } ?>
											<?php } ?>
									</ul>
									<?php } ?>
								<?php } ?>
						</li>
						<?php } ?>
				</ul>
				<?php } //End Categories ?>
		</li>
	</ul>
	<?php //Default Opencart Links ?>
	<ul class="links">
		<li><a href="http://buradasatiliyor.com/index.php?route=product/manufacturer"><?php echo $text_manufacturer; ?></a></li>
        <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
		<li><a href="<?php echo $wishlist; ?>" id="wishlist_total"><?php echo $text_wishlist; ?></a></li>         
		<li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
		<li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
	</ul> 
	<div class="clear"></div>
</div>


<script type="text/javascript"><!--
	$('#container input[name=\'filter_test\']').keydown(function(e) {
		if (e.keyCode == 13) {
			$('#button').trigger('click');
		}
	});

	$('#button').bind('click', function() {
		url = 'index.php?route=product/search';

		var filter_name = $('#container input[name=\'filter_test\']').attr('value');

		if (filter_name) {
			url += '&search=' + encodeURIComponent(filter_name);
		}

		var filter_category_id = $('#container select[name=\'filter_category_id\']').attr('value');

		if (filter_category_id > 0) {
			url += '&category_id=' + encodeURIComponent(filter_category_id);
		}	
		location = url;
	});


//--></script> 




  