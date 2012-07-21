<?php

class DokusCustomerGroupCache
{
    private $offline = false;
    private $group;

    public function getGroup($id)
    {
        if (empty($this->group)):
            $this->getDokusCustomerGroups();
        endif;

        //return all if no $id is spec.
        if (empty($id)):
            return $this->group;
        endif;

        return $this->group[$id];
    }

    private function getDokusCustomerGroups()
    {
        if($this->offline == true):
            $this->group = file("../resources/customer_group.json");
        else:
            $dokus = getDokusService();
            foreach ($dokus->customerGroups->all() as $group):
                $this->group[$group->id] = $group;
            endforeach;
        endif;
    }
}