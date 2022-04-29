<?php
$wpsdKeyShowMessage = false;

if ( isset( $_POST['updateKeySettings'] ) ) {
     $wpsdKeySettingsInfo = array(
          'wpsd_private_key' => (!empty($_POST['wpsd_private_key']) && (sanitize_text_field($_POST['wpsd_private_key']) != '')) ? sanitize_text_field($_POST['wpsd_private_key']) : '',
          'wpsd_secret_key'  => (!empty($_POST['wpsd_secret_key']) && (sanitize_text_field($_POST['wpsd_secret_key']) != '')) ? sanitize_text_field(base64_encode($_POST['wpsd_secret_key'])) : '',
     );

     $wpsdKeyShowMessage = update_option( 'wpsd_key_settings', serialize( $wpsdKeySettingsInfo ) );
}

$wpsdKeySettings    = stripslashes_deep( unserialize( get_option('wpsd_key_settings') ) );
$wpsdPrivateKey     = isset( $wpsdKeySettings['wpsd_private_key'] ) ? $wpsdKeySettings['wpsd_private_key'] : '';
$wpsdSecretKey      = isset( $wpsdKeySettings['wpsd_secret_key'] ) ? base64_decode( $wpsdKeySettings['wpsd_secret_key'] ) : '';
?>
<div id="wpsd-wrap-all" class="wrap wpsd-key-settings">

    <div class="settings-banner">
        <h2><i class="fa fa-key" aria-hidden="true"></i>&nbsp;<?php _e('Stripe Key Settings', WPSD_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
        if ( $wpsdKeyShowMessage ) {
            $this->wpsd_display_notification('success', 'Your information updated successfully.');
        }
    ?>

    <div class="wpsd-wrap">
        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left; margin-top: 5px;">
            <form name="wpsd-general-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-settings-form-id" autocomplete="off">
                <table class="form-table">
                    <tr class="wpsd_private_key">
                        <th scope="row">
                            <label for="wpsd_private_key"><?php _e('Publishable Key', WPSD_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="text" name="wpsd_private_key" id="wpsd_private_key" class="regular-text" 
                                value="<?php esc_attr_e( $wpsdPrivateKey ); ?>"/>
                            <code>pk_test_********************************</code>
                        </td>
                    </tr>
                    <tr class="wpsd_secret_key">
                        <th scope="row">
                            <label for="wpsd_secret_key"><?php _e('Secret Key', WPSD_TXT_DOMAIN); ?>:</label>
                        </th>
                        <td>
                            <input type="password" name="wpsd_secret_key" id="wpsd_secret_key" class="regular-text"
                                value="<?php esc_attr_e( $wpsdSecretKey ); ?>" autocomplete="new-password"/>
                            <code>sk_test_********************************</code>
                        </td>
                    </tr>
                </table>
                <p class="submit"><button id="updateKeySettings" name="updateKeySettings"
                        class="button button-primary wpsd-button"><?php _e('Save Settings', WPSD_TXT_DOMAIN); ?></button></p>
            </form>
            <br><br>
            <h3><?php _e('Where to Find Stripe Keys', WPSD_TXT_DOMAIN); ?>?</h3>
            <p>Please go to your <a href="https://dashboard.stripe.com/login" target="_blank">Stripe</a> account and find the keys like the below image:</p>
            <img src="<?php echo esc_attr( WPSD_ASSETS . 'img/striipe-api-keys.jpg' ); ?>" width="800" style="border:4px solid #CCC; border-radius: 10px;">
        </div>

        <?php $this->wpsd_admin_sidebar(); ?>

    </div>
</div>