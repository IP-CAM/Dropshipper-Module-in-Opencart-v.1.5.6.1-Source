<?php if ( (empty($isset_subcategories) AND empty($values_selected) AND empty($values_no_selected) AND empty($price_range_script)) ) { ?>
<?php }else{ ?>

<div id="menuscm">
  <?php $i=1; ?>
  <div class="box">
    <div id="filter_box" class="p_rel">
      <?php if ($values_selected) { ?>
      <?php $i==1 ? $liclass="first upper" : $liclass="upper"; ?>
      <dl class="filters">
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em>Your selections</span></dt>
        <dd class="page_preload">
          <ul>
            <?php foreach ($values_selected as $value_selected) {      ?>
            <?php if($value_selected['Tipo']=="OPTION" && !empty($value_selected['image'])){ //is a option and have image. ?>
            <li><img class="picker" align="absmiddle" src="<?php echo $value_selected['image'];?>" width="20" height="20" alt="<?php echo utf8_strtoupper($value_selected['name']); ?>"/> <a class="link_filter_del smenu {dnd:'<?php echo $value_selected['href'];?>', ajaxurl:'<?php echo $value_selected['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?>> <img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a> <span><?php echo $value_selected['name'];?> </span></li>
            <?php }elseif($value_selected['Tipo']=="PRICERANGE"){ ?>
            <li class="active"><em>&nbsp;</em><a class="link_filter_del smenu {dnd:'<?php echo $value_selected['href'];?>', ajaxurl:'<?php echo $value_selected['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?>><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a><span><?php echo $SymbolLeft.$MinPrice.$SymbolRight; ?> - <?php echo $SymbolLeft.$MaxPrice.$SymbolRight; ?></span></li>
            <?php }else{ ?>
            <li class="active"><em>&nbsp;</em> <a class="link_filter_del smenu {dnd:'<?php echo $value_selected['href'];?>', ajaxurl:'<?php echo $value_selected['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?>><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a> <span><?php echo $value_selected['name'];?> </span></li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <?php } ?>
      <?php $i++;



   ?>
      <?php if ($isset_subcategories) { ?>
      <dl class="filters">
        <?php $i==1 ? $liclass="first upper" : $liclass="upper"; ?>
        <dt class="<?php echo $liclass; ?>"><span><em> </em><?php echo $category_text; ?></span></dt>
        <?php if ($values_selected_categories && !empty($values_selected_categories)) { 	?>
        <dd class="page_preload">
          <ul>
            <?php foreach ($values_selected_categories as $values_selected_category) { ?>
            <li class="active<?php echo $category_style; ?>" ><em>&nbsp;</em><a class="link_filter_del smenu {dnd:'<?php echo $values_selected_category['href'];?>',ajaxurl:'<?php echo $values_selected_category['ajax_url'];?>',gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?> ><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a><span><?php echo $values_selected_category['name'];?> </span></li>
            <?php } ?>
          </ul>
        </dd>
        <?php } ?>
        <?php if ($values_no_selected_categories) { ?>
        <?php if ($values_no_selected_categories[0]['view']=="list"){ ?>
        <?php if ($values_no_selected_categories[0]['total'] > $values_no_selected_categories[0]['list_number']) { ?>
        <dd class="page_preload">
          <ul>
            <?php 

            $array_original=array();

            $array_original=$values_no_selected_categories[0]['jurjur'] ;

		     //Order by quantity and name

            $sort_order  = array();

            $array_slice = array();

           //order by total                     



           foreach ($array_original as $key => $value) {

                $sort_order[$key] = $value['total'];}

                array_multisort($sort_order, SORT_DESC,$array_original);

                  //slice array for present only attributes more important



	            $array_slice= array_slice($array_original,0, $values_no_selected_categories[0]['list_number']);

             	$sort_order = array();



                  if ($values_no_selected_categories[0]['order']=="OH"){

                        foreach ($array_slice as $key => $value) {

						   $sort_order["str".$value['name']] = $value['name'];

                  }

                 natsort($sort_order);

                 $array_slice= array_merge($sort_order,$array_slice);   

                 }elseif ($values_no_selected_categories[0]['order']=="OC"){

       	      		foreach ($array_slice as $key => $value) {

					$sort_order[] = $value['name'];

				}

                    array_multisort($sort_order,SORT_ASC,$array_slice);  

                }

            foreach ($array_slice as $value){ ?>
            <?php

             ($count_products)? $count="&nbsp;<span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

           	 ($track_google) ? $gap=trim($values_no_selected_categories[0]['name'])."@@@@@@".trim($value['name']) : $gap="no";

             

            ?>
            <li class="inactive<?php echo $category_style; ?>"><em>&nbsp;</em><a class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>',gapush:'<?php echo $gap;?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>> <?php echo $value['name'];?><?php echo $count; ?></a></li>
            <?php } ?>
            <li class="more_filters1"><a href="javascript:void(0)" class="light small" rel="nofollow"><?php echo $see_more_text; ?></a></li>
          </ul>
        </dd>
        <dd style="display: none;" class="page_preload">
          <ul>
            <?php foreach ($values_no_selected_categories[0]['jurjur'] as $value){ ?>
            <?($count_products)? $count="&nbsp;<span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

           	 ($track_google) ? $gap=trim($values_no_selected_categories[0]['name'])."@@@@@@".trim($value['name']) : $gap="no"; 

           ?>
            <li class="inactive<?php echo $category_style; ?>"><em>&nbsp;</em><a class="smenu {dnd:'<?php echo $value['href'];?>',ajaxurl:'<?php echo $value['ajax_url'];?>',gapush:'<?php echo $gap;?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?><?php echo $count; ?></a></li>
            <?php } ?>
          </ul>
        </dd>
        <?php }else{ ?>
        <dd class="page_preload">
          <ul>
            <?php foreach ($values_no_selected_categories[0]['jurjur'] as $value){ 

     		 ($count_products)? $count="&nbsp;<span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

           	 ($track_google) ? $gap=trim($values_no_selected_categories[0]['name'])."@@@@@@".trim($value['name']) : $gap="no"; 

           ?>
            <li class="inactive<?php echo $category_style; ?>"><em>&nbsp;</em><a class="smenu {dnd:'<?php echo $value['href'];?>',ajaxurl:'<?php echo $value['ajax_url'];?>',gapush:'<?php echo $gap;?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?><?php echo $count; ?></a></li>
            <?php } ?>
          </ul>
        </dd>
        <?php } ?>
        <?php }else{ //$values_no_selected_categories['view']=="list" ?>
        <dd class="page_preload">
          <select class="smenu" style="width: 160px; margin-left:5px;">
            <option value="0" selected="selected">- Select <?php echo $values_no_selected_categories[0]['name']; ?> -</option>
            <?php foreach ($values_no_selected_categories[0]['jurjur'] as $value){ 

         ($count_products)? $count="&nbsp;(". $value['total'] .")" : $count="";

   		 ($track_google) ? $gap=trim($values_no_selected_categories[0]['name'])."@@@@@@".trim($value['name']) : $gap="no";  ?>
            <option class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}"><?php echo $value['name'];?><?php echo $count; ?></option>
            <?php } ?>
          </select>
        </dd>
        <?php } //$values_selected_categories['view']=="list"?>
        <?php } ?>
      </dl>
      <?php $i++; } ?>
      <?php if (!empty($values_no_selected)) { ?>
      <?php foreach ($values_no_selected as $value_no_select) { ?>
      <?php foreach ($value_no_select as $value_no_sel) { ?>
      <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
      <?php if ($value_no_sel['total']==1){//dont show select option. 



           $value_no_sel['jurjur']=array_values ( $value_no_sel['jurjur']); 



        ?>
      <dl id="filter_p<?php echo $i; ?>" class="filters">
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span></dt>
        <dd class="page_preload">
          <?php if($count_products) {?>
          <span class="seleccionado"><em>&nbsp;</em><?php echo $value_no_sel['jurjur'][0]['name'];?> (<?php echo $value_no_sel['jurjur'][0]['total'];?>)</span>
          <?php }else{ ?>
          <span class="seleccionado"><em>&nbsp;</em><?php echo $value_no_sel['jurjur'][0]['name'];?></span>
          <?php } ?>
        </dd>
      </dl>
      <?php   }else{   ?>
      <dl id="filter_p<?php echo $i; ?>" class="filters <?php echo $value_no_sel['initval']; ?>">
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span></dt>
        <?php  

    

	      if ($value_no_sel['view']=="list"){  ?>
        <?php

       

      if ($value_no_sel['total'] > $value_no_sel['list_number']) { ?>
        <dd class="page_preload">
          <ul id="results_container_<?php echo $i; ?>">
            <?php 

				$array_original=array();

                $array_original=$value_no_sel['jurjur'];

               //Order by quantity and name

                $sort_order  = array();

                $array_slice = array();

               //order by total                     

                    foreach ($value_no_sel['jurjur'] as $key => $value) {

                   		$sort_order[$key] = $value['total'];}

                   	 	array_multisort($sort_order, SORT_DESC,$value_no_sel['jurjur']);

                       //slice array for present only attributes more important

                   		$array_slice= array_slice($value_no_sel['jurjur'],0, $value_no_sel['list_number']);

                       	$sort_order = array();

                            if ($value_no_sel['order']=="OH"){

                                foreach ($array_slice as $key => $value) {

                                    $sort_order["str".$value['name']] = $value['name'];

                                }

								 natsort($sort_order);

								 $array_slice= array_merge($sort_order,$array_slice);   

					        }elseif ($value_no_sel['order']=="OC"){

			                    foreach ($array_slice as $key => $value) {

									$sort_order[] = $value['name'];

								}

								

                                array_multisort($sort_order,SORT_ASC,$array_slice);  

							  }

	     	foreach ($array_slice as $value){ ?>
            <?php 

            

            ($count_products)? $count=" <span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

            ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";

            

            ?>
            <li><em>&nbsp;</em><a class="smenu {dnd: '<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?></a><?php echo $count; ?></li>
            <?php } ?>
            <li class="more_filters1"><a href="javascript:void(0)" class="light small" rel="nofollow"><?php echo $see_more_text; ?></a></li>
          </ul>
        </dd>
        <dd style="display: none;" class="page_preload">
          <div id="search_container_<?php echo $i; ?>" >
            <?php if ($value_no_sel['searchinput']=="yes"){ ?>
            <input name="" type="text"  id="search<?php echo $i; ?>" onclick="this.value = '';" class="search-box-bg" onkeyup="refineResults(event,this,'search_container_<?php echo $i; ?>','#search_container_<?php echo $i; ?>')" value="<?php echo $search_in; ?>"  />
            <?php } ?>
            <ul>
              <?php foreach ($array_original as $value){ 

             ($count_products)? $count=" <span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

           	 ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";

           ?>
              <li><em>&nbsp;</em><a class="smenu {dnd: '<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?></a><?php echo $count; ?></li>
              <?php } ?>
            </ul>
          </div>
        </dd>
        <?php }else{ ?>
        <dd class="page_preload">
          <ul>
            <?php foreach ($value_no_sel['jurjur'] as $value){ 

            ($count_products)? $count=" <span class=\"product-count\">(". $value['total'] .")</span>" : $count="";

            ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";

            ?>
            <li><em>&nbsp;</em><a class="smenu {dnd: '<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?></a><?php echo $count; ?></li>
            <?php } ?>
          </ul>
        </dd>
        <?php } ?>
      </dl>
      <?php }elseif ($value_no_sel['view']=="sele") { ?>
      <dd class="page_preload">
        <select class="smenu" style="width: 160px; margin-left:5px;">
          <option value="0" selected="selected">- Select <?php echo $value_no_sel['name']; ?> -</option>
          <?php foreach ($value_no_sel['jurjur'] as $value){ 

         ($count_products)? $count="&nbsp;(". $value['total'] .")" : $count="";

   		 ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";  ?>
          <option class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}"><?php echo $value['name'];?><?php echo $count; ?></option>
          <?php } ?>
        </select>
      </dd>
      </dl>
      <?php }elseif ($value_no_sel['view']=="image") { ?>
      <dd class="page_preload">
        <div style="margin-left: 6px;" class="color_matrix">
          <ul>
            <?php foreach ($value_no_sel['jurjur'] as $value){ 

            ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no"; ?>
            <li><a class="smenu {dnd: '<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><img class="picker" src="<?php echo $value['image_thumb'];?>" width="20" height="20" alt="<?php echo utf8_strtoupper($value['name']); ?>"/></a></li>
            <?php } ?>
          </ul>
        </div>
      </dd>
      </dl>
      <?php }  ?>
      <?php } ?>
      <?php   $i++; } //if ($value_no_sel['total']=1  ?>
      <?php } ?>
      <?php } ?>
      <?php if ($price_range_is_not_selected) {?>
      <dl id="priceRange" class="filters <?php echo $intivalprice; ?>">
        <dt><span><em>&nbsp;</em><?php echo $pricerange_text; ?></span></dt>
        <dd>
          <?php if ($price_view=="slider"){ ?>
          <div class="left" id="leftSlider">
            <input type="text" id="amount_price_range" />
            <br />
            <div id="slider-range"></div>
          </div>
          <?php }elseif ($price_view=="list"){?>
          <?php if (count($array_prices_values) >1){ ?>
          <ul>
            <?php foreach($array_prices_values as $array_price_value) {  

            	($count_products)? $count=" <span class=\"product-count\">(". $array_price_value['total'] .")</span>" : $count="";

            

            	if ($array_price_value['total']>0){ //remove range that no have products.

            	?>
            <li> <em>&nbsp;</em><a class="smenu {dnd: '<?php echo $PriceUrl; ?>&amp;C=<?php echo $Currency; ?>&amp;PRICERANGE=<?php echo $array_price_value['intMin']; ?>MPRM<?php echo $array_price_value['intMax']; ?>', ajaxurl:'<?php echo $PriceAjaxUrl; ?>&amp;C=<?php echo $Currency; ?>&amp;PRICERANGE=<?php echo $array_price_value['intMin']; ?>MPRM<?php echo $array_price_value['intMax'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo sprintf($array_price_value['prices'],$SymbolLeft,$SymbolRight,$SymbolLeft,$SymbolRight); ?> </a><?php echo $count; ?></li>
            <?php } }?>
          </ul>
          <?php 

           }else{ 

          	 ($count_products)? $count=" <span class=\"product-count\">(". $array_prices_values[0]['total'] .")</span>" : $count="";

           ?>
          <span class="seleccionado"> <em>&nbsp;</em><?php echo sprintf($array_prices_values[0]['prices'],$SymbolLeft,$SymbolRight); ?> <?php echo $count; ?></span>
          <?php } ?>
          <?php }else if($price_view=="select"){ ?>
          <?php if (count($array_prices_values) >1){?>
          <select class="smenu" style="width: 160px; margin-left:5px;">
            <option value="0" selected="selected">- Select <?php echo $pricerange_text; ?> -</option>
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

          	 ($count_products)? $count=" <span class=\"product-count\">(". $array_prices_values[0]['total'] .")</span>" : $count="";

           ?>
          <span class="seleccionado"> <em>&nbsp;</em><?php echo sprintf($array_prices_values[0]['prices'],$SymbolLeft,$SymbolRight); ?> <?php echo $count; ?></span>
          <?php } ?>
          <?php } //price_view_select?>
        </dd>
      </dl>
      <?php } ?>
      <dl class="filters">
        <dt class="last"><span>&nbsp;</span></dt>
      </dl>
    </div>
    <br />
  </div>
  <?php if ($price_range_script) {?>
  <script type="text/javascript">

// <![CDATA[

function getSteps(values){

	diffvalues=  Math.abs(values[0] - values[1]);

	if (100000 >= diffvalues && diffvalues >10000){

		$("#slider-range").slider( "option", "step", <?php echo $this->data['steps'][0]; ?>);

	}else if (10000 >= diffvalues && diffvalues >1000){

		$("#slider-range").slider( "option", "step", <?php echo $this->data['steps'][1]; ?>);		

	}else if (1000 >= diffvalues && diffvalues >100){	

		$("#slider-range").slider( "option", "step", <?php echo $this->data['steps'][2]; ?>);			

	}else if (100 >= diffvalues && diffvalues >10){	

		$("#slider-range").slider( "option", "step", <?php echo $this->data['steps'][3]; ?>);

	}else{

		$("#slider-range").slider( "option", "step", <?php echo $this->data['steps'][4]; ?>);

	}

}



var timers = {};
function delayShowData(values) {
  clearTimeout(timers);
  timers = setTimeout(function() {
  <?php if ($is_ajax){ ?>
  
	  ajax_url='<?php echo htmlspecialchars_decode($PriceAjaxUrl); ?>&C=<?php echo $Currency; ?>&PRICERANGE='+values[0]+'MPRM'+values[1];
	  dnd='<?php echo htmlspecialchars_decode($PriceUrl); ?>&C=<?php echo $Currency; ?>&PRICERANGE='+values[0]+'MPRM'+values[1];
	  if (history.pushState) {
		History.pushState(null,ajax_url, dnd);
	  }else{
		Ajaxmenu('<?php echo htmlspecialchars_decode($PriceAjaxUrl); ?>&C=<?php echo $Currency; ?>&PRICERANGE='+values[0]+'MPRM'+values[1]);
	  }
  <?php }else{ ?>
	window.location.href ='<?php echo htmlspecialchars_decode($PriceUrl); ?>&C=<?php echo $Currency; ?>&PRICERANGE='+values[0]+'MPRM'+values[1];
 <?php } ?>
   }, 500);
}
$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: <?php echo $MinPrice; ?>,
			max: <?php echo $MaxPrice; ?>,
			step: <?php echo $step; ?>,
			values: [ <?php echo $MinPrice; ?>,<?php echo $MaxPrice; ?> ],
			slide: function( event, ui ) {
     		 getSteps(ui.values);
			clearTimeout(timers);
			$( "#amount_price_range" ).val( "<?php echo $SymbolLeft; ?>" + ui.values[ 0 ] + "<?php echo $SymbolRight; ?> - <?php echo $SymbolLeft; ?>" + ui.values[ 1 ] +"<?php echo $SymbolRight; ?>" );
			},
            stop: function(event, ui){
			//fix problem with prices with decimals
			var min_ini=<?php echo $MinPrice; ?>;
			var max_ini=<?php echo $MaxPrice; ?>;
			if (min_ini==ui.values[ 0 ] && ui.values[ 0 ] == ui.values[ 1 ]){
				ui.values[ 1 ] =ui.values[ 0 ] + 1;
			}else if(max_ini==ui.values[ 1 ] && ui.values[ 0 ] == ui.values[ 1 ]){
				ui.values[ 0 ] =ui.values[ 1 ] - 1;
			}
              delayShowData(ui.values);
			}
		});
		var valuemin=$( "#slider-range" ).slider( "values", 0 );
		var valuemax=$( "#slider-range" ).slider( "values", 1 );
     	if ((valuemin==valuemax) || (valuemax-valuemin <=1)){
		$( "#amount_price_range" ).val( "<?php echo $SymbolLeft; ?>" + valuemin +"<?php echo $SymbolRight; ?> - <?php echo $SymbolLeft; ?>" + valuemax +"<?php echo $SymbolRight; ?>" );
		$( "#slider-range" ).slider( "destroy" )
		}else{
		$( "#amount_price_range" ).val( "<?php echo $SymbolLeft; ?>" + valuemin +"<?php echo $SymbolRight; ?> - <?php echo $SymbolLeft; ?>" + valuemax +"<?php echo $SymbolRight; ?>" );
		}	});
// ]]>
</script>
  <?php } ?>
</div>
<script type="text/javascript">
	var ajaxManager = $.manageAjax.create('cacheQueue', { queue: true, cacheResponse: true });	
	function Ajaxmenu(filter){        
		ajaxManager.add({ 
			success:showResponseMenu,  // post-submit callback 
			url: 'index.php?route=module/supercategorymenuadvanced/MenuAjax',
			data: filter,
			type: "GET",
			cache: true
		});
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
	function showResponseMenu(responseText, statusText, xhr)  { 
		$('#menuscm').fadeOut('slow', function(){
		$('#menuscm').fadeOut('slow');
		$("#menuscm").replaceWith(responseText).fadeIn(<?php echo (int)$speedmenu; ?>);
		});
	}
	function showResponsedatos(responseText, statusText, xhr)  { 
		$('#content').fadeOut('slow', function(){
		$('#content').fadeOut('slow');
		$("#content").replaceWith(responseText).fadeIn(<?php echo (int)$speedresults; ?>);
		});
		$('body,html').animate({scrollTop: 150}, 800);
	}

	$(document).delegate("select.smenu", "change", function(){
		var jThis = $("option:selected", this), dnd, gapush, ajax_url;
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
<?php  } ?>
