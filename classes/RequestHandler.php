<?php

class RequestHandler
{
    private $validPages = null;

    private function getValidPages()
    {
        if (null !=  $this->validPages):
            return $this->$validPages;
        endif;
        $request_dir = dirname(__FILE__) . "/../pages";
        $this->validPages = scandir($request_dir);
        return $this->validPages;
    }

    public function validateRequest($requestPage)
    {
        return in_array($requestPage, $this->getValidPages());
    }
}