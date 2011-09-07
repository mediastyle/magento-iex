<?php

class Mediastyle_IEX_Block_Adminhtml_IEX_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('iex_form', array('legend'=>Mage::helper('iex')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('iex')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('iex')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('iex')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('iex')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('iex')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('iex')->__('Content'),
          'title'     => Mage::helper('iex')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getIEXData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getIEXData());
          Mage::getSingleton('adminhtml/session')->setIEXData(null);
      } elseif ( Mage::registry('iex_data') ) {
          $form->setValues(Mage::registry('iex_data')->getData());
      }
      return parent::_prepareForm();
  }
}