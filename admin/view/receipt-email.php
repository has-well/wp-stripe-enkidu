<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdEmailSettings );
foreach ( $wpsdEmailSettings as $option_name => $option_value ) {
    if ( isset( $wpsdEmailSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<div id="wpsd-wrap-all" class="wrap wpsd-email-settings">

    <div class="settings-banner">
        <h2><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Receipt Email Settings', WPSD_TXT_DOMAIN );
?></h2>
    </div>

    <?php 
if ( $wpsdEmailShowMessage ) {
    $this->wpsd_display_notification( 'success', 'Your information updated successfully.' );
}
?>

    <div class="wpsd-wrap">

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <form name="wpsd-email-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-settings-form-id">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Subject', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_re_email_subject" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_email_subject );
?>" />
                            <br>
                            <code><?php 
_e( 'We received your payment', WPSD_TXT_DOMAIN );
?>!</code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Heading', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_re_email_heading" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_email_heading );
?>" />
                            <br>
                            <code><?php 
_e( 'Thanks for your payment!', WPSD_TXT_DOMAIN );
?></code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Footnote', WPSD_TXT_DOMAIN );
?></label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_re_email_footnote" class="regular-text" value="<?php 
esc_attr_e( $wpsd_re_email_footnote );
?>" />
                            <br>
                            <code><?php 
_e( 'If you have any question, please reply this email.', WPSD_TXT_DOMAIN );
?></code>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wpsd_disable_receipt_email"><?php 
_e( 'Disable Plugin Receipt Email', WPSD_TXT_DOMAIN );
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
                            <label for="wpsd_disable_stripe_receipt_email"><?php 
_e( 'Disable Stripe Receipt Email', WPSD_TXT_DOMAIN );
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
_e( 'From Name', WPSD_TXT_DOMAIN );
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
_e( 'From Email', WPSD_TXT_DOMAIN );
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
                </table>
                <p class="submit"><button id="updateEmailSettings" name="updateEmailSettings" class="button button-primary wpsd-button">
                    <?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?></button>
                </p>
            </form>

        </div>

        <?php 
$this->wpsd_admin_sidebar();
?>

    </div>
</div>