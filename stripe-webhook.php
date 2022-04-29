<?php
if (!defined('ABSPATH')) {
    exit;
}
if ( ! class_exists( '\Stripe\Stripe' ) ) {
    require_once WPSD_PATH . 'stripe/init.php';
}

function wpsd_stripe_donate_process_webhook(){
    if(!isset($_REQUEST['wps_stripe_donate_webhook']))
    {
        return;
    }
    http_response_code(200);
    $body = @file_get_contents('php://input');
    $event = null;
    $wpsdKeySettings = stripslashes_deep(unserialize(get_option('wpsd_key_settings')));
    $wpsdStripeKey = (isset($wpsdKeySettings['wpsd_secret_key']) ? $wpsdKeySettings['wpsd_secret_key'] : '');
    \Stripe\Stripe::setApiKey(base64_decode($wpsdStripeKey));

    try {
        $event = \Stripe\Event::constructFrom(
            json_decode($body, true)
        );
    } catch(\UnexpectedValueException $e) {
        http_response_code(400);
        exit();
    }
    $_POST = $event->data['metadata'];
    switch ($event->type) {
        case 'charge.succeeded':
            $wpsdDonationFor = sanitize_text_field($_POST['donation_for']);
            $wpsdName = sanitize_text_field($_POST['name']);
            $wpsdEmail = sanitize_email($_POST['email']);
            $wpsdAmount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
            $wpsdCurrency = sanitize_text_field($_POST['currency']);
            $comments = sanitize_text_field($_POST['comments']);
            $wpsdGeneralSettings = stripslashes_deep(unserialize(get_option('wpsd_general_settings')));
            $wpsdDonationEmail = (isset($wpsdGeneralSettings['wpsd_donation_email']) ? $wpsdGeneralSettings['wpsd_donation_email'] : '');
            $wpsd_disable_donation_email = (isset($wpsdGeneralSettings['wpsd_disable_donation_email']) ? $wpsdGeneralSettings['wpsd_disable_donation_email'] : '');
            // Send email to admin
            if ('' !== $wpsdDonationEmail) {
                if (!$wpsd_disable_donation_email) {
                    wpsd_email_to_admin(
                        $wpsdDonationEmail,
                        $wpsdName,
                        $wpsdAmount,
                        $wpsdCurrency,
                        $wpsdDonationFor,
                        $wpsdEmail
                    );
                }
            }
            // Save data to database
            wpsd_save_donation_info(
                $wpsdDonationFor,
                $wpsdName,
                $wpsdEmail,
                $wpsdAmount,
                $wpsdCurrency,
                $comments,
                $_POST['address']
            );
            // Upon Successful transaction, reply an Success message
            $response = array( 'status' => 'success' );  
            wp_send_json($response);
            break;
        default:
            wp_send_json(['error' => true]);
            break;
    }
}
function wpsd_email_to_admin(
    $wpsdDonationEmail,
    $wpsdName,
    $wpsdAmount,
    $wpsdCurrency,
    $wpsdDonationFor,
    $wpsdEmail
) {
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $wpsdEmailSubject = __('New Donation Received!', WPSD_TXT_DOMAIN);
    $wpsdEmailMessage = __('Name: ') . $wpsdName;
    $wpsdEmailMessage .= '<br>' . __('Email: ', WPSD_TXT_DOMAIN) . $wpsdEmail;
    $wpsdEmailMessage .= '<br>' . __('Amount: ', WPSD_TXT_DOMAIN) . $wpsdAmount . $wpsdCurrency;
    $wpsdEmailMessage .= '<br>' . __('For: ', WPSD_TXT_DOMAIN) . $wpsdDonationFor;
    return wp_mail(
        $wpsdDonationEmail,
        $wpsdEmailSubject,
        $wpsdEmailMessage,
        $headers
    );
}
function wpsd_save_donation_info(
    $wpsdDonationFor,
    $wpsdName,
    $wpsdEmail,
    $wpsdAmount,
    $wpsdCurrency,
    $comments
) {
    global  $wpdb;
    $address_street = sanitize_text_field($_POST['address'][0]['address_street']);
    $address_line2 = sanitize_text_field($_POST['address'][0]['address_line2']);
    $sql = $wpdb->prepare('INSERT INTO ' . WPSD_TABLE . '(
        wpsd_donation_for,
        wpsd_donator_name,
        wpsd_donator_email,
        wpsd_donator_phone,
        wpsd_donated_amount,
        wpsd_donation_datetime,
        wpsd_comments,
        wpsd_address
    ) VALUES (
        %s, %s, %s, %s, %s, %s, %s, %s
    )', $wpsdDonationFor, $wpsdName, $wpsdEmail, $wpsdCurrency, $wpsdAmount, date( 'Y-m-d h:i:s' ), $comments, $address_street . "&nbsp;" . $address_line2);
    $wpdb->query($sql);
}