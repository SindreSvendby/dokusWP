<?php

class DokusWPFactory
{
    private static function getDokusAccountSettings()
    {
        $options = get_option(WP_OPTION_KEY);
        $settings = $options[WP_OPTION_SETTINGS];
        $dokusAccount = new DokusAccount();
        $dokusAccount->email = $settings[WP_OPTION_SETTINGS_EMAIL];
        $dokusAccount->password = $settings[WP_OPTION_SETTINGS_PASSWORD];
        $dokusAccount->subdomain = $settings[WP_OPTION_SETTINGS_SUBDOMAIN];
        return $dokusAccount;
    }

    public static function getDokusWP()
    {
        $dokusAccount = $this->getDokusAccountSettings();
        $dokusService = new DokusService($dokusAccount->email, $dokusAccount->password, $dokusAccount->subdomain);
        return new DokusWP($dokusService);
    }
}

class DokusWP
{
    private $dokusService;

    public function __construct($dokusService)
    {
        $this->dokusService = $dokusService;
    }

}

/**
 * Contains the DokusAccountInformation
 */
class DokusAccount
{
    public $email;
    public $password;
    public $subdomain;


    /**
     * @return void
     */
    public static function setAccountSettings() {
        $dokusAccount = new  DokusAccount();
        $dokusAccount->subdomain = $_POST["subdomain"];
        $dokusAccount->email = $_POST["email"];
        $dokusAccount->password = $_POST["password"];
        $dokusAccount->save();
    }

    function validDokusAccount() {
        $dokusService = new DokusService($this->email, $this->password, $this->subdomain);
        $request = $dokusService->request('/customers/');
        return ($request->status === 200);
    }

    private function save() {
        $options = get_option(WP_OPTION_KEY);
        $settings = $options[WP_OPTION_SETTINGS];
        $settings[WP_OPTION_SETTINGS_EMAIL] = $this->email;
        $settings[WP_OPTION_SETTINGS_PASSWORD] = $this->password;
        $settings[WP_OPTION_SETTINGS_SUBDOMAIN] = $this->subdomain;
        $options[WP_OPTION_SETTINGS] = $settings;
        update_option(WP_OPTION_KEY, $options);
    }
}