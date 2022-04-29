<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wpsd-wrap-all" class="wrap wpsd-template-settings">

    <div class="settings-banner">
        <h2><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp;<?php _e('Form Settings', WPSD_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
        if ( $wpsdNotice ) {
            $this->wpsd_display_notification('success', 'Your information updated successfully.'); 
        } 
    ?>

    <div class="wpsd-wrap">

        <nav class="nav-tab-wrapper">
            <a href="?page=wpsd-template-settings&tab=settings" class="nav-tab <?php if ( $tab != 'styles' ) { ?>nav-tab-active<?php } ?>"><?php _e('Content', WPSD_TXT_DOMAIN); ?></a>
            <a href="?page=wpsd-template-settings&tab=styles" class="nav-tab <?php if ( $tab === 'styles' ) { ?>nav-tab-active<?php } ?>"><?php _e('Styles', WPSD_TXT_DOMAIN); ?></a>
        </nav>

        <div class="wpsd_personal_wrap wpsd_personal_help" style="width: 75%; float: left;">

            <div class="tab-content">
                <?php 
                switch ( $tab ) {
                    case 'styles':
                        include WPSD_PATH . 'admin/view/partial/form-styles.php';
                        break;
                    default:
                        include WPSD_PATH . 'admin/view/partial/form-content.php';
                        break;
                } 
                ?>
            </div>

        </div>

        <?php $this->wpsd_admin_sidebar(); ?>

    </div>

</div>