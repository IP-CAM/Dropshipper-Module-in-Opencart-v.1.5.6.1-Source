<?php

class ControllerModuleQuickSmartSearch extends Controller {

    public function index() {

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        if ($this->cache->get('qss')) {
            $qss = $this->cache->get('qss');
            $qss_search_in = $qss['qss_search_in'];
            $qss_category_separately = $qss['qss_category_separately'];
            if ($qss_category_separately == '1') {
                $qss_max_result_in_category = $qss['qss_max_result_in_category'];
                $qss_max_category = $qss['qss_max_category'];
            } else {
                $qss_max_results = $qss['qss_max_results'];
            }
            $qss_product_image_visibility = $qss['qss_product_image_visibility'];
            if ($qss_product_image_visibility == '1') {
                $qss_product_image_width = $qss['qss_product_image_width'];
                $qss_product_image_height = $qss['qss_product_image_height'];
            }
            $qss_view_more_text = $qss['qss_view_more_text'];
            $qss_no_result_found_text = $qss['qss_no_result_found_text'];
            $qss_product_discription_visibility = $qss['qss_product_discription_visibility'];
            if ($qss_product_discription_visibility == '1') {
                $qss_product_discription_word_lenght = $qss['qss_product_discription_word_lenght'];
            }
            $qss_product_price_visibility = $qss['qss_product_price_visibility'];
            $qss_product_title_visibility = $qss['qss_product_title_visibility'];

            $qss_word_rule_status = $qss['qss_word_rule_status'];
            if ($qss_word_rule_status == '1') {
                $qss_word_rules = $qss['qss_word_rules'];
            }
        } else {
            $qss_category_separately = $this->config->get('qss_category_separately');
            $qss_search_in = $this->config->get('qss_search_in');
            if ($qss_category_separately == '1') {
                $qss_max_result_in_category = $this->config->get('qss_max_result_in_category');
                $qss_max_category = $this->config->get('qss_max_category');
            } else {
                $qss_max_results = $this->config->get('qss_max_results');
            }
            $qss_product_image_visibility = $this->config->get('qss_product_image_visibility');
            if ($qss_product_image_visibility == '1') {
                $qss_product_image_width = $this->config->get('qss_product_image_width');
                $qss_product_image_height = $this->config->get('qss_product_image_height');
            }
            $qss_view_more_text = $this->config->get('qss_view_more_text');
            $qss_no_result_found_text = $this->config->get('qss_no_result_found_text');
            $qss_product_discription_visibility = $this->config->get('qss_product_discription_visibility');
            if ($qss_product_discription_visibility == '1') {
                $qss_product_discription_word_lenght = $this->config->get('qss_product_discription_word_lenght');
            }
            $qss_product_price_visibility = $this->config->get('qss_product_price_visibility');
            $qss_product_title_visibility = $this->config->get('qss_product_title_visibility');

            $qss_word_rule_status = $this->config->get('qss_word_rule_status');
            if ($qss_word_rule_status == '1') {
                $qss_word_rules = $this->config->get('qss_word_rules');
            }
        }

        if (isset($this->request->get['search'])) {
            $keyword = $this->request->get['search'];
            $search_url = "search=" . $keyword;
            if (in_array("description", $qss_search_in)) {
                $search_url .= "&description=true";
            }
        } else {
            if (isset($this->request->get['filter_test'])) {
                $keyword = $this->request->get['filter_test'];
                $search_url = "filter_test=" . $keyword;
                if (in_array("description", $qss_search_in)) {
                    $search_url .= "&filter_description=true";
                }
            } else {
                $keyword = "";
                $search_url = "";
            }
        }


        $sort = 'p.sort_order';

        $order = 'ASC';

        $this->data['products'] = array();
        $page = 1;
        $output = "";
        $no_result = 0;
        $product_ids = array();
        $view_more = true;
        if (isset($keyword) && $keyword != "") {

            if ($qss_word_rule_status == '1') {
                $keyword = str_replace($qss_word_rules['word'], $qss_word_rules['replacement'], $keyword);
            }

            $output = '<div id="searchresults">';

            if ($qss_category_separately != '1') {
                $data = array(
                    'filter_name' => $keyword,
                    'search_in' => $qss_search_in,
                    'sort' => $sort,
                    'order' => $order,
                    'start' => 0,
                    'limit' => $qss_max_results
                );


                $results = $this->getProducts($data);

                foreach ($results as $result) {
                    if ($result['image'] && $qss_product_image_visibility == '1') {
                        //$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                        $image = $this->model_tool_image->resize($result['image'], $qss_product_image_width, $qss_product_image_height);
                    } else {
                        $image = false;
                    }

                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }

                                                if ((float) $result['special']) {
                                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                            } else {
                                $special = false;
                            }

                            if ($special) {
                                $price = $special;
                            }


                    $output .= ' <a href="' . $this->url->link('product/product', 'product_id=' . $result['product_id'] . '&' . $search_url) . '">';
                    if ($qss_product_image_visibility == '1') {
                        $output .= '<img width="'.$qss_product_image_width.'" height="'.$qss_product_image_height.'" src="' . $image . '" alt="" />';
                    }
                    $output .= '<span class="searchheading">';
                    if ($qss_product_title_visibility == '1') {
                        $output .= $result['name'];
                    }
                    if ($qss_product_price_visibility == '1') {
                        $output .= ' <span class="searchheading_price">' . $price . '</span>';
                    }
                    $output .= '</span>';
                    if ($qss_product_discription_visibility == '1') {
                        $output .= '<span>' . $this->utf8_substr_qss(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $qss_product_discription_word_lenght) . '..</span>';
                    }
                    $output .= '</a>';

                    $no_result++;
                }
                if ($no_result < $qss_max_results) {
                    $view_more = false;
                }
            } else {
                // 3 Level Category Search
                $categories = array();
                $categories = $this->model_catalog_category->getCategories(0);

                $num_categories = 0;

                foreach ($categories as $category) {
                    if ($num_categories < $qss_max_category) {
                        $product_in_this_cat = 0;
                        $data = array(
                            'filter_name' => $keyword,
                            'search_in' => $qss_search_in,
                            'filter_category_id' => $category['category_id'],
                            'filter_sub_category' => true,
                            'sort' => $sort,
                            'order' => $order,
                            'start' => 0,
                            'limit' => $qss_max_result_in_category
                        );


                        $results = $this->getProducts($data);

                        foreach ($results as $result) {
                            if (!in_array($result['product_id'], $product_ids) && $product_in_this_cat < $qss_max_result_in_category) {
                                if ($result['image'] && $qss_product_image_visibility == '1') {
                                    //$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                    $image = $this->model_tool_image->resize($result['image'], $qss_product_image_width, $qss_product_image_height);
                                } else {
                                    $image = false;
                                }

                                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                                } else {
                                    $price = false;
                                }

                            if ((float) $result['special']) {
                                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                            } else {
                                $special = false;
                            }

                            if ($special) {
                                $price = $special;
                            }
                                if ($product_in_this_cat == 0) {
                                    $num_categories++;
                                    $output .= '<span class="category">' . $category['name'] . '</span>';
                                }
                                $output .= ' <a href="' . $this->url->link('product/product', 'product_id=' . $result['product_id'] . '&' . $search_url) . '">';
                                if ($qss_product_image_visibility == '1') {
                                    $output .= '<img width="'.$qss_product_image_width.'" height="'.$qss_product_image_height.'" src="' . $image . '" alt="" />';
                                }
                                $output .= '<span class="searchheading">';
                                if ($qss_product_title_visibility == '1') {
                                    $output .= $result['name'];
                                }
                                if ($qss_product_price_visibility == '1') {
                                    $output .= ' <span class="searchheading_price">' . $price . '</span>';
                                }
                                $output .= '</span>';
                                if ($qss_product_discription_visibility == '1') {
                                    $output .= '<span>' . $this->utf8_substr_qss(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $qss_product_discription_word_lenght) . '..</span>';
                                }
                                $output .= '</a>';

                                $product_ids[] = $result['product_id'];
                                $no_result++;
                                $product_in_this_cat++;
                            }
                        }
                    }
                }
                if ($num_categories < $qss_max_category) {
                    $view_more = false;
                }
            }
            if ($no_result == '0') {
                $output .= '<div style="height:20px;margin:5px;"> ' . $qss_no_result_found_text . '</div>';
            } else {
                if ($view_more) {
                    $output .= '<a href="' . $this->url->link('product/search', $search_url) . '" id="oc_search_more_results"> ' . $qss_view_more_text . '</a>';
                }
            }
            $output .= "</div>";
        }


        $this->response->setOutput($output);
    }

    private function getProducts($data = array()) {
        $search_in = $data['search_in'];
        if (!empty($search_in)) {
            $search_in = array_flip($search_in);
        }

        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $sql = "SELECT p.product_id,  (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int) $customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";

            $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        if (isset($search_in['attr_val'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (p.product_id = pa.product_id)";
        }

        if (isset($search_in['option_val'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_option po ON (p.product_id = po.product_id)";
        }

        if (isset($search_in['manufacture'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer pm ON (p.manufacturer_id = pm.manufacturer_id)";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'";

        if (!empty($search_in)) {
            $sql .= " AND (";

            if (isset($search_in['name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($word)) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }
            }

            if (isset($search_in['description'])) {
                $impl[] = "LCASE(pd.description) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['meta_description'])) {
                $impl[] = "LCASE(pd.meta_description) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['meta_keyword'])) {
                $impl[] = "LCASE(pd.meta_keyword) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['tags']) && version_compare(VERSION, '1.5.2', '>=')) {
                $impl[] = "LCASE(pd.tag) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['model'])) {
                $impl[] = "LCASE(p.model) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['sku'])) {
                $impl[] = "LCASE(p.sku) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['upc'])) {
                $impl[] = "LCASE(p.upc) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['ean']) && version_compare(VERSION, '1.5.2', '>=')) {
                $impl[] = "LCASE(p.ean) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['jan']) && version_compare(VERSION, '1.5.2', '>=')) {
                $impl[] = "LCASE(p.jan) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['isbn']) && version_compare(VERSION, '1.5.2', '>=')) {
                $impl[] = "LCASE(p.isbn) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['mpn']) && version_compare(VERSION, '1.5.2', '>=')) {
                $impl[] = "LCASE(p.mpn) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['attr_val'])) {
                $impl[] = "LCASE(pa.text) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['option_val'])) {
                $impl[] = "LCASE(po.option_value) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if (isset($search_in['manufacture'])) {
                $impl[] = "LCASE(pm.name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
            }

            if ($impl) {
                if (isset($search_in['name'])) {
                    $sql .= " OR ";
                }
                $sql .= " " . implode(" OR ", $impl);
            }
            $sql .= ")";
        }

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $implode_data = array();

                $implode_data[] = (int) $data['filter_category_id'];

                $categories = $this->getCategoriesByParentId($data['filter_category_id']);

                foreach ($categories as $category_id) {
                    $implode_data[] = (int) $category_id;
                }

                $sql .= " AND p2c.category_id IN (" . implode(', ', $implode_data) . ")";
            } else {
                $sql .= " AND p2c.category_id = '" . (int) $data['filter_category_id'] . "'";
            }
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int) $data['filter_manufacturer_id'] . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    private function getCategoriesByParentId($parent_id = 0) {
        $category_data = array();
        $category_query = $this->db->query("SELECT c.category_id AS category_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1'");

        foreach ($category_query->rows as $category) {
            $category_data[] = $category['category_id'];

            $children = $this->getCategoriesByParentId($category['category_id']);

            if ($children) {
                $category_data = array_merge($children, $category_data);
            }
        }

        return $category_data;
    }

    private function getProduct($product_id) {
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getCustomerGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int) $customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int) $customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int) $customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int) $this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int) $this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int) $this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return array(
                'product_id' => $query->row['product_id'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'image' => $query->row['image'],
                'price' => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
                'special' => $query->row['special'],
                'tax_class_id' => $query->row['tax_class_id'],
            );
        } else {
            return false;
        }
    }

    private function utf8_substr_qss($string, $offset, $length = null) {
        // generates E_NOTICE
        // for PHP4 objects, but not PHP5 objects
        $string = (string) $string;
        $offset = (int) $offset;

        if (!is_null($length)) {
            $length = (int) $length;
        }

        // handle trivial cases
        if ($length === 0) {
            return '';
        }

        if ($offset < 0 && $length < 0 && $length < $offset) {
            return '';
        }

        // normalise negative offsets (we could use a tail
        // anchored pattern, but they are horribly slow!)
        if ($offset < 0) {
            $strlen = strlen(utf8_decode($string));
            $offset = $strlen + $offset;

            if ($offset < 0) {
                $offset = 0;
            }
        }

        $Op = '';
        $Lp = '';

        // establish a pattern for offset, a
        // non-captured group equal in length to offset
        if ($offset > 0) {
            $Ox = (int) ($offset / 65535);
            $Oy = $offset % 65535;

            if ($Ox) {
                $Op = '(?:.{65535}){' . $Ox . '}';
            }

            $Op = '^(?:' . $Op . '.{' . $Oy . '})';
        } else {
            $Op = '^';
        }

        // establish a pattern for length
        if (is_null($length)) {
            $Lp = '(.*)$';
        } else {
            if (!isset($strlen)) {
                $strlen = strlen(utf8_decode($string));
            }

            // another trivial case
            if ($offset > $strlen) {
                return '';
            }

            if ($length > 0) {
                $length = min($strlen - $offset, $length);

                $Lx = (int) ($length / 65535);
                $Ly = $length % 65535;

                // negative length requires a captured group
                // of length characters
                if ($Lx) {
                    $Lp = '(?:.{65535}){' . $Lx . '}';
                }

                $Lp = '(' . $Lp . '.{' . $Ly . '})';
            } elseif ($length < 0) {
                if ($length < ($offset - $strlen)) {
                    return '';
                }

                $Lx = (int) ((-$length) / 65535);
                $Ly = (-$length) % 65535;

                // negative length requires ... capture everything
                // except a group of  -length characters
                // anchored at the tail-end of the string
                if ($Lx) {
                    $Lp = '(?:.{65535}){' . $Lx . '}';
                }

                $Lp = '(.*)(?:' . $Lp . '.{' . $Ly . '})$';
            }
        }

        if (!preg_match('#' . $Op . $Lp . '#us', $string, $match)) {
            return '';
        }

        return $match[1];
    }

}
?>

