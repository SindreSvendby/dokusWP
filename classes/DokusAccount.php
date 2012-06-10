<?php

/**
 * Contains the DokusAccountInformation
 */
class DokusAccount
{
    public $email;
    public $password;
    public $subdomain;

    public function __construct($email, $subdomain, $password)
    {
        $this->email = $email;
        $this->subdomain = $subdomain;
        $this->password = $password;
    }

    public function validDokusAccount()
    {
        $dokusService = new DokusService($this->email, $this->password, $this->subdomain);
        $dokusCustomersResource = new DokusCustomersResource($dokusService);
        $responds = $dokusCustomersResource->all();
        return (!($responds == null));
    }

    public function save()
    {
        $options = get_option(WP_OPTION_KEY);
        $settings = $options[WP_OPTION_SETTINGS];
        $settings[WP_OPTION_SETTINGS_EMAIL] = $this->email;
        $settings[WP_OPTION_SETTINGS_PASSWORD] = $this->password;
        $settings[WP_OPTION_SETTINGS_SUBDOMAIN] = $this->subdomain;
        $options[WP_OPTION_SETTINGS] = $settings;
        update_option(WP_OPTION_KEY, $options);
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

function getDokusAccountSettings()
{
    $options = get_option(WP_OPTION_KEY);
    $settings = $options[WP_OPTION_SETTINGS];
    $email = $settings[WP_OPTION_SETTINGS_EMAIL];
    $password = $settings[WP_OPTION_SETTINGS_PASSWORD];
    $subdomain = $settings[WP_OPTION_SETTINGS_SUBDOMAIN];
    $dokusAccount = new DokusAccount($email, $subdomain, $password);
    return $dokusAccount;
}

function setAccountSettings()
{
    $dokusAccount = new  DokusAccount($_POST["email"], $_POST["subdomain"], $_POST["password"]);
    $dokusAccount->save();
}

function getDokusService()
{
    $dokusAccount = getDokusAccountSettings();
    return new DokusService($dokusAccount->email, $dokusAccount->password, $dokusAccount->subdomain);
}

