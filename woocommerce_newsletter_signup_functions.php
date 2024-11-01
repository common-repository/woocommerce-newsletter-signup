<?php

/**
 * 
 * WOOCOMMERCE FORM BY CONTACTUS.COM
 * 
 * Initialization WooCommerce Form Functions
 * @since 3.1 First time this was introduced into Contact Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 **/

$cus_dirbase = trailingslashit(basename(dirname(__FILE__)));
$cus_dir = trailingslashit(WP_PLUGIN_DIR) . $cus_dirbase;
$cus_url = trailingslashit(WP_PLUGIN_URL) . $cus_dirbase;

//CONFIG VARS
require_once( $cus_dir . 'woocommerce_newsletter_signup_conf.php');

//CUS API OBJECT
if (!class_exists('cUsComAPI_WOO')) {
    require_once( cUsWOO_DIR . 'libs/cusAPI.class.php');
}
//AJAX REQUEST HOOKS
require_once( cUsWOO_DIR . 'controllers/woocommerce_newsletter_signup_ajx_request.php');

// WIDGET CALL
include_once( cUsWOO_DIR . 'woocommerce_newsletter_signup_widget.php');
/*
* Method in charge to render widget into wp admin
* @since 1.0
* @return string Return Html into wp admin
*/
function cUsWoo_register_widgets() {
    register_widget('woocommerce_form_Widget');
}
add_action('widgets_init', 'cUsWoo_register_widgets');

if(is_admin()){
    //CREATE PRODUCTS META BOX
    require_once( cUsWOO_DIR . 'controllers/woocommerce_newsletter_signup_products_box.php');
}

/* -----------------------CONTACTUS.COM--------------------------- */

if (!function_exists('cUsWoo_admin_header')) {
   /*
    * Method in charge to render plugin js libraries and css
    * @since 1.0
    * @return string Return Html into wp admin header
    */
    function cUsWoo_admin_header() {
        
        global $current_screen;

        if ($current_screen->id == 'toplevel_page_cUsWoo_form_plugin') {
            
            wp_enqueue_style( 'cUsWoo_Styles', plugins_url('assets/style/cUsWoo_style.css', __FILE__), false, '1' );
            wp_enqueue_style( 'colorbox', plugins_url('assets/scripts/colorbox/colorbox.css', __FILE__), false, '1' );
            wp_enqueue_style( 'bxslider', plugins_url('assets/scripts/bxslider/jquery.bxslider.css', __FILE__), false, '1' );
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
            wp_enqueue_style('thickbox');

            wp_register_script( 'cUsWoo_Scripts', plugins_url('assets/scripts/cUsWoo_scripts.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '4.0', true);
            wp_localize_script( 'cUsWoo_Scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            wp_register_script( 'cUsWoo_cats_module', plugins_url('assets/scripts/cUsWoo_cats_module.js?pluginurl=' . dirname(__FILE__), __FILE__), array('jquery'), '1.0', true);
            wp_register_script( 'colorbox', plugins_url('assets/scripts/colorbox/jquery.colorbox-min.js', __FILE__), array('jquery'), '1.4.33', true);
            wp_register_script( 'bxslider', plugins_url('assets/scripts/bxslider/jquery.bxslider.js', __FILE__), array('jquery'), '4.1.1', true);

            wp_enqueue_script( 'jquery' ); //JQUERY WP CORE
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-ui-button' );
            wp_enqueue_script( 'jquery-ui-selectable' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-tooltip' );
            wp_enqueue_script( 'colorbox' );
            wp_enqueue_script( 'thickbox' );
            wp_enqueue_script( 'bxslider' );
            wp_enqueue_script( 'cUsWoo_Scripts' );
            wp_enqueue_script( 'cUsWoo_cats_module' );
            
            //CONTACT FORM SUPPORT CHAT
            wp_register_script( 'cUsWoo_support_chat', '//cdn.contactus.com/cdn/forms/Y2FlNjhjMTNiZDU,/contactus.js', array(), '2.7', true);
            wp_enqueue_script( 'cUsWoo_support_chat' );
            
        }
        
    }

} 
add_action('admin_enqueue_scripts', 'cUsWoo_admin_header'); // cUsWoo_admin_header hook
//END CONTACTUS.COM PLUGIN STYLES CSS

//CONTACTUS.COM ADD FORM TO PLUGIN PAGE

// Add option page in admin menu
if (!function_exists('cUsWoo_admin_menu')) {
    
    function cUsWoo_admin_menu() {
        add_menu_page('WooCommerce Form by ContactUs.com ', 'WooCommerce Form', 'edit_themes', 'cUsWoo_form_plugin', 'cUsWoo_menu_render', plugins_url("assets/style/images/woo_small.png", __FILE__));
    }

}
add_action('admin_menu', 'cUsWoo_admin_menu'); // cUsWoo_admin_menu hook

/*
* Method in charge to render link to Help Center into wp plugins manager page
* @since 1.0
* @return string Return Html plugins manager page
*/
function cUsWoo_plugin_links($links, $file) {
    $plugin_file = 'woocommerce-form/woocommerce_newsletter_signup.php';
    if ($file == $plugin_file) {
        $links[] = '<a target="_blank" style="color: #42a851; font-weight: bold;" href="http://help.contactus.com/">' . __("Get Support", "cus_plugin") . '</a>';
    }
    return $links;
} 
add_filter('plugin_row_meta', 'cUsWoo_plugin_links', 10, 2);


/*
* Method in charge to create the setting button in plugins manager page
* @since 1.0
* @return string Return Html plugins manager page
*/
function cUsWoo_action_links($links, $file) {
    $plugin_file = 'woocommerce-form/woocommerce_newsletter_signup.php';
    //make sure it is our plugin we are modifying
    if ($file == $plugin_file) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cUsWoo_form_plugin') . '">' . __('Settings', 'cus_plugin') . '</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
} 
add_filter("plugin_action_links", 'cUsWoo_action_links', 10, 4);

//Display the validation errors and update messages

/*
 * Admin notices
 */

function cUsWoo_admin_notices() {
    settings_errors();
} 
add_action('admin_notices', 'cUsWoo_admin_notices');

/*
 * Method in charge to validate allowed form types
 * @since 1.0
 * @param string $form_type Form type to validate
 * @return boolean
 */
function cUsWoo_allowedFormType($form_type){
    $aryAllowedFormTypes = array('contact_us', 'newsletter');
    if( in_array($form_type, $aryAllowedFormTypes) ){
        return TRUE;
    }else{
        return FALSE;
    }
}
/*
 * Method in charge to validate allowed woocommerce pages
 * @since 1.0
 * @param string $page_slug to validate
 * @return boolean
 */
function cUsWoo_allowedWooPages($page_slug){
    //$aryAllowedWOOSlugs = array('shop', 'cart','checkout','my-account','lost-password','edit-address','view-order','change-password','logout','pay','order-received');
    $aryAllowedWOOSlugs = array('cart','checkout','my-account','lost-password','edit-address','view-order','change-password','logout','pay','order-received');
    if( in_array($page_slug, $aryAllowedWOOSlugs) ){
        return TRUE;
    }else{
        return FALSE;
    }
}

/*
 * Method in charge to update default form key
 * @since 1.0
 * @param string $form_key Form Key to validate
 * @return null
 */
function cUsWoo_updateDefaultFormKey($form_key) {
    $default_form_key = get_option('cUsWoo_settings_form_key');
    if ($default_form_key != $form_key) {
        update_option('cUsWoo_settings_form_key', $form_key);
    }
    $form_key = get_option('cUsWoo_settings_form_key');
    
    return $form_key;
}

/*
 * IMPORTANT
* Method in charge to render the contactus.com javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function cUsWoo_JS_into_html() {
    if (!is_admin() && !is_archive()) {
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsWoo_settings_FormByPage', true );
        $allCatSettings = get_option('cUsWoo_settings_cat_allcats');
        $productCategories = get_the_terms($pageID, 'product_cat');
        
        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0
            
            //FORM BY PRODUCT/PAGE ID
            
            $boolTab        = $pageSettings['tab_user'];
            $cus_version    = $pageSettings['cus_version'];
            $form_key       = $pageSettings['form_key'];
            
            if($cus_version == 'tab'){
                
                $userJScode = renderJSCodebyFormKey($form_key);
            
                echo $userJScode;
            }
            
        }elseif(is_array($allCatSettings) && !empty ($allCatSettings)){ 
            
            //ALL CATEGORIES SELECTED AND ALLOW IN PRODUCTS
            
            //print_r($allCatSettings);
            
            $boolTab        = $allCatSettings['tab_user'];
            $allowProds     = $allCatSettings['allowProds'];
            $cus_version    = $allCatSettings['cus_version'];
            $form_key       = $allCatSettings['form_key'];

            if($cus_version == 'tab' && $allowProds && $boolTab){

                $userJScode = renderJSCodebyFormKey($form_key);

                echo $userJScode;
            }
            
        }elseif (is_array($productCategories) && !empty ($productCategories) ) {
            
            //ALLOW PRODUCTS IN SELECTED CATEGORY
            
            foreach ($productCategories as $Cats => $Cat){
                if($Cat->parent == 0){
                    $term_id = $Cat->term_id;
                    break;
                }
            }
            
            if($term_id != 0){
                $catSettings = get_option('cUsWoo_settings_cat_'.$term_id);
        
                if(is_array($catSettings) && !empty($catSettings)){ 
                    
                    $boolTab        = $catSettings['tab_user'];
                    $allowProds     = $catSettings['allowProds'];
                    $cus_version    = $catSettings['cus_version'];
                    $form_key       = $catSettings['form_key'];
                    
                    if($cus_version == 'tab' && $allowProds && $boolTab){

                        $userJScode = renderJSCodebyFormKey($form_key);

                        echo $userJScode;
                    }

                }
                
            }
            
        }else{
            
            //CUSTOM PAGE SETTINGS
            
            $formOptions    = get_option('cUsWoo_settings_form');
            $getTabPages    = get_option('cUsWoo_settings_tabpages');
            
            $getInlinePages = get_option('cUsWoo_settings_inlinepages');
            $form_key       = get_option('cUsWoo_settings_form_key');
            $boolTab = $formOptions['tab_user'];
            $cus_version = $formOptions['cus_version'];
            
            if(!empty($getTabPages) && in_array('home', $getTabPages) && is_home() ){
                $getHomePage     = get_option('cUsWoo_settings_home');
                $boolTab        = $getHomePage['tab_user'];
                $cus_version    = $getHomePage['cus_version'];
                $form_key       = $getHomePage['form_key'];
            }
            
            $userJScode = renderJSCodebyFormKey($form_key);

            //the theme must have the wp_footer() function included
            //include the contactUs.com JS before the </body> tag
            switch ($cus_version) {
                case 'tab':
                    if (strlen($form_key) && $boolTab){
                        echo $userJScode;
                    }
                    break;
                case 'selectable':
                    if (strlen($form_key) && is_array($getTabPages) && in_array($pageID, $getTabPages)){
                        echo $userJScode;
                    }
                    break;
            }
        }
    }
}
add_action('wp_footer', 'cUsWoo_JS_into_html'); // ADD JS BEFORE BODY TAG

/*
 * IMPORTANT
* Method in charge to render the contactus.com javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function renderJSCodebyFormKey($form_key){
    
    $userJScode = '';
    
    if(strlen($form_key)){
        $userJScode = "\n<!-- BEGIN CONTACTUS.COM SCRIPT -->\n";
        $userJScode .= '<script type="text/javascript" src="' . cUsWOO_ENV_URL . $form_key . '/contactus.js"></script>';
        $userJScode .= "\n<!-- END CONTACTUS.COM SCRIPT -->\n\n";
    }
    
    return $userJScode;
}

/*
 * IMPORTANT
* Method in charge to render the contactus.com javascript snippet into the default wp theme INLINE
* @since 1.0
* @return string Return Html javascript snippet
*/
function renderJSCodebyFormKeyInline($form_key){
    
    $userJScode = '';
    
    if(strlen($form_key)){
        
        $userJScode = "\n<!-- BEGIN CONTACTUS.COM SCRIPT -->\n";
        $userJScode .= '<div style="min-height: 300px; min-width: 340px; clear:both;">';
        $userJScode .= '<script type="text/javascript" src="' . cUsWOO_ENV_URL . $form_key . '/inline.js"></script>';
        $userJScode .= '</div>';
        $userJScode .= "\n<!-- END CONTACTUS.COM SCRIPT -->\n\n";
    }
    
    return $userJScode;
}

/*
 * IMPORTANT
* Method in charge to render the contactus.com javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function cUsWoo_JS_into_categories_archive() {
    if (!is_admin() && is_archive()) {
        
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $parent_id = $queried_object->parent;
        
        if($parent_id != 0){
            $term_id = $parent_id;
        }
        
        $catSettings = get_option('cUsWoo_settings_cat_'.$term_id);
        $allCatSettings = get_option('cUsWoo_settings_cat_allcats');
        
        if(is_array($catSettings) && !empty($catSettings) ){ //NEW VERSION 3.0
            
            $boolTab        = $catSettings['tab_user'];
            $allowSubCats   = $catSettings['allowSubCats'];
            $cus_version    = $catSettings['cus_version'];
            $form_key       = $catSettings['form_key'];
            
        }elseif(is_array($allCatSettings) && !empty($allCatSettings)){
            
            $boolTab        = $allCatSettings['tab_user'];
            $allowSubCats   = $allCatSettings['allowSubCats'];
            $cus_version    = $allCatSettings['cus_version'];
            $form_key       = $allCatSettings['form_key'];
        }
        
        if($cus_version == 'tab' && $allowSubCats && $boolTab){
                
            $userJScode = renderJSCodebyFormKey($form_key);

            echo $userJScode;

        }
        
    }
}
add_action('wp_footer', 'cUsWoo_JS_into_categories_archive'); // ADD JS BEFORE BODY TAG


//SHORTCODE MANAGMENT ROUTINES
/*
 * IMPORTANT
* Method in charge to read wp shortcode and render the javascript snippet into the default wp theme
* @since 1.0
* @return string Return Html javascript snippet
*/
function cUsWoo_shortcode_handler($aryFormParemeters) {
    
    $cUsWoo_credentials = get_option('cUsWoo_settings_userCredentials'); //GET USERS CREDENTIALS V3.0 API 1.9
    
    if(!empty($cUsWoo_credentials)){ 
        
        $pageID = get_the_ID();
        $pageSettings = get_post_meta( $pageID, 'cUsWoo_settings_FormByPage', false );
        $inlineJS_output = '';

        if(is_array($pageSettings) && !empty($pageSettings)){ //NEW VERSION 3.0

            $boolTab        = $pageSettings[0]['tab_user'];
            $cus_version    = $pageSettings[0]['cus_version'];
            $form_key       = $pageSettings[0]['form_key'];

            if(strlen($formkey)) $form_key = $formkey;

            if ($cus_version == 'inline' || $cus_version == 'selectable') {
               $inlineJS_output = renderJSCodebyFormKeyInline($form_key);
            }

        }elseif(is_array($aryFormParemeters)){

            if($aryFormParemeters['version'] == 'tab'){
                $Fkey = $aryFormParemeters['formkey'];
                update_option('cUsWoo_settings_FormKey_SC', $Fkey);
                do_action('wp_footer', $Fkey);
                add_action('wp_footer', 'cUsWoo_shortcodeTab'); // ADD JS BEFORE BODY TAG
            }else{
                $inlineJS_output = renderJSCodebyFormKeyInline($form_key);
            }

        }else{   //OLDER VERSION < 2.5 //UPDATE 
            $formOptions    = get_option('cUsWoo_settings_form');//GET THE NEW FORM OPTIONS
            $form_key       = get_option('cUsWoo_settings_form_key');
            $cus_version    = $formOptions['cus_version'];

            if ($cus_version == 'inline' || $cus_version == 'selectable') {
                $inlineJS_output = renderJSCodebyFormKeyInline($form_key);
            }

        }

        return $inlineJS_output;
    }else{
        
        return '<p>WooCommerce Extension Form by ContactUs.com user Credentials Missing . . . <br/>Please Signup / Login Again <a href="'.get_admin_url().'admin.php?page=cUsWoo_form_plugin" target="_blank">here</a>, Thank You.</p>';
        
    }
}

/*
 * Method in charge to render the javascript snippet into the default wp theme like a tab
 * @since 1.0
 * @param array $Args Array with all shortcode options
 * @return string
 */
function cUsWoo_shortcodeTab($Args) {
    
    $form_key = get_option('cUsWoo_settings_FormKey_SC');
    
    if ( !is_admin() && strlen($form_key) ) {
        
        $userJScode = renderJSCodebyFormKey($form_key);
        
        echo $userJScode;
    }
}

/*
 * Method in charge to add the shortcode into the page content by page ID
 * @since 1.0
 * @param int $inline_req_page_id WP Page ID
 * @return array
 */
function cUsWoo_inline_shortcode_add($inline_req_page_id) {
    
    if($inline_req_page_id != 'home'){
        $oPage = get_page($inline_req_page_id);
        $pageContent = $oPage->post_content;
        $pageContent = $pageContent . "\n[show-woocommerce-form]";
        $aryPage = array();
        $aryPage['ID'] = $inline_req_page_id;
        $aryPage['post_content'] = $pageContent;
        return wp_update_post($aryPage);
    }
}

/*
 * Method in charge to remove page setting to all wp pages content by page ID
 * @since 1.0
 * @return null
 */
function cUsWoo_page_settings_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        delete_post_meta($oPage->ID, 'cUsWoo_settings_FormByPage');//reset values
        cUsWoo_inline_shortcode_cleaner_by_ID($oPage->ID); //RESET SC
    }
}
/*
 * Method in charge to remove the shortcode into the all wp pages content by page ID
 * @since 1.0
 * @return null
 */
function cUsWoo_inline_shortcode_cleaner() {
    $aryPages = get_pages();
    foreach ($aryPages as $oPage) {
        $pageContent = $oPage->post_content;
        $pageContent = str_replace('[show-woocommerce-form]', '', $pageContent);
        $aryPage = array();
        $aryPage['ID'] = $oPage->ID;
        $aryPage['post_content'] = $pageContent;
        wp_update_post($aryPage);
    }
}
/*
 * Method in charge to remove the shortcode into the wp page content by page ID
 * @since 1.0
 * @return null
 */
function cUsWoo_inline_shortcode_cleaner_by_ID($inline_req_page_id) {
    $oPage = get_page( $inline_req_page_id );
    
    $pageContent = $oPage->post_content;
    $pageContent = str_replace('[show-woocommerce-form]', '', $pageContent);
    $aryPage = array();
    $aryPage['ID'] = $oPage->ID;
    $aryPage['post_content'] = $pageContent;
    
    wp_update_post($aryPage);
    
}

add_shortcode("show-woocommerce-form", "cUsWoo_shortcode_handler"); //[show-woocommerce-form]

//SHORTCODES

/*
 *  UPDATE NOTICES
 * 
 * Method in charge to display update notice into wp admin header
 * @since 1.0
 * @return string Html
 */
/* Display a notice that can be dismissed */
add_action('admin_notices', 'cUsWoo_update_admin_notice');
function cUsWoo_update_admin_notice() {
	
        global $current_user ;
        $user_id = $current_user->ID;
        
        $aryUserCredentials = get_option('cUsWoo_settings_userCredentials');
        $form_key           = get_option('cUsWoo_settings_form_key');
        $cUs_API_Account    = $aryUserCredentials['API_Account'];
        $cUs_API_Key        = $aryUserCredentials['API_Key'];
        
	if ( ! get_user_meta($user_id, 'cUsWoo_ignore_notice') && !strlen($cUs_API_Account) && !strlen($cUs_API_Key) && strlen($form_key)) {
            echo '<div class="updated"><p>';
            printf(__('Contact Form has been updated!. Please take time to activate your new features <a href="%1$s">here</a>. | <a href="%2$s">Hide Notice</a>'), 'admin.php?page=cUsWoo_form_plugin', '?cUsWoo_ignore_notice=0');
            echo "</p></div>";
	}
        
}
add_action('admin_init', 'cUsWoo_nag_ignore');
function cUsWoo_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        if ( isset($_GET['cUsWoo_ignore_notice']) && '0' == $_GET['cUsWoo_ignore_notice'] ) {
             add_user_meta($user_id, 'cUsWoo_ignore_notice', 'true', true);
	}
}

/*
 * --------------------------------------------------------------
 * 
 * UNISTALL ROUTINES
 * 
 * Method in charge to remove all plugin options and settings
 * @since 1.0
 * @return null
 */
if (!function_exists('cUsWoo_plugin_db_uninstall')) {

    function cUsWoo_plugin_db_uninstall() {

        $cUsWoo_api = new cUsComAPI_WOO();
        $cUsWoo_api->resetData(); //RESET DATA
        
        cUsWoo_page_settings_cleaner();
        
    }
    
}
register_uninstall_hook(__FILE__, 'cUsWoo_plugin_db_uninstall');