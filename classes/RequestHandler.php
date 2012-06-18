<?php

class RequestHandler
{
    private static $validPages = null;

    private function getValidPages()
    {
        if (null !== static::$validPages):
            return static::$validPages;
        endif;
        $request_dir = dirname(__FILE__) . "/../pages";
        static::$validPages = scandir($request_dir);
        return self::$validPages;
    }

    public static function validateRequest($requestPage)
    {
        return in_array($requestPage, RequestHandler::getValidPages());
    }
}