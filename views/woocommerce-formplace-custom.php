<?php
/**
 * 
 * WOOCOMMERCE FORM BY CONTACTUS.COM
 * 
 * Initialization WooCommerce Custom Form Placement View
 * @since 1.0 First time this was introduced into WooCommerce Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140127
 * */
?>
<form method="post" action="admin.php?page=cUsWoo_form_plugin" id="cUsWoo_selectable" class="cus_versionform select_version" name="cUsWoo_selectable">
    <h3 class="form_title">WooCommerce Pages</h3>
    <div class="pageselect_cont">
        <?php
        /*
         * Get Main WP Pages
         */
        $mypages = get_pages(array( ' post_status ' => 'publish,private', 'sort_column' => 'post_date', 'sort_order' => 'desc'));

        if (is_array($mypages) && !empty($mypages)) {

            
                $getAllPages    = get_option('cUsWoo_settings_form');
                $allpages_boolTab   = $getAllPages['tab_user'];
                $allpages_cus_version = $getAllPages['cus_version'];
                $allpages_form_key  = $getAllPages['form_key'];
            ?>
            <ul class="selectable_pages">

                <li class="ui-widget-content"> 
                    <div class="page_title">
                        <span class="title">All Shop Pages</span>
                        <span class="bullet ui-icon ui-icon-circle-zoomin">
                            <a target="_blank" href="<?php echo get_option('home'); ?>" title="Preview" class="setLabels">&nbsp;</a>
                        </span>
                    </div>

                    <div class="options home">
                        <input type="radio" name="pages[allpages]" class="radio-allpages" id="radio-allpages" value="tab" <?php echo (is_array($getAllPages) || $allpages_cus_version == 'tab') ? 'checked' : '' ?> />
                        <label class="label-allpages setLabels" for="radio-allpages" title="Will show up as a floating tab">Enabled</label>
                        <a class="ui-state-default ui-corner-all pageclear-allpages setLabels" href="javascript:;" title="Clear All pages settings"><label class="ui-icon ui-icon-circle-close">&nbsp;</label></a>
                    </div>

                    <div class="form_template form-templates-allpages">
                        <h4>Pick which form you would like on this page</h4>
                        <div class="template_slider slider-allpages">
                            <?php
                            /*
                             * Render Forms Data
                             */
                            
                            if ($cUsWoo_API_getFormKeys) {
                                $cUs_json = json_decode($cUsWoo_API_getFormKeys);

                                switch ($cUs_json->status) {
                                    case 'success':
                                        foreach ($cUs_json->data as $oForms => $oForm) {

                                            if (cUsWoo_allowedFormType($oForm->form_type)) {

                                                if (strlen($allpages_form_key) && $allpages_form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else if (!strlen($allpages_form_key) && $form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else {
                                                    $itemClass = 'tpl';
                                                }
                                                ?>
                                                <span class="<?php echo $itemClass; ?> item template-allpages" rel="<?php echo $oForm->form_key ?>">
                                                    <img class="tab tab-home" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
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
                            <input type="button" class="btn lightblue save-page save-allpages" value="Save" />
                        </div>
                        <div class="save_message save_message_allpages">
                            <p>Sending . . .</p>
                        </div>
                    </div>

                    <input type="hidden" class="cus_version_allpages" value="<?php echo $cus_version; ?>" />
                    <input type="hidden" class="form_key_allpages" value="<?php echo (strlen($home_form_key)) ? $home_form_key : $form_key; ?>" />

                </li>
                <script>

                    /*
                     * ALL SHOP PAGES JS ACTIONS
                     */

                    jQuery('.pageclear-allpages').click(function() {

                        jQuery("#dialog-message").html('Do you want to delete your settings?');
                        jQuery("#dialog-message").dialog({
                            resizable: false,
                            width: 430,
                            title: 'Delete page settings?',
                            height: 130,
                            modal: true,
                            buttons: {
                                "Yes": function() {

                                    jQuery('.radio-allpages').removeAttr('checked');
                                    jQuery('.label-allpages').removeClass('ui-state-active');

                                    jQuery('.template-allpages').removeClass('default');

                                    jQuery.deletePageSettings('allpages');

                                    jQuery(this).dialog("close");

                                },
                                Cancel: function() {
                                    jQuery(this).dialog("close");
                                }
                            }
                        });

                    });

                    jQuery('.radio-allpages').click(function() {
                        jQuery('.form_template').fadeOut();
                        jQuery('.form-templates-allpages').slideDown();

                        jQuery('.cus_version_allpages').val(jQuery(this).val());

                    });
                    jQuery('.template-allpages').click(function() {
                        jQuery('.form_key_allpages').val(jQuery(this).attr('rel'));
                        jQuery('.slider-allpages .item').removeClass('default');
                        jQuery(this).addClass('default');
                    });
                    jQuery('.save-allpages').click(function() {
                        var cus_version_allpages = jQuery('.cus_version_allpages').val();
                        var form_key_allpages = jQuery('.form_key_allpages').val();

                        jQuery( "#dialog-message" ).html('<p>You are about to change to show selected form in all your pages, your selected form will show up in all of your site and clear your custom pages settings.</p>');
                        jQuery( "#dialog-message" ).dialog({
                            resizable: false,
                            width:430,
                            title: 'Save page settings Settings?',
                            height:180,
                            modal: true,
                            buttons: {
                                "Yes": function() {
                                    
                                    jQuery.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_changePageSettings',pageID:'allpages',form_key:form_key_allpages,cus_version:'tab',tab_user:1},
                                        success: function(data) {
                                            
                                            jQuery( "#dialog-message" ).dialog( "close" );
                                            message = '<p>Saved Successfully . . . .</p>';
                                            jQuery('.save_message_allpages').show().html(message);
                                            jQuery('.save-page-allpages').val('Completed . . .');
                                            
                                            setTimeout(function(){
                                                
                                                jQuery('.ui-buttonset label').removeClass('ui-state-active');
                                                jQuery('.save_message_allpages').fadeOut();
                                                jQuery('.save-page-allpages').val('Save');
                                                jQuery('.form-templates-allpages').slideUp();
                                                jQuery('.label-allpages').addClass('ui-state-active');
                                                
                                            },2000);

                                        },
                                        async: false
                                    });

                                },
                                Cancel: function() {
                                    jQuery( this ).dialog( "close" );
                                }
                            }
                        });
                        

                    });
                </script>
                <li class="ui-widget-content"> 
                    <div class="page_title">
                        <span class="title">Shop Home Page</span>
                        <span class="bullet ui-icon ui-icon-circle-zoomin">
                            <a target="_blank" href="<?php echo get_option('home'); ?>" title="Home Preview" class="setLabels">&nbsp;</a>
                        </span>
                    </div>
                    <?php
                        $homeSettings = get_option('cUsWoo_settings_home');
                        $home_form_key = $homeSettings['form_key'];
                    ?>
                    <div class="options home">
                        <input type="radio" name="pages[home]" class="home-page" id="pageradio-home" value="tab" <?php echo ( is_array($homeSettings) && !empty($homeSettings) ) ? 'checked' : '' ?> />
                        <label class="label-home setLabels" for="pageradio-home" title="Will show up as a floating tab">Enabled</label>
                        <a class="ui-state-default ui-corner-all pageclear-home setLabels" href="javascript:;" title="Clear Home page settings"><label class="ui-icon ui-icon-circle-close">&nbsp;</label></a>
                    </div>

                    <div class="form_template form-templates-home">
                        <h4>Pick which form you would like on this page</h4>
                        <div class="template_slider slider-home">
                            <?php
                            /*
                             * HOME PAGE
                             * Render Forms Data
                             */

                            if ($cUsWoo_API_getFormKeys) {
                                $cUs_json = json_decode($cUsWoo_API_getFormKeys);

                                switch ($cUs_json->status) {
                                    case 'success':
                                        foreach ($cUs_json->data as $oForms => $oForm) {

                                            if (cUsWoo_allowedFormType($oForm->form_type)) {

                                                if (strlen($home_form_key) && $home_form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else if (!strlen($home_form_key) && $form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else {
                                                    $itemClass = 'tpl';
                                                }
                                                ?>
                                                <span class="<?php echo $itemClass; ?> item template-home" rel="<?php echo $oForm->form_key ?>">
                                                    <img class="tab tab-home" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
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
                            <input type="button" class="btn lightblue save-page save-page-home" value="Save" />
                        </div>
                        <div class="save_message save_message_home">
                            <p>Sending . . .</p>
                        </div>
                    </div>

                    <input type="hidden" class="cus_version_home" value="<?php echo $cus_version; ?>" />
                    <input type="hidden" class="form_key_home" value="<?php echo (strlen($home_form_key)) ? $home_form_key : $form_key; ?>" />

                </li>
                <hr/>
                <script>

                    /*
                     * HOME PAGE JS ACTION
                     * 
                     * Clear home page settngs
                     */

                    jQuery('.pageclear-home').click(function() {

                        jQuery("#dialog-message").html('Do you want to delete your settings in this page?');
                        jQuery("#dialog-message").dialog({
                            resizable: false,
                            width: 430,
                            title: 'Delete page settings?',
                            height: 130,
                            modal: true,
                            buttons: {
                                "Yes": function() {

                                    jQuery('.home-page').removeAttr('checked');
                                    jQuery('.label-home').removeClass('ui-state-active');

                                    jQuery('.template-home').removeClass('default');

                                    jQuery.deletePageSettings('home');

                                    jQuery(this).dialog("close");

                                },
                                Cancel: function() {
                                    jQuery(this).dialog("close");
                                }
                            }
                        });

                    });


                    jQuery('.home-page').click(function() {
                        jQuery('.form_template').fadeOut();
                        jQuery('.form-templates-home').slideDown();

                        jQuery('.cus_version_home').val(jQuery(this).val());

                    });
                    jQuery('.template-home').click(function() {
                        jQuery('.form_key_home').val(jQuery(this).attr('rel'));
                        jQuery('.slider-home .item').removeClass('default');
                        jQuery(this).addClass('default');
                    });
                    jQuery('.save-page-home').click(function() {
                        var cus_version_home = jQuery('.cus_version_home').val();
                        var form_key_home = jQuery('.form_key_home').val();

                        jQuery.changePageSettings('home', cus_version_home, form_key_home);

                    });
                </script>

                <?php
                /*
                 * PAGE SELECTION
                 * 
                 * Render all main wp pages
                 */

                foreach ($mypages as $page) {

                    if (cUsWoo_allowedWooPages($page->post_name)) {

                        $pageSettings = get_post_meta($page->ID, 'cUsWoo_settings_FormByPage', false);
                        
                        //print_r($pageSettings);

                        if (is_array($pageSettings) && !empty($pageSettings)) {
                            $cus_version = $pageSettings[0]['cus_version'];
                            $form_page_key = $pageSettings[0]['form_key'];
                        }
                        ?>

                        <li class="ui-widget-content">

                            <div class="page_title">
                                <span class="title"><?php echo $page->post_title; ?></span>
                                <span class="bullet ui-icon ui-icon-circle-zoomin">
                                    <a target="_blank" href="<?php echo get_permalink($page->ID); ?>" title="Preview <?php echo $page->post_title; ?> page" class="setLabels">&nbsp;</a>
                                </span>
                            </div>

                            <div class="options">
                                <input type="radio" name="pages[<?php echo $page->ID; ?>]" value="tab" id="pageradio-<?php echo $page->ID; ?>-1" class="<?php echo $page->ID; ?>-page" <?php echo (is_array($getTabPages) && in_array($page->ID, $getTabPages) || $cus_version == 'tab') ? 'checked' : '' ?> />
                                <label class="setLabels label-<?php echo $page->ID; ?>" for="pageradio-<?php echo $page->ID; ?>-1" title="Will show up as a floating tab">Enabled</label>
                                <!-- input type="radio" name="pages[<?php echo $page->ID; ?>]" value="inline" id="pageradio-<?php echo $page->ID; ?>-2" class="<?php echo $page->ID; ?>-page" <?php echo (is_array($getInlinePages) && in_array($page->ID, $getInlinePages) || $cus_version == 'inline') ? 'checked' : '' ?> />
                                <label class="setLabels label-<?php echo $page->ID; ?>" for="pageradio-<?php echo $page->ID; ?>-2" title="The form was added by inserting a short code in your page. You can change its location by moving the short code within the page content">Inline</label -->
                                <a class="ui-state-default ui-corner-all pageclear-<?php echo $page->ID; ?> setLabels" href="javascript:;" title="Clear <?php echo $page->post_title; ?> page settings"><label class="ui-icon ui-icon-circle-close">&nbsp;</label></a>
                            </div>

                            <div class="form_template form-templates-<?php echo $page->ID; ?>">
                                <h4>Pick which Form/Tab combination you would like on <?php echo $page->post_title; ?> page</h4>
                                <div class="template_slider slider-<?php echo $page->ID; ?>">
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

                                                        if (strlen($form_page_key) && $form_page_key == $oForm->form_key) {
                                                            $itemClass = 'default';
                                                        } else if (!strlen($form_page_key) && $form_key == $oForm->form_key) {
                                                            $itemClass = 'default';
                                                        } else {
                                                            $itemClass = 'tpl';
                                                        }
                                                        ?>
                                                        <span class="<?php echo $itemClass; ?> item template-<?php echo $page->ID; ?>" rel="<?php echo $oForm->form_key ?>">
                                                            <img class="tab tab-<?php echo $page->ID; ?>" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
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
                                    <input type="button" class="btn lightblue save-page save-page-<?php echo $page->ID; ?>" value="Save" />
                                </div>
                                <div class="save_message save_message_<?php echo $page->ID; ?>">
                                    <p>Sending . . .</p>
                                </div>
                            </div>

                            <input type="hidden" class="cus_version_<?php echo $page->ID; ?>" value="<?php echo $cus_version; ?>" />
                            <input type="hidden" class="form_key_<?php echo $page->ID; ?>" value="<?php echo (strlen($form_page_key)) ? $form_page_key : $form_key; ?>" />

                        </li>
                        <?php
                        if (empty($pageSettings)) {
                            ?>
                            <script>jQuery(document).ready(function($) {  jQuery('.<?php echo $page->ID; ?>-page').removeAttr('checked').checked = false; });</script>
                            <?php
                        }
                        ?>
                        <script>

                            /*
                             * ACTIONS BY PAGE ID
                             */

                            jQuery('.pageclear-<?php echo $page->ID; ?>').click(function() {

                                jQuery("#dialog-message").html('Do you want to delete your settings in this page?');
                                jQuery("#dialog-message").dialog({
                                    resizable: false,
                                    width: 430,
                                    title: 'Delete page settings?',
                                    height: 130,
                                    modal: true,
                                    buttons: {
                                        "Yes": function() {

                                            jQuery('.<?php echo $page->ID; ?>-page').removeAttr('checked');
                                            jQuery('.label-<?php echo $page->ID; ?>').removeClass('ui-state-active');

                                            jQuery('.template-<?php echo $page->ID; ?>').removeClass('default');

                                            jQuery.deletePageSettings(<?php echo $page->ID; ?>);

                                            jQuery(this).dialog("close");

                                        },
                                        Cancel: function() {
                                            jQuery(this).dialog("close");
                                        }
                                    }
                                });

                            });
                            jQuery('.<?php echo $page->ID; ?>-page').click(function() {
                                jQuery('.form_template').fadeOut();
                                jQuery('.form-templates-<?php echo $page->ID; ?>').slideDown();

                                jQuery('.cus_version_<?php echo $page->ID; ?>').val(jQuery(this).val());

                                var version = jQuery(this).val();

                                if (version == 'tab') {
                                    jQuery('img.tab-<?php echo $page->ID; ?>').show();
                                } else {
                                    jQuery('img.tab-<?php echo $page->ID; ?>').hide();
                                }


                            });
                            jQuery('.template-<?php echo $page->ID; ?>').click(function() {
                                jQuery('.form_key_<?php echo $page->ID; ?>').val(jQuery(this).attr('rel'));
                                jQuery('.slider-<?php echo $page->ID; ?> .item').removeClass('default');
                                jQuery(this).addClass('default');
                            });
                            jQuery('.save-page-<?php echo $page->ID; ?>').click(function() {
                                var cus_version_<?php echo $page->ID; ?> = jQuery('.cus_version_<?php echo $page->ID; ?>').val();
                                var form_key_<?php echo $page->ID; ?> = jQuery('.form_key_<?php echo $page->ID; ?>').val();
                                jQuery.changePageSettings(<?php echo $page->ID; ?>, cus_version_<?php echo $page->ID; ?>, form_key_<?php echo $page->ID; ?>);

                            });
                        </script>
                        <?php
                        $cus_version = '';
                        $form_page_key = '';
                    } //endforeach; 
                } //END IF ALLOWED WOO SLUGS
                ?>
            </ul>

        <?php } //endif;  ?>
    </div>
    <input type="hidden" name="cus_version" value="selectable" />
    <input type="hidden" value="settings" name="option" />
</form>