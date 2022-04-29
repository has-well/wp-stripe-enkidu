<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !function_exists( 'wsd_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wsd_fs()
    {
        global  $wsd_fs ;
        
        if ( !isset( $wsd_fs ) ) {
            // Include Freemius SDK.
            require_once WPSD_PATH . '/freemius/start.php';
            $wsd_fs = fs_dynamic_init( array(
                'id'             => '8794',
                'slug'           => 'wp-stripe-donation',
                'type'           => 'plugin',
                'public_key'     => 'pk_83fa0cae51a10d3554a277cf1756d',
                'is_premium'     => false,
                'premium_suffix' => 'Basic',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'menu'           => array(
                'slug'       => 'wpsd-admin-settings',
                'first-path' => 'admin.php?page=wpsd-get-help',
            ),
                'is_live'        => true,
            ) );
        }
        
        return $wsd_fs;
    }
    
    // Init Freemius.
    wsd_fs();
    // Signal that SDK was initiated.
    do_action( 'wsd_fs_loaded' );
    function wsd_fs_support_forum_url( $wp_support_url )
    {
        return 'https://wordpress.org/support/plugin/wp-stripe-donation/';
    }
    
    wsd_fs()->add_filter( 'support_forum_url', 'wsd_fs_support_forum_url' );
    function wsd_fs_custom_connect_message_on_update(
        $message,
        $user_first_name,
        $plugin_title,
        $user_login,
        $site_link,
        $freemius_link
    )
    {
        return sprintf(
            __( 'Hey %1$s' ) . ',<br>' . __( 'Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'hm-logo-showcase' ),
            $user_first_name,
            '<b>' . $plugin_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }
    
    wsd_fs()->add_filter(
        'connect_message_on_update',
        'wsd_fs_custom_connect_message_on_update',
        10,
        6
    );
    function wsd_fs_uninstall_cleanup()
    {
        global  $wpdb ;
        $table_name = WPSD_TABLE;
        $tbl = $wpdb->prefix . 'options';
        $search_string = 'wpsd_%';
        $sql = $wpdb->prepare( "SELECT option_name FROM {$tbl} WHERE option_name LIKE %s", $search_string );
        $options = $wpdb->get_results( $sql, OBJECT );
        if ( is_array( $options ) && count( $options ) ) {
            foreach ( $options as $option ) {
                delete_option( $option->option_name );
                delete_site_option( $option->option_name );
            }
        }
        // drop a custom database table
        $wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );
    }
    
    wsd_fs()->add_action( 'after_uninstall', 'wsd_fs_uninstall_cleanup' );
}
