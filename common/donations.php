<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Slide Settings
*/
trait Wpsd_Donations
{
	protected $wpsdTable = WPSD_TABLE;

    protected function wpsd_get_all_donations() {

		global $wpdb;
		return $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->wpsdTable WHERE %d ORDER BY wpsd_id DESC LIMIT 0, 10", 1));
        
	}

	protected function wpsd_get_all_donations_full() {

		global $wpdb;
		return $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->wpsdTable WHERE %d ORDER BY wpsd_id DESC", 1));
        
	}

	protected function wpsd_delete_donation( $id ) {

		global $wpdb;
		
		$success = $wpdb->query( $wpdb->prepare("DELETE FROM $this->wpsdTable WHERE wpsd_id = %d", $id) );

		if ( $success ) {
        	return __("Donation has been deleted.", WPSD_TXT_DOMAIN);
	
		}
	}

	protected function wpsd_delete_bulk_donation( $action ) {

		if ( $action !== '' ) {
			
			$reqArray = isset( $_POST['bulkSelection'] ) ? $_POST['bulkSelection'] : array();

			if ( is_array( $reqArray ) && count( $reqArray ) ) {

				foreach ( $reqArray as $rowId ) {

					$this->wpsd_delete_donation( $rowId );
				
				}
				
				return __("Donations has been deleted.", WPSD_TXT_DOMAIN);
			
			} else {
				
				return __("Please select donations to delete.", WPSD_TXT_DOMAIN);
			
			}

		} else {
			
			return __("Please choose action to apply.", WPSD_TXT_DOMAIN);
		
		}

	}
}