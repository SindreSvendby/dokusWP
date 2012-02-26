<?php
/**
 * Stand for the interaction with WordPress, controlles the settings.
 */
class DokusWP
{
    private $dokusAdapter;

    const WP_OPTION_KEY = "dokus";
    const WP_OPTION_USERS = "wordpress_users";
    const WP_OPTION_GROUPS = "groups";
    const WP_OPTION_SETTINGS = "settings";
    const WP_OPTION_SETTINGS_EMAIL = "email";
    const WP_OPTION_SETTINGS_PASSWORD = "password";
    const WP_OPTION_SETTINGS_SUBDOMAIN = "subdomain";

    function __construct()
    {
        $settings = $this->getDokusAccountSettings();
        if (empty($settings) || empty($settings[self::WP_OPTION_SETTINGS_EMAIL])) {
            return null;
        }
        $email = $settings[self::WP_OPTION_SETTINGS_EMAIL];
        $password = $settings[self::WP_OPTION_SETTINGS_PASSWORD];
        $subdomain = $settings[self::WP_OPTION_SETTINGS_SUBDOMAIN];
        $this->dokusAdapter = new DokusAdapter($email, $password, $subdomain);
    }

    function setDokusAccountSettings($email, $password, $subdomain)
    {
        $options = get_option(self::WP_OPTION_KEY);
        $settings = $options[self::WP_OPTION_SETTINGS];
        $settings[self::WP_OPTION_SETTINGS_EMAIL] = $email;
        $settings[self::WP_OPTION_SETTINGS_PASSWORD] = $password;
        $settings[self::WP_OPTION_SETTINGS_SUBDOMAIN] = $subdomain;
        $options[self::WP_OPTION_SETTINGS] = $settings;
        update_option(self::WP_OPTION_KEY, $options);
    }

     function getDokusAccountSettings()
    {
        $options = get_option(self::WP_OPTION_KEY);
        $settings = $options[self::WP_OPTION_SETTINGS];
        return $settings;
    }

}

/**
 * A wrapper for wordpress that extends the DokusService provided by funkbit
 * Takes wp_user and people-list input, and translate it to dokus.
 */
class DokusAdapter
{
    function __construct($email, $password, $subdomain)
    {
        //$this->dokus_service = new DokusService("sindre.svendby@eniro.no", "DokusPro", "holstadtest");
        $this->dokusService = new DokusService($email, $password, $subdomain);
        $this->dokus_service->setDebug(false);
    }

    function get($id) {

    }

    function createMapping() {

    }

    function deleteMapping() {

    }

}
