<?php

namespace LinkedFarm\Core\Settings;

    function init()
    {
        add_action('admin_menu', 'LinkedFarm\Core\Settings\lf_main_menu');
    }

    function lf_main_menu() {
        // add top level menu page
        add_menu_page(
            'Linked Farm General Settings',
            'LF Settings',
            'manage_options',
            'lf_core_page',
            'LinkedFarm\Core\Settings\lf_core_page_html'
        );
    }

    function lf_core_page_html() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'lf_core_messages', 'lf_core_message', __( 'Settings Saved', 'linkedfarm' ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'lf_core_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "ofd_general"
                settings_fields( 'lf_core' );
                // output setting sections and their fields
                // (sections are registered for "ofd_general", each field is registered to a specific section)
                do_settings_sections( 'lf_core' );
                // output save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
}