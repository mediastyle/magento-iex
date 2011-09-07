<?php

class Mediastyle_IEX_Model_IEX extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('iex/iex');
    }
}