$(function(){
	//search
	var searchInput = $('.searchBox input');
	var value = searchInput.val();
	searchInput.click(function(){		
			$(this).val('');
	});
	searchInput.blur(function(){
		if($(this).val() == ""){
				$(this).val(value);
		}
	});
	//All Categories
	$(".categories > li").mouseenter(function(){
		$("ul.first").stop(true,true).slideDown('fast');
	}).mouseleave(function(){
		$("ul.first").stop(true,true).slideUp('fast');
	});		
});


$(function(){
	//Homepage Slideshow
	$('.slides').cycle({ 
		speed: 200, 
		timeout: 3000, 
		fx : 'scrollLeft',
		pager: '.slideTab', 
		pagerEvent: 'mouseover', 
		pause: 1 
	});	
	$('.slideTab a').wrap("<li></li>");
	$('.slides li').mouseenter(function(){
		$(this).find('p').stop(true,true).animate({bottom: '0px'},200);
	}).mouseleave(function(){
		$(this).find('p').stop(true,true).animate({bottom: '-36px'},200);
	});
});


$(function(){
	//Sidebar Categories
	$('li.parent').mouseenter(function(){
		$(this).find('ul').show();		
	}).mouseleave(function(){
		$(this).find('ul').hide();
	});
	
	$('.children').mouseenter(function(){
		$(this).parent().addClass('white');
	}).mouseleave(function(){
		$(this).parent().removeClass('white');
	});
});

$(function(){
	//Best Sellers
	$(".bestSeller li").mouseenter(function(){			
		$(this).find(".details").show();		
	}).mouseleave(function(){
		$(this).find(".details").hide();
	});
});


$(function(){
	//Product Tabs
	var li = $(".productTabs li");
		$(".tabWrapper").hide().first().show();
		li.click(function(){
			li.removeClass("active");
			var attr = $(this).attr("class");			
			$(this).addClass("active");
			$(".tabWrapper").hide();
			$("div."+attr).show();			
		});
	$("li a.reviews").click(function(){
		var attr = $(this).attr("class");		
		$(".productTabs li").removeClass("active");
		$(".productTabs li.reviews").addClass("active");
		$(".tabWrapper").hide();
		$("div."+attr).show();	
	});
});




$(function() {
	/* Search */
	$('.button-search').bind('click', function() {
		url = 'index.php?route=product/search';
		 
		var filter_name = $('input[name=\'search\']').attr('value')
		
		if (filter_name) {
			url += '&search=' + encodeURIComponent(filter_name);
		}
		
		location = url;
	});
	
	$('input[name=\'search\']').keydown(function(e) {
		if (e.keyCode == 13) {
			url = 'index.php?route=product/search';
			 
			var filter_name = $('input[name=\'search\']').attr('value')
			
			if (filter_name) {
				url += '&search=' + encodeURIComponent(filter_name);
			}
			
			location = url;
		}
	});
	
	
});

$('.success img, .warning img, .attention img, .information img').live('click', function() {
	$(this).parent().fadeOut('slow', function() {
		$(this).remove();
	});
});
$(function(){
	/* Ajax Cart */
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});	

});

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="attention" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.attention').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'fast'); 
				$("#cart").animate({opacity:0}, 400)
								.animate({opacity:1}, 400);

			}	
		}
	});
}
function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').after('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#wishlist-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
