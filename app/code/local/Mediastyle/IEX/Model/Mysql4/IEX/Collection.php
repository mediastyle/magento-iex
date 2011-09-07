<?php

class Mediastyle_IEX_Model_Mysql4_IEX_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('iex/iex');
    }
}