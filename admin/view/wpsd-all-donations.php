<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wpsd-wrap-all" class="wrap">
    
    <div class="settings-banner">
        <h2><i class="fa fa-list" aria-hidden="true"></i>&nbsp;<?php _e('Donations Information', WPSD_TXT_DOMAIN); ?></h2>
    </div>

    <table class="wp-list-table widefat fixed striped posts" cellspacing="0" id="wpc_data_table">
        <thead>
            <tr>
                <?php print_column_headers('wpsd-column-table'); ?>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php
            if ( count( $wpsdDonations ) > 0 ) {
                foreach ( $wpsdDonations as $donation ) {
                    ?>
                    <tr>
                        <td class="wpsd-donated-amount" style="min-width: 200px;"><?php printf('%s (%s)', $donation->wpsd_donated_amount, $donation->wpsd_donator_phone ); ?></td>
                        <td><?php printf('%s', $donation->wpsd_donation_for); ?></td>
                        <td><?php printf('%s', $donation->wpsd_donator_name); ?></td>
                        <td><?php printf('%s', $donation->wpsd_donator_email); ?></td>
                        <td><?php printf('%s', date('M d, h:i A', strtotime($donation->wpsd_donation_datetime))); ?>
                        </td>
                    </tr>
                    <?php 
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <?php print_column_headers('wpsd-column-table', false); ?>
            </tr>
        </tfoot>
    </table>
</div>