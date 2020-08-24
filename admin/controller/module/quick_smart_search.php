<?php

class ControllerModuleQuickSmartSearch extends Controller {

    private $error = array();

    public function index() {
        $this->language->load('module/quick_smart_search');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->cache->delete('qss');
            $this->model_setting_setting->editSetting('quick_smart_search', $this->request->post);
            $this->cache->set('qss',$this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

           // $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['tab_settings'] = $this->language->get('tab_settings');
        $this->data['tab_customization'] = $this->language->get('tab_customization');
        $this->data['tab_search_settings'] = $this->language->get('tab_search_settings');
        
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');     
        $this->data['text_category_separator'] = $this->language->get('text_category_separator');
        $this->data['text_product_title'] = $this->language->get('text_product_title');
        $this->data['text_product_description'] = $this->language->get('text_product_description');
        $this->data['text_product_price'] = $this->language->get('text_product_price');
        $this->data['text_product_image'] = $this->language->get('text_product_image');
        $this->data['text_general_settings'] = $this->language->get('text_general_settings');
        $this->data['text_auto_suggest'] = $this->language->get('text_auto_suggest');
        $this->data['text_common'] = $this->language->get('text_common');
        $this->data['text_search_in'] = $this->language->get('text_search_in');
     
           $this->data['text_name'] = $this->language->get('text_name');
           $this->data['text_description'] = $this->language->get('text_description');
           $this->data['text_meta_description'] = $this->language->get('text_meta_description');
           $this->data['text_meta_keyword'] = $this->language->get('text_meta_keyword');
           $this->data['text_upc'] = $this->language->get('text_upc');
           $this->data['text_sku'] = $this->language->get('text_sku');
           $this->data['text_ean'] = $this->language->get('text_ean');
           $this->data['text_jan'] = $this->language->get('text_jan');
           $this->data['text_isbn'] = $this->language->get('text_isbn');
           $this->data['text_mpn'] = $this->language->get('text_mpn');
           $this->data['text_attr_name'] = $this->language->get('text_attr_name');
           $this->data['text_attr_val'] = $this->language->get('text_attr_val');
           $this->data['text_option_name'] = $this->language->get('text_option_name');
           $this->data['text_option_val'] = $this->language->get('text_option_val');
           $this->data['text_tags'] = $this->language->get('text_tags');
           $this->data['text_model'] = $this->language->get('text_model');
           $this->data['text_manufacture'] = $this->language->get('text_manufacture');

        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_product_title_visibility'] = $this->language->get('entry_product_title_visibility');
        $this->data['entry_product_price_visibility'] = $this->language->get('entry_product_price_visibility');
        $this->data['entry_product_image_visibility'] = $this->language->get('entry_product_image_visibility');
        $this->data['entry_category_separately'] = $this->language->get('entry_category_separately');
        $this->data['entry_max_result'] = $this->language->get('entry_max_result');
        $this->data['entry_max_category'] = $this->language->get('entry_max_category');      
        $this->data['entry_max_result_in_category'] = $this->language->get('entry_max_result_in_category');      
        $this->data['entry_result_box_width'] = $this->language->get('entry_result_box_width');      
        $this->data['entry_view_more_text'] = $this->language->get('entry_view_more_text');      
        $this->data['entry_no_result_found_text'] = $this->language->get('entry_no_result_found_text');      
        $this->data['entry_min_word_lenght_to_active_search'] = $this->language->get('entry_min_word_lenght_to_active_search');      
        $this->data['entry_product_discription_word_lenght'] = $this->language->get('entry_product_discription_word_lenght');      
       
        $this->data['entry_category_heading_background_color'] = $this->language->get('entry_category_heading_background_color');      
        $this->data['entry_background_color'] = $this->language->get('entry_background_color');      
        $this->data['entry_heighlight_color'] = $this->language->get('entry_heighlight_color');      
        $this->data['entry_border_color'] = $this->language->get('entry_border_color');      
        $this->data['entry_category_heading_font_color'] = $this->language->get('entry_category_heading_font_color');      
        $this->data['entry_category_heading_font_size'] = $this->language->get('entry_category_heading_font_size');      
        $this->data['entry_product_name_font_color'] = $this->language->get('entry_product_name_font_color');      
        $this->data['entry_product_name_font_size'] = $this->language->get('entry_product_name_font_size');      
        $this->data['entry_product_price_font_size'] = $this->language->get('entry_product_price_font_size');      
        $this->data['entry_product_discription_visibility'] = $this->language->get('entry_product_discription_visibility');      
        $this->data['entry_product_discription_font_color'] = $this->language->get('entry_product_discription_font_color');      
        $this->data['entry_product_discription_font_size'] = $this->language->get('entry_product_discription_font_size');      
        $this->data['entry_product_price_font_color'] = $this->language->get('entry_product_price_font_color');      
        $this->data['entry_product_image_width'] = $this->language->get('entry_product_image_width');      
        $this->data['entry_product_image_height'] = $this->language->get('entry_product_image_height');      
        $this->data['entry_search_in'] = $this->language->get('entry_search_in');      
        
        $this->data['entry_word_replace_rule'] = $this->language->get('entry_word_replace_rule');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_rule'] = $this->language->get('button_add_rule');
        $this->data['button_remove'] = $this->language->get('button_remove');



        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/quick_smart_search', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/quick_smart_search', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['modules'] = array();

        
        
        
        if (isset($this->request->post['qss_status'])) {
            $this->data['qss_status'] = $this->request->post['qss_status'];
        } elseif ($this->config->get('qss_status')) {
            $this->data['qss_status'] = $this->config->get('qss_status');
        } else {
            $this->data['qss_status'] = "0";
        }
        
        if (isset($this->request->post['qss_product_title_visibility'])) {
            $this->data['qss_product_title_visibility']= $this->request->post['qss_product_title_visibility'];
        } elseif ($this->config->get('qss_product_title_visibility') =='1') {
            $this->data['qss_product_title_visibility'] = $this->config->get('qss_product_title_visibility');
        } elseif ($this->config->get('qss_product_title_visibility') =='0') {
            $this->data['qss_product_title_visibility'] = $this->config->get('qss_product_title_visibility');
        } else {
            $this->data['qss_product_title_visibility'] = "1";
        }
        
        if (isset($this->request->post['qss_product_price_visibility'])) {
            $this->data['qss_product_price_visibility']= $this->request->post['qss_product_price_visibility'];
        } elseif ($this->config->get('qss_product_price_visibility') =='1') {
            $this->data['qss_product_price_visibility'] = $this->config->get('qss_product_price_visibility');
        } elseif ($this->config->get('qss_product_price_visibility') =='0') {
            $this->data['qss_product_price_visibility'] = $this->config->get('qss_product_price_visibility');
        } else {
            $this->data['qss_product_price_visibility'] = "1";
        }
        
        if (isset($this->request->post['qss_product_image_visibility'])) {
            $this->data['qss_product_image_visibility']= $this->request->post['qss_product_image_visibility'];
        } elseif ($this->config->get('qss_product_image_visibility') =='1') {
            $this->data['qss_product_image_visibility'] = $this->config->get('qss_product_image_visibility');
        } elseif ($this->config->get('qss_product_image_visibility') =='0') {
            $this->data['qss_product_image_visibility'] = $this->config->get('qss_product_image_visibility');
        } else {
            $this->data['qss_product_image_visibility'] = "1";
        }
        
        if (isset($this->request->post['qss_category_separately'])) {
            $this->data['qss_category_separately'] = $this->request->post['qss_category_separately'];
        } elseif ($this->config->get('qss_category_separately') =='1') {
            $this->data['qss_category_separately'] = $this->config->get('qss_category_separately');
        } elseif ($this->config->get('qss_category_separately') =='0') {
            $this->data['qss_category_separately'] = $this->config->get('qss_category_separately');
        } else {
            $this->data['qss_category_separately'] = "0";
        }
        
        if (isset($this->request->post['qss_max_results'])) {
            $this->data['qss_max_results'] = $this->request->post['qss_max_results'];
        } elseif ($this->config->get('qss_max_results')) {
            $this->data['qss_max_results'] = $this->config->get('qss_max_results');
        } else {
            $this->data['qss_max_results'] = "8";
        }
        
        if (isset($this->request->post['qss_max_category'])) {
            $this->data['qss_max_category'] = $this->request->post['qss_max_category'];
        } elseif ($this->config->get('qss_max_category')) {
            $this->data['qss_max_category'] = $this->config->get('qss_max_category');
        } else {
            $this->data['qss_max_category'] = "3";
        }
        
        if (isset($this->request->post['qss_max_result_in_category'])) {
            $this->data['qss_max_result_in_category'] = $this->request->post['qss_max_result_in_category'];
        } elseif ($this->config->get('qss_max_result_in_category')) {
            $this->data['qss_max_result_in_category'] = $this->config->get('qss_max_result_in_category');
        } else {
            $this->data['qss_max_result_in_category'] = "3";
        }
        
        if (isset($this->request->post['qss_min_word_lenght_to_active_search'])) {
            $this->data['qss_min_word_lenght_to_active_search'] = $this->request->post['qss_min_word_lenght_to_active_search'];
        } elseif ($this->config->get('qss_min_word_lenght_to_active_search')) {
            $this->data['qss_min_word_lenght_to_active_search'] = $this->config->get('qss_min_word_lenght_to_active_search');
        } else {
            $this->data['qss_min_word_lenght_to_active_search'] = "1";
        }
           
        if (isset($this->request->post['qss_result_box_width'])) {
            $this->data['qss_result_box_width'] = $this->request->post['qss_result_box_width'];
        } elseif ($this->config->get('qss_result_box_width')) {
            $this->data['qss_result_box_width'] = $this->config->get('qss_result_box_width');
        } else {
            $this->data['qss_result_box_width'] = "296";
        }
        
        if (isset($this->request->post['qss_view_more_text'])) {
            $this->data['qss_view_more_text'] = $this->request->post['qss_view_more_text'];
        } elseif ($this->config->get('qss_view_more_text')) {
            $this->data['qss_view_more_text'] = $this->config->get('qss_view_more_text');
        } else {
            $this->data['qss_view_more_text'] = "More results";
        }
        
        if (isset($this->request->post['qss_no_result_found_text'])) {
            $this->data['qss_no_result_found_text'] = $this->request->post['qss_no_result_found_text'];
        } elseif ($this->config->get('qss_no_result_found_text')) {
            $this->data['qss_no_result_found_text'] = $this->config->get('qss_no_result_found_text');
        } else {
            $this->data['qss_no_result_found_text'] = "No suggestion found";
        }
        
        if (isset($this->request->post['qss_category_heading_background_color'])) {
            $this->data['qss_category_heading_background_color'] = $this->request->post['qss_category_heading_background_color'];
        } elseif ($this->config->get('qss_category_heading_background_color')) {
            $this->data['qss_category_heading_background_color'] = $this->config->get('qss_category_heading_background_color');
        } else {
            $this->data['qss_category_heading_background_color'] = "#F8F8F8";
        }
        
        if (isset($this->request->post['qss_background_color'])) {
            $this->data['qss_background_color'] = $this->request->post['qss_background_color'];
        } elseif ($this->config->get('qss_background_color')) {
            $this->data['qss_background_color'] = $this->config->get('qss_background_color');
        } else {
            $this->data['qss_background_color'] = "#FFFFFF";
        }
        
        if (isset($this->request->post['qss_heighlight_color'])) {
            $this->data['qss_heighlight_color'] = $this->request->post['qss_heighlight_color'];
        } elseif ($this->config->get('qss_heighlight_color')) {
            $this->data['qss_heighlight_color'] = $this->config->get('qss_heighlight_color');
        } else {
            $this->data['qss_heighlight_color'] = "#24B4FF";
        }
        
        if (isset($this->request->post['qss_border_color'])) {
            $this->data['qss_border_color'] = $this->request->post['qss_border_color'];
        } elseif ($this->config->get('qss_border_color')) {
            $this->data['qss_border_color'] = $this->config->get('qss_border_color');
        } else {
            $this->data['qss_border_color'] = "#F7F7F7";
        }
        
        if (isset($this->request->post['qss_category_heading_font_color'])) {
            $this->data['qss_category_heading_font_color'] = $this->request->post['qss_category_heading_font_color'];
        } elseif ($this->config->get('qss_category_heading_font_color')) {
            $this->data['qss_category_heading_font_color'] = $this->config->get('qss_category_heading_font_color');
        } else {
            $this->data['qss_category_heading_font_color'] = "#333333";
        }
        
        if (isset($this->request->post['qss_category_heading_font_size'])) {
            $this->data['qss_category_heading_font_size'] = $this->request->post['qss_category_heading_font_size'];
        } elseif ($this->config->get('qss_category_heading_font_size')) {
            $this->data['qss_category_heading_font_size'] = $this->config->get('qss_category_heading_font_size');
        } else {
            $this->data['qss_category_heading_font_size'] = "10";
        }
        
        if (isset($this->request->post['qss_product_name_font_color'])) {
            $this->data['qss_product_name_font_color'] = $this->request->post['qss_product_name_font_color'];
        } elseif ($this->config->get('qss_product_name_font_color')) {
            $this->data['qss_product_name_font_color'] = $this->config->get('qss_product_name_font_color');
        } else {
            $this->data['qss_product_name_font_color'] = "#333333";
        }
        
        if (isset($this->request->post['qss_product_name_font_size'])) {
            $this->data['qss_product_name_font_size'] = $this->request->post['qss_product_name_font_size'];
        } elseif ($this->config->get('qss_product_name_font_size')) {
            $this->data['qss_product_name_font_size'] = $this->config->get('qss_product_name_font_size');
        } else {
            $this->data['qss_product_name_font_size'] = "10";
        }
        
        if (isset($this->request->post['qss_product_discription_visibility'])) {
            $this->data['qss_product_discription_visibility'] = $this->request->post['qss_product_discription_visibility'];
        } elseif ($this->config->get('qss_product_discription_visibility') == '1') {
            $this->data['qss_product_discription_visibility'] = $this->config->get('qss_product_discription_visibility');
        }elseif ($this->config->get('qss_product_discription_visibility') == '0') {
            $this->data['qss_product_discription_visibility'] = $this->config->get('qss_product_discription_visibility');
        } else {
            $this->data['qss_product_discription_visibility'] = "1";
        }
        
        if (isset($this->request->post['qss_product_discription_font_color'])) {
            $this->data['qss_product_discription_font_color'] = $this->request->post['qss_product_discription_font_color'];
        } elseif ($this->config->get('qss_product_discription_font_color')) {
            $this->data['qss_product_discription_font_color'] = $this->config->get('qss_product_discription_font_color');
        } else {
            $this->data['qss_product_discription_font_color'] = "#666666";
        }
        
        if (isset($this->request->post['qss_product_discription_font_size'])) {
            $this->data['qss_product_discription_font_size'] = $this->request->post['qss_product_discription_font_size'];
        } elseif ($this->config->get('qss_product_discription_font_size')) {
            $this->data['qss_product_discription_font_size'] = $this->config->get('qss_product_discription_font_size');
        } else {
            $this->data['qss_product_discription_font_size'] = "10";
        }
        
        if (isset($this->request->post['qss_product_discription_word_lenght'])) {
            $this->data['qss_product_discription_word_lenght'] = $this->request->post['qss_product_discription_word_lenght'];
        } elseif ($this->config->get('qss_product_discription_word_lenght')) {
            $this->data['qss_product_discription_word_lenght'] = $this->config->get('qss_product_discription_word_lenght');
        } else {
            $this->data['qss_product_discription_word_lenght'] = "100";
        }
        
        if (isset($this->request->post['qss_product_price_font_color'])) {
            $this->data['qss_product_price_font_color'] = $this->request->post['qss_product_price_font_color'];
        } elseif ($this->config->get('qss_product_price_font_color')) {
            $this->data['qss_product_price_font_color'] = $this->config->get('qss_product_price_font_color');
        } else {
            $this->data['qss_product_price_font_color'] = "#333333";
        }
        
        if (isset($this->request->post['qss_product_price_font_size'])) {
            $this->data['qss_product_price_font_size'] = $this->request->post['qss_product_price_font_size'];
        } elseif ($this->config->get('qss_product_price_font_size')) {
            $this->data['qss_product_price_font_size'] = $this->config->get('qss_product_price_font_size');
        } else {
            $this->data['qss_product_price_font_size'] = "12";
        }
        
        if (isset($this->request->post['qss_product_image_width'])) {
            $this->data['qss_product_image_width'] = $this->request->post['qss_product_image_width'];
        } elseif ($this->config->get('qss_product_image_width')) {
            $this->data['qss_product_image_width'] = $this->config->get('qss_product_image_width');
        } else {
            $this->data['qss_product_image_width'] = "60";
        }
        
        if (isset($this->request->post['qss_product_image_height'])) {
            $this->data['qss_product_image_height'] = $this->request->post['qss_product_image_height'];
        } elseif ($this->config->get('qss_product_image_height')) {
            $this->data['qss_product_image_height'] = $this->config->get('qss_product_image_height');
        } else {
            $this->data['qss_product_image_height'] = "60";
        }
        
        if (isset($this->request->post['qss_word_rules'])) {
            $this->data['qss_word_rules'] = $this->request->post['qss_word_rules'];
        } elseif ($this->config->get('qss_word_rules')) {
            $this->data['qss_word_rules'] = $this->config->get('qss_word_rules');
        } else {
            $this->data['qss_word_rules'] =array();
        }
        
        if (isset($this->request->post['qss_word_rule_status'])) {
            $this->data['qss_word_rule_status'] = $this->request->post['qss_word_rule_status'];
        } elseif ($this->config->get('qss_word_rule_status') == "1") {
            $this->data['qss_word_rule_status'] = $this->config->get('qss_word_rule_status');
        } elseif ($this->config->get('qss_word_rule_status') == "0") {
            $this->data['qss_word_rule_status'] = $this->config->get('qss_word_rule_status');
        } else {
            $this->data['qss_word_rule_status'] ="0";
        }
        
       if (isset($this->request->post['qss_search_in'])) {
            $this->data['qss_search_in'] = $this->request->post['qss_search_in'];
        } elseif ($this->config->get('qss_search_in')) {
            $this->data['qss_search_in'] = $this->config->get('qss_search_in');
        } else {
            $this->data['qss_search_in'] =array("name","description");
        }
     

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'module/quick_smart_search.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/quick_smart_search')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }      

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>