function setupAjaxForm(form_id, form_action){
        var form = "#" + form_id;
        var form_message = form + '-message';
        console.log(form_action);
        console.log(form_id);

        // en/disable submit button
        var disableSubmit = function(val){
        jQuery(form + ' input[type=submit]').attr('disabled', val);
        };
    
        // setup loading message
        jQuery(form).ajaxSend(function(){
             if (!jQuery(form_message).hasClass("alert-success")) {
                  jQuery(form_message).removeClass('alert alert-danger').addClass('ajaxspinner').html('<img src="wp/wp-content/plugins/pikuseru-forms/images/spinner.gif" border="0">').fadeIn();
              }
        });
        
        // setup jQuery Plugin 'ajaxForm'       
        var options = {
                data: {action: 'ACTION', formaction: form_action},
                dataType:  'json',
                type: 'POST',
                url: URLS.ajaxurl,
                
                beforeSubmit: function(){
                        disableSubmit(true);
                },
                success: function(json){
                        jQuery(form_message).addClass('alert alert-'+json.type).html(json.message).fadeIn('slow');
                        disableSubmit(false);
                        if(form_action == 'form1' && json.type == 'success'){
                            jQuery(form).fadeOut('fast');
                        }else if (form_action == 'form2' && json.type == 'success'){
                            jQuery(form)[0].reset();
                        }
                                

                }
        };
        jQuery(form).ajaxForm(options); 

}

jQuery(document).ready(function() {
    var form_id;
    var form_action;
    jQuery(".accordion-toggle").click(function() {
    form_id = jQuery(this).data('formid');  
    form_action = 'form1';
    new setupAjaxForm(form_id, form_action);
    });
    jQuery("#submit-contactform").click(function() {
    form_id = jQuery('#pikuseru-form-2').attr('id');
    form_action = 'form2';
    console.log(form_id, form_action);
    new setupAjaxForm(form_id, form_action);
    });
});


//remove zipcode/bot spam field
jQuery(document).ready(function() {
    jQuery("input").remove("#zip_code");
  });
