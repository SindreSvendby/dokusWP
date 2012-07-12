<?php

class DokusCustomersCache
{
    private static $offline = false;
    private static $customers;

    public static function getCustomer($id)
    {
        if (empty(self::$customers)):
            self::getDokusCustomers();
        endif;

        if (empty($id)):
            return self::$customers;
        endif;
        return self::$customers[$id];
    }

    private static function getDokusCustomers()
    {
        if (self::$offline == true):
            self::$customers = file("../resources/customer.json");
        else:

            $dokusCustomersResource = new DokusCustomersResource(getDokusService());
            $dokus_users  = $dokusCustomersResource->all();
            foreach ($dokus_users  as $dokus_user):
                self::$customers[$dokus_user->id] = $dokus_user;
            endforeach;
        endif;
    }
}