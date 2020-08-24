<?php  
class ControllerModuleSuperCategoryMenuAdvancedSeeMore extends Controller {
	
		public function seemore() {
		
		$this->language->load('module/supercategorymenuadvanced');
		$this->load->model('module/supercategorymenuadvanced');
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
		$this->data['see_more_text'] 		= $this->language->get('see_more_text');
		$this->data['remove_filter_text'] 	= $this->language->get('remove_filter_text');
		$this->data['pricerange_text'] 		= $this->language->get('pricerange_text');
		$this->data['no_data_text'] 		= $this->language->get('no_data_text');
		$this->data['manufacturer_text'] 	= $this->language->get('manufacturer_text');
		$this->data['category_text'] 		= $this->language->get('category_text');
	    $this->data['search_in'] 			= $this->language->get('search_in');
	
		if (isset($this->request->get['path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = array_pop($parts);
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
			$url_pr .= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
		}
		
		if (isset($this->request->get['C'])) {
			$url_pr .= '&amp;C=' . $this->request->get['C'];
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
		
		$manufacturer_text= $this->language->get('manufacturer_text');
		$stock_text= $this->language->get('stock_text');	
		
		//BEGIN CHECKING FILTERS
	
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
						
						
							if (strpos($name, "SPER")){$namev=substr($name,0,-4);}else{$namev=$name;}
							
							if (strpos($tipo, "ig")){$tipo=substr($tipo,0,-2);}else{$tipo=$tipo;}		
							
				
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
				
					unset($filtro);
				
				}//end foreach $filtros
		
		}//End FILTER
	 
	 if (!empty($this->request->get['filter'])){
			
			$url_filter=$this->request->get['filter'];
			$min_urls = explode("@@",str_replace("&amp;","&",$url_filter));
		
			$url_filter=array();
			foreach ($min_urls as $min_url){
		
				list($tipo,$name,$id,$dnd)=explode("=",$min_url);
					
					$url_filter[]=urlencode($tipo) ."=". urlencode($name) ."=". urlencode($id) ."=". urlencode($dnd);
					//$url_filter[]=$tipo ."=". $name ."=". $id ."=". $dnd;
			}
			//$url_filter=;
			
			$url_filter='&amp;filter='.str_replace("&amp;","&",implode("@@",$url_filter));
		}else{
			$url_filter='&amp;filter=';	
		}
		
		//PRICE RANGE
			if (isset($this->request->get['PRICERANGE'])) {
					list($filter_min_price,$filter_max_price)=explode("MPRM",$this->request->get['PRICERANGE']);
					
					//echo "currency factor".$this->request->get['C']."=". $this->currency->getValue($this->request->get['C']);
				   //remove currency from price
					$filter_min_price=floor($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_min_price,$this->request->get['C'])); 
					$filter_max_price=ceil($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_max_price,$this->request->get['C']));
				  	
				  //remove tax from price
				  if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					$tax_value= $this->tax->calculate(1, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
					$filter_min_price=floor( $filter_min_price/$tax_value ); 
					$filter_max_price=ceil( $filter_max_price/$tax_value );
				  }
				  
				 
			} //END PRICE RANGE 
	
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


	   // $productos_filtrados= $this->model_module_supercategorymenuadvanced->getProductsFiltered($data_filter);
		$productos_filtrados= $this->model_module_supercategorymenuadvanced->getProductsFiltered($data_filter,$settings_module['stock']['clearance_value'],$settings_module['stock']['number_day']);
	
		
	    $values_in_category= $this->config->get('VALORES_'.$category_id,(int)$this->config->get('config_store_id'));
	
		$que_buscar=$this->request->get['tipo'];
	    $nombre_seleccionado=str_replace("&amp;","&",$this->request->get['name']);  
		$dnd=$this->request->get['dnd'];
		$id=$this->request->get['id'];
			
	
		
		if ($que_buscar=="ATTRIBU"){
			
		   isset($values_in_category['attributes']) ? $attributes_in_category=$values_in_category['attributes'] : $attributes_in_category="no hay atributos";
	         //WE HAVE VALUES
			if (is_array($attributes_in_category)){
			
			//define id for selected attribute
			$attribute_we_want_info=array($id=>$id);	
			
			
			//FILTER ATRIBUTES.
			//Get attributes filtered
			$attributes_in_category_filtered = $this->model_module_supercategorymenuadvanced->getAtributesFiltered($productos_filtrados,$data_filter,$attribute_we_want_info);
			
			
			//remove all attributes we dont need
			$attributes_filtered=array_intersect_key($attributes_in_category,$attribute_we_want_info);
			
			//remove other attributes in filter.
			$delete_attributes=array();
			
			if ($filter_attribute_id){
				$attributos_filtrados=explode(",",substr($filter_attribute_id, 0, -1));
				foreach ($attributos_filtrados as $attributo_filtrado){
					$delete_attributes[$attributo_filtrado] =$attributo_filtrado;
					
				}
				
			}
	
				//remove attributes in filter we don`t need info.		
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
			    //$attribute_values = $this->model_module_supercategorymenuadvanced->getAtributesFiltered($productos_filtrados,$data_filter);
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
						$attribute_value['text']=="" ? $attribute_name="NDDDDDN" : $attribute_name=$attribute_value['text'];
												
								
						if ($attribute_name==$nombre_seleccionado){
							
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;;	
							}		
							
						}else{ //no es seleccionado
							//reset filter 
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter.'@@ATTRIBU='.urlencode($attribute_name.$sep).'='.urlencode($attribute_id).'='.urlencode($name);		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@ATTRIBU='.urlencode($attribute_name.$sep).'='.urlencode($attribute_id).'='.urlencode($name);	
						  }else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'ATTRIBU='.urlencode($attribute_name.$sep).'='.urlencode($attribute_id).'='.urlencode($name);										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'ATTRIBU='.urlencode($attribute_name.$sep).'='.urlencode($attribute_id).'='.urlencode($name);	
							}		
								
						}
							
						$namer=$attribute_value['text']=="" ? $attribute_name=$this->data['no_data_text'] : $attribute_name=$attribute_value['text'];
						
						
							$atributos_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'total'		   => $attribute_value['total'],
								'ajax_url'	   => $ajax_url,
								'seleccionado' => ($namer==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
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
						'ajax_url'	   => $ajax_url,
						'tipo'         => 'ATTRIBUTE',
						'list_number'  => $attribute_number,
				       	'order'	       => $attribute_orderval,
					    'sort_order'   => $attribute_sort_order,
						'jurjur'	   => $atributos_final,
						'view'		   => $attribute_view,
						'initval'	   => $attribute_initval,
						'searchinput'  => $attribute_searchinput,				
						);
				}
			
			
			
			}// END FOR EACH RESULTS
			
			}//WE HAVE VALUES is_array
			
			if(!empty($atributos)){
				
				$this->data['values_no_selected'][]=$atributos;
			}else{
				
				if ($filter){					
					$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
			   }else{				
					$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_filter;										
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
				}		
							
				$atributos_final['str'] = array(
					'name'    	   => $nombre_seleccionado,
					'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'total'		   => "-",
					'ajax_url'	   => $ajax_url,
					'seleccionado' => "is_seleccionado",
				);
					
				$atributos[$id] = array(
						'attribute_id' => $id,
						'name'    	   => html_entity_decode($nombre_seleccionado),
						'total'		   => 1, 
						'ajax_url'	   => $ajax_url,
						'tipo'         => $que_buscar,
     					'jurjur'	   => $atributos_final,
						'view'		   => "list",
						'initval'	   => "opened",
						'searchinput'  => "no",	
						);
					
				$this->data['values_no_selected'][]=$atributos;
				
			}	
	

			
			
			
		}elseif($que_buscar=="MANUFFUNAM"){
         
		 	//check admin configuration
			if ($settings_module['manufacturer']['manufacturer']){
				
				$manufactures = array();
				$results = $this->model_module_supercategorymenuadvanced->getManufacturesFiltered($productos_filtrados,$data_filter);
					
				
				if(!empty($results)){
					
					foreach ($results as $result) {
						
						
							$result['name']=="" ? $manufacturer_name="NDDDDDN" : $manufacturer_name=$result['name'];		
						
						if ($manufacturer_name==$nombre_seleccionado){
							if ($filter){		
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
																		
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter.'@@MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);	
						  }else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'MANUFFUNAM='.urlencode($result['name']).'='.urlencode($result['manufacturer_id']).'='.urlencode($manufacturer_text);	
						  }
											
							
						}
						
						$manufactures_final["str".$result['name']] = array(
							'manufacturer_id'=> $result['manufacturer_id'],
							'seleccionado' => ($result['name']==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
							'name'    	     => $result['name'],
							'total'		     => $result['total'],
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "MANUFACTURER",
							
							
						);
						
					}
		

		        $sort_order=array();
				
				if ($settings_module['manufacturer']['order']=="OT"){
				     //get total values.
					 foreach ($manufactures_final as $key => $value) {
               			 $sort_order[] = $value['total'];
               		 }
                	array_multisort($sort_order,SORT_DESC,$manufactures_final);   
				
				}else{
					//get names values.
					foreach ($manufactures_final as $key => $value) {
						$sort_order["str".$value['name']] = $value['name'];
					}
				  
				  natsort($sort_order);
				  
				  $manufactures_final= array_merge($sort_order,$manufactures_final);   
				}
			
				
				
				$manufactures[] = array(
						'name'    	     => $manufacturer_text,
						'total'		     => count($manufactures_final),
						'jurjur'    	 => $manufactures_final,
						'list_number' 	 => $settings_module['manufacturer']['list_number'],
				        'order'			 => $settings_module['manufacturer']['order'],
					   // 'sort_order'	 => $settings_module['manufacturer']['sort_order'],
					    'view'			 => $settings_module['manufacturer']['view'],
						'initval'	     => isset($settings_module['manufacturer']['initval']) ? $settings_module['manufacturer']['initval']  : "opened",
						'searchinput'    => isset($settings_module['manufacturer']['searchinput']) ? $settings_module['manufacturer']['searchinput'] : "no",
						
				);
						
				$this->data['values_no_selected'][]=$manufactures;
						
				}// end !empty results
				
	
			}// end if ($settings_module["manufacturer"] && !$filter_manufacturers_by_id ){
		
		
		
		}elseif($que_buscar=="STOCKKCOTS"){

		//check admin configuration
		$stockstatuses = array();
	    	isset($settings_module['stock']['recalcular']) ? $recalcular= $settings_module['stock']['recalcular']: $recalcular=false;
		    $results = $this->model_module_supercategorymenuadvanced->getStocksFiltered($productos_filtrados,$data_filter,$recalcular);
				
				if(!empty($results)){
								
					foreach ($results as $result) {
					
						$result['name']=="" ? $stock_name="NDDDDDN" : $stock_name=$result['name'];		
						
						if ($stock_name==$nombre_seleccionado){
							
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
					
					     if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter.'@@STOCKKCOTS='.urlencode($result['name']).'='.urlencode($result['stock_status_id']).'='.urlencode($stock_text);		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@STOCKKCOTS='.urlencode($result['name']).'='.urlencode($result['stock_status_id']).'='.urlencode($stock_text);	
						  }else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'STOCKKCOTS='.urlencode($result['name']).'='.urlencode($result['stock_status_id']).'='.urlencode($stock_text);										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'STOCKKCOTS='.urlencode($result['name']).'='.urlencode($result['stock_status_id']).'='.urlencode($stock_text);	
						  }
						
						
						}
						$stockstatuses_final["str".$result['name']] = array(
							'stock_id'		 => $result['stock_status_id'],
							'name'    	     => $result['name'],
							'seleccionado'   => ($result['name']==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
							'total'		     => $result['total'],
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "STOCKSTATUS"
							
						);
						
					}
		

		        $sort_order=array();
				
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
				//$id_valor_seleccionado=		
			    //SET Manufacturers
				$this->data['values_no_selected'][]=$stockstatuses;
						
				}// end !empty results
				
	
		}elseif ($que_buscar=="OPTION"){
			
		  isset($values_in_category['options']) ? $options_in_category=$values_in_category['options'] : $options_in_category="no hay opciones";
	
			//WE HAVE VALUES
			if (is_array($options_in_category)){
			
			//define id for selected attribute
			$options_we_want_info=array($id=>$id);	
					
			//FILTER ATRIBUTES.
			//Get options filtered
			$options_in_category_filtered = $this->model_module_supercategorymenuadvanced->getOptionsFiltered($productos_filtrados,$data_filter,$options_we_want_info);
	
			//remove all options we dont need
			$options_filtered=array_intersect_key($options_in_category,$options_we_want_info);
			
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
		
				//GET DEFAULT VALUES
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

			if($options_values){ 
					foreach ($options_values as $option_value){
					
							(!empty($option_value['image_thumb']) && $option_view=="image") ? $img="ig" : $img='';		
																	
						
						//check if option value have no data:
						$option_value['text']=="" ? $option_name="NDDDDDN" : $option_name=$option_value['text'];						
								
						if ($option_name==$nombre_seleccionado){
							
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
						
						   if ($filter){					
							 $filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter.'@@OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);		
							 $ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);	
						  }else{				
							$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.'&amp;filter='.'OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);										
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.'OPTION'.$img.'='.urlencode($option_name).'='.urlencode($option_id).'='.urlencode($name);	
						  }		
						
								
						}
						
						
						
						$namer=$option_value['text']=="" ? $option_name=$this->data['no_data_text'] : $option_name=$option_value['text'];
						
						$options_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'seleccionado' => ($namer==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
								'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'total'		   => $option_value['total'],
								'ajax_url'	   => $ajax_url,
								'image_thumb'  => $option_value['image_thumb']
								
							);
					}
			
			
			
				}//


			  $sort_order = array();
	  				
					
					if ($option_value['image_thumb']){
						 foreach ($options_final as $key => $value) {
							 $sort_order[] = $value['seleccionado'];
						 }
						array_multisort($sort_order,SORT_ASC,$options_final); 
						
					}else{
					
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
							
					}else{ //by natural order
						//get names values.
						foreach ($options_final as $key => $value) {
							$sort_order['str'.(string)$value['name']] = $value['name'];
						}
					  
						 natsort($sort_order);
					   	 $options_final= array_merge($sort_order,$options_final);   
						
					}
					
					
					}
					
					if(!empty($options_final)){
						$opciones[$option_id] = array(
							'option_id' => $option_id,
							'name'    	   => html_entity_decode($name),
							'total'		   => count($options_final), 
							'ajax_url'	   => $ajax_url,
							'tipo'         => 'OPTION',
							'list_number'  => $option_number,
							'order'	       => $option_orderval,
							'sort_order'   => $option_sort_order,
							'jurjur'	   => $options_final,
							'view'		   => $option_view,
							'initval'	   => $option_initval,
							'searchinput'  => $option_searchinput,
							
												
							);
					}
			
			
			}// END FOR EACH RESULTS
			
			
			//if(!empty($opciones)){$this->data['values_no_selected'][]=$opciones;}
		}//is_array(option_category)
		
		
		if(!empty($opciones)){
				
				$this->data['values_no_selected'][]=$opciones;
		}else{
				
				if ($filter){					
					$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_search.$url_filter;		
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
			   }else{				
					$filter_url=$this->url->link('product/asearch', 'path='.$this->request->get['path']).$url_pr.$url_limits.$url_filter;										
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
				}		
							
				$options_final['str'] = array(
					'name'    	   => $nombre_seleccionado,
					'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'total'		   => "-",
					'ajax_url'	   => $ajax_url,
					'seleccionado' => "is_seleccionado",
				);
					
				$opciones[$id] = array(
						'option_id' => $id,
						'name'    	   => html_entity_decode($nombre_seleccionado),
						'total'		   => 1, 
						'ajax_url'	   => $ajax_url,
						'tipo'         => $que_buscar,
						'jurjur'	   => $options_final,
						'view'		   => "list",
						'initval'	   => "opened",
						'searchinput'  => "no",	
						);
					
				$this->data['values_no_selected'][]=$opciones;
				
			}	
		} 
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl';
		} else {
				$this->template = 'default/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl';
		}
				$this->response->setOutput($this->render());
		
			
	}
	
	}
	
?>