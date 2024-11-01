<?php
/**
 * 
 * WOOCOMMERCE FORM BY CONTACTUS.COM
 * 
 * Initialization WooCommerce Categories View
 * @since 1.0 First time this was introduced into WooCommerce Form plugin.
 * @author ContactUs.com <support@contactus.com>
 * @copyright 2014 ContactUs.com Inc.
 * Company      : contactus.com
 * Updated  	: 20140128
 * */
?>
<form method="post" action="admin.php?page=cUsWoo_form_plugin" id="cUsWoo_selectable" class="cus_versionform" name="cUsWoo_categories">
    <h3 class="form_title">Category Selection  <a href="edit-tags.php?taxonomy=product_cat&post_type=product">Create a new Category <span>+</span></a></h3> 
    <div class="pageselect_cont">
        <?php
        /*
         * Get WooCats
         */
        
        $cUsWoo_getCatsArgs = array('hierarchical' => 1,'show_option_none' => '','hide_empty' => 0,'parent' => 0,'taxonomy' => 'product_cat');
	$cUsWoo_Cats = get_categories($cUsWoo_getCatsArgs);

        if (is_array($cUsWoo_Cats) && !empty($cUsWoo_Cats)) {
            
            ?>
            <ul class="selectable_pages">

                <?php
                    $allCatSettings = get_option('cUsWoo_settings_cat_allcats');
                    $allcats_form_key = $allCatSettings['form_key'];
                ?>
                <li class="ui-widget-content"> 
                    <div class="page_title">
                        <span class="title">All Categories</span>
                    </div>

                    <div class="options home">
                        <input type="radio" name="pages[allcats]" class="allcats-page" id="radio-allcats" value="tab" <?php echo (is_array($allCatSettings) && !empty($allCatSettings)) ? 'checked' : '' ?> />
                        <label class="label-allcats setLabels" for="radio-allcats" title="Will show up as a floating tab">Enabled</label>
                        <a class="ui-state-default ui-corner-all clear-allcats setLabels" href="javascript:;" title="Clear Category settings"><label class="ui-icon ui-icon-circle-close">&nbsp;</label></a>
                    </div>

                    <div class="form_template form-templates-allcats">
                        <h4>Pick which form you would like on this page</h4>
                        <div class="template_slider slider-allcats">
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

                                                if (strlen($allcats_form_key) && $allcats_form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else if (!strlen($allcats_form_key) && $form_key == $oForm->form_key) {
                                                    $itemClass = 'default';
                                                } else {
                                                    $itemClass = 'tpl';
                                                }
                                                ?>
                                                <span class="<?php echo $itemClass; ?> item template-allcats" rel="<?php echo $oForm->form_key ?>">
                                                    <img class="tab tab-allcats" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
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
                        <div class="check-options"><hr/>
                            <input type="checkbox" <?php echo (is_array($allCatSettings) && $allCatSettings['allowProds']) ? 'checked' : ''; ?> name="allowprods" class="allowprods-allcats" id="allowprods-allcats"/>
                            <label for="allowprods-allcats">Show this form in all products</label>
                        </div>
                        <div class="save-options">
                            <input type="button" class="btn lightblue save-cat save-cat-allcats" value="Save" />
                        </div>
                        <div class="save_message save_message_allcats">
                            <p>Sending . . .</p>
                        </div>
                    </div>

                    <input type="hidden" class="cus_version_allcats" value="<?php echo $cus_version; ?>" />
                    <input type="hidden" class="form_key_allcats" value="<?php echo (strlen($allcats_form_key)) ? $allcats_form_key : $form_key; ?>" />

                </li><hr />
                <script>



                    /*
                     * ALL CATS JS ACTION
                     */

                    jQuery('.clear-allcats').click(function() {

                        jQuery("#dialog-message").html('Do you want to delete your settings?');
                        jQuery("#dialog-message").dialog({
                            resizable: false,
                            width: 430,
                            title: 'Delete page settings?',
                            height: 130,
                            modal: true,
                            buttons: {
                                "Yes": function() {

                                    jQuery('.allcats-page').removeAttr('checked');
                                    jQuery('.label-allcats').removeClass('ui-state-active');

                                    jQuery('.template-allcats').removeClass('default');

                                    jQuery.deleteCatSettings('allcats');

                                    jQuery(this).dialog("close");

                                },
                                Cancel: function() {
                                    jQuery(this).dialog("close");
                                }
                            }
                        });

                    });


                    jQuery('.allcats-page').click(function() {
                        jQuery('.form_template').fadeOut();
                        jQuery('.form-templates-allcats').slideDown();

                        jQuery('.cus_version_allcats').val(jQuery(this).val());

                    });
                    jQuery('.template-allcats').click(function() {
                        jQuery('.form_key_allcats').val(jQuery(this).attr('rel'));
                        jQuery('.slider-allcats .item').removeClass('default');
                        jQuery(this).addClass('default');
                    });
                    jQuery('.save-cat-allcats').click(function() {
                        var cus_version_allcats = jQuery('.cus_version_allcats').val();
                        var form_key_allcats = jQuery('.form_key_allcats').val();
                        
                        var allowProds_allcats = 0;
                        if(jQuery(".allowprods-allcats").is(':checked')){
                            allowProds_allcats = 1;
                        }

                        jQuery.changeCatSettings('allcats', cus_version_allcats, form_key_allcats, 1, allowProds_allcats);

                    });
                </script>
                
                <?php
                /*
                 * CATEGORY SELECTION
                 * 
                 * Render all main wp pages
                 */

                foreach ($cUsWoo_Cats as $cUsWoo_Cat) {

                    $catSettings = get_option('cUsWoo_settings_cat_'.$cUsWoo_Cat->term_id);
                    ?>
                
                    <li class="ui-widget-content">

                        <div class="page_title">
                            <span class="title"><?php echo $cUsWoo_Cat->name; ?></span>
                            <span class="bullet ui-icon ui-icon-circle-zoomin">
                                <a target="_blank" href="<?php echo get_option( 'home' ); ?>/product-category/<?php echo $cUsWoo_Cat->slug; ?>/" title="Preview <?php echo $cUsWoo_Cat->name; ?> category" class="setLabels">&nbsp;</a>
                            </span>
                        </div>

                        <div class="options">
                            <input type="radio" name="cats[<?php echo $cUsWoo_Cat->term_id; ?>]" value="tab" id="catradio-<?php echo $cUsWoo_Cat->term_id; ?>-1" class="<?php echo $cUsWoo_Cat->term_id; ?>-cat" <?php echo (is_array($catSettings) && $catSettings['tab_user']) ? 'checked' : '' ?> />
                            <label class="setLabels catlabel-<?php echo $cUsWoo_Cat->term_id; ?>" for="catradio-<?php echo $cUsWoo_Cat->term_id; ?>-1" title="Will show up as a floating tab">Enabled</label>
                            <a class="ui-state-default ui-corner-all cateclear-<?php echo $cUsWoo_Cat->term_id; ?> setLabels" href="javascript:;" title="Clear <?php echo $cUsWoo_Cat->name; ?> settings"><label class="ui-icon ui-icon-circle-close">&nbsp;</label></a>
                        </div>

                        <div class="form_template form-templates-<?php echo $cUsWoo_Cat->term_id; ?>">
                            <h4>Pick which Form/Tab combination you would like on <?php echo $cUsWoo_Cat->name; ?> category</h4>
                            <div class="template_slider slider-<?php echo $cUsWoo_Cat->term_id; ?>">
                                <?php
                                /*
                                 * Render Forms
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
                                                    <span class="<?php echo $itemClass; ?> item template-cat-<?php echo $cUsWoo_Cat->term_id; ?>" rel="<?php echo $oForm->form_key ?>">
                                                        <img class="tab tab-<?php echo $cUsWoo_Cat->term_id; ?>" src="<?php echo $oForm->template_desktop_tab_thumbnail; ?>" alt="<?php echo $oForm->form_name ?>" title="Form Name:<?php echo $oForm->form_name ?> - Form Key: <?php echo $oForm->form_key ?>" />
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
                            <div class="check-options"><hr/>
                                <input type="checkbox" <?php echo (is_array($catSettings) && $catSettings['allowSubCats']) ? 'checked' : ''; ?> name="allowsubcats" class="allowsubcats-<?php echo $cUsWoo_Cat->term_id; ?>" id="allowsubcats-<?php echo $cUsWoo_Cat->term_id; ?>" />
                                <label for="allowsubcats-<?php echo $cUsWoo_Cat->term_id; ?>">Show this form in <?php echo $cUsWoo_Cat->name; ?> Sub Categories</label><br/>
                                <input type="checkbox" <?php echo (is_array($catSettings) && $catSettings['allowProds']) ? 'checked' : ''; ?> name="allowprods" class="allowprods-<?php echo $cUsWoo_Cat->term_id; ?>" id="allowprods-<?php echo $cUsWoo_Cat->term_id; ?>"/>
                                <label for="allowprods-<?php echo $cUsWoo_Cat->term_id; ?>">Show this form in <?php echo $cUsWoo_Cat->name; ?> products</label>
                            </div>
                            <div class="save-options">
                                <input type="button" class="btn lightblue save-page save-cat-<?php echo $cUsWoo_Cat->term_id; ?>" value="Save" />
                            </div>
                            <div class="save_message save_message_<?php echo $cUsWoo_Cat->term_id; ?>">
                                <p>Sending . . .</p>
                            </div>
                        </div>

                        <input type="hidden" class="cus_version_<?php echo $cUsWoo_Cat->term_id; ?>" value="<?php echo $cus_version; ?>" />
                        <input type="hidden" class="form_key_<?php echo $cUsWoo_Cat->term_id; ?>" value="<?php echo (strlen($form_page_key)) ? $form_page_key : $form_key; ?>" />

                    </li>
                    <script>

                        /*
                         * ACTIONS BY PAGE ID
                         */

                        jQuery('.cateclear-<?php echo $cUsWoo_Cat->term_id; ?>').click(function(e) {
                            
                            e.preventDefault();
                            
                            jQuery("#dialog-message").html('Do you want to delete your settings in this category?');
                            jQuery("#dialog-message").dialog({
                                resizable: false,
                                width: 430,
                                title: 'Delete category settings?',
                                height: 130,
                                modal: true,
                                buttons: {
                                    "Yes": function() {

                                        jQuery('.<?php echo $cUsWoo_Cat->term_id; ?>-page').removeAttr('checked');
                                        jQuery('.catlabel-<?php echo $cUsWoo_Cat->term_id; ?>').removeClass('ui-state-active');

                                        jQuery('.template-cat-<?php echo $cUsWoo_Cat->term_id; ?>').removeClass('default');

                                        jQuery.deleteCatSettings(<?php echo $cUsWoo_Cat->term_id; ?>);

                                        jQuery(this).dialog("close");

                                    },
                                    Cancel: function() {
                                        jQuery(this).dialog("close");
                                    }
                                }
                            });

                        });
                        jQuery('.<?php echo $cUsWoo_Cat->term_id; ?>-cat').click(function() {
                            jQuery('.form_template').fadeOut();
                            jQuery('.form-templates-<?php echo $cUsWoo_Cat->term_id; ?>').slideDown();

                            jQuery('.cus_version_<?php echo $cUsWoo_Cat->term_id; ?>').val(jQuery(this).val());

                            var version = jQuery(this).val();

                            if (version == 'tab') {
                                jQuery('img.tab-<?php echo $cUsWoo_Cat->term_id; ?>').show();
                            } else {
                                jQuery('img.tab-<?php echo $cUsWoo_Cat->term_id; ?>').hide();
                            }


                        });
                        jQuery('.template-cat-<?php echo $cUsWoo_Cat->term_id; ?>').click(function() {
                            jQuery('.form_key_<?php echo $cUsWoo_Cat->term_id; ?>').val(jQuery(this).attr('rel'));
                            jQuery('.slider-<?php echo $cUsWoo_Cat->term_id; ?> .item').removeClass('default');
                            jQuery(this).addClass('default');
                        });
                        jQuery('.save-cat-<?php echo $cUsWoo_Cat->term_id; ?>').click(function(e) {
                            
                            e.preventDefault();
                            
                            var allowSubCats_<?php echo $cUsWoo_Cat->term_id; ?> = 0;
                            if(jQuery(".allowsubcats-<?php echo $cUsWoo_Cat->term_id; ?>").is(':checked')){
                                allowSubCats_<?php echo $cUsWoo_Cat->term_id; ?> = 1;
                            }
                            
                            var allowProds_<?php echo $cUsWoo_Cat->term_id; ?> = 0;
                            if(jQuery(".allowprods-<?php echo $cUsWoo_Cat->term_id; ?>").is(':checked')){
                                allowProds_<?php echo $cUsWoo_Cat->term_id; ?> = 1;
                            }
                            
                            var cus_version_<?php echo $cUsWoo_Cat->term_id; ?> = jQuery('.cus_version_<?php echo $cUsWoo_Cat->term_id; ?>').val();
                            var form_key_<?php echo $cUsWoo_Cat->term_id; ?> = jQuery('.form_key_<?php echo $cUsWoo_Cat->term_id; ?>').val();
                            jQuery.changeCatSettings(<?php echo $cUsWoo_Cat->term_id; ?>, cus_version_<?php echo $cUsWoo_Cat->term_id; ?>, form_key_<?php echo $cUsWoo_Cat->term_id; ?>, allowSubCats_<?php echo $cUsWoo_Cat->term_id; ?>, allowProds_<?php echo $cUsWoo_Cat->term_id; ?>);

                        });
                    </script>
                    <?php
                    $cus_version = '';
                    $form_page_key = '';
                } //endforeach; 
                ?>
            </ul>

        <?php } //endif;  ?>
    </div>
</form>
<script>
    
    //PLUGIN cUsWoo_myjq ENVIROMENT (cUsWoo_myjq)
    var cUsWoo_myjq = jQuery.noConflict();
    
    //ON READY DOM LOADED
    cUsWoo_myjq(document).ready(function($) {
        
        //JQ FUNCTION - CHANGE PAGE SETTINGS IN PAGE SELECTION
        cUsWoo_myjq.changeCatSettings = function(catID, cus_version, form_key, allowSubCats, allowProds ) { 

            if(!cus_version.length){
                cUsWoo_myjq('.advice_notice').html('Please select TAB or INLINE').slideToggle().delay(2000).fadeOut(2000);
            }else if(!form_key.length){
                cUsWoo_myjq('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
            }else{

                cUsWoo_myjq('.save_message_'+catID).show();

                //AJAX POST CALL cUsWoo_changeCatSettings
                cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, dataType:'json', data: {action:'cUsWoo_changeCatSettings',catID:catID,cus_version:cus_version, form_key:form_key, allowSubCats:allowSubCats, allowProds:allowProds },
                    success: function(data) {

                        switch(data.status){
                            case 1:
                                message = '<p>Saved Successfully . . . .</p>';
                                cUsWoo_myjq('.save_message_'+catID).html(message);
                                cUsWoo_myjq('.save-cat-'+catID).val('Completed . . .');

                                setTimeout(function(){
                                    
                                    if(catID == 'allcats'){
                                       cUsWoo_myjq('.cUsWoo_Categories .ui-buttonset label').removeClass('ui-state-active');
                                       cUsWoo_myjq('.cUsWoo_Categories .ui-buttonset label.label-allcats').addClass('ui-state-active');
                                    }else{
                                       cUsWoo_myjq('.cUsWoo_Categories .ui-buttonset label.label-allcats').removeClass('ui-state-active');
                                    }
                                    
                                    cUsWoo_myjq('.save_message_'+catID).fadeOut();
                                    cUsWoo_myjq('.save-cat-'+catID).val('Save');
                                    cUsWoo_myjq('.form-templates-'+catID).slideUp();
                                },2000);

                                break;
                            case 2:
                            case '':
                            default :
                                message = '<p>'+ data.message +'</p>';
                                cUsWoo_myjq('.save_message_'+catID).html(message);
                                cUsWoo_myjq('.save-cat-'+catID).val('Error . . .');
                                setTimeout(function(){
                                    cUsWoo_myjq('.save_message_'+catID).fadeOut();
                                    cUsWoo_myjq('.save-cat-'+catID).val('Save');
                                },2000);
                                break;
                        }

                    },
                    async: false
                });
            }  

        };
        
        
        //JQ FUNCTION - REMOVE PAGE SETTINGS IN PAGE SELECTION
        cUsWoo_myjq.deleteCatSettings = function(catID) { 

            cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, dataType:'json', data: {action:'cUsWoo_deleteCatSettings',catID:catID},
                success: function(data) {
                    console.log('deleted');
                    switch(data.status){
                            case 1:
                                message = '<p>Saved Successfully . . . .</p>';
                                cUsWoo_myjq('.save_message_'+catID).html(message);
                                cUsWoo_myjq('.form-templates-'+catID).slideUp();
                                break;
                            case 2:
                            case '':
                            default :
                                message = '<p>'+ data.message +'</p>';
                                cUsWoo_myjq('.save_message_'+catID).html(message);
                                cUsWoo_myjq('.save-cat-'+catID).val('Error . . .');
                                cUsWoo_myjq('.form-templates-'+catID).slideUp();
                                break;
                        }
                },
                async: false
            });

        };
        
        
        
    });
        
</script>