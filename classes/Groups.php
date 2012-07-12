<?php

/**
 * Contains information between groups and
 */
class Groups
{

    private $only_dokus = array();
    private $only_wordpress = array();
    private $both = array();

    function __construct($dokus_groups_ids, $wordpress_groups_ids)
    {
        foreach ($dokus_groups_ids as $dg_id):
            if (in_array($dg_id, $wordpress_groups_ids)):
                $this->both[] = $dg_id;
            else:
                $this->only_dokus[] = $dg_id;
            endif;
        endforeach;

        foreach ($wordpress_groups_ids as $wg_id):
            if (!in_array($wg_id, $dokus_groups_ids)):
                $this->only_wordpress[] = $wg_id;
            endif;
        endforeach;
    }

    public function get_both()
    {
        return $this->both;
    }

    public function get_only_dokus()
    {
        return $this->only_dokus;
    }

    public function get_only_wordpress()
    {
        return $this->only_wordpress;
    }


}
