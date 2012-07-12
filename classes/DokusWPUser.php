<?php

class DokusWPUser
{
    private $w_name;
    private $w_id;
    private $d_name;
    private $d_id;
    private $groups;

    public function set_w_name($name) {
        $this->w_name = $name;
    }

    public function set_d_name($name) {
        $this->d_name = $name;
    }

    public function set_w_id($id) {
        $this->w_id = $id;
    }

    public function set_d_id($id) {
        $this->d_id = $id;
    }

    public function get_w_name() {
        return $this->w_name;
    }

    public function get_d_name() {
        return $this->d_name;
    }

    public function get_w_id() {
        return $this->w_id;
    }

    public function get_d_id() {
        return $this->d_id;
    }

    /**
     * @return mixed|Groups
     */
    public function get_groups()
    {
        return $this->groups;
    }

    public function set_groups($groups)
    {
        $this->groups = $groups;
    }


}
