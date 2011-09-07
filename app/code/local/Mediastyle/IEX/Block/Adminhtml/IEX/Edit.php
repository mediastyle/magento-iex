<?php

class Mediastyle_IEX_Block_Adminhtml_IEX_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'iex';
        $this->_controller = 'adminhtml_iex';
        
        $this->_updateButton('save', 'label', Mage::helper('iex')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('iex')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('iex_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'iex_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'iex_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('iex_data') && Mage::registry('iex_data')->getId() ) {
            return Mage::helper('iex')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('iex_data')->getTitle()));
        } else {
            return Mage::helper('iex')->__('Add Item');
        }
    }
}