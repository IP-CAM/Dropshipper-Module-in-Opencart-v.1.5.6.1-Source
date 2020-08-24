<?php
class ModelModuleSuperCategoryMenuAdvancedCache extends Model {
	
public function getAtributesFiltered($products = array(), $data= array(), $attributes =array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$attributes_data = $this->getCacheSMBD('attribute_filters.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
	
		
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

			
			
		$this->setCacheSMBD('attribute_filters.'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $attributes_data,(int)$data['filter_category_id'],$string);	
		} 	
			
		return $attributes_data;
	
	}

public function getOptionsFiltered($products = array(), $data= array(), $options= array()){
		
		$this->load->model('tool/image');
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		$options_data = array();
		
		$options_data = $this->getCacheSMBD('options_filters.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
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
			ovd.language_id = " . (int)$this->config->get('config_language_id');
				
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
	
	$this->setCacheSMBD('options_filters.'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $options_data,(int)$data['filter_category_id'],$string);	
		
		} 	
		
		
			return $options_data;
	
	}



	public function getManufacturesFiltered($products = array(), $data= array()){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$manufacturer_data = $this->getCacheSMBD('manufactures_by_products.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$manufacturer_data) {	
		
			$manufacturer_data = array();
			
			$sql = "SELECT DISTINCT m.name, p.product_id, m.manufacturer_id
				FROM " . DB_PREFIX . "manufacturer m 
				LEFT JOIN " . DB_PREFIX . "product p ON (m.manufacturer_id=p.manufacturer_id) 
				WHERE
				p.product_id IN (".implode(', ',array_values($products)).")";
		
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
		
			$this->setCacheSMBD('manufactures_by_products.'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $manufacturer_data,(int)$data['filter_category_id'],$string);	
		
		} 	

			
			return $manufacturer_data;
	
	}
	
	public function getStocksFiltered($products = array(), $data= array(), $recalcular=false){
		
		$cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$stockstatus_data = $this->getCacheSMBD('stocks_by_products.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
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
			
			
		
		$this->setCacheSMBD('stocks_by_products.'. (int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $stockstatus_data,(int)$data['filter_category_id'],$string);	
		} 	
						
			return $stockstatus_data;
	

	}
	
	public function getCategoriesFiltered($products = array(), $data= array()){
				
	   $cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$subcategory_data = $this->getCacheSMBD('categories_filtered_by_products.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$subcategory_data) {
						
			$subcategory_data = array();
			
			$sql= "SELECT * FROM " . DB_PREFIX . "category c 
			LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (c.category_id =p2c.category_id ) 
			LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
			WHERE 
			c.parent_id = '" . (int)$data['filter_category_id'] . "' 
			AND
			p2c.product_id IN (".implode(', ',array_values($products)).")
			and cd.language_id=". (int)$this->config->get('config_language_id') . "
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
						'category_id' => $value['category_id']
					);
				
			}
	
			
			$this->setCacheSMBD('categories_filtered_by_products.'.(int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $subcategory_data,(int)$data['filter_category_id'] ,$string);	
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
	
	public function getProductsFiltered($data = array()) {
		
	$cache = md5(http_build_query($data));
	$string = http_build_query($data);	
		
		$product_data = $this->getCacheSMBD('product_filters.'.(int)$data['filter_category_id'].'.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
	
		
		if (!$product_data) {
			$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			 LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id)"; 
									
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
			if (!empty($data['filter_tag'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id)";			
			}	
					
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
			
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
				
				$sql .= " AND ( p.price BETWEEN ".$data['filter_min_price']." AND ".$data['filter_max_price']." OR ( ps.price BETWEEN ".$data['filter_min_price']." AND ".$data['filter_max_price']." AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())))  )";
				
		
			}
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
											
				if (!empty($data['filter_name'])) {
					$implode = array();
					
					$words = explode(' ', $data['filter_name']);
					
					foreach ($words as $word) {
						if (!empty($data['filter_description'])) {
							// $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
							$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR  LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
						} else {
							// $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' ";
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
			
			
			
			$sql .= " GROUP BY p.product_id";
			
			//echo $sql;
			
			
     		$product_data = array();
					
     		$query = $this->db->query($sql);
			
			foreach ($query->rows as $key=> $value) {
				if (isset($data['filter_min_price']) && !empty($data['filter_max_price'])) {//clean prices out of filter
				if ($value['special']<$data['filter_min_price'] || $value['price']<$data['filter_min_price'] || $value['special']>$data['filter_max_price']|| $value['special']>$data['filter_max_price']){							             
				}else{ 
					$product_id_NO_seleccionados[$key] = $value['product_id'];
					}
				}else{
					$product_id_NO_seleccionados[$key] = $value['product_id'];
					
				}
				
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
									$sql.="	AND LCASE(pa.text) LIKE '%" . $this->db->escape(utf8_strtolower(substr(str_replace("&amp;","&",$explode),0,-12))) . "%' GROUP BY product_id";
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
				foreach ($query->rows as $result) {
				
				
				if (isset($data['filter_min_price']) && !empty($data['filter_max_price'])) {//limpiamos los productos que no esten en este rango de precios.
				
					if ($result['special']<$data['filter_min_price'] || $result['price']<$data['filter_min_price'] || $result['special']>$data['filter_max_price']|| $result['special']>$data['filter_max_price']){       
					}else{
					$product_data[$result['product_id']] = $result['product_id'];
					}
				}else{
				
				$product_data[$result['product_id']] = $result['product_id'];
				}
				
				
				
				}
				
				
			}
				

		 $this->setCacheSMBD('product_filters.'.(int)$data['filter_category_id'].'.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $product_data,(int)$data['filter_category_id'],$string);
			
		} 
			
		return $product_data;
	}
	
	
	public function CleanName($str){
	
	$str_to_clean=$str;
	$search  = array('%25','%2B','%26quot%3B','&quot;');
	$replace = array('%','+','"','"');

		return str_replace($search, $replace,$str_to_clean);
	}
	
	
	
	public function formatMoney($number) {
	    return ($number*$this->currency->getValue());
  	}
	public function UnformatMoney($number,$currency='') {
	    return ($number/$this->currency->getValue($currency));
  	}
	
	
	public function getProductsPriceandSpecial($products = array(), $data= array()){
				
	    $cache = md5(http_build_query($data));
	    $string=http_build_query($data);
		
		$prices_data = $this->getCacheSMBD('Prices_filtered_by_products.'. (int)$data['filter_category_id'] . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache,(int)$data['filter_category_id']);
		
		
		if (!$prices_data) {
			
			$prices= array();
			$special_prices= array();
			
			$sql= "SELECT p.price, p.product_id FROM  " . DB_PREFIX . "product p where p.product_id IN (".implode(', ',array_values($products)).") ORDER BY p.price DESC";
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $key=> $value){
				$prices[$value['product_id'].'id']=$value['price'];
			}
			
			
			$sql= "SELECT ps.price, ps.product_id FROM  " . DB_PREFIX . "product_special ps where ps.product_id IN (".implode(', ',array_values($products)).")
			AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))		
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
			
				
			$this->setCacheSMBD('Prices_filtered_by_products.'.(int)$data['filter_category_id'] . '.'  . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . $cache, $prices_data,(int)$data['filter_category_id'] ,$string);	
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
	
  
	

	
	
}

?>
