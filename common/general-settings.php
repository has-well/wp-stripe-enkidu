<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Slide Settings
*/
trait Wpsd_General_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_general_settings( $post ) {

        $this->fields   = $this->wpsd_general_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wpsd_general_settings', $this->options, $post );

        return update_option( 'wpsd_general_settings', serialize( $this->settings ) );

    }

    protected function wpsd_get_general_settings() {

        $this->fields   = $this->wpsd_general_option_fileds();
		$this->settings = stripslashes_deep( unserialize( get_option('wpsd_general_settings') ) );
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_general_option_fileds() {

        return [
            [
                'name'      => 'wpsd_donation_email',
                'type'      => 'email',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_disable_donation_email',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wpsd_payment_title',
                'type'      => 'text',
                'default'   => 'Your Form Title',
            ],
            [
                'name'      => 'wpsd_form_description',
                'type'      => 'textarea',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_donation_options',
                'type'      => 'textarea',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_donation_values',
                'type'      => 'textarea',
                'default'   => '',
            ],
            [
                'name'      => 'wpsd_donate_button_text',
                'type'      => 'text',
                'default'   => 'Make Payment',
            ],
            [
                'name'      => 'wpsd_donate_currency',
                'type'      => 'text',
                'default'   => 'USD',
            ],
            [
                'name'      => 'wpsd_thankyou_page',
                'type'      => 'text',
                'default'   => 'wpsd-thank-you',
            ],
            [
                'name'      => 'wpsd_exclude_stripe_sdk',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wpsd_hide_idempotency_key',
                'type'      => 'boolean',
                'default'   => false,
            ],
        ];
    }
}