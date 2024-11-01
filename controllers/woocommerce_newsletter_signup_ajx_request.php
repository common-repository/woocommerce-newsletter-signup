<?php

// loginAlreadyUser handler function...
/*
 * Method in charge to login user via ajax post request vars
 * @since 2.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUsWoo_loginAlreadyUser', 'cUsWoo_loginAlreadyUser_callback');
function cUsWoo_loginAlreadyUser_callback() {
    
    $cUsWoo_api = new cUsComAPI_WOO();
    $cUs_email = $_REQUEST['email'];
    $cUs_pass = $_REQUEST['pass'];
    
    //API CALL TO getAPICredentials
    $cUsWoo_API_credentials = $cUsWoo_api->getAPICredentials($cUs_email, $cUs_pass); //api hook;
    
    if($cUsWoo_API_credentials){
        $cUs_json = json_decode($cUsWoo_API_credentials);
        
        //SWITCH API STATUS RESPONSE
        switch ( $cUs_json->status  ) {
            case 'success':
                
                $cUs_API_Account    = $cUs_json->api_account;
                $cUs_API_Key        = $cUs_json->api_key;
                
                if(strlen(trim($cUs_API_Account)) && strlen(trim($cUs_API_Key))){
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUsWoo_settings_userCredentials', $aryUserCredentials);
                    
                    $cUsWoo_API_getKeysResult = $cUsWoo_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                    
                    $old_options = get_option('contactus_settings'); //GET THE OLD OPTIONS
                    
                    $cUs_jsonKeys = json_decode($cUsWoo_API_getKeysResult);
                
                    if($cUs_jsonKeys->status == 'success' ){
                        
                        $postData = array( 'email' => $cUs_email, 'credential'    => $cUs_pass);
                        update_option('cUsWoo_settings_userData', $postData);
                        
                        $cUsWoo_deeplinkview = $cUsWoo_api->get_deeplink( $cUs_jsonKeys->data );
                        
                        // get a default deeplink
                        update_option('cUsWoo_settings_default_deep_link_view', $cUsWoo_deeplinkview ); // DEFAULT FORM KEYS
                        
                        foreach ($cUs_jsonKeys->data as $oForms => $oForm) {
                            if ($oForm->default == 1){ //GET DEFAULT CONTACT FORM KEY
                               $defaultFormKey = $oForm->form_key;
                               $deeplinkview   = $oForm->deep_link_view;
                               $defaultFormId  = $oForm->form_id;
                               break;
                            }
                        } 
                            
                        if(!strlen($defaultFormKey)){
                                //echo 2; //NO ONE CONTACT FORM 
                                
                                $aryResponse = array(
                                    'status' => 2,
                                    'cUs_API_Account' 	=> $cUs_API_Account,
                                    'cUs_API_Key' 	=> $cUs_API_Key,
                                    'deep_link_view'	=> $cUsWoo_deeplinkview
                                );
                                
                               
                        }else{
                            
                            $aryFormOptions = array('tab_user' => 1,'cus_version' => 'tab'); //DEFAULT SETTINGS / FIRST TIME
                            
                            update_option('cUsWoo_settings_form', $aryFormOptions );//UPDATE FORM SETTINGS
                            update_option('cUsWoo_settings_form_key', $defaultFormKey);//DEFAULT FORM KEYS
                            update_option('cUsWoo_settings_form_keys', $cUs_jsonKeys); // ALL FORM KEYS
                            update_option('cUsWoo_settings_form_id', $defaultFormId); // DEFAULT FORM KEYS
                            update_option('cUsWoo_settings_default_deep_link_view', $deeplinkview); // DEFAULT FORM KEYS
                            
                            $aryResponse = array('status' => 1);
                            
                        }

                            //echo 1;
                        
                    }else{
                        $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                    } 
                    
                }else{
                    $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                }
                
                break;

            case 'error':
                $aryResponse = array('status' => 3, 'message' => $cUs_json->error);
                break;
        }
    }
    
    echo json_encode($aryResponse);
    
    die();
}


// cUsWoo_verifyCustomerEmail handler function...
/*
 * Method in charge to verify if the email exist via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_verifyCustomerEmail', 'cUsWoo_verifyCustomerEmail_callback');
function cUsWoo_verifyCustomerEmail_callback() {
    
    if      ( !strlen(filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING)) ){      echo 'Missing First Name, is required fields';      die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING)) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL)) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'website')) ){    echo 'Missing Website, is required field';         die();
    }else{
        
        $cUsWoo_api = new cUsComAPI_WOO(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => filter_input(INPUT_POST, 'fName',FILTER_SANITIZE_STRING),
            'lname' => filter_input(INPUT_POST, 'lName',FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL),
            'phone' => filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_NUMBER_INT),
            'credential' => filter_input(INPUT_POST, 'credential'),
            'website' => filter_input(INPUT_POST, 'website')
        );

        $cUsWoo_API_EmailResult = $cUsWoo_api->verifyCustomerEmail( filter_input(INPUT_POST, 'Email',FILTER_VALIDATE_EMAIL) ); //EMAIL VERIFICATION
        if($cUsWoo_API_EmailResult) {
            $cUsWoo_jsonEmail = json_decode($cUsWoo_API_EmailResult);
            
            switch ($cUsWoo_jsonEmail->result){
                case 0 :
                    //echo 'No Existe';
                    echo 1;
                    update_option('cUsWoo_settings_userData', $postData);
                    break;
                case 1 :
                    //echo 'Existe';
                    echo 2;//ALREDY CUS USER
                    delete_option('cUsWoo_settings_userData');
                    break;
            }
            
        }else{
            echo 'Unfortunately there has being an error during the application, please try again';
            exit();
        }
         
    }
    
    die();
}


// cUsWoo_createCustomer handler function...
/*
 * Method in charge to create a contactus.com user via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_createCustomer', 'cUsWoo_createCustomer_callback');
function cUsWoo_createCustomer_callback() {
    
    $cUsWoo_userData = get_option('cUsWoo_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsWoo_userData['fname']) ){      echo 'Missing First Name, is required fields';      die();
    }elseif  ( !strlen($cUsWoo_userData['lname']) ){      echo 'Missing Last Name, is required field';       die();
    }elseif  ( !strlen($cUsWoo_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($cUsWoo_userData['website']) ){    echo 'Missing Website, is required field';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING)) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen(filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING)) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUsWoo_api = new cUsComAPI_WOO(); //CONTACTUS.COM API
        
        $postData = array(
            'fname' => $cUsWoo_userData['fname'],
            'lname' => $cUsWoo_userData['lname'],
            'email' => $cUsWoo_userData['email'],
            'website' => $cUsWoo_userData['website'],
            'phone' => preg_replace('/[^0-9]+/i', '', $cUsWoo_userData['phone']),
            'Template_Desktop_Form' => filter_input(INPUT_POST, 'Template_Desktop_Form',FILTER_SANITIZE_STRING),
            'Template_Desktop_Tab' => filter_input(INPUT_POST, 'Template_Desktop_Tab',FILTER_SANITIZE_STRING),
            'Main_Category' => filter_input(INPUT_POST, 'CU_category',FILTER_SANITIZE_STRING),
            'Sub_Category' => filter_input(INPUT_POST, 'CU_subcategory',FILTER_SANITIZE_STRING),
            'Goals' => filter_input(INPUT_POST, 'CU_goals',FILTER_SANITIZE_STRING)
        );
        
        $cUsWoo_API_result = $cUsWoo_api->createCustomer($postData, $cUsWoo_userData['credential']);
        if($cUsWoo_API_result) {

            $cUs_json = json_decode($cUsWoo_API_result);

            switch ( $cUs_json->status ) {

                case 'success':
                    
                    echo 1;//GREAT
                    update_option('cUsWoo_settings_form_key', $cUs_json->form_key ); //finally get form key form contactus.com // SESSION IN
                    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
                        'tab_user'          => 1,
                        'cus_version'       => 'tab'
                    ); 
                    update_option('cUsWoo_settings_form', $aryFormOptions );//UPDATE FORM SETTINGS
                    update_option('cUsWoo_settings_userData', $postData);
                    
                    $cUs_API_Account    = $cUs_json->api_account;
                    $cUs_API_Key        = $cUs_json->api_key;
                    
                    $aryUserCredentials = array(
                        'API_Account' => $cUs_API_Account,
                        'API_Key'     => $cUs_API_Key
                    );
                    update_option('cUsWoo_settings_userCredentials', $aryUserCredentials);
                    
                    // ********************************
                    // get here the default deeplink after creating customer
                    $cUsWoo_API_getKeysResult = $cUsWoo_api->getFormKeysData($cUs_API_Account, $cUs_API_Key); //api hook;
                    
                    $cUs_jsonKeys = json_decode( $cUsWoo_API_getKeysResult );
                    $cUsWoo_deeplinkview = $cUsWoo_api->get_deeplink( $cUs_jsonKeys->data );
                    // get the default contact form deeplink
                    if( strlen( $cUsWoo_deeplinkview ) ){
                        update_option('cUsWoo_settings_default_deep_link_view', $cUsWoo_deeplinkview ); // DEFAULT FORM KEYS
                    }
                    // save the form id for this donation new user
                    update_option( 'cUsWoo_settings_form_id', $cUs_jsonKeys->data[0]->form_id );

                break;

                case 'error':

                    if($cUs_json->error == 'Email exists'){
                        echo 2;//ALREDY CUS USER
                        //$cUsWoo_api->resetData(); //RESET DATA
                    }else{
                        //ANY ERROR
                        echo $cUs_json->error;
                        //$cUsWoo_api->resetData(); //RESET DATA
                    }
                    
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsWoo_api->resetData(); //RESET DATA
        }
         
    }
    
    die();
}


// LoadDefaultKey handler function...
/*
 * Method in charge to set default form key by user via ajax post request vars
 * @since 2.0
 * @return array jSon encoded array
 */
add_action('wp_ajax_cUsWoo_LoadDefaultKey', 'cUsWoo_LoadDefaultKey_callback');
function cUsWoo_LoadDefaultKey_callback() {
    
    $cUsWoo_api = new cUsComAPI_WOO();
    $cUsWoo_userData = get_option('cUsWoo_settings_userData'); //get the saved user data
    $cUs_email = $cUsWoo_userData['email'];
    $cUs_pass = $cUsWoo_userData['credential'];
    
    $cUsWoo_API_result = $cUsWoo_api->getFormKeysData($cUs_email, $cUs_pass); //api hook;
    if($cUsWoo_API_result){
        $cUs_json = json_decode($cUsWoo_API_result);

        switch ( $cUs_json->status  ) {
            case 'success':
                
                foreach ($cUs_json->data as $oForms => $oForm) {
                    if ($oForms !='status' && $oForm->form_type == 0 && $oForm->default == 1){//GET DEFAULT CONTACT FORM KEY
                       $defaultFormKey = $oForm->form_key;
                    }
                }
                
                update_option('cUsWoo_settings_form_key', $defaultFormKey); 
                
                echo 1;
                break;

            case 'error':
                echo $cUs_json->error;
                //$cUsWoo_api->resetData(); //RESET DATA
                break;
        }
    }
    
    die();
}

// cUsWoo_setDefaulFormKey handler function...
/*
 * Method in charge to set default form key in all WP environment via ajax post request vars
 * @since 4.0.1
 * @return atring Status value array
 */
add_action('wp_ajax_cUsWoo_setDefaulFormKey', 'cUsWoo_setDefaulFormKey_callback');
function cUsWoo_setDefaulFormKey_callback() {
    
    if(isset($_REQUEST['formKey'])){
       update_option('cUsWoo_settings_form_key', $_REQUEST['formKey']);
       echo 1;//GREAT
    }
    
    die();
}

// cUsWoo_createCustomer handler function...
/*
 * Method in charge to update user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_UpdateTemplates', 'cUsWoo_UpdateTemplates_callback');
function cUsWoo_UpdateTemplates_callback() {
    
    $cUsWoo_userData = get_option('cUsWoo_settings_userData'); //get the saved user data
    
    if      ( !strlen($cUsWoo_userData['email']) ){      echo 'Missing/Invalid Email, is required field';   die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';         die();
    }else{
        
        $cUsWoo_api = new cUsComAPI_WOO(); //CONTACTUS.COM API
        $form_key       = get_option('cUsWoo_settings_form_key');
        $postData = array(
            'email' => $cUsWoo_userData['email'],
            'credential' => $cUsWoo_userData['credential'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsWoo_API_result = $cUsWoo_api->updateFormSettings($postData, $form_key);
        if($cUsWoo_API_result) {

            $cUs_json = json_decode($cUsWoo_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsWoo_api->resetData(); //RESET DATA
                break;


            }
            
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsWoo_api->resetData(); //RESET DATA
        }
         
    }
    
    die();
}

/*
 * Method in charge to chage user form templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_changeFormTemplate', 'cUsWoo_changeFormTemplate_callback');
function cUsWoo_changeFormTemplate_callback() {
    
    $cUsWoo_userData = get_option('cUsWoo_settings_userCredentials'); //get the saved user data
   
    if      ( !strlen($cUsWoo_userData['API_Account']) ){     echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUsWoo_userData['API_Key']) ){         echo 'Missing Form Key';         die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Form']) ){    echo 'Missing Form Template';         die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){    echo 'Missing Form Key';         die();
    }else{
        
        $cUsWoo_api = new cUsComAPI_WOO(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsWoo_userData['API_Account'],
            'API_Key'           => $cUsWoo_userData['API_Key'],
            'Template_Desktop_Form' => $_REQUEST['Template_Desktop_Form']
        );
        
        $cUsWoo_API_result = $cUsWoo_api->updateFormSettings($postData, $form_key);
        if($cUsWoo_API_result) {

            $cUs_json = json_decode($cUsWoo_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsWoo_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsWoo_api->resetData(); //RESET DATA
        } 
        
         
    } 
    
    die();
}

/*
 * Method in charge to update user tab templates via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_changeTabTemplate', 'cUsWoo_changeTabTemplate_callback');
function cUsWoo_changeTabTemplate_callback() {
    
    $cUsWoo_userData = get_option('cUsWoo_settings_userCredentials'); //get the saved user data
   
    if       ( !strlen($cUsWoo_userData['API_Account']) ){       echo 'Missing API Account';   die();
    }elseif  ( !strlen($cUsWoo_userData['API_Key']) ){           echo 'Missing Form Key';      die();
    }elseif  ( !strlen($_REQUEST['Template_Desktop_Tab']) ){    echo 'Missing Tab Template';  die();
    }elseif  ( !strlen($_REQUEST['form_key']) ){                echo 'Missing Form Key';      die();
    }else{
        
        $cUsWoo_api = new cUsComAPI_WOO(); //CONTACTUS.COM API
        $form_key = $_REQUEST['form_key'];
        
        $postData = array(
            'API_Account'       => $cUsWoo_userData['API_Account'],
            'API_Key'           => $cUsWoo_userData['API_Key'],
            'Template_Desktop_Tab' => $_REQUEST['Template_Desktop_Tab']
        );
        
        $cUsWoo_API_result = $cUsWoo_api->updateFormSettings($postData, $form_key);
        if($cUsWoo_API_result) {

            $cUs_json = json_decode($cUsWoo_API_result);

            switch ( $cUs_json->status  ) {

                case 'success':
                    echo 1;//GREAT

                break;

                case 'error':
                    //ANY ERROR
                    echo $cUs_json->error;
                    //$cUsWoo_api->resetData(); //RESET DATA
                break;


            } 
        }else{
             //echo 3;//API ERROR
             echo $cUs_json->error;
             // $cUsWoo_api->resetData(); //RESET DATA
        } 
        
         
    }
    
    die();
}



// save custom selected pages handler function...
/*
 * Method in charge to save form settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_saveCustomSettings', 'cUsWoo_saveCustomSettings_callback');
function cUsWoo_saveCustomSettings_callback() {
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => filter_input(INPUT_POST, 'tab_user'), 
        'cus_version'       => filter_input(INPUT_POST, 'cus_version'),
        'form_key'       => filter_input(INPUT_POST, 'form_key')
    ); 
    update_option('cUsWoo_settings_form', $aryFormOptions );//UPDATE FORM SETTINGS
    update_option('cUsWoo_settings_form_key', filter_input(INPUT_POST, 'form_key') );
    
    cUsWoo_page_settings_cleaner();
    
    delete_option( 'cUsWoo_settings_inlinepages' );
    delete_option( 'cUsWoo_settings_tabpages' );
    
    $aryResponse = array('status' => 1, 'message' => 'Success');    
    echo json_encode($aryResponse);
   
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_deletePageSettings', 'cUsWoo_deletePageSettings_callback');
function cUsWoo_deletePageSettings_callback() {
    
    echo $pageID = filter_input(INPUT_POST, 'pageID');
    
    if($pageID == 'home'){
        
        delete_option( 'cUsWoo_settings_home' );
        
    }elseif ($pageID == 'allpages') {

        delete_option( 'cUsWoo_settings_form' );
        
    }else{
        
        delete_post_meta($pageID, 'cUsWoo_settings_FormByPage');//reset values
    }
    
    
    delete_post_meta($pageID, 'cUsWoo_settings_FormByPage');//reset values
    cUsWoo_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    
    $aryTabPages = get_option('cUsWoo_settings_tabpages');
    $aryTabPages = cUsWoo_removePage($pageID,$aryTabPages);
    update_option( 'cUsWoo_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
    $aryInlinePages = get_option('cUsWoo_settings_inlinepages');
    $aryInlinePages = cUsWoo_removePage($pageID,$aryInlinePages);
    update_option( 'cUsWoo_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
    
    die();
}

// save custom selected pages handler function...
/*
 * Method in charge to update user page settings from page selection via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_changePageSettings', 'cUsWoo_changePageSettings_callback');
function cUsWoo_changePageSettings_callback() {
    
    $pageID = filter_input(INPUT_POST, 'pageID');
    $cus_version = filter_input(INPUT_POST, 'cus_version');
    delete_post_meta($pageID, 'cUsWoo_settings_FormByPage');//reset values
    cUsWoo_inline_shortcode_cleaner_by_ID($pageID); //RESET SC
    $aryTabPages = get_option('cUsWoo_settings_tabpages');
    $aryInlinePages = get_option('cUsWoo_settings_inlinepages');
    
    switch ( $cus_version ){
        case 'tab':
            
            $tabUser = 1;
            
            $aryTabPages[] = $pageID;
            $aryTabPages = array_unique($aryTabPages);
            update_option('cUsWoo_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            
            if(!empty($aryInlinePages)){
                $aryInlinePages = cUsWoo_removePage($pageID,$aryInlinePages);
                update_option( 'cUsWoo_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            }
            
            echo 1;
            
            break;
        case 'inline':
            
            $tabUser = 0;
            
            $aryInlinePages[] = $pageID;
            $aryInlinePages = array_unique($aryInlinePages);
            update_option( 'cUsWoo_settings_inlinepages', $aryInlinePages); //UPDATE OPTIONS
            
            if(!empty($aryTabPages)){
                $aryTabPages = cUsWoo_removePage($pageID,$aryTabPages);
                update_option( 'cUsWoo_settings_tabpages', $aryTabPages); //UPDATE OPTIONS
            }
            
            cUsWoo_inline_shortcode_add($pageID); //ADDING SHORTCODE FOR INLINE PAGES
            
            echo 1;
            
            break;
    } 
    
    $aryFormOptions = array( //DEFAULT SETTINGS / FIRST TIME
        'tab_user'          => $tabUser,
        'form_key'          => filter_input(INPUT_POST, 'form_key'),   
        'cus_version'       => filter_input(INPUT_POST, 'cus_version')
    );
    
    if($pageID == 'home'){
        
        update_option( 'cUsWoo_settings_home', $aryFormOptions );//UPDATE FORM SETTINGS
        delete_option( 'cUsWoo_settings_form' );
        
    }elseif ($pageID == 'allpages') {
        
        update_option( 'cUsWoo_settings_form', $aryFormOptions );//UPDATE FORM SETTINGS
        update_option( 'cUsWoo_settings_form_key', filter_input(INPUT_POST, 'form_key') );

        cUsWoo_page_settings_cleaner();

        delete_option( 'cUsWoo_settings_inlinepages' );
        delete_option( 'cUsWoo_settings_tabpages' );
        delete_option( 'cUsWoo_settings_home' );
        
    }else{
        
        delete_option( 'cUsWoo_settings_form' );
        update_post_meta($pageID, 'cUsWoo_settings_FormByPage', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
    }
    
    die();
}

/*
 * Method in charge to remove page settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
function cUsWoo_removePage($valueToSearch, $arrayToSearch){
    $key = array_search($valueToSearch,$arrayToSearch);
    if($key!==false){
        unset($arrayToSearch[$key]);
    }
    return $arrayToSearch;
}

// logoutUser handler function...
/*
 * Method in charge to remove wp options saved with this plugin via ajax post request vars
 * @since 1.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_logoutUser', 'cUsWoo_logoutUser_callback');
function cUsWoo_logoutUser_callback() {
    
    $cUsWoo_api = new cUsComAPI_WOO();
    $cUsWoo_api->resetData(); //RESET DATA
    
    delete_option( 'cUsWoo_settings_api_key' );  
    delete_option( 'cUsWoo_settings_form_key' );  
    delete_option( 'cUsWoo_settings_list_Name' );  
    delete_option( 'cUsWoo_settings_list_ID' );  
    
    echo 'Deleted.... User data'; //none list
    
    die();
}

//WOO CATEGORIES

// save custom selected categories handler function...
/*
 * Method in charge to update woocommerce category selection via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_changeCatSettings', 'cUsWoo_changeCatSettings_callback');
function cUsWoo_changeCatSettings_callback() {
    
    $catID = filter_input(INPUT_POST, 'catID');
     
    $aryFormOptions = array(
        'tab_user'          => 1,
        'allowSubCats'      => filter_input(INPUT_POST, 'allowSubCats'), 
        'allowProds'        => filter_input(INPUT_POST, 'allowProds'), 
        'form_key'          => filter_input(INPUT_POST, 'form_key'),   
        'cus_version'       => filter_input(INPUT_POST, 'cus_version')
    );
    
    if($catID){
        //SAVE DATA ON TERM META DATA
        update_option( 'cUsWoo_settings_cat_'.$catID, $aryFormOptions); //UPDATE OPTIONS
        
        if($catID != 'allcats'){
            delete_option('cUsWoo_settings_cat_allcats');
        }else{
            cUsWoo_deleteAllCatSettings();
        }
        
        $aryResponse = array('status' => 1, 'message' => 'Category saved successfully');
        
    }
    
    echo json_encode($aryResponse);
    
    die();
}

/*
 * Method in charge to remove woocommerce categories settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_deleteCatSettings', 'cUsWoo_deleteCatSettings_callback');
function cUsWoo_deleteCatSettings_callback() {
    
    $catID = filter_input(INPUT_POST, 'catID');
    
    if($catID){
        delete_option('cUsWoo_settings_cat_'.$catID);
        $aryResponse = array('status' => 1, 'message' => 'Category saved successfully');
    }else{
        $aryResponse = array('status' => 2, 'message' => 'Unfortunately there has being an error during the application.');
    }
    
    echo json_encode($aryResponse);
    
    die();
}

/*
 * Method in charge to remove woocommerce categories settings via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */

function cUsWoo_deleteAllCatSettings() {
    
    $cUsWoo_getCatsArgs = array('hierarchical' => 1,'show_option_none' => '','hide_empty' => 0,'parent' => 0,'taxonomy' => 'product_cat');
    $cUsWoo_Cats = get_categories($cUsWoo_getCatsArgs);

    if (is_array($cUsWoo_Cats) && !empty($cUsWoo_Cats)) {
        foreach ($cUsWoo_Cats as $cUsWoo_Cat) {
            delete_option('cUsWoo_settings_cat_'.$cUsWoo_Cat->term_id);
        }

    }
}

//WOO PRODUCTS

/*
 * Method in charge to save forms by product via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_saveProdSettings', 'cUsWoo_saveProdSettings_callback');
function cUsWoo_saveProdSettings_callback() {
    
    $prodID = filter_input(INPUT_POST, 'prodID');
    $form_key = filter_input(INPUT_POST, 'form_key');
    
    $aryFormOptions = array( //LOAD OLD PAGE SETTINGS / FIRST TIME
        'tab_user'          => 1,
        'form_key'          => $form_key,
        'cus_version'       => 'tab'
    );

    if($prodID){
        update_post_meta($prodID, 'cUsWoo_settings_FormByPage', $aryFormOptions);//SAVE DATA ON POST TYPE PAGE METAS
        $aryResponse = array('status' => 1, 'message' => 'Product saved successfully');
    }
    
    echo json_encode($aryResponse);
    
    die();
}

/*
 * Method in charge to remove forms by product via ajax post request vars
 * @since 2.0
 * @return string Value status to switch
 */
add_action('wp_ajax_cUsWoo_deleteProdSettings', 'cUsWoo_deleteProdSettings_callback');
function cUsWoo_deleteProdSettings_callback() {
    
    $prodID = filter_input(INPUT_POST, 'prodID');

    if($prodID){
        delete_post_meta($prodID, 'cUsWoo_settings_FormByPage');//reset values
        $aryResponse = array('status' => 1, 'message' => 'Product saved successfully');
    }
    
    echo json_encode($aryResponse);
    
    die();
}
