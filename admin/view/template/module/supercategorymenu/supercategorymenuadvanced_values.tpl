<?php if ($error_warning) { ?>

<div class="warning"><?php echo $error_warning; ?></div>
<?php }else{ ?>
<?php if (empty($category['all_values'])) {?>
<div class="attention"><?php echo $no_values; ?> </div>
<?php }else{ ?>
<div id="notification2"></div>
<div class="box">
  <div class="heading">
    <div class="selectbox" style="float:left;padding-top: 15px;">
      <input name="VALORES_<?php echo $category['category_id']; ?>" type="checkbox" value="1" onclick="Selecbox(this);"/>
      <?php echo $entry_all_values; ?> </div>
    <div class="buttons"> <a class="button" id="editattribute"  href="javascript:void(0)" ><span><?php echo $button_save; ?></span></a> <a onclick="$('#tr_nueva').fadeOut(1000, function() { $(this).remove(); });" class="button"><span><?php echo $button_close; ?></span></a>
      <?php if($category['parent_id']){ ?>
      <a class="button" id="editallcategories"  href="javascript:void(0)" ><span><?php echo $button_save_all; ?></span></a>
      <?php } ?>
    </div>
  </div>
  <form action="<?php echo $action_save_attribute; ?>" method="get" enctype="multipart/form-data" id="formatt">
    <input name="dnd" type="hidden" value="VALORES_<?php echo $category['category_id']; ?>" />
    <input name="token" type="hidden" value="<?php echo $this->session->data['token']; ?>" />
    <input name="category_id" type="hidden" value="<?php echo $category['category_id']; ?>" />
    <input name="store_id" type="hidden" value="<?php echo $category['store_id']; ?>" />
    <table id="tblattributes" width="100%" border="0" cellpadding="2" class="list">
      <thead>
        <tr>
          <td class="left"><?php echo $entry_value; ?><img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_values_explanation; ?>" /></td>
          <td class="left"><?php echo $text_what_is; ?></td>
          <td class="left"><?php echo $entry_num_products; ?></td>
          <td class="left"><?php echo $entry_sort_order; ?></td>
          <td class="left"><?php echo $entry_view; ?></td>
          <td class="left"><?php echo $entry_separator; ?> <img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_separator_explanation; ?>" /></td>
          <td class="left"><?php echo $entry_search; ?></td>
          <td class="left"><?php echo $entry_open; ?></td>
          <td class="left"><?php echo $entry_order; ?></td>
          <td class="left"><?php echo $entry_examples; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($category['all_values'] as $value) { ?>
        <tr>
          <td class="left"><?php 

          

          $value['what']=="options" ? $str="option_id"  : $str="attribute_id" ;

          

      if ($value['checked']) { ?>
            <input name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" checked="checked" />
            <?php echo $value['name']; ?>
            <?php }else{ ?>
            <input name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" />
            <?php echo $value['name']; ?>
            <?php } ?></td>
          <td><?php echo substr(strtoupper($value['what']), 0, -1); ?></td>
          <td class="left"><input beforeUnselect="<?php echo $value['number']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][number]" type="text" value="<?php echo $value['number']; ?>" size="5"/></td>
          <td class="left"><input beforeUnselect="<?php echo $value['sort_order']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][sort_order]" type="text" value="<?php echo $value['sort_order']; ?>" size="5"/></td>
          <td class="left"><select beforeunselect="<?php echo $value['view']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][view]">
              <?php if ($value['view'] == "list") { ?>
              <option value="list" selected="selected"><?php echo $entry_list; ?></option>
              <?php } else { ?>
              <option value="list"><?php echo $entry_list; ?></option>
              <?php } ?>
              <?php if ($value['view'] == "sele") { ?>
              <option value="sele" selected="selected"><?php echo $entry_select; ?></option>
              <?php } else { ?>
              <option value="sele"><?php echo $entry_select; ?></option>
              <?php } ?>
              <?php if ($value['what']=="options"){ ?>
              <?php if ($value['view'] == "image") { ?>
              <option value="image" selected="selected"><?php echo $entry_image; ?></option>
              <?php } else { ?>
              <option value="image"><?php echo $entry_image; ?></option>
              <?php } ?>
              <?php  } ?>
            </select></td>
          <td class="left"><input beforeUnselect="<?php echo $value['separator']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][separator]" type="text" value="<?php echo $value['separator']; ?>" size="5"/></td>
          <td class="left"><select beforeUnselect="<?php echo $value['searchinput']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][searchinput]">
              <?php if ($value['searchinput'] == "yes") { ?>
              <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
              <?php } else { ?>
              <option value="yes"><?php echo $text_yes; ?></option>
              <?php } ?>
              <?php if ($value['searchinput'] == "no") { ?>
              <option value="no" selected="selected"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="no"><?php echo $text_no; ?></option>
              <?php } ?>
            </select></td>
          <td class="left"><select beforeUnselect="<?php echo $value['initval']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][initval]">
              <?php if ($value['initval'] == "opened") { ?>
              <option value="opened" selected="selected"><?php echo $text_open; ?></option>
              <?php } else { ?>
              <option value="opened"><?php echo $text_open; ?></option>
              <?php } ?>
              <?php if ($value['initval'] == "closed") { ?>
              <option value="closed" selected="selected"><?php echo $text_close; ?></option>
              <?php } else { ?>
              <option value="closed"><?php echo $text_close; ?></option>
              <?php } ?>
            </select></td>
          <td class="left">
          <select beforeUnselect="<?php echo $value['orderval']; ?>" name="VALORES_<?php echo $category['category_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][orderval]">
              <?php if ($value['orderval'] == "OH") { ?>
              <option value="OH" selected="selected"><?php echo $text_human; ?></option>
              <?php } else { ?>
              <option value="OH"><?php echo $text_human; ?></option>
              <?php } ?>
              <?php if ($value['orderval'] == "OT") { ?>
              <option value="OT" selected="selected"><?php echo $text_count; ?></option>
              <?php } else { ?>
              <option value="OT"><?php echo $text_count; ?></option>
              <?php } ?>
              <?php if ($value['orderval'] == "OC") { ?>
              <option value="OC" selected="selected"><?php echo $text_computer; ?></option>
              <?php } else { ?>
              <option value="OC"><?php echo $text_computer; ?></option>
              <?php } ?>
              <?php if ($value['what']=="options"){ ?>
              <?php if ($value['orderval'] == "OP") { ?>
                  <option value="OP" selected="selected"><?php echo $opencart; ?></option>
                  <?php } else { ?>
                  <option value="OP"><?php echo $opencart; ?></option>
                  <?php } ?>
               <?php } ?>   
          
            </select></td>
          <td class="left"><?php foreach ($languages as $language) { ?>
            <select  name="select" id="select<?php echo $language; ?>" style="width: 150px" >
              <?php if ($value['values'][$language['language_id']]){ 

				      natsort($value['values'][$language['language_id']]);

					  foreach ($value['values'][$language['language_id']] as $valores_default){ ?>
              <option><?php echo trim($valores_default); ?></option>
              <?php } ?>
              <?php }else{ ?>
              <option> <?php echo sprintf($text_none,$value['what']);?></option>
              <?php } ?>
            </select>
            <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
            <?php } ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } ?>
  </form>
</div>
<script type="text/javascript"><!--
 $('a#editattribute').click(function() {

		 $.ajax({

			success :editsuccess,  // post-submit callback 

			url: "index.php?route=module/supercategorymenuadvanced/SetAllValues&token=<?php echo $this->session->data['token']; ?>",

			data: $('#formatt').serialize(),

			type: "POST",

			cache: true,

			error: function(xhr, ajaxOptions, thrownError){

			alert('responseText: \n' + thrownError +'.'); }

		});



	});

	function editsuccess(responseText, statusText, xhr){

		$("#notification2").html("<div class=\"success\" style=\"display:none;\"><?php echo $success; ?></div>");

   		$(".success").fadeIn("slow");

   		$('.success').delay(3500).fadeOut('slow');

	}







	$('a#editallcategories').click(function() {

		 $.ajax({

			success :editallsuccess,  // post-submit callback 

			url: "index.php?route=module/supercategorymenuadvanced/SetAllValuesCategories&token=<?php echo $this->session->data['token']; ?>",

			data: $('#formatt').serialize(),

			type: "POST",

			cache: true,

			error: function(xhr, ajaxOptions, thrownError){

			alert('responseText: \n' + thrownError +'.'); }

		});



	});

	function editallsuccess(responseText, statusText, xhr){

		$("#notification2").html("<div class=\"success\" style=\"display:none;\"><?php echo $success; ?></div>");

   		$(".success").fadeIn("slow");

   		$('.success').delay(3500).fadeOut('slow');

	}





$("img.tooltip").tooltip({

	track: true, 

    delay: 0, 

    showURL: false, 

    showBody: " - ", 

    fade: 250 

});







$('#tblattributes').delegate(':checkbox', 'change', function() {



	obj=$(this).closest('tr').find('input:text');

	obj2=$(this).closest('tr').find('select[name*="VALORES"]');   

   if (this.checked) {

       obj.removeAttr('disabled');

       obj2.removeAttr('disabled');

       obj.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555', });

	   obj2.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555', });



   } else {



	  obj.attr('disabled', true);

      obj2.attr('disabled', true);

      obj.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});

	  obj2.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});

        $(this).closest('tr').find('input:text:eq(0)').val('8');  

        $(this).closest('tr').find('input:text:eq(1)').val('0');  

        $(this).closest('tr').find('input:text:eq(3)').val('no');  



	  }



});



$(':checkbox').change(); //set initially



//--></script>
<?php } ?>
