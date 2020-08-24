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
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="qss_button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="qss_button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-settings" style="display: inline;"><?php echo $tab_settings; ?></a>
                <a href="#tab-customization" style="display: inline;"><?php echo $tab_customization; ?></a>
                <a href="#tab-search-settings" style="display: inline;"><?php echo $tab_search_settings; ?></a>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-settings">
                    
                    <table class="form">
            <h2><?php echo $text_general_settings; ?></h2>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_status; ?></td>
                            <td><select name="qss_status">
                                    <option value="1" <?php if ($qss_status == '1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                                    <option value="0" <?php if ($qss_status == '0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                                </select></td>
                        </tr>
                        
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_max_result; ?></td>
                            <td><input type="text" name="qss_max_results" value="<?php echo $qss_max_results;?>" style="width: 45px;"/>                             
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_min_word_lenght_to_active_search; ?></td>
                            <td><input type="text" name="qss_min_word_lenght_to_active_search" value="<?php echo $qss_min_word_lenght_to_active_search;?>"  style="width: 45px;"/>                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_result_box_width; ?></td>
                            <td><input type="text" name="qss_result_box_width" value="<?php echo $qss_result_box_width;?>"  style="width: 45px;"/>                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_view_more_text; ?></td>
                            <td><input type="text" name="qss_view_more_text" value="<?php echo $qss_view_more_text;?>"  style="width: 300px;"/>                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_no_result_found_text; ?></td>
                            <td><input type="text" name="qss_no_result_found_text" value="<?php echo $qss_no_result_found_text;?>" style="width: 300px;"/>                               
                            </td>
                        </tr>



                    </table>
                </div>
                <div id="tab-customization">
                    <h2><?php echo $text_category_separator; ?></h2>
                    <table class="form">
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_category_separately; ?></td>
                            <td><select name="qss_category_separately" class="do_action" id="category_sep">
                                    <option value="1" <?php if ($qss_category_separately == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_category_separately == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select></td>
                        </tr>
                        <tbody id="div_category_sep" <?php if ($qss_category_separately == '0') { ?>style="display:none;"<?php } ?>>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_max_category; ?></td>
                            <td><input type="text" name="qss_max_category" value="<?php echo $qss_max_category;?>"  style="width: 45px;"/>                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_max_result_in_category; ?></td>
                            <td><input type="text" name="qss_max_result_in_category" value="<?php echo $qss_max_result_in_category;?>"  style="width: 45px;"/>                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_category_heading_background_color; ?></td>
                            <td><input type="text" name="qss_category_heading_background_color" value="<?php echo $qss_category_heading_background_color;?>"  />                                
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_category_heading_font_color; ?></td>
                            <td><input type="text" name="qss_category_heading_font_color" value="<?php echo $qss_category_heading_font_color;?>"  />                                
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_category_heading_font_size; ?></td>
                            <td><input type="text" name="qss_category_heading_font_size" value="<?php echo $qss_category_heading_font_size;?>"  />                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                     <h2><?php echo $text_common; ?></h2>
                    <table class="form">
                    <tr>
                            <td style="width: 250px;"><?php echo $entry_background_color; ?></td>
                            <td><input type="text" name="qss_background_color" value="<?php echo $qss_background_color;?>"  />                          
                            </td>
                        </tr>
                    <tr>
                            <td style="width: 250px;"><?php echo $entry_border_color; ?></td>
                            <td><input type="text" name="qss_border_color" value="<?php echo $qss_border_color;?>"  />                          
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_heighlight_color; ?></td>
                            <td><input type="text" name="qss_heighlight_color" value="<?php echo $qss_heighlight_color;?>"  />                                
                            </td>
                        </tr>
                    </table>
                    <h2><?php echo $text_product_title; ?></h2>
                    <table class="form">
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_title_visibility; ?></td>
                            <td><select name="qss_product_title_visibility" class="do_action" id="product_name">
                                    <option value="1" <?php if ($qss_product_title_visibility == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_product_title_visibility == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select></td>
                        </tr>                           
                        <tbody id="div_product_name" <?php if ($qss_product_title_visibility == '0') { ?>style="display:none;"<?php } ?>>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_name_font_color; ?></td>
                            <td><input type="text" name="qss_product_name_font_color" value="<?php echo $qss_product_name_font_color;?>"  />                                
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_name_font_size; ?></td>
                            <td><input type="text" name="qss_product_name_font_size" value="<?php echo $qss_product_name_font_size;?>"  />                              
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h2><?php echo $text_product_description; ?></h2>
                    <table class="form">
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_discription_visibility; ?></td>
                            <td><select name="qss_product_discription_visibility" class="do_action" id="product_des">
                                    <option value="1" <?php if ($qss_product_discription_visibility == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_product_discription_visibility == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select></td>
                        </tr>                        
                        <tbody id="div_product_des" <?php if ($qss_product_discription_visibility == '0') { ?>style="display:none;"<?php } ?>>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_discription_font_color; ?></td>
                            <td><input type="text" name="qss_product_discription_font_color" value="<?php echo $qss_product_discription_font_color;?>"  />                               
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_discription_font_size; ?></td>
                            <td><input type="text" name="qss_product_discription_font_size" value="<?php echo $qss_product_discription_font_size;?>"  />                                
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_discription_word_lenght; ?></td>
                            <td><input type="text" name="qss_product_discription_word_lenght" value="<?php echo $qss_product_discription_word_lenght;?>"  />                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h2><?php echo $text_product_price; ?></h2>
                    <table class="form">  
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_price_visibility; ?></td>
                            <td><select name="qss_product_price_visibility" class="do_action" id="product_price">
                                    <option value="1" <?php if ($qss_product_price_visibility == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_product_price_visibility == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select></td>
                        </tr>    
                        <tbody id="div_product_price" <?php if ($qss_product_price_visibility == '0') { ?>style="display;none;"<?php } ?>>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_price_font_color; ?></td>
                            <td><input type="text" name="qss_product_price_font_color" value="<?php echo $qss_product_price_font_color;?>"  />                                
                            </td>
                        </tr>
                         <tr>
                            <td style="width: 250px;"><?php echo $entry_product_price_font_size; ?></td>
                            <td><input type="text" name="qss_product_price_font_size" value="<?php echo $qss_product_price_font_size;?>"  />                                
                            </td>
                        </tr>  
                        </tbody>
                        </table>
                    <h2><?php echo $text_product_image; ?></h2>
                    <table class="form">  
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_image_visibility; ?></td>
                            <td><select name="qss_product_image_visibility" class="do_action" id="product_image">
                                    <option value="1" <?php if ($qss_product_image_visibility == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_product_image_visibility == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select></td>
                        </tr> 
                        <tbody id="div_product_image" <?php if ($qss_product_image_visibility == '0') { ?>style="display:none;"<?php } ?>>
                        <tr>
                                                <td style="width: 250px;"><?php echo $entry_product_image_width; ?></td>
                        <td><input type="text" name="qss_product_image_width" value="<?php echo $qss_product_image_width;?>"  />                               
                        </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;"><?php echo $entry_product_image_height; ?></td>
                            <td><input type="text" name="qss_product_image_height" value="<?php echo $qss_product_image_height;?>"  />                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="tab-search-settings">
                    <h2><?php echo $text_search_in; ?></h2>
                    <table id="module" class="list">

                        <table class="form">
                            <tr>
                                <td style="vertical-align: top;"><?php echo $entry_search_in;?></td>
                                <td>
                                    <input type="checkbox" name="qss_search_in[]" value="name" <?php if(in_array('name',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_name;?> <br>
                                    <input type="checkbox" name="qss_search_in[]" value="description" <?php if(in_array('description',$qss_search_in)) { ?>checked="checked"<?php } ?>/> <?php echo $text_description;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="meta_description" <?php if(in_array('meta_description',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_meta_description;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="meta_keyword" <?php if(in_array('meta_keyword',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_meta_keyword;?> <br>
                                    <input type="checkbox" name="qss_search_in[]" value="upc" <?php if(in_array('upc',$qss_search_in)) { ?>checked="checked"<?php } ?>" /> <?php echo $text_upc;?> <br>
                                    <input type="checkbox" name="qss_search_in[]" value="sku" <?php if(in_array('sku',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_sku;?> <br>
                                    <input type="checkbox" name="qss_search_in[]" value="ean" <?php if(in_array('ean',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_ean;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="jan" <?php if(in_array('jan',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_jan;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="isbn" <?php if(in_array('isbn',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_isbn;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="mpn" <?php if(in_array('mpn',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_mpn;?><br>                                    
                                    <input type="checkbox" name="qss_search_in[]" value="attr_val" <?php if(in_array('attr_val',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_attr_val;?><br>                                    
                                    <input type="checkbox" name="qss_search_in[]" value="option_val" <?php if(in_array('option_val',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_option_val;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="tags" <?php if(in_array('tags',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_tags;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="model" <?php if(in_array('model',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_model;?><br>
                                    <input type="checkbox" name="qss_search_in[]" value="manufacture" <?php if(in_array('manufacture',$qss_search_in)) { ?>checked="checked"<?php } ?> /> <?php echo $text_manufacture;?><br>
                                    
                                    </td>
                            </tr>
                                                  
                            </table>
                        
                    <h2><?php echo $text_auto_suggest; ?></h2>
                    <table id="module" class="list">

                        <table class="form">
                            <tr>
                                <td><?php echo $entry_word_replace_rule;?></td>
                                <td>
                                    <select name="qss_word_rule_status">
                                    <option value="1" <?php if ($qss_word_rule_status == '1') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                                    <option value="0" <?php if ($qss_word_rule_status == '0') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                                </select>
                                    </td>
                            </tr>
                                                  
                            </table>
                        <table class="list" id="module">
            <?php $module_row = 0; ?>
                <?php if(!empty($qss_word_rules)){ ?>
                        <?php foreach ($qss_word_rules['word'] as $qss_word_rule) { ?>
                        <tbody id="module-row<?php echo $module_row; ?>">
                            <tr>
                                <td class="left">
                                    <input type="text" name="qss_word_rules[word][<?php echo $module_row; ?>]" value="<?php echo $qss_word_rules['word'][$module_row];?>"  />               
                                </td>
                                <td class="left">
                                    >>
                                </td>
                                <td class="left">
                                    <input type="text" name="qss_word_rules[replacement][<?php echo $module_row; ?>]" value="<?php echo $qss_word_rules['replacement'][$module_row];?>"  />               
                                </td>

                                <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="qss_button"><?php echo $button_remove; ?></a></td>
                            </tr>
                        </tbody>
                        <?php $module_row++; ?>
                        <?php } ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="left"><a onclick="addModule();" class="qss_button"><?php echo $button_add_rule; ?></a></td>
                            </tr>
                        </tfoot>
                        
          </table>
                        
        
                </div>
            </form>

        </div>
    </div>
</div>
<style type="text/css">
.qss_button{ background: none repeat scroll 0 0 #003A88 !important;
    border-radius: 10px 10px 10px 10px;
    color: #FFFFFF !important;
    display: inline-block;
    padding: 5px 15px;
    text-decoration: none;
    }
</style>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
            function addModule() {
                html = '<tbody id="module-row' + module_row + '">';
                html += '  <tr>';
                html += '    <td class="left">';
                html += '       <input type="text" name="qss_word_rules[word][' + module_row + ']" value=""  />    ';
                html += '   </td>';
                html += '    <td class="left">';
                html += '       >>  ';
                html += '   </td>';
                html += '    <td class="left">';
                html += '      <input type="text" name="qss_word_rules[replacement][' + module_row + ']" value=""  />   ';
                html += '    </td>';
                html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="qss_button"><?php echo $button_remove; ?></a></td>';
                html += '  </tr>';
                html += '</tbody>';

                $('#module tfoot').before(html);

                module_row++;
            }
            
            $('.do_action').on('change', function() {
  var selVal =this.value;
  var selId = $(this).attr('id');
  var divId = "div_"+selId;
  if(selVal == '1'){
  $("#"+divId).show();
  }else{ 
  $("#"+divId).hide();
  }
});
//--></script> 

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>
<?php echo $footer; ?>