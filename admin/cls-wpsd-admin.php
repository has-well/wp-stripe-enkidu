<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 *	Master Class: Admin
 */
class Wpsd_Admin
{
    use 
        HM_Currency,
        Wpsd_Common,
        Wpsd_General_Settings,
        Wpsd_Email_Settings,
        Wpsd_Form_Settings,
        Wpsd_Form_Style_Settings,
        Wpsd_Donations
    ;
    private  $wpsd_version ;
    private  $wpsd_option_group ;
    private  $wpsd_assets_prefix ;
    public function __construct( $version )
    {
        $this->wpsd_version = $version;
        $this->wpsd_option_group = WPSD_PRFX . 'options_group';
        $this->wpsd_assets_prefix = substr( WPSD_PRFX, 0, -1 ) . '-';
    }
    
    /**
     *	Loading the admin menu
     */
    public function wpsd_admin_menu()
    {
        add_menu_page(
            __( 'WP Stripe Donation', WPSD_TXT_DOMAIN ),
            __( 'WP Stripe Donation', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-admin-settings',
            array( $this, WPSD_PRFX . 'get_help' ),
            'dashicons-money-alt',
            100
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Key Settings', WPSD_TXT_DOMAIN ),
            __( 'Key Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-key-settings',
            array( $this, WPSD_PRFX . 'key_settings' )
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'General Settings', WPSD_TXT_DOMAIN ),
            __( 'General Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-general-settings',
            array( $this, WPSD_PRFX . 'general_settings' )
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Form Settings', WPSD_TXT_DOMAIN ),
            __( 'Form Settings', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-template-settings',
            array( $this, WPSD_PRFX . 'form_settings' )
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Donation List', WPSD_TXT_DOMAIN ),
            __( 'Donation List', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-all-donations',
            array( $this, WPSD_PRFX . 'all_donations' )
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Receipt Email', WPSD_TXT_DOMAIN ),
            __( 'Receipt Email', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-email-settings',
            array( $this, 'wpsd_email_settings' )
        );
        add_submenu_page(
            'wpsd-admin-settings',
            __( 'Usage & Tutorial', WPSD_TXT_DOMAIN ),
            __( 'Usage & Tutorial', WPSD_TXT_DOMAIN ),
            'manage_options',
            'wpsd-get-help',
            array( $this, WPSD_PRFX . 'get_help' )
        );
    }
    
    /**
     *	Loading admin panel assets
     */
    function wpsd_admin_assets()
    {
        wp_enqueue_style(
            $this->wpsd_assets_prefix . 'font-awesome',
            WPSD_ASSETS . 'css/font-awesome/css/font-awesome.min.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        wp_enqueue_style(
            $this->wpsd_assets_prefix . 'admin',
            WPSD_ASSETS . 'css/' . $this->wpsd_assets_prefix . 'admin.css',
            array(),
            $this->wpsd_version,
            FALSE
        );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_media();
        if ( !wp_script_is( 'jquery' ) ) {
            wp_enqueue_script( 'jquery' );
        }
        wp_enqueue_script(
            $this->wpsd_assets_prefix . 'admin',
            WPSD_ASSETS . 'js/' . $this->wpsd_assets_prefix . 'admin.js',
            array( 'jquery' ),
            $this->wpsd_version,
            TRUE
        );
        //$wpsd_settings = get_option('wpsd_settings');
        $wpsdAdminArray = array(
            'wpsdIdsOfColorPicker' => array(),
        );
        wp_localize_script( $this->wpsd_assets_prefix . 'admin-script', 'wpsdAdminScript', $wpsdAdminArray );
    }
    
    /**
     *	Loading admin panel view/forms
     */
    function wpsd_key_settings()
    {
        require_once WPSD_PATH . 'admin/view/' . $this->wpsd_assets_prefix . 'key-settings.php';
    }
    
    function wpsd_general_settings()
    {
        $wpsdGeneralShowMessage = false;
        if ( isset( $_POST['updateGeneralSettings'] ) ) {
            $wpsdGeneralShowMessage = $this->wpsd_set_general_settings( $_POST );
        }
        $wpsdGeneralSettings = $this->wpsd_get_general_settings();
        require_once WPSD_PATH . 'admin/view/general.php';
    }
    
    function wpsd_form_settings()
    {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        $tab = ( isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : null );
        $wpsdNotice = false;
        if ( isset( $_POST['updateContent'] ) ) {
            $wpsdNotice = $this->wpsd_set_form_content_settings( $_POST );
        }
        if ( isset( $_POST['updateStyle'] ) ) {
            $wpsdNotice = $this->wpsd_set_form_style_settings( $_POST );
        }
        $wpsdContentSettings = $this->wpsd_get_form_content_settings();
        $wpsdSyleSettings = $this->wpsd_get_form_style_settings();
        require_once WPSD_PATH . 'admin/view/form.php';
    }
    
    function wpsd_email_settings()
    {
        $wpsdEmailShowMessage = false;
        if ( isset( $_POST['updateEmailSettings'] ) ) {
            $wpsdEmailShowMessage = $this->wpsd_set_email_content_settings( $_POST );
        }
        $wpsdEmailSettings = $this->wpsd_get_email_content_settings();
        require_once WPSD_PATH . 'admin/view/receipt-email.php';
    }
    
    function wpsd_all_donations()
    {
        $wpsdColumns = array(
            'wpsd_donated_amount'    => __( 'Amount', WPSD_TXT_DOMAIN ),
            'wpsd_donation_for'      => __( 'Donation For', WPSD_TXT_DOMAIN ),
            'wpsd_donator_name'      => __( 'Name', WPSD_TXT_DOMAIN ),
            'wpsd_donator_email'     => __( 'Email', WPSD_TXT_DOMAIN ),
            'wpsd_donation_datetime' => __( 'Date', WPSD_TXT_DOMAIN ),
        );
        register_column_headers( 'wpsd-column-table', $wpsdColumns );
        $wpsdDonations = $this->wpsd_get_all_donations();
        require_once WPSD_PATH . 'admin/view/' . $this->wpsd_assets_prefix . 'all-donations.php';
    }
    
    protected function wpsd_display_notification( $type, $msg )
    {
        ?>
		<div class="wpsd-alert <?php 
        esc_attr_e( $type );
        ?>">
			<span class="wpsd-closebtn">&times;</span>
			<strong><?php 
        esc_html_e( ucfirst( $type ) );
        ?>!</strong> <?php 
        esc_html_e( $msg );
        ?>
		</div>
		<?php 
    }
    
    function wpsd_get_image()
    {
        
        if ( isset( $_GET['id'] ) ) {
            $image = wp_get_attachment_image(
                filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ),
                esc_html( $_GET['img_type'] ),
                false,
                array(
                'id' => esc_html( $_GET['prev_id'] ),
            )
            );
            $data = array(
                'image' => $image,
            );
            wp_send_json_success( $data );
        } else {
            wp_send_json_error();
        }
    
    }
    
    function wpsd_get_help()
    {
        require_once WPSD_PATH . 'admin/view/' . $this->wpsd_assets_prefix . 'help-usage.php';
    }
    
    function wpsd_export_donations_to_csv()
    {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
    }

}