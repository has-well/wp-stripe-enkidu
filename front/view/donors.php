<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="wp-list-table widefat fixed striped table-view-list posts" cellspacing="0" id="wpc_data_table">
    <thead>
        <tr>
            <td>#</td>
            <td><?php _e('Amount', WPSD_TXT_DOMAIN); ?></td>
            <td><?php _e('Donation For', WPSD_TXT_DOMAIN); ?></td>
            <td><?php _e('Donor', WPSD_TXT_DOMAIN); ?></td>
            <td><?php _e('Date', WPSD_TXT_DOMAIN); ?></td>
            <td><?php _e('Comments', WPSD_TXT_DOMAIN); ?></td>
        </tr>
    </thead>
    <tbody id="the-list">
        <?php
        if ( count( $wpsdDonations ) > 0 ) {
            $i=1;
            foreach ( $wpsdDonations as $donation ) {
                ?>
                <tr>
                    <td><?php printf( '%d', $i++ ) ?></td>
                    <td><?php printf('%s (%s)', $donation->wpsd_donated_amount, $donation->wpsd_donator_phone ); ?></td>
                    <td><?php esc_html_e( $donation->wpsd_donation_for ); ?></td>
                    <td><?php esc_html_e( $donation->wpsd_donator_name ); ?></td>
                    <td><?php echo date('M d, h:i A', strtotime( $donation->wpsd_donation_datetime )); ?></td>
                    <td><?php esc_html_e( $donation->wpsd_comments ); ?></td>
                </tr>
                <?php 
            }
        }
        ?>
    </tbody>
</table>