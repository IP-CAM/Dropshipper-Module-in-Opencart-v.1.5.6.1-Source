<?php 
    /**
    * @property ModelTedarikciTedarikci $model_tedarikci_tedarikci
    * @property ModelCatalogProduct $model_catalog_product
    * @property Request $r6sequest;
    */
    class ControllerTedarikciTedarikci extends Controller 
    { 
        private $error = array();

        public function index() 
        {

            $this->load->model('tedarikci/tedarikci');
            $this->template = 'tedarikci/tedarikci_list.tpl';

            $this->children = array(
                'common/header',
                'common/footer'
            );

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }



            $this->data['error_warning'] = "" ;  
            $this->data['success'] = "" ;
            $this->data['text_no_results'] = "Kayıtlı tedarikçi yok." ;

            $this->data['yeni_tedarikci_link'] = $this->url->link('tedarikci/tedarikci/add', 'token=' . $this->session->data['token'], 'SSL') ;
            $this->data['tedarikci_sil_link'] = $this->url->link('tedarikci/tedarikci/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

            $this->data['success'] = "" ;
            $this->data['heading_title'] = "Tedarikçim" ;
            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_home'),
                'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text'      => "Tedarikçim",
                'href'      => $this->url->link('tedarikci/tedarikci', 'token=' . $this->session->data['token'] . $url, 'SSL'),
                'separator' => ' :: '
            );


            //var_dump($this);       


            $limit =   $this->config->get('config_admin_limit');
            $start = ($page - 1) *  $limit;

            $tedarikciler  = $this->model_tedarikci_tedarikci->getList($limit,$start);
            foreach($tedarikciler as &$tedarikci)
            {
                $tedarikci['edit_url'] = $this->url->link('tedarikci/tedarikci/update', 'token=' . $this->session->data['token'] . '&tedarikci_id=' . $tedarikci['tedarikci_id'] . $url, 'SSL');
            }

            $this->data['update_stock_link'] = str_replace('&amp;','&',$this->url->link('tedarikci/tedarikci/updateProducts', 'token=' . $this->session->data['token'], 'SSL'));

            $this->data['tedarikciler'] = $tedarikciler;

            $pagination = new Pagination();
            $pagination->total = $this->model_tedarikci_tedarikci->getTotalCount();
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('tedarikci/tedarikci', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');



            $this->data['pagination'] = $pagination->render();

            $this->response->setOutput($this->render());
        }



        public function add()
        {                                                     

            $this->data['error_warning'] = "" ;  
            $this->data['success'] = "" ;

            if(isset($_POST) && $_POST && $this->validateForm())
            {

                $this->load->model('tedarikci/tedarikci'); 
                $tedarikci_data = $this->request->post['tedarikci'];
                $tedarikci_data['tedarikci_xml_match'] = $this->request->post['fields'];

                $this->model_tedarikci_tedarikci->insert($tedarikci_data);

                $this->data['success'] = "Kayıt Başarıyla Eklendi." ;
            }



            $this->data['heading_title'] = "Yeni Tedarikçi" ;
            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_home'),
                'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text'      => "Tedarikçim",
                'href'      => $this->url->link('tedarikci/tedarikci', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );

            $this->data['breadcrumbs'][] = array(
                'text'      => "Yeni Tedarikçi",
                'href'      => $this->url->link('tedarikci/tedarikci/add', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );


            $this->children = array(
                'common/header',
                'common/footer'
            );

            $this->data['xml_ajax_url'] = str_replace('&amp;','&',$this->url->link('tedarikci/tedarikci/getxmltable', 'token=' . $this->session->data['token'], 'SSL'));

            $this->template = 'tedarikci/tedarikci_form.tpl';
            $this->response->setOutput($this->render());
        }

        public function validateForm()
        {
            if(!isset($_POST['fields']) || !is_array($_POST['fields']))
            {
                $this->data['error_warning'] = "XML Sütunları eşleştirilmemiş.";
                return false;
            }

            if(!isset($_POST['tedarikci']) || !is_array($_POST['tedarikci']))
            {   
                $this->data['error_warning'] = "Tüm alanları doldurunuz.";
                return false;
            }

            if(!isset($_POST['tedarikci']['tedarikci_adi']))
            {   
                $this->data['error_warning'] = "Tedarikçi adını girmediniz.";
                return false;
            }   

            return true;

        }

        public function getxmltable()
        {
            if(isset($_POST) && isset($_POST['address']))
            {
                $xml_address = $_POST['address'];

                if(!strpos($xml_address,'&gt;'))
                {
                    die('<div class="warning">XML Path Tanımlamadınız.</div>');
                }
                else{

                    list($xml,$root) = explode('&gt;',$xml_address);


                    $xml =  simplexml_load_file($xml);   
                    $xml = get_object_vars($xml);
                    $urunler = $xml[$root];
                    $keys = array_keys( get_object_vars( $urunler[0]));
                    $select = '<option value="">Seçiniz..</option>';
                    foreach($keys as $key)
                        $select .='<option>'.$key.'</option>';

                ?>
                <table class="list">
                    <thead>
                        <tr><td>Alan</td><td>Xml Eşleşmesi</td></tr>
                    </thead>                          
                    <tbody>
                        <tr><td>Ürün Adı</td><td><select name="fields[URUN_AD]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Ürün Kodu</td><td><select name="fields[KOD]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Marka</td><td><select name="fields[MARKA]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Açıklama</td><td><select name="fields[ACIKLAMA]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Kategori ID</td><td><select name="fields[KATEGORI_ID]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Stok</td><td><select name="fields[STOK]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Kdv</td><td><select name="fields[KDV]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Fiyat</td><td><select name="fields[FIYAT]"><?php echo $select; ?></select> Kar Payı : %<input type="text" name="fields[KAR_PAYI]" size="3" value="0" /></td></tr>
                        <tr><td>Kdv Hariç</td><td><select name="fields[KDV_HARIC]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Ağırlık</td><td><select name="fields[AGIRLIK]"><?php echo $select; ?></select></td></tr>
                        <tr><td>Resim</td><td><select name="fields[RESIM]"><?php echo $select; ?></select></td></tr>
                    </tbody>
                </table>
                <?php
                }
            }
        }

        public function updateProducts()
        {
            //buraya id gelecek! ve xml okunacak.

            $this->load->model('tedarikci/tedarikci'); 
            $this->load->model('catalog/product'); 

            $tedarikci_id = (int)$_POST['tedarikci_id'];
            $tedarikci = $this->model_tedarikci_tedarikci->getById($tedarikci_id);

            $tedarikci_key = preg_replace('/[^a-z0-9_-]/i','_',$tedarikci['tedarikci_adi']);

            $image_url_folder = "data/tedarikciler/" . $tedarikci_key;

            if(!is_dir($image_dir = DIR_IMAGE.$image_url_folder))
                mkdir($image_dir,0755,true);

            list($xml,$root) = explode('&gt;',$tedarikci['tedarikci_xml_adres']);
            $map = get_object_vars(json_decode($tedarikci['tedarikci_xml_match']));

            $field_URUN_AD = $map['URUN_AD'];
            $field_KOD = $map['KOD'];
            $field_MARKA = $map['MARKA'];
            $field_ACIKLAMA = $map['ACIKLAMA'];
            $field_KATEGORI_ID = $map['KATEGORI_ID'];
            $field_STOK = $map['STOK'];
            $field_KDV = $map['KDV'];
            $field_FIYAT = $map['FIYAT'];
            $field_KDV_HARIC = $map['KDV_HARIC'];
            $field_AGIRLIK = $map['AGIRLIK'];
            $field_RESIM = $map['RESIM'];
            
            $katEslesmeler = explode(',',$map['KATEGORILER']);
            $catMap = array();
            foreach($katEslesmeler as $eslesme)
            {
                $idler = explode('=',$eslesme);
                $catMap[trim($idler[0])] = trim($idler[1]);
            }
            

            $xml =  simplexml_load_file($xml);   
            $xml = get_object_vars($xml);
            $urunler = $xml[$root];

            foreach($urunler as $urun)
            {
                $urun = get_object_vars($urun);

                $segs = explode('.',$urun[$field_RESIM]);
                $image_extension = end($segs);
                $imageName = md5($urun[$field_RESIM]);


                //the product data to update or insert!
                $data = array();
                $data['provider_name'] = $tedarikci['tedarikci_adi'];
                $data['product_currency'] = 'TRY';
                $data['status'] = '1';
                $data['product_store'] = array('0');

                //copy images to local if not exists                   
                $image_file_name =  $imageName ."." . $image_extension;

                if(!file_exists($image_file = ($image_dir . "/" . $image_file_name)))
                    file_put_contents($image_file,file_get_contents($urun[$field_RESIM]));

                $data['image'] = $image_url_folder ."/" . $image_file_name; 

                $data['product_description'][(int)$this->config->get('config_language_id')] = array(
                    'name' => $urun[$field_URUN_AD],
                    'description' => $urun[$field_ACIKLAMA]
                );

                $SKU = $tedarikci['tedarikci_id'] . "_" . $urun[$field_KOD];       

                $data['sku'] = $SKU;
                $data['model'] = $urun[$field_URUN_AD];
                $data['name'] = $urun[$field_URUN_AD];
                $data['quantity'] = $urun[$field_STOK];

                $data['stok_status_id'] = $data['quantity'] > 1 ?  7 : 5;

                $price = floatval($urun[$field_FIYAT]);
                $data['price'] =  $price + ($map['RESIM'] * $price / 100 );

                $data['weight'] = floatval( $urun[$field_AGIRLIK]);
                $data['weight_class_id'] = 1;
                
                $data['product_category'] = array();
                $data['product_category'][] =  $catMap[$urun[$field_KATEGORI_ID]];
                

                $product = $this->model_tedarikci_tedarikci->getProductBySKU($SKU);

                if($product)       
                    $this->model_catalog_product->editProduct($product['product_id'],$data);
                else        
                    $this->model_catalog_product->addProduct($data);



                //add product.  
            }

            $this->model_tedarikci_tedarikci->updated($tedarikci_id);

        }

    }
