<?php

class Mediastyle_IEX_Block_Adminhtml_IEX_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('iex_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('iex')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('iex')->__('Item Information'),
          'title'     => Mage::helper('iex')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('iex/adminhtml_iex_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}