<?php
class Mediastyle_IEX_Block_IEX extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getIEX()     
     { 
        if (!$this->hasData('iex')) {
            $this->setData('iex', Mage::registry('iex'));
        }
        return $this->getData('iex');
        
    }
}