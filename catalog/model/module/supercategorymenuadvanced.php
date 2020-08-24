<?php
class ModelModuleSuperCategoryMenuAdvanced extends Model {
	
public function getAtributesFiltered($products = array(), $data= array(), $attributes =array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$attributes_data = $this->getCacheSMBD('attribute_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
	
		
		if (!$attributes_data) {	
	
			$attributes_data = array();
			
			$sql = "SELECT pa.text, p.product_id, pa.attribute_id as id
				FROM " . DB_PREFIX . "product_attribute pa
				LEFT JOIN " . DB_PREFIX . "product p ON (pa.product_id=p.product_id) 
				WHERE
				p.product_id IN (".implode(', ',array_values($products)).")
				AND
				pa.attribute_id IN (".implode(', ',array_values($attributes)).")
				AND
				pa.language_id=". (int)$this->config->get('config_language_id');
		
			$query =  $this->db->query($sql);
			$value_total=1;
			
			foreach ($query->rows as $key=> $value){
				if (isset($attributes_data[$value['id']][$value['text']]['total'])){
					$value_total = $attributes_data[$value['id']][$value['text']]['total'] + 1;
				}else{
					$value_total=1;
				}
				
		       $attributes_data[$value['id']][$value['text']] = array(
					'total' => $value_total,
					'text'	=> $value['text'],
					'attribute_id' => $value['id']
				);
			}

			
			
		$this->setCacheSMBD('attribute_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $attributes_data,(int)$data['filter_category_id'],$string);	
		} 	
			
		return $attributes_data;
	
	}

public function getOptionsFiltered($products = array(), $data= array(), $options= array()){
		
		$this->load->model('tool/image');
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		$options_data = array();
		
		$options_data = $this->getCacheSMBD('options_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		if (!$options_data) {
			
		$options_data = array();	
		
			$sql="SELECT ovd.name as name, pov.option_id as id,p.product_id, op.image
			FROM " . DB_PREFIX . "product_option_value pov 
			LEFT JOIN  " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id=ovd.option_value_id) 
			LEFT JOIN " . DB_PREFIX . "product p ON (pov.product_id=p.product_id) 
			LEFT JOIN " . DB_PREFIX . "option_value op ON (pov.option_value_id=op.option_value_id) 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).")
			AND
			pov.option_id IN (".implode(', ',array_values($options)).")
			AND
			pov.quantity > 0 
			AND
			ovd.language_id = " . (int)$this->config->get('config_language_id')."
			ORDER BY op.sort_order ASC";
				
			$query =  $this->db->query($sql);
			$value_total=1;
			
			foreach ($query->rows as $key=> $value){
				if (isset($options_data[$value['id']][$value['name']]['total'])){
					$value_total = $options_data[$value['id']][$value['name']]['total'] + 1;
				}else{
					$value_total=1;
				}
				
				if ($value['image']) {
				$image = $this->model_tool_image->resize($value['image'], 20, 20);
				} else {
				$image= '';
				}
			
			$options_data[$value['id']][$value['name']] = array(
					'total' => $value_total,
					'text'	=> $value['name'],
					'option_id' => $value['id'],
					'image_thumb' =>$image
				);
			}
	
	$this->setCacheSMBD('options_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $options_data,(int)$data['filter_category_id'],$string);	
		
		} 	
		
		
			return $options_data;
	
	}



	public function getManufacturesFiltered($products = array(), $data= array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$manufacturer_data = $this->getCacheSMBD('manufactures_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$manufacturer_data) {	
		
			$manufacturer_data = array();
			
			$sql = "SELECT DISTINCT m.name, p.product_id, m.manufacturer_id
				FROM " . DB_PREFIX . "manufacturer m 
				LEFT JOIN " . DB_PREFIX . "product p ON (m.manufacturer_id=p.manufacturer_id) 
				WHERE
				p.product_id IN (".implode(', ',array_values($products)).") 
				ORDER BY m.sort_order ASC";
		
				$query =  $this->db->query($sql);
				$value_total=0;
			
				foreach ($query->rows as $key=> $value){
					
					if(!empty($manufacturer_data)){
						$value_total = 1;
					
						if(array_key_exists($value['name'],$manufacturer_data)){
						$value_total = $manufacturer_data[$value['name']]['total'] + 1;
						}
									
					}else{
					
						$value_total = 1;
						
					}
						$manufacturer_data[$value['name']] = array(
							'total' => $value_total,
							'name'	=> $value['name'],
							'manufacturer_id' => $value['manufacturer_id']
						);
					
				}
		
			$this->setCacheSMBD('manufactures_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $manufacturer_data,(int)$data['filter_category_id'],$string);	
		
		} 	

			
			return $manufacturer_data;
	
	}
	
	public function getStocksFiltered($products = array(), $data= array(), $recalcular=false){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$stockstatus_data = $this->getCacheSMBD('stocks_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$stockstatus_data) {	
		
		$stockstatus_data = array();
		$sql = "SELECT DISTINCT ss.name, p.product_id, ss.stock_status_id, quantity
			FROM " . DB_PREFIX . "stock_status ss 
			LEFT JOIN " . DB_PREFIX . "product p ON (ss.stock_status_id=p.stock_status_id) 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).")";
	
		   // $this->language->load('module/supercategorymenuadvanced');
			
			$query =  $this->db->query($sql);
			$value_total=0;
			
			foreach ($query->rows as $key=> $value){
				
				if($recalcular){
					($value['quantity'] > 0) ? $name=$this->language->get('in_stock_values') : $name=$value['name'];
				}else{
					$name=$value['name'];
				}
								
				if(!empty($stockstatus_data)){
					$value_total = 1;
				
					if(array_key_exists($name,$stockstatus_data)){
					$value_total = $stockstatus_data[$name]['total'] + 1;
					}
								
				}else{
				
					$value_total = 1;
					
				}
					$stockstatus_data[$name] = array(
						'total' => $value_total,
						'name'	=> $name,
						'stock_status_id' => $value['stock_status_id']
					);
				
			}
			
			
		
		$this->setCacheSMBD('stocks_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $stockstatus_data,(int)$data['filter_category_id'],$string);	
		} 	
						
			return $stockstatus_data;
	

	}
	
	public function getCategoriesFiltered($products = array(), $data= array()){
				
	   $cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$subcategory_data = $this->getCacheSMBD('categories_filtered_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$subcategory_data) {
						
			$subcategory_data = array();
			
			$sql= "SELECT * FROM " . DB_PREFIX . "category c 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (c.category_id =p2c.category_id ) 
			LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
			LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id =c2s.category_id ) 
			WHERE 
			c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			AND
			c.parent_id = '" . (int)$data['filter_category_id'] . "' 
			AND
			p2c.product_id IN (".implode(', ',array_values($products)).")
			AND
			cd.language_id=". (int)$this->config->get('config_language_id') . "
			ORDER BY 
			c.sort_order, LCASE(cd.name)";


			$query =  $this->db->query($sql);
			$value_total=0;
			$subcategory_data = array();
            foreach ($query->rows as $key=> $value){
				
				if(!empty($subcategory_data)){
					$value_total = 1;
				
					if(array_key_exists($value['name'],$subcategory_data)){
					$value_total = $subcategory_data[$value['name']]['total'] + 1;
					}
								
				}else{
				
					$value_total = 1;
					
				}
					$subcategory_data[$value['name']] = array(
						'total' => $value_total,
						'name'	=> $value['name'],
						'category_id' => $value['category_id'],
						'image'=> $value['image']
					);
				
			}
	
			
			$this->setCacheSMBD('categories_filtered_by_products_store('. (int)$this->config->get('config_store_id') .').'.(int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $subcategory_data,(int)$data['filter_category_id'] ,$string);	
		} 	
	
			return $subcategory_data;
	}
		
	

	public function getAttributeName($attribute_id) {
	
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
	return $query->row['name'];
	}
	
	public function getoptionName($option_id) {
	
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "option_description WHERE option_id = '" . (int)$option_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
	return $query->row['name'];
	}
	
	public function getoptionImage($option_id,$option_name) {
	
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "option_value ov 
		LEFT JOIN  " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id=ovd.option_value_id) 
		WHERE ov.option_id = '" . (int)$option_id . "'
		AND LCASE(ovd.name) = '" . $this->db->escape(utf8_strtolower(str_replace("&amp;","&",$option_name))) . "'
		AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
		$this->load->model('tool/image');
			if ($query->row['image']) {
				$image = $this->model_tool_image->resize($query->row['image'], 20, 20);
			} else {
				$image= '';
			}
		
		return $image;
	
	}
	
	
	public function getCategoryName($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->row['name'];
	}
	
	
	
	public function getProductsFiltered($data = array(),$clearance_id, $days) {
	
		$cache = md5(http_build_query($data));
		$string = http_build_query($data);	
		
		$product_data = $this->getCacheSMBD('product_filters_store('. (int)$this->config->get('config_store_id') .').'.(int)$data['filter_category_id'].'.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
	
         if (!$product_data) {
	
	
			if (!empty($data['filter_special'])){
				
				$product_id_NO_seleccionados=$this->GetProductsFilteredSpecial($data,$clearance_id, $days);
			
			}else{
				$Products_with_price_filtered=$this->GetProductsFilteredPrice($data,$clearance_id, $days);
				$Products_with_special_price_filtered=$this->GetProductsFilteredSpecial($data,$clearance_id, $days);
     			$product_id_NO_seleccionados=array_merge((array)$Products_with_price_filtered,(array)$Products_with_special_price_filtered);
				
			}
			
	
		if (!empty($data['filter_by_name'])) {
				
				$explode_data=array();
				$explode_data= explode("@@@",$data['filter_by_name']);
				$explode_data2=array();
				$explode_data2= explode(",",$data['filter_ids']);
				$i=0;
				$products_id_seleccionados=array();


				foreach ($explode_data as  $explode){
				 $products_id_query=array();
				
					$pos = strpos($explode,'OPTTOP');
					if ($pos !== false) {// is an option
					
						$sql="SELECT pov.product_id 
						FROM " . DB_PREFIX . "product_option_value pov 
						LEFT JOIN  " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id=ovd.option_value_id) 
						LEFT JOIN " . DB_PREFIX . "product p ON (pov.product_id = p.product_id)  
						LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
						WHERE
						pov.option_id = '" . (int)$explode_data2[$i] . "' 
						AND	ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'
					    AND p.status = '1' 
						AND pov.quantity > 0 
						AND p.date_available <= NOW() 
						AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
						
						//FIX for empty attribute values.
							if ($explode=="NDDDDDNOPTTOP"){
								$sql.=" AND LCASE(ovd.name)='' GROUP BY product_id";
							}else{
							
								$sql.=" AND LCASE(ovd.name) = '" . $this->db->escape(utf8_strtolower(substr(str_replace("&amp;","&",$explode),0,-6))) . "' GROUP BY product_id";
								
							}
											
					}
				
					$pos = strpos($explode,'ATTNNATT');
					if ($pos !== false) {// is an attribute
				
							$sql= "SELECT p.product_id
							FROM " . DB_PREFIX . "product_attribute pa 
							LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) 
							LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) 
							LEFT JOIN " . DB_PREFIX . "product p ON (pa.product_id = p.product_id)  
							LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
							WHERE
							pa.attribute_id = '" . (int)$explode_data2[$i] . "'
							AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' 
							AND p.status = '1' 
							AND p.date_available <= NOW() 
							AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
							
							//FIX for empty attribute values.
							if ($explode=="NDDDDDNATTNNATT"){
								$sql.=" AND LCASE(pa.text)='' GROUP BY product_id";
							}else{
							
								if (strpos($explode, "SPER")){
									/*	QUERY FOR NO ROBUST DATA FOR CORRECT PATTERN */
																	
									$sql.="	AND LCASE(pa.text) LIKE '%" . $this->db->escape(utf8_strtolower(substr(str_replace("&amp;","&",$explode),0,-12))) . "%' GROUP BY product_id"; 
									/*	QUERY FOR ROBUST DATA FOR CORRECT PATTERN 
									
									IF YOU ARE USING CORRECT PATTERN VALUE SPACE SEPARTOR SPACE VALUE ETC... UNCOMENT NEXT QUERY AND COMENT PREVIOUS QUERY SO THIS WILL FIX
									TO SEARCH VALUES WITH SIMILAR VALUES ON SEPARATOR RECORD */
									//$sper_value=utf8_strtolower(substr(str_replace("&amp;","&",$explode),0,-12));

									//$sql.="   AND (LCASE(pa.text) LIKE '" . $sper_value. " %'  OR LCASE(pa.text) LIKE '% " . $sper_value. "'  OR LCASE(pa.text) LIKE '% " . $sper_value. " %' )  GROUP BY product_id";
								}else{
									$sql.=" AND LCASE(pa.text) = '" . $this->db->escape(utf8_strtolower(substr(str_replace("&amp;","&",$explode),0,-8))) . "' GROUP BY product_id";
								}
							}
					
					}
					
	
					
						$query2 =  $this->db->query($sql);
			
						foreach ($query2->rows as $key=> $value) {
							$products_id_query[$key] = $value['product_id'];
					    }
			
				
						if(empty($products_id_seleccionados)){
						    $products_id_seleccionados =$products_id_query;
						}else{
							$products_id_seleccionados =array_intersect((array)$products_id_seleccionados,$products_id_query);
						}
					$i++;
					}
			 
			 		$result = array_intersect($product_id_NO_seleccionados, $products_id_seleccionados);
			
						 foreach ($result as $key=> $value) {
				 			    $product_data[$key] = $value;
							}
			
			}else{

			
				$product_data = array();
				foreach ($product_id_NO_seleccionados as $result) {
					
					$product_data[$result] = $result;
					
				}
				
				
		}
				
				
		 $this->setCacheSMBD('product_filters_store('. (int)$this->config->get('config_store_id') .').'.(int)$data['filter_category_id'].'.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $product_data,(int)$data['filter_category_id'],$string);
			
		} 
			
		return $product_data;
	}
	
	
	
	private function GetProductsFilteredPrice($data = array(), $clearance_id,$days=7){
			if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
			
			 
			$sql = "SELECT p.product_id,(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, p.price AS price FROM " . DB_PREFIX . "product p 
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id)"; 
									
				if (!empty($data['filter_category_id'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
				}
				
				if(version_compare(VERSION,'1.5.4','<')) {
		     		if (!empty($data['filter_tag'])) {
						$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id)";			
					}	
				}
						
			$sql .= " 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p.status = '1' 
			AND p.date_available <= NOW() 
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
	       
		    if (!empty($data['filter_category_id']) and $data['filter_category_id']!=0) {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
					
			if (!empty($data['filter_manufacturers_by_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturers_by_id'] . "'";
			}
			
			if (!empty($data['filter_stock_id'])) {
				$sql .= " AND p.stock_status_id = '" . (int)$data['filter_stock_id'] . "'";
			}
          		   												
			
			if (isset($data['filter_min_price']) && !empty($data['filter_max_price'])) {
				
				$sql .= " AND p.price BETWEEN ".$data['filter_min_price']." AND ".$data['filter_max_price'];
			
			}
			
			if (!empty($data['filter_stock'])) {
				
				$sql .= " AND p.quantity > 0";
			
			}
			
			if (!empty($data['filter_clearance'])) {
				
				$sql .= " AND  p.stock_status_id='".$clearance_id."'";
			
			}
			if (!empty($data['filter_arrivals'])) {
				
				$sql .= " AND p.date_added >DATE_SUB(CURDATE(), INTERVAL ".$days." DAY)";
			
			}
			
			
			if(version_compare(VERSION,'1.5.4','<')) {
			
					if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
						$sql .= " AND (";
													
						if (!empty($data['filter_name'])) {
							$implode = array();
							
							$words = explode(' ', $data['filter_name']);
							
							foreach ($words as $word) {
								if (!empty($data['filter_description'])) {
									$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR  LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
								} else {
									$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR  LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
								}				
							}
							
							if ($implode) {
								$sql .= " " . implode(" OR ", $implode) . "";
							}
						}
						
						if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
							$sql .= " OR ";
						}
						
						if (!empty($data['filter_tag'])) {
							$implode = array();
							
							$words = explode(' ', $data['filter_tag']);
							
							foreach ($words as $word) {
								$implode[] = "LCASE(pt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
							}
							
							if ($implode) {
								$sql .= " " . implode(" OR ", $implode) . "";
							}
						}
					
						$sql .= ")";
					}
			
			
			}else{
			
					if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
						$sql .= " AND (";
						
						if (!empty($data['filter_name'])) {					
							if (!empty($data['filter_description'])) {
								$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(pd.description) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
							} else {
								$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
							}
						}
						
						if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
							$sql .= " OR ";
						}
						
						if (!empty($data['filter_tag'])) {
							$sql .= "MATCH(pd.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
						}
					
						$sql .= ")";
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}	
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}		
		
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
		
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}		
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}					
					}
					
			
			}
			
			
			$sql .= " GROUP BY p.product_id";

			
(isset($data['filter_min_price']) && !empty($data['filter_min_price'])) ? $min_price=$data['filter_min_price'] : $min_price="no";
			!empty($data['filter_max_price'])? $max_price=$data['filter_max_price'] : $max_price="no";
			
			
	 		$product_data = array();
	 		$query = $this->db->query($sql);

			
			foreach ($query->rows as $key=> $value) {
				
			
				if ($min_price=="no"){
					$product_data["p".$value['product_id']] = $value['product_id'];
					
				}else{
					
					!empty($value['special']) ? $special_price=$value['special'] : $special_price=$min_price;
					
					if (($value['price'] <= $max_price || $value['price'] >= $max_price ) && ($special_price >= $min_price )){
					
						 $product_data["p".$value['product_id']] = $value['product_id'];
						
					}
					
				}
			}

	return	$product_data;

	

	}
	
	
	public  function GetProductsFilteredSpecial($data = array(), $clearance_id,$days=7){
		
			if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$sql = "SELECT p.product_id,ps.price AS special, p.price AS price FROM " . DB_PREFIX . "product p 
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id)"; 
									
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
			
			if(version_compare(VERSION,'1.5.4','<')) {
		     		if (!empty($data['filter_tag'])) {
						$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id)";			
					}	
				}
			
			
			$sql .= " WHERE ps.customer_group_id = '" . (int)$customer_group_id . "' 
			AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p.status = '1' AND p.date_available <= NOW() 
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))"; 
			
				
	        if (!empty($data['filter_category_id']) and $data['filter_category_id']!=0) {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
					
			if (!empty($data['filter_manufacturers_by_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturers_by_id'] . "'";
			}
			
			if (!empty($data['filter_stock_id'])) {
				$sql .= " AND p.stock_status_id = '" . (int)$data['filter_stock_id'] . "'";
			}
          		   												
			
			if (isset($data['filter_min_price']) && !empty($data['filter_max_price'])) {
				
				$sql .= "AND (ps.price BETWEEN ".$data['filter_min_price']." AND ".$data['filter_max_price'].") ";
			
			}
			if (!empty($data['filter_stock'])) {
				
				$sql .= " AND p.quantity > 0";
			
			}
			
			if (!empty($data['filter_clearance'])) {
				
				$sql .= " AND  p.stock_status_id='".$clearance_id."'";
			
			}
			if (!empty($data['filter_arrivals'])) {
				
				$sql .= " AND p.date_added >DATE_SUB(CURDATE(), INTERVAL ".$days." DAY)";
			
			}
			
			
			if(version_compare(VERSION,'1.5.4','<')) {
			
					if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
						$sql .= " AND (";
													
						if (!empty($data['filter_name'])) {
							$implode = array();
							
							$words = explode(' ', $data['filter_name']);
							
							foreach ($words as $word) {
								if (!empty($data['filter_description'])) {
									$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR  LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
								} else {
									$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR  LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
								}				
							}
							
							if ($implode) {
								$sql .= " " . implode(" OR ", $implode) . "";
							}
						}
						
						if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
							$sql .= " OR ";
						}
						
						if (!empty($data['filter_tag'])) {
							$implode = array();
							
							$words = explode(' ', $data['filter_tag']);
							
							foreach ($words as $word) {
								$implode[] = "LCASE(pt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
							}
							
							if ($implode) {
								$sql .= " " . implode(" OR ", $implode) . "";
							}
						}
					
						$sql .= ")";
					}
			
			
			}else{
			
					if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
						$sql .= " AND (";
						
						if (!empty($data['filter_name'])) {					
							if (!empty($data['filter_description'])) {
								$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(pd.description) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
							} else {
								$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
							}
						}
						
						if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
							$sql .= " OR ";
						}
						
						if (!empty($data['filter_tag'])) {
							$sql .= "MATCH(pd.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
						}
					
						$sql .= ")";
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}	
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}		
		
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
		
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}		
						
						if (!empty($data['filter_name'])) {
							$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
						}					
					}
					
			
			}
			
			
			
			$sql .= " GROUP BY p.product_id";
			
		
    		
			(isset($data['filter_min_price']) && !empty($data['filter_min_price'])) ? $min_price=$data['filter_min_price'] : $min_price="no";
			!empty($data['filter_max_price'])? $max_price=$data['filter_max_price'] : $max_price="no";
			
			
	 		$product_data = array();
	 		$query = $this->db->query($sql);
			foreach ($query->rows as $key=> $value) {
				
			
				if ($min_price=="no"){
					 $product_data["p".$value['product_id']] = $value['product_id'];
					
				}else{
					if ($value['special'] <= $min_price || $value['special'] >= $min_price ){
						$product_data["p".$value['product_id']] = $value['product_id'];
					}
					
				}
			}

	
	return	$product_data;

	

	}
	
	
	public function CleanName($str){
	
	$str_to_clean=$str;
	$search  = array('%25','%2B','%26quot%3B','&quot;','%26amp%3B');
	$replace = array('%','+','"','"',"&");
		return str_replace($search, $replace,$str_to_clean);
	}
	
	public function SeoFix($str){
	
		$str_seo_fix=$str;
	
		$search  = array("%20","%23","%24","%25","%26","%40","%60","%2F","%3A","%3B","%3C","%3D","%3E","%3F","%5B","%5C","%5D","%5E","%7B","%7C","%7D","%7E","%22","%27","%2B","%2C");
		$replace = array("%2520","%2523","%2524","%2525","%2526","%2540","%2560","%252F","%253A","%253B","%253C","%253D","%253E","%253F","%255B","%255C","%255D","%255E","%257B","%257C","%257D","%257E","%2522","%2527","%252B","%252C");

		if ($this->config->get('config_seo_url')){
			return str_replace($search, $replace,$str_seo_fix);
		}else{
			return $str_seo_fix;
		}
	
	}
	
	public function formatMoney($number) {
	    return ($number*$this->currency->getValue());
  	}
	public function UnformatMoney($number,$currency='') {
	    return ($number/$this->currency->getValue($currency));
  	}
	
	
	
function getRanges($intMin,$intMax,$intRanges=3,$prices=array(),$productos = array(),$currency,$is_tax,$tax_id) {
    $intRange = $intMax-$intMin;
    $intIncrement = ceil(abs($intRange/$intRanges));
    $arrRanges = array(); $arrPrices=array();
	if ($intIncrement < 5){ //the minimun between min and max must be 10
		 
		$arrRanges[]=$intMax;
		   
		   $f_min_price=$this->UnformatMoney($intMin,$currency);
		   $f_max_price=$this->UnformatMoney($intMax,$currency);
		   
		    if ( $this->config->get('config_tax') && $is_tax) {
				    $tax_value= $this->tax->calculate(1, $tax_id, $this->config->get('config_tax'));
					$f_min_price=floor( $f_min_price/$tax_value ); 
					$f_max_price=ceil( $f_max_price/$tax_value );
			}
		
		$arrayPrices[]=array(
				'prices'	=> "%s".$intMin."%s",
				'intMax' 	=> $intMax,
				'intMin' 	=> $intMin,
				'total' 	=> (int)$this->getTotalPrices($f_min_price,$f_max_price,$productos),
			);
		
		
	}else{
	
		for($i=0;$i<$intRanges;$i++) {
			$arrRanges[] = $i==0 || $i==($intRanges-1)?$i==0?$intMin:$intMax:$intMin+($i*$intIncrement);
		}
	
	    $j=0;
        foreach($arrRanges as $key=>$value) { 
		
		if ($j == count($arrRanges)-1){
             break;
        }else{
           
		   $intMin = $key == 0?$value:$arrRanges[($key)];
		   $intMax = $arrRanges[($key+1)];
           $f_min_price=$this->UnformatMoney($intMin,$currency);
		   $f_max_price=$this->UnformatMoney($intMax,$currency);
		   
		    if ( $this->config->get('config_tax')&& $is_tax) {
				    $tax_value= $this->tax->calculate(1, $tax_id, $this->config->get('config_tax'));
					$f_min_price=floor( $f_min_price/$tax_value ); 
					$f_max_price=ceil( $f_max_price/$tax_value );
			}
			   
		  	$arrayPrices[]=array(
				'prices'	=> "%s".$intMin."%s - %s".$intMax."%s",
				'intMax' 	=> $intMax,
				'intMin' 	=> $intMin,
				'total' 	=> (int)$this->getTotalPrices($f_min_price,$f_max_price,$productos),
			);
				  
		  $j++;
		}
		}
}
  //Calculate the numer of products
  return $arrayPrices;

}

public function getTotalPrices($intMin,$intMax,$productos){

		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

			$products_count=array();
	
			
			$sql= "SELECT ps.product_id FROM  " . DB_PREFIX . "product_special ps 
			LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = ps.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			AND p.status = '1' AND p.date_available <= NOW() 
			WHERE
			ps.customer_group_id = '" . (int)$customer_group_id . "'
			AND
			ps.product_id IN (".implode(', ',array_values($productos)).") 
			AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))		
			AND ps.price BETWEEN ".$intMin." AND ".$intMax." ";
			
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $key=> $value){
				$products_count[$value['product_id']]=$value['product_id'];
			}
	
			$sql = "SELECT p.product_id,(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND
			ps.product_id IN (".implode(', ',array_values($productos)).") AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, p.price AS price FROM " . DB_PREFIX . "product p 
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
				LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id)									
				 
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND p.status = '1' 
			AND p.date_available <= NOW() 
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			AND
			p.product_id IN (".implode(', ',array_values($productos)).") 
			AND p.price BETWEEN ".$intMin." AND ".$intMax."";
			
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $key=> $value){
			
				if(isset($value['special'])){
					
					if ($value['special'] >= $intMin){
						$products_count[$value['product_id']]=$value['product_id'];
					}
					
					
				}else{
				$products_count[$value['product_id']]=$value['product_id'];
				}
			}
		return count($products_count);
		
	}
	
	
	public function getProductsPriceandSpecial($products = array(), $data= array()){
	
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
	    $cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$prices_data = $this->getCacheSMBD('Prices_filtered_by_products_store('. (int)$this->config->get('config_store_id') .')_customer('.$customer_group_id.').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$prices_data) {
			
			$prices= array();
			$special_prices= array();
			
			$sql= "SELECT p.price, p.product_id FROM  " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.product_id IN (".implode(', ',array_values($products)).") ORDER BY p.price DESC";
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $key=> $value){
				$prices[$value['product_id'].'id']=$value['price'];
			}
			
			
			$sql= "SELECT ps.price, ps.product_id FROM  " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (ps.product_id = p2s.product_id) WHERE  ps.customer_group_id = '" . (int)$customer_group_id . "' AND ps.product_id IN (".implode(', ',array_values($products)).") AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))		
			ORDER BY ps.price DESC";
			
			$query = $this->db->query($sql);
			
			
			if ($query->rows){
				foreach ($query->rows as $key=> $value){
					$special_prices[$value['product_id'].'id']=$value['price'];
				}
			}
			
			
			$new_array=array_merge($prices,$special_prices);
			$prices_data=array();
			$prices_data = array(
				'PriceMax' => max($new_array),
				'PriceMin'	=> min($new_array)
			);
			
				
			$this->setCacheSMBD('Prices_filtered_by_products_store('. (int)$this->config->get('config_store_id') .')_customer('.$customer_group_id.').'.(int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $prices_data,(int)$data['filter_category_id'] ,$string);	
	}
	
			return $prices_data;
	}
	
		
	public function calculateTAX($price,$taxclass_id){
    	$tax_rates= $this->tax->getRates(100,$taxclass_id);
		$amount=0;
		foreach ($tax_rates as $tax_rate) {
			if ($tax_rate['type'] == 'F') {
				$amount += $tax_rate['amount'];
			//$price=$price-$tax_rate['amount'];echo "<br>";
			} elseif ($tax_rate['type'] == 'P') {
		
				$amount += ($price / 100 * $tax_rate['amount']);
		
			}
			
		}
	return	$price-$amount;
		
	}
    public function getCacheSMBD($key,$cat) {
				
		$query = $this->db->query("SELECT data,cache_id FROM " . DB_PREFIX . "cache_supercategory cs WHERE cs.cat = '" . $cat . "' AND cs.name = '" . $key. "' LIMIT 1");
		if ($query->num_rows) {
			$this->db->query("UPDATE " . DB_PREFIX . "cache_supercategory cs SET cs.cached=cs.cached+1 WHERE cs.cache_id = '" . $query->row['cache_id'] . "'");
			return unserialize($query->row['data']);
		}
	}

  	public function setCacheSMBD($key,$value,$cat,$string) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "cache_supercategory WHERE name LIKE  '" . $key . "%'");
		
		if($this->config->get('supercategorymenuadvanced_mode')=="Production"){
			$this->db->query("INSERT INTO " . DB_PREFIX . "cache_supercategory 
			SET 
			`cache_id` = '', 
			`cat` = '" . $this->db->escape($cat) . "', 
			`name` = '" . $this->db->escape($key) . "', 
			`string` = '" . $this->db->escape($string) . "', 
			`data` = '" . $this->db->escape(serialize($value)) . "'");
		}
	}
	
	public function getStocksSpecial($products = array(), $data= array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$special_data = $this->getCacheSMBD('specialprice_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
	
		
		if (!$special_data) {	
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}		
			
			$special_data = array();
			
			$sql = "SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps 
			LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).") AND
			p.status = '1' AND 
			p.date_available <= NOW() AND 
			p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND 
			ps.customer_group_id = '" . (int)$customer_group_id . "' 
			AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
				
			$query = $this->db->query($sql);
			
			
			if (isset($query->row['total'])) {
				$special_data= $query->row['total'];
			} else {
				$special_data= "no_special";	
			}
				
		$this->setCacheSMBD('specialprice_filters_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $special_data,(int)$data['filter_category_id'],$string);	
		} 	
			
		return $special_data;
	
	}
	
	
	public function getStocksClearance($products = array(), $data= array(), $clearance_id){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$clearance_data = $this->getCacheSMBD('clearance_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$clearance_data) {	
		
		$clearance_data = array();
		
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).")
			AND p.stock_status_id='".$clearance_id."'";
				
			$query =  $this->db->query($sql);
			if (isset($query->row['total'])) {
				$clearance_data= $query->row['total'];
			} else {
				$clearance_data= "no_clearance";	
			}
			
		
		$this->setCacheSMBD('stocks_by_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $clearance_data,(int)$data['filter_category_id'],$string);	
		} 	
						
			return $clearance_data;
	

	}
	
	
	public function getStocksInStock($products = array(), $data= array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$stockstatus_data = $this->getCacheSMBD('instock_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$stockstatus_data) {	
		
		
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).")
			AND p.quantity >0";
		
		 $query =  $this->db->query($sql);
			if (isset($query->row['total'])) {
				$stockstatus_data= $query->row['total'];
			} else {
				$stockstatus_data= "no_stock";	
			}
			
			
			
		
		$this->setCacheSMBD('instock_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $stockstatus_data,(int)$data['filter_category_id'],$string);	
		} 	
						
			return $stockstatus_data;

	

	}
	
	
	
	public function getStocksArrivals($products = array(), $data= array(),$days=7){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data); 
		
		$new_arribals_data = $this->getCacheSMBD('new_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
				
		if (!$new_arribals_data) {	
				
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p 
			WHERE
			p.product_id IN (".implode(', ',array_values($products)).")
			AND p.date_added >DATE_SUB(CURDATE(), INTERVAL ".$days." DAY)";
		
		 $query =  $this->db->query($sql);
			if (isset($query->row['total'])) {
				$new_arribals_data= $query->row['total'];
			} else {
				$new_arribals_data= "no_new";	
			}
					
		$this->setCacheSMBD('new_products_store('. (int)$this->config->get('config_store_id') .').'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $new_arribals_data,(int)$data['filter_category_id'],$string);	
		} 	
						
		return $new_arribals_data;
	}


}
?>
