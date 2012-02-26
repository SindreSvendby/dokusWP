<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */

class DokusMainController
{
    public function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['subdomain'])) {
                $this->setAccountSettings();
            }
        }
    }

    public function setAccountSettings()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $subdomain = $_POST["subdomain"];
        DokusWP::setDokusAccountSettings($email, $password, $subdomain);

    }
}
