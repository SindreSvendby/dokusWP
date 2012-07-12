<?php

class DokusCustomerGroupCache
{
    private static $offline = false;
    private static $group;

    public static function getGroup($id)
    {
        if (empty(self::$group)):
            self::getDokusCustomerGroups();
        endif;

        if (empty($id)):
            return self::$group;
        endif;
        return self::$group[$id];
    }

    private static function getDokusCustomerGroups()
    {
        if(self::$offline == true):
            self::$group = file("../resources/customer_group.json");
        else:

            $dokusCustomersGroupResource = new DokusCustomerGroupsResource(getDokusService());
            foreach ($dokusCustomersGroupResource->all() as $group):
                self::$group[$group->id] = $group;
            endforeach;
        endif;
    }
}