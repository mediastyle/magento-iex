<?php
class Mediastyle_IEX_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/iex?id=15 
    	 *  or
    	 * http://site.com/iex/id/15 	
    	 */
    	/* 
		$iex_id = $this->getRequest()->getParam('id');

  		if($iex_id != null && $iex_id != '')	{
			$iex = Mage::getModel('iex/iex')->load($iex_id)->getData();
		} else {
			$iex = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($iex == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$iexTable = $resource->getTableName('iex');
			
			$select = $read->select()
			   ->from($iexTable,array('iex_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$iex = $read->fetchRow($select);
		}
		Mage::register('iex', $iex);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}