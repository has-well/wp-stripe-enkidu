
<?php 
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdContentSettings );
foreach ( $wpsdContentSettings as $option_name => $option_value ) {
    if ( isset( $wpsdContentSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-temp-settings-form" role="form" class="form-horizontal" method="post" action="" id="wpsd-temp-settings-form-id">
    <table class="wpsd-form-content-settings">
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Template Color', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <div class="wpsd-template-selector">
                    <?php 
for ( $i = 0 ;  $i < 5 ;  $i++ ) {
    ?>
                    <div class="wpsd-template-item">
                        <input type="radio" name="wpsd_select_template" id="<?php 
    printf( 'wpsd_select_template_%d', $i );
    ?>" value="<?php 
    printf( '%d', $i );
    ?>"
                            <?php 
    if ( $wpsd_select_template == $i ) {
        echo  'checked' ;
    }
    ?>>
                        <label for="<?php 
    printf( 'wpsd_select_template_%d', $i );
    ?>" class="wpsd-template-<?php 
    printf( '%d', $i );
    ?>"></label>
                    </div>
                    <?php 
}
?>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_display_banner"><?php 
_e( 'Display Banner', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td>
                <input type="checkbox" name="wpsd_display_banner" class="wpsd_display_banner" id="wpsd_display_banner" value="1" <?php 
echo  ( $wpsd_display_banner ? 'checked' : '' ) ;
?> >
            </td>
            <th scope="row">
                <label><?php 
_e( 'Banner', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td>
                <input type="hidden" name="wpsd_form_banner" id="wpsd_form_banner" value="<?php 
esc_attr_e( $wpsd_form_banner );
?>" class="regular-text" />
                <input type='button' class="button-primary" value="<?php 
esc_attr_e( 'Select a banner', WPSD_TXT_DOMAIN );
?>" id="wpsd_media_manager" data-image-type="full" />
                <?php 
$wpsdFormBannerImage = '';
if ( intval( $wpsd_form_banner ) > 0 ) {
    $wpsdFormBannerImage = wp_get_attachment_image(
        $wpsd_form_banner,
        'full',
        false,
        array(
        'id' => 'wpsd-form-banner-preview-image',
    )
    );
}
?>
                <div id="wpsd-form-banner-preview-image">
                    <?php 
echo  $wpsdFormBannerImage ;
?>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_hide_label"><?php 
_e( 'Hide All Form Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="checkbox" name="wpsd_hide_label" id="wpsd_hide_label" value="1" <?php 
echo  ( $wpsd_hide_label ? 'checked' : '' ) ;
?> >
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_hide_donation_for"><?php 
_e( 'Hide Donation For', WPSD_TXT_DOMAIN );
?></label>
                <br>
                <small><?php 
_e( 'If you hide this, please make sure you must have only one donation for available in general settings.', WPSD_TXT_DOMAIN );
?></small>
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
            <th scope="row">
                <label><?php 
_e( 'Donate/Payment For Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td>
                <input type="text" name="wpsd_donation_for_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Donation/Payment For', WPSD_TXT_DOMAIN );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donation_for_label );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Name Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_donator_name_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Full Name', WPSD_TXT_DOMAIN );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donator_name_label );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Email Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_donator_email_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Email', WPSD_TXT_DOMAIN );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donator_email_label );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_display_address"><?php 
_e( 'Display Address', WPSD_TXT_DOMAIN );
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
            <th scope="row">
                <label for="wpsd_show_captcha"><?php 
_e( 'Address Street Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Address Line-2 Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Address City Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Address State Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Postal Code Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Country Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_show_comments"><?php 
_e( 'Show Comments', WPSD_TXT_DOMAIN );
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
            <th scope="row">
                <label><?php 
_e( 'Comments Label', WPSD_TXT_DOMAIN );
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
                <label for="wpsd_show_captcha"><?php 
_e( 'Show Captcha', WPSD_TXT_DOMAIN );
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
            <th scope="row">
                <label><?php 
_e( 'Captcha Label', WPSD_TXT_DOMAIN );
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
_e( 'Amount Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_donate_amount_label" class="medium-text" placeholder="<?php 
esc_attr_e( 'Amount', WPSD_TXT_DOMAIN );
?>"
                    value="<?php 
esc_attr_e( $wpsd_donate_amount_label );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Other Amount Text', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_other_amount_text" class="medium-text" placeholder="<?php 
esc_attr_e( 'Other Amount', WPSD_TXT_DOMAIN );
?>"
                    value="<?php 
esc_attr_e( $wpsd_other_amount_text );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Card Element Label', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <input type="text" name="wpsd_card_element_label" class="medium-text" placeholder="<?php 
esc_attr_e( $wpsd_card_element_label );
?>"
                    value="<?php 
esc_attr_e( $wpsd_card_element_label );
?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wpsd_form_width"><?php 
_e( 'Form Width', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_form_header_type"><?php 
_e( 'Form Header Type', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_form_button_width"><?php 
_e( 'Form Button Width', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
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
                <label for="wpsd_display_total_donation"><?php 
_e( 'Display Total Donation Today', WPSD_TXT_DOMAIN );
?></label>
            </th>
            <td colspan="3">
                <?php 
?>
                    <span><?php 
echo  '<a href="' . wsd_fs()->get_upgrade_url() . '">' . __( 'Upgrade to Professional!', WPSD_TXT_DOMAIN ) . '</a>' ;
?></span>
                    <?php 
?>
            </td>
        </tr>
    </table>
    <p class="submit">
        <button id="updateContent" name="updateContent" class="button button-primary wpsd-button"><?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?></button>
    </p>
</form>