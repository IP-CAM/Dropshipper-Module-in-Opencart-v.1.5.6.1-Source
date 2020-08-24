<?php 
class ControllerProductaSearch extends Controller { 	
	public function index() { 
	    if(version_compare(VERSION,'1.5.5','>')) {
		     $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');					
		}
		$this->language->load('product/asearch');
		$this->load->model('catalog/category');
		$this->load->model('module/supercategorymenuadvanced');
		$this->load->model('catalog/asearch');
		$this->language->load('module/supercategorymenuadvanced');
		$this->load->model('tool/image'); 
		//Load filter settings.
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
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
		
		if (isset($settings_module['category']['asearch'])){
			$this->data['is_categories']=$settings_module['category']['asearch'];
		}else{
			$this->data['is_categories']=0;
		}
	   
	    $url_pr='';
		if (isset($this->request->get['PRICERANGE'])) {
			$url_pr .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		}
		
		if (isset($this->request->get['C'])) {
			$url_pr .= '&amp;C=' . $this->request->get['C'];
		} 
			
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
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
			
			$category_id = $this->request->get['filter_category_id'];

		
		} else {
			$filter_category_id = false;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
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
		
		
		//init filters
		$nombre_de_la_categoria='';
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
		$this->data['no_data_text'] 		= $this->language->get('no_data_text');
		
		//BEGIN CHECKING FILTERS
		$filtros_seleccionados= array();
			
				
			if (!empty($this->request->get['filter'])){
				$url_filter=$this->request->get['filter'];
			}else{
				$url_filter='';	
			}
		
				
			//PRICE RANGE
			if (isset($this->request->get['PRICERANGE']) and !empty($this->request->get['PRICERANGE'])) {
					list($filter_min_price,$filter_max_price)=explode("MPRM",$this->request->get['PRICERANGE']);
				   //remove currency from price
					$filter_min_price=floor($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_min_price,$this->request->get['C'])); 
					$filter_max_price=ceil($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_max_price,$this->request->get['C']));
				  
				  //remove tax from price
				   if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					
					 $tax_value= $this->tax->calculate(1, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
					
						$filter_min_price=floor( $filter_min_price/$tax_value ); 
						$filter_max_price=ceil( $filter_max_price/$tax_value );
				   }
			   
					//flag for show PRICE RANGE
					$this->data['price_range_is_not_selected']=false;
			
			} //END PRICE RANGE 
			
		
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
						
						
							if (strpos($name, "SPER")){
								$namev=substr($name,0,-4);
							}else{
								$namev=$name;
							}
				            if (strpos($tipo, "ig")){
								$tipo=substr($tipo,0,-2);
								//$image=$this->model_module_supercategorymenuadvanced->getoptionImage($id,$name);
								//$image=$this->model_module_supercategorymenuadvanced->getImage($name);
									
							}else{
								$tipo=$tipo;
								$image='';
							}
							
				        $namefinal=html_entity_decode($namev)=="NDDDDDN" ? html_entity_decode($this->data['no_data_text']): html_entity_decode($namev);
				        
						if($links){
						    $urlfilter='&amp;filter='.urlencode(str_replace("&amp;","&",$links));
						}else{
						    $urlfilter='&amp;filter=';
						}		
						
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
								break;	
								
							case 'STOCKNEW':
								$filter_arrivals=true;
								$namefinal=$this->language->get('new_products_text');
								$dnd=$this->language->get('stock_text');
								break;	
			
							case 'STOCKSPECIAL':
								$filter_special=true;
								$namefinal= $this->language->get('special_prices_text');
								$dnd=$this->language->get('stock_text');
								break;	
							case 'STOCKS':
								$filter_stock=true;
								$namefinal=$this->language->get('in_stock_text');
								$dnd=$this->language->get('stock_text');
								break;	
						}
									
						$filtros_seleccionados[]=array(
								'Tipo' 		   => $tipo,
								'name'		   => html_entity_decode($namefinal),
								'id_attributo' => $id,
								'url_filter'   => $url_filter,
								'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_search.$urlfilter),
								'ajax_url'	   => 'path='.$this->request->get['path'].$url_pr.$url_search.$urlfilter,
								'see_more'	   => 'index.php?route=module/supercategorymenuadvancedseemore/seemore&amp;path='.$this->request->get['path'].$url_pr.$url_search.'&amp;id='.urlencode($id).'&amp;dnd='.urlencode($dnd).'&amp;tipo='.urlencode($tipo).'&amp;name='.urlencode($namefinal).$urlfilter,
								'dnd'		   => $dnd,
								
								
						);
					
				
					unset($filtro);
				
				}//end foreach $filtros
		
		}//End FILTER
	
	
	
	
	    /////////////////////////////////////////////////////////////
		// 
		//   SEARCH BOX
		////////////////////////////////////////////////////////////


			if (!empty($this->request->get['filter'])){
				//$url_filter=$this->request->get['filter'];
				$urlfilter2='&filter='.urlencode(str_replace("&amp;","&",$this->request->get['filter']));
			}else{
				//$url_filter='';	
				$urlfilter2='&filter=';
			}
			//remove filter_name from string.
           
			if ($filter_name){// show search box
				$filtros_seleccionados[]=array(
			    	'Tipo' 		   => "Search",
					'name'		   => html_entity_decode($filter_name),
					'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$urlfilter2),
				    'ajax_url'	   => 'path='.$this->request->get['path'].$url_pr.$urlfilter2,
					'see_more'	   => false,
					'dnd'		   => $this->language->get('search_filter_text'),
					'image'		   => '',
			);
		  }
	

	
		//set all values selected.
		$this->data['values_selected']=$filtros_seleccionados;
	    // REMOVE FILTERS CHECKED ON MENU
	    if (!$settings_module['asearch_filters']){ 
			$this->data['values_selected']='';
		}
	   
	   
	   
	    if (!empty($this->request->get['filter'])){
			
			$url_filter=$this->request->get['filter'];
			$min_urls = explode("@@",str_replace("&amp;","&",$url_filter));
		
			$url_filter=array();
			foreach ($min_urls as $min_url){
		
				list($tipo,$name,$id,$dnd)=explode("=",$min_url);
					
					$url_filter[]=urlencode($tipo) ."=". urlencode($name) ."=". urlencode($id) ."=". urlencode($dnd);
					//$url_filter[]=$tipo ."=". $name ."=". $id ."=". $dnd;
			}
			$url_filter=implode("@@",$url_filter);
		}else{
			$url_filter='&filter=';	
		}
		
		
		$this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
									
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
					
					$nombre_de_la_categoria=$category_info['name'];
	       			
					$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('product/asearch', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
					
				
				}
			
			
			}		
		
			$category_id = array_pop($parts);
		}
		
					
   		
    	if (!$nombre_de_la_categoria){
    	$this->data['heading_title'] = sprintf($this->language->get('heading_title'),$this->language->get('this_store'));
		}else{
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'),$nombre_de_la_categoria);
		}
		
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->data['heading_title'] .  ' - ' . $this->request->get['keyword']);
		} else {
		   $this->document->setTitle($this->data['heading_title']);
		}
		
		
		
		
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_sub_category'] = $this->language->get('text_sub_category');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_points'] = $this->language->get('text_points');
		$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');		
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_refine'] = $this->language->get('text_refine');
    	$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['compare'] = $this->url->link('product/compare');
		$this->data['remove_filter_text'] = $this->language->get('remove_filter_text');
		$this->data['entry_selected'] = $this->language->get('entry_selected');

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
			
		$this->data['products'] = array();
		if (empty($productos_filtrados)){//prevent errors for no products
			$min_price=$maxprice=0;
			$product_total=0;
		    $this->data['ocscroll']='';
		    $this->data['categories']='';
			$this->data['totales'] = 0;
		
		}else{
			
			
		if ($this->data['is_categories']){ // NO CATEGORY NAV IN 
				
			$this->data['categories'] = array();
			
			$results = $this->model_module_supercategorymenuadvanced->getCategoriesFiltered($productos_filtrados,$data_filter);
		
			
			foreach ($results as $result) {
			
			$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			
				$this->data['categories'][] = array(
					'name'  => $result['name'],
					'href'  => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '_' . $result['category_id']) .$url_pr.$url_search),
					'ajax_url'  => 'path=' . $this->request->get['path'] . '_' . $result['category_id'] .$url_pr.$url_search,
					'total'	=> $result['total'],
					'thumb' => $image
				);
			}
			
											
		}else{
			
			$this->data['categories'] = '';
		}
		
		$url = '';
			
			if (isset($this->request->get['filter'])) {
				$url .= '&amp;filter=' . $url_filter;
			}
			
			
			if (isset($this->request->get['C'])) {
				$url .= '&amp;C=' . $this->request->get['C'];
		    } 

			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
	
					
			if (isset($this->request->get['limit'])) {
				$url .= '&amp;limit=' . $this->request->get['limit'];
			}
			
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
						
	    //for pagination.	
        $product_total = count($productos_filtrados);


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		} 

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
  		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		$pagination_filters = array(
				'products'					=> implode(",",$productos_filtrados),
				'sort'                		=> $sort,
				'order'               		=> $order,
				'start'               		=> ($page - 1) * $limit,
				'limit'               		=> $limit
			);
			
			$results= $this->model_catalog_asearch->getProducts($pagination_filters);
			
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}	
				
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
					
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id']).$this->model_module_supercategorymenuadvanced->SeoFix($url) 
				);
			}
					
			
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC') . $url
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC') . $url
			);
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC') . $url
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC') . $url
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC') . $url
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC') . $url
			);
	
			$url = '';
			if (isset($this->request->get['filter'])) {
					$url .= '&amp;filter=' . $url_filter;
			}
            if (isset($this->request->get['C'])) {
			$url .= '&amp;C=' . $this->request->get['C'];
			}
			
			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
				
			if (isset($this->request->get['sort'])) {
				$url .= '&amp;sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('product/asearch',  'path=' . $this->request->get['path'] . '&limit=' . $this->config->get('config_catalog_limit')) . $url
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=25') . $url
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=50') . $url
			);
	
			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('product/asearch',  'path=' . $this->request->get['path'] . '&limit=75') . $url
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=100') . $url 
			);
					
			$url = '';
	
			if (isset($this->request->get['filter'])) {
				$url .= '&amp;filter=' . $url_filter;
			}
			
			if (isset($this->request->get['C'])) {
				$url .= '&amp;C=' . $this->request->get['C'];
		    }			
			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
			

										
			if (isset($this->request->get['sort'])) {
				$url .= '&amp;sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&amp;order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&amp;limit=' . $this->request->get['limit'];
			}
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
					
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/asearch','path=' . $this->request->get['path'] . '&page={page}') . $url;
			
			$this->data['pagination'] = $pagination->render();
			$this->data['totales'] =  $product_total;
			//Load filter settings.
			$this->data['ocscroll']='';
			$settings_module=$this->config->get('supercategorymenuadvanced_settings');
			if($settings_module['ocscroll']){
				$this->load->model('module/ocscroll');
				$this->data['ocscroll']=$this->model_module_ocscroll->setocScroll();
			}
		
		//}	
		
		$this->data['filter'] = $filter;
		//$this->data['PRICERANGE'] = $filter_price;
		$this->data['path'] = $path;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;
		
		
		
			}//end for no products
		
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/asearch.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/asearch.tpl';
		} else {
			$this->template = 'default/template/product/asearch.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top','common/content_filter',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
				
		$this->response->setOutput($this->render());
  	}


	public function asearchAjax() { 
    	$this->language->load('product/asearch');
		$this->load->model('catalog/category');
		$this->load->model('module/supercategorymenuadvanced');
		$this->load->model('catalog/asearch');
		$this->language->load('module/supercategorymenuadvanced');
		$this->load->model('tool/image'); 
		//Load filter settings.
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
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
		
		if (isset($settings_module['category']['asearch'])){
			$this->data['is_categories']=$settings_module['category']['asearch'];
		}else{
			$this->data['is_categories']=0;
		}
	    $url_pr='';
		if (isset($this->request->get['PRICERANGE'])) {
			$url_pr .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		}
		
		if (isset($this->request->get['C'])) {
			$url_pr .= '&amp;C=' . $this->request->get['C'];
		} 
			
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
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
			
			//if ($category_id==0){
				$category_id = $this->request->get['filter_category_id'];
			//}
		} else {
			$filter_category_id = false;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
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
		//init filters
		$nombre_de_la_categoria='';
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
		$this->data['no_data_text'] 		= $this->language->get('no_data_text');
		
		//BEGIN CHECKING FILTERS
		$filtros_seleccionados= array();
			
				
			if (!empty($this->request->get['filter'])){
				$url_filter=$this->request->get['filter'];
			}else{
				$url_filter='&filter=';	
			}
		
				
			//PRICE RANGE
			if (isset($this->request->get['PRICERANGE']) and !empty($this->request->get['PRICERANGE'])) {
					list($filter_min_price,$filter_max_price)=explode("MPRM",$this->request->get['PRICERANGE']);
				   //remove currency from price
					$filter_min_price=floor($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_min_price,$this->request->get['C'])); 
					$filter_max_price=ceil($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_max_price,$this->request->get['C']));
				  
				  //remove tax from price
				   if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					
					 $tax_value= $this->tax->calculate(1, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
					
						$filter_min_price=floor( $filter_min_price/$tax_value ); 
						$filter_max_price=ceil( $filter_max_price/$tax_value );
				   }
			   
					//flag for show PRICE RANGE
					$this->data['price_range_is_not_selected']=false;
			
			} //END PRICE RANGE 
			
		
		
			//FILTER
			
			if (!empty($this->request->get['filter'])){//fix problem with filter=empty
				
				//$filtros = explode("@@",urldecode($url_filter));
				$filtros = explode("@@",$url_filter);
				
				$filter=true;
				
				foreach ($filtros as $filtro){
						//fix filter string for href[first_position-Second position - only this filter]
						$arr=array();
						$arr = array_diff($filtros,(array)$filtro);
						$links=implode ("@@",$arr);
										
						list($tipo,$name,$id,$dnd)=explode("=",$filtro);
						
						
							if (strpos($name, "SPER")){	$namev=substr($name,0,-4);}else{$namev=$name;}
				            if (strpos($tipo, "ig")){$tipo=substr($tipo,0,-2);								
							}else{
								$tipo=$tipo;
								$image='';
							}
							
						$namefinal=html_entity_decode($namev)=="NDDDDDN" ? html_entity_decode($this->data['no_data_text']): html_entity_decode($namev);
						
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
								break;	
								
							case 'STOCKNEW':
								$filter_arrivals=true;
								$namefinal=$this->language->get('new_products_text');
								$dnd=$this->language->get('stock_text');
								break;	
			
							case 'STOCKSPECIAL':
								$filter_special=true;
								$namefinal= $this->language->get('special_prices_text');
								$dnd=$this->language->get('stock_text');
								break;	
							case 'STOCKS':
								$filter_stock=true;
								$namefinal=$this->language->get('in_stock_text');
								$dnd=$this->language->get('stock_text');
								break;	
						}
						
						$filtros_seleccionados[]=array(
								'Tipo' 		   => $tipo,
								'name'		   => html_entity_decode($namefinal),
								'id_attributo' => $id,
								'query'	       => $filtro,
								'url_filter'   => $url_filter,
								'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_search.'&amp;filter='.urlencode(str_replace("&amp;","&",$links))),
								'ajax_url'	   => 'path='.$this->request->get['path'].$url_pr.$url_search.'&amp;filter='.urlencode(str_replace("&amp;","&",$links)),
								'see_more'	   => $this->url->link('module/supercategorymenuadvancedseemore/seemore', 'path='.$this->request->get['path']).$url_pr.$url_search.'&amp;id='.urlencode($id).'&amp;dnd='.urlencode($dnd).'&amp;tipo='.urlencode($tipo).'&name='.urlencode($namefinal).'&amp;filter='.urlencode(str_replace("&amp;","&",$links)),
								'dnd'		   => $dnd
								
						);
					
						unset($search);
				 		
				
					unset($filtro);
				
				}//end foreach $filtros
		
		}//End FILTER
	
	
	
	    /////////////////////////////////////////////////////////////
		// 
		//   SEARCH BOX
		////////////////////////////////////////////////////////////


			if (!empty($this->request->get['filter'])){
				//$url_filter=$this->request->get['filter'];
				$urlfilter2='&amp;filter='.urlencode(str_replace("&amp;","&",$this->request->get['filter']));
			}else{
				//$url_filter='';	
				$urlfilter2='';
			}
			//remove filter_name from string.
           
			if ($filter_name){// show search box
				$filtros_seleccionados[]=array(
			    	'Tipo' 		   => "Search",
					'name'		   => html_entity_decode($filter_name),
					'href'		   => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$urlfilter2),
				    'ajax_url'	   => 'path='.$this->request->get['path'].$url_pr.$urlfilter2,
					'see_more'	   => false,
					'dnd'		   => $this->language->get('search_filter_text'),
					'image'		   => '',
			);
		  }
	
		//set all values selected.
		$this->data['values_selected']=$filtros_seleccionados;
	    // REMOVE FILTERS CHECKED ON MENU
	    if (!$settings_module['asearch_filters']){ 
			$this->data['values_selected']='';
		}
	   
	   
	   
	    if (!empty($this->request->get['filter'])){
			
			$url_filter=$this->request->get['filter'];
			$min_urls = explode("@@",str_replace("&amp;","&",$url_filter));
		
			$url_filter=array();
			foreach ($min_urls as $min_url){
		
				list($tipo,$name,$id,$dnd)=explode("=",$min_url);
					
					$url_filter[]=urlencode($tipo) ."=". urlencode($name) ."=". urlencode($id) ."=". urlencode($dnd);
					//$url_filter[]=$tipo ."=". $name ."=". $id ."=". $dnd;
			}
			$url_filter=implode("@@",$url_filter);
		}else{
			$url_filter='&filter=';	
		}
		
		
		$this->data['breadcrumbs'] = array();
   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
									
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
					
					$nombre_de_la_categoria=$category_info['name'];
	       			
					$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('product/asearch', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
					
				
				}
			
			
			}		
		
			$category_id = array_pop($parts);
		}
		
					
   		
    	if (!$nombre_de_la_categoria){
    	$this->data['heading_title'] = sprintf($this->language->get('heading_title'),$this->language->get('this_store'));
		}else{
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'),$nombre_de_la_categoria);
		}
		
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->data['heading_title'] .  ' - ' . $this->request->get['keyword']);
		} else {
		   $this->document->setTitle($this->data['heading_title']);
		}
		
		
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_sub_category'] = $this->language->get('text_sub_category');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_points'] = $this->language->get('text_points');
		$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');		
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_refine'] = $this->language->get('text_refine');
    	$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['compare'] = $this->url->link('product/compare');
		$this->data['remove_filter_text'] = $this->language->get('remove_filter_text');
		$this->data['entry_selected'] = $this->language->get('entry_selected');

		//Array with all filter	
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
			
		$this->data['products'] = array();
		if (empty($productos_filtrados)){//prevent errors for no products
			$min_price=$maxprice=0;
			$product_total=0;
		    $this->data['ocscroll']='';
		    $this->data['categories']='';
			$this->data['totales'] = 0;
		
		}else{
			
			
		if ($this->data['is_categories']){ // NO CATEGORY NAV IN 
				
			$this->data['categories'] = array();
			
			$results = $this->model_module_supercategorymenuadvanced->getCategoriesFiltered($productos_filtrados,$data_filter);
			foreach ($results as $result) {
			
			$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			
				$this->data['categories'][] = array(
					'name'  => $result['name'],
					'href'  => $this->model_module_supercategorymenuadvanced->SeoFix($this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '_' . $result['category_id']) .$url_pr.$url_search),
					'ajax_url'  => 'path=' . $this->request->get['path'] . '_' . $result['category_id'] .$url_pr.$url_search,
					'total'	=> $result['total'],
					'thumb' => $image
				);
			}
						
		}else{
			
			$this->data['categories'] = '';
		}
			
	        $url = '';
			
			if (isset($this->request->get['filter'])) {
				$url .= '&amp;filter=' . $url_filter;
			}
				
			if (isset($this->request->get['C'])) {
			$url .= '&amp;C=' . $this->request->get['C'];
		    } 
			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
					
			if (isset($this->request->get['limit'])) {
				$url .= '&amp;limit=' . $this->request->get['limit'];
			}
			
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
		
		
		//for pagination.	
        $product_total = count($productos_filtrados);


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		} 

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
  		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		$pagination_filters = array(
				'products'					=> implode(",",$productos_filtrados),
				'sort'                		=> $sort,
				'order'               		=> $order,
				'start'               		=> ($page - 1) * $limit,
				'limit'               		=> $limit
			);
			
			$results= $this->model_catalog_asearch->getProducts($pagination_filters);
			
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}	
				
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
					
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id']).$this->model_module_supercategorymenuadvanced->SeoFix($url) 
				);
			}
					
			
						
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC') . $url
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC') . $url
			);
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC') . $url
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC') . $url
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC') . $url
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC') . $url
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC') . $url
			);
	
			$url = '';
			if (isset($this->request->get['filter'])) {
				$url .= '&amp;filter=' . $url_filter;
			}
            if (isset($this->request->get['C'])) {
				$url .= '&amp;C=' . $this->request->get['C'];
			}
			
			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
						
			if (isset($this->request->get['sort'])) {
				$url .= '&amp;sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&amp;order=' . $this->request->get['order'];
			}
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('product/asearch',  'path=' . $this->request->get['path'] . '&limit=' . $this->config->get('config_catalog_limit')) . $url
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=25') . $url
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=50') . $url
			);
	
			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('product/asearch',  'path=' . $this->request->get['path'] . '&limit=75') . $url
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&limit=100') . $url 
			);
					
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&amp;filter=' . $url_filter;
			}
			
			if (isset($this->request->get['C'])) {
				$url .= '&amp;C=' . $this->request->get['C'];
		   }			
			if (isset($this->request->get['PRICERANGE'])) {
				$url .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		    }			
						
			if (isset($this->request->get['sort'])) {
				$url .= '&amp;sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&amp;order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&amp;limit=' . $this->request->get['limit'];
			}
			if(version_compare(VERSION,'1.5.5','>')) {
				if (isset($this->request->get['search'])) {
					$url .= '&amp;search=' . $this->request->get['search'];
				}
		
			}else{
				if (isset($this->request->get['filter_name'])) {
				$url .= '&amp;filter_name=' . $this->request->get['filter_name'];
				}
			
			}
		
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
			}
				
			if (isset($this->request->get['filter_description'])) {
				$url .= '&amp;filter_description=' . $this->request->get['filter_description'];
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
			}
		
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
			}	
					
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/asearch', 'path=' . $this->request->get['path'] . '&page={page}') . $url;
			
			$this->data['pagination'] = $pagination->render();
			$this->data['totales'] =  $product_total;
			//Load filter settings.
			$this->data['ocscroll']='';
			$settings_module=$this->config->get('supercategorymenuadvanced_settings');
			if($settings_module['ocscroll']){
				$this->load->model('module/ocscroll');
				$this->data['ocscroll']=$this->model_module_ocscroll->setocScroll();
			}
		
		//}	
		
		$this->data['filter'] = $filter;
		//$this->data['PRICERANGE'] = $filter_price;
		$this->data['path'] = $path;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;
		
		
		
			}//end for no products
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/asearch_a.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/asearch_a.tpl';
		} else {
			$this->template = 'default/template/product/asearch_a.tpl';
		}
		
			$this->children = array(
				'common/content_filter',	'common/column_left',
			'common/column_right',
			);			
		$this->response->setOutput($this->render());
  	}
	
	
}
?>