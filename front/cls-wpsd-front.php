<?php

if (!defined('ABSPATH')) {
    exit;
}
/** 
 * Master Class: Front
 */
class Wpsd_Front
{
    use
        HM_Currency,
        Wpsd_Common,
        Wpsd_General_Settings,
        Wpsd_Form_Settings,
        Wpsd_Form_Style_Settings,
        Wpsd_Email_Settings,
        Wpsd_Donations;
    private  $wpsd_version;
    function __construct($version)
    {
        $this->wpsd_version = $version;
        $this->wpsd_assets_prefix = substr(WPSD_PRFX, 0, -1) . '-';
    }

    function wpsd_front_assets()
    {

        if (shortcode_exists('wp_stripe_donation')) {
            // searchable dropdown select Style
            wp_register_style('wbg-selectize', '//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css');
            wp_enqueue_style('wbg-selectize');
            wp_enqueue_style(
                $this->wpsd_assets_prefix . 'front',
                WPSD_ASSETS . 'css/' . $this->wpsd_assets_prefix . 'front.css',
                array(),
                $this->wpsd_version,
                FALSE
            );
            if (!wp_script_is('jquery')) {
                wp_enqueue_script('jquery');
            }
            wp_enqueue_script(
                'wpsd-stripe',
                '//js.stripe.com/v3/',
                null,
                $this->wpsd_version,
                true
            );
            wp_enqueue_script(
                $this->wpsd_assets_prefix . 'front',
                WPSD_ASSETS . 'js/' . $this->wpsd_assets_prefix . 'front.js',
                array('jquery'),
                $this->wpsd_version,
                TRUE
            );
            // searchable dropdown select js
            wp_enqueue_script('wbg-selectize', '//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js');
            $wpsdKeySettings = stripslashes_deep(unserialize(get_option('wpsd_key_settings')));
            $wpsdPrimaryKey = (isset($wpsdKeySettings['wpsd_private_key']) ? $wpsdKeySettings['wpsd_private_key'] : 'pk_test_12345');
            $wpsdGeneralSettings = stripslashes_deep(unserialize(get_option('wpsd_general_settings')));
            $wpsdDonateCurrency = (isset($wpsdGeneralSettings['wpsd_donate_currency']) ? $wpsdGeneralSettings['wpsd_donate_currency'] : 'USD');
            $wpsd_thankyou_page = (isset($wpsdGeneralSettings['wpsd_thankyou_page']) ? $wpsdGeneralSettings['wpsd_thankyou_page'] : 'wpsd-thank-you');
            $wpsd_exclude_stripe_sdk = (isset($wpsdGeneralSettings['wpsd_exclude_stripe_sdk']) ? $wpsdGeneralSettings['wpsd_exclude_stripe_sdk'] : false);
            $wpsdFormStyleSettings = stripslashes_deep(unserialize(get_option('wpsd_form_style_settings')));
            $wpsd_form_input_font_color = (isset($wpsdFormStyleSettings['wpsd_form_input_font_color']) ? $wpsdFormStyleSettings['wpsd_form_input_font_color'] : '#242424');
            $wpsdAdminArray = array(
                'stripePKey'         => $wpsdPrimaryKey,
                'ajaxurl'            => admin_url('admin-ajax.php'),
                'currency'           => $wpsdDonateCurrency,
                'successUrl'         => get_site_url() . '/' . $wpsd_thankyou_page,
                'idempotency'        => $this->wpsd_rand_string(8),
                'security'           => wp_create_nonce('acme-security-nonce'),
                'stripe_sdk'         => $wpsd_exclude_stripe_sdk,
                'card_element_color' => $wpsd_form_input_font_color,
            );
            wp_localize_script($this->wpsd_assets_prefix . 'front', 'wpsdAdminScriptObj', $wpsdAdminArray);
        }

        //if ( shortcode_exists( 'wp_stripe_donation' ) ) {
    }

    function wpsd_load_shortcode()
    {
        add_shortcode('wp_stripe_donation', array($this, 'wpsd_load_shortcode_view'));
    }

    function wpsd_load_shortcode_view()
    {
        $wpsdGeneralSettings = $this->wpsd_get_general_settings();
        $wpsdFormSettings = $this->wpsd_get_form_content_settings();
        $wpsdFormSyleSettings = $this->wpsd_get_form_style_settings();
        $wpsd_donation_today = $this->wpsd_get_total_donation_today();
        $output = '';
        ob_start();
        include plugin_dir_path(__FILE__) . '/view/payment-form.php';
        $output .= ob_get_clean();
        return $output;
    }

    function wpsd_load_donors_panel()
    {
        $wpsdDonations = $this->wpsd_get_all_donations_full();
        $output = '';
        ob_start();
        include plugin_dir_path(__FILE__) . '/view/donors.php';
        $output .= ob_get_clean();
        return $output;
    }

    function wpsd_donation_handler()
    {

        if (!check_ajax_referer('acme-security-nonce', 'security', false)) {
            wp_send_json_error('Invalid security token sent.');
            wp_die();
        }
        if ( ! class_exists( '\Stripe\Stripe' ) ) {
            require_once WPSD_PATH . 'stripe/init.php';
        }
        $wpsdKeySettings = stripslashes_deep(unserialize(get_option('wpsd_key_settings')));
        $wpsdStripeKey = (isset($wpsdKeySettings['wpsd_secret_key']) ? $wpsdKeySettings['wpsd_secret_key'] : '');
        \Stripe\Stripe::setApiKey(base64_decode($wpsdStripeKey));
        if (!empty($_POST['email']) && !empty($_POST['amount']) && !empty($_POST['donation_for'])) {
            $wpsdDonationFor = sanitize_text_field($_POST['donation_for']);
            $name = sanitize_email($_POST['name']);
            $wpsdEmail = sanitize_email($_POST['email']);
            $wpsdAmount = sanitize_text_field($_POST['amount']);
            $wpsdCurrency = sanitize_text_field($_POST['currency']);
            $idempotency = ($wpsd_hide_idempotency_key ? $this->wpsd_rand_string(100) : preg_replace('/[^a-z\\d]/im', '', $_POST['idempotency']));
            $address_street = sanitize_text_field($_POST['address'][0]['address_street']);
            $address_line2 = sanitize_text_field($_POST['address'][0]['address_line2']);
            $address_city = sanitize_text_field($_POST['address'][0]['address_city']);
            $address_state = sanitize_text_field($_POST['address'][0]['address_state']);
            $address_postal = sanitize_text_field($_POST['address'][0]['address_postal']);
            $address_country = sanitize_text_field($_POST['address'][0]['address_country']);
            $wpsdEmailSettings = stripslashes_deep(unserialize(get_option('wpsd_receipt_email_settings')));
            $wpsdDisableStripeEmail = (isset($wpsdEmailSettings['wpsd_disable_stripe_receipt_email']) ? $wpsdEmailSettings['wpsd_disable_stripe_receipt_email'] : true);
            $receiptEmail = ($wpsdDisableStripeEmail ? null : $wpsdEmail);
            $amount = $this->wpsd_multiplying_currencies($wpsdAmount, $wpsdCurrency);
            try {
                $_POST['integration_check'] = 'accept_a_payment';
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount'        => $amount,
                    'currency'      => $wpsdCurrency,
                    'description'   => $wpsdDonationFor,
                    'receipt_email' => $receiptEmail,
                    'automatic_payment_methods' => ['enabled' => true],
                    'metadata'      => $_POST,
                    'shipping'      => [
                        'name'    => $name,
                        'address' => [
                            'line1'       => $address_street . ' ' . $address_line2,
                            'postal_code' => $address_postal,
                            'city'        => $address_city,
                            'state'       => $address_state,
                            'country'     => $address_country,
                        ],
                    ],
                ], 
				  //['idempotency_key' => $idempotency,]
				);

                if ('' !== $paymentIntent->client_secret) {
                    $output = array(
                        'status'        => 'success',
                        'client_secret' => $paymentIntent->client_secret,
                    );
                    wp_send_json_success($output);
                } else {
                    wp_send_json_success(array(
                        'status'  => 'error',
                        'message' => __('Something went wrong!', WPSD_TXT_DOMAIN),
                    ));
                }
            } catch (\Stripe\Exception\CardException $e) {
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\RateLimitException $e) {
                // Too many requests made to the API too quickly
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Invalid parameters were supplied to Stripe's API
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // Network communication with Stripe failed
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                //
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (\Stripe\Exception\IdempotencyException $e) {
                // Idempotency Duplicate Issue
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                wp_send_json_success(array(
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ));
            }
        }
    }

    function wpsd_donation_handler_success()
    {
        $wpsdKeySettings = stripslashes_deep(unserialize(get_option('wpsd_key_settings')));
        $wpsdStripeKey = (isset($wpsdKeySettings['wpsd_secret_key']) ? $wpsdKeySettings['wpsd_secret_key'] : '');
        if ( ! class_exists( '\Stripe\Stripe' ) ) {
            require_once WPSD_PATH . 'stripe/init.php';
        }
        \Stripe\Stripe::setApiKey(base64_decode($wpsdStripeKey));
       
        try {
            $intent = \Stripe\PaymentIntent::retrieve(
                $_POST['pay_result']['paymentIntent']['id']
            );
            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response = array( 'status' => 'error', 'data' => $e->getMessage() );  
            wp_send_json($response);
        } catch (Exception $e) {
            $response = array( 'status' => 'error' );  
            wp_send_json($response);
        }
        $wpsdAmount = filter_var($_POST['amount'], FILTER_SANITIZE_STRING);
        if ($intent->amount_capturable !== 0 or $intent->amount_received != ($wpsdAmount*100)){
            $response = array( 'status' => 'error', 'message' => 'Payment completed, but have some error.');  
            wp_send_json($response);
            exit();
        }
        if (!empty($_POST['email']) && !empty($_POST['amount']) && !empty($_POST['name']) && !empty($_POST['donation_for'])) {
            $wpsdDonationFor = sanitize_text_field($_POST['donation_for']);
            $wpsdName = sanitize_text_field($_POST['name']);
            $wpsdEmail = sanitize_email($_POST['email']);
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
            $response = array( 'status' => 'success' );  
            wp_send_json($response);
        }
    }

    function wpsd_rand_string($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

    function wpsd_get_total_donation_today()
    {
        global  $wpdb;
        $table_name = WPSD_TABLE;
        $val = $wpdb->get_var("SELECT sum(wpsd_donated_amount) FROM {$table_name} WHERE CAST(wpsd_donation_datetime AS DATE) =  CURDATE()");
        if ($val > 0) {
            return $val;
        }
        return 0;
    }

    function wpsd_multiplying_currencies($amount, $currency)
    {
        $zero_decimal_currencies = [
            'BIF',
            'CLP',
            'DJF',
            'GNF',
            'JPY',
            'KMF',
            'KRW',
            'MGA',
            'PYG',
            'RWF',
            'UGX',
            'VND',
            'VUV',
            'XAF',
            'XOF',
            'XPF'
        ];
        if (!in_array($currency, $zero_decimal_currencies)) {
            return $amount * 100;
        }
        return $amount;
    }
}
