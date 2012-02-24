<?php
//Load the iex client api
$ExternalLibPath=Mage::getModuleDir('', 'Mediastyle_IEX') . DS . 'iex-api' . DS .'iex_client_api.php';
require_once ($ExternalLibPath);

class Mediastyle_IEX_Model_Observer {

  public function iexClient(){
    $customer = Mage::getStoreConfig('iex_options/settings/customer_id');
    $link = Mage::getStoreConfig('iex_options/settings/api_link');
    $secret = Mage::getStoreConfig('iex_options/settings/api_secret');
    
    return new IexClientApi($customer,$link,$secret);
  }

  public function productTransfer($observer){
    $api = $this->iexClient();
    $event = $observer->getEvent();
    $product = $event->getProduct()->getData();
    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->addTransfer('product',IEX_TRANSFER,$product);
      $api->doTransfer();
    }
  }

  public function productDelete($observer){
    $api = $this->iexClient();
    $event = $observer->getEvent();
    $product = $event->getProduct()->getData();

    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->addTransfer('product',IEX_DELETE,$product);
      $api->doTransfer();
    }
  }

  public function customerTransfer($observer){
    $api = $this->iexClient();
    $event = $observer->getEvent();
    $customer = $event->getCustomer()->getData();

    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->addTransfer('customer',IEX_TRANSFER,$customer);
      $api->doTransfer();
    }
  }

  public function customerDelete($observer){
    $api = $this->iexClient();
    $event = $observer->getEvent();
    $customer = $event->getCustomer()->getData();

    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->addTransfer('customer',IEX_DELETE,$customer);
      $api->doTransfer();
    }
  }

  public function orderTransfer($observer){

    $api = $this->iexClient();

    $event = $observer->getEvent();
    $order = $event->getOrder();
    
    if(Mage::registry('has_transfered_order_' . $order->getEntityId()))
      return;
    $row = array();

    $row['id'] = $order->getEntityId() ;

    $customer
    =Mage::getModel('customer/customer')->load($order->getCustomerId());

    $row['customer_id'] = $order->getCustomerId();
    $row['customer_name'] = $customer->getName();
    $row['number'] = '';
    $row['gross_amount'] = $order->getGrandTotal();
    $row['net_amount'] = $order->getSubtotal();
    $row['vat_amount'] = $order->getTaxAmount();
    $row['shipping'] = $order->getShippingAmount();
    $row['shipping_tax'] = $order->getShippingTaxAmount();
    $row['coupon_code'] = $order->getCouponCode();
    $row['discount'] = $order->getDiscountAmount();
    $row['currency'] = $order->getOrderCurrencyCode();
    $row['shipping_method'] = $order->getShippingMethod();
    $row['create_date'] = $order->getCreatedAt();
    $api->addTransfer('order',IEX_TRANSFER,$row);

    $items = $order->getAllItems();
    $i = 0;
    foreach($items as $k=>$item){
      $i++;
      $orderline = array();
      $orderline['id'] = $i;
      $orderline['order_id'] = $item->getOrderId();
      $orderline['product_id'] = $item->getSku();
      $orderline['title'] = $item->getName();
      $orderline['quantity'] = $item->getQtyOrdered();
      $orderline['price'] = floatval($item->getPrice());
      $orderline['attributes'] = '';
      $api->addTransfer('orderline',IEX_TRANSFER,$orderline);
    }

    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->doTransfer();
    }
    Mage::register('has_transfered_order_' . $order->getEntityId(),true);
  }

  public function orderDelete($observer){
    $api = $this->iexClient();
    $event = $observer->getEvent();
    $order = $event->getOrder()->getData();
    
    if(Mage::getStoreConfig('iex_options/settings/synchronise')){
      $api->addTransfer('order',IEX_DELETE,$order);
      $api->doTransfer();
    }
  }
}
