<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */
require_once('../dokus2.php');
require_once 'PHPUnit.php';

class dokus2Test extends PHPUnit_Framework_TestCase {
    public function test_decideController() {
        $controller = decideController();
    }
}