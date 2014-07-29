function setupAjaxForm(form_id, form_action){
        var form = "#" + form_id;
        var form_message = form + '-message';

        // en/disable submit button so the user can't resubmit the form while it is loading.
        var disableSubmit = function(val){
        jQuery(form + ' input[type=submit]').attr('disabled', val);
        };
    
        // setup loading message
       /* jQuery(form).ajaxSend(function(){
             if (!jQuery(form_message).hasClass("alert-success")) {
                  jQuery(form_message).removeClass('alert alert-danger').addClass('ajaxspinner').html('<img src="/wp/wp-content/plugins/pikuseru-forms/images/spinner.gif" border="0">').hide().fadeIn();
              }
        });*/
        
        // setup jQuery Plugin 'ajaxForm'       
        var options = {
                data: {action: 'ACTION', formaction: form_action},
                dataType:  'json',
                type: 'POST',
                url: URLS.ajaxurl,
                
                beforeSubmit: function(){
                        jQuery(form_message).removeClass('alert alert-danger').addClass('ajaxspinner', 'text-center', 'giant-cow').html('<img src="'+URLS.plugins_url+'/pikuseru-forms/images/spinner_small.gif" border="0">').hide().fadeIn();
                        disableSubmit(true);
                },
                success: function(json){

                        jQuery(form_message).hide();
                        jQuery(form_message).addClass(json.type, "work").html(json.message).removeClass('ajaxspinner').fadeIn('slow');
                        disableSubmit(false);

                         if(json.type == 'success'){
                            jQuery(form).fadeOut('fast');
                        }
                        
                        

                }
        };
        jQuery(form).ajaxForm(options); 

}

jQuery(document).ready(function() {
    var form_id;
    var form_action;
    jQuery("#submit-contactform-1").click(function() {
    form_id = jQuery('#pikuseru-form-1').attr('id');
    form_action = 'form1';
    /*console.log(form_id, form_action);*/
    new setupAjaxForm(form_id, form_action);
    });
    jQuery("#submit-contactform-2").click(function() {
    form_id = jQuery('#pikuseru-form-2').attr('id');
    form_action = 'form2';
    new setupAjaxForm(form_id, form_action);
    });
});


//remove zipcode/bot spam field
jQuery(document).ready(function() {
    jQuery("input").remove("#zip_code");
  });
