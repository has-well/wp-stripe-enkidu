<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdGeneralSettings );
foreach ( $wpsdGeneralSettings as $option_name => $option_value ) {
    if ( isset( $wpsdGeneralSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<div id="wpsd-wrap-all" class="wrap wpsd-general-settings">

    <div class="settings-banner">
        <h2><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;<?php 
_e( 'General Settings', WPSD_TXT_DOMAIN );
?></h2>
    </div>

    <?php 
if ( $wpsdGeneralShowMessage ) {
    $this->wpsd_display_notification( 'success', 'Your information updated successfully.' );
}
?>

    <div class="wpsd-wrap">

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left; margin-top: 5px;">

            <form name="wpsd-general-settings-form" role="form" class="form-horizontal" method="post" action=""
                id="wpsd-settings-form-id">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Donation Admin Email', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_donation_email" id="wpsd_donation_email" class="regular-text"
                                value="<?php 
esc_attr_e( $wpsd_donation_email );
?>" />
                            <br>
                            <code><?php 
_e( 'Donation notification will send to this email', WPSD_TXT_DOMAIN );
?>.</code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wpsd_disable_donation_email"><?php 
_e( 'Disable Admin Email', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <?php 
?>
                                <span><?php 
echo  '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WPSD_TXT_DOMAIN ) . '</a>' ;
?></span>
                                <?php 
?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Form Title', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_payment_title" id="wpsd_payment_title" class="regular-text"
                                value="<?php 
esc_attr_e( $wpsd_payment_title );
?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Form Description', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <textarea cols="40" style="min-height:100px;" name="wpsd_form_description" class="regular-text"
                                id="wpsd_form_description"><?php 
esc_html_e( $wpsd_form_description );
?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Donation For Options', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <textarea cols="40" style="min-height:100px;" name="wpsd_donation_options" class="regular-text"
                                id="wpsd_donation_options"><?php 
esc_html_e( $wpsd_donation_options );
?></textarea>
                            <br>
                            <code><?php 
_e( 'Use comma "," separated values like: Option-1, Option-2', WPSD_TXT_DOMAIN );
?></code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Amounts', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <textarea cols="40" style="min-height:100px;" name="wpsd_donation_values" class="regular-text"
                                id="wpsd_donation_values"><?php 
esc_html_e( $wpsd_donation_values );
?></textarea>
                            <br>
                            <code><?php 
_e( 'Use comma "," separated values like: 100,150,200', WPSD_TXT_DOMAIN );
?></code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Form Button Text', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_donate_button_text" id="wpsd_donate_button_text" class="regular-text"
                                value="<?php 
esc_attr_e( $wpsd_donate_button_text );
?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Currency', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <select name="wpsd_donate_currency" id="wpsd_donate_currency" class="regular-text">
                                <?php 
$wpsdCurrency = $this->hm_get_all_currency();
foreach ( $wpsdCurrency as $wpsdcurr ) {
    ?>
                                    <option value="<?php 
    esc_attr_e( $wpsdcurr->abbreviation );
    ?>" <?php 
    if ( $wpsd_donate_currency === $wpsdcurr->abbreviation ) {
        echo  'selected' ;
    }
    ?> >
                                        <?php 
    esc_html_e( $wpsdcurr->currency );
    ?>-<?php 
    esc_html_e( $wpsdcurr->abbreviation );
    ?>-<?php 
    esc_html_e( $wpsdcurr->symbol );
    ?>
                                    </option>
                                    <?php 
}
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Success Page', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <?php 
?>
                                <span><?php 
echo  '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>' ;
?></span>
                                <?php 
?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wpsd_exclude_stripe_sdk"><?php 
_e( 'Exclude Stripe SDK', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wpsd_exclude_stripe_sdk" class="wpsd_exclude_stripe_sdk" id="wpsd_exclude_stripe_sdk" value="1" 
                                <?php 
echo  ( $wpsd_exclude_stripe_sdk ? 'checked' : '' ) ;
?> >
                            <br>
                            <code><?php 
_e( 'Check this if you have other stripe plugins activated. This will avoid conflict.', WPSD_TXT_DOMAIN );
?></code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wpsd_hide_idempotency_key"><?php 
_e( 'Disable Idempotency Key Checking', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <?php 
?>
                                <span><?php 
echo  '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>' ;
?></span>
                                <?php 
?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
esc_html_e( 'Shortcode', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_shortcode" id="wpsd_shortcode" class="regular-text" value="[wp_stripe_donation]" readonly />
                        </td>
                    </tr>
                </table>
                <p class="submit"><button id="updateGeneralSettings" name="updateGeneralSettings"
                        class="button button-primary wpsd-button"><?php 
esc_attr_e( 'Save Settings', WPSD_TXT_DOMAIN );
?></button>
                </p>
            </form>

        </div>

        <?php 
$this->wpsd_admin_sidebar();
?>

    </div>
</div>