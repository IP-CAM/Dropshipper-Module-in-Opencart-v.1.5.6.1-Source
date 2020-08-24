<?php if (!empty($values_no_selected)) { ?>
<?php foreach ($values_no_selected as $value_no_select) { ?>
<?php foreach ($value_no_select as $value_no_sel) { ?>
<?php if ($value_no_sel['view']=="list"){ $i=rand(50,150000);?>

<div id="search_container_<?php echo $i; ?>" >
  <ul>
    <?php if ($value_no_sel['searchinput']=="yes"){ ?>
    <input name="" type="text"  id="search<?php echo $i; ?>" class="search-box-bg"  onkeyup="refineResults(event,this,'search_container_<?php echo $i; ?>','#search_container_<?php echo $i; ?>')" value="<?php echo $search_in; ?>" onclick="this.value = '';" />
    <a href="javascript:void(0);" id="search_clear<?php echo $i; ?>" ></a>
    <?php } ?>
    <?php foreach ($value_no_sel['jurjur'] as $value){ 
      if($value['seleccionado']== "is_seleccionado") {
    
     $count=$count_products ? "&nbsp;<span class=\"product-count\">(". $value['total'] .")</span>" : "";
         
    ?>
    <li class="active"><em>&nbsp;</em><a class="link_filter_del smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?> ><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a><span><?php echo $value['name'];?><?php echo $count;?></span></li>
    <?php }else{ 
    
     ($count_products)? $count="&nbsp;<span class=\"product-count\">(". $value['total'] .")</span>" : $count="";
     ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";
    
    ?>
    <li><em>&nbsp;</em><a class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><?php echo $value['name'];?></a><?php echo $count; ?></li>
    <?php } ?>
    <?php } //end of is_seleccionado ?>
  </ul>
</div>
<?php }elseif ($value_no_sel['view']=="image") { ?>
<ul>
  <?php foreach ($value_no_sel['jurjur'] as $value){ ?>
  <?php if($value['seleccionado']== "is_seleccionado") {    
   ($count_products)? $count=" <span class=\"product-count\">(". $value['total'] .")</span>" : $count="";
   ($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";
  ?>
  <li class="active"> <img src="<?php echo $value['image_thumb'];?>" alt="<?php echo utf8_strtoupper($value['name']); ?>" width="20" height="20" align="absmiddle" class="picker"/> <a class="link_filter_del smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?> > <img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a> <span><?php echo $value['name'];?><?php echo $count; ?></span></li>
  <?php }else{ ?>
  <a class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" href="javascript:void(0)" <?php echo $nofollow; ?>><img class="picker" src="<?php echo $value['image_thumb'];?>" width="20" height="20" alt="<?php echo utf8_strtoupper($value['name']); ?>"/></a>
  <?php } ?>
  <?php } //end is_seleccionado ?>
</ul>
<?php }elseif ($value_no_sel['view']=="sele") { ?>
<?php foreach ($value_no_sel['jurjur'] as $value){  ?>
<?php   if($value['seleccionado']== "is_seleccionado") { ?>
<a class="link_filter_del smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'no'}" href="javascript:void(0)" <?php echo $nofollow; ?> ><img src="image/supermenu/spacer.gif" alt="<?php echo $remove_filter_text; ?>" class="filter_del" /></a>
<?php }?>
<?php }?>
<select class="smenu" style="width: 155px; margin-left:5px;">
  <?php foreach ($value_no_sel['jurjur'] as $value){  ?>
  <?php ($value['seleccionado']== "is_seleccionado")  ?  $selected="selected" : $selected="";  
 	($count_products)? $count="&nbsp;(". $value['total'] .")" : $count="";
   	($track_google) ? $gap=trim($value_no_sel['name'])."@@@@@@".trim($value['name']) : $gap="no";  ?>
  <option class="smenu {dnd:'<?php echo $value['href'];?>', ajaxurl:'<?php echo $value['ajax_url'];?>', gapush:'<?php echo $gap; ?>'}" <?php echo $selected; ?> ><?php echo $value['name'];?><?php echo $count; ?></option>
  <?php } ?>
</select>
<?php }  ?>
<?php } ?>
<?php } ?>
<?php } ?>
