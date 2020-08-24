<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Super Category Menu</title>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" href="view/javascript/jquery/supermenu/supermenu.css">
</head>
<body>
<div class="box">
  <div class="heading">
    <div style="float:left;padding-top: 12px;"><strong><?php echo $entry_cache_manual_list; ?></strong> </div>
    <div class="buttons"><a onclick="parent.$.fancybox.close();" class="button"><span><?php echo $button_close; ?></span></a></div>
  </div>
  <table width="800px" border="0" cellpadding="2" class="list">
    <div id="menuscm">
      <?php $i=1; ?>
      <div class="box">
        <div id="filter_box" class="p_rel" style="width:200px;">
          <?php if ($values_selected) { ?>
          <?php foreach ($values_selected as $value_selected) { 
    		 $i==1 ? $liclass="first upper" : $liclass="upper";
  			 ?>
          <dl class="filters">
            <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_selected['dnd']; ?></span></dt>
            <dd class="page_preload">
              <ul>
                <li class="active"><em>&nbsp;</em> <a class="link_filter_del smenu"
              href="<?php echo $value_selected['href'];?>"  > <img src="view/javascript/jquery/supermenu/images/spacer.gif" class="filter_del" /> </a> <span><?php echo $value_selected['name'];?> </span></li>
              </ul>
            </dd>
          </dl>
          <?php $i++;  } ?>
          <?php } ?>
          <?php

    if (!empty($values_no_selected)) { ?>
          <?php foreach ($values_no_selected as $value_no_select) { ?>
          <?php foreach ($value_no_select as $value_no_sel) { ?>
          <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
          <?php if ($value_no_sel['total']==1){//dont show select option. 
            	 $value_no_sel['jurjur']=array_values ( $value_no_sel['jurjur']); 
             ?>
          <dl id="filter_p<?php echo $i; ?>" class="filters ">
            <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span></dt>
            <dd class="page_preload">
              <?php if($count_products) {?>
              <span class="seleccionado"><em>&nbsp;</em><?php echo $value_no_sel['jurjur'][0]['name'];?> (<?php echo $value_no_sel['jurjur'][0]['total'];?>)</span>
              <?php }else{ ?>
              <span class="seleccionado"><em>&nbsp;</em><?php echo $value_no_sel['jurjur'][0]['name'];?></span>
              <?php } ?>
            </dd>
          </dl>
          <?php   }else{ ?>
          <dl id="filter_p<?php echo $i; ?>" class="filters ">
            <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span></dt>
            <dd class="page_preload">
              <ul>
                <?php foreach ($value_no_sel['jurjur'] as $value){ ?>
                <li><em>&nbsp;</em> <a href="<?php echo $value['href'];?>" > <?php echo $value['name'];?> </a> (<?php echo $value['total'];?>)</li>
                <?php } ?>
              </ul>
            </dd>
          </dl>
          <?php } ?>
          <?php   $i++; } //if ($value_no_sel['total']=1  ?>
          <?php } ?>
          <?php } ?>
          <dl class="filters">
            <dt class="last"><span>&nbsp;</span></dt>
          </dl>
        </div>
        <br>
      </div>
    </div>
    <script type="text/javascript" src="view/javascript/jquery/supermenu/supermenu_base.js"></script>
  </table>
</div>
</body>
</html>