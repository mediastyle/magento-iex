<?php
class Mediastyle_IEX_Block_Adminhtml_IEX extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_iex';
    $this->_blockGroup = 'iex';
    $this->_headerText = Mage::helper('iex')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('iex')->__('Add Item');
    parent::__construct();
  }
}