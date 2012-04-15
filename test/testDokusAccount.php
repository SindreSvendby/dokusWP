<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */
require_once('../DokusWP.php');
#require_once('PHPUnit/Framework/F');

class TestDokusAccount extends PHPUnit_Framework_TestCase {


    public function testDokusAccount() {
        $dokusAccount = new DokusAccount();
        $this->assertNotEmpty($dokusAccount);
    }
}