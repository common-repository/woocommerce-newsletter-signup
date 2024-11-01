
//PLUGIN $ ENVIROMENT ($)
var cUsWoo_myjq = jQuery.noConflict();

cUsWoo_myjq(window).error(function(e){
    e.preventDefault();
});

//ON READY DOM LOADED
cUsWoo_myjq(document).ready(function($) {
    
    try{
        
        //FORMS AND TABS TEMPLATE SELECTION SLIDER
        $('.selectable_cf, .selectable_tabs_cf').bxSlider({
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
        $('.template_slider').bxSlider({
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
        
        $( '.bx-loading' ).hide(); //DOM BUG FIX
       
    }catch(err){
        $('.advice_notice').html('Error - please update your version of WordPress to the latest version. If the problem continues, contact us at support@contactus.com.: ' + err ).slideToggle().delay(2000).fadeOut(2000);
    }
    
    try {
        $('.template-prod').click(function() {
            $('.form_key').val($(this).attr('rel'));
            $('.cus_version').val('tab');
            $('.template_slider .item').removeClass('default');
            $(this).addClass('default');
        });
        
        $('.save-prod').click(function(e) {

            e.preventDefault();

            var cus_version = $('.cus_version').val();
            var form_key = $('.form_key').val();
            var prodID = $('.prodID').val();
            
            $.saveProdSettings( prodID , cus_version , form_key );
        });
        
        $('.reset-prod').click(function(e) {

            e.preventDefault();
            
            var prodID = $('.prodID').val();
            
            $.deleteProdSettings( prodID );
        });
        
    } catch (err) {
        console.log(err);
    }
    
    //JQ FUNCTION 
    $.saveProdSettings = function( prodID , cus_version , form_key ) { 
        
        var message = '';
        
        if(!cus_version.length){
            $('.advice_notice').html('Please select TAB or INLINE').slideToggle().delay(2000).fadeOut(2000);
        }else if(!form_key.length){
            $('.advice_notice').html('Please select your Contact Us Form Template').slideToggle().delay(2000).fadeOut(2000);
        }else{

            $('.save_message').show();

            //AJAX POST CALL cUsWoo_changeCatSettings
            $.ajax({type: "POST", url: ajax_object.ajax_url, dataType:'json', data: {action:'cUsWoo_saveProdSettings',prodID:prodID,cus_version:cus_version, form_key:form_key },
                success: function(data) {

                    switch(data.status){
                        case 1:
                            message = '<p>Saved Successfully . . . .</p>';
                            $('.save_message').html(message);
                            $('.save-cat').val('Completed . . .');

                            setTimeout(function(){
                                $('.save_message').fadeOut();
                                $('.save-cat').val('Save');
                                $('.form-templates').slideUp();
                            },2000);

                            break;
                        case 2:
                        case '':
                        default :
                            message = '<p>'+ data.message +'</p>';
                            $('.save_message').html(message);
                            $('.save-cat').val('Error . . .');
                            setTimeout(function(){
                                $('.save_message').fadeOut();
                                $('.save-cat').val('Save');
                            },2000);
                            break;
                    }

                },
                async: false
            });
        }  

    };
    
    //JQ FUNCTION 
    $.deleteProdSettings = function( prodID ) { 

        $('.save_message').show();
        var message = '';

        //AJAX POST CALL cUsWoo_changeCatSettings
        $.ajax({type: "POST", url: ajax_object.ajax_url, dataType:'json', data: {action:'cUsWoo_deleteProdSettings',prodID:prodID },
            success: function(data) {

                switch(data.status){
                    case 1:
                        message = '<p>Clear Form Settings Successfully . . . .</p>';
                        $('.save_message').html(message);
                        $('.save-cat').val('Completed . . .');
                        
                        setTimeout(function(){
                            $('.template_slider .item').removeClass('default');
                            $('.save_message').fadeOut();
                            $('.save-cat').val('Save');
                            $('.form-templates').slideUp();
                        },2000);

                        break;
                    case 2:
                    case '':
                    default :
                        message = '<p>'+ data.message +'</p>';
                        $('.save_message').html(message);
                        $('.save-cat').val('Error . . .');
                        setTimeout(function(){
                            $('.save_message').fadeOut();
                            $('.save-cat').val('Save');
                        },2000);
                        break;
                }

            },
            async: false
        });

    };
    
    
    
});//ON LOAD