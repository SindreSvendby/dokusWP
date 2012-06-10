<?php

require_once "../classes/DokusWP.php";
class UserMappingTest   extends PHPUnit_Framework_TestCase
{
    public function testUserLists() {
        $dokusWP = DokusWPFactory::getDokusWP();
        get_list_of_users($dokusWP);
    }

}
