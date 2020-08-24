<div class="footer">
	<div class="footerWrapper">
          <div class="fooLeft">        
            <?php
        		$langId = $this->config->get('config_language_id');
        		$welcome = $this->config->get('welcome_module'); 	
        		echo html_entity_decode($welcome[1]["description"][$langId]);
   			 ?>     
          </div>

        
       
         <div class="fooLinks">
         	  <p><?php echo $text_service; ?></p>	
              <ul>        
                <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
                <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>        
                <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
                <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
                <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              </ul>
         </div>
         
         <div class="fooLinks">
         	 <p><?php echo $text_information; ?></p>
             <ul>      
				  <?php $informations = $this->model_catalog_information->getInformations(); //Get Information Module
                        foreach($informations as $information): 
                  ?>
                        <li><a href="<?php echo $this->url->link('information/information', 'information_id=' . $information["information_id"]); ?>"><?php echo $information["title"]; ?></a></li>
                 <?php endforeach; //End Information Module ?>
   			</ul>     
         </div>
         
         <div class="fooLinks last">
         	  <p><?php echo $text_account; ?></p>
              <ul>        
                 <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
        		 <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
       			 <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
        		 <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
              </ul>
         </div>
         
         
         <div class="clear"></div>

   </div>
           
</div>
       <!-- 
    OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donatation.
    Please donate via PayPal to donate@opencart.com
    //-->
          <p class="powered">Copyright © 2013 Erikrende Bilişim, Tüm Hakları Saklıdır.</p>
       <!-- 
    OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donatation.
    Please donate via PayPal to donate@opencart.com
    //-->  

</body></html>