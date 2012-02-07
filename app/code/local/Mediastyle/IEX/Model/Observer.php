<?php
$ExternalLibPath=Mage::getModuleDir('', 'Mediastyle_IEX') . DS . 'iex-api' . DS .'iex_client_api.php';
require_once ($ExternalLibPath);

class Mediastyle_IEX_Model_Observer {

  public function productTransfer($observer){
    $event = $observer->getEvent();
    $product = $event->getProduct()->getData();
    $this->iexQuery('product','transfer',$product);
  }

  public function productDelete($observer){
    $action = 'delete';
    $event = $observer->getEvent();
    $product = $event->getProduct()->getData();

    $this->iexQuery('product','delete',$product);
  }

  public function customerTransfer($observer){
    $action = 'transfer';
    $event = $observer->getEvent();
    $customer = $event->getCustomer()->getData();

    $this->iexQuery('customer','transfer',$customer);
  }

  public function customerDelete($observer){
    $action = 'delete';
    $event = $observer->getEvent();
    $customer = $event->getCustomer()->getData();
    $this->iexQuery('customer','delete',$customer);
  }

  public function orderTransfer($observer){
    $action = 'transfer';
    $event = $observer->getEvent();
    $order = $event->getOrder();
    $row = array();

    $row['id'] = $order->getEntityId() ;

    $customer =
    $this->getCustomer(Mage::getModel('customer/customer')->load($order->getCustomerId()));

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
    
    $this->iexQuery('customer','transfer',$row);

    $items = $order->getAllItems();
    $orderlines = array();
    foreach($items as $item){
      $tmp = array();
      $tmp['order_id'] = $item->getOrderId();
      $tmp['product_id'] = $item->getSku();
      $tmp['title'] = $item->getName();
      $tmp['quantity'] = $item->getQtyToInvoice();
      $tmp['price'] = floatval($item->getPrice());
      $tmp['attributes'] = '';
//      $orderlines[] = $tmp;
      $this->iexQuery('customer','transfer',$tmp);
    }
/*    mail('ronni.lindsgaard@gmail.com','Order
    data',print_r(array_shift($items)->getData(),true));*/

    
  }

  public function orderDelete($observer){
    $action = 'delete';
    $event = $observer->getEvent();
    $order = $event->getOrder()->getData();
    $this->iexQuery('order','delete',$order);
  }

  public function iexQuery($entity,$action,$data){
    $customer = Mage::getStoreConfig('iex_options/settings/customer_id');
    $link = Mage::getStoreConfig('iex_options/settings/api_link');
    $secret = Mage::getStoreConfig('iex_options/settings/api_secret');
    $api = new IexClientApi($customer,$link,$secret);
    $result = $api->query($entity,$action,$data);
/*    mail('ronni.lindsgaard@gmail.com','An event ' .$action . ' was
    triggered for ' . $entity . " with
    data:",print_r($data,true) ."\n and the message\n " .
    print_r($result,true) 
    );*/
  }

}
