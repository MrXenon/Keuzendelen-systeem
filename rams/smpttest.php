<?php
/*
      * Template name: smtptest
      */

if (current_user_can('administrator')) {
    get_header();
    $to = 'support@samsite.nl';
    $subject = 'Test';
    $message = 'The message';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $attachments= [];
    wp_mail($to,  $subject,  $message, $headers, $attachments);
}
