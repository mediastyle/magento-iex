<?php

class Mediastyle_IEX_Model_Mysql4_IEX extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the iex_id refers to the key field in your database table.
        $this->_init('iex/iex', 'iex_id');
    }
}