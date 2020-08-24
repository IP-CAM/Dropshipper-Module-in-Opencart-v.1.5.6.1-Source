<?php echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"> <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="vtabs" id="settings"> <a href="#tab-settings"><?php echo $tab_settings; ?></a> <a href="#tab-layouts"><?php echo $tab_layouts; ?></a> <a href="#tab-pricerange"><?php echo $tab_pricerange; ?></a> <a href="#tab-manufacturer"><?php echo $tab_manufacturer; ?></a> <a href="#tab-categories"><?php echo $tab_categories; ?></a> <a href="#tab-stock"><?php echo $tab_stock; ?></a> <a href="#tab-templates" id="templates"><?php echo $tab_templates; ?></a> <a href="#tab-styles"><?php echo $tab_styles; ?></a> <a href="#tab-admincache"><?php echo $tab_admincache; ?></a><a href="#tab-register" id="licensing"><?php echo $tab_register; ?></a> <a id="contact" href="#tab-contact"><?php echo $tab_contact; ?></a> </div>
        <div id="tab-settings" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_truncate; ?></td>
              <td width="100"><div id="num_registros"><?php echo $number_registros; ?> <?php echo $text_records; ?></div></td>
              <td width="120"><div class="buttons"> <a id="truncate" class="button"><span><?php echo $button_truncate; ?></span></a></div></td>
              <td colspan="6"><span class="help"><?php echo $entry_truncate_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_mode; ?></td>
              <td width="100"><?php if ($settings_mode=="Production") { ?>
                <input type="radio" name="supercategorymenuadvanced_mode" value="Production" checked="checked" />
                <?php echo $text_production; ?>
                <input type="radio" name="supercategorymenuadvanced_mode" value="Developing" />
                <?php echo $text_developing; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_mode" value="Production" />
                <?php echo $text_production; ?>
                <input type="radio" name="supercategorymenuadvanced_mode" value="Developing" checked="checked" />
                <?php echo $text_developing; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_mode_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_seo_keyword; ?></td>
              <td width="100"><input type="text" name="supercategorymenuadvanced_seo_keyword" value="<?php echo $settings_seo_keyword; ?>" />
              	</td>
              <td colspan="7"><span class="help"><?php echo $entry_seo_keyword_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_ajax; ?></td>
              <td width="100"><?php if ($settings_ajax) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ajax][ajax]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ajax][ajax]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ajax][ajax]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ajax][ajax]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_ajax_explanation; ?></span></td>
              <td><span class="required">*</span> <?php echo $entry_menu_speed; ?></td>
              <td><input type="text" name="supercategorymenuadvanced_settings[ajax][speedmenu]" value="<?php echo $settings_ajax_speedmenu; ?>" size="5" /></td>
              <td><?php echo $entry_menu_speed_explanation; ?></span></td>
              <td><span class="required">*</span> <?php echo $entry_asearch_speed; ?></td>
              <td><input type="text" name="supercategorymenuadvanced_settings[ajax][speedresults]" value="<?php echo $settings_ajax_speedresults; ?>" size="5" /></td>
              <td><?php echo $entry_asearch_speed_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_asearch_filters; ?></td>
              <td><?php if ($settings_asearch_filters) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[asearch_filters]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[asearch_filters]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[asearch_filters]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[asearch_filters]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_asearch_filters_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_trigger_see_more; ?></td>
              <td><?php if ($settings_see_more_trigger) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[see_more_trigger]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[see_more_trigger]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[see_more_trigger]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[see_more_trigger]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_see_more_trigger_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_menu_filters; ?></td>
              <td><?php if ($settings_menu_filters) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[menu_filters]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[menu_filters]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[menu_filters]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[menu_filters]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_menu_filters_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_count; ?></td>
              <td><?php if ($settings_countp) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[countp]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[countp]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[countp]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[countp]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_count_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_nofollow; ?></td>
              <td><?php if ($settings_nofollow) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[nofollow]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[nofollow]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[nofollow]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[nofollow]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_nofollow_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_track_google; ?></td>
              <td><?php if ($settings_trackgoogle) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[track_google]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[track_google]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[track_google]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[track_google]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_track_google_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_ocscroll; ?></td>
              <td width="100"><?php if ($settings_ocscroll) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ocscroll]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ocscroll]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <?php if($ocscroll){ ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ocscroll]" value="1" />
                <?php echo $text_yes; ?>
                <?php }else{ ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ocscroll]" value="1" disabled/>
                <?php echo $text_yes; ?>
                <?php } ?>
                <input type="radio" name="supercategorymenuadvanced_settings[ocscroll]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="7"><span class="help"><?php echo $entry_ocscroll_explanation; ?></span></td>
            </tr>
          </table>
        </div>
        <div id="tab-register" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $register_status; ?></td>
              <td colspan="3"><input type="hidden" name="supercategorymenuadvanced_code" value="<?php echo $settings_code; ?>" />
                <?php echo $supercategorymenuadvanced_accountDetails; ?></td>
              <td width="120"></td>
            </tr>
            <tr id="addcode"> </tr>
          </table>
        </div>
        
        
        <div id="tab-pricerange" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_pricerange; ?></td>
              <td><?php if ($settings_pricerange) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][pricerange]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][pricerange]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][pricerange]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][pricerange]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_pricerange_explanation; ?></span></td>
            </tr>
             <tr>
              <td><span class="required">*</span> <?php echo $entry_view; ?></td>
              <td>
              <select name="supercategorymenuadvanced_settings[pricerange][view]">
              <?php if ($settings_price_view == "slider") { ?>
              <option value="slider" selected="selected"><?php echo $entry_slider; ?></option>
              <?php } else { ?>
              <option value="slider"><?php echo $entry_slider; ?></option>
              <?php } ?>
              <?php if ($settings_price_view== "list") { ?>
              <option value="list" selected="selected"><?php echo $entry_list; ?></option>
              <?php } else { ?>
              <option value="list"><?php echo $entry_list; ?></option>
              <?php } ?>
              <?php if ($settings_price_view== "select") { ?>
              <option value="select" selected="selected"><?php echo $entry_select; ?></option>
              <?php } else { ?>
              <option value="select"><?php echo $entry_select; ?></option>
              <?php } ?>
              </select>
               </td>
              <td><span class="help"></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_set_vat; ?></td>
              <td><?php if ($settings_setvat) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][setvat]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][setvat]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][setvat]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[pricerange][setvat]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_set_vat_explanation; ?></span></td>
            </tr>
              <tr>
            
            <td><span class="required">*</span> <?php echo $entry_open; ?></td>
              <td>
            <select name="supercategorymenuadvanced_settings[pricerange][initval]">
              <?php if ($settings_pricerange_initval == "opened") { ?>
              <option value="opened" selected="selected"><?php echo $text_open; ?></option>
              <?php } else { ?>
              <option value="opened"><?php echo $text_open; ?></option>
              <?php } ?>
              <?php if ($settings_pricerange_initval== "closed") { ?>
              <option value="closed" selected="selected"><?php echo $text_close; ?></option>
              <?php } else { ?>
              <option value="closed"><?php echo $text_close; ?></option>
              <?php } ?>
              </select>
                </td>
              
                <td>
                <span class="help">
              <?php echo $entry_view_explanation; ?>
                </span>
                </td>
              
            </tr>
              
                <tr>
              
                <td>
                <span class="required">
                *
                </span>
              <?php echo $default_vat_price_range; ?>
                </td>
              
                <td>
                <select name="supercategorymenuadvanced_settings[pricerange][tax_class_id]">
              
              <?php foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
              </td>
            
            
              <td><span class="help"><?php echo $default_vat_price_range_explanation; ?></span></td>
            </tr>
           
            <tr>
              <td><span class="required">*</span> <?php echo $entry_steps; ?></td>
              <td colspan="2"><?php if ($settings_pricerange_steps) { 

              $values_steps=array('100000','10000','1000','100','10');

              $i=0;
              foreach ($settings_pricerange_steps as $step){ ?>
                <br />
                <?php echo sprintf($entry_steps_text,$values_steps[$i]); ?>
                <input id="stepvalue<?php echo $i; ?>" name="supercategorymenuadvanced_settings[pricerange][steps][]" type="text" value="<?php echo $step; ?>" size="8" />
                <br />
                <script>
  
	    $(function() {
		$( "#slider-range<?php echo $i; ?>" ).slider({
			range: true,
			min: 0,
			max: <?php echo $values_steps[$i]; ?>,
			step: $("#stepvalue<?php echo $i; ?>").val(),
			values: [ 0, <?php echo $values_steps[$i]; ?>],
			start: function(event,ui){
			$("#slider-range<?php echo $i; ?>").slider( "option", "step", $("#stepvalue<?php echo $i; ?>").val());
			},
			slide: function( event, ui ) {
				$( "#amount<?php echo $i; ?>" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			}
		});
		$( "#amount<?php echo $i; ?>" ).val( "$" + $( "#slider-range<?php echo $i; ?>" ).slider( "values", 0 ) +
			" - $" + $( "#slider-range<?php echo $i; ?>" ).slider( "values", 1 ) );
	});
	</script>
                <p>
                  <label for="amount<?php echo $i; ?>">Price range:</label>
                  <input type="text" id="amount<?php echo $i; ?>" style="border:0; color:#f6931f; font-weight:bold;" />
                </p>
                <div style="width:350px"  id="slider-range<?php echo $i; ?>"></div>
                <?php $i++; }?>
                <?php } ?></td>
            </tr>
          </table>
        </div>
        <div id="tab-manufacturer" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_manufacturer; ?></td>
              <td><?php if ($settings_manufacturer) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][manufacturer]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][manufacturer]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][manufacturer]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][manufacturer]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_manufacturer_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_list_number; ?></td>
              <td><input type="text" name="supercategorymenuadvanced_settings[manufacturer][list_number]" value="<?php echo $settings_manufacturer_list_number; ?>" size="5" /></td>
              <td><span class="help"><?php echo $entry_list_number_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_order; ?></td>
              <td><select name="supercategorymenuadvanced_settings[manufacturer][order]">
                  
                  <?php if ($settings_manufacturer_order == "OP") { ?>
                  <option value="OP" selected="selected"><?php echo $opencart; ?></option>
                  <?php } else { ?>
                  <option value="OP"><?php echo $opencart; ?></option>
                  <?php } ?>
                  
                  
                  
                  
                  
                  <?php if ($settings_manufacturer_order == "OH") { ?>
                  <option value="OH" selected="selected"><?php echo $text_human; ?></option>
                  <?php } else { ?>
                  <option value="OH"><?php echo $text_human; ?></option>
                  <?php } ?>
                  <?php if ($settings_manufacturer_order == "OT") { ?>
                  <option value="OT" selected="selected"><?php echo $text_count; ?></option>
                  <?php } else { ?>
                  <option value="OT"><?php echo $text_count; ?></option>
                  <?php } ?>
                </select></td>
              <td><span class="help"><?php echo $entry_order_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_view; ?></td>
              <td><?php if ($settings_manufacturer_view == "list") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][view]" value="list" checked="checked" />
                <?php echo $entry_list; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][view]" value="list"/>
                <?php echo $entry_list; ?>
                <?php } ?>
                <?php if ($settings_manufacturer_view == "sele") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][view]" value="sele" checked="checked" />
                <?php echo $entry_select; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][view]" value="sele"/>
                <?php echo $entry_select; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_open_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_search; ?></td>
              <td><?php if ($settings_manufacturer_searchinput == "yes") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][searchinput]" value="yes" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][searchinput]" value="yes"/>
                <?php echo $text_yes; ?>
                <?php } ?>
                <?php if ($settings_manufacturer_searchinput == "no") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][searchinput]" value="no" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[manufacturer][searchinput]" value="no"/>
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_search_explanation; ?></span></td>
            </tr>
            <tr>
            
            <td><span class="required">*</span> <?php echo $entry_open; ?></td>
              <td>
              <select name="supercategorymenuadvanced_settings[manufacturer][initval]">
            
            <?php if ($settings_manufacturer_initval == "opened") { ?>
            <option value="opened" selected="selected"><?php echo $text_open; ?></option>
            <?php } else { ?>
            <option value="opened"><?php echo $text_open; ?></option>
            <?php } ?>
            <?php if ($settings_manufacturer_initval== "closed") { ?>
            <option value="closed" selected="selected"><?php echo $text_close; ?></option>
            <?php } else { ?>
            <option value="closed"><?php echo $text_close; ?></option>
            <?php } ?>
            </select>
              </td>
            
              <td><span class="help"><?php echo $entry_view_explanation; ?></span></td>
            
            </tr>
            
          </table>
        </div>
        <div id="tab-categories" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_category; ?></td>
              <td><?php if ($settings_category) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][category]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][category]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][category]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][category]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_category_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_category_asearch; ?></td>
              <td><?php if ($settings_category_asearch) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][asearch]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][asearch]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][asearch]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][asearch]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_asearch_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_list_number; ?></td>
              <td><input type="text" name="supercategorymenuadvanced_settings[category][list_number]" value="<?php echo $settings_category_list_number; ?>" size="5" /></td>
              <td><span class="help"><?php echo $entry_list_number_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_order; ?></td>
              <td><select name="supercategorymenuadvanced_settings[category][order]">
                 
                 <?php if ($settings_category_order == "OP") { ?>
                  <option value="OP" selected="selected"><?php echo $opencart; ?></option>
                  <?php } else { ?>
                  <option value="OP"><?php echo $opencart; ?></option>
                  <?php } ?>
                 
                 <?php if ($settings_category_order == "OH") { ?>
                  <option value="OH" selected="selected"><?php echo $text_human; ?></option>
                  <?php } else { ?>
                  <option value="OH"><?php echo $text_human; ?></option>
                  <?php } ?>
                  <?php if ($settings_category_order == "OT") { ?>
                  <option value="OT" selected="selected"><?php echo $text_count; ?></option>
                  <?php } else { ?>
                  <option value="OT"><?php echo $text_count; ?></option>
                  <?php } ?>
                </select></td>
              <td><span class="help"><?php echo $entry_order_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_view; ?></td>
              <td><?php if ($settings_category_view == "list") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][view]" value="list" checked="checked" />
                <?php echo $entry_list; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][view]" value="list"/>
                <?php echo $entry_list; ?>
                <?php } ?>
                <?php if ($settings_category_view == "sele") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][view]" value="sele" checked="checked" />
                <?php echo $entry_select; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][view]" value="sele"/>
                <?php echo $entry_select; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_view_explanation; ?></span></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_style; ?></td>
              <td><?php if ($settings_category_style == "imagen1") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][style]" value="imagen1" checked="checked" />
                <img src="<?php echo HTTP_CATALOG ?>/catalog/view/javascript/jquery/supermenu/images/imagen1.gif" />
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][style]" value="imagen1"/>
                <img src="<?php echo HTTP_CATALOG ?>/catalog/view/javascript/jquery/supermenu/images/imagen1.gif" />
                <?php } ?>
                <?php if ($settings_category_style == "imagen2") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][style]" value="imagen2" checked="checked" />
                <img src="<?php echo HTTP_CATALOG ?>/catalog/view/javascript/jquery/supermenu/images/imagen2.gif" />
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[category][style]" value="imagen2"/>
                <img src="<?php echo HTTP_CATALOG ?>/catalog/view/javascript/jquery/supermenu/images/imagen2.gif" />
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_style_explanation; ?></span></td>
            </tr>
              <tr>
            
            <td><span class="required">*</span> <?php echo $entry_open; ?></td>
            <td>
            <select name="supercategorymenuadvanced_settings[category][initval]" >
            <?php if ($settings_category_initval == "opened") { ?>
            <option value="opened" selected="selected"><?php echo $text_open; ?></option>
            <?php } else { ?>
            <option value="opened"><?php echo $text_open; ?></option>
            <?php } ?>
            <?php if ($settings_category_initval== "closed") { ?>
            <option value="closed" selected="selected"><?php echo $text_close; ?></option>
            <?php } else { ?>
            <option value="closed"><?php echo $text_close; ?></option>
            <?php } ?>
            </select>
              </td>
            
              <td>
              <span class="help">
            <?php echo $entry_view_explanation; ?>
              </span>
              </td>
            
            </tr>
            
          </table>
        </div>
        <div id="tab-styles" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_style; ?></td>
              <td><select name="supercategorymenuadvanced_settings[styles]" onchange="$('#style').load('index.php?route=module/supercategorymenuadvanced/style&token=<?php echo $token; ?>&style=' + encodeURIComponent(this.value));">
                  <?php foreach ($styles as $style) { ?>
                  <?php if ($style == $settings_styles) { ?>
                  <option value="<?php echo $style; ?>" selected="selected"><?php echo $style; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $style; ?>"><?php echo $style; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td></td>
              <td id="style"></td>
            </tr>
          </table>
          <script>
		
		$('#style').load('index.php?route=module/supercategorymenuadvanced/style&token=<?php echo $token; ?>&style=' + encodeURIComponent($('select[name=\'supercategorymenuadvanced_settings[styles]\']').attr('value')));
		
		</script> 
        </div>
        <div id="tab-templates" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_template; ?></td>
              <td><select name="supercategorymenuadvanced_settings[template_menu]">
                  <?php foreach ($templates as $template) { ?>
                  <?php if ($template == $settings_template) { ?>
                  <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <?php if (empty($templates)) { ?>
            <script type="text/javascript">
               $('#templates').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"10\" border=\"0\" />');  $('#templates').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
            
            </script>
          <tr>
              <td colspan="2">
              <div class="warning">
                Please be sure you have installed the menu templates in your theme folder, go to support.ocmodules.com,
                <ul>
                <li> Check under download section if yout theme is there, if yes download and install the files.</li>
                <li> if not go to installation videos and watch <strong>"HOW install advanced menu in a special theme video"</strong>, and follow the instructions.</li>
                </ul>                   
              </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td id="template"></td>
            </tr>
          </table>
        </div>
        <div id="tab-stock" class="vtabs-content">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_stock; ?></td>
              <td><?php if ($settings_stock) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][stock]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][stock]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][stock]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][stock]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="3"><span class="help"><?php echo $entry_stock_explanation; ?></span></td>
            </tr>
         <?php /*
            <tr>
              <td><span class="required">*</span> <?php echo $entry_recalcular; ?></td>
              <td style="width:150px"><?php if ($settings_recalcular) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][recalcular]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][recalcular]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][recalcular]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][recalcular]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="3"><span class="help"><?php echo $entry_recalcular_explanation; ?></span></td>
            </tr>
            */ ?>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_clearance; ?></td>
              <td style="width:150px"><?php if ($settings_clearance) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][clearance]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][clearance]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][clearance]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][clearance]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span class="help"><?php echo $entry_clearance_explanation; ?></span></td>
              <td><span class="required">*</span> <?php echo $entry_select_clearance; ?></td>
              <td>             
              <select name="supercategorymenuadvanced_settings[stock][clearance_value]">
                  <?php foreach ($stock_statuses as $stock_status) { ?>
                    <?php if ($stock_status['stock_status_id'] == $settings_clearance_value) { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
             </select>
              </td>
            </tr> 
              <tr>
              <td><span class="required">*</span> <?php echo $entry_special; ?></td>
              <td style="width:150px"><?php if ($settings_special) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][special]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][special]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][special]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][special]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="3"><span class="help"><?php echo $entry_special_explanation; ?></span></td>
            </tr> 
             <tr>
              <td><span class="required">*</span> <?php echo $entry_arrivals; ?></td>
              <td style="width:150px"><?php if ($settings_arrivals) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][arrivals]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][arrivals]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][arrivals]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][arrivals]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td><span style="width:150px"><span class="help"><?php echo $entry_arrivals_explanation; ?></span></span></td>
              <td><span class="required">*</span> <?php echo $entry_number_day; ?></td>
              <td><input type="text" name="supercategorymenuadvanced_settings[stock][number_day]" value="<?php echo $settings_number_day; ?>" size="5" /></td>
            </tr> 
     
           <tr>
              <td><span class="required">*</span> <?php echo $entry_auto_clean; ?></td>
              <td style="width:150px"><?php if ($settings_auto_clean) { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][auto_clean]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][auto_clean]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][auto_clean]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][auto_clean]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
              <td colspan="3"><span class="help"><?php echo $entry_auto_clean_explanation; ?></span></td>
            </tr>   <tr>
              <td><span class="required">*</span> <?php echo $entry_view; ?></td>
              <td><?php if ($settings_stock_view == "list") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][view]" value="list" checked="checked" />
                <?php echo $entry_list; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][view]" value="list"/>
                <?php echo $entry_list; ?>
                <?php } ?>
                <?php if ($settings_stock_view == "sele") { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][view]" value="sele" checked="checked" />
                <?php echo $entry_select; ?>
                <?php } else { ?>
                <input type="radio" name="supercategorymenuadvanced_settings[stock][view]" value="sele"/>
                <?php echo $entry_select; ?>
                <?php } ?></td>
              <td colspan="3"><span class="help"><?php echo $entry_view_explanation; ?></span></td>
            </tr> 
           <tr>
            
            <td><span class="required">*</span> <?php echo $entry_open; ?></td>
              <td><select name="supercategorymenuadvanced_settings[stock][initval]">
            
            <?php if ($settings_stock_initval == "opened") { ?>
            <option value="opened" selected="selected"><?php echo $text_open; ?></option>
            <?php } else { ?>
            <option value="opened"><?php echo $text_open; ?></option>
            <?php } ?>
            <?php if ($settings_stock_initval== "closed") { ?>
            <option value="closed" selected="selected"><?php echo $text_close; ?></option>
            <?php } else { ?>
            <option value="closed"><?php echo $text_close; ?></option>
            <?php } ?>
            </select>
              </td>
            
              <td colspan="3"><span class="help"><?php echo $entry_view_explanation; ?></span></td>
            </tr>
            
          </table>
        </div>
        <div id="tab-layouts" class="vtabs-content">
          <table id="module" class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_layout; ?></td>
                <td class="left"><?php echo $entry_position; ?></td>
                <td class="left"><?php echo $entry_status; ?></td>
                <td class="right"><?php echo $entry_sort_order; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $module_row = 0; ?>
            <?php foreach ($modules as $module) { ?>
            <tbody id="module-row<?php echo $module_row; ?>">
              <tr>
                <td class="left"><select name="supercategorymenuadvanced_module[<?php echo $module_row; ?>][layout_id]">
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="left"><select name="supercategorymenuadvanced_module[<?php echo $module_row; ?>][position]">
                    <?php if ($module['position'] == 'column_left') { ?>
                    <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                    <?php } else { ?>
                    <option value="column_left"><?php echo $text_column_left; ?></option>
                    <?php } ?>
                    <?php if ($module['position'] == 'column_right') { ?>
                    <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                    <?php } else { ?>
                    <option value="column_right"><?php echo $text_column_right; ?></option>
                    <?php } ?> 
                    <?php if ($module['position'] == 'content_filter') { ?>
                    <option value="content_filter" selected="selected"><?php echo $text_horizontal; ?></option>
                    <?php } else { ?>
                    <option value="content_filter"><?php echo $text_horizontal; ?></option>
                    <?php } ?>
                  </select></td>
                <td class="left"><select name="supercategorymenuadvanced_module[<?php echo $module_row; ?>][status]">
                    <?php if ($module['status']) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select></td>
                <td class="right"><input type="text" name="supercategorymenuadvanced_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
                <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
              </tr>
            </tbody>
            <?php $module_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </form>
      <div id="tab-admincache" class="vtabs-content">
        <div class="box">
          <div class="heading">
            <h1><img src="view/image/product.png" alt="" /> <?php echo $entry_cache_del_list; ; ?></h1>
            <div class="buttons">
              <?php if (!$text_error_no_cache) { ?>
              <a id="deletecache" class="button"><span><?php echo $button_delete; ?></span></a>
              <?php } ?>
            </div>
          </div>
          <br />
          <div class="attention"><?php echo $text_cache_del_remenber_setting; ?></div>
          <div id="notification"></div>
          <div id="form_delete_reponse">
            <form method="get" id="del_admin_cache">
              <input name="category_id" type="hidden" value="admin" />
              <input name="Are_you_sure" type="hidden" value="admin" />
              <input name="token" type="hidden" value="<?php echo $this->session->data['token']; ?>" />
              <table class="list">
                <thead>
                  <tr>
                    <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected_del\']').attr('checked', this.checked);" /></td>
                    <td class="right">cat</td>
                    <td class="left">reference</td>
                    <td class="left">cached</td>
                    <td class="left">date</td>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($cache_records) { ?>
                  <?php foreach ($cache_records as $cache_record) { ?>
                  <tr>
                    <td style="text-align: center;"><input type="checkbox" name="selected_del[]" value="<?php echo $cache_record['cache_id']; ?>" /></td>
                    <td class="right"><?php echo $cache_record['cat']; ?></td>
                    <td class="left"><?php echo $cache_record['name']; ?></td>
                    <td class="left"><?php echo $cache_record['cached']; ?></td>
                    <td class="left"><?php echo $cache_record['date']; ?></td>
                  </tr>
                  <?php } ?>
                  <?php } else { ?>
                  <tr>
                    <td class="center" colspan="5"><?php echo $text_error_no_cache; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
      <script>		

  function AjaxDeleteAdmin(){        
		$.ajax({
			success:showResponseAjaxDeleteAdmin,  // post-submit callback 
			url: 'index.php?route=module/supercategorymenuadvanced/DeleteCacheSettings',
			data: $('#del_admin_cache').serialize(),
			type: "GET",
			cache: true,
		
		});
	};

	function showResponseAjaxDeleteAdmin(responseText, statusText, xhr)  { 
		   $('#form_delete_reponse').fadeOut('slow', function(){
		   $("#form_delete_reponse").html('');
		   $("#form_delete_reponse").replaceWith(responseText).fadeIn(2000);
		});
		
		
		$("#notification").html('<div class="success" style="display: none;"><?php echo $successdel; ?></div>');
	  		 $(".success").fadeIn("slow");
	   		 $('.success').delay(2500).fadeOut('slow');
	  	 	 $("html, body").animate({scrollTop: 0}, "slow")	
		}
			 
	
	$('a#deletecache').click(function() { AjaxDeleteAdmin();return false;});
    $('a#truncate').click(function() {
		
		
		$.ajax({
			url: 'index.php?route=module/supercategorymenuadvanced/DeleteCacheDB&token=<?php echo $token; ?>',
			dataType: 'json',
			beforeSend: function() {
			$('#num_registros').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');},
			complete: function() { $('.loading').remove();},
			success: function(json) {
			$('.success').remove();
			$('.warning').remove();
			if (json['error']) {
			$('#tab-settings').prepend('<div class="warning" style="display: none;">' + json['error'] + '</div>');
			$('.warning').fadeIn('slow');
			}
			if (json.success) {
			 $("#tab-settings").prepend('<div class="success" style="display: none;">'+json.success+'</div>');
	  		 $(".success").fadeIn("slow");
	   		 $('.success').delay(2500).fadeOut('slow');
				
				
			 $('#num_registros').html(json.registros +" <?php echo $text_records; ?>");
        	}
			}
			});
			}); 
				
	
  </script>
      <div id="tab-contact" class="vtabs-content">
        <table width="100%" border="0" cellpadding="2">
          <tr>
            <td rowspan="2" valign="top"><img src="view/image/logo_scmv.png" title="I'm Happy!" /></td>
            <td><table width="100%" border="0" cellpadding="2">
                <tr>
                  <td>Contact: (Only registered users will be supported)</td>
                  <td><a href="http://support.ocmodules.com" target="_blank">support.ocmodules.com</a></td>
                </tr>
                <tr>
                  <td>Current Version:</td>
                  <td><?php echo $current_version; ?>
                    <div id="newversion"></div></td>
                </tr>
                <tr>
                  <td></td>
                  <td><div id="what_is_new"></div></td>
                </tr>
                <tr>
                  <td>OpenCart Url</td>
                  <td><a href="http://www.opencart.com/index.php?route=extension/extension/info&amp;extension_id=<?php echo $version['extension_opencart_url']; ?>" target="_blank"> http://www.opencart.com/index.php?route=extension/extension/info&amp;extension_id=<?php echo $version['extension_opencart_url']; ?></a></td>
                </tr>
              </table>
              <br />
              <br />
              <?php if (isset($version['modules'])){ ?>
              <strong>Other modules:</strong><br />
              <table width="100%" border="0" cellpadding="2">
                <?php foreach ($version['modules'] as $modules) { ?>
                <tr>
                  <td height="66"><strong><br />
                    <?php echo $modules['name']; ?> - v<?php echo $modules['version']; ?></strong><br />
                    <?php echo str_replace("@@@","<br>",$modules['resume']); ?><br />
                    OC: <a href="http://www.opencart.com/index.php?route=extension/extension/info&amp;extension_id=<?php echo $modules['extension_opencart_url']; ?>" target="_blank">http://www.opencart.com/index.php?route=extension/extension/info&extension_id=<?php echo $modules['extension_opencart_url']; ?> </a>
                    <?php if ($modules['video']) { ?>
                    Video: <a href="<?php echo $modules['video']; ?>" target="_blank"><br />
                    <?php } ?></td>
                  <td>&nbsp;</td>
                </tr>
                <?php } ?>
              </table>
              <?php } ?></td>
            <?php  if ($version){ 

            if ($version['current_version']!=$current_version){ ?>
            <script type="text/javascript">
               $('#contact').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"10\" border=\"0\" />');  $('#contact').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
               $('#newversion').append ('<span style=\"color:red\"><strong>New version for this extesion available <?php echo $version["current_version"]; ?></strong></span>');
               $('#what_is_new').append('<?php echo html_entity_decode(str_replace("@@@","<br>",$version['whats_new']), ENT_QUOTES, 'UTF-8'); ?> ');
              </script>
            <?php } else{ ?>
            <script type="text/javascript">
            $('#contact').append('<img id=\"success\" src=\"view/image/success.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"10\" border=\"0\" />');  $('#contact').css({'border': '1px solid #BBDF8D','color': 'green'});		
	</script>
            <?php  }} ?>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      
      <!-- END CONTENT TAB GENERAL --> 
      

      
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="supercategorymenuadvanced_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="supercategorymenuadvanced_module[' + module_row + '][position]">';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '      <option value="column_right"><?php echo $text_horizontal; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="supercategorymenuadvanced_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="supercategorymenuadvanced_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	$('#module tfoot').before(html);
	module_row++;
}
<?php if (!$rg){ ?>
$('#licensing').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"10\" border=\"0\" />');  $('#licensing').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});	
<?php }else{ ?>
$('#licensing').append('<img id=\"success\" src=\"view/image/success.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"10\" border=\"0\" />');  $('#licensing').css({'border': '1px solid #BBDF8D','color': 'green'});		
<?php } ?>
$('#settings a').tabs(); 
$('#menutemplates').change(function() {
	var file=$(this).val();
	var n=file.split("."); 
	var uxml ='<?php echo $url_templates; ?>'+ n[0]+'.xml';
		
	$.ajax({
  	type: 'GET',
  	url: uxml,
 	cache: false,
  	dataType: ($.browser.msie) ? 'text' : 'xml', // Reconocemos el browser.
  	success: function(data){
   	var xml;
   	if(typeof data == 'string'){
     	 xml = new
     	 ActiveXObject('Microsoft.XMLDOM');
      	xml.async = false;
      	xml.loadXML(data);
    } else {
     	 xml = data;
    }
	
	$(xml).find('menu').each(function(){
	var name = $(this).find('name').text();
	var designed = $(this).find('designed').text();
	var extension = $(this).find('extension').text();
	var explantion = $(this).find('explantion').text();
	var intructions = $(this).find('intructions').text();
	var version = $(this).find('version').text();
	html='';
	html+='<strong>Name: </strong>'+ name+' v'+version+'<br>';
	html+='<strong>Designed: </strong>'+designed +'<br>';
	html+='<strong>Extension: </strong>'+ extension+'<br>';
	html+='<strong>Explantion: </strong>'+ explantion+'<br>';
	html+='<strong>Intructions: </strong>'+ intructions+'<br>';
	$( "#template" ).html( '' );
    $( "#template" ).append( html );
	
	});
	
	}
	});

});
$("a.register").click(function() {
	html='';
	$('tr#addcode').html();
	html='<td>Please enter register code:</td>';
	html+='<td><input type="input" name="supercategorymenuadvanced_code" value="" /></td><td></td></tr>';
	$('tr#addcode').html(html);
});
 $('a.register').fancybox({
	 'type':'iframe',
	 'transitionIn':'elastic',
	 'transitionOut':'elastic',
	 'speedIn':600,
	 'speedOut':200,
	 'scrolling':'no',
	 'showCloseButton':true,
	 'overlayShow':false,
	 'autoDimensions':false,
	 'width': 600,
	 'height': 300,
	});
//--></script> 
<?php echo $footer; ?>