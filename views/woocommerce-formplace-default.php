<?php
/**
 * 
 * WOOCOMMERCE FORM BY CONTACTUS.COM
 * 
 * Initialization WooCommerce Defaut Form Placement View
 * @since 1.0 First time this was introduced into WooCommerce Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 * */
?>

<form method="post" action="admin.php?page=cUsWoo_form_plugin" id="cUsWoo_selectable" class="cus_versionform tab_version <?php echo ( strlen($cus_version) && $cus_version != 'tab') ? 'hidden' : ''; ?>" name="cUsWoo_defaultformkey">
    <h3 class="form_title">Available Form Types</h3>
    <div class="pageselect_cont">
        <p>If you want use one of your default forms in all WordPress environment just select as "Default" and will appear in you site.</p>
        <p>If you want to change the default form for each form type, go to the form settings page in your ContactUs.com admin panel, by clicking 
            <a href="<?php echo cUsWOO_PARTNER_URL; ?>/index.php?loginName=<?php echo $cUs_API_Account; ?>&userPsswd=<?php echo urlencode($cUs_API_Key); ?>&confirmed=1&redir_url=<?php echo $default_deep_link . '?pageID=81'; ?>" target="_blank" class="blue_link">here</a>
            , and follow these instructions. <a href="http://help.contactus.com/hc/en-us/articles/201090883-Setting-Default-Forms" target="_blank" class="blue_link">http://help.contactus.com/hc/en-us/articles/201090883-Setting-Default-Forms</a>
        </p>

        <div class="loadingMessage def"></div><div class="advice_notice">Advice ....</div><div class="notice">Messages....</div>
        <ul class="selectable_pages defaultF">

            <?php
            /*
             * DEFAULT FORM TYPES
             * Render Forms Data
             */

            if ($cUsWoo_API_getFormKeys) {
                $cUs_json = json_decode($cUsWoo_API_getFormKeys);
                switch ($cUs_json->status) {
                    case 'success':
                        foreach ($cUs_json->data as $oForms => $oForm) {
                            if (cUsWoo_allowedFormType($oForm->form_type) && $oForm->default == 1) {

                                //RE-ASSING DEFAULT FORM KEY
                                //$form_key = updateDefaultFormKey($oForm->form_key);
                                ?>

                                <li class="ui-widget-content <?php echo $oForm->form_type; ?>">
                                    <div class="page_title">
                                        <span class="name">Name: <strong><?php echo $oForm->form_name ?></strong></span>  | 
                                        <span class="key">Key: <?php echo $oForm->form_key; ?></span>
                                    </div>

                                    <div class="options">
                                        <input type="radio" name="defaultformkey[]" value="<?php echo $oForm->form_key; ?>" id="formkeyradio-<?php echo $oForm->form_id; ?>-1" class="setDefaulFormKey" <?php echo ($oForm->form_key == $form_key) ? 'checked' : '' ?> />
                                        <label class="setLabel label-<?php echo $oForm->form_id; ?>" for="formkeyradio-<?php echo $oForm->form_id; ?>-1" title="Set as Default, click to save"><?php echo ($oForm->form_key == $form_key) ? 'Default' : 'Set as Default' ?></label>
                                    </div>
                                </li>

                                <?php
                            }
                        }
                        break;
                } //endswitch;
            }
            ?>
        </ul>
    </div>
</form>

<form method="post" action="admin.php?page=cUsWoo_form_plugin" id="cUsWoo_button" class="cus_versionform tab_version <?php echo ( strlen($cus_version) && $cus_version != 'tab') ? 'hidden' : ''; ?>" name="cUsWoo_button">

    <input type="hidden" class="tab_user" name="tab_user" value="1" />
    <input type="hidden" name="cus_version" value="tab" />
    <input type="hidden" value="settings" name="option" />

</form>