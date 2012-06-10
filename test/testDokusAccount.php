<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */
require_once('../classes/DokusWP.php');
#require_once('PHPUnit/Framework/F');

class TestDokusAccount extends PHPUnit_Framework_TestCase {

    public $dokusAccount;

    public function setUp() {
        $email = "sindre.svendby@eniro.no";
        $subdomain = "holstadtest";
        $password = "baya829";
        $this->dokusAccount = new DokusAccount($email, $subdomain, $password);
        $this->assertEquals($email,$this->dokusAccount->email);
        $this->assertEquals($subdomain, $this->dokusAccount->subdomain);
        $this->assertEquals($password, $this->dokusAccount->password);
    }

    public function testValidDokusAccount() {
       $this->assertTrue($this->dokusAccount->validDokusAccount());
   }

}