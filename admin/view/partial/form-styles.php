
<?php 
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wpsdSyleSettings );
foreach ( $wpsdSyleSettings as $option_name => $option_value ) {
    if ( isset( $wpsdSyleSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wpsd-form-style-settings" role="form" class="form-horizontal" method="post" action="" id="wpsd-form-style-settings-id">
    <table class="wpsd-form-style-settings">
        <tr>
            <th scope="row" colspan="2">
                <span><?php 
_e( 'Form Container', WPSD_TXT_DOMAIN );
?> :</span>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Border Width', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Border Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Border Radius', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Padding', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Background Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Font Color', WPSD_TXT_DOMAIN );
?> :</label>
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
            <th scope="row" colspan="2">
                <span><?php 
_e( 'Input Fields', WPSD_TXT_DOMAIN );
?> :</span>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Border Width', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Border Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Border Radius', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Padding', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Background Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Font Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Font Size', WPSD_TXT_DOMAIN );
?> :</label>
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
            <th scope="row" colspan="2">
                <span><?php 
_e( 'Button', WPSD_TXT_DOMAIN );
?> :</span>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Background Color', WPSD_TXT_DOMAIN );
?> :</label>
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
_e( 'Font Color', WPSD_TXT_DOMAIN );
?> :</label>
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
    </table>
    <p class="submit"><button id="updateStyle" name="updateStyle" class="button button-primary wpsd-button"><?php 
_e( 'Save Settings', WPSD_TXT_DOMAIN );
?></button>
    </p>
</form>