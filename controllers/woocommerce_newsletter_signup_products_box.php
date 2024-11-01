<?php
if (!function_exists('cUsWoo_admin_products_box') && is_admin()) {
    
    function cUsWoo_admin_products_box() {
        
        $prodID = get_the_ID();
        
        $prodSettings = get_post_meta( $prodID, 'cUsWoo_settings_FormByPage',true );
        $form_prod_key = $prodSettings['form_key'];
        
        $cUsWoo_API_getFormKeys = get_option('cUsWoo_settings_FormKeys'); //get the forms
        ?>
        <div class="cUsWoo_prodsbox">
            <div id="message" class="updated fade notice_success"></div><div class="advice_notice"></div><div class="loadingMessage"></div>
            <div class="form_template">
                <h4>Pick which Form/Tab combination you would like on this product page description</h4>
                <div class="template_slider">
                    <?php
                    /*
                     * MAIN WP PAGES
                     * Render Forms Data
                     */

                    if ($cUsWoo_API_getFormKeys) {

                        $cUs_json = json_decode($cUsWoo_API_getFormKeys);

                        switch ($cUs_json->status) {
                            case 'success':
                                foreach ($cUs_json->data as $oForms => $oForm) {
                                    if (cUsWoo_allowedFormType($oForm->form_type)) {

                                        if (strlen($form_prod_key) && $form_prod_key == $oForm->form_key) {
                                            $itemClass = 'default';
                                        } else if (!strlen($form_prod_key) && $form_key == $oForm->form_key) {
                                            $itemClass = 'default';
                                        } else {
                                            $itemClass = 'tpl';
                                        }
                                        ?>
                                        <span class="<?php echo $itemClass; ?> item template-prod" rel="<?php echo $oForm->form_key ?>">
                                            <img class="tab tab-<?php echo $prodID; ?>" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
                                            <img src="<?php echo $oForm->template_desktop_form_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
                                            <span class="captions">
                                                <p>
                                                    Form Name:<?php echo $oForm->form_name ?><br>
                                                    Form Key: <?php echo $oForm->form_key ?>
                                                </p>
                                            </span>
                                            <span class="def_bak"></span>
                                        </span>
                                        <?php
                                    }
                                }
                                break;
                        } //endswitch;
                    }
                    ?>
                </div>

                <div class="save-options">
                    <input type="button" class="btn small lightblue reset-prod" value="Clear" />
                    <input type="button" class="btn small lightblue save-prod" value="Save" />
                    
                    <input type="hidden" class="cus_version" value="<?php echo $cus_version; ?>" />
                    <input type="hidden" class="form_key" value="<?php echo (strlen($form_prod_key)) ? $form_prod_key : $form_key; ?>" />
                    <input type="hidden" class="prodID" value="<?php echo $prodID; ?>" />
                    
                </div>
                <div class="save_message">
                    <p>Sending . . .</p>
                </div>
            </div>
            <div class="cUsWoo_box_powered">Powered by </div>
        
        </div>

        <?php
    }

    // This function tells WP to add a new "meta box"
    function cUsWoo_admin_add_products_box() {
        add_meta_box('cUsWoo_prods_box', 'ContactUs.com Forms', 'cUsWoo_admin_products_box', 'product', 'advanced', 'high');
    }

    add_action('admin_menu', 'cUsWoo_admin_add_products_box');
    
    
    if (!function_exists('cUsWoo_admin_add_products_box_libs')) {
        /*
         * Method in charge to render plugin js libraries and css
         * @since 1.0
         * @return string Return Html into wp admin header
         */

        function cUsWoo_admin_add_products_box_libs() {

            global $current_screen;

            if ($current_screen->id == 'product' && $current_screen->post_type == 'product') {
                wp_enqueue_style('cUsWoo_Styles', plugins_url('../assets/style/cUsWoo_style_products.css', __FILE__), false, '1');
                wp_enqueue_style('bxslider', plugins_url('../assets/scripts/bxslider/jquery.bxslider.css', __FILE__), false, '1');

                wp_register_script('cUsWoo_Scripts', plugins_url('../assets/scripts/cUsWoo_form_product.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '4.0', true);
                wp_localize_script('cUsWoo_Scripts', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
                wp_register_script('bxslider', plugins_url('../assets/scripts/bxslider/jquery.bxslider.js', __FILE__), array('jquery'), '4.1.1', true);

                wp_enqueue_script('jquery'); //JQUERY WP CORE
                wp_enqueue_script('bxslider');
                wp_enqueue_script('cUsWoo_Scripts');
            }
        }

        add_action('admin_enqueue_scripts', 'cUsWoo_admin_add_products_box_libs'); // cUsWoo_admin_header hook
    }
}