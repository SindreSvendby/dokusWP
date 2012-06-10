<?php

class RequestHandler
{
    private static $validPages = null;

    private function getValidPages()
    {
        if (null !== static::$validPages):
            return static::$validPages;
        endif;
        static::$validPages = array('settings', 'default', 'dokusUsers', 'groups', 'options',
            'peopleList', SEE_WORDPRESS_USERS, SEE_OPTIONS, SEE_OPTIONS_VALUES);
        return self::$validPages;
    }

    public static function validateRequest($requestPage)
    {
        return in_array($requestPage, RequestHandler::getValidPages());
    }
}