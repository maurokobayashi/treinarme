<?php

if( isset( $_REQUEST['field_email'] ) ) {

    // EDIT THE LINES BELOW AS REQUIRED
    $email_to = 'example@example.com'; // email where the contact form messages will be sent
    $success_msg = '<p class="alert-message success" style="display: none;"><i class="ico fa fa-check-circle"></i><strong>Message sent successfully!</strong></p>';

    function died( $error ) {
        echo '<p class="alert-message warning phpvalidation" style="display: none;"><i class="ico fa fa-exclamation-circle"></i>' . $error . '</p>';
        die();
    }

    // validation expected data exists
    if( !isset( $_REQUEST['field_name'] ) ||
        !isset( $_REQUEST['field_email'] ) ||
        !isset( $_REQUEST['field_message'] ) ) {
        died( '<strong>Fields with (*) are required!</strong>' );
    }
	// honeypot
	if ( isset( $_REQUEST['field_email_hp'] ) && $_REQUEST['field_email_hp'] !== '' ) {
		died( 'Leave the field after the email field blank please.' );
	}

    $field_name = $_REQUEST['field_name']; // required
    $field_email = $_REQUEST['field_email']; // required

    if ( isset( $_REQUEST['field_phone'] ) ) {
        $field_phone = $_REQUEST['field_phone']; // not required
    }

    if ( isset( $_REQUEST['field_subject'] ) && strlen( $_REQUEST['field_subject'] ) > 0 ) {
        $field_subject = $_REQUEST['field_subject']; // not required
    }
    else {
        $field_subject = 'Contact form message'; // change this alternative subject
    }

    $field_message = $_REQUEST['field_message']; // required

    $error_message = '';

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if ( !preg_match( $email_exp, $field_email ) ) {
        $error_message .= '<br>The Email Address you entered does not appear to be valid.';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";
    if ( !preg_match( $string_exp, $field_name ) ) {
        $error_message .= '<br>The First Name you entered does not appear to be valid.';
    }

    if ( strlen( $field_message ) < 2 ) {
        $error_message .= '<br>The Comments you entered do not appear to be valid.';
    }

    if ( strlen( $error_message ) > 0 ) {
        died( $error_message );
    }

    function clean_string( $string ) {
        $bad = array( 'content-type', 'bcc:', 'to:', 'cc:', 'href' );
        return str_replace( $bad, '', $string );
    }

    $email_message = 'Form details below.' . "\n\n";
    $email_message .= 'Name: ' . clean_string( $field_name ) . "\n";
    $email_message .= 'Email: ' . clean_string( $field_email ) . "\n";
    if ( isset( $field_phone ) ) {
        $email_message .= 'Phone: ' . clean_string( $field_phone ) . "\n";
    }
    $email_message .= "\n" . clean_string( $field_message ) . "\n";

    $headers = 'From: ' . $field_email . "\r\n".
    'Reply-To: ' . $field_email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    @mail($email_to, $field_subject, $email_message, $headers);

    echo $success_msg;

}

?>