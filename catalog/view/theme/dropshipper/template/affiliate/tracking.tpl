<?php echo $header; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
 <div class="accountWrap">
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_description; ?></p>
  <p><?php echo $text_code; ?><br />
    <textarea cols="40" rows="5"><?php echo $code; ?></textarea>
  </p>
  <p><?php echo $text_generator; ?><br />
    <input type="text" name="product" value="" />
  </p>
  <p><?php echo $text_link; ?><br />
    <textarea name="link" cols="40" rows="5"></textarea>
  </p>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>
    </div>
    <?php echo $column_right; ?>
    <div class="clear"></div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=affiliate/tracking/autocomplete',
			type: 'POST',
			dataType: 'json',
			data: 'filter_name=' +  encodeURIComponent(request.term),
			success: function(data) {		
				response($.map(data, function(item) {
					return {
						label: item.name,
						value: item.link
					}
				}));
			}
		});
		
	},
	select: function(event, ui) {
		$('input[name=\'product\']').attr('value', ui.item.label);
		$('textarea[name=\'link\']').attr('value', ui.item.value);
						
		return false;
	}
});
//--></script> 
<?php echo $footer; ?>