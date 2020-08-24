<?php  
class ControllerModuleSuperCategoryMenuAdvanced extends Controller {
	
	protected function index() { 
		
    	$this->language->load('module/supercategorymenuadvanced');
		
		$DIR_MY_STYLES_2='catalog/view/javascript/jquery/supermenu/templates/';
		
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
		//variable with enable/disable count.
		if (isset($settings_module['styles'])){
			$template_styles=$settings_module['styles'];
		}else{
			$template_styles='default';
		} 
			
		$this->document->addScript('catalog/view/javascript/jquery/supermenu/supermenu_base.js');
			
		if (file_exists($DIR_MY_STYLES_2 . $template_styles . '/supermenu.css')) {
			$this->document->addStyle($DIR_MY_STYLES_2 . $template_styles . '/supermenu.css');
		} else {
			$this->document->addStyle($DIR_MY_STYLES_2 . 'default/supermenu.css');
		}
		   
	   if (isset($this->request->get['path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = array_pop($parts);
			$this->WithCategories($category_id);
		}else{
			$category_id = 0;
			$this->WithCategories($category_id);
		}
		
		if (isset($settings_module['template_menu'])){
			$template_menu=$settings_module['template_menu'];
		}else{
			$template_menu='supercategorymenuadvanced.tpl';
		}
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/supercategorymenu/templates/'.$template_menu)) {
				$this->template = $this->config->get('config_template') . '/template/module/supercategorymenu/templates/'.$template_menu;
		} else {
				$this->template = 'default/template/module/supercategorymenu/templates/'.$template_menu;
		}
				$this->response->setOutput($this->render());
			
	}
	
	public function MenuAjax() {
		
    	$this->language->load('module/supercategorymenuadvanced');
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
	   if (isset($this->request->get['path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = array_pop($parts);
			$this->WithCategories($category_id);
		}else{
			$category_id = 0;
			$this->WithCategories($category_id);
			
		}
		
		if (isset($settings_module['template_menu'])){
			$template_menu=$settings_module['template_menu'];
		}else{
			$template_menu='supercategorymenuadvanced.tpl';
		}
		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/supercategorymenu/templates/'.$template_menu)) {
				$this->template = $this->config->get('config_template') . '/template/module/supercategorymenu/templates/'.$template_menu;
		} else {
				$this->template = 'default/template/module/supercategorymenu/templates/'.$template_menu;
		}
				
				$this->response->setOutput($this->render());
			
		
	}

		
	public function WithCategories($category_id) {
			
		//Load filter settings.
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
		//var to set speed to fade menu
		if (isset($settings_module['ajax']['speedmenu'])){
			$this->data['speedmenu']=$settings_module['ajax']['speedmenu'];
		}else{
			$this->data['speedmenu']=2000;
		}
		//var to set speed to fade results
		if (isset($settings_module['ajax']['speedresults'])){
			$this->data['speedresults']=$settings_module['ajax']['speedresults'];
		}else{
			$this->data['speedresults']=2000;
		}
		
		//variable with enable/disable count.
		if (isset($settings_module['see_more_trigger'])){
			$this->data['see_more_trigger']=$settings_module['see_more_trigger'];
		}else{
			$this->data['see_more_trigger']=0;
		}
		//variable with enable/disable count.
		if (isset($settings_module['countp'])){
			$this->data['count_products']=$settings_module['countp'];
		}else{
			$this->data['count_products']=1;
		}
		//variable with enable/disable follow.
		if (isset($settings_module['nofollow'])){
			$this->data['nofollow']='rel="nofollow"';
		}else{
			$this->data['nofollow']='';
		}
		//variable with enable/disable tracking.
		if (isset($settings_module['track_google'])){
			$this->data['track_google']=$settings_module['track_google'];
		}else{
			$this->data['track_google']=0;
		}
		//variable with enable/disable ajax.		
		if (isset($settings_module['ajax']['ajax'])){
			$this->data['is_ajax']=$settings_module['ajax']['ajax'];
		}else{
			$this->data['is_ajax']=0;
		}
		
		if (isset($settings_module['menu_filters'])){
			$this->data['menu_filters']=$settings_module['menu_filters'];
		}else{
			$this->data['menu_filters']=1;
		}
		
		if(version_compare(VERSION,'1.5.5','>')) {
		    
			if (isset($this->request->get['search'])) {
				$filter_name = $this->request->get['search'];
			} else {
				$filter_name = '';
			} 
		
		}else{
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			} 
			
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['filter_name'])) {
			$filter_tag = $this->request->get['filter_name'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		} 
				
		if (isset($this->request->get['filter_category_id'])) {
			
			if ($category_id==0){
				$category_id = $this->request->get['filter_category_id'];
			}
		} else {
			$filter_category_id = false;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
		} 
	
		$url_pr='';
		if (isset($this->request->get['PRICERANGE'])) {
			$url_pr.= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		}
		
		if (isset($this->request->get['C'])) {
			$url_pr.= '&amp;C=' . $this->request->get['C'];
		} 
	
		//searh url filters
		$url_search='';
		
		
		
		if(version_compare(VERSION,'1.5.5','>')) {
			if (isset($this->request->get['search'])) {
				$url_search .= '&amp;search=' . $this->request->get['search'];
			}
		
		}else{
			if (isset($this->request->get['filter_name'])) {
			$url_search .= '&amp;filter_name=' . $this->request->get['filter_name'];
		    }
			
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$url_search .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
		}
				
		if (isset($this->request->get['filter_description'])) {
			$url_search .= '&amp;filter_description=' . $this->request->get['filter_description'];
		}
						
		if (isset($this->request->get['filter_category_id'])) {
			$url_search .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_sub_category'])) {
			$url_search .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
		}
		
		if (!isset($this->request->get['path']) or empty($this->request->get['path'])) {
			
			if (isset($this->request->get['filter_category_id'])) {
			
				$this->request->get['path']=$this->request->get['filter_category_id'];
			}else{
				$this->request->get['path']=0;
			}
		}
	
		$url_limits='';
	
		if (isset($this->request->get['sort'])) {
			$url_limits.= '&amp;sort=' . $this->request->get['sort'];
		}	
		if (isset($this->request->get['order'])) {
			$url_limits.= '&amp;order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['limit'])) {
			$url_limits.= '&amp;limit=' . $this->request->get['limit'];
		}

	
		//arrays with all values to construct the menu.-
		$this->data['values_selected'] = array();
		$this->data['values_no_selected'] = array();
		$this->data['categories']='';
			
		
		//load some language
		$this->language->load('module/supercategorymenuadvanced');
		
    	$this->data['heading_title'] 		= $this->language->get('heading_title');
		$this->data['see_more_text'] 		= $this->language->get('see_more_text');
		$this->data['remove_filter_text'] 	= $this->language->get('remove_filter_text');
		$this->data['pricerange_text'] 		= $this->language->get('pricerange_text');
		$this->data['no_data_text'] 		= $this->language->get('no_data_text');
		$this->data['manufacturer_text'] 	= $this->language->get('manufacturer_text');
		$this->data['category_text'] 		= $this->language->get('category_text');
		$this->data['search_in'] 			= $this->language->get('search_in');
	    $this->data['search_filter_text'] 	= $this->language->get('search_filter_text');
		$this->data['entry_selected'] 		= $this->language->get('entry_selected');
		$this->data['entry_select_filter'] 	= $this->language->get('entry_select_filter');
	    $this->data['txt_select_on_select'] = $this->language->get('txt_select_on_select');

		
		(isset($settings_module['category']['style'])) ? $this->data['category_style']="_".$settings_module['category']['style'] : $this->data['category_style']='';
 
	    $manufacturer_text= $this->language->get('manufacturer_text');
		$stock_text= $this->language->get('stock_text');	
		
		$this->load->model('module/supercategorymenuadvanced');
		
		//init filters
		$filter = false;
		$filter_manufacturers_by_id='';
		$filter_manufacturers_by_id_string='';
		$filter_attributes_by_name='';
		$filter_attribute_id='';
		$filter_options_by_name='';
		$filter_option_id='';
		$filter_attribute_string='';
		$filter_min_price='';
		$filter_max_price='';
		$filter_stock_id='';
		$filter_by_name='';
		$filter_ids='';
		
		$filter_stock='';
		$filter_special=''; 
		$filter_clearance='';
		$filter_arrivals='';
		
		$this->data['isset_subcategories']=false;
		$this->data['price_range_is_not_selected']=true;
		$this->data['price_range_script']=true;
	
		//fix problem with 
		
		
		
		//BEGIN CHECKING FILTERS
		$filtros_seleccionados= array();
			
		if (!empty($this->request->get['filter'])){
		  $url_filter=$this->request->get['filter'];
		}else{
		  $url_filter='';	
		}
		//FILTER
			
			if (!empty($this->request->get['filter'])){//fix problem with filter=empty
				
				//$filtros = explode("@@",urldecode($url_filter));
				$filtros = explode("@@",$this->request->get['filter']);
				$filter=true;
				
				foreach ($filtros as $filtro){
						//fix filter string for href[first_position-Second position - only this filter]
						$arr=array();
						$arr = array_diff($filtros,(array)$filtro);
						$links=implode ("@@",$arr);
										
						list($tipo,$name,$id,$dnd)=explode("=",$filtro);
						
						if (strpos($name, "SPER")){	$namev=substr($name,0,-4);}else{$namev=$name;}
							if (strpos($tipo, "ig")){$tipo=substr($tipo,0,-2);			
								$image=$this->model_module_supercategorymenuadvanced->getoptionImage($id,$name);
							}else{$tipo=$tipo;$image='';}
						
						$namefinal=html_entity_decode($namev)=="NDDDDDN" ? html_entity_decode($this->data['no_data_text']): html_entity_decode($namev);
				        
						if($links){
						    $urlfilter='&amp;filter='.urlencode(str_replace("&amp;","&",$links));
						}else{
						    $urlfilter='&amp;filter=';
						}		
						
						
						$see_more_url='index.php?route=module/supercategorymenuadvancedseemore/seemore&amp;path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;id='.urlencode($id).'&amp;dnd='.urlencode($dnd).'&amp;tipo='.urlencode($tipo)."&amp;name=".urlencode($namefinal).$urlfilter;
						
						switch($tipo) {
							case 'ATTRIBU':
								$filter_attributes_by_name.=$name."ATTNNATT";		
								$filter_attribute_id.=$id.",";	
								$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."ATTNNATT@@@";
								$filter_ids.=$id.",";
								break;
							case 'MANUFFUNAM':
								$filter_manufacturers_by_id=$id;
								break;
							case 'STOCKKCOTS':
								$filter_stock_id=$id;
								break;
							case 'OPTION':
								$filter_options_by_name.=$name."OPTTOP";		
								$filter_option_id.=$id.",";	
								$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."OPTTOP@@@";
								$filter_ids.=$id.",";
								break;
					    	case 'STOCKCLEARANCE':
								$filter_clearance=true;
								$namefinal=$this->language->get('clearance_text');
								$dnd=$this->language->get('stock_text');
								$see_more_url=false;
								break;	
							case 'STOCKNEW':
								$filter_arrivals=true;
								$namefinal=$this->language->get('new_products_text');
								$dnd=$this->language->get('stock_text');
								$see_more_url=false;
								break;	
							case 'STOCKSPECIAL':
								$filter_special=true;
								$namefinal= $this->language->get('special_prices_text');
								$dnd=$this->language->get('stock_text');
								$see_more_url=false;
								break;	
							case 'STOCKS':
								$filter_stock=true;
								$namefinal=$this->language->get('in_stock_text');
								$dnd=$this->language->get('stock_text');
								$see_more_url=false;
								break;	
						}
							
							$filtros_seleccionados[]=array(
								'Tipo' 		   => $tipo,
								'name'		   => html_entity_decode($namefinal),
								'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$urlfilter),
								'ajax_url'	   => 'path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$urlfilter,
								'see_more'	   => $see_more_url,
								'dnd'		   => $dnd,
								'image'		   => $image,
								
						);
				
				
					unset($filtro);
				
				}//end foreach $filtros
		
		}//End FILTER
	
		
		
		
		/////////////////////////////////////////////////////////////
		// 
		//   SEARCH BOX
		////////////////////////////////////////////////////////////
		if ($filter_name){// show search box

			if (!empty($this->request->get['filter'])){
				//$url_filter=$this->request->get['filter'];
				//$urlfilter2='&filter='.$this->request->get['filter'];
			     $urlfilter2='&amp;filter='.urlencode(str_replace("&amp;","&",$this->request->get['filter']));
			     $filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$urlfilter2;
				$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$urlfilter2;
			
			}else{
				//$url_filter='';	
				$urlfilter2='&amp;filter=';
				$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$urlfilter2;
				$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$urlfilter2;
				
			}
			//remove filter_name from string.
            
			$filtros_seleccionados[]=array( 
			    	'Tipo' 		   => "Search",
					'name'		   => html_entity_decode($filter_name),
					'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'ajax_url'	   => $ajax_url,					
					'see_more'	   => false,
					'dnd'		   => $this->language->get('search_filter_text'),
					'image'		   => '',
			);

}			
					
			
		//set all values selected.

		if (!$settings_module['menu_filters']){ // REMOVE FILTERS CHECKED ON MENU EXCEPT PRICE RANGE.
			$this->data['values_selected']='';
			$filtros_seleccionados=array(); //reset array
		}
	    
		if (!empty($this->request->get['filter']) and $this->request->get['filter']!=""){
			
			$url_filter=$this->request->get['filter'];
			$min_urls = explode("@@",str_replace("&amp;","&",$url_filter));
		
			$url_filter=array();
			foreach ($min_urls as $min_url){
		
				list($tipo,$name,$id,$dnd)=explode("=",$min_url);
					
					$url_filter[]=urlencode($tipo) ."=". urlencode($name) ."=". urlencode($id) ."=". urlencode($dnd);
					
			}
			$url_filter=implode("@@",$url_filter);
			
		}else{
			$url_filter='&amp;filter=';	
			
		}
		
		//fix problem with product/special
		if (isset($this->request->get['route']) && $this->request->get['route']=="product/special"){
		
		    $filter_special=true;
		
			if ($filter){  
				$url_filter.="@@STOCKSPECIAL=a=b=c";
			}else{
				$url_filter="STOCKSPECIAL=a=b=c";
			}
			 
			$filter=true;
			
		}
		
		
		
		
		//PRICE RANGE
			if (isset($this->request->get['PRICERANGE']) and !empty($this->request->get['PRICERANGE'])) {
					list($filter_min_price,$filter_max_price)=explode("MPRM",$this->request->get['PRICERANGE']);
					
					$SymbolLeft=$this->currency->getSymbolLeft();
					$SymbolRight=$this->currency->getSymbolRight();
					
					$txt_price_rage_selected=$SymbolLeft.$filter_min_price.$SymbolRight." - ".$SymbolLeft.$filter_max_price.$SymbolRight;
					
					
				   //remove currency from price
					$filter_min_price=floor($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_min_price,$this->request->get['C'])); 
					$filter_max_price=ceil($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_max_price,$this->request->get['C']));
				  
				  //remove tax from price
				   if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					    $tax_value= $this->tax->calculate(1, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
						$filter_min_price=floor( $filter_min_price/$tax_value ); 
						$filter_max_price=ceil( $filter_max_price/$tax_value );
				   }
				   
				
					$filtros_seleccionados[]=array(
							'Tipo' 		   => "PRICERANGE",
							'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_search.'&filter='.$url_filter.$url_limits),
							'ajax_url'	   => 'path='.$this->request->get['path'].$url_search.'&filter='.$url_filter.$url_limits,
							//'href'		   => $this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_search.'&amp;filter='.str_replace("&amp;","&",$url_filter),
							//'ajax_url'	   => 'path='.$this->request->get['path'].'&amp;filter='.$url_filter,
							//'ajax_url'	   => 'path='.$this->request->get['path'].$url_search.'&amp;filter='.str_replace("&amp;","&",$url_filter),
							'dnd'		   => $this->language->get('pricerange_text'),
							'name'		   => $txt_price_rage_selected
					);
					//flag for show PRICE RANGE
					$this->data['price_range_is_not_selected']=false;
			
			} //END PRICE RANGE 
		
		
			$this->data['values_selected']=$filtros_seleccionados;
			
		//////////////////////////////////////////////////////////////
		
		/* SECOND PART*/
		/////////////////////////////////////////////////////////////
		
		//array with filters to search in database.
	
		$data_filter = array(
				'filter_manufacturers_by_id'=> $filter_manufacturers_by_id, 
				'filter_min_price'  		=> $filter_min_price,
				'filter_max_price'  	 	=> $filter_max_price, 
				'filter_category_id'    	=> $category_id, 
				'filter_stock_id'    	    => $filter_stock_id, 
				'filter_by_name' 			=> substr($filter_by_name,0,-3),
				'filter_ids'				=> substr($filter_ids,0,-1),
				'filter_name'         		=> $filter_name, 
				'filter_tag'          		=> $filter_tag, 
				'filter_description'  		=> $filter_description,
				'filter_sub_category' 		=> $filter_sub_category, 
				'filter_stock'				=> $filter_stock,
				'filter_special'			=> $filter_special, 
				'filter_clearance'			=> $filter_clearance,
				'filter_arrivals'			=> $filter_arrivals
			);
			

		//List of products filtered
		$productos_filtrados= $this->model_module_supercategorymenuadvanced->getProductsFiltered($data_filter,$settings_module['stock']['clearance_value'],$settings_module['stock']['number_day']);
		

    	if (!empty($productos_filtrados)){//we have products
			
			/////////////////////////////////////
			//SUBCATEGORIES.-
			////////////////////////////////////
			
			if ($settings_module['category']['category']){ //exist and enable

				$this->data['values_no_selected_categories']=array();
				$this->data['values_selected_categories']=array();
				$this->data['isset_subcategories']=1;
			
				$subsubcategories = array();
			
				$results = $this->model_module_supercategorymenuadvanced->getCategoriesFiltered($productos_filtrados,$data_filter);
			
				if (!empty($this->request->get['path'])){
					
					$previo_path=$this->request->get['path'] . '_' ;
				}else{
					$previo_path='';
				}
			
			if (!empty($results)){//No more categories in this navigation.
			
			
				foreach ($results as $result) {
					
				 //  if ($filter){																																
					//		$url=$this->url->link('product/asearch', 'path='. $previo_path . $result['category_id']) .$url_pr.$url_limits.$url_search. '&amp;filter='.$url_filter;
						//	$url_ajax='path='. $previo_path  . $result['category_id'] .$url_pr.$url_limits.$url_search. '&amp;filter='.$url_filter;
				   //}else{
							$url=$this->url->link('product/asearch', 'path='. $previo_path  . $result['category_id']).$url_pr.$url_limits.$url_search;
							$url_ajax='path='. $previo_path . $result['category_id'].$url_pr.$url_limits.$url_search;
				   //}
					
					$subsubcategories["str".$result['name']] = array(
						'category_id'	=> $result['category_id'],
						'name'  		=> $result['name'],
						'href'          => $this->model_module_supercategorymenuadvanced->SeoFix($url),
						'ajax_url'	    => $this->model_module_supercategorymenuadvanced->SeoFix($url_ajax),
						'total'			=> $result['total']
						);
				}
			
			 	$sort_order=array();
				
					if ($settings_module['category']['order']=="OT"){
				     //get total values.
						 foreach ($subsubcategories as $key => $value) {
               			 $sort_order[] = $value['total'];
               			 }
                		 array_multisort($sort_order,SORT_DESC,$subsubcategories);   
				
					}elseif ($settings_module['category']['order']=="OH"){
					//get names values.
						foreach ($subsubcategories as $key => $value) {
						$sort_order["str".$value['name']] = $value['name'];
						}
				  
						  natsort($sort_order);
				  
				 		 $subsubcategories= array_merge($sort_order,$subsubcategories);   
					}else{//opencart order.
						$subsubcategories=$subsubcategories;
						
					}
			
			
				$subcategories[] = array(
						'name'    	     => $this->data['category_text'],
						'total'		     => count($subsubcategories),
						'jurjur'    	 => $subsubcategories,
						'Tipo'			 => "CATEGORY",
						'list_number' 	 => $settings_module['category']['list_number'],
						'order'			 => $settings_module['category']['order'],
						'sort_order'	 => $settings_module['category']['category'],
						'view'			 => $settings_module['category']['view'],
						'initval'		 => isset($settings_module['category']['initval']) ? $settings_module['category']['initval'] : "opened"
				);
						
			    //SET Subcategories
				$this->data['values_no_selected_categories']=$subcategories;
			
			
			}//no empty(results)
			
			
			if (!empty($this->request->get['path']) and $this->request->get['path']!=""){
		
		       $paths = explode("_",urldecode($this->request->get['path']));
		
				$categories_nav=array();
				$w=0;
				
				foreach ($paths as $path){
					$arr=array_slice($paths,0,$w);
					$w==0 ? $path_links='':$path_links=implode ("_",$arr);
					
					if ($path!=0){
						$categories_nav[]=array(
							'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$path_links)),
							'name' 		   => $this->model_module_supercategorymenuadvanced->getCategoryName($path),
							'ajax_url'	   => $this->model_module_supercategorymenuadvanced->SeoFix('path='.$path_links),
					);
					$w++;			
					}
			 	}
				$this->data['values_selected_categories'] = $categories_nav;
			}
			
						
			}else{ //subcategories not enable
			$this->data['isset_subcategories']=0;
			}		

			//////////////////////////////
			//PRICE RANGE
			/////////////////////////////
		
			//check if we set price range, for admin configuration and module configuration
			if (($this->config->get('config_customer_price') && $this->customer->isLogged() && $settings_module['pricerange']['pricerange']) || !$this->config->get('config_customer_price') && $settings_module['pricerange']['pricerange']) {		
				
				$price_range_init= isset($settings_module['pricerange']['initval']) ? $settings_module['pricerange']['initval'] : "opened";
				$prices_min_max=$this->model_module_supercategorymenuadvanced->getProductsPriceandSpecial($productos_filtrados,$data_filter);
				
				$max_price=$prices_min_max['PriceMax'];
				$min_price=$prices_min_max['PriceMin'];
			    
				// check price with vat or not
				
				if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					$max_price =$this->tax->calculate($max_price, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
					$min_price =$this->tax->calculate($min_price, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
				}
				
				$this->data['MaxPrice']= ceil($this->model_module_supercategorymenuadvanced->formatMoney($max_price));
				$this->data['MinPrice']= floor($this->model_module_supercategorymenuadvanced->formatMoney($min_price));
				
			    $this->data['intivalprice']=$settings_module['pricerange']['initval'];
				$this->data['SymbolLeft']=$this->currency->getSymbolLeft();
				$this->data['SymbolRight']=$this->currency->getSymbolRight();
				$this->data['price_view']=$settings_module['pricerange']['view'];
				$this->data['Currency']= isset($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
							
				   if ($filter){																																
						$this->data['PriceUrl']=$this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_search.$url_limits.'&amp;filter='.$url_filter);
						$this->data['PriceAjaxUrl']='path='.$this->request->get['path'].$url_search.$url_limits.'&amp;filter='.$url_filter;
					}else{
						$this->data['PriceUrl']=$this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path'].$url_limits));
						$this->data['PriceAjaxUrl']='path='.$this->request->get['path'].$url_search.$url_limits;
					}
			    
					
				if($settings_module['pricerange']['view']=="slider"){
					 	$this->data['steps']=$settings_module['pricerange']['steps'];
				    	$price_diff=$this->data['MaxPrice']-$this->data['MinPrice'];
					
						if (100000 >= $price_diff && $price_diff >10000){
							$this->data['step']=$settings_module['pricerange']['steps']['0'];
						}elseif (10000 >= $price_diff && $price_diff >1000){
							$this->data['step']=$settings_module['pricerange']['steps']['1'];					
						}elseif (1000 >= $price_diff && $price_diff >100){	
							$this->data['step']=$settings_module['pricerange']['steps']['2'];				
						}elseif (100 >= $price_diff && $price_diff >10){	
							$this->data['step']=$settings_module['pricerange']['steps']['3'];	
						}else{
							$this->data['step']=$settings_module['pricerange']['steps']['4'];	
						}
					
				}else{
					
					//count($productos_filtrados) < 5 ? $cuantos=count($productos_filtrados) : 
					$cuantos=5;
					$this->data['array_prices_values']=$this->model_module_supercategorymenuadvanced->getRanges($this->data['MinPrice'],$this->data['MaxPrice'],$cuantos,$prices_min_max,$productos_filtrados,$this->data['Currency'],$settings_module['pricerange']['setvat'],$settings_module['pricerange']['tax_class_id']);
					
				    $this->data['price_range_script']=false;
				}
			
				
			}else{
				
				//Don't show PRICE RANGE
				$this->data['price_range_is_not_selected']=false;
				$this->data['price_range_script']=false;
			} //End price range
			
			
			/////////////////////////////////////
			//MANUFACTURES.-
			////////////////////////////////////
			
			
			//check admin configuration
			if ($settings_module['manufacturer']['manufacturer'] && !$filter_manufacturers_by_id ){
				
				$manufactures = array();
				$results = $this->model_module_supercategorymenuadvanced->getManufacturesFiltered($productos_filtrados,$data_filter);
				
				if(!empty($results)){
					
					foreach ($results as $result) {
							if ($filter){																																
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);
								
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);
								
								
							}else{
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);

							
							
							}
						$manufactures_final["str".$result['name']] = array(
							'manufacturer_id'=> $result['manufacturer_id'],
							'name'    	     => $result['name'],
							'total'		     => $result['total'],
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "MANUFACTURER"
							
						);
						
					}
		

		        $sort_order=array();
				
				if ($settings_module['manufacturer']['order']=="OT"){
				     //get total values.
					 foreach ($manufactures_final as $key => $value) {
               			 $sort_order[] = $value['total'];
               		 }
                	array_multisort($sort_order,SORT_DESC,$manufactures_final);   
				
				}elseif($settings_module['manufacturer']['order']=="OH"){
					//get names values.
					foreach ($manufactures_final as $key => $value) {
						$sort_order["str".$value['name']] = $value['name'];
					}
				  
				  natsort($sort_order);
				  
				  $manufactures_final= array_merge($sort_order,$manufactures_final);   
				}else{//opencart order.
						$manufactures_final=$manufactures_final;
						
				}
			
				
				
				$manufactures[] = array(
						'name'    	     => $manufacturer_text,
						'total'		     => count($manufactures_final),
						'jurjur'    	 => $manufactures_final,
						'list_number' 	 => $settings_module['manufacturer']['list_number'],
				        'order'			 => $settings_module['manufacturer']['order'],
					    //'sort_order'	 => $settings_module['manufacturer']['sort_order'],
					    'view'			 => $settings_module['manufacturer']['view'],
						'initval'	     => isset($settings_module['manufacturer']['initval']) ? $settings_module['manufacturer']['initval']  : "opened",
						'searchinput'    => isset($settings_module['manufacturer']['searchinput']) ? $settings_module['manufacturer']['searchinput'] : "no",
						
				);
						
			    //SET Manufacturers
				$this->data['values_no_selected'][]=$manufactures;
						
				}// end !empty results
				
			}// end if ($settings_module["manufacturer"] && !$filter_manufacturers_by_id ){
			
			/////////////////////////////////////
			// STOCK FILTER.-
			////////////////////////////////////
			$stockstatuses_final=array();
			
			// 1.- PRODUCTS IN STOCK
				if($settings_module['stock']['stock'] && !$filter_stock){
					$results = $this->model_module_supercategorymenuadvanced->getStocksInStock($productos_filtrados,$data_filter);
					if ($filter){																																
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKS=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKS=a=b=c';
						}else{
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter=STOCKS=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter=STOCKS=a=b=c';
					}
					if ($results!="no_stock"){
						$stockstatuses_final["no_stock" && $results>0] = array(
							'stock_id'		 => "stock",
							'name'    	     => $this->language->get('in_stock_text'),
							'total'		     => $results,
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "STOCKS"							
						);
					}
				}

		       //add special to stock filter
				if($settings_module['stock']['special'] && !$filter_special){
					$results = $this->model_module_supercategorymenuadvanced->getStocksSpecial($productos_filtrados,$data_filter);
					if ($filter){																																
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKSPECIAL=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKSPECIAL=a=b=c';
						}else{
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter=STOCKSPECIAL=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter=STOCKSPECIAL=a=b=c';
					}
					if ($results!="no_special" && $results>0){
						$stockstatuses_final["strspecial"] = array(
							'stock_id'		 => "special",
							'name'    	     => $this->language->get('special_prices_text'),
							'total'		     => $results,
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "STOCKSPECIAL"							
						);
					}
				}
				
				if($settings_module['stock']['clearance'] && !$filter_clearance){
					$results = $this->model_module_supercategorymenuadvanced->getStocksClearance($productos_filtrados,$data_filter,$settings_module['stock']['clearance_value']);
					if ($filter){																																
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKCLEARANCE=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKCLEARANCE=a=b=c';
						}else{
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter=STOCKCLEARANCE=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter=STOCKCLEARANCE=a=b=c';
					}
					if ($results!="no_clearance" && $results>0){
						$stockstatuses_final["clearance"] = array(
							'stock_id'		 => "clearance",
							'name'    	     => $this->language->get('clearance_text'),
							'total'		     => $results,
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "STOCKCLEARANCE"							
						);
					}
				}
				
				if($settings_module['stock']['arrivals'] && !$filter_arrivals){
					$results = $this->model_module_supercategorymenuadvanced->getStocksArrivals($productos_filtrados,$data_filter,$settings_module['stock']['number_day']);
					if ($filter){																																
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKNEW=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@STOCKNEW=a=b=c';
						}else{
						$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter=STOCKNEW=a=b=c';
						$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter=STOCKNEW=a=b=c';
					}
					if ($results!="no_new" && $results>0){
						$stockstatuses_final["new"] = array(
							'stock_id'		 => "new",
							'name'    	     => $this->language->get('new_products_text'),
							'total'		     => $results,
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "STOCKNEW"							
						);
					}
				}
				
				if (!empty($stockstatuses_final)){ //SET STOKES
				
				
				$stockstatuses[] = array(
						'name'    	     => $stock_text,
						'total'		     => count($stockstatuses_final),
						'jurjur'    	 => $stockstatuses_final,
						'list_number' 	 => 100,
				        'order'			 => "OT",
					    'view'			 => $settings_module['stock']['view'],
						'initval'	     => isset($settings_module['stock']['initval']) ? $settings_module['stock']['initval']  : "opened",
						'searchinput'    => "no",
						
				);
				
				
				$this->data['values_no_selected'][]=$stockstatuses;
				}
				
	
				
			///////////////////////////////////
			// GET VALUES FROM ADMIN
			//////////////////////////////////

			$values_in_category= $this->config->get('VALORES_'.$category_id, (int)$this->config->get('config_store_id') );

			/////////////////////////////////////
			//OPTIONS.-
			////////////////////////////////////
						
			isset($values_in_category['options']) ? $options_in_category=$values_in_category['options'] : $options_in_category="no hay opciones";
			
		
			//WE HAVE VALUES
			if (is_array($options_in_category)){
				
				
				foreach ($options_in_category as $option_in_category){
					$option_ids[$option_in_category['option_id']]=$option_in_category['option_id'];
	         	}
		
		 	
			//get all option with filter
			$options_in_category_filtered = $this->model_module_supercategorymenuadvanced->getOptionsFiltered($productos_filtrados,$data_filter,$option_ids);

		   	//remove options not selected in admin
			$options_filtered=array_intersect_key($options_in_category,$options_in_category_filtered);
			
			//remove options selected by user
			$delete_options=array();
			
			if ($filter_option_id){
				//Clean string
				$opciones_filtrados=explode(",",substr($filter_option_id, 0, -1));
				foreach ($opciones_filtrados as $opciones_filtrado){
					$delete_options[$opciones_filtrado] =$opciones_filtrado;
					
				}
				
			}

		//remove options in filter we don`t need info.		
		$results=array_diff_key($options_filtered,$delete_options);

				
				foreach ($results as $result){
		
				//GET DEFAULT VALUES'initval'	     => 
				$name= $this->model_module_supercategorymenuadvanced->getOptionName($result['option_id']);	
				$option_id=$result['option_id'];
				$option_number=$result['number'];
				$option_sort_order=$result['sort_order'];
                $option_orderval=$result['orderval'];
                $option_separator=$result['separator'];
				$option_view=$result['view'];
				$option_initval= isset($result['initval']) ? $result['initval']  : "opened";
				$option_searchinput=isset($result['searchinput']) ? $result['searchinput']  : "no";
				//GET ALL OPTIONS VALUES FILTERED
			    $options_values = $options_in_category_filtered[$option_id];	
				
				$options_final = array();
				
				//check if we have options
				if($options_values){ 
				
					foreach ($options_values as $option_value){
					
							(!empty($option_value['image_thumb']) && $option_view=="image") ? $img="ig" : $img='';								
						//check if option value have no data:
						
						$option_value['text']=="" ? $option_name="NDDDDDN" : $option_name=$option_value['text'];
							
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);		
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);	
						}else{				
							$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);										
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);	
						}		
						
						
						$namer=$option_value['text']=="" ? $option_name=$this->data['no_data_text'] : $option_name=$option_value['text'];
						
						
							$options_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'href'    	   => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							    'ajax_url'	   => $ajax_url,
								'total'		   => $option_value['total'],
								'image_thumb'  => $option_value['image_thumb']
							);
					}
			
				
						
	
			    $sort_order = array();
	  				
					if ($option_orderval=="OT"){//by total
						 //get total values.
						 foreach ($options_final as $key => $value) {
							 $sort_order[] = $value['total'];
						 }
						array_multisort($sort_order,SORT_DESC,$options_final);   
					
					}elseif($option_orderval=="OC"){//computer order
						//get names values.
						foreach ($options_final as $key => $value) {
							$sort_order[] = $value['name'];
						}
					
						array_multisort($sort_order,SORT_ASC,$options_final);  
							
					}elseif($option_orderval=="OH"){//computer order 
					
					     //by natural order
						//get names values.
						foreach ($options_final as $key => $value) {
							$sort_order['str'.(string)$value['name']] = $value['name'];
						}
					  
					  natsort($sort_order);
					  
					  $options_final= array_merge($sort_order,$options_final);   
						
						
					}else{
						
						$options_final=$options_final;
						
					}
					
					if(!empty($options_final)){
						$opciones[$option_id] = array(
							'option_id' => $option_id,
							'name'    	   => html_entity_decode($name),
							'total'		   => count($options_final), 
							//'ajax_url'	   => $ajax_url,
							'tipo'         => 'OPTION',
							'list_number'  => $option_number,
							'order'	       => $option_orderval,
							'sort_order'   => $option_sort_order,
							'initval'	   => $option_initval,
							'searchinput'  => $option_searchinput,
     						'jurjur'	   => $options_final,
							'view'		   => $option_view						
							);
					}
			
				
				
				}// END FOREACH RESULTS	
				
				
				}
				
				//if(!empty($opciones)){$this->data['values_no_selected'][]=$opciones;}
			
			
					
			}

			/////////////////////////////////////
			//ATRIBUTES.-
			////////////////////////////////////
						
			isset($values_in_category['attributes']) ? $attributes_in_category=$values_in_category['attributes'] : $attributes_in_category="no hay atributos";
	
			//WE HAVE VALUES
			if (is_array($attributes_in_category)){
				
			//FILTER ATRIBUTES.
	
			foreach ($attributes_in_category as $attribute_in_category){
	
					$attribute_ids[$attribute_in_category['attribute_id']]=$attribute_in_category['attribute_id'];
					
			}
	
			$attributes_in_category_filtered = $this->model_module_supercategorymenuadvanced->getAtributesFiltered($productos_filtrados,$data_filter,$attribute_ids);
			
		
			$attributes_filtered=array_intersect_key($attributes_in_category,$attributes_in_category_filtered);
			
			$delete_attributes=array();
			
			if ($filter_attribute_id){
				$attributos_filtrados=explode(",",substr($filter_attribute_id, 0, -1));
				foreach ($attributos_filtrados as $attributo_filtrado){
					$delete_attributes[$attributo_filtrado] =$attributo_filtrado;
					
				}
				
			}
            $results=array_diff_key($attributes_filtered,$delete_attributes);


			foreach ($results as $result){
		
				//GET DEFAULT VALUES
				$name= $this->model_module_supercategorymenuadvanced->getAttributeName($result['attribute_id']);	
				$attribute_id=$result['attribute_id'];
				$attribute_number=$result['number'];
				$attribute_sort_order=$result['sort_order'];
                $attribute_orderval=$result['orderval'];
                $attribute_separator=$result['separator'];
				$attribute_view=$result['view'];
				$attribute_initval=isset($result['initval']) ? $result['initval']  : "opened";
				$attribute_searchinput=isset($result['searchinput']) ? $result['searchinput']  : "no";
				
				//GET ALL ATRIBUTE VALUES FILTERED
			    $attribute_values = $attributes_in_category_filtered[$attribute_id];
			
				//Mount real values with the separator.
					if ($attribute_separator!="no"){
						$new_array_values= array();
							if($attribute_values){
							foreach ($attribute_values as $attribute_value){
									
								$attributes = explode($attribute_separator, $attribute_value['text']);	
									$total=0;			
									foreach ($attributes as $attribute) {
										
										if (array_key_exists(trim($attribute), $new_array_values)) {
											$new_array_values[trim($attribute)]=array(
												'text'=>trim($attribute),
												'total'=>$attribute_value['total'] + $new_array_values[trim($attribute)]['total'],
												'separator'=>'YES'
											);
										}else{
											$new_array_values[trim($attribute)]=array(
												'text'=>trim($attribute),
												'total'=>$attribute_value['total'],
												'separator'=>'YES'
											);
										}
									}
								
							}
							$attribute_values=$new_array_values;
							}
					}
				

				
				$atributos_final = array();
				
			
				if($attribute_values){ 
					foreach ($attribute_values as $attribute_value){
					
						//vemos si exites separador
						
						isset($attribute_value['separator']) ? $sep="SPER" : $sep='';
									
						//check if attribute value have no data:
						$attribute_value['text']=="" ? $attribute_name="NDDDDDN" : $attribute_name=$attribute_value['text'].$sep;
							
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@ATTRIBU='.urlencode($attribute_name).'='.urlencode($attribute_id).'='.urlencode($name);		
							
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$url_filter.'@@ATTRIBU='.urlencode($attribute_name).'='.urlencode($attribute_id).'='.urlencode($name);	
							
									   				
						}else{				
							$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'ATTRIBU='.urlencode($attribute_name).'='.urlencode($attribute_id).'='.urlencode($name);										
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'ATTRIBU='.urlencode($attribute_name).'='.urlencode($attribute_id).'='.urlencode($name);	
						
						}		
						
						$namer=$attribute_value['text']=="" ? $attribute_name=$this->data['no_data_text'] : $attribute_name=$attribute_value['text'];
						
						
							$atributos_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'total'		   => $attribute_value['total'],
								'href'    	   => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'ajax_url'	   => $ajax_url,
								
							);
					}
			
				}//
						
	
			    $sort_order = array();
	  				
				if ($attribute_orderval=="OT"){//by total
				     //get total values.
					 foreach ($atributos_final as $key => $value) {
               			 $sort_order[] = $value['total'];
               		 }
                	array_multisort($sort_order,SORT_DESC,$atributos_final);   
				
				}elseif($attribute_orderval=="OC"){//computer order
					//get names values.
					foreach ($atributos_final as $key => $value) {
						$sort_order[] = $value['name'];
					}
				
					array_multisort($sort_order,SORT_ASC,$atributos_final);  
				
				
				   
				  
				 // $atributos_final= array_merge($sort_order,$atributos_final);   
				
				}else{ //by natural order
					//get names values.
					foreach ($atributos_final as $key => $value) {
						$sort_order['str'.(string)$value['name']] = $value['name'];
					}
				  
				  natsort($sort_order);
				  
				  $atributos_final= array_merge($sort_order,$atributos_final);   
					
					
				}

	
			if(!empty($atributos_final)){
					$atributos[$attribute_id] = array(
						'attribute_id' => $attribute_id,
						'name'    	   => html_entity_decode($name),
						'total'		   => count($atributos_final), 
						'tipo'         => 'ATTRIBUTE',
						'list_number'  => $attribute_number,
				       	'order'	       => $attribute_orderval,
					    'sort_order'   => $attribute_sort_order,
						'initval'	   => $attribute_initval,
						'searchinput'  => $attribute_searchinput,
						'jurjur'	   => $atributos_final,
						'view'		   => $attribute_view						
						);
				}
			
			
			
			
			}// END FOREACH RESULTS	
				
			
			}
		
			if(!empty($opciones)&& !empty($atributos) ){
				
				//merge and reorder.
				
				$all_values= array_merge($opciones,$atributos);
				
					
				$sort_order=array();
				foreach ($all_values as $key => $value) {
                   $sort_order[] = $value['sort_order'];
			  	}
              
			  	array_multisort($sort_order, SORT_ASC,$all_values);
				
				$this->data['values_no_selected'][]=$all_values;
				
				
			}elseif(empty($opciones) && !empty($atributos)){
			
				$sort_order=array();
				foreach ($atributos as $key => $value) {
                   $sort_order[] = $value['sort_order'];
			  	}
              
			  	array_multisort($sort_order, SORT_ASC,$atributos);
				$this->data['values_no_selected'][]=$atributos;
			
			
			}elseif(empty($atributos) && !empty($opciones)){
				$sort_order=array();
				foreach ($opciones as $key => $value) {
                   $sort_order[] = $value['sort_order'];
			  	}
              
			  	array_multisort($sort_order, SORT_ASC,$opciones);
				$this->data['values_no_selected'][]=$opciones;
			}
				
				

				
		
		}else{//we don't have products
			//Don't show PRICE RANGE
			$this->data['price_range_is_not_selected']=false;
			$this->data['price_range_script']=false;

			
		} //if (!empty($productos_filtrados)){
	
	
	}//en with categories
	
	

		
}
?>