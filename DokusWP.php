<?php

require('DokusService.php');

class DokusWPFactory
{
    public  static function getDokusAccountSettings()
    {
        $options = get_option(WP_OPTION_KEY);
        $settings = $options[WP_OPTION_SETTINGS];
        $email = $settings[WP_OPTION_SETTINGS_EMAIL];
        $password = $settings[WP_OPTION_SETTINGS_PASSWORD];
        $subdomain = $settings[WP_OPTION_SETTINGS_SUBDOMAIN];
        $dokusAccount = new DokusAccount($email, $subdomain, $password);
        return $dokusAccount;
    }

    public static function getDokusWP()
    {
        $dokusAccount = DokusWPFactory::getDokusAccountSettings();
        $dokusService = new DokusService($dokusAccount->email, $dokusAccount->password, $dokusAccount->subdomain);
        return new DokusWP($dokusService);
    }

    public static function setAccountSettings() {
        $dokusAccount = new  DokusAccount($_POST["email"],$_POST["subdomain"],$_POST["password"]);
        $dokusAccount->save();
    }

    public static function getDokusService() {
        $dokusAccount = DokusWPFactory::getDokusAccountSettings();
        return new DokusService($dokusAccount->email, $dokusAccount->password, $dokusAccount->subdomain);
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
    public  $email;
    public $password;
    public $subdomain;

    public function __construct($email, $subdomain, $password) {
        $this->email = $email;
        $this->subdomain = $subdomain;
        $this->password = $password;
    }

    function validDokusAccount() {
        $dokusService = new DokusService($this->email, $this->password, $this->subdomain);
        $request = $dokusService->request('/customers/');
        return ($request->status === 200);
    }

    public function save() {
        $options = get_option(WP_OPTION_KEY);
        $settings = $options[WP_OPTION_SETTINGS];
        $settings[WP_OPTION_SETTINGS_EMAIL] = $this->email;
        $settings[WP_OPTION_SETTINGS_PASSWORD] = $this->password;
        $settings[WP_OPTION_SETTINGS_SUBDOMAIN] = $this->subdomain;
        $options[WP_OPTION_SETTINGS] = $settings;
        update_option(WP_OPTION_KEY, $options);
    }

    public function __get($property) {
      if (property_exists($this, $property)) {
        return $this->$property;
      }
    }

    public function __set($property, $value) {
      if (property_exists($this, $property)) {
        $this->$property = $value;
      }
    }
}