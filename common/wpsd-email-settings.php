<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Slide Settings
*/
trait Wpsd_Email_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_email_content_settings( $post ) {

        $this->fields   = $this->wpsd_email_content_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

       $this->settings = apply_filters( 'wpsd_receipt_email_settings', $this->options, $post );

        return update_option( 'wpsd_receipt_email_settings', serialize( $this->settings ) );

    }

    protected function wpsd_get_email_content_settings() {

        $this->fields   = $this->wpsd_email_content_option_fileds();
		$this->settings = stripslashes_deep( unserialize( get_option('wpsd_receipt_email_settings') ) );
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_email_content_option_fileds() {

        return [
            [
                'name'      => 'wpsd_re_email_subject',
                'type'      => 'text',
                'default'   => 'We received your payment!',
            ],
            [
                'name'      => 'wpsd_re_email_heading',
                'type'      => 'text',
                'default'   => 'Thanks for your payment!',
            ],
            [
                'name'      => 'wpsd_re_email_footnote',
                'type'      => 'text',
                'default'   => 'If you have any question, please reply this email.',
            ],
            [
                'name'      => 'wpsd_disable_receipt_email',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wpsd_disable_stripe_receipt_email',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wpsd_re_from_name',
                'type'      => 'text',
                'default'   => 'Donation Received',
            ],
            [
                'name'      => 'wpsd_re_from_email',
                'type'      => 'email',
                'default'   => 'webmaster@yourdomain.com',
            ],
        ];
    }
}