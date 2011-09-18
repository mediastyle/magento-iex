<?php
class Mediastyle_IEX_IndexController extends Mage_Core_Controller_Front_Action
{
  public function indexAction() {
    	
    $helper = Mage::helper('iex');
    $request = $this->getRequest();
    $type = $request->getParam('type');
    $action = $request->getParam('action');
    $key = $request->getParam('key');

    if($key == Mage::getStoreConfig('iex_options/settings/api_key')){
      if($action) {
        $helper->importProduct($_POST);
      } else {
        switch($type){
          case 'orders':
            $data = $helper->exportOrders();
          break;
          case 'products':
            $data = $helper->exportProducts();
          break;
          case 'customers':
            $data = $helper->exportCustomers();
          break;
          default:
            die('The action chosen is not defined');
        }
        if(!empty($data)){
          $fh = fopen('php://output','w');
          foreach($data as $line){
            fputcsv($fh,$line,';','"');
          }
        } else {
          die('An error occured, no data was found');
        }
      }
    } else {
      die('Access denied');
    }
  }
}
