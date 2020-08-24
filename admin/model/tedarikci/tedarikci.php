<?php 
    /**
    * @property MySQL $db
    */
    class ModelTedarikciTedarikci extends Model 
    {
        public function getList($limit = null,$start = null)
        {
            $this->checkDatabase();
            return $this->db->query("SELECT *,(SELECT COUNT(*) FROM ". DB_PREFIX ."product WHERE sku LIKE CONCAT(t.tedarikci_id,'\_%')) stok_adeti FROM " . DB_PREFIX . "tedarikciler t ORDER BY tedarikci_id DESC" . (is_numeric($limit) ? (" LIMIT " . (is_numeric($start) ? " " . $start."," : "") . $limit ) : ""))->rows;

        }

        public function getById($tedarikci_id)
        {
            return $this->db->query("SELECT * FROM " . DB_PREFIX . "tedarikciler WHERE tedarikci_id = " . (int)$tedarikci_id)->row;
        }

        public function updated($tedarikci_id)
        {
            return $this->db->query("UPDATE " . DB_PREFIX . "tedarikciler SET tedarikci_son_guncelleme=NOW() WHERE tedarikci_id = " . (int)$tedarikci_id);
        }

        public function insert($data)
        {
            if(is_array($data['tedarikci_xml_match']))
                $data['tedarikci_xml_match'] = json_encode($data['tedarikci_xml_match']);

            return  $this->db->query("INSERT INTO " .  DB_PREFIX . "tedarikciler SET
                tedarikci_adi = '". $this->db->escape($data['tedarikci_adi']) ."',
                tedarikci_xml_adres = '". $this->db->escape($data['tedarikci_xml_adres']) ."',
                tedarikci_xml_match =  '" . $this->db->escape($data['tedarikci_xml_match']) . "' ");
        }   

        public function update($data,$tedarikci_id)
        {

            if(is_array($data['tedarikci_xml_match']))
                $data['tedarikci_xml_match'] = json_encode($data['tedarikci_xml_match']);

            return  $this->db->query("UPDATE " .  DB_PREFIX . "tedarikciler SET
                tedarikci_adi = '". $this->db->escape($data['tedarikci_adi']) ."',
                tedarikci_xml_adres = '". $this->db->escape($data['tedarikci_xml_adres']) ."',
                tedarikci_xml_match =  '" . $this->db->escape($data['tedarikci_xml_match']) . "' 
                WHERE tedarikci_id = " . (int)$tedarikci_id);
        }   

        public function getTotalCount()                                                
        {
            return $this->db->query("SELECT COUNT(*) cnt FROM " . DB_PREFIX . "tedarikciler")->row['cnt'];
        }         

        public function updateXmlMatch($tedarikci_id,$xml_match_array)
        {
            $xml_match_json = json_encode($xml_match_array);
            return $this->updateXmlMatchJson($xml_match_json);
        }

        public function updateXmlMatchJson($tedarikci_id,$xml_match_json)
        {
            return $this->db->query("UPDATE " . DB_PREFIX . "tedarikciler SET tedarikci_xml_match = '" . $this->db->escape($xml_match_json) ."' WHERE tedarikci_id = " . (int) $tedarikci_id );
        }

        public function getXmlMatchJson($tedarikci_id)
        {
            $result = $this->db->query("SELECT tedarikci_xml_match FROM " .  DB_PREFIX . "  WHERE tedarikci_id = " . (int)$tedarikci_id);
            if(isset($result->row) && is_array($result->row) && isset($result->row['tedarikci_xml_match']))
                return    $result->row['tedarikci_xml_match'];

            return null;           
        }

        public function getXmlMatchArray($tedarikci_id)
        {
            return json_decode($this->getXmlMatch($tedarikci_id));
        }
                        
        /// Opencart malı SKU koduna göre ürün vermeyince bunu yazmak zorunda kaldık. Abi sen ne iş yaparsın? niye yazdılar seni ya!
        public function getProductBySKU($sku_code)
        {
            $query = $this->db->query(
            "SELECT DISTINCT *, 
            (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword 
            FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
            WHERE p.sku = '" . $this->db->escape($sku_code) . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

            return $query->row;
        }

        //Tech.
        public function checkDatabase()
        {  
            if(!($this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "tedarikciler'")->row)) 
            {
                $this->db->query("
                    CREATE TABLE " . DB_PREFIX ."tedarikciler(
                    tedarikci_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    tedarikci_adi VARCHAR(255) NOT NULL,
                    tedarikci_xml_adres VARCHAR(255) NOT NULL,
                    tedarikci_son_guncelleme TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE  CURRENT_TIMESTAMP,
                    tedarikci_xml_match TEXT NULL
                    );
                ");
            }  
        }

        public function removeAllData()
        {
            return $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "tedarikciler");
        }

        public function dropModule()
        {
            return $this->db->query("DROP TABLE  IF EXISTS " . DB_PREFIX . "tedarikciler");
        }

        public function resetModule()
        {
            $this->dropModule();
            $this->checkDatabase();
        }

    }
