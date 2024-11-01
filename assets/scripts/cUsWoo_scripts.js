
//PLUGIN cUsWoo_myjq ENVIROMENT (cUsWoo_myjq)
var cUsWoo_myjq = jQuery.noConflict();

cUsWoo_myjq(window).error(function(e){
    e.preventDefault();
});

//ON READY DOM LOADED
cUsWoo_myjq(document).ready(function($) {
    
    try{
        
        //LOADING UI BOX
        cUsWoo_myjq( ".cUsWoo_preloadbox" ).delay(1500).fadeOut();
        
        //UI TABS
        cUsWoo_myjq( "#cUsWoo_tabs" ).tabs({active: false});
        
        //UI TABS
        var formplacementTabs = cUsWoo_myjq( "#formplacement-tabs" ).tabs({active: false});
        
        //GO TO SHORTCODES TABS LINK
        cUsWoo_myjq( ".goto_shortcodes" ).click(function(){
            cUsWoo_myjq( "#cUsWoo_tabs" ).tabs({ active: 2 });
        });
        
        //UNBIND UI TABS LINK ON CLICK
        cUsWoo_myjq("li.gotohelp a").unbind('click');
        
        //FORMS AND TABS TEMPLATE SELECTION SLIDER
        cUsWoo_myjq('.selectable_cf, .selectable_tabs_cf').bxSlider({
            slideWidth: 160,
            minSlides: 4,
            maxSlides: 4,
            moveSlides:1,
            infiniteLoop:false,
            //captions:true,
            pager:true,
            slideMargin: 5
        });
        
        //PAGES FORM SELECTION SLIDER
        cUsWoo_myjq('.template_slider').bxSlider({
            slideWidth: 160,
            minSlides: 4,
            maxSlides: 4,
            moveSlides:1,
            infiniteLoop:false,
            preloadImages:'all',    
            //captions:true,
            pager:true,
            slideMargin: 5
        });
        
        //colorbox window
        cUsWoo_myjq(".tooltip_formsett").colorbox({iframe:true, innerWidth:'75%', innerHeight:'80%'});   
        
        //TEMPLATE SELECTION
        cUsWoo_myjq( '.options' ).buttonset();
        cUsWoo_myjq( '.form_types' ).buttonset();
        cUsWoo_myjq( '#inlineradio' ).buttonset();
        
        cUsWoo_myjq( '.bx-loading' ).hide(); //DOM BUG FIX
        
        //SELECTED CONTACT FORM TEMPLATE
        cUsWoo_myjq(".selectable_cf, .selectable_news").selectable({
            selected: function(event, ui) {
                var idEl = cUsWoo_myjq(ui.selected).attr('id');
                cUsWoo_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsWoo_myjq('#Template_Desktop_Form').val(idEl);           
            }                   
        });
        
        //SELECTED FORM TAB TEMPLATE
        cUsWoo_myjq(".selectable_tabs_cf, .selectable_tabs_news").selectable({
            selected: function(event, ui) {
                var idEl = cUsWoo_myjq(ui.selected).attr('id');
                cUsWoo_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsWoo_myjq('#Template_Desktop_Tab').val(idEl);           
            }                   
        });
        
        //SELECTED CONTACT FORM TEMPLATE
        cUsWoo_myjq(".selectable_ucf, .selectable_unews").selectable({
            selected: function(event, ui) {
                var idEl = cUsWoo_myjq(ui.selected).attr('id');
                cUsWoo_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsWoo_myjq('#uTemplate_Desktop_Form').val(idEl);           
            }                   
        });
        
        //SELECTED FORM TAB TEMPLATE
        cUsWoo_myjq(".selectable_tabs_ucf, .selectable_tabs_unews").selectable({
            selected: function(event, ui) {
                var idEl = cUsWoo_myjq(ui.selected).attr('id');
                cUsWoo_myjq(ui.selected).addClass("ui-selected").siblings().removeClass("ui-selected");           
                cUsWoo_myjq('#uTemplate_Desktop_Tab').val(idEl);           
            }                   
        });

        //UI ACCORDIONS
        cUsWoo_myjq( "#terminology" ).accordion({
            collapsible: true,
            heightStyle: "content",
            active: false,
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
        
        cUsWoo_myjq( "#user_forms" ).accordion({
            collapsible: true,
            heightStyle: "content",
            active: true,
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsWoo_myjq( ".user_templates" ).accordion({
            collapsible: true,
            active: false,
            heightStyle: "content",
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsWoo_myjq( "#form_examples, #tab_examples" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
        
        cUsWoo_myjq( ".form_templates_aCc" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-circle-plus", "activeHeader": "ui-icon-circle-minus" }
        });
        
        cUsWoo_myjq( ".signup_templates" ).accordion({
            collapsible: true,
            heightStyle: "content",
            icons: { "header": "ui-icon-info", "activeHeader": "ui-icon-arrowreturnthick-1-n" }
        });
       
    }catch(err){
        cUsWoo_myjq('.advice_notice').html('Error - please update your version of WordPress to the latest version. If the problem continues, contact us at support@contactus.com.: ' + err ).slideToggle().delay(2000).fadeOut(2000);
    }
    
    //TOOLTIPS
    try{
        //JQ UI TOOLTIPS
        cUsWoo_myjq(".setLabels").tooltip();
    }catch(err){
        cUsWoo_myjq('.advice_notice').html('Error - please update your version of WordPress to the latest version. If the problem continues, contact us at support@contactus.com. ' + err ).slideToggle().delay(2000).fadeOut(2000);
    }
    
    try{
        cUsWoo_myjq('.setDefaulFormKey').change(function(){
            var sRadio = cUsWoo_myjq(this);
            var form_key = cUsWoo_myjq(this).val();
            cUsWoo_myjq('.loadingMessage.def').show();
            cUsWoo_myjq('.defaultF li .setLabel').html('<span class="ui-button-text">Set as Default</span>');
            //AJAX POST CALL setDefaulFormKey
            cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_setDefaulFormKey',formKey:form_key},
                success: function(data) {

                    switch(data){
                        //SAVED
                        case '1':
                            
                            message = '<p>Form Key saved succesfuly . . . .</p>';
                            sRadio.next().html('<span class="ui-button-text">Default</span>');
                            break;
                        //API OR CONNECTION ISSUES
                        default:
                            message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                            cUsWoo_myjq('.advice_notice').html(message).show();
                            break;
                    }

                    cUsWoo_myjq('.loadingMessage.def').fadeOut();

                },
                fail: function(){ //AJAX FAIL
                   message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                   cUsWoo_myjq('.advice_notice').html(message).show();
                   cUsWoo_myjq('.loadingMessage.def').fadeOut();
                },
                async: false
            });
            
        });
    }catch(err){
        console.log(err);
    }
    
    
    //LOGIN ALREADY CUS OR OLD CUS USERS
    try{
        cUsWoo_myjq('.cUsWoo_LoginUser').click(function(e){
            
            e.preventDefault();
            
            var email = cUsWoo_myjq('#login_email').val();
            var pass = cUsWoo_myjq('#user_pass').val();
            cUsWoo_myjq('.loadingMessage').show();

            //LENGTH VALIDATIONS
            if(!email.length){
                cUsWoo_myjq('.advice_notice').html('User Email is a required and valid field').slideToggle().delay(2000).fadeOut(2000);
                cUsWoo_myjq('#login_email').focus();
                cUsWoo_myjq('.loadingMessage').fadeOut();
            }else if(!pass.length){
                cUsWoo_myjq('.advice_notice').html('User password is a required field').slideToggle().delay(2000).fadeOut(2000);
                cUsWoo_myjq('#user_pass').focus();
                cUsWoo_myjq('.loadingMessage').fadeOut();
            }else{
                var bValid = checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. sergio@cUsWoo_myjq.com" );  
                if(!bValid){ //EMAIL VALIDATION
                    cUsWoo_myjq('.advice_notice').html('Please enter a valid User Email').slideToggle().delay(2000).fadeOut(2000);
                    cUsWoo_myjq('.loadingMessage').fadeOut();
                }else{

                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Loading . . .').attr('disabled', true);

                    //AJAX POST CALL
                    cUsWoo_myjq.ajax({ type: "POST", dataType:'json', url: ajax_object.ajax_url, data: {action:'cUsWoo_loginAlreadyUser',email:email,pass:pass},
                        success: function(data) {

                            switch(data.status){

                                //USER CRATED SUCCESS
                                case 1:

                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Success . . .');

                                    message = '<p>Welcome to ContactUs.com</p>';

                                    setTimeout(function(){
                                        cUsWoo_myjq('#cUsWoo_loginform').slideUp().fadeOut();
                                        location.reload();
                                    },2500);

                                    cUsWoo_myjq('.notice').html(message).show().delay(3000).fadeOut();
                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false);
                                    cUsWoo_myjq('.advice_notice').fadeOut();

                                break;

                                //OLD USER DON'T HAVE DEFAULT CONTACT FORM
                                case 2:

                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Error . . .');

                                    message = '<p>To continue, you will need to create a default contact form.</p>';
                                    message += '<p> This takes just a few minutes by logging in to your ContactUs.com admin panel with the credentials you used to setup the plugin. '; 
                                    message += '<a href="https://admin.contactus.com/partners/index.php?loginName='+data.cUs_API_Account;
                                    message += '&userPsswd='+data.cUs_API_Key+'&confirmed=1&redir_url='+data.deep_link_view+'?';
                                    message += encodeURIComponent('pageID=81&id=0&do=addnew&formType=contact_us');
                                    message += ' " target="_blank">Click here to continue</a></p>';
                                    message += '<p>you will be redirected to our admin login page.</p>';

                                    cUsWoo_myjq.messageDialogLogin('Default Contact Form Required');

                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false);
                                    
                                    cUsWoo_myjq('#dialog-message').html(message);


                                break;

                                //API ERROR OR CONECTION ISSUES
                                case 3:
                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false);
                                    message = '<p>Unfortunately, we weren’t able to log you into your ContactUs.com account.</p>';
                                    message += '<p>Please try again with the email address and password used when you created a ContactUs.com account. If you still aren’t able to log in, please submit a ticket to our support team at <a href="http://help.contactus.com" target="_blank">http://help.contactus.com.</a></p>';
                                    message += '<p>Error:  <b>' + data.message + '</b></p>';
                                    cUsWoo_myjq('.advice_notice').html(message).show();
                                break;

                                //API ERROR OR CONECTION ISSUES
                                case '':
                                default:
                                    cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false);
                                    message = '<p>Unfortunately, we weren’t able to log you into your ContactUs.com account.</p>';
                                    message += '<p>Please try again with the email address and password used when you created a ContactUs.com account. If you still aren’t able to log in, please submit a ticket to our support team at <a href="http://help.contactus.com" target="_blank">http://help.contactus.com.</a></p>';
                                    message += '<p>Error:  <b>' + data.message + '</b></p>';
                                    cUsWoo_myjq('.advice_notice').html(message).show();
                                    break;
                            }

                            cUsWoo_myjq('.loadingMessage').fadeOut();


                        },
                        fail: function(){ //AJAX FAIL
                           message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                           cUsWoo_myjq('.advice_notice').html(message).show();
                           cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false); 
                        },
                        async: false
                    });
                }
            }
        });
    
    }catch(err){
        message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
        cUsWoo_myjq('.advice_notice').html(message).show();
        cUsWoo_myjq('.cUsWoo_LoginUser').val('Login').attr('disabled', false); 
    };
    
    //jQ UI ALERTS & MESSAGE DIALOGS
    cUsWoo_myjq.messageDialogLogin = function(title){
        try{
            cUsWoo_myjq( "#dialog-message" ).dialog({
                modal: true,
                title: title,
                minWidth: 520,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }catch(err){
            //console.log(err);
        }
    };
    
    //JUI CUSTOM ALERTS AND MESSAGE DIALOGS
    cUsWoo_myjq.messageDialog = function(title, msg){
        try{
            cUsWoo_myjq( "#dialog-message" ).html(msg);
            cUsWoo_myjq( "#dialog-message" ).dialog({
                modal: true,
                title: title,
                minWidth: 520,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }catch(err){
            //console.log(err);
        }
    };
    
    
    //SENT LIST ID AJAX CALL /// STEP 2
    try{
        cUsWoo_myjq('#cUsWoo_CreateCustomer').click(function(e) {
            
            e.preventDefault();
            
            var postData = {};
            
            //GET ALL FORM FIELDS DATA
            var cUsWoo_first_name = cUsWoo_myjq('#cUsWoo_first_name').val();
            var cUsWoo_last_name = cUsWoo_myjq('#cUsWoo_last_name').val();
            var cUsWoo_email = cUsWoo_myjq('#cUsWoo_email').val();
            var cUsWoo_phone = cUsWoo_myjq('#cUsWoo_phone').val();
            //EMAIL VALIDATION FUNCTION
            var cUsWoo_emailValid = checkRegexp( cUsWoo_email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. sergio@cUsWoo_myjq.com" );
            var cUsWoo_pass = cUsWoo_myjq('#cUsWoo_password').val();
            var cUsWoo_pass2 = cUsWoo_myjq('#cUsWoo_password_r').val();
            var cUsWoo_web = cUsWoo_myjq('#cUsWoo_web').val();
            //URL VALIDATION FUNCTION
            var cUsWoo_webValid = checkURL(cUsWoo_web);
            
           cUsWoo_myjq('.loadingMessage').show();
           
           //lenght validations
           if( !cUsWoo_first_name.length){
               cUsWoo_myjq('.advice_notice').html('Your First Name is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_first_name').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if( !cUsWoo_last_name.length){
               cUsWoo_myjq('.advice_notice').html('Your Last Name is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_last_name').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(!cUsWoo_email.length){
               cUsWoo_myjq('.advice_notice').html('Email is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#apikey').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(!cUsWoo_pass.length){
               cUsWoo_myjq('.advice_notice').html('Password is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_password').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(cUsWoo_pass.length < 8){ //PASSWORD 8 CHARS VALIDATION
               cUsWoo_myjq('.advice_notice').html('Password must be 8 characters or more').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_password').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(cUsWoo_pass2 != cUsWoo_pass){
               cUsWoo_myjq('.advice_notice').html('Confirm Password not match').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_password_r').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(!cUsWoo_emailValid){
               cUsWoo_myjq('.advice_notice').html('Please, enter a valid Email').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_email').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(!cUsWoo_web.length){
               cUsWoo_myjq('.advice_notice').html('Your Website is a required field').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_web').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else if(!cUsWoo_webValid){
               cUsWoo_myjq('.advice_notice').html('Please, enter one valid website URL').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('#cUsWoo_web').focus();
               cUsWoo_myjq('.loadingMessage').fadeOut();
           }else{
                cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Loading . . .').attr('disabled', true);
                
                postData = {action: 'cUsWoo_verifyCustomerEmail', fName:str_clean(cUsWoo_first_name),lName:str_clean(cUsWoo_last_name),Email:cUsWoo_email,Phone:cUsWoo_phone,credential:cUsWoo_pass,website:cUsWoo_web};
                
                //AJAX POST CALL
                cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: postData,
                    success: function(data) {
                        switch(data){
                            
                            //NO USER, CONTINUE WITH NEXT STEP
                            case '1':
                                message = '<h4>Continue with Form Design Selection . . .</h4>';
                                
                                setTimeout(function(){
                                    cUsWoo_myjq('.step1').slideDown().fadeOut();
                                    cUsWoo_myjq('.step2').slideUp().fadeIn();
                                },1800);
                                
                                cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Next >>').attr('disabled', false);
                                cUsWoo_myjq('.notice').html(message).show().delay(8000).fadeOut(2000);
                                
                            break;
                            
                            //OLD USER, LOGIN
                            case '2':
                                message = 'Seems like you already have one Contactus.com Account, Please Login below';
                                cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Next >>').attr('disabled', false); 
                                setTimeout(function(){
                                    cUsWoo_myjq('#login_email').val(cUsWoo_email).focus();
                                    cUsWoo_myjq('#cUsWoo_userdata').fadeOut();
                                    cUsWoo_myjq('#cUsWoo_settings').slideDown('slow');
                                    cUsWoo_myjq('#cUsWoo_loginform').delay(1000).fadeIn();
                                },2000);
                                cUsWoo_myjq('.advice_notice').html(message).show().delay(8000).fadeOut(2000);
                            break; 
                        
                            //API OR CONNECTION ISSUES
                            case '':
                            default:
                                message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com. <br/>Error: <b>' + data + '</b>.</a></p>';
                                cUsWoo_myjq('.advice_notice').html(message).show();
                                cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Next >>').attr('disabled', false);
                            break;
                        }
                        
                        cUsWoo_myjq('.loadingMessage').fadeOut();
                        

                    },
                    fail: function(){ //AJAX FAIL
                       message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                       cUsWoo_myjq('.advice_notice').html(message).show();
                       cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Next >>').attr('disabled', false); 
                    }
                });
           }
           
            
        });
    }catch(err){ //JS ISSUES
        cUsWoo_myjq('.advice_notice').html('Unfortunately there has being an error during the application. ' + err).slideToggle().delay(2000).fadeOut(2000);
        cUsWoo_myjq('#cUsWoo_CreateCustomer').val('Next >>').attr('disabled', false);
    }
    
    //cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox({inline:true, maxWidth:'100%', minHeight:'425px', scrolling:false });
    
    cUsWoo_myjq("#cUsWoo_SendTemplates").on('click', function(e) {
           
        e.preventDefault();
        
        var Template_Desktop_Form = cUsWoo_myjq('#Template_Desktop_Form').val();
        var Template_Desktop_Tab = cUsWoo_myjq('#Template_Desktop_Tab').val();

        if (!Template_Desktop_Form.length) {
            cUsWoo_myjq('.advice_notice').html('Please select a form template before continuing.').slideToggle().delay(2000).fadeOut(2000);
            cUsWoo_myjq('.loadingMessage').fadeOut();
            cUsWoo_myjq(".signup_templates").accordion({active: 0});
        } else if (!Template_Desktop_Tab.length) {
            cUsWoo_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
            cUsWoo_myjq('.loadingMessage').fadeOut();
            cUsWoo_myjq(".signup_templates").accordion({active: 1});
        } else {
            cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox({escKey:false,overlayClose:false,closeButton:false, inline: true, maxWidth: '100%', minHeight: '430px', scrolling: false});
        }

    });
    
    //SIGNUP TEMPLATE SELECTION
    try{ cUsWoo_myjq('.btn-skip').click(function(e) {
           
           e.preventDefault();
           var oThis = cUsWoo_myjq(this);
           oThis.hide();
           cUsWoo_myjq('#open-intestes').hide();
           
           //GET SELECTED TEMPLATES
           var Template_Desktop_Form = cUsWoo_myjq('#Template_Desktop_Form').val();
           var Template_Desktop_Tab = cUsWoo_myjq('#Template_Desktop_Tab').val();
           // this are optional so do not passcheck
           var CU_category 	= cUsWoo_myjq('#CU_category').val();
           var CU_subcategory 	= cUsWoo_myjq('#CU_subcategory').val();
           
            var new_goals = '';
            var CU_goals = cUsWoo_myjq('input[name="the_goals[]"]').each(function(){
                    new_goals += cUsWoo_myjq(this).val()+',';	
            });

            if( cUsWoo_myjq('#other_goal').val() )
                    new_goals += cUsWoo_myjq('#other_goal').val()+',';
           
           cUsWoo_myjq(".img_loader").show();
           cUsWoo_myjq('.loadingMessage').show();
           
           //VALIDATION
           if(!Template_Desktop_Form.length){
               cUsWoo_myjq('.advice_notice').html('Please select a form template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('.loadingMessage').fadeOut();
               cUsWoo_myjq( ".signup_templates" ).accordion({ active: 0 });
           }else if(!Template_Desktop_Tab.length){
               cUsWoo_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('.loadingMessage').fadeOut();
               cUsWoo_myjq( ".signup_templates" ).accordion({ active: 1 });
           }else{
                
                cUsWoo_myjq('#cUsWoo_SendTemplates').val('Loading . . .').attr('disabled', true);
                oThis.attr('disabled', true);
                
                //AJAX POST CALL cUsWoo_createCustomer
                cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_createCustomer',Template_Desktop_Form:Template_Desktop_Form,Template_Desktop_Tab:Template_Desktop_Tab,CU_category:CU_category,CU_subcategory:CU_subcategory,CU_goals:new_goals },
                    success: function(data) {

                        switch(data){
                            
                            //USER CREATED
                            case '1':
                                message = '<p>Template saved succesfuly . . . .</p>';
                                message += '<p>Welcome to ContactUs.com, and thank you for your registration.</p>';
                                cUsWoo_myjq('.notice').html(message).show().delay(4900).fadeOut(800);
                                
                                setTimeout(function(){
                                    cUsWoo_myjq('.step3').slideUp().fadeOut();
                                    cUsWoo_myjq('.step4').slideDown().delay(800);
                                    cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false);
                                    cUsWoo_myjq("#cUsFC_SendTemplates").colorbox.close();
                                    location.reload();
                                },2000);
                                break;
                             //OLD USER - LOGING
                             case '2':
                                message = 'Seems like you already have one Contactus.com Account, Please Login below';
                                cUsWoo_myjq('.advice_notice').html(message).show();
                                cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false);
                                cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox.close();
                                cUsWoo_myjq(".img_loader").hide();
                                setTimeout(function(){
                                    cUsWoo_myjq('#login_email').val(cUsWoo_email).focus();
                                    cUsWoo_myjq('#cUsWoo_userdata').fadeOut();
                                    cUsWoo_myjq('#cUsWoo_settings').slideDown('slow');
                                    cUsWoo_myjq('#cUsWoo_loginform').delay(1000).fadeIn();
                                },2000);
                                break;
                            //API OR CONNECTION ISSUES
                            case '':
                            default:
                                message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com. <br/>Error: <b>' + data + '</b>.</a></p>';
                                cUsWoo_myjq('.advice_notice').html(message).show();
                                cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false);
                                cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox.close();
                                break;
                        }
                        
                        cUsWoo_myjq('.loadingMessage').fadeOut();

                    },
                    fail: function(){ //AJAX FAIL
                       message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                       cUsWoo_myjq('.advice_notice').html(message).show();
                       cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false);
                       cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox.close();
                    },
                    error: function(request, status, error){ //AJAX ERROR
                       message = '<p>Unfortunately there has being an error during the application. If the problem continues, contact us at support@contactus.com.</a></p>';
                       message += '<p>ERROR: ' + request.responseText + '</p>';
                       cUsWoo_myjq('.advice_notice').html(message).show();
                       cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false);
                       cUsWoo_myjq("#cUsWoo_SendTemplates").colorbox.close();
                    },
                    async: false
                });
           }
           
            
        });
    }catch(err){
        cUsWoo_myjq('.advice_notice').html('Unfortunately there has being an error during the application. ' + err).slideToggle().delay(9000).fadeOut(2000);
        cUsWoo_myjq('#cUsWoo_SendTemplates').val('Create my account').attr('disabled', false); 
    }
    
    //UPDATE TEMPLATES FOR ALREADY USERS
    try{ cUsWoo_myjq('#cUsWoo_UpdateTemplates').click(function() {
           
           //GET SELECTED TEMPLATES
           var Template_Desktop_Form = cUsWoo_myjq('#uTemplate_Desktop_Form').val();
           var Template_Desktop_Tab = cUsWoo_myjq('#uTemplate_Desktop_Tab').val();
           cUsWoo_myjq('.loadingMessage').show();
           
           //VALIDATION
           if(!Template_Desktop_Form.length){
               cUsWoo_myjq('.advice_notice').html('Please select a form template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('.loadingMessage').fadeOut();
               cUsWoo_myjq( "#form_examples" ).accordion({ active: 0 });
           }else if(!Template_Desktop_Tab.length){
               cUsWoo_myjq('.advice_notice').html('Please select a tab template before continuing.').slideToggle().delay(2000).fadeOut(2000);
               cUsWoo_myjq('.loadingMessage').fadeOut();
               cUsWoo_myjq( "#form_examples" ).accordion({ active: 1 });
           }else{
                
                cUsWoo_myjq('#cUsWoo_UpdateTemplates').val('Loading . . .').attr('disabled', true);
                
                //AJAX POST CALL cUsWoo_UpdateTemplates
                cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_UpdateTemplates',Template_Desktop_Form:Template_Desktop_Form,Template_Desktop_Tab:Template_Desktop_Tab},
                    success: function(data) {

                        switch(data){
                            //SAVED
                            case '1':
                                message = '<p>Template saved succesfuly . . . .</p>';
                                cUsWoo_myjq('.notice').html(message).show();
                                setTimeout(function(){
                                    cUsWoo_myjq('.step3').slideUp().fadeOut();
                                    cUsWoo_myjq('.step4').slideDown().delay(800);
                                    location.reload();
                                },2000);
                                break;
                            //API OR CONNECTION ISSUES
                            default:
                                message = '<p>Unfortunately there has being an error during the application: <b>' + data + '</b>. Please try again</a></p>';
                                cUsWoo_myjq('.advice_notice').html(message).show();
                                cUsWoo_myjq('#cUsWoo_UpdateTemplates').val('Update my template').attr('disabled', false); 
                                break;
                        }
                        
                        cUsWoo_myjq('.loadingMessage').fadeOut();

                    },
                    async: false
                });
           }
           
            
        });
    }catch(err){
        cUsWoo_myjq('.advice_notice').html('Unfortunately there has being an error during the application.  '+ err).slideToggle().delay(2000).fadeOut(2000);
        cUsWoo_myjq('#cUsWoo_UpdateTemplates').val('Update my template').attr('disabled', false); 
    }
    
    //loading default template
    try{ cUsWoo_myjq('.load_def_formkey').click(function() { 
            
        cUsWoo_myjq('.loadingMessage').show();
          
        cUsWoo_myjq('.load_def_formkey').html('Loading . . .');

        cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_LoadDefaultKey'},
            success: function(data) {

                switch(data){
                    case '1':
                        message = '<p>New form Loaded correctly. . . .</p>';
                        cUsWoo_myjq('.load_def_formkey').html('Completed . . .');
                        setTimeout(function(){
                            location.reload();
                        },2000);
                        break;
                }

                cUsWoo_myjq('.loadingMessage').fadeOut();
                cUsWoo_myjq('.advice_notice').html(message).show();
                 

            },
            async: false
        });
           
            
        });
    }catch(err){
        cUsWoo_myjq('.advice_notice').html('Unfortunately there has being an error during the application.  '+ err).slideToggle().delay(2000).fadeOut(2000);
        cUsWoo_myjq('.load_def_formkey').html('Update my template'); 
    }
    
    //JQ FUNCTION - CHANGE PAGE SETTINGS IN PAGE SELECTION
    cUsWoo_myjq.changePageSettings = function(pageID, cus_version, form_key) { 
        
        if(!cus_version.length){
            cUsWoo_myjq('.advice_notice').html('Please select TAB or INLINE').slideToggle().delay(2000).fadeOut(2000);
        }else if(!form_key.length){
            cUsWoo_myjq('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsWoo_myjq('.save_message_'+pageID).show();
            
            //AJAX POST CALL cUsWoo_changePageSettings
            cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_changePageSettings',pageID:pageID,cus_version:cus_version, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsWoo_myjq('.save_message_'+pageID).html(message);
                            cUsWoo_myjq('.save-page-'+pageID).val('Completed . . .');
                            //cUsWoo_myjq('.ui-buttonset label.label-home').removeClass('ui-state-active');
                            cUsWoo_myjq('.ui-buttonset label.label-allpages').removeClass('ui-state-active');
                            setTimeout(function(){
                                cUsWoo_myjq('.save_message_'+pageID).fadeOut();
                                cUsWoo_myjq('.save-page-'+pageID).val('Save');
                                cUsWoo_myjq('.form-templates-'+pageID).slideUp();
                                jQuery('.label-'+pageID).addClass('ui-state-active');
                            },2000);

                            break;
                    }

                },
                async: false
            });
        }  
            
    };
    
    //JQ FUNCTION - REMOVE PAGE SETTINGS IN PAGE SELECTION
    cUsWoo_myjq.deletePageSettings = function(pageID) { 

        cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_deletePageSettings',pageID:pageID},
            success: function(data) {
                //console.log('Success . . .');
            },
            async: false
        });
            
    };
    
    
    //CHANGE FORM TEMPLATES
    cUsWoo_myjq.changeFormTemplate = function(formID, form_key, Template_Desktop_Form) {
        
        if(!Template_Desktop_Form.length || !form_key.length){
            cUsWoo_myjq('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsWoo_myjq('.save_message_'+formID).show();
            
            cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_changeFormTemplate',Template_Desktop_Form:Template_Desktop_Form, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsWoo_myjq('.save_message_'+formID).html(message);
                            cUsWoo_myjq('.form_thumb_'+formID).attr('src','https://admin.contactus.com/popup/tpl/'+Template_Desktop_Form+'/scr.png');

                            setTimeout(function(){
                                cUsWoo_myjq('.save_message_'+formID).fadeOut();
                            },2000);

                            break
                    }

                },
                async: false
            });
        }  
            
    };
    
    //CHANGE FORM TEMPLATES
    cUsWoo_myjq.changeTabTemplate = function(formID, form_key, Template_Desktop_Tab) { //loading default template
        
        
        if(!Template_Desktop_Tab.length || !form_key.length){
            cUsWoo_myjq('.advice_notice').html('Please select your Contact Us Tab Template').slideToggle().delay(2000).fadeOut(2000);
        }else{
            
            cUsWoo_myjq('.save_tab_message_'+formID).show();
            
            cUsWoo_myjq.ajax({type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_changeTabTemplate',Template_Desktop_Tab:Template_Desktop_Tab, form_key:form_key },
                success: function(data) {

                    switch(data){
                        case '1':
                            message = '<p>Saved Successfully . . . .</p>';
                            cUsWoo_myjq('.save_tab_message_'+formID).html(message);
                            cUsWoo_myjq('.tab_thumb_'+formID).attr('src','https://admin.contactus.com/popup/tpl/'+Template_Desktop_Tab+'/scr.png');

                            setTimeout(function(){
                                cUsWoo_myjq('.save_tab_message_'+formID).fadeOut();
                            },2000);

                            break
                    }

                },
                async: false
            });
        }  
            
    };
    
    //UNLINK ACCOUNT AND DELETE PLUGIN OPTIONS AND SETTINGS
    cUsWoo_myjq('.cUsWoo_LogoutUser').click(function(){
        
        cUsWoo_myjq( "#dialog-message" ).html('Please confirm you would like to unlink your account from wordpress.');
        cUsWoo_myjq( "#dialog-message" ).dialog({
            resizable: false,
            width:430,
            title: 'Close your account session?',
            height:180,
            modal: true,
            buttons: {
                "Yes": function() {
                    
                    cUsWoo_myjq('.loadingMessage').show();
                    cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_logoutUser'},
                        success: function(data) {
                            cUsWoo_myjq('.loadingMessage').fadeOut();
                              location.reload();
                        },
                        async: false
                    });
                    
                    cUsWoo_myjq( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    cUsWoo_myjq( this ).dialog( "close" );
                }
            }
        });
        
    });
    
    //FORM PLACEMENT SELECITION / DEFAULT FORM OR CUSTOM SETTINGS
    cUsWoo_myjq('.form_version').click(function(){
        
        var value = cUsWoo_myjq(this).val();
         
        var msg = '';
        switch(value){
            case 'select_version':
                msg = '<p>You are about to change to Custom Form Settings. You need to choose what forms go on each page or home page</p>';
                break;
            case 'tab_version':
                msg = '<p>You are about to change to Default Form Settings, only your Default form will show up in all of your site</p>';
                break;
        }
        
        cUsWoo_myjq( "#dialog-message" ).html(msg);
        cUsWoo_myjq( "#dialog-message" ).dialog({
            resizable: false,
            width:430,
            title: 'Change your Form Settings?',
            height:180,
            modal: true,
            buttons: {
                "Yes": function() {
                    
                    switch(value){
                        case 'select_version':
                            cUsWoo_myjq('.tab_button').addClass('gray').removeClass('green').attr('disabled', false);
                            cUsWoo_myjq('.custom').addClass('green').removeClass('disabled').attr('disabled', true);
                            cUsWoo_myjq('.ui-buttonset input').removeAttr('checked');
                            cUsWoo_myjq('.ui-buttonset label').removeClass('ui-state-active');

                            cUsWoo_myjq('.loadingMessage').show();
                            cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_saveCustomSettings',cus_version:'selectable',tab_user:0},
                                success: function(data) {
                                    cUsWoo_myjq('.loadingMessage').fadeOut();
                                    cUsWoo_myjq('.notice_success').html('<p>Custom settings saved . . .</p>').fadeIn().delay(2000).fadeOut(2000);
                                    //location.reload();
                                },
                                async: false
                            });

                            break;
                        case 'tab_version':
                            cUsWoo_myjq('.custom').addClass('gray').removeClass('green').attr('disabled', false);
                            cUsWoo_myjq('.tab_button').removeClass('gray').addClass('green').attr('disabled', true);

                            cUsWoo_myjq('.loadingMessage').show();
                            cUsWoo_myjq.ajax({ type: "POST", url: ajax_object.ajax_url, data: {action:'cUsWoo_saveCustomSettings',cus_version:'tab',tab_user:1},
                                success: function(data) {
                                    cUsWoo_myjq('.loadingMessage').fadeOut();
                                    cUsWoo_myjq('.notice_success').html('<p>Tab settings saved . . .</p><p>Your default Form will appear in all your website.</p>').fadeIn().delay(5000).fadeOut(2000);
                                    //location.reload();
                                },
                                async: false
                            });

                            break;
                    }

                    cUsWoo_myjq('.cus_versionform').fadeOut();
                    cUsWoo_myjq('.' + value).fadeToggle();
                    
                    cUsWoo_myjq( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    cUsWoo_myjq( this ).dialog( "close" );
                }
            }
        });
        
    });
    
    cUsWoo_myjq('.btab_enabled').click(function(){
        var value = cUsWoo_myjq(this).val();
        cUsWoo_myjq('.tab_user').val(value);
        cUsWoo_myjq('.loadingMessage').show();
       
        setTimeout(function(){
            cUsWoo_myjq('#cUsWoo_button').submit();
        },1500);
        
    });
    
    cUsWoo_myjq('#contactus_settings_page').change(function(){
        cUsWoo_myjq('.show_preview').fadeOut();
        cUsWoo_myjq('.save_page').fadeOut( "highlight" ).fadeIn().val('>> Save your settings');
    });
    
    cUsWoo_myjq('.callout-button').click(function() {
        cUsWoo_myjq('.getting_wpr').slideToggle('slow');
    });
    
    cUsWoo_myjq('#cUsWoo_yes').click(function() {
        cUsWoo_myjq('#cUsWoo_userdata, #cUsWoo_templates').fadeOut();
        cUsWoo_myjq('#cUsWoo_settings').slideDown('slow');
        cUsWoo_myjq('#cUsWoo_loginform').delay(600).fadeIn();
    });
    cUsWoo_myjq('#cUsWoo_no, #cUsWoo_signup_cloud').click(function() {
        cUsWoo_myjq('#cUsWoo_loginform, #cUsWoo_templates').fadeOut();
        cUsWoo_myjq('#cUsWoo_settings').slideDown('slow');
        cUsWoo_myjq('#cUsWoo_userdata').delay(600).fadeIn();
    });
    
    //DOM ISSUES ON LOAD
    cUsWoo_myjq('.form_template, .step2, #cUsWoo_settings').css("display","none");
    
    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o ) ) ) {
            return false;
        } else {
            return true;
        }
    }
    
    function checkURL(url) {
        return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    }
    
    function str_clean(str){
           
        str = str.replace("'" , " ");
        str = str.replace("," , "");
        str = str.replace("\"" , "");
        str = str.replace("/" , "");

        return str;
    }
    
});//ON LOAD