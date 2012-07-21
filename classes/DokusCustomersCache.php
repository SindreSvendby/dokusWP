<?php

class DokusCustomersCache
{
    private $offline = false;
    private $customers;

    public function getCustomer($id)
    {
        if (empty($this->customers)):
            $this->getDokusCustomers();
        endif;

        if (empty($id)):
            return $this->customers;
        endif;
        return $this->customers[$id];
    }

    private function getDokusCustomers()
    {
        if ($this->offline == true):
            $this->customers = file("../resources/customer.json");
        else:

            $dokusCustomersResource = new DokusCustomersResource(getDokusService());
            $dokus_users  = $dokusCustomersResource->all();
            foreach ($dokus_users  as $dokus_user):
                $this->customers[$dokus_user->id] = $dokus_user;
            endforeach;
        endif;
    }
}