<?php

if (!defined('ABSPATH')) {
    exit;
}
foreach ($wpsdGeneralSettings as $gs_name => $gs_value) {
    if (isset($wpsdGeneralSettings[$gs_name])) {
        ${"" . $gs_name} = $gs_value;
    }
}
$wpsd_donation_values = ($wpsd_donation_values != '' ? explode(',', $wpsd_donation_values) : []);
// ========================
// Form Settings
// ========================
foreach ($wpsdFormSettings as $form_name => $form_value) {
    if (isset($wpsdFormSettings[$form_name])) {
        ${"" . $form_name} = $form_value;
    }
}
foreach ($wpsdFormSyleSettings as $fs_name => $fs_value) {
    if (isset($wpsdFormSyleSettings[$fs_name])) {
        ${"" . $fs_name} = $fs_value;
    }
}

if ('tdb' === $wpsd_form_header_type) {
    $form_header_type = ['title', 'description', 'banner'];
} else {

    if ('btd' === $wpsd_form_header_type) {
        $form_header_type = ['banner', 'title', 'description'];
    } else {
        $form_header_type = ['title', 'banner', 'description'];
    }
}

$wpsdCaptchaItem1 = rand(1, 20);
$wpsdCaptchaItem2 = rand(1, 20);
?>
<div class="wpsd-master-wrapper wpsd-template-<?php
                                                printf('%d', $wpsd_select_template);
                                                ?>" id="wpsd-wrap-all">

    <div id="wpsd-pageloader">
        <img src="<?php
                    echo  esc_attr(WPSD_ASSETS . 'img/loader.gif');
                    ?>" alt="<?php
            _e('Processing', WPSD_TXT_DOMAIN);
            ?>" />
    </div>

    <?php
    $fht = 0;
    foreach ($form_header_type as $type) {
        if ('title' === $type) {

            if ('' !== $wpsd_payment_title) {
    ?>
                <h3 class="wpsd-form-title"><?php
                                            esc_html_e($wpsd_payment_title);
                                            ?></h3>
                <!-- Title Border -->
                <div class="wpsd-form-title-border"></div>
            <?php
            }
        }
        if ('description' === $type) {

            if ('' !== $wpsd_form_description) {
            ?>
                <p class="wpsd-form-description"><?php
                                                    esc_html_e($wpsd_form_description);
                                                    ?></p>
    <?php
            }
        }
        if ('banner' === $type) {
            if ($wpsd_display_banner) {
                if (intval($wpsd_form_banner) > 0) {
                    echo  wp_get_attachment_image(
                        $wpsd_form_banner,
                        'full',
                        false,
                        array(
                            'class' => 'wpsd-form-banner',
                        )
                    );
                }
            }
        }
        $fht++;
    }
    ?>

    <!-- Main Form -->
    <div class="wpsd-wrapper-content">

        <form action="" method="POST" id="wpsd-donation-form-id" autocomplete="off">

            <ul id="wpsd_donate_amount">
                <?php
                if (count($wpsd_donation_values) > 0) {
                    foreach ($wpsd_donation_values as $amount) {
                        //if( '' !== $amount ) {
                ?>
                        <li class="amount" data-amount="<?php
                                                        esc_attr_e(trim($amount));
                                                        ?>">
                            <div class="form-group">
                                <label for="amount_<?php
                                                    esc_attr_e(trim($amount));
                                                    ?>"><?php
                        esc_html_e(number_format($amount));
            ?></label>
                            </div>
                        </li>
                    <?php
                        //}
                    }
                }

                if ('' !== $wpsd_other_amount_text) {
                    ?>
                    <li>
                        <div class="form-group"><?php
                                                esc_html_e($wpsd_other_amount_text);
                                                ?></div>
                    </li>
                <?php
                }

                ?>
                <li class="wpsd_donate_amount_other_li">
                    <div class="form-group">
                        <input id="wpsd_donate_other_amount" type="text" value="100" class="wpsd_donate_other_amount" name="wpsd_donate_other_amount" placeholder="<?php
                                                                                                                                                        _e('Amount', WPSD_TXT_DOMAIN);
                                                                                                                                                        ?>"> <?php
        esc_html_e($wpsd_donate_currency);
        ?>
                    </div>
                </li>
            </ul>

            <?php
            // Donation/Payment For

            if (!$wpsd_hide_donation_for) {

                if (!$wpsd_hide_label) {
            ?>
                    <label for="wpsd_donation_for" class="wpsd-donation-form-label"><?php
                                                                                    esc_html_e($wpsd_donation_for_label);
                                                                                    ?></label>
                <?php
                }

                ?>
                <select name="wpsd_donation_for" id="wpsd_donation_for" class="wpsd-text-field">
                    <?php
                    $wpsd_donation_options = ($wpsd_donation_options != '' ? explode(',', $wpsd_donation_options) : []);
                    if (count($wpsd_donation_options) > 0) {
                        foreach ($wpsd_donation_options as $item) {
                    ?>
                            <option value="<?php
                                            esc_attr_e(trim($item));
                                            ?>"><?php
                            esc_html_e(trim($item));
                ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            <?php
            } else {
            ?>
                <input type="hidden" name="wpsd_donation_for" id="wpsd_donation_for" value="<?php
                                                                                            esc_attr_e($wpsd_donation_options);
                                                                                            ?>">
            <?php
            }

            // Full Name

            if (!$wpsd_hide_label) {
            ?>
                <label for="wpsd_donator_name" class="wpsd-donation-form-label"><?php
                                                                                esc_html_e($wpsd_donator_name_label);
                                                                                ?></label>
            <?php
            }

            ?>
            <input type="text" name="wpsd_donator_name" id="wpsd_donator_name" class="wpsd-text-field" autocomplete="on" placeholder="<?php
                                                                                                                    esc_attr_e($wpsd_donator_name_label);
                                                                                                                    ?>">

            <!-- Email -->
            <?php

            if (!$wpsd_hide_label) {
            ?>
                <label for="wpsd_donator_email" class="wpsd-donation-form-label"><?php
                                                                                    esc_html_e($wpsd_donator_email_label);
                                                                                    ?></label>
            <?php
            }

            ?>
            <input type="email" name="wpsd_donator_email" id="wpsd_donator_email" class="wpsd-text-field" autocomplete="on" placeholder="<?php
                                                                                                                        esc_attr_e($wpsd_donator_email_label);
                                                                                                                        ?>">

            <?php if ($wpsd_display_phone) { ?>
                <label for="wpsd_donator_phone" class="wpsd-donation-form-label"><?php esc_html_e($wpsd_donator_phone_label); ?></label>
                <input type="text" name="wpsd_donator_phone" id="wpsd_donator_phone" class="wpsd-text-field" placeholder="<?php esc_attr_e($wpsd_donator_phone_label); ?>">
            <?php } ?>

            <?php
            ?>
            <div id="card-errors" class="wpsd-alert" role="alert"></div>
            <input type="submit" name="wpsd-donate-button" class="btn btn-blue" value="<?php esc_attr_e($wpsd_donate_button_text);  ?>">
        </form>
        
            <!-- Card --->
            <div id="wpsd-payment" class="payment">
                <div id="card-element"></div>
                <button id="wps_pay_btn" class="btn btn-yellow">Pay</button>
            </div>
            <!---card end-->

        <?php
        ?>
    </div>
</div>