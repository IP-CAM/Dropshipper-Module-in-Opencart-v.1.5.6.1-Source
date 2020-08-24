if(change_option_image_hover){

	$('.option-value-image').hover(function(){
 
    var option_image = $(this).attr('rel');
  
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
  });
  
  
  

	$('.option-image-select > option').hover(function(){
 
    var option_image = $(this).attr('rel');
  
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
  });
  
  
  
  
  
	$('.option input').hover(function(){
 
    var option_image = $(this).attr('rel');
    
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
    
  });




	$('.option label').hover(function(){
 
    var option_image = $(this).attr('rel');
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
    
  });

  
  
  
  
  
  
  
}












if(change_option_image_select){
$(".option").keyup(function() {
  $(".option-image-select option:selected" ).each(function() {
    var option_image = $(this).attr('rel');
    
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
  });
});


$(".option select").keyup(function() {
  $(".option-image-select option:selected" ).each(function() {
    var option_image = $(this).attr('rel');
    
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
  });
});




$(".option select").click(function() {
  $(".option-image-select option:selected" ).each(function() {
    var option_image = $(this).attr('rel');
    
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
  });
});







	$('.options input').click(function(){
 
    var option_image = $(this).attr('rel');
    var image_thumb = default_image_thumb;
    var image_popup = default_image_popup;
    
    
    if(option_image){
      var option_image_split = option_image.split("|||");
      
      var option_image_thumb = option_image_split[0];
      var option_image_popup = option_image_split[1];
    
      if(option_image_thumb != "" && option_image_popup != ""){
        image_thumb = option_image_thumb;
        image_popup = option_image_popup;
      }
    }
    
    $(".left .image > a").prop("href",image_popup);
    $("#image").prop("src",image_thumb);
    
  });



}