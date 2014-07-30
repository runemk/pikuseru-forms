<?php
/*
Plugin Name: Pikuseru Form Plugin
Plugin URI: http://pikuseru.dk/
Description: Pikuseru Form Plugin indsætter forms med shortcoden [pikuseru-form-(id)]. Leverages Advanced Custom plugin. 
Version: 3.2.4
Author: Rune Møller Kjerri
Author URI: http://pikuseru.dk/
License: Copyright 2014 Pikuseru
*/



function pikuseru_form_setup() {

    wp_register_style('pikuseru-forms-style', plugins_url('pikuseru-forms-style.css',__FILE__ ), array('bootstrap'));
    wp_enqueue_style('pikuseru-forms-style');

    wp_register_script( 'pikuseru_form', plugins_url( '/js/pikuseru-form.js', __FILE__ ), array('jquery', 'jquery-form') );
    wp_enqueue_script( 'pikuseru_form',  array('jquery', 'jquery-form'), false, true);
    //the js file uses these localized scripts 
    wp_localize_script(
    'pikuseru_form',
    'URLS',
    array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'site_url' => get_site_url(),
        'theme_directory' => get_template_directory_uri(),
        'plugins_url' => plugins_url()
    ));

}

add_action('wp_enqueue_scripts','pikuseru_form_setup');


 
function my_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_stylesheet_directory_uri() . '/advanced-custom-fields/';
    
    
    // return
    return $dir;
    
}
 
 
add_filter('acf/settings/show_admin', '__return_false');
 


//For IPen fra hvemend der submitter formen. Derved kan der tjekkes for evt. spam
function get_the_ip() {
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        return $_SERVER["REMOTE_ADDR"];
    }
}


//ALL ajax in wordpress MUST be processed through wp ajax actions. The second argument is the .js file to target. 
add_action('wp_ajax_nopriv_ACTION', 'pikuseru_form_ajax');
add_action('wp_ajax_ACTION', 'pikuseru_form_ajax');


function pikuseru_form_ajax() {
//send to mails er et array der indeholder alle de emails hvortil 
/*    $send_to_emails =  get_field('contactform_emails');
    extract(array(
        "error_empty" => 'Udfyld venligst alle felter',
        "error_noemail" => 'Indtast venligst en gyldig e-mailadresse',
        "success" => 'Tak for din henvendelse, vi vil vende tilbage hurtigst muligt!'
    ));

 
        $ajaxresponse = array('type'=>'', 'message'=>'');
        $the_title = $_REQUEST['title'];
        $the_blogname = $_REQUEST['bloginfo'];
        var_dump($_POST);
        if($_POST["formaction"] == 'form2')
        {
            $error = false;
            $required_fields = array("name", "email", "message", "subject");
            foreach ($_POST as $field => $value) {
                if (get_magic_quotes_gpc()) {
                    $value = stripslashes($value);
                }
                $form_data[$field] = strip_tags($value);
            }

            foreach ($required_fields as $required_field) {
                $value = trim($form_data[$required_field]);
                if(empty($value)) {
                    $error = true;
                    $result = $error_empty;
                }
            }

            if(!is_email($form_data['email'])) 
            {
                $error = true;
                $result = $error_noemail;
            }

            if ($error == false) {
                $email_subject = "[" . get_bloginfo('name') . "] " . "Ny besked fra " . $form_data['name'];
                $email_message = $form_data['message'] . "\n\nBesked sendt fra denne ip adresse: " . get_the_ip();
                $headers  = "From: ".$form_data['name']." <".$form_data['email'].">\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\n";
                $headers .= "Content-Transfer-Encoding: 8bit\n";
                wp_mail($send_to_emails, $email_subject, $email_message, $headers);
                $result = $success;
                $sent = true;
                $ajaxresponse['type'] = 'success';
                $ajaxresponse['message'] = $result;
            }elseif ($error == true) {
                $ajaxresponse['type'] = 'danger';
                $ajaxresponse['message'] = $result;
            }else{
                $ajaxresponse['type'] = 'danger';
                $ajaxresponse['message'] = 'Formen blev ikke sendt, prøv venligst igen';
            }

        }

        possible to use $required_fields = array("name", "email", "subject", "message"); to also specifiy topic */
        if($_POST["formaction"] == 'form1')
        {
            $required_fields = array("name", "email", "message");
            try
            {

                foreach ($_POST as $field => $value) 
                {
                    if (get_magic_quotes_gpc()) 
                    {
                        $value = stripslashes($value);
                    }
                    $form_data[$field] = strip_tags($value);
                }
        
                foreach ($required_fields as $required_field)
                {
                    $value = trim($form_data[$required_field]);
                    if(empty($value)) 
                    {
                        throw new Exception("Udfyld venligst Navn, E-mail, og besked");
        
                    }
                }

                if (!is_email($form_data['email']))
                {
                    throw new Exception("Indtast venligst en gyldig e-mailadresse"); 

                }else{

                /*elseif(!preg_match('/^\d{8}$/', $form_data['tlf'])) 
                {
                   throw new Exception("Telefonnummeret skal være 8 cifre langt, og må ikke indeholde tegn eller mellemrum");

                }*/
          /*       elseif(!is_numeric($form_data['cust_number'])) 
                {
                    throw new Exception("Antal deltagere skal angives i tal, og må ikke indeholde tegn eller mellemrum");

                }elseif(isset($form_data['zip_code'])){
                    throw new Exception("Formen blev ikke sendt, prøv venligst igen");

                }*/

                    // 
                    // $email_subject = "[" . get_bloginfo('name') . "] " . "Ny bestilling for " . $the_title;
                    // $email_message .= "Ny bestilling for " . $the_title ."\n";
                    // $email_message .= "Navn: " . $form_data['name'] . "\n";
                    // $email_message .= "Telefonnummer: " . $form_data['tlf'] . "\n";
                    // $email_message .= "E-mail: " . $form_data['email'] . "\n";
                    // $email_message .= "Antal deltagere: " . $form_data['cust_number'] . "\n";
                    // $email_message .= "Kommentarer: " . $form_data['message'] . "\n";
                    // $email_message .= "Denne besked blev sendt fra følgende ip: "  . get_the_ip() . "";
                    // $headers  = "From:" . '"' . $the_blogname . '"' . "<".$form_data['email'].">\r\n";
                    // $headers .= "Content-Type: text/plain; charset=UTF-8\n";
                    // $headers .= "Content-Transfer-Encoding: 8bit\n";
                    // wp_mail($admin_emails, $email_subject, $email_message, $headers);


                    // use ACF to set up the emails to send to in the WP backend for instance use:
                    //get_field('contactform_emails')
                    $send_to = $form_data['email'];
                    $email_subject = "[" . get_bloginfo('name') . "] " . "Ny besked fra " . $form_data['name'];
                    $email_message = $form_data['message'] . "\n\nBesked sendt fra denne ip adresse: " . get_the_ip();
                    $headers  = "From: ".$form_data['name']." <".$form_data['email'].">\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\n";
                    $headers .= "Content-Transfer-Encoding: 8bit\n";
                    wp_mail($admin_emails, $email_subject, $email_message, $headers);
                    $sent = true;
                    if($sent === true){
                    $ajaxresponse['type'] = 'success';
                    $ajaxresponse['message'] = 'Tak for din besked, vi vil kontakte dig hurtigst muligt.';
                    }else{
                        throw new Exception("Besked blev ikke sendt, prøv venligst senere.");
                    }
                }
            }catch(Exception $e) {
                $ajaxresponse['type'] = 'danger';
                $ajaxresponse['message'] = ($e->getMessage());
            }

            print json_encode($ajaxresponse);
            die();
        }
   

    if($_POST["formaction"] == 'form2')
        {
            $required_field = "email";
            try
            {

                foreach ($_POST as $field => $value) 
                {
                    if (get_magic_quotes_gpc()) 
                    {
                        $value = stripslashes($value);
                    }
                    $form2_data[$field] = strip_tags($value);
                }
        
                
                    $value = trim($form2_data[$required_field]);
                    if(empty($value)) 
                    {
                        throw new Exception("Udfyld venligst din email for at modtage voress bog");
        
                    }
                

                if (!is_email($form2_data['email']))
                {
                    throw new Exception("Indtast venligst en gyldig e-mailadresse"); 

                }else{

                    $send_to = $form2_data['email']; /* sending the form to the form entered email */
                    $email_subject = "Din gratis e-bog fra [" . get_bloginfo('name') . "] ";

                    $email_message = "Klik på linket, og indtast følgende kode for at downloade din gratis e-bog!\n"; /*. "\n\nBesked sendt fra denne ip adresse: " . get_the_ip();*/ /* we dont need to send the IP for this */
                    $email_message.= "Kodeord:".get_field('password', 250)." \n";
                    $email_message.= "merefart.testhjemmeside.dk/giveaway/\n";
                    $email_message.= "Bemærk at du ikke kan svare på denne besked.\r\n";
                    //wp filter funktion, ændre fra navnet
                    add_filter( 'wp_mail_from_name', function($name){
                        return 'Merefart.dk';
                    });
                    //wp filter funktion ændre den email mailen bliver sendt fra
                    add_filter( 'wp_mail_from', function($email){
                        return 'giveaway@merefart.testhjemmeside.dk';
                    });
                    //attach logo til mailen 
                    $attachments = array( get_template_directory_uri() . '/img/logo.png');
                    //wp_mail funktion sender mailen, bruger phpmailer
                    wp_mail($send_to, $email_subject, $email_message, $headers, $attachments);
                    //fjerner filterne igen. 
                    remove_filter('wp_mail_from_name', $name);
                    remove_filter('wp_mail_from', $email);
                    $sent = true;
                    if($sent === true){
                    $ajaxresponse['type'] = 'success';
                    $ajaxresponse['message'] = 'Tjek din email! Vi har sendt et download link til din gratis ebog!';
                    }else{
                        throw new Exception("Prøv venligst igen.");
                    }
                }
            }catch(Exception $e) {
                $ajaxresponse['type'] = 'danger';
                $ajaxresponse['message'] = ($e->getMessage());
            }

            print json_encode($ajaxresponse);
            die();

        }
   
}


function pikuseru_form_init() {
     $template = '<form id="pikuseru-form-1"  class="form-inline" role="form" method="post" action="'.get_permalink().'">
                
                <div id="form-col" class="col-md-6">
                <input type="text" name="name" placeholder="Navn" class="form-control"  value="'.$form_data['name'].'">
                </div>

                <div id="form-col" class="col-md-6">
                <input type="email" name="email" placeholder="E-mail" class="form-control" value="'.$form_data['email'].'">
                </div>
             
                <div id="form-col" class="col-md-12">
                <textarea class="form-control" name="message" placeholder="Besked" rows="10">'.$form_data['message'].'</textarea>
                </div>
                <div id="form-col" class="col-md-12">
                <input type="submit" id="submit-contactform-1" class="btn pikuseru-btn-green" name="send-contactform" value="Send besked">
                </div>
                </form>



                ';
    return $template;
}


add_shortcode( 'pikuseru-form-1', 'pikuseru_form_init' );

//returnere en div, og laver det til en shortcode. Derved kan placeringen af response teksten kontrolleres. 
function pikuseru_form_1_response(){
    $template = '<br>
                <div id="pikuseru-form-1-message" class="text-center"></div>
                <br>';
    return $template;
}
add_shortcode( 'pikuseru-form-1-response', 'pikuseru_form_1_response' );



function pikuseru_form_2_response(){
    $template = '
        <br>
        <div id="pikuseru-form-2-message" class="text-center alert">
        </div>
        ';
    return $template;
}
add_shortcode( 'pikuseru-form-2-response', 'pikuseru_form_2_response' );

function pikuseru_form_2_init(){
    $template = '<form id="pikuseru-form-2" class="contact-form" role="form" method="post" action="'.get_permalink().'">
                <div id="form-col" class="col-md-7">
                    <input type="email" name="email" placeholder="E-mail" class="form-control" value="'.$form2_data['email'].'">
                </div>
                <div id="form-col" class="col-md-5">
                    <input type="submit" id="submit-contactform-2" class="btn pikuseru-btn-green" name="send-newsletter" value="Send mig en gratis e-bog!">
                </div>                
                </form>';
    return $template;
}

add_shortcode('pikuseru-form-2', 'pikuseru_form_2_init');
