<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title>Super Category Menu</title>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.6.1.min.js"></script>
</head>
<body>
<div id="response_build" style="width:400px;margin:0 auto; text-align: center;"></div>
<div id="response_success" style="display:none;margin:0 auto;">
<div class="heading"><div class="buttons"><a onclick="parent.$.fancybox.close();" class="button"><span><?php echo $button_close; ?></span></a></div></div>
<div class="box2">
 <table width="400px" border="0" cellpadding="2" class="list">
   <tr>
    <td class="left"><div class="success"><div id="response_build2"></div></div></td>
    </tr>
 </table>
</div>
</div>
<div class="box">
   <table width="400px" border="0" cellpadding="2" class="list">
     <tr>
       <td class="left"><div class="attention"><?php echo $text_cache_build_remenber; ?></div></td>
     </tr>
    </tbody>
   </table>
  <div class="heading">
  <div class="buttons">
     <?php if (!$success) { ?>
       <a onclick="location = '<?php echo $action_build_cache; ?>'" class="button"><span><?php echo $button_build; ?></span></a>
       <a id="automatic"  class="button" href="javascript:void(0)" category_id="<?php echo $category; ?>" ><span><?php echo $button_build_automatic; ?></span></a>
     <?php } ?>
    	<a onclick="parent.$.fancybox.close();" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>  
</div>
<script>
  	$('a#automatic').click(function() {
    	var id = $(this).attr("category_id"); 
	   	$.ajax({  
			beforeSend: function() {
			$('.box').remove();
			$('#response_build').html('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span> Building cache, please wait...');
			},	
			complete: function() { $('#response_build').remove();	},
			success:showResponsebuildcache,  // post-submit callback 
			url: 'index.php?route=module/supercategorymenuadvanced/BuildingCache',
			data: 'token=<?php echo $this->session->data['token']; ?>&automatic=1&path='+id,
			type: "GET",
			cache: true,
			error: function(ERROR){
			alert('responseText: \n' + ERROR +'.'); }
		});

		return false;		
		});

	function showResponsebuildcache(responseText, statusText, xhr)  { 
          $("#response_success").fadeIn(100, function () {
          $("#response_build2").html('');
          $("#response_build2").html(responseText).fadeIn(1000);
    });
	}
</script>
</body></html>