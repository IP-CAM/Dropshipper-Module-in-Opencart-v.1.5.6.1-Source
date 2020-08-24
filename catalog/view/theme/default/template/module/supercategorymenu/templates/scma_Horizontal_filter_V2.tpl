<?php 

 if ( (empty($isset_subcategories) AND empty($values_selected) AND empty($values_no_selected) AND empty($price_range_script)) ) { ?>
<?php }else{ ?>

<div id="menuscm">
  <div id="filter_on_category">
    <?php if ( (!empty($isset_subcategories) AND !empty($values_no_selected) AND $price_range_is_not_selected) ) { ?>
    <span><em>&nbsp;</em><?php echo $entry_select_filter; ?></span>
    <?php } ?>
    <div class="datos">
      <?php if (($isset_subcategories) && ($values_no_selected_categories)){ ?>
      <select class="smenu" style="width: 170px; margin-left:5px;margin-bottom:15px;">
        <option value="0" selected="selected">- <?php echo $txt_select_on_select; ?> <?php echo $values_no_selected_categories[0]['name']; ?> -</option>
        <?php foreach ($values_no_selected_categories[0]['jurjur'] as $value){ 

     ($count_products)? $count="&nbsp;(". $value['total'] .")" : $count="";

	 ($track_google) ? $gap=trim($values_no_selected_categories[0]['name'])."@@@@@@".trim($value['name']) : $gap="no";  ?>
        <option class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}"><?php echo $value['name'];?><?php echo $count; ?></option>
        <?php } ?>
      </select>
      <?php } ?>
      <?php if (!empty($values_no_selected)) { ?>
      <?php foreach ($values_no_selected as $value_no_select) { ?>
      <?php foreach ($value_no_select as $value_no_sel) { ?>
      <select class="smenu" style="width: 170px; margin-left:5px;margin-bottom:15px;">
        <option value="0" selected="selected">- <?php echo $txt_select_on_select; ?> <?php echo $value_no_sel['name']; ?> -</option>
        <?php foreach ($value_no_sel['jurjur'] as $value){ 

         ($count_products)? $count="&nbsp;(". $value['total'] .")" : $count="";

   		 ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";  ?>
        <option class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}"><?php echo $value['name'];?><?php echo $count; ?></option>
        <?php } ?>
      </select>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <?php if ($price_range_is_not_selected) {?>
      <?php if (count($array_prices_values) >1){?>
      <select class="smenu" style="width: 170px; margin-left:5px;margin-bottom:15px;">
        <option value="0" selected="selected">- <?php echo $txt_select_on_select; ?> <?php echo $pricerange_text; ?> -</option>
        <?php

             	 foreach($array_prices_values as $array_price_value) {  

            	($count_products)? $count="&nbsp;(". $array_price_value['total'] .")" : $count="";

            

            	if ($array_price_value['total']>0){ //remove range that no have products.

            	?>
        <option class="smenu {dnd:'<?php echo $PriceUrl; ?>&amp;C=<?php echo $Currency; ?>&amp;PRICERANGE=<?php echo $array_price_value['intMin']; ?>MPRM<?php echo $array_price_value['intMax']; ?>', ajaxurl:'<?php echo $PriceAjaxUrl; ?>&amp;C=<?php echo $Currency; ?>&amp;PRICERANGE=<?php echo $array_price_value['intMin']; ?>MPRM<?php echo $array_price_value['intMax'];?>', gapush:'no'}"><?php echo sprintf($array_price_value['prices'],$SymbolLeft,$SymbolRight,$SymbolLeft,$SymbolRight); ?><?php echo $count; ?></option>
        <?php } } ?>
      </select>
      <?php 

           }else{    

          

   }  } ?>
    </div>
    <div class="clearfixed2"></div>
    <span><em>&nbsp;</em><?php echo $entry_selected; ?></span>
    <div class="filter_box_hori">
      <dl id="onasearch" class="filters">
        <dd class="page_preload" style="margin-left: 2px;!important">
          <ul >
          
          	<?php if (isset($values_selected_categories)){ ?>
          
            <?php foreach ($values_selected_categories as $values_selected_category) { ?>
            <li class="active<?php echo $category_style; ?>"><em>&nbsp;</em><a class="link_filter_del smenu {dnd:'<?php echo $values_selected_category['href'];?>', ajaxurl:'<?php echo $values_selected_category['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?> ><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del2" /></a> <span><?php echo $values_selected_category['name'];?> </span></li>
            <?php } ?><?php } ?>
            <br />
            <?php foreach ($values_selected as $value_selected){ ?>
            <li class="active"><em>&nbsp;</em><a class="link_filter_del smenu {dnd:'<?php echo $value_selected['href'];?>', ajaxurl:'<?php echo $value_selected['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?>><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del2" /></a> <span class="txtdnd"><?php echo $value_selected['dnd']; ?>:</span> <?php echo $value_selected['name'];?></li>
            <?php } ?>
          </ul>
        </dd>
      </dl>
    </div>
  </div>
  <script type="text/javascript">

var ajaxManager = $.manageAjax.create('cacheQueue', { queue: true, cacheResponse: true });	
	function Ajaxmenu(filter){        
    	ajaxManager.add({ 
			success:showResponsedatos,  // post-submit callback 
			url: 'index.php?route=product/asearch/asearchAjax',
			data: filter,
			type: "GET",
			cache: true
		});
	};
	var ajaxManager2 = $.manageAjax.create('cacheQueue', { queue: true, cacheResponse: true });	
    function Ajaxmenup(filter){        
	ajaxManager2.add({ 
			success:showResponsedatos,  // post-submit callback 
			url: 'index.php?route=product/asearch/asearchAjax', 
			data: filter,
			type: "GET",
			cache: true
		});
	};

	function showResponsedatos(responseText, statusText, xhr)  { 
		$('#content').fadeOut('slow', function(){
		$('#content').fadeOut('slow');
		$("#content").replaceWith(responseText).fadeIn(<?php echo (int)$speedresults; ?>);
		});
		$('body,html').animate({scrollTop: 150}, 800);
	}

	$(document).delegate("select.smenu", "change", function(){
		var jThis = $("option:selected", this), dnd, gapush, ajax_url;
		dnd=jThis.metadata().dnd;gapush=jThis.metadata().gapush;ajax_url=jThis.metadata().ajaxurl;
		if (gapush!="no"){
		     var gas_val=gapush.split('@@@@@')	
			_gaq.push(['_trackEvent','SCM', gas_val[0],gas_val[1]])
		}
		<?php if ($is_ajax){ ?> 
		  if (history.pushState) {
			  History.pushState(null,ajax_url, dnd);
		  }else{
			Ajaxmenu(ajax_url);
		  }
		<?php }else{ ?>
			window.location.href = dnd;
		<?php } ?>
		return false;
		});
	  $(document).delegate("a.smenu", "click", function(){
		var jThis = $(this), dnd, gapush, ajax_url;
		dnd=jThis.metadata().dnd;
		gapush=jThis.metadata().gapush;
		ajax_url=jThis.metadata().ajaxurl;
		if (gapush!="no"){
			var gas_val=gapush.split('@@@@@')	
			_gaq.push(['_trackEvent','SCM', gas_val[0],gas_val[1]])
		}
		<?php if ($is_ajax){ ?> 
		  if (history.pushState) {
			  History.pushState(null,ajax_url, dnd);
		  }else{
			Ajaxmenu(ajax_url);
		  }
		<?php }else{ ?>
			window.location.href = dnd;
		<?php } ?>
		return false;
	 });
	<?php if ($see_more_trigger){ ?>
		$('a.all_filters').trigger('click');
	<?php } ?>
	
</script> 
</div>
<?php } ?>
